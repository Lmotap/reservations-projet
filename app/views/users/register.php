<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2070&auto=format&fit=crop');">
    <div class="bg-white/90 backdrop-blur-sm p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Inscription</h1>

        <form action="/user/register" method="POST" class="space-y-6">
            <div>
                <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">
                    Prénom
                </label>
                <input 
                    type="text" 
                    name="prenom" 
                    id="prenom" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-700 focus:border-gray-700 outline-none transition-colors"
                    required
                >
            </div>

            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                    Nom
                </label>
                <input 
                    type="text" 
                    name="nom" 
                    id="nom" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-700 focus:border-gray-700 outline-none transition-colors"
                    required
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="john.doe@gmail.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-700 focus:border-gray-700 outline-none transition-colors"
                    required
                >
            </div>

            <div>
                <label for="motdepasse" class="block text-sm font-medium text-gray-700 mb-2">
                    Mot de passe
                </label>
                <input 
                    type="password" 
                    name="motdepasse" 
                    id="motdepasse"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-700 focus:border-gray-700 outline-none transition-colors"
                    required
                >
                <small class="text-gray-500 text-xs mt-1 block">Le mot de passe doit contenir au moins 8 caractères</small>
            </div>

            <div>
                <label for="motdepasse_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmer le mot de passe
                </label>
                <input 
                    type="password" 
                    name="motdepasse_confirmation" 
                    id="motdepasse_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-700 focus:border-gray-700 outline-none transition-colors"
                    required
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-gray-900 text-white py-2 px-4 rounded-md hover:bg-gray-800 transition-colors duration-200 font-semibold"
            >
                S'inscrire
            </button>
        </form>

        <?php if(isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
            <div class="mt-6 space-y-2">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <p class="text-red-500 text-sm bg-red-50 p-3 rounded-md">
                        <?php echo htmlspecialchars($error); ?>
                    </p>
                <?php endforeach; ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <p class="mt-8 text-center text-sm text-gray-600">
            Déjà inscrit ? 
            <a href="/login" class="text-gray-800 hover:text-gray-900 font-semibold underline">
                Connectez-vous
            </a>
        </p>
    </div>
</body>
</html>