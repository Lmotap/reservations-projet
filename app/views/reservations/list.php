
        <div class="flex gap-3 items-center mb-8">
            <a href="/dashboard" class="inline-flex items-center text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Toutes les réservations</h1>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date réservation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($reservation->getActiviteNom()) ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= date('d/m/Y H:i', strtotime($reservation->getDatetimeDebut())) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <?= htmlspecialchars(
                                        $reservation->getUserPrenom() . ' ' . $reservation->getUserNom(),
                                    ) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500">
                                    <?= date('d/m/Y H:i', strtotime($reservation->getDateReservation())) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $reservation->getEtat()
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800' ?>">
                                    <?= $reservation->getEtat() ? 'Active' : 'Annulée' ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
        </div>
    </div>
