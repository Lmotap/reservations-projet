<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Toutes les réservations</h1>
    <a href="/dashboard" class="text-blue-600 hover:text-blue-800">← Retour au dashboard</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Table content -->
</div>

<div class="mb-6 flex items-center gap-4">
    <a href="/reservation" class="text-blue-600 hover:text-blue-800">
        ← Retour aux réservations
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Détails de la réservation</h1>
    
    <div class="space-y-4">
        <div>
            <h2 class="text-xl font-semibold"><?= htmlspecialchars($reservation->activite_nom) ?></h2>
            <p class="text-gray-600"><?= htmlspecialchars($reservation->description) ?></p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="font-semibold">Date de l'activité</p>
                <p><?= date('d/m/Y H:i', strtotime($reservation->datetime_debut)) ?></p>
            </div>
            <div>
                <p class="font-semibold">Durée</p>
                <p><?= $reservation->duree ?> minutes</p>
            </div>
            <div>
                <p class="font-semibold">Date de réservation</p>
                <p><?= date('d/m/Y H:i', strtotime($reservation->date_reservation)) ?></p>
            </div>
            <div>
                <p class="font-semibold">Statut</p>
                <p><?= $reservation->etat ? 'Active' : 'Annulée' ?></p>
            </div>
        </div>

        <?php if ($reservation->etat): ?>
            <div class="mt-6">
                <form action="/reservations/cancel/<?= $reservation->id ?>" 
                      method="POST"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                    <button type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                        Annuler la réservation
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>