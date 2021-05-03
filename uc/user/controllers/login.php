<?php
// Projet: Association TPI
// Script: Contrôleur login.php
// Description: validation des données d'identification fournies par l'utilisateur
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2017 / Codage initial


require_once 'commons/views/Html.php';

$errors = array();

if (filter_has_var(INPUT_POST,"submit")) {
     // récupération des données provenant des données saisies par l'utilisateur
    
    $email = trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL));
    $pwd = trim(filter_input(INPUT_POST,"pwd"));
    
    // vérification des données saisies
    $user = User::checkUserIdentification($email, $pwd);
    if (empty($user)) {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER,"Identification ou mot de passe invalide");
    } else {
        Session::setUser($user);
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS,"Bienvenue, ".$user->getFullName());
        header("Location:".Routes::PathTo('main','home'));
        exit;
    }
}

Html::showHtmlPage('Identification','uc/user/views/loginform.php',array('errors'=>$errors));