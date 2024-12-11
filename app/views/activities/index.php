<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Activités</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-6">
                <h1 class="text-3xl font-bold text-gray-800">Liste des Activités</h1>
                <a href="/dashboard" 
                   class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </a>
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
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
