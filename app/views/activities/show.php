<?php
require_once './app/utils/AuthMiddleware.php';
AuthMiddleware::isAuthenticated();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($activity['nom']) ?> - Détails</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏨</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <a href="/activities" class="inline-flex items-center text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6"><?= htmlspecialchars($activity['nom']) ?></h1>

            <div class="space-y-4 mb-8">
                <p class="text-gray-700 whitespace-pre-line"><?= nl2br(htmlspecialchars($activity['description'])) ?></p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-600">
                    <p>Places disponibles : <?= $activity['places_disponibles'] ?></p>
                    <p>Date de début : <?= date('d/m/Y H:i', strtotime($activity['datetime_debut'])) ?></p>
                    <p>Durée : <?= $activity['duree'] ?> minutes</p>
                </div>
            </div>

            <div class="flex gap-4">
                <?php if ($isAdmin): ?>
                    <a href="/activities/update/<?= $activity['id'] ?>" 
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                        Modifier
                    </a>
                    <form action="/activities/delete/<?= $activity['id'] ?>" 
                          method="POST" 
                          class="inline-block"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ?');">
                        <?php error_log("Form submitted for activity ID: " . $activity['id']); ?>
                        <input type="hidden" name="id" value="<?= $activity['id'] ?>">
                        <button type="submit" 
                                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                            Supprimer
                        </button>
                    </form>
                <?php else: ?>
                    <form action="/reservations/create" method="POST">
                        <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>">
                        <button type="submit" 
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                <?= $activity['places_disponibles'] <= 0 ? 'disabled' : '' ?>>
                            Réserver
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
