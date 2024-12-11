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
            <h1 class="text-3xl font-bold text-gray-800">Liste des Activités</h1>
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
