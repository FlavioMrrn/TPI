<?php
// Projet: Application TPI / User
// Script: Controlleur controllers/profil.php
// Description: script d'affichage des informations de l'utilisateur avec modification possible
// Auteur: Morrone Flavio
// Version 0.1.1 MF 05.05.2021
require_once 'commons/views/Html.php';

const USER_SEARCH_QUERY = "UserSearchQuery";
const PAGE_SIZE =  10;

$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
if (empty($page)) {
    $page = 1;
}

$word = filter_input(INPUT_POST, 'word', FILTER_SANITIZE_STRING);
if (is_null($word)) {
    $word = Session::get(USER_SEARCH_QUERY);
} else {
    Session::set(USER_SEARCH_QUERY, $word);
}

$count = User::SearchCount($word);
$users = User::SearchUser($word, PAGE_SIZE * ($page - 1), PAGE_SIZE);

$pages = array();
for ($i = 1; $i <= ceil($count / PAGE_SIZE); $i++) {
    $pages[$i] = Routes::PathTo("user", "showUsers") . "&page=$i";
}


Html::showHtmlPage("Utilisateurs", 'uc/user/views/userstable.php', array(
    'users' => $users,
    'pages' => $pages,
    'page' => $page,
    'word' => $word,
    'count' => $count
));
