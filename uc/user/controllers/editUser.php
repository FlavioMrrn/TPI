<?php
require_once 'commons/views/Html.php';

$user = null;

const USER_UPDATE_ID = "UpdateId";

if (filter_has_var(INPUT_POST, 'edit')) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $user = User::findById($id);
    if ($user !== null) {
        Session::Set(USER_UPDATE_ID, $id);
    } else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, 'Une erreur est survenue.');
        header("Location: " . Routes::PathTo('user', 'showUsers'));
        exit;
    }
}

if (filter_has_var(INPUT_POST, 'update')) {
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
    $address = trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING));
    $pwd = trim(filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING));

    $user = User::findById(Session::Get(USER_UPDATE_ID));

    if (!empty($email) && !empty($name) && !empty($firstname) && !empty($address)) {
        if (empty($pwd)) {
            User::updateProfil($name, $firstname, $address, $user->getIdUser());
        } else {
            User::updateProfilWithPassword($name, $firstname, $address, $pwd, $user->getIdUser());
        }
        if ($user->getEmail() !== $email) {
            User::updateEmail($user->getEmail(), $email);
            $message = "Bonjour, \r\n Votre comte à été modifié par un admin. \r\n  Votre nouvel email pour vous connecter est $email. \r\n Bonne continuation ! \r\n L'administration";
            mail($user->getEmail(), "Changement d'email", $message);
            $message = "Bonjour, \r\n Votre comte à été modifié par un admin. \r\n  Voici le nouvel email de votre compte. \r\n Bonne continuation ! \r\n L'administration";
            mail($email, "Changement d'email", $message);
        } else {
            $message = "Bonjour, \r\n Votre comte à été modifié par un admin. \r\n  \r\n Bonne continuation ! \r\n L'administration";
            mail($email, "Récupération du mot de passe", $message);
        }

        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Le compte à correctement été modifié.");
        header("Location: " . Routes::PathTo('user', 'showUsers'));
        exit;
    }
}
Html::showHtmlPage('Modifier', 'uc/user/views/updateuserform.php', array('user' => $user));
