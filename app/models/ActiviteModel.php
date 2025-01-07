<?php

// Inclusion des fichiers nécessaires
require_once './app/utils/Bdd.php';
require_once './app/orms/Activite.php';

class ActiviteModel extends Bdd
{
    // Constructeur : appel du constructeur parent
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Récupère toutes les activités
     * @return array Liste des activités ou tableau vide en cas d'erreur
     */
    public function getAllActivities(): array
    {
        try {
            $stmt = $this->db->prepare('SELECT a.*, t.nom as type_nom FROM activities a
                                        LEFT JOIN type_activite t ON a.type_id = t.id');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Activite');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Récupère une activité par son ID
     * @param int $id
     * @return array Détails de l'activité ou tableau vide si non trouvée
     */
    public function getActivityById(int $id): array
    {
        try {
            $stmt = $this->db->prepare('SELECT a.*, t.nom as type_nom FROM activities a
                                        LEFT JOIN type_activite t ON a.type_id = t.id
                                        WHERE a.id = :id LIMIT 1');
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Vérifie le nombre de places disponibles pour une activité
     * @param int $activityId
     * @return int Nombre de places restantes
     */
    public function getPlacesLeft(int $activityId): int
    {
        try {
            $stmt = $this->db->prepare('SELECT places_disponibles FROM activities WHERE id = :id');
            $stmt->execute(['id' => $activityId]);
            $activite = $stmt->fetch(PDO::FETCH_ASSOC);
            return $activite ? (int) $activite['places_disponibles'] : 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    /**
     * Met à jour les informations d'une activité
     * @param int $id
     * @param array $data Données mises à jour
     * @return bool Succès ou échec de la mise à jour
     */
    public function updateActivity(int $id, array $data): bool
    {
        try {
            $stmt = $this->db->prepare('
                UPDATE activities 
                SET nom = :nom, 
                    type_id = :type_id, 
                    places_disponibles = :places_disponibles, 
                    description = :description,
                    image_url = :image_url, 
                    datetime_debut = :datetime_debut, 
                    duree = :duree 
                WHERE id = :id
            ');
            return $stmt->execute([
                'id' => $id,
                'nom' => $data['nom'],
                'type_id' => $data['type_id'],
                'places_disponibles' => $data['places_disponibles'],
                'description' => $data['description'],
                'image_url' => $data['image_url'],
                'datetime_debut' => $data['datetime_debut'],
                'duree' => $data['duree'],
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Supprime une activité ainsi que ses réservations associées
     * @param int $id
     * @return bool Succès ou échec de la suppression
     */
    public function deleteActivity(int $id): bool
    {
        try {
            $this->db->beginTransaction();

            // Suppression des réservations associées
            $stmt = $this->db->prepare('DELETE FROM reservations WHERE activite_id = :id');
            $stmt->execute(['id' => $id]);

            // Suppression de l'activité
            $stmt = $this->db->prepare('DELETE FROM activities WHERE id = :id');
            $result = $stmt->execute(['id' => $id]);

            $this->db->commit();
            return $result;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Crée une nouvelle activité
     * @param array $data Données de l'activité
     * @return bool Succès ou échec de la création
     */
    public function createActivity(array $data): bool
    {
        try {
            $stmt = $this->db->prepare(
                'INSERT INTO activities (nom, type_id, places_disponibles, description, image_url, datetime_debut, duree) 
                 VALUES (:nom, :type_id, :places_disponibles, :description, :image_url, :datetime_debut, :duree)'
            );
            return $stmt->execute([
                'nom' => $data['nom'],
                'type_id' => $data['type_id'],
                'places_disponibles' => $data['places_disponibles'],
                'description' => $data['description'],
                'image_url' => $data['image_url'],
                'datetime_debut' => $data['datetime_debut'],
                'duree' => $data['duree'],
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
