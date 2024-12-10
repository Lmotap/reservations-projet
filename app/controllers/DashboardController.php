<?php

class DashboardController {
    public function index() {
        if(!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        require_once './app/views/dashboard.php';
    }
}