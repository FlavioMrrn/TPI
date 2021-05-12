<?php
// Projet: Association TPI
// Script: Contrôleur login.php
// Description: validation des données d'identification fournies par l'utilisateur
// Auteur: Pascal Comminot
//      Modifié par: Morrone Flavio
// Version 1.0.0 PC 02.10.2017 / Codage initial
// Version 1.0.1 PC 06.05.2021 / Ajout de la vérification du nombre d'essais


require_once 'commons/views/Html.php';

$errors = array();

if (filter_has_var(INPUT_POST, "submit")) {
    // récupération des données provenant des données saisies par l'utilisateur

    $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
    $pwd = trim(filter_input(INPUT_POST, "pwd"));

    // vérification des données saisies
    $user = User::checkUserIdentification($email, $pwd);
    if ($user == null) {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Identification ou mot de passe invalide");
        $currentTryNumber = Session::Get('currentTryNumber');
        if ($currentTryNumber >= 3) {
            Log::addLog("La connexion a echoué $currentTryNumber fois de suite sur le même poste avec l'email $email.");
        }
        Session::addTry($email, $currentTryNumber);
    } else {
        Session::Set('currentTryNumber', 0);
        Session::setUser($user);
        User::updateLastLogin($email);
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "Bienvenue, " . $user->getFullName());
        header("Location:" . Routes::PathTo('main', 'home'));
        exit;
    }
}

Html::showHtmlPage('Identification', 'uc/user/views/loginform.php', array('errors' => $errors));
