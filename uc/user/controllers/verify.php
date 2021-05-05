<?php
// Projet: Application TPI / User
// Script: Routeur verify.php
// Description: script de vérification de l'email
// Auteur: Morrone Flavio
// Version 0.1.1 MF 03.05.2021

require_once 'commons/views/Html.php';
$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

//si la requête de vérification est executé
if (filter_input(INPUT_POST, "verify")) {
    //récupération des données / filtrage
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $token = filter_input(INPUT_POST, "token", FILTER_SANITIZE_STRING);
    if (!empty($email) && !empty($token)) {
        //vérification de la compatibilité
        if (User::verifyValidationTokenEmail($token, $email)) {
            $now = new DateTime("NOW");
            $date = User::getValidationDate($email);
            $format = 'Y-m-d H:i:s';
            $validation = DateTime::createFromFormat($format, $date);
            //vérification de la date limite de validation
            if ($now < $validation) {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Félicitation, votre compte à été validé !");
                User::validateAccount($email);
                Session::setUser(User::findById(Session::getUser()->getIdUser()));
                header("Location: " . Routes::PathTo("main", "home"));
                exit();
            } else {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Votre date limite de validation à expiré !");
            }
        } else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Le token et l'email ne correspondent pas !");
        }
    }
}

Html::showHtmlPage("Valider", "uc/user/views/verifyform.php", array("token" => $token));
