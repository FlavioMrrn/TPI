<?php
// Projet: Application TPI / User
// Script: Routeur register.php
// Description: définit les routes du Use Case Category
// Auteur: Morrone Flavio
// Version 0.1.1 MF 10.05.2021 / Codage initial

Routes::AddRoute('category', 'showCategory', 'uc/category/controllers/showCategory.php');
$menu = new Menu('Categories', null, true, Menu::MENU_MAIN_MENU_LEFT);
$menu->AddItem(new Menu("Afficher les categories", Routes::PathTo('category', 'showCategory'), true, Menu::MENU_STANDARD_ITEM));

if (Session::getUser()->hasCurrentRole(User::USER_ROLE_WEB_MANAGER)) {
    Routes::AddRoute('category', 'addCategory', 'uc/category/controllers/addCategory.php');
    Routes::AddRoute('category', 'updateCategory', 'uc/category/controllers/updateCategory.php');
    Routes::AddRoute('category', 'deleteCategory', 'uc/category/controllers/deleteCategory.php');
    $menu->AddItem(new Menu("Ajouter une catégorie", Routes::PathTo('category', 'addCategory')));
}
else {
    Routes::AddRoute('category', 'addCategory', 'commons/controllers/accessDenied.php');
    Routes::AddRoute('category', 'updateCategory', 'commons/controllers/accessDenied.php');
    Routes::AddRoute('category', 'deleteCategory', 'commons/controllers/accessDenied.php');
}
$menu->AddDivider();


$categories = Category::getAllCategories();

$array = Category::buildArrayWithChild($categories);
showMenu($array, $menu);


function showMenu($array, &$menu)
{
    foreach ($array as $c) {
      $item = new Menu($c->getTitle(), Routes::PathTo('category', 'showOneCategory').'&id='.$c->getIdCategory(), true, Menu::MENU_STANDARD_ITEM);
      $menu->AddItem($item);
      if ($c->children != array()) {
          showMenu($c->children, $item);
      }
    }
}
