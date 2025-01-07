<?php

class AuthMiddleware
{
    public static function isAuthenticated()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    }

    public static function isAdmin()
    {
        self::isAuthenticated();
        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: /activities');
            exit();
        }
    }
}
