<?php

// Inclusion des fichiers nécessaires
require_once './app/controllers/UserController.php';
require_once './app/controllers/ActivityController.php';
require_once './app/controllers/ReservationsController.php';
require_once './app/controllers/DashboardController.php';
require_once './app/models/ActiviteModel.php';

class Router
{
    // Routes protégées nécessitant une authentification
    private $protectedRoutes = ['activities', 'dashboard', 'user/profile', 'reservations'];

    // Routes accessibles uniquement aux administrateurs
    private $adminRoutes = ['activities/create', 'activities/update', 'activities/delete', 'reservations/list'];

    // Routes publiques accessibles sans authentification
    private $publicRoutes = ['', 'login', 'register', 'user/login', 'user/register'];

    // Fonction principale pour gérer les routes
    public function dispatch($url)
    {
        // Nettoyage de l'URL : suppression des "/" en début et fin de chaîne
        $url = trim($url, '/');

        // Redirection vers la page des activités si l'URL est vide
        if ($url === '') {
            header('Location: /activities');
            exit();
        }

        // Gestion des routes pour les réservations
        if ($this->handleReservationsRoutes($url)) {
            return;
        }

        // Vérification de l'authentification pour les routes protégées
        $this->checkAuthentication($url);

        // Vérification des droits administratifs pour les routes admin
        $this->checkAdminRights($url);

        // Gestion des routes pour les activités
        if ($this->handleActivitiesRoutes($url)) {
            return;
        }

        // Gestion des routes spécifiques (login, register, dashboard, logout)
        if ($this->handleSpecialRoutes($url)) {
            return;
        }

        // Gestion dynamique des contrôleurs et méthodes
        $this->handleDynamicRoutes($url);
    }

    // Fonction pour gérer les routes liées aux réservations
    private function handleReservationsRoutes($url)
    {
        if (strpos($url, 'reservations') === 0) {
            $reservationController = new ReservationsController();

            if ($url === 'reservations') {
                $reservationController->index();
                return true;
            }

            if ($url === 'reservations/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $reservationController->create();
                return true;
            }

            if (preg_match('#^reservations/show/(\d+)$#', $url, $matches)) {
                $reservationController->show((int) $matches[1]);
                return true;
            }

            if (preg_match('#^reservations/cancel/(\d+)$#', $url, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $reservationController->cancel((int) $matches[1]);
                return true;
            }

            if ($url === 'reservations/list' && isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
                $reservationController->list();
                return true;
            }
        }
        return false;
    }

    // Fonction pour vérifier l'authentification des utilisateurs
    private function checkAuthentication($url)
    {
        if (!in_array($url, $this->publicRoutes)) {
            require_once './app/utils/AuthMiddleware.php';
            AuthMiddleware::isAuthenticated();
        }

        $currentRoute = explode('/', $url)[0];
        if (in_array($currentRoute, $this->protectedRoutes) && !isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    }

    // Fonction pour vérifier les droits d'administration
    private function checkAdminRights($url)
    {
        if (
            in_array($url, $this->adminRoutes) &&
            (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin')
        ) {
            header('Location: /activities');
            exit();
        }
    }

    // Fonction pour gérer les routes liées aux activités
    private function handleActivitiesRoutes($url)
    {
        $urlParts = explode('/', $url);

        if ($urlParts[0] === 'activities') {
            $controller = new ActivityController();

            if (!isset($urlParts[1])) {
                $controller->index();
                return true;
            }

            switch ($urlParts[1]) {
                case 'show':
                    if (isset($urlParts[2])) {
                        $controller->show((int) $urlParts[2]);
                    }
                    break;
                case 'update':
                    if (isset($urlParts[2])) {
                        $controller->update((int) $urlParts[2]);
                    }
                    break;
                case 'delete':
                    if (isset($urlParts[2])) {
                        $controller->delete((int) $urlParts[2]);
                    }
                    break;
                case 'create':
                    $controller->create();
                    break;
                case 'store':
                    $controller->store();
                    break;
            }
            return true;
        }
        return false;
    }

    // Fonction pour gérer les routes spéciales (login, register, dashboard, logout)
    private function handleSpecialRoutes($url)
    {
        switch ($url) {
            case 'login':
                require_once './app/views/users/login.php';
                exit();
            case 'register':
                $controller = new UserController();
                $controller->register();
                exit();
            case 'dashboard':
                if (!isset($_SESSION['user'])) {
                    header('Location: /login');
                    exit();
                }
                if ($_SESSION['user']['role'] !== 'admin') {
                    header('Location: /activities');
                    exit();
                }
                $controller = new DashboardController();
                $controller->index();
                exit();
            case 'logout':
                $controller = new UserController();
                $controller->logout();
                exit();
        }
        return false;
    }

    // Fonction pour gérer les routes dynamiques
    private function handleDynamicRoutes($url)
    {
        $urlParts = explode('/', $url);

        $controllerName = ucfirst($urlParts[0]) . 'Controller';
        $methodName = $urlParts[1] ?? 'index';
        $params = array_slice($urlParts, 2);

        if (file_exists("./app/controllers/$controllerName.php")) {
            require_once "./app/controllers/$controllerName.php";
            $controller = new $controllerName();

            if (method_exists($controller, $methodName)) {
                call_user_func_array([$controller, $methodName], $params);
            } else {
                $this->show404();
            }
        } else {
            $this->show404();
        }
    }

    // Fonction pour afficher la page d'erreur 404
    private function show404()
    {
        require_once './app/views/errors/404.php';
        exit();
    }
}
