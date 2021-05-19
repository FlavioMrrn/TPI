<?php
// Projet: Application TPI / User
// Script: Controller controllers/profil.php
// Description: script d'affichage des informations de l'utilisateur avec modification possible
// Auteur: Morrone Flavio
// Version 0.1.1 MF 05.05.2021

require_once 'commons/views/Html.php';


if (filter_input(INPUT_POST, 'updateProfil')) {
    if (!Session::getUser()->hasRole(array(User::USER_ROLE_NOT_VERIFIED, User::USER_ROLE_BANNED, User::USER_ROLE_ANONYMOUS))) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING);
        $newpassword = filter_input(INPUT_POST, 'newpwd', FILTER_SANITIZE_STRING);
        $confirm = filter_input(INPUT_POST, 'confirmnewpwd', FILTER_SANITIZE_STRING);

        if (!empty($email) && !empty($name) && !empty($firstname) && !empty($address)) {
            if ($email == Session::getUser()->getEmail() || User::findByEmail($email) == null) {
                if ($email != Session::getUser()->getEmail()) {
                    $token = User::generateToken();
                    //envoyer un mail
                    $message = "Bonjour,\r\n\r\nVous avez fait une demande de changement d'email.\r\n\r\nVeuillez valider votre email en cliquant sur ce lien: http://localhost/TPI/index.php?uc=user&action=modifyEmail&token=$token\r\n\r\n Bonne continuation !\r\n\r\nL'administration";
                    mail(Session::getUser()->getEmail(), "Changement d'email", $message);
                    User::askModifyEmail(Session::getUser()->getEmail(), $token);
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_INFO, "Un mail vous à été envoyé pour vérifier votre email.");
                }
                if (!empty($password)) {
                    if (!empty($newpassword)) {
                        if (User::checkUserIdentification(Session::getUser()->getEmail(), $password)) {
                            if ($newpassword == $confirm) {
                                User::updateProfilWithPassword($name, $firstname, $address, implode(',', Session::getUser()->getStatus()), $newpassword, Session::getUser()->getIdUser());
                                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, 'Le profil ainsi que le mot de passe ont été mis a jour.');
                            } else {
                                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Les mots de passes ne sont pas identiques.");
                            }
                        } else {
                            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Le mot de passe actuel n'est pas correct");
                        }
                    } else {
                        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Veuillez rentrez toutes les données.");
                    }
                }
                if (empty($password) && (!empty($newpassword) || !empty($confirm))) {
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Pour modifier le mot de passe entrez le mot de passe actuel ainsi que deux fois le nouveau");
                }

                if (empty($password) && empty($newpassword) && empty($confirm)) {
                    User::updateProfil($name, $firstname, $address, implode(',', Session::getUser()->getStatus()), Session::getUser()->getIdUser());
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Votre profil à été modifié.");
                }

                Session::setUser(User::findById(Session::getUser()->getIdUser()));
            } else {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "L'email est déjà utilisé.");
            }
        }
    } else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_WARNING, "Vous devez vérifier votre compte avant de modifier vos données.");
    }
}

Html::showHtmlPage('Profil', 'uc/user/views/profil.php', array());
