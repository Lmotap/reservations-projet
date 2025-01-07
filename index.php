<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once 'app/utils/Router.php';
require_once 'app/models/UserModel.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialise router
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);
