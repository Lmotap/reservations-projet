<?php

// Inclusion des fichiers nécessaires
require_once './app/models/ActiviteModel.php';
require_once './app/utils/AuthMiddleware.php';
require_once './app/utils/Render.php';

class ActivityController
{
    use Render;
    private ActiviteModel $activiteModel;

    // Constructeur : initialisation du modèle d'activités
    public function __construct()
    {
        $this->activiteModel = new ActiviteModel();
    }

    /**
     * Affiche la liste des activités
     */
    public function index()
    {
        AuthMiddleware::isAuthenticated();
        $activities = $this->activiteModel->getAllActivities();
        $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
        $this->renderView(
            'activities/index',
            [
                'title' => 'Liste des activités',
                'activities' => $activities,
                'isAdmin' => $isAdmin,
            ],
            'activities',
        );
    }

    /**
     * Affiche les détails d'une activité
     * @param int $id
     */
    public function show(int $id)
    {
        AuthMiddleware::isAuthenticated();
        $activity = $this->activiteModel->getActivityById($id);
        if (empty($activity)) {
            require_once './app/views/errors/404.php';
            exit();
        }

        $isAdmin = $_SESSION['user']['role'] === 'admin';
        $this->renderView(
            'activities/show',
            [
                'title' => $activity['nom'] . ' - Détails',
                'activity' => $activity,
                'isAdmin' => $isAdmin,
            ],
            'activities',
        );
    }

    /**
     * Affiche le formulaire de création d'une activité (admin uniquement)
     */
    public function create()
    {
        AuthMiddleware::isAdmin();
        $this->renderView(
            'activities/create',
            [
                'title' => 'Créer une activité',
            ],
            'activities',
        );
    }

    /**
     * Met à jour une activité existante
     * @param int $id
     */
    public function update(int $id)
    {
        AuthMiddleware::isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? '',
                'type_id' => (int) ($_POST['type_id'] ?? 0),
                'places_disponibles' => (int) ($_POST['places_disponibles'] ?? 0),
                'description' => $_POST['description'] ?? '',
                'image_url' => $_POST['image_url'] ?? null,
                'datetime_debut' => $_POST['datetime_debut'] ?? '',
                'duree' => (int) ($_POST['duree'] ?? 0),
            ];

            if ($this->activiteModel->updateActivity($id, $data)) {
                header('Location: /activities/show/' . $id);
                exit();
            }
        }

        $activity = $this->activiteModel->getActivityById($id);
        $this->renderView(
            'activities/edit',
            [
                'title' => 'Modifier l\'activité',
                'activity' => $activity,
            ],
            'activities',
        );
    }

    /**
     * Supprime une activité existante (admin uniquement)
     * @param int $id
     */
    public function delete(int $id)
    {
        AuthMiddleware::isAdmin();
        if ($this->activiteModel->deleteActivity($id)) {
            header('Location: /activities');
        } else {
            header('Location: /activities/show/' . $id);
        }
        exit();
    }

    /**
     * Enregistre une nouvelle activité dans la base de données
     */
    public function store()
    {
        AuthMiddleware::isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'] ?? '',
                'type_id' => (int) ($_POST['type_id'] ?? 0),
                'places_disponibles' => (int) ($_POST['places_disponibles'] ?? 0),
                'description' => $_POST['description'] ?? '',
                'image_url' => $_POST['image_url'] ?? null,
                'datetime_debut' => $_POST['datetime_debut'] ?? '',
                'duree' => (int) ($_POST['duree'] ?? 0),
            ];

            if ($this->activiteModel->createActivity($data)) {
                header('Location: /activities');
                exit();
            }
        }

        // Si une erreur s'est produite, redirection vers le formulaire de création
        header('Location: /activities/create');
        exit();
    }
}
