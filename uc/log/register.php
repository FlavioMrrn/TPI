<?php
// Projet: Application TPI / User
// Script: Routeur register.php
// Description: définit les routes du Use Case Log
// Auteur: Morrone Flavio
// Version 0.1.1 MF 03.06.2021 / Codage initial

if (Session::getUser()->hasCurrentRole('WebManager')) {
    Routes::AddRoute('log', 'showLogs', 'uc/log/controllers/showLogs.php');
    $menu = new Menu('Logs',  Routes::PathTo('log', 'showLogs'), true, Menu::MENU_MAIN_MENU_LEFT);
}
else {
    Routes::addRoute('log', 'showLogs', 'commons/controllers/accessDenied.php');
}
