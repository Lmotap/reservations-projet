<?php

class DashboardController {
    public function __construct() {
        require_once './app/utils/AuthMiddleware.php';
    }

    public function index() {
        AuthMiddleware::isAuthenticated();
        require_once './app/views/dashboard.php';
    }
}