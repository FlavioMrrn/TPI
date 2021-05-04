<?php
// Projet: Application TPI 
// Script: script register.php
// Description: script réalisant l'enregistrement d'un user
// Auteur: Morrone Flavio
// Version 0.1.1 MF 03.05.2021

require_once 'commons/views/Html.php';

//si une requête d'enregistrement est effecuté
if (filter_has_var(INPUT_POST, "register")) {
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
                $status = 'NotVerified';
                $token = user::generateToken();
                $validationDate = new DateTime('NOW');
                $validationDate->modify('+1 day');
                if (User::countUsers() == 0) {
                    $status = 'WebManager';
                }
                try {
                    if ($status == 'WebManager') {
                        User::register($name, $firstname, $email, $password, $address, $status, null, null);
                        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Votre compte à bien été crée. Vous êtes WebManager sur le site !");
                    } else {
                        User::register($name, $firstname, $email, $password, $address, $status, date_format($validationDate, 'Y-m-d H:i:s'), $token);
                        $message = "Bonjour,
    
     Merci pour votre inscription à notre site.
    
     Veuillez valider votre email en cliquant sur ce lien: http://localhost/TPI/index.php?uc=user&action=verify&token=$token
    
     Bonne continuation !
    
     L'administration";

                        mail($email, "Validation de votre compte", $message);
                        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "L'utilisateur à été enregistré avec succès. Un mail va vous être envoyé pour valider votre email.");
                    }

                    header("Location: " . Routes::PathTo('user', 'login'));
                    exit();
                    
                } catch (\Throwable $th) {
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Une erreure est survenue lors de la création de l'utilisateur, veuillez reessayer plus tard.");
                }
            } else {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Les mots de passes ne sont pas identiques !");
            }
        } else {
            header("Location: " . Routes::PathTo('user', 'login'));
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "L'email est déjà utilisé !");
            exit();
        }
    } else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Vous n'avez pas complété tous les champs !");
    }
}

Html::showHtmlPage('Enregistrement', 'uc/user/views/registerform.php', array());
