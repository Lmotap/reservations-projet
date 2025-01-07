<?php
require_once './app/utils/AuthMiddleware.php';
AuthMiddleware::isAuthenticated();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Activités</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏨</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-6">
                <h1 class="text-3xl font-bold text-gray-800">Liste des Activités</h1>
                <div class="flex gap-4">
                    <a href="/dashboard" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </a>
                    <a href="/reservations" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <?php if ($isAdmin): ?>
                <a href="/activities/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Ajouter une nouvelle activité
                </a>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($activities as $activity): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            <?= htmlspecialchars($activity->getNom()) ?>
                        </h2>
                        <p class="text-gray-600 mb-4">
                            <?= htmlspecialchars(substr($activity->getDescription(), 0, 100)) ?>...
                        </p>
                        <div class="space-y-2 text-sm text-gray-500">
                            <p>Places disponibles : <?= $activity->getPlacesDisponibles() ?></p>
                            <p>Date : <?= date('d/m/Y H:i', strtotime($activity->getDatetimeDebut())) ?></p>
                            <p>Durée : <?= $activity->getDuree() ?> minutes</p>
                        </div>
                        <a href="/activities/show/<?= $activity->getId() ?>" 
                           class="mt-4 inline-block bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                            Voir les détails
                        </a>
                        <?php if ($activity->getPlacesDisponibles() > 0): ?>
                            <form action="/reservations/create" method="POST" class="inline">
                                <input type="hidden" name="activity_id" value="<?= $activity->getId() ?>">
                                <button type="submit" 
                                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
                                    Réserver
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
