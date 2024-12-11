<?php

require_once './app/utils/Bdd.php';
require_once './app/orms/Activite.php';

class ActiviteModel extends Bdd {
    public function __construct() {
        parent::__construct();
    }

    public function getAllActivities(): array 
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM activities');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Activite');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getActivityById(int $id): array 
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM activities WHERE id = :id LIMIT 1');
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getPlacesLeft(int $activityId): int 
    {
        try {
            $stmt = $this->db->prepare('SELECT places_disponibles FROM activities WHERE id = :id');
            $stmt->execute(['id' => $activityId]);
            $activite = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $activite ? (int)$activite['places_disponibles'] : 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function updateActivity(int $id, array $data): bool 
    {
        try {
            $stmt = $this->db->prepare('
                UPDATE activities 
                SET nom = :nom, 
                    type_id = :type_id, 
                    places_disponibles = :places_disponibles, 
                    description = :description, 
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
                'datetime_debut' => $data['datetime_debut'],
                'duree' => $data['duree']
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteActivity(int $id): bool 
    {
        try {
            // Commencer une transaction
            $this->db->beginTransaction();
            
            // Supprimer d'abord les réservations associées
            $stmt = $this->db->prepare('DELETE FROM reservations WHERE activite_id = :id');
            $stmt->execute(['id' => $id]);
            
            // Puis supprimer l'activité
            $stmt = $this->db->prepare('DELETE FROM activities WHERE id = :id');
            $result = $stmt->execute(['id' => $id]);
            
            // Valider la transaction
            $this->db->commit();
            return $result;
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function createActivity(array $data): bool 
    {
        try {
            $stmt = $this->db->prepare(
                'INSERT INTO activities (nom, type_id, places_disponibles, description, datetime_debut, duree) 
                 VALUES (:nom, :type_id, :places_disponibles, :description, :datetime_debut, :duree)'
            );
            
            return $stmt->execute([
                'nom' => $data['nom'],
                'type_id' => $data['type_id'],
                'places_disponibles' => $data['places_disponibles'],
                'description' => $data['description'],
                'datetime_debut' => $data['datetime_debut'],
                'duree' => $data['duree']
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}