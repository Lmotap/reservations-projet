<?php

require_once './app/utils/Bdd.php';
require_once './app/orms/User.php';


class UserModel extends Bdd{
  public function __construct(){
    parent::__construct();
  }
 
  public function getAllUsers(): array
  {
      try {
          $stmt = $this->db->prepare('SELECT * FROM users');
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
          return $result;
      } catch (PDOException $e) {
          return [];
      }
  }
 
  public function findOneById(int $id): User | false
  {
    $users = $this->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
    $users->setFetchMode(PDO::FETCH_CLASS, 'User');
    $users->execute([
      'id' => $id
    ]);
 
    return $users->fetch();
  }

  public function createUser(array $data): bool
  {
      try {
          $stmt = $this->db->prepare(
              'INSERT INTO users (prenom, nom, email, motdepasse, role) 
               VALUES (:prenom, :nom, :email, :motdepasse, :role)'
          );
          
          return $stmt->execute([
              'prenom' => $data['prenom'],
              'nom' => $data['nom'],
              'email' => $data['email'],
              'motdepasse' => $data['motdepasse'],
              'role' => $data['role']
          ]);
      } catch (PDOException $e) {
          error_log($e->getMessage());
          return false;
      }
  }

  public function login($POST): bool
  {
    if (!isset($POST['email']) || !isset($POST['motdepasse'])) {
        $_SESSION['errors'][] = 'Email et mot de passe requis';
        return false;
    }
    
    $email = htmlspecialchars(trim($POST['email']));
    $pwd = htmlspecialchars(trim($POST['motdepasse']));
    
    $sql = 'SELECT id, prenom, nom, email, motdepasse, role FROM users WHERE email = :email LIMIT 1';
    $params = ['email' => $email];

    try {
        $select = $this->db->prepare($sql);
        $select->execute($params);

        if($select->rowCount() == 1){
            $user = $select->fetch();
            
            if(password_verify($pwd, $user['motdepasse'])){
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'prenom' => $user['prenom'],
                    'nom' => $user['nom'],
                    'role' => $user['role']
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
