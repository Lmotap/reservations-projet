<?php

require_once './app/controllers/UserController.php';
require_once './app/controllers/ActivityController.php';
require_once './app/models/ActiviteModel.php';

class Router{
  // Define protected routes that require authentication
  private $protectedRoutes = [
      'activities',
      'dashboard',
      'user/profile'
  ];

  // Define admin-only routes
  private $adminRoutes = [
      'activities/create',
      'activities/update',
      'activities/delete',
      'activities/test'
  ];

  private $publicRoutes = [
      '',
      'login',
      'register',
      'user/login',
      'user/register'
  ];

  public function dispatch($url)
  {
    // Suppression des / en début et fin de chaine
    $url = trim($url, '/');

    // Si l'URL est vide, charger la page d'accueil (login dans ce cas)
    if(empty($url)){
      require_once './app/views/users/login.php';
      exit;
    }

    // Check if the route requires authentication
    if (!in_array($url, $this->publicRoutes)) {
        require_once './app/utils/AuthMiddleware.php';
        AuthMiddleware::isAuthenticated();
    }

    // Check authentication for protected routes
    $currentRoute = explode('/', $url)[0];
    
    if (in_array($currentRoute, $this->protectedRoutes) && !isset($_SESSION['user'])) {
        header('Location: /login');
        exit;
    }
    
    // Check admin rights for admin routes
    if (in_array($url, $this->adminRoutes) && 
        (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin')) {
        header('Location: /activities');
        exit;
    }

    // Découpe en tableau l'URL
    $url = explode('/', $url);

    // Gestion des routes pour les activités
    if($url[0] === 'activities') {
      $controller = new ActivityController();
      
      if(!isset($url[1])) {
        $controller->index();
        exit;
      }

      switch($url[1]) {
        case 'show':
          if(isset($url[2])) {
            $controller->show((int)$url[2]);
          }
          break;
        case 'update':
          if(isset($url[2])) {
            $controller->update((int)$url[2]);
          }
          break;
        case 'delete':
          if(isset($url[2])) {
            $controller->delete((int)$url[2]);
          }
          break;
        case 'create':
          $controller->create();
          break;
        case 'store':
          $controller->store();
          break;
        case 'test':
          require_once './app/views/activities/test.php';
          break;
      }
      exit;
    }

    // Gestion des routes spéciales
    if($url[0] === 'login') {
      require_once './app/views/users/login.php';
      exit;
    }

    if($url[0] === 'register') {
      $controller = new UserController();
      $controller->register();
      exit;
    }

    // Ajout de la gestion de la route dashboard
    if($url[0] === 'dashboard') {
      if(!isset($_SESSION['user'])) {
        header('Location: /login');
        exit;
      }
      require_once './app/views/dashboard.php';
      exit;
    }

    if($url[0] === 'logout') {
        $controller = new UserController();
        $controller->logout();
        exit;
    }

    // Défini le nom du controller
    $controllerName = ucfirst($url[0]) . 'Controller';

    // Le second élément de l'URL est la méthode
    if(isset($url[1])){
      $methodName = $url[1];
    }
    else{
      $methodName = 'index';
    }
    
    // Extrait la suite de l'URL
    $params = array_slice($url, 2);

    // Vérification de l'existence du contrôleur
    if (file_exists("./app/controllers/$controllerName.php")) {
      // Charge le controleur
      require_once "./app/controllers/$controllerName.php";
      // Initialise le controleur
      $controller = new $controllerName;

      // Vérification de l'existence de la méthode dans le contrôleur
      if (method_exists($controller, $methodName)) {
        // Appel la méthode du controleur et envoie les paramètres
        call_user_func_array([$controller, $methodName], $params);
      } else {
        require_once './app/views/errors/404.php';
        exit;
      }
    } else {
      require_once './app/views/errors/404.php';
      exit;
    }
  }
}