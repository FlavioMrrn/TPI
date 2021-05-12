<?php
if (filter_has_var(INPUT_POST, 'deleteCategory')) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (Category::findById($id) != null) {
        if (!Category::hasChild($id)) {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "La catégorie à bien été supprimé.");
        } else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Il est impossible de supprimer cette catégorie.");
        }
    } else {
        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "La catégorie est introuvable.");
    }
}
header("Location: " . Routes::PathTo('category', 'showCategory'));