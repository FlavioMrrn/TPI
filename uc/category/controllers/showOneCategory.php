<?php
// Projet: Application TPI / User
// Script: Controlleur showOneCategory.php
// Description: permet l'affichage de tous les items pour une catégorie.
// Auteur: Morrone Flavio
// Version 0.1.1 MF 17.05.2021 / Codage initial

require_once 'commons/views/Html.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$category = Category::findById($id);
if ($category == null) {
    FlashMessage::AddMessage(FlashMessage::FLASH_RANKING_DANGER, 'La catégorie n\'existe pas.');
    header('Location ' . Routes::PathTo('category', 'showCategory'));
    exit;
}

Html::showHtmlPage($category->getTitle(), 'uc/category/views/showonecategory.php', array('category' => $category));

/**
 * Créé un tableau contenant, pour chaques catégories, toutes ses catégories mères
 * @param Category la catégorie à analyser
 * @return 
 */
function makeBreadCrumb($category)
{
    $result = [];
    $result[] = $category->getIdCategory();
    if ($category->getIdParent() != null) {
        $c = Category::findById($category->getIdParent());
        $result[] = makeBreadCrumb($c);
    }
    return $result;
}

/**
 * Permet de créer la ligne d'arianne avec un tableau de catégory
 * @param array le tableau avec les catégories mères
 * @return string 
 */
function buildBreadCrumb($bc)
{
    $result = '';
    if (isset($bc[1])) {
        $result .= buildBreadCrumb($bc[1]);
    }
    $id = $bc[0];
    $category = Category::findById($id);
    $result .= '<li class="breadcrumb-item"><a href="' . Routes::PathTo('category', 'showOneCategory') . '&id=' . $category->getIdCategory() . '">' . $category->getTitle() . '</a></li>';
    return $result;
}
