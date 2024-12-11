<?php
// Debugging
error_log('GET parameters: ' . print_r($_GET, true));
if (isset($_GET['activity_id'])) {
    $activity = $activiteModel->getActivityById((int)$_GET['activity_id']);
    error_log('Activity data: ' . print_r($activity, true));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test des fonctions Activités</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex gap-4 mb-8">
            <a href="/dashboard" class="inline-flex items-center text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Test des fonctions Activités</h1>
        </div>

        <!-- Toutes les activités -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Toutes les activités</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php
                $activiteModel = new ActiviteModel();
                $activities = $activiteModel->getAllActivities();
                
                foreach ($activities as $activity): ?>
                    <div class="border rounded-lg p-4 hover:shadow-lg transition-shadow">
                        <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($activity->getNom()) ?></h3>
                        <p class="text-gray-600 mb-2"><?= htmlspecialchars($activity->getDescription()) ?></p>
                        <div class="text-sm text-gray-500">
                            <p>Date: <?= (new DateTime($activity->getDatetimeDebut()))->format('d/m/Y H:i') ?></p>
                            <p>Durée: <?= $activity->getDuree() ?> minutes</p>
                            <p>Places disponibles: <?= $activity->getPlacesDisponibles() ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Recherche par ID -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Rechercher une activité par ID</h2>
            <form class="flex gap-4 mb-4" action="/activities/test" method="GET">
                <input 
                    type="number" 
                    name="id" 
                    placeholder="Entrez l'ID de l'activité"
                    class="px-4 py-2 border rounded-md flex-grow"
                    min="1"
                    value="<?= htmlspecialchars($_GET['id'] ?? '') ?>"
                >
                <button 
                    type="submit"
                    class="bg-gray-900 text-white px-6 py-2 rounded-md hover:bg-gray-800 transition-colors"
                >
                    Rechercher
                </button>
            </form>

            <?php
            if (isset($_GET['id'])) {
                $activity = $activiteModel->getActivityById((int)$_GET['id']);
                if (!empty($activity)) : ?>
                    <div class="border rounded-lg p-4">
                        <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($activity['nom']) ?></h3>
                        <p class="text-gray-600 mb-2"><?= htmlspecialchars($activity['description']) ?></p>
                        <div class="text-sm text-gray-500">
                            <p>Date: <?= (new DateTime($activity['datetime_debut']))->format('d/m/Y H:i') ?></p>
                            <p>Durée: <?= $activity['duree'] ?> minutes</p>
                            <p>Places disponibles: <?= $activity['places_disponibles'] ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-red-500">Aucune activité trouvée avec cet ID.</p>
                <?php endif;
            }
            ?>
        </section>

        <!-- Places restantes pour toutes les activités -->
        <section class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Places restantes par activité</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach ($activities as $activity): 
                    $placesLeft = $activiteModel->getPlacesLeft($activity->getId());
                ?>
                    <div class="border rounded-lg p-4 text-center">
                        <h3 class="font-semibold mb-2"><?= htmlspecialchars($activity->getNom()) ?></h3>
                        <p class="text-2xl font-bold <?= $placesLeft > 0 ? 'text-green-600' : 'text-red-600' ?>">
                            <?= $placesLeft ?>
                        </p>
                        <p class="text-sm text-gray-500">places restantes</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>
</html>