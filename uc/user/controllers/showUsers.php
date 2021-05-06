<?php
// Projet: Application TPI / User
// Script: Controller controllers/profil.php
// Description: script d'affichage des informations de l'utilisateur avec modification possible
// Auteur: Morrone Flavio
// Version 0.1.1 MF 05.05.2021
require_once 'commons/views/Html.php';
$users = User::findAll();

Html::showHtmlPage("Utilisateurs", 'uc/user/views/userstable.php', array('users' => $users));