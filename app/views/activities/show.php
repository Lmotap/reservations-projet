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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex gap-4 mb-6">
            <a href="/activities" class="inline-flex items-center text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à la liste
            </a>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-800 border text-white px-4 py-3 rounded relative mb-4">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8"><?= htmlspecialchars($activity['nom']) ?></h1>
            
            <div class="space-y-6">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-lg font-medium text-gray-700 mb-2">Description</h2>
                    <p class="text-gray-600"><?= htmlspecialchars($activity['description']) ?></p>
                </div>
                
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-lg font-medium text-gray-700 mb-4">Détails</h2>
                    <div class="text-sm text-gray-500 space-y-4">
                        <p><i class="fas fa-calendar-alt fa-lg"></i> <span class="ml-2">Date : <?= date('d/m/Y H:i', strtotime($activity['datetime_debut'])) ?></span></p>
                        <p><i class="fas fa-hourglass-start fa-lg"></i> <span class="ml-2">Durée : <?= $activity['duree'] ?> minutes</span></p>
                        <p><i class="fas fa-chair fa-lg"></i> <span class="ml-2">Places disponibles : <?= $activity['places_disponibles'] ?></span></p>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <?php if ($isAdmin): ?>
                        <a href="/activities/update/<?= $activity['id'] ?>" 
                           class="w-full px-4 py-2 bg-black text-white rounded hover:bg-darkgray transition-colors text-center">
                            Modifier
                        </a>
                        <form action="/activities/delete/<?= $activity['id'] ?>" 
                              method="POST"
                              onsubmit="return confirm('Êtes-vous sûr ?');">
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-red-800 text-white rounded hover:bg-darkgray transition-colors">
                                Supprimer
                            </button>
                        </form>
                    <?php else: ?>
                        <form action="/reservations/create" method="POST">
                            <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>">
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-black text-white rounded hover:bg-darkgray transition-colors
                                           <?= $activity['places_disponibles'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                    <?= $activity['places_disponibles'] <= 0 ? 'disabled' : '' ?>>
                                Réserver
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
