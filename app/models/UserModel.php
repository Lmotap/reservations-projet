<?php

// Inclusion des fichiers nécessaires
require_once './app/utils/Bdd.php';
require_once './app/orms/User.php';

class UserModel extends Bdd
{
    // Constructeur : appel du constructeur parent
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Récupère tous les utilisateurs
     * @return array Liste des utilisateurs ou tableau vide en cas d'erreur
     */
    public function getAllUsers(): array
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM users');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Trouve un utilisateur par son ID
     * @param int $id
     * @return User|false L'utilisateur ou false si non trouvé
     */
    public function findOneById(int $id): User|false
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Crée un nouvel utilisateur
     * @param array $data Données de l'utilisateur
     * @return bool Succès ou échec de l'insertion
     */
    public function createUser(array $data): bool
    {
        try {
            $stmt = $this->db->prepare(
                'INSERT INTO users (prenom, nom, email, motdepasse, role) 
                 VALUES (:prenom, :nom, :email, :motdepasse, :role)',
            );
            return $stmt->execute([
                'prenom' => $data['prenom'],
                'nom' => $data['nom'],
                'email' => $data['email'],
                'motdepasse' => $data['motdepasse'],
                'role' => $data['role'],
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Gère la connexion de l'utilisateur
     * @param array $POST Données du formulaire de connexion
     * @return bool Succès ou échec de la connexion
     */
    public function login(array $POST): bool
    {
        if (!isset($POST['email']) || !isset($POST['motdepasse'])) {
            $_SESSION['errors'][] = 'Email et mot de passe requis';
            return false;
        }

        $email = htmlspecialchars(trim($POST['email']));
        $pwd = htmlspecialchars(trim($POST['motdepasse']));

        $sql = 'SELECT id, prenom, nom, email, motdepasse, role FROM users WHERE email = :email LIMIT 1';

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['email' => $email]);

            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch();

                // Vérification du mot de passe
                if (password_verify($pwd, $user['motdepasse'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'prenom' => $user['prenom'],
                        'nom' => $user['nom'],
                        'role' => $user['role'],
                    ];
                    return true;
                }
            }

            $_SESSION['errors'][] = 'Identifiant ou mot de passe incorrect';
            return false;
        } catch (PDOException $e) {
            $_SESSION['errors'][] = 'Une erreur est survenue';
            error_log($e->getMessage());
            return false;
        }
    }
}
