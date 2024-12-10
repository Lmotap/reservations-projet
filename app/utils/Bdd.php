<?php

abstract class Bdd{
  protected $db = null;
 
  protected function __construct() {
    if($this->db === null){
      $this->connect();
    }
  }
 
  private function connect():void
  {
    try {
      $this->db = new PDO(
        'mysql:host='. $_ENV['db_host'] .';dbname='. $_ENV['db_name'],
        $_ENV['db_user'],
        $_ENV['db_pwd'],
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
      );
    } catch(PDOException $e) {
      die('Erreur de connexion : ' . $e->getMessage());
    }
  }

  protected function getConnection(): PDO {
    return $this->db;
  }
}