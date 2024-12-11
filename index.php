<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once 'app/utils/Router.php';
require_once 'app/models/UserModel.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Define public routes (both direct and controller routes)
$publicRoutes = [
    '', // empty route
    'user/login',
    'user/register',
    'dashboard',
    'register',
    'login',
    'activities/test',
    'activities',
    'activities/show',
];

// Get current route
$currentRoute = trim($_SERVER['REQUEST_URI'], '/');

// Check if user is logged in or accessing public route
if (!isset($_SESSION['user']) && !in_array($currentRoute, $publicRoutes)) {
    header('Location: /login');
    exit;
}

// Initialisation du router
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);