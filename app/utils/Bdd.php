<?php

/**
 * Classe abstraite représentant une connexion à la base de données.
 * Toutes les classes qui en héritent peuvent utiliser la connexion PDO partagée.
 */
abstract class Bdd
{
    /**
     * Instance PDO pour la connexion à la base de données.
     * @var PDO|null
     */
    protected $db = null;

    /**
     * Constructeur de la classe.
     * Initialise la connexion à la base de données si elle n'est pas encore établie.
     */
    protected function __construct()
    {
        if ($this->db === null) {
            $this->connect();
        }
    }

    /**
     * Établit une connexion à la base de données.
     * Utilise les variables d'environnement pour configurer les paramètres de connexion.
     * 
     * @return void
     */
    private function connect(): void
    {
        try {
            $this->db = new PDO(
                'mysql:host=' . $_ENV['db_host'] . ';dbname=' . $_ENV['db_name'],
                $_ENV['db_user'],
                $_ENV['db_pwd'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            // Arrête l'exécution du script en cas d'erreur de connexion
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    /**
     * Retourne l'instance PDO de la connexion à la base de données.
     * 
     * @return PDO L'instance PDO active pour la connexion.
     */
    protected function getConnection(): PDO
    {
        return $this->db;
    }
}
