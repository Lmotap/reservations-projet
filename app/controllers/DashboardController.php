<?php

class DashboardController {
    private $userModel;

    public function __construct() {
        require_once './app/utils/AuthMiddleware.php';
        require_once './app/models/UserModel.php';
        $this->userModel = new UserModel();
    }

    public function index() {
        AuthMiddleware::isAuthenticated();
        
        $users = [];
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            $users = $this->userModel->getAllUsers();
        }
        
        require_once './app/views/dashboard.php';
    }
}