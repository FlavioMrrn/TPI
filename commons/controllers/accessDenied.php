<?php
// Projet: Application TPI
// Script: Contrôleur accessDenied
// Description: traite les tentatives d'accès à des actions avec des droits insuffisants
// Auteur: Pascal Comminot
// Version 1.0.0 PC 16.04.2021 / Codage initial


FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER,"Vous ne disposez pas de droits suffisants pour accéder à cette URL (uc=$uc / action=$action)");
header("HTTP/1.0 403 Access Denied");
header("Location:".Routes::PathTo('main','home'));
exit;
