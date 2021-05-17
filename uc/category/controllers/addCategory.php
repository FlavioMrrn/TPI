<?php
// Projet: Application TPI 
// Script: Controlleur addCategory.php
// Description: script réalisant l'enregistrement d'une catégorie
// Auteur: Morrone Flavio
// Version 0.1.1 MF 12.05.2021

require_once 'commons/views/Html.php';

//si une requête d'enregistrement est effecuté
if (filter_has_var(INPUT_POST, "addCategory")) {
    //récupération et filtrage des données
    $title = trim(filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING));
    $description = trim(filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING));
    $idParent = trim(filter_input(INPUT_POST, "idParent", FILTER_VALIDATE_INT));

    if ($idParent == "") {
        $idParent = null;
    }
    if (!empty($title)) {
        if (Category::findById($idParent) !== null || $idParent == null) {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "La catégorie à bien été ajouté.");
            Category::addCategory($title, $description, $idParent);
            header("Location: ".Routes::PathTo('category', 'showCategory'));
            exit;
        } else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Vous devez au moin completer le titre.");
        }
    }
}
Html::showHtmlPage('Ajouter une Categorie', 'uc/category/views/addcategoryform.php', array());
