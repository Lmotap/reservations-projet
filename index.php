<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once 'app/models/UserModel.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginResult = $userModel->login($_POST);
    if ($loginResult) {
        header('Location: dashboard.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-image {
            background-image: url('https://images.unsplash.com/photo-1517840901100-8179e982acb7?ixlib=rb-4.0.3');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="min-h-screen bg-image flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden">
            <div class="px-6 py-8">
                <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-8">
                    Connexion
                </h2>
                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm text-red-700">
                                    <?php 
                                    foreach ($_SESSION['errors'] as $error) {
                                        echo htmlspecialchars($error) . '<br>';
                                    }
                                    unset($_SESSION['errors']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <div class="mt-1">
                            <input type="email" id="email" name="email" required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="pwd" class="block text-sm font-medium text-gray-700">
                            Mot de passe
                        </label>
                        <div class="mt-1">
                            <input type="password" id="pwd" name="pwd" required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            Se connecter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>