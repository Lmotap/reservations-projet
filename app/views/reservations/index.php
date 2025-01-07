<div class="flex justify-between items-center mb-8">
    <div class="flex items-center gap-6">
    <?php if ($isAdmin): ?>
        <a href="/dashboard" class="inline-flex items-center text-gray-600 hover:text-gray-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
    <?php endif; ?>
        <h1 class="text-3xl font-bold text-gray-800">Mes réservations</h1>
    </div>
    <a href="/activities" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-darkgray transition-colors">
        Voir les activités disponibles
    </a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-700 border border-green-700 text-white px-4 py-3 rounded relative mb-4">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (!empty($reservations)): ?>
        <?php foreach ($reservations as $reservation): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">
                        <?= htmlspecialchars($reservation->getActiviteNom()) ?>
                    </h2>
                    <div class="space-y-2 text-sm text-gray-500 mb-4">
                        <p>Date de réservation : <?= date(
                            'd/m/Y H:i',
                            strtotime($reservation->getDateReservation()),
                        ) ?></p>
                        <p>Statut : <?= $reservation->getEtat() ? 'Active' : 'Annulée' ?></p>
                        <p>Date de l'activité : <?= date(
                            'd/m/Y H:i',
                            strtotime($reservation->getDatetimeDebut()),
                        ) ?></p>
                        <p>Durée : <?= $reservation->getDuree() ?> minutes</p>
                    </div>
                    <?php if ($reservation->getEtat()): ?>
                        <form action="/reservations/cancel/<?= $reservation->getId() ?>" 
                              method="POST" 
                              class="inline-block"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                            <button type="submit" 
                                    class="bg-red-800 text-white px-4 py-2 rounded hover:bg-darkgray transition-colors">
                                Annuler la réservation
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-3 text-center text-gray-500">
            Aucune réservation trouvée
        </div>
    <?php endif; ?>
</div>