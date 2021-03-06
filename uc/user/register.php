<?php
// Projet: Application TPI / User
// Script: Routeur register.php
// Description: définit les routes du Use Case User
// Cette version fournit le strict minimum pour permettre aux candidats qui ne s'occupent pas de la gestion des utilisateurs
// d'avoir les fonctionnalités minimales pour faire leur partie.
// Auteur: Pascal Comminot
//       Modifié par : Morrone Flavio
// Version 1.0.0 PC 09.03.2021 / Codage initial
// Version 1.0.1 PC 22.04.2021 / Ajout de la gestion dynamique du menu utilisateur
// Version 1.0.2 PC 05.01.2021 / Correction de bug lié au changement de rôle (nouveau rôle absent dans le lien)
// Version 1.0.3 MF 03.05.2021 / Modification de la création des routes selon les utilisateurs - Création de la route register ainsi que du menu

if (Session::getUser()->isAnonymous()) {
    Routes::addRoute('user', 'login', 'uc/user/controllers/login.php');
    Routes::addRoute('user', 'register', 'uc/user/controllers/register.php');
    Routes::addRoute('user', 'logout', 'commons/controllers/accessDenied.php');
    Routes::addRoute('user', 'profil', 'commons/controllers/accessDenied.php');
} else {
    Routes::addRoute('user', 'login', 'commons/controllers/accessDenied.php');
    Routes::addRoute('user', 'register', 'commons/controllers/accessDenied.php');
    Routes::addRoute('user', 'logout', 'uc/user/controllers/logout.php');
    Routes::addRoute('user', 'profil', 'uc/user/controllers/profil.php');
}

if (Session::getUser()->hasCurrentRole(User::USER_ROLE_WEB_MANAGER)) {
    $menu = new Menu('Utilisateurs', null, true, Menu::MENU_MAIN_MENU_LEFT);
    Routes::AddRoute('user', 'showUsers', 'uc/user/controllers/showUsers.php');
    Routes::AddRoute('user', 'deleteUser', 'uc/user/controllers/deleteUser.php');
    Routes::AddRoute('user', 'editUser', 'uc/user/controllers/editUser.php');
    Routes::AddRoute('user', 'addUser', 'uc/user/controllers/addUser.php');
    $menu->AddItem(new Menu("Ajouter un utilisateur", Routes::PathTo('user', 'addUser'), true));
    $menu->AddItem(new Menu('Afficher les utilisateurs', Routes::PathTo('user', 'showUsers'), true));
} else {
    Routes::AddRoute('user', 'showUsers', 'commons/controllers/accessDenied.php');
    Routes::AddRoute('user', 'deleteUser', 'commons/controllers/accessDenied.php');
    Routes::AddRoute('user', 'addUser', 'commons/controllers/accessDenied.php');
    Routes::AddRoute('user', 'editUser', 'commons/controllers/accessDenied.php');
}

Routes::AddRoute("user", "modifyEmail", 'uc/user/controllers/modifyEmail.php');
Routes::addRoute('user', 'verify', 'uc/user/controllers/verify.php');
Routes::addRoute('user', 'recoverPassword', 'uc/user/controllers/recoverPassword.php');

if (Session::getUser()->hasRole([User::USER_ROLE_ANONYMOUS, User::USER_ROLE_BANNED, User::USER_ROLE_NOT_VERIFIED, User::USER_ROLE_UNDEFINED])) {
    Routes::addRoute('user', 'changeRole', 'commons/controllers/accessDenied.php');
} else {
    Routes::addRoute('user', 'changeRole', 'uc/user/controllers/role.php');
}

$currentRole = Session::getCurrentRole();
if ($currentRole == User::USER_ROLE_ANONYMOUS) {
    $menuUser = new Menu("Connexion", Routes::PathTo('user', 'login'), true, Menu::MENU_MAIN_MENU_RIGHT);
    $menuUser = new Menu("S'enregistrer", Routes::PathTo('user', 'register'), true, Menu::MENU_MAIN_MENU_RIGHT);
} else {
    $menuUser = new Menu(Session::getUser()->getFullName(), null, true, Menu::MENU_MAIN_MENU_RIGHT);
    if ($currentRole == User::USER_ROLE_BANNED) {
        $menuUser->AddItem((new Menu(User::USER_ROLE_BANNED, null, false))->SetBgColor(Menu::MENU_BG_COLOR_DANGER));
    } else {
        foreach (Session::getRoles() as $r) {
            if ($r == $currentRole) {
                $menuUser->AddItem((new Menu($r, null, false))->SetBgColor(Menu::MENU_BG_COLOR_PRIMARY));
            } else {
                $menuUser->AddItem(new Menu($r, Routes::PathTo('user', 'changeRole') . "&role=$r"));
            }
        }
    }

    $menuUser->AddDivider();
    $menuUser->AddItem(new Menu('Profil', Routes::PathTo('user', 'profil', false)));
    $menuUser->AddItem(new Menu('Déconnexion', Routes::PathTo('user', 'logout')));
}
