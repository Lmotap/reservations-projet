<?php

require_once './app/utils/Bdd.php';
require_once './app/orms/Reservation.php';

class ReservationModel extends Bdd {
    public function __construct() {
        parent::__construct();
    }

    public function createReservation(int $userId, int $activityId): bool 
    {
        try {
            $stmt = $this->db->prepare('SELECT places_disponibles FROM activities WHERE id = :activity_id');
            $stmt->execute(['activity_id' => $activityId]);
            $activity = $stmt->fetch();

            if (!$activity || $activity['places_disponibles'] <= 0) {
                return false;
            }

            $this->db->beginTransaction();

            $stmt = $this->db->prepare(
                'INSERT INTO reservations (user_id, activite_id, date_reservation, etat) 
                 VALUES (:user_id, :activite_id, NOW(), 1)'
            );
            
            $success = $stmt->execute([
                'user_id' => $userId,
                'activite_id' => $activityId
            ]);

            if ($success) {
                $stmt = $this->db->prepare(
                    'UPDATE activities 
                     SET places_disponibles = places_disponibles - 1 
                     WHERE id = :activity_id'
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

    public function getReservationsByUserId(int $userId): array 
    {
        try {
            $stmt = $this->db->prepare(
                'SELECT r.*, a.nom as activite_nom, a.description, a.datetime_debut, a.duree 
                 FROM reservations r 
                 JOIN activities a ON r.activite_id = a.id 
                 WHERE r.user_id = :user_id'
            );
            
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Reservation');
            
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function cancelReservation(int $reservationId): bool 
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare(
                'SELECT activite_id FROM reservations WHERE id = :id AND etat = 1'
            );
            $stmt->execute(['id' => $reservationId]);
            $reservation = $stmt->fetch();

            if (!$reservation) {
                return false;
            }

            $stmt = $this->db->prepare(
                'UPDATE reservations SET etat = 0 WHERE id = :id AND etat = 1'
            );
            
            $success = $stmt->execute(['id' => $reservationId]);

            if ($success) {
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
}