<?php

class UserController {
  
    public function index() {
        require_once './app/views/users/login.php';
    }
    public function create(): void
    {
      require_once './app/views/user/create.php';
    }
  
    public function save()
    {
        $required_fields = ['prenom', 'nom', 'email', 'motdepasse', 'motdepasse_confirmation', 'role'];
        $errors = [];

        // Validate required fields
        foreach ($required_fields as $field) {
            if (empty(trim($_POST[$field] ?? ''))) {
                $errors[] = "Le champ " . ucfirst($field) . " est obligatoire";
            }
        }

        // Validate email format
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide";
        }

        // Validate password match
        if ($_POST['motdepasse'] !== $_POST['motdepasse_confirmation']) {
            $errors[] = "Les mots de passe ne correspondent pas";
        }

        // Validate password strength (minimum 8 characters)
        if (strlen($_POST['motdepasse']) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
        }

        // Validate role
        $allowed_roles = ['user', 'admin'];
        if (!in_array($_POST['role'], $allowed_roles)) {
            $errors[] = "Le rôle sélectionné n'est pas valide";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /user/create');
            exit;
        }

        $userModel = new UserModel();

        $result = $userModel->createUser([
            'prenom' => trim($_POST['prenom']),
            'nom' => trim($_POST['nom']),
            'email' => trim($_POST['email']),
            'motdepasse' => password_hash($_POST['motdepasse'], PASSWORD_DEFAULT),
            'role' => $_POST['role']
        ]);

        if ($result) {
            $_SESSION['success'] = 'Compte créé avec succès';
            header('Location: /login');
        } else {
            $_SESSION['errors'] = ['Une erreur est survenue lors de la création du compte'];
            header('Location: /user/create');
        }
        exit;
    }
  
  
    public function logout() {
      unset($_SESSION['user']);
      header('location: /login');
      exit;
  }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require_once './app/views/users/register.php';
            return;
        }

        $required_fields = ['prenom', 'nom', 'email', 'motdepasse', 'motdepasse_confirmation'];
        $errors = [];

        // Validate required fields
        foreach ($required_fields as $field) {
            if (empty(trim($_POST[$field] ?? ''))) {
                $errors[] = "Le champ " . ucfirst($field) . " est obligatoire";
            }
        }

        // Validate email format
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide";
        }

        // Validate password match
        if ($_POST['motdepasse'] !== $_POST['motdepasse_confirmation']) {
            $errors[] = "Les mots de passe ne correspondent pas";
        }

        // Validate password strength
        if (strlen($_POST['motdepasse']) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /user/register');
            exit;
        }

        $userModel = new UserModel();

        // Hash password and save user
        $userData = [
            'prenom' => trim($_POST['prenom']),
            'nom' => trim($_POST['nom']),
            'email' => trim($_POST['email']),
            'motdepasse' => password_hash($_POST['motdepasse'], PASSWORD_DEFAULT),
            'role' => 'user'
        ];

        if ($userModel->createUser($userData)) {
            header('Location: /login');
        } else {
            $_SESSION['errors'] = ['Une erreur est survenue lors de la création du compte'];
            header('Location: /user/register');
        }
        exit;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new UserModel();
            if ($userModel->login($_POST)) {
                header('Location: /dashboard');
                exit;
            }
        }
        
        $logged = isset($_SESSION['user']);
        require_once './app/views/users/login.php';
    }
}