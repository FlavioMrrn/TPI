<?php
// Projet: Application TPI / User
// Script: Controller updateCategory.php
// Description: permet la modification d'une catégorie
// Auteur: Morrone Flavio
// Version 0.1.1 MF 12.05.2021 / Codage initial
require_once 'commons/views/Html.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$category = Category::findById($id);

if (filter_has_var(INPUT_POST, 'updateCat')) {
    $category = Category::findById($id);
    if ($category != null) {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $idParent = filter_input(INPUT_POST, 'idParent', FILTER_SANITIZE_STRING);
        if (!empty($title)) {
            if ($idParent == "") {
                $idParent = null;
            }
            $parent = Category::findById($idParent);
            if ($parent !== null || $idParent == null) {
                if ($id != $parent->getIdCategory()) {
                    if (!Category::hasCategoryChild($id, $parent->getIdCategory())) {
                        Category::updateCategory($id, $title, $description, $idParent);
                        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_SUCCESS, "La catégorie a été modifié.");
                        header("Location: " . Routes::PathTo('category', 'showCategory'));
                        exit;
                    } else {
                        FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, 'Vous ne pouvez pas mettre comme parent une catégorie enfant de celle-ci');
                    }
                } else {
                    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, 'Vous ne pouvze pas mettre elle même comme catégorie');
                }
            } else {
                FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Le parent d'existe pas.");
            }
        } else {
            FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Veuillez mettre au moin le titre.");
        }
    }
} else if ($category == null) {
    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, "Il n'y a pas de catégorie à modifier.");
    header("Location :" . Routes::PathTo('catogory', 'showCategory'));
    exit;
}


Html::showHtmlPage('Modifier une catégorie', 'uc/category/views/updatecategoryform.php', array('category' => $category));
