<!-- En-tête avec navigation -->
<div class="flex flex-wrap justify-between items-center mb-8">
    <div class="flex flex-wrap items-center gap-6">
        <?php if ($isAdmin): ?>
            <a href="/dashboard" class="inline-flex items-center text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
        <?php endif; ?>
        <h1 class="text-xl md:text-3xl font-bold text-black">Liste des activités</h1>
        <div class="flex flex-wrap gap-4">
            <a href="/reservations/index" class=" flex items-center gap-2 rounded-full p-2 bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-800 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="hidden md:inline">Voir mes réservations</span>
            </a>
        </div>
    </div>
    <?php if ($isAdmin): ?>
        <a href="/activities/create" class="bg-black text-white px-4 py-2 rounded hover:bg-darkgray transition-colors">
            Ajouter une nouvelle activité
        </a>
    <?php endif; ?>
    <?php if (!$isAdmin): ?>
        <a href="/logout" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-800 hover:bg-darkgray transition-colors">
            Déconnexion
        </a>
    <?php endif; ?>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($activities as $activity): ?>
        <div class="bg-white rounded-lg overflow-hidden flex flex-col">
            <?php if ($activity->getImageUrl()): ?>
                <div class="h-72 w-72 overflow-hidden">
                    <img src="<?= htmlspecialchars($activity->getImageUrl()) ?>" 
                         alt="<?= htmlspecialchars($activity->getNom()) ?>"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
            <?php endif; ?>
            <div class="p-6 flex flex-col flex-1">
                <h2 class="text-xl font-bold text-black mb-2">
                    <?= htmlspecialchars($activity->getNom()) ?>
                </h2>
                
                <p class="text-sm text-gray-600 mb-4">
                    Type : <?= htmlspecialchars($activity->getTypeNom()) ?>
                </p>

                <p class="text-sm text-gray-600 mb-4 flex-1">
                    <?= htmlspecialchars($activity->getDescription()) ?>
                </p>
                <p class="text-lg font-bold text-gray-800 mb-4 flex-1">
                    Nombre de places disponibles : <?= htmlspecialchars($activity->getPlacesDisponibles()) ?>
                </p>
                <div class="mt-auto">
                    <div class="flex gap-3">
                        <a href="/activities/show/<?= $activity->getId() ?>" 
                           class="flex-1 text-center bg-black text-white px-4 py-2 rounded hover:bg-darkgray transition-colors">
                            Voir les détails
                        </a>
                        <form action="/reservations/create" method="POST" class="flex-1">
                            <input type="hidden" name="activity_id" value="<?= $activity->getId() ?>">
                            <button type="submit" 
                                    class="w-full bg-black text-white px-4 py-2 rounded hover:bg-darkgray transition-colors">
                                Réserver
                            </button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>