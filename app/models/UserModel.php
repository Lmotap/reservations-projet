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
          $stmt = $this->co->prepare('SELECT * FROM users');
          $stmt->execute();
          
          // Debug: Print count of returned rows
          $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
          echo "Found " . count($result) . " users";
          
          return $result;
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
          return [];
      }
  }
 
  public function findOneById(int $id): User | false
  {
    $users = $this->co->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
    $users->setFetchMode(PDO::FETCH_CLASS, 'User');
    $users->execute([
      'id' => $id
    ]);
 
    return $users->fetch();
  }

  public function save($POST): int
  {
    $email = htmlspecialchars(trim($POST['email']));
    $pwd = htmlspecialchars(trim($POST['motdepasse']));

    $sql = 'INSERT INTO users(email, motdepasse) VALUES (:email, :motdepasse)';
    $params = [
      'email' => $email,
      'motdepasse' => password_hash(
        $pwd,
        PASSWORD_BCRYPT
      )
    ];

    $insert = $this->co->prepare($sql);
    $insert->execute($params);

    return $insert->rowCount();
  }

  public function login($POST): bool
  {
    $email = htmlspecialchars(trim($POST['email']));
    $pwd = htmlspecialchars(trim($POST['pwd']));
    
    $sql = 'SELECT * FROM users WHERE email = :email LIMIT 1';

    $params = [
      'email' => $email
    ];

    $select = $this->co->prepare($sql);
    $select->execute($params);

    if($select->rowCount() == 1){
      $user = $select->fetch();
      if(password_verify($pwd, $user['motdepasse'])){
        $_SESSION['email'] = $user['email'];
        return true;
      }
      else{
        $_SESSION['errors'][] = 'Identifiant ou mot de passe incorrect';
        return false;
      }
    }
    else{
      return false;
    }
  }
}