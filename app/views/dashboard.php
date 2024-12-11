<?php
require_once './app/utils/AuthMiddleware.php';
AuthMiddleware::isAuthenticated();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏨</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <span class="text-xl font-semibold text-gray-800">
                        Dashboard
                    </span>
                    <div class="flex space-x-4">
                        <a href="/dashboard" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md">
                            Accueil
                        </a>
                        <a href="/activities" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md">
                            Activités
                        </a>
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <a href="/activities/test" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md">
                                Test Activités
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">
                        <?php echo htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']); ?>
                    </span>
                    <a href="/logout" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                        Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Welcome card -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    Bienvenue, <?php echo htmlspecialchars($_SESSION['user']['prenom']); ?> !
                </h1>
                <p class="text-gray-500">
                    Vous êtes connecté en tant que : <?php echo htmlspecialchars($_SESSION['user']['email']); ?>
                </p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Stat card 1 -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Rôle
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        <?php echo htmlspecialchars($_SESSION['user']['role']); ?>
                    </dd>
                </div>
            </div>

            <!-- Stat card 2 -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        ID Utilisateur
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        #<?php echo htmlspecialchars($_SESSION['user']['id']); ?>
                    </dd>
                </div>
            </div>

            <!-- Stat card 3 -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Status
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-green-600">
                        Actif
                    </dd>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
