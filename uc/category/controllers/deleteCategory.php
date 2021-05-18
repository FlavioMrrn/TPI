<?php
// Projet: Application TPI 
// Script: Controller deleteCategory.php
// Description: script réalisant la suppression d'une catégorie
// Auteur: Morrone Flavio
// Version 0.1.1 MF 12.05.2021

if (filter_has_var(INPUT_POST, 'deleteCategory')) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (Category::findById($id) != null) {
        if (!Category::hasChild($id)) {
            $count = Category::CountItems($id);
            if ($count[0] <= 0) {
                Category::deleteNotPublishedItems($id);
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "La catégorie à bien été supprimé.");
                Category::deleteCategory($id);
            }
            
        } else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Il est impossible de supprimer cette catégorie.");
        }
    } else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "La catégorie est introuvable.");
    }
}
header("Location: " . Routes::PathTo('category', 'showCategory'));