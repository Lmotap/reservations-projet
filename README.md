# Projet de Réservations 📅

## Auteur 🙍‍♂️

Lucas Mota

## Configuration initiale 🛠️

Pour mettre en place et exécuter ce projet, suivez les étapes ci-dessous :

### Prérequis 📋

1. **MAMP/WAMP/XAMPP**:
   - Installez et lancez MAMP (ou équivalent) pour gérer votre serveur MySQL et Apache localement. 🖥️

2. **PHP**:
   - Assurez-vous que PHP est installé sur votre machine pour pouvoir exécuter des scripts PHP localement. 🐘

3. **Composer**:
   - Installez Composer pour gérer les dépendances PHP du projet. 🎼

4. **Environnement de développement (.env)**:

   - Configurez vos variables d'environnement en créant un fichier `.env` à la racine du projet.

   ```bash
   composer require vlucas/phpdotenv
   ```

### Installation 📥

1. **Cloner le dépôt**:
   - Clonez ce dépôt sur votre machine locale en utilisant :

     ```bash
     git clone [URL_DU_DEPOT]
     ```

2. **Installer les dépendances**:

   - Naviguez dans le dossier du projet et exécutez :

     ```bash
     composer install
     ```

3. **Base de données**:
   - Exportez la base de données depuis un environnement existant ou utilisez le fichier fourni dans le dépôt.
   - Créez une base de données locale et importez-y les données exportées. 📚

4. **Configuration du serveur**:

   - Vous pouvez lancer un serveur PHP local en utilisant :

     ```bash
     php -S 127.0.0.1:8000
     ```

   - Vous pouvez changer le port `8000` en tout autre port de votre choix. 🌐

### Utilisation 🚀

- **Accès au projet**:
  - Ouvrez votre navigateur et accédez à `http://127.0.0.1:8000` ou à tout autre port que vous avez configuré. 🌍

- **Création d'un compte administrateur**:
  - Vous pouvez vous inscrire via l'interface utilisateur ou créer un compte administrateur directement dans la base de données pour accéder à des fonctionnalités administratives. 👤
  