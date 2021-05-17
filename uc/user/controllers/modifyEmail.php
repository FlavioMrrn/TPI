<?php
// Projet: Application TPI
// Script: Controlleur modifyEmail.php
// Description: permet la modification de l'email d'un utilisateur
// Auteur: Morrone Flavio 
// Version 0.1.1 MF 05.05.2021 

require_once 'commons/views/Html.php';
$token = filter_input(INPUT_GET, 'token');

if (filter_input(INPUT_POST, 'modifyEmail')) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $newemail = filter_input(INPUT_POST, 'newemail', FILTER_SANITIZE_EMAIL);
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($newemail)) {
        if (!($email == $newemail)) {
            if (User::verifyValidationTokenEmail($token, $email)) {
                User::updateEmail($email, $newemail);
                $message = "Bonjour, \r\n \r\n Votre email à correctement été modifié. \r\n \r\n Vous devez-donc maintenant vous connecter avec cet email.\r\n \r\n Bonne continuation ! \r\n \r\n L'administration";
                mail($newemail, "Changement d'email", $message);
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Votre email à bien été changé.");
                Session::setUser(User::findById(Session::getUser()->getIdUser()));
                header("Location: " . Routes::PathTo("main", "home"));
                exit;
            } else {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Le token et l'email ne correspondent pas.");
            }
        } else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Les deux mails sont identiques.");
        }
    } else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Veuillez completer tous les champs");
    }
}

Html::showHtmlPage("Modifier l'email", 'uc/user/views/modifyEmail.php', array('token' => $token));
