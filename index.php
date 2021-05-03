<?php
// Projet: Application TPI
// Script: Contrôleur Principal index.php
// Description: Gère les actions à réaliser et dispatche dans les contrôleurs secondaires 
// Auteur: Pascal Comminot 
// Version 1.0.0 PC 02.10.2020 / Codage initial

// Chargement des classes qui utilisent la session
require_once 'uc/user/model/User.php';
require_once 'commons/model/FlashMessage.php';
require_once 'commons/model/Session.php';
Session::start();

// Chargement des classes liées au routage
require_once 'commons/model/Menu.php';
require_once 'commons/controllers/Routes.php';
// il existe au moins une route par défaut...
Routes::addRoute('main', 'home', 'commons/controllers/home.php');

// Enregistrement des divers Use Cases 
require_once 'uc/user/register.php';
require_once 'uc/temporary/register.php';


// récupération des paramètres de routage
$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_URL);
if (empty($action)) {
    $action = 'home';
}

$uc = filter_input(INPUT_GET, "uc", FILTER_SANITIZE_URL);
if (empty($uc)) {
    $uc = 'main';
}


try {
    $path = Routes::findRoute($uc, $action);
    if ($path === FALSE) {
        // le chemin demandé n'a pas été trouvé. La réponse standard est une page 404
        require_once "commons/views/Html.php";
        header("HTTP/1.0 404 Not Found");
        Html::showHtmlPage('Page non trouvée', 'commons/views/404.php', array());
        exit();
    } else {
        require_once $path;
    }
} catch (Exception $e) {
    // une erreur inattendue s'est produite. La réponse standard est une page 500
    require_once 'commons/views/Html.php';

    Html::showHtmlPage("Erreur interne du serveur", "commons/views/500.php", array('e' => $e));
}
