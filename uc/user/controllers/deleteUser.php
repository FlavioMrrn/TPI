<?php
// Projet: Application TPI / User
// Script: Controller controllers/deleteUser.php
// Description: script d'affichage des informations de l'utilisateur avec modification possible
// Auteur: Morrone Flavio
// Version 0.1.1 MF 05.05.2021

require_once 'commons/views/Html.php';
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$user = User::findById($id);
if ($user === null) {
    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "L'utilisateur n'existe pas.");
    header("Location: " . Routes::PathTo('user', 'showUsers'));
    exit;
} else {
    $date = new DateTime("NOW");
    $lastYear = $date->modify('-1 year');
    $validateDate = $user->getValidationDate();
    $validateDate = DateTime::createFromFormat('Y-m-d H:i:s', $validateDate);
    $lastConnection = strtotime('Y-m-d H:i:s', $user->getLastConnection());
    $countCommands = User::countCommands($user->getIdUser());
    if ($validateDate !== false) {
        if ($validateDate < $date && $user->hasRole(User::USER_ROLE_NOT_VERIFIED)) {
            User::deleteUser($user->getIdUser());
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Le compte " . $user->getEmail() . " à bien été supprimé.");
        } else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "L'utilisateur ne peut pas être supprimé.");
        }
    } else if ($countCommands <=  0 && ($lastConnection > $lastYear || $lastConnection === false)) {
        User::deleteUser($user->getIdUser());
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Le compte " . $user->getEmail() . " à bien été supprimé.");
    } else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "L'utilisateur ne peut pas être supprimé.");
    }
}

header("Location: " . Routes::PathTo('user', 'showUsers'));
exit;
