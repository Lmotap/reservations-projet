<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <div class="mb-8">
            <h1 class="text-9xl font-bold text-gray-800">404</h1>
            <p class="text-2xl text-gray-600 mt-4">Page non trouvée</p>
        </div>
        
        <p class="text-gray-500 mb-8">
            Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
        </p>
        
        <div class="space-x-4">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="<?= $_SESSION['user']['role'] === 'admin' ? '/dashboard' : '/activities' ?>" 
                   class="inline-block bg-black hover:bg-darkgray text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200">
                    Retour à l'accueil
                </a>
            <?php else: ?>
                <a href="/login" 
                   class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-lg transition-colors duration-200">
                    Se connecter
                </a>
            <?php endif; ?>
        </div>
        
        <div class="mt-8 text-sm text-gray-500">
            Si vous pensez qu'il s'agit d'une erreur, veuillez contacter le support.
        </div>
    </div>
</body>
</html> 