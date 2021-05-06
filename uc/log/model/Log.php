<?php
// Projet: Application TPI
// Script: Modèle Log.php
// Description: contient la classe log et les méthodes en lien avec la table logs 
// Auteur: Morrone Flavio 
// Version 0.1.1 MF 06.05.2021 

require_once 'commons/model/DbConnection.php';


class Log
{
    /**
     * @var int
     */
    private $idLog;
    /**
     * @var string
     */
    private $message;
    /**
     * @var string
     */
    private $date;

    /**
     * get retourne l'id de la log
     *
     * @return ?int L'id peut être null, dans le cas de la création d'un nouvel enregistrement.
     */
    public function getIdLog(): ?int
    {
        return $this->idLog;
    }

    /**
     * get retourne le message
     *
     * @return ?int L'id peut être null, dans le cas de la création d'un nouvel enregistrement.
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * get retourne l'id de la log
     *
     * @return ?int L'id peut être null, dans le cas de la création d'un nouvel enregistrement.
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * setIdLog permet de définir l'id de la Log... 
     * Cette méthode ne devrait jamais être utilisée, dans la mesure où c'est la base de donnée qui définit l'id...
     * L'id peut être null, ce qui permet de créer un nouvel enregistrement lors de la sauvegarde dans la base de données
     *
     * @param  ?int $idLog
     * @return self
     */
    public function setIdLog(?int $idLog): self
    {
        $this->idLog = $idLog;
        return $this;
    }


    /**
     * setMessage permet de modifier le message de la Log
     *
     * @param  ?string $message
     * @return self
     */
    public function setMessage(?int $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * setDate permet de modifier la date de la Log
     *
     * @param  ?DateTime $date
     * @return self
     */
    public function setDate(?DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Récupère toutes les logs de la base de données
     * @return array Un tablea de valeur de type Log
     */
    public static function getAllLogs(): array
    {
        $sql = "SELECT * FROM logs";
        $req = DbConnection::getInstance()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, 'Log');
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * Ajoute une nouvelle Log dans la base de données
     * @param string le message à ajouter
     * @return void
     */
    public static function addLog(string $message): void
    {
        $date =  date_format(new DateTime("NOW"), 'Y-m-d H:i:s');
        $sql = "INSERT INTO `ecommerce`.`logs` (`date`, `message`) VALUES (:date, :message);";
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(':date', $date);
        $req->bindParam(':message', $message);
        $req->execute();
    }
}
