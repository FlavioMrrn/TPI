<?php
// Projet: Application TPI 
// Script: Controller register.php
// Description: script réalisant l'enregistrement d'un user
// Auteur: Morrone Flavio
// Version 0.1.1 MF 03.05.2021

require_once 'commons/views/Html.php';

//si une requête d'enregistrement est effecuté
if (filter_has_var(INPUT_POST, "addUser")) {
    //récupération et filtrage des données
    $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
    $name = trim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING));
    $firstname = trim(filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING));
    $address = trim(filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING));
    $confirmpassword = trim(filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING));
    $password = trim(filter_input(INPUT_POST, "confirmpwd", FILTER_SANITIZE_STRING));

    if (!empty($email) && !empty($name) && !empty($firstname) && !empty($confirmpassword) && !empty($password) && !empty($address)) {
        //vérification de l'existance de l'utilisateur
        if (User::findByEmail($email) == null) {
            if ($password == $confirmpassword) {
                $password = User::hashPassword($password);
                try {
                    $status = 'Customer';
                    User::register($name, $firstname, $email, $password, $address, $status, null, null);
                    $message = "Bonjour, \r\n \r\n Votre compte à été créé par un administrateur. \r\n \r\n Vous pouvez dès à présent vous connecter avec cet email.\r\n \r\n Si vous ne connaissez pas le mot de passe faite une demande de réinitialisation. \r\n \r\n L'administration";
                    mail($email, "Validation de votre compte", $message);
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "L'utilisateur à été enregistré avec succès.");
                } catch (\Throwable $th) {
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Une erreure est survenue lors de la création de l'utilisateur, veuillez reessayer plus tard.");
                }
            } else {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Les mots de passes ne sont pas identiques !");
            }
        } else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "L'email est déjà utilisé !");
        }
    } else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Vous n'avez pas complété tous les champs !");
    }
}
Html::showHtmlPage('Ajouter un utilisateur', 'uc/user/views/adduserform.php', array());