<?php
// Projet: Association TPI
// Script: Contrôleur role
// Description: permet à l'utilisateur qui dispose de plusieurs rôles de changer de rôle
// Auteur: Pascal Comminot
// Version 1.0.0 PC 09.03.2021 / Codage initial


$erreurs = array();

if (filter_has_var(INPUT_GET,"role")) {
     // récupération des données provenant des données saisies par l'utilisateur
    
    $newRole = trim(filter_input(INPUT_GET,"role",FILTER_SANITIZE_STRING));
    
    if (in_array($newRole, Session::getRoles())){
        Session::setCurrentRole($newRole);
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_INFO,'Changement de rôle, vous êtes maintenant '.Session::getCurrentRole());
    } else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER,"Vous n'avez pas le droit de changer de rôle...");
    }

}

header("Location:".Routes::PathTo('main','home'));
