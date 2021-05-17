<?php
// Projet: Application TPI
// Script: Controlleur showLogs.php
// Description: permet l'affichage des logs pour l'administrateur
// Auteur: Morrone Flavio 
// Version 0.1.1 MF 06.05.2021 

require_once 'commons/views/Html.php';
$logs = Log::getAllLogs();

Html::showHtmlPage('Afficher les logs', 'uc/log/views/logtable.php', array('logs' => $logs));
