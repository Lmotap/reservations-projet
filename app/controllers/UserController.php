<?php

class UserController {
  
    public function create(): void
    {
      require_once './app/views/user/create.php';
    }
  
    public function save()
    {
      if(empty(trim($_POST['email']))){
        die('<p>Email obligatoire</p>');
      }
      if(empty(trim($_POST['pwd']))){
        die('<p>Mot de passe obligatoire</p>');
      }
  
      $userModel = new UserModel();
      $add = $userModel->save($_POST);
  
      if($add > 0){
        header('location: /user');
      }
      else{
        die('<p>Une erreur est survenue</p>');
      }
    }
  
  
    public function logout(){
      unset($_SESSION['email']);
      header('location: /user/login');
    }
}