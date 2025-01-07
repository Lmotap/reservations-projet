<?php

// Inclusion des fichiers nécessaires
require_once './app/utils/AuthMiddleware.php';
require_once './app/models/UserModel.php';
require_once './app/utils/Render.php';

class UserController
{
    use Render;
    private UserModel $userModel;

    // Constructeur : initialisation du modèle utilisateur
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Affiche la page de connexion
     */
    public function index(): void
    {
        require_once './app/views/users/login.php';
    }

    /**
     * Affiche la page de création d'utilisateur
     */
    public function create(): void
    {
        require_once './app/views/user/create.php';
    }

    /**
     * Enregistre un nouvel utilisateur après validation
     */
    public function save(): void
    {
        $required_fields = ['prenom', 'nom', 'email', 'motdepasse', 'motdepasse_confirmation', 'role'];
        $errors = [];

        // Validation des champs requis
        foreach ($required_fields as $field) {
            if (empty(trim($_POST[$field] ?? ''))) {
                $errors[] = 'Le champ ' . ucfirst($field) . ' est obligatoire';
            }
        }

        // Validation du format de l'email
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide";
        }

        // Validation de la correspondance des mots de passe
        if ($_POST['motdepasse'] !== $_POST['motdepasse_confirmation']) {
            $errors[] = 'Les mots de passe ne correspondent pas';
        }

        // Validation de la longueur du mot de passe
        if (strlen($_POST['motdepasse']) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères';
        }

        // Validation du rôle
        $allowed_roles = ['user', 'admin'];
        if (!in_array($_POST['role'], $allowed_roles)) {
            $errors[] = "Le rôle sélectionné n'est pas valide";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /user/create');
            exit();
        }

        // Création de l'utilisateur
        $result = $this->userModel->createUser([
            'prenom' => trim($_POST['prenom']),
            'nom' => trim($_POST['nom']),
            'email' => trim($_POST['email']),
            'motdepasse' => password_hash($_POST['motdepasse'], PASSWORD_DEFAULT),
            'role' => $_POST['role'],
        ]);

        if ($result) {
            $_SESSION['success'] = 'Compte créé avec succès';
            header('Location: /login');
        } else {
            $_SESSION['errors'] = ['Une erreur est survenue lors de la création du compte'];
            header('Location: /user/create');
        }
        exit();
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout(): void
    {
        AuthMiddleware::isAuthenticated();
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /login');
        exit();
    }

    /**
     * Affiche la page d'inscription ou gère les soumissions
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->renderView(
                'users/register',
                [
                    'title' => 'Inscription',
                ],
                'user',
            );
            return;
        }

        $required_fields = ['prenom', 'nom', 'email', 'motdepasse', 'motdepasse_confirmation'];
        $errors = [];

        // Validation des champs requis
        foreach ($required_fields as $field) {
            if (empty(trim($_POST[$field] ?? ''))) {
                $errors[] = 'Le champ ' . ucfirst($field) . ' est obligatoire';
            }
        }

        // Validation du format de l'email
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide";
        }

        // Validation de la correspondance des mots de passe
        if ($_POST['motdepasse'] !== $_POST['motdepasse_confirmation']) {
            $errors[] = 'Les mots de passe ne correspondent pas';
        }

        // Validation de la longueur du mot de passe
        if (strlen($_POST['motdepasse']) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /user/register');
            exit();
        }

        // Création de l'utilisateur
        $userData = [
            'prenom' => trim($_POST['prenom']),
            'nom' => trim($_POST['nom']),
            'email' => trim($_POST['email']),
            'motdepasse' => password_hash($_POST['motdepasse'], PASSWORD_DEFAULT),
            'role' => 'user',
        ];

        if ($this->userModel->createUser($userData)) {
            header('Location: /login');
        } else {
            $_SESSION['errors'] = ['Une erreur est survenue lors de la création du compte'];
            header('Location: /user/register');
        }
        exit();
    }

    /**
     * Gère la connexion utilisateur
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->renderView(
                'users/login',
                [
                    'title' => 'Connexion',
                ],
                'user',
            );
            return;
        }

        if ($this->userModel->login($_POST)) {
            // Redirection basée sur le rôle
            if ($_SESSION['user']['role'] === 'admin') {
                header('Location: /dashboard');
            } else {
                header('Location: /activities');
            }
            exit();
        }

        header('Location: /login');
        exit();
    }
}
