<?php
// Projet: Application TPI 
// Script: Controlleur showCategory.php
// Description: script réalisant l'affichage de toutes les catégories
// Auteur: Morrone Flavio
// Version 0.1.1 MF 12.05.2021
require_once 'commons/views/Html.php';

$categories = Category::getAllCategories();

Html::showHtmlPage("Catégories", 'uc/category/views/categoriestable.php', array('categories' => $categories));