<?php

require_once './app/controllers/UserController.php';
require_once './app/models/ActiviteModel.php';

class Router{
  public function dispatch($url)
  {
    // Suppression des / en début et fin de chaine
    $url = trim($url, '/');

    // Si l'URL est vide, charger la page d'accueil (login dans ce cas)
    if(empty($url)){
      require_once './app/views/users/login.php';
      exit;
    }

    // Découpe en tableau l'URL
    $url = explode('/', $url);

    if($url[0] === 'activities' && isset($url[1]) && $url[1] === 'test') {
        $activiteModel = new ActiviteModel();
        require_once './app/views/activities/test.php';
        exit;
<<<<<<< Updated upstream
=======
<<<<<<< Updated upstream
=======
<<<<<<< Updated upstream
=======
>>>>>>> Stashed changes
      }

      switch($url[1]) {
        case 'show':
          if(isset($url[2])) {
            $controller->show((int)$url[2]);
          }
          break;
        case 'test':
          require_once './app/views/activities/test.php';
          break;
<<<<<<< Updated upstream
      }
      exit;
=======
        case 'delete':
          if(isset($url[2])) {
            error_log("Router: Delete route hit with ID: " . $url[2]);
            error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
              $controller->delete((int)$url[2]);
            }
          }
          break;
        case 'update':
          if(isset($url[2])) {
            $controller->update((int)$url[2]);
          }
          break;
      }
      exit;
>>>>>>> Stashed changes
>>>>>>> Stashed changes
>>>>>>> Stashed changes
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