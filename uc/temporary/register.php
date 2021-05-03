

    <?php
    // Projet: Application TPI / temporary
    // Script: Routeur register.php
    // Description: définit les routes du Use Case temporary, ainsi que les options correspondantes affichées dans le menu
    // Auteur: Pascal Comminot
    // Version 1.0.0 PC 01.05.2021 / Codage initial
    
    
    
    if (Session::getUser()->hasCurrentRole(User::USER_ROLE_PRODUCT_MANAGER)) {
        // Cette partie ne concerne que le PRODUCT_MANAGER
        Routes::addRoute('temporary', 'list', 'uc/temporary/controllers/list.php');
        Routes::addRoute('temporary', 'command', 'uc/temporary/controllers/command.php');
    
        $menuDico = new Menu("TEMPORAIRE", null, true, Menu::MENU_MAIN_MENU_LEFT);
        $menuDico->AddItem(new Menu("Simuler un arrivage de produits", Routes::PathTo('temporary','list')));
    
    }
    