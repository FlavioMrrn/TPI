<?php
// Projet: Application TPI / User
// Script: Controller controllers/deleteUser.php
// Description: script d'affichage des informations de l'utilisateur avec modification possible
// Auteur: Morrone Flavio
// Version 0.1.1 MF 05.05.2021
require_once 'commons/views/Html.php';
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$user = User::findById($id);
if ($user === false) {
    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "L'utilisateur n'existe pas.");
    header("Location: ". Routes::PathTo('user', 'showUsers'));
    exit;
}
else {
    //delete user
}