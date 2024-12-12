<?php
require_once './app/utils/AuthMiddleware.php';
AuthMiddleware::isAuthenticated();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Réservations</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏨</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-6">
                <h1 class="text-3xl font-bold text-gray-800">Mes Réservations</h1>
                <a href="/dashboard" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </a>
            </div>
            <a href="/activities" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Voir les activités disponibles
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($reservations as $reservation): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            <?= htmlspecialchars($reservation->activite_nom) ?>
                        </h2>
                        <div class="space-y-2 text-sm text-gray-500 mb-4">
                            <p>Date de réservation : <?= date('d/m/Y H:i', strtotime($reservation->getDateReservation())) ?></p>
                            <p>Statut : <?= $reservation->getEtat() ? 'Active' : 'Annulée' ?></p>
                            <p>Date de l'activité : <?= date('d/m/Y H:i', strtotime($reservation->datetime_debut)) ?></p>
                            <p>Durée : <?= $reservation->duree ?> minutes</p>
                        </div>
                        <?php if ($reservation->getEtat()): ?>
                            <form action="/reservations/cancel/<?= $reservation->getId() ?>" 
                                  method="POST" 
                                  class="inline-block"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                <button type="submit" 
                                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                                    Annuler la réservation
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