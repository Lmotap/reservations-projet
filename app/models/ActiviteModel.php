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
}