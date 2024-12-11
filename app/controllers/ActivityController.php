<?php

require_once './app/models/ActiviteModel.php';
require_once './app/utils/AuthMiddleware.php';

class ActivityController {
    private ActiviteModel $activiteModel;

    public function __construct() {
        require_once './app/utils/AuthMiddleware.php';
        $this->activiteModel = new ActiviteModel();
    }

    public function index() {
        AuthMiddleware::isAuthenticated();
        $activities = $this->activiteModel->getAllActivities();
        $isAdmin = $_SESSION['user']['role'] === 'admin';
        require_once './app/views/activities/index.php';
    }

    public function show(int $id) {
        AuthMiddleware::isAuthenticated();
        $activity = $this->activiteModel->getActivityById($id);
        if (empty($activity)) {
            require_once './app/views/errors/404.php';
            exit;
        }

        $isAdmin = $_SESSION['user']['role'] === 'admin';
        require_once './app/views/activities/show.php';
    }

    public function create() {
        AuthMiddleware::isAdmin();
        require_once './app/views/activities/create.php';
    }

    public function update(int $id) {
        AuthMiddleware::isAdmin();
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
        require_once './app/views/activities/edit.php';
    }

    public function delete(int $id) {
        AuthMiddleware::isAdmin();
        if ($this->activiteModel->deleteActivity($id)) {
            header('Location: /activities');
        } else {
            header('Location: /activities/show/' . $id);
        }
        exit;
    }

    public function store() {
        AuthMiddleware::isAdmin();
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

            if ($this->activiteModel->createActivity($data)) {
                header('Location: /activities');
                exit;
            }
        }

        // If something went wrong, redirect back to create form
        header('Location: /activities/create');
        exit;
    }
}
