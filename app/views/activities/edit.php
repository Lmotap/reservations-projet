<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'activité</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Modifier l'activité</h1>

        <form action="/activities/update/<?= $activity['id'] ?>" method="POST" class="bg-white rounded-lg shadow-md p-6">
            <div class="space-y-6">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom de l'activité</label>
                    <input type="text" id="nom" name="nom" 
                           value="<?= htmlspecialchars($activity['nom']) ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label for="type_id" class="block text-sm font-medium text-gray-700 mb-2">Type d'activité</label>
                    <select id="type_id" name="type_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="1" <?= $activity['type_id'] == 1 ? 'selected' : '' ?>>Sport</option>
                        <option value="2" <?= $activity['type_id'] == 2 ? 'selected' : '' ?>>Culture</option>
                        <option value="3" <?= $activity['type_id'] == 3 ? 'selected' : '' ?>>Loisir</option>
                    </select>
                </div>

                <div>
                    <label for="places_disponibles" class="block text-sm font-medium text-gray-700 mb-2">Places disponibles</label>
                    <input type="number" id="places_disponibles" name="places_disponibles" 
                           value="<?= $activity['places_disponibles'] ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required min="0">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="5" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              required><?= htmlspecialchars($activity['description']) ?></textarea>
                </div>

                <div>
                    <label for="datetime_debut" class="block text-sm font-medium text-gray-700 mb-2">Date et heure de début</label>
                    <input type="datetime-local" id="datetime_debut" name="datetime_debut" 
                           value="<?= date('Y-m-d\TH:i', strtotime($activity['datetime_debut'])) ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label for="duree" class="block text-sm font-medium text-gray-700 mb-2">Durée (en minutes)</label>
                    <input type="number" id="duree" name="duree" 
                           value="<?= $activity['duree'] ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required min="0">
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="/activities/show/<?= $activity['id'] ?>" 
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
