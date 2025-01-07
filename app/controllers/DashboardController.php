<?php

// Inclusion des dépendances nécessaires
require_once './app/utils/AuthMiddleware.php';
require_once './app/models/UserModel.php';
require_once './app/utils/Render.php';

class DashboardController
{
    private UserModel $userModel;
    use Render;

    // Constructeur : initialisation du modèle utilisateur
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Affiche le tableau de bord
     */
    public function index()
    {
        // Vérification de l'authentification et des droits admin
        AuthMiddleware::isAuthenticated();
        
        // Redirection des non-admin vers la liste des activités
        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: /activities');
            exit();
        }

        $users = $this->userModel->getAllUsers();
        $this->renderView('dashboard/index', [
            'title' => 'Tableau de bord',
            'users' => $users
        ], 'main');
    }
}
