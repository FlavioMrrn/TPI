<?php
// Projet: TPI eCommerce
// Script: Modèle DbConnection.php
// Description: contient classe et la méthode de connexion à la base de données.
// Auteur: Pascal Comminot
// Version 1.0.1 PC 20.02.2021 / Codage initial, adaptation du tuto de Stephane Rolland / Udemy

require_once 'config.php';


/**
 * Classe de connexion à la base de données, réalisée sous forme de singleton
 */
class DbConnection{
    private static $dbServer = DB_SERVER;
    private static $dbName = DB_NAME;
    private static $dbUser = DB_USER;
    private static $dbPwd = DB_PWD;
    private static $pdo = null;
    private static $myself = null;


    /**
     * Constructeur de la classe, crée l'objet PDO pour la connexion à la base
     */
    private function __construct(){
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        DbConnection::$pdo = new PDO("mysql:host=".self::$dbServer.";dbname=".self::$dbName, self::$dbUser, self::$dbPwd, $pdo_options);
        DbConnection::$pdo->exec('SET CHARACTER SET utf8');
    }


    /**
     * retourne l'objet de connexion à la base de données
     * @return PDO connecteur PDO pour accéder à la base de données
     */
    public static function getInstance() : PDO {
        if(self::$myself === null){
            self::$myself = new DbConnection();
        }
        return self::$pdo;
    }
}


