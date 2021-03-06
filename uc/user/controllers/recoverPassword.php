<?php
// Projet: Application TPI
// Script: Controller recoverPassword.php
// Description: permet la récupération de mot de passe d'un utilisateur
// Auteur: Morrone Flavio 
// Version 0.1.1 MF 05.05.2021 

require_once 'commons/views/Html.php';

$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

if (filter_input(INPUT_POST, "askRecover")) {
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    if (User::findByEmail($email) != false) {
        $token = User::generateToken();
        User::askRecover($email, $token);
        $message = "Bonjour, \r\nVous avez demandé de récupérer votre mot de passe. \r\nVeuillez cliquer sur ce lien afin de le changer: http://localhost/TPI/index.php?uc=user&action=recoverPassword&token=$token \r\nBonne continuation ! \r\nL'administration";
        mail($email, "Récupération du mot de passe", $message);
    }
    Log::addLog("Une demande de récupération de mot de passe à été effectué sur l'email $email");
    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Votre demande à été prise en compte. Vous avez 2h pour modifier votre mot de passe en cliquant sur le lien reçu par mail.");
    header("Location: " . Routes::PathTo("user", "login"));
    exit;
} else if (filter_input(INPUT_POST, "modifyPassword")) {
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);
    $confirmPassword = filter_input(INPUT_POST, "confirmPwd", FILTER_SANITIZE_STRING);
    $token = filter_input(INPUT_POST, "token", FILTER_SANITIZE_STRING);
    if ($password == $confirmPassword) {
        $user = User::findByEmail($email);
        if ($user !== false) {
            if (User::verifyRecoverTokenEmail($token, $email)) {
                $format = 'Y-m-d H:i:s';
                $now = new DateTime("NOW");
                $date = $user->getRecoveryDate();
                if ($date == null) {
                    $date = User::getRecoveryDateByEmail($email);
                }
                $validation = DateTime::createFromFormat($format, $date);
                //vérification de la date limite de validation
                if ($now < $validation) {
                    User::modifyPassword($email, $password);
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Le mot de passe à été modifié");
                    header("Location: " . Routes::PathTo("user", "login"));
                    exit;
                }
                else {
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Vous avez dépassé les 2h mises à dispositions, refaites une demande !");
                }
            }
            else {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Le token ne correspond pas avec l'email !");
            }
        }
        else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "L'utilisateur n'existe pas !");
        }
    }else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Les mots de passes ne correspondent pas");
    }
} else if (!empty($token)) {
    Html::showHtmlPage("Modifier le mot de passe", "uc/user/views/modifyPassword.php", array('token' => $token));
    exit;
}

Html::showHtmlPage("Récupérer le mot de passe", "uc/user/views/askRecoverPassword.php", array());