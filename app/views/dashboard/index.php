<!-- app/views/dashboard.php -->
<main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Welcome card -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                Bienvenue, <?php echo htmlspecialchars($_SESSION['user']['prenom']); ?> !
            </h1>
            <p class="text-gray-500">
                Vous êtes connecté en tant que : <?php echo htmlspecialchars($_SESSION['user']['email']); ?>
            </p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Stat cards -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Rôle</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?php echo htmlspecialchars($_SESSION['user']['role']); ?>
                </dd>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">ID utilisateur</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    #<?php echo htmlspecialchars($_SESSION['user']['id']); ?>
                </dd>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Status</dt>
                <dd class="mt-1 text-3xl font-semibold text-green-700">Actif</dd>
            </div>
        </div>
    </div>

    <?php if ($_SESSION['user']['role'] === 'admin' && !empty($users)): ?>
        <!-- Users Section (Admin Only) -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden mt-8">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des utilisateurs</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($users as $user): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        #<?php echo htmlspecialchars($user->getId()); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars($user->getNom()); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo htmlspecialchars($user->getPrenom()); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo htmlspecialchars($user->getEmail()); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?php echo $user->getRole() === 'admin'
                                                ? 'bg-purple-100 text-purple-800'
                                                : 'bg-green-100 text-green-800'; ?>">
                                            <?php echo htmlspecialchars($user->getRole()); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>