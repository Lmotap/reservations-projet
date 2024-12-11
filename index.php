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
    'register',
    'login',
];

// Get current route
$currentRoute = trim($_SERVER['REQUEST_URI'], '/');

// Check if user is logged in or accessing public route
if (!isset($_SESSION['user']) && !in_array($currentRoute, $publicRoutes)) {
    header('Location: /login');
    exit;
}

// Check admin routes
$adminRoutes = [
    'activities/create',
    'activities/update',
    'activities/delete',
    'activities/test',
    'users/manage'
];

// If route requires admin access but user is not admin, redirect
if (in_array($currentRoute, $adminRoutes) && 
    (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin')) {
    header('Location: /activities');
    exit;
}

// Initialize router
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);