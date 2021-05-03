<?php
// Projet: Application TPI
// Script: Contrôleur logout.php
// Description: déconnexion de l'utilisateur
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2017 / Codage initial


$user = Session::getUser();
Session::forgetUser();

FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_INFO,"Au revoir, ".$user->getFullName().", vous avez été déconnecté");
header("Location:".Routes::PathTo('main','home'));
exit;
