<?php
// Projet: Application TPI
// Script: Contrôleur home.php
// Description: affiche la page d'accueil du site. Essentiellement statique
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2020 / Codage initial

require_once 'commons/views/Html.php';
Html::showHtmlPage('Accueil','commons/views/home.php',array());
