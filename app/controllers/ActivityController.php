<?php

require_once './app/models/ActiviteModel.php';

class ActivityController {
    private ActiviteModel $activiteModel;

    public function __construct() {
        $this->activiteModel = new ActiviteModel();
    }

    public function index() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $activities = $this->activiteModel->getAllActivities();
        $isAdmin = $_SESSION['user']['role'] === 'admin';

        require_once './app/views/activities/index.php';
    }

    public function show(int $id) {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $activity = $this->activiteModel->getActivityById($id);
        if (empty($activity)) {
            require_once './app/views/errors/404.php';
            exit;
        }

        $isAdmin = $_SESSION['user']['role'] === 'admin';
        require_once './app/views/activities/show.php';
    }

    public function update(int $id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? '',
                'type_id' => (int)($_POST['type_id'] ?? 0),
                'places_disponibles' => (int)($_POST['places_disponibles'] ?? 0),
                'description' => $_POST['description'] ?? '',
                'datetime_debut' => $_POST['datetime_debut'] ?? '',
                'duree' => (int)($_POST['duree'] ?? 0)
            ];

            if ($this->activiteModel->updateActivity($id, $data)) {
                header('Location: /activities/show/' . $id);
                exit;
            }
        }

        $activity = $this->activiteModel->getActivityById($id);
        if (empty($activity)) {
            require_once './app/views/errors/404.php';
            exit;
        }

        require_once './app/views/activities/edit.php';
    }

    public function delete(int $id) {
        error_log("ActivityController: Delete method called for ID: " . $id);
        
        // Vérification de l'authentification
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            error_log("ActivityController: User not authorized to delete");
            header('Location: /login');
            exit;
        }

        // Vérification que l'activité existe
        $activity = $this->activiteModel->getActivityById($id);
        if (empty($activity)) {
            error_log("ActivityController: Activity not found");
            header('Location: /activities');
            exit;
        }

        // Tentative de suppression
        $result = $this->activiteModel->deleteActivity($id);
        error_log("ActivityController: Delete result: " . ($result ? 'true' : 'false'));

        if ($result) {
            error_log("ActivityController: Activity deleted successfully");
            header('Location: /activities');
            exit;
        }

        // En cas d'échec
        error_log("ActivityController: Failed to delete activity");
        header('Location: /activities/show/' . $id);
        exit;
    }
}
