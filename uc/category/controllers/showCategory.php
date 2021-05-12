<?php
require_once 'commons/views/Html.php';

$categories = Category::getAllCategories();

Html::showHtmlPage("Catégories", 'uc/category/views/categoriestable.php', array('categories' => $categories));