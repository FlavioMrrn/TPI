<?php
// Projet: Application TPI
// Script: FlashMessage.php
// Description: Gestion de messages flash affichés une seule fois dans les pages
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.02.2021 / Codage initial


class FlashMessage
{
    public const FLASH_SIGNATURE = 'FlashMessages';
    public const FLASH_RANKING_SUCCESS = 'success';
    public const FLASH_RANKING_DANGER = 'danger';
    public const FLASH_RANKING_WARNING = 'warning';
    public const FLASH_RANKING_INFO = 'info';


    private $message;
    private $ranking;
    
    /**
     * __construct Constructeur de message Flash
     *
     * @param  mixed $ranking
     * @param  mixed $message
     * @return void
     */
    public function __construct(string $ranking, string $message){
        $this->message = $message;
        $this->ranking = $ranking;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getRanking(): string
    {
        return $this->ranking;
    }

    public function setRanking(string $ranking)
    {
        if (in_array($ranking,[FlashMessage::FLASH_RANKING_SUCCESS,
            FlashMessage::FLASH_RANKING_DANGER,
            FlashMessage::FLASH_RANKING_WARNING,
            FlashMessage::FLASH_RANKING_INFO])) {
            $this->ranking = $ranking;
        } else {
            $this->ranking = FlashMessage::FLASH_RANKING_INFO;
        }
    }



    /**
     * Définit un message flash
     * @param string $msg Le message à conserver
     */
    public static function AddMessage(string $ranking, string $message) {
        $msg = new FlashMessage($ranking,$message);
        if (is_array($_SESSION[FlashMessage::FLASH_SIGNATURE])){
            $_SESSION[FlashMessage::FLASH_SIGNATURE][] = $msg; 
        } else {
            $_SESSION[FlashMessage::FLASH_SIGNATURE] = [$msg]; 
        }
    }
    
    /**
     * Récupère les éventuels messages flash, et les supprime de la session
     * @return array of strings les messages flash
     */
    public static function GetAllMessages() : array {
        $messages = empty($_SESSION[FlashMessage::FLASH_SIGNATURE]) ? array() : $_SESSION[FlashMessage::FLASH_SIGNATURE];
        $_SESSION[FlashMessage::FLASH_SIGNATURE] = array();
        return $messages;
    }
    
}
