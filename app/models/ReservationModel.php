<?php

// Inclusion des fichiers nécessaires
require_once './app/utils/Bdd.php';
require_once './app/orms/Reservation.php';

class ReservationModel extends Bdd
{
    // Constructeur : appel du constructeur parent
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Crée une réservation pour un utilisateur et une activité
     * @param int $userId ID de l'utilisateur
     * @param int $activityId ID de l'activité
     * @return bool Succès ou échec de la création
     */
    public function createReservation(int $userId, int $activityId): bool
    {
        try {
            // Vérifie la disponibilité des places
            $stmt = $this->db->prepare('SELECT places_disponibles FROM activities WHERE id = :activity_id');
            $stmt->execute(['activity_id' => $activityId]);
            $activity = $stmt->fetch();

            if (!$activity || $activity['places_disponibles'] <= 0) {
                return false;
            }

            // Début de la transaction
            $this->db->beginTransaction();

            // Insère la réservation
            $stmt = $this->db->prepare(
                'INSERT INTO reservations (user_id, activite_id, date_reservation, etat) 
                 VALUES (:user_id, :activite_id, NOW(), 1)',
            );

            $success = $stmt->execute([
                'user_id' => $userId,
                'activite_id' => $activityId,
            ]);

            if ($success) {
                // Met à jour les places disponibles
                $stmt = $this->db->prepare(
                    'UPDATE activities 
                     SET places_disponibles = places_disponibles - 1 
                     WHERE id = :activity_id',
                );
                $stmt->execute(['activity_id' => $activityId]);
            }

            $this->db->commit();
            return $success;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Récupère les réservations pour un utilisateur donné
     * @param int $userId ID de l'utilisateur
     * @return array Liste des réservations ou tableau vide en cas d'erreur
     */
    public function getReservationsByUserId(int $userId): array
    {
        try {
            $stmt = $this->db->prepare(
                'SELECT r.*, a.nom as activite_nom, a.description, a.datetime_debut, a.duree 
                 FROM reservations r 
                 JOIN activities a ON r.activite_id = a.id 
                 WHERE r.user_id = :user_id 
                 AND r.etat = 1',
            );

            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Reservation');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Annule une réservation
     * @param int $reservationId ID de la réservation
     * @return bool Succès ou échec de l'annulation
     */
    public function cancelReservation(int $reservationId): bool
    {
        try {
            // Début de la transaction
            $this->db->beginTransaction();

            // Vérifie l'existence de la réservation
            $stmt = $this->db->prepare('SELECT activite_id FROM reservations WHERE id = :id AND etat = 1');
            $stmt->execute(['id' => $reservationId]);
            $reservation = $stmt->fetch();

            if (!$reservation) {
                $this->db->rollBack();
                return false;
            }

            // Met à jour l'état de la réservation
            $stmt = $this->db->prepare('UPDATE reservations SET etat = 0 WHERE id = :id AND etat = 1');
            $success = $stmt->execute(['id' => $reservationId]);

            if ($success) {
                // Réajoute une place disponible pour l'activité
                $stmt = $this->db->prepare(
                    'UPDATE activities 
                     SET places_disponibles = places_disponibles + 1 
                     WHERE id = :activity_id'
                );
                $stmt->execute(['activity_id' => $reservation['activite_id']]);
            }

            $this->db->commit();
            return $success;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Récupère une réservation par son ID
     * @param int $id ID de la réservation
     * @return Reservation|null La réservation ou null si non trouvée
     */
    public function getReservationById(int $id): ?Reservation
    {
        try {
            $stmt = $this->db->prepare(
                'SELECT r.*, a.nom as activite_nom, a.description, a.datetime_debut, a.duree 
                 FROM reservations r 
                 JOIN activities a ON r.activite_id = a.id 
                 WHERE r.id = :id',
            );

            $stmt->execute(['id' => $id]);
            return $stmt->fetchObject('Reservation') ?: null;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * Récupère toutes les réservations
     * @return array Liste des réservations ou tableau vide en cas d'erreur
     */
    public function getAllReservations(): array
    {
        try {
            $stmt = $this->db->prepare(
                'SELECT r.*, a.nom as activite_nom, a.description, a.datetime_debut, a.duree,
                        u.nom as user_nom, u.prenom as user_prenom
                 FROM reservations r 
                 JOIN activities a ON r.activite_id = a.id 
                 JOIN users u ON r.user_id = u.id
                 ORDER BY r.date_reservation DESC',
            );

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Reservation');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}
