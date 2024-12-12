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
        <a href="/" class="nav-link inline-flex items-center mb-6">
            ← Retour aux activités
        </a>

        <div class="card p-8">
            <h1 class="text-3xl font-light mb-6"><?= htmlspecialchars($activity['nom']) ?></h1>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <p class="text-gray-600 mb-4"><?= htmlspecialchars($activity['description']) ?></p>
                    <div class="space-y-2 text-sm text-gray-500">
                        <p>Date : <?= date('d/m/Y H:i', strtotime($activity['datetime_debut'])) ?></p>
                        <p>Durée : <?= $activity['duree'] ?> minutes</p>
                        <p class="text-rose-500 font-medium">
                            Places disponibles : <?= $activity['places_disponibles'] ?>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <?php if ($isAdmin): ?>
                        <a href="/activities/update/<?= $activity['id'] ?>" class="btn-secondary">
                            Modifier
                        </a>
                        <form action="/activities/delete/<?= $activity['id'] ?>" 
                              method="POST"
                              onsubmit="return confirm('Êtes-vous sûr ?');">
                            <button type="submit" class="btn-danger w-full">Supprimer</button>
                        </form>
                    <?php else: ?>
                        <form action="/reservations/create" method="POST">
                            <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>">
                            <button type="submit" 
                                    class="btn-primary w-full <?= $activity['places_disponibles'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
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
