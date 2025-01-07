<?php
// app/views/layouts/main.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏨</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="/public/css/styles.css" rel="stylesheet">
    <link href="/public/css/custom.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 transition-all duration-300 ease-in-out">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <span class="text-xl font-semibold text-gray-800">
                        Dashboard
                    </span>
                    <div class="flex space-x-4">
                        <a href="/dashboard" class="nav-link text-gray-600 hover:text-gray-900 px-3 py-2">
                            Accueil
                        </a>
                        <a href="/activities" class="nav-link text-gray-600 hover:text-gray-900 px-3 py-2">
                            Activités
                        </a>
                        <a href="/reservations" class="nav-link text-gray-600 hover:text-gray-900 px-3 py-2">
                            Réservations
                        </a>
                        <a href="/reservations/list" class="nav-link text-gray-600 hover:text-gray-900 px-3 py-2">
                            Toutes les réservations
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/logout" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-800 hover:bg-darkgray transition-colors">
                        Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <?= $content ?>
</body>
</html>