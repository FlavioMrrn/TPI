<?php
// Projet: Application TPI / temporary
// Script: Contrôleur list
// Description: affiche la liste des produits à notre catalgue afin que l'on puisse les commander auprès de nos fournisseurs
// Auteur: Pascal Comminot
// Version 1.0.0 PC 01.05.2021 / Codage initial

require_once 'uc/temporary/model/Simulation.php';
require_once 'commons/views/Html.php';

$items = Simulation::getAllItems();


Html::showHtmlPage('Commande auprès des fournisseurs',"uc/temporary/views/showItems.php",array('items'=>$items));