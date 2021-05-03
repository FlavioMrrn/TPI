<?php
// Projet: Application TPI
// Script: Classe Html
// Description: Classe statique fournissant les méthodes pour afficher 
// les pages HTML du site
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2020 / Codage initial
// Version 1.0.1 PC 22.04.2021 / Ajout de la gestion dynamique du menu utilisateur

class Html
{

    /**
     * showHtmlPage affiche une page HTML avec le contenu passé en paramètre
     *
     * @param  mixed $pageTitle string|null titre de la page
     * @param  string $htmlContent chemin d'accès au script du contenu de la page
     * @param  array $params données fournies à la page. Toutes les variables PHP utilisées
     *      dans le script $htmlContent doivent être passées par ce tableau
     * @return void
     */
    public static function showHtmlPage(?string $pageTitle, string $htmlContent, array $params)
    {
        extract($params);
        include "commons/views/header.php";
        include $htmlContent;
        include "commons/views/footer.php";
    }

    /**
     * MainMenu affiche le menu de l'application sous la forme d'une barre de navigation Bootstrap 4
     *
     * @return void
     */
    public static function MainMenu()
    {
        echo '<ul class="nav navbar-nav navbar-left">' . "\n";
        foreach (Menu::RootLeftItems() as $navItem) {
            Html::NavItem($navItem);
        }
        echo "</ul>\n";
        echo '<ul class="nav navbar-nav navbar-right">' . "\n";
        foreach (Menu::RootRightItems() as $navItem) {
            Html::NavItem($navItem);
        }
        echo "</ul>\n";
    }

    /**
     * NavItem affiche un item Bootstrap de la barre de navigation de l'application
     *
     * @param  Menu $item
     * @return void
     */
    private static function NavItem(Menu $item)
    {
        if ($item->IsEnabled()) {
            if ($item->HasChildren()) { // menu déroulant standard
                echo '<li class="nav-item dropdown">' . "\n";
                echo '<a class="nav-link dropdown-toggle" href="#" id="dropdown' . $item->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $item->text . '</a>' . "\n";
                echo '<ul class="dropdown-menu" aria-labelledby="dropdown' . $item->id . '">' . "\n";
                foreach ($item->MenuItems() as $dropDownItem) {
                    Html::DropDownItem($dropDownItem);
                }
                echo '</ul>' . "\n";
                echo '</li>' . "\n";
            } else { // Item standard dans la barre de navigation
                echo '<li class="nav-item"><a href="' . $item->href . '" class="nav-link">' . $item->text . '</a></li>' . "\n";
            }
        } else {  // Item de la barre de navigation, désactivé
            echo '<li class="nav-item"><a href="" class="nav-link disabled">' . $item->text . '</a></li>' . "\n";
        }
    }

    /**
     * DropDownItem affiche un item de menu déroulant Bootstrap lié à la barre de navigation de l'application
     *
     * @param  mixed $item
     * @return void
     */
    private static function DropDownItem(Menu $item)
    {
        $bg = ($item->bg_color == Menu::MENU_BG_COLOR_DEFAULT) ? "": ' class="bg-'.$item->bg_color.'" ';
        if ($item->IsEnabled()) {
            if ($item->HasChildren()) {  // sous-menu
                echo '<li class="dropdown-submenu">' . "\n";
                echo '<a class="dropdown-item dropdown-toggle" href="#" id="dropdown' . $item->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $item->text . '</a>' . "\n";
                echo '<ul class="dropdown-menu" aria-labelledby="dropdown' . $item->id . '">' . "\n";
                foreach ($item->MenuItems() as $dropDownItem) {
                    Html::DropDownItem($dropDownItem);
                }
                echo '</ul>' . "\n";
                echo '</li>' . "\n";
            } else { // Item standard
                echo '<li'.$bg.'><a class="dropdown-item" href="' . $item->href . '">' . $item->text . '</a></li>' . "\n";
            }
        } elseif ($item->IsDivider()) {  // Trait horizontal
            echo '<li'.$bg.'><hr class="dropdown-divider"></li>' . "\n";
        } else { // Désactivé
            echo '<li'.$bg.'><a href="" class="dropdown-item disabled">' . $item->text . '</a></li>' . "\n";
        }
    }

    /**
     * PageNavigator construit un paginateur Bootstrap 4
     *
     * @param  array $items tableau dont la clé est le texte affiché (entier ou texte) et la valeur le lien associé
     * @param  mixed $current valeur courante
     * @param  int $width nombre de pages proposées. Ne fonctionne que si $current est un entier.
     * @return string
     */
    public static function PageNavigator(array $items, $current, int $width = 10): string
    {
        $pages = "";
        $first = "";
        $last = "";
        $previous = "<li class=\"page-item disabled\"><span class=\"page-link\">Précédent</span></li>\n";
        $next = "<li class=\"page-item disabled\"><span class=\"page-link\">Suivant</span></li>\n";
        $before = "";
        $after = "";

        foreach ($items as $key => $value) {
            if ($first == "") {
                if ($key == $current) {
                    $first = "<li class=\"page-item disabled\"><span class=\"page-link\">Premier</span></li>\n";
                } else {
                    $first = "<li class=\"page-item\"><a class=\"page-link\" href=\"$value\">Premier</a></li>\n";
                }
            }
            if (is_int($current) && ($key < $current - floor($width / 2))) {
                $before = "<li class=\"page-item disabled\"><span class=\"page-link\">...</span></li>\n";
            } elseif (is_int($current) && ($key > $current + ceil($width / 2))) {
                $after = "<li class=\"page-item disabled\"><span class=\"page-link\">...</span></li>\n";
            } else {
                if ($key == $current) {
                    $pages .= "<li class=\"page-item active\" aria-current=\"page\"><span class=\"page-link\">$key</span></li>\n";
                } else {
                    $pages .= "<li class=\"page-item\"><a class=\"page-link\" href=\"$value\">$key</a></li>\n";
                }
            }

            if ($key == $current - 1) {
                $previous = "<li class=\"page-item\"><a class=\"page-link\" href=\"$value\">Précédent</a></li>\n";
            }
            if ($key == $current + 1) {
                $next = "<li class=\"page-item\"><a class=\"page-link\" href=\"$value\">Suivant</a></li>\n";
            }
            if ($key == $current) {
                $last = "<li class=\"page-item disabled\"><span class=\"page-link\">Dernier</span></li>\n";
            } else {
                $last = "<li class=\"page-item\"><a class=\"page-link\" href=\"$value\">Dernier</a></li>\n";
            }
        }

        $pager = "<nav aria-label=\"Pagination Navigator\">\n";
        $pager .= "<ul class=\"pagination\">\n";

        $pager .= $first . $previous . $before . $pages . $after . $next . $last;

        $pager .= "</ul>\n";
        $pager .= "</nav>\n";
        return $pager;
    }

    /**
     * Construit un élément SELECT basé sur le tableau associatif $liste, 
     * sélectionnant l'option $courant, et ajoute les éventuels attributs à
     * la balise select 
     * @param string $name nom du champ de saisie
     * @param array $options tableau associatif value=>texte de l'option
     * @param mixed $default sert à indiquer l'option initialement sélectionnée
     * @param array $attributes liste des autres attributs à placer dans le select (id, class, etc...)
     * @return string élement html select prêt à l'emploi
     */
    public static function Select(string $name, array $options, ?string $default = null, ?array $attributes = null): string
    {
        $selectElement = '<select name="' . $name . '" ';
        if (!empty($attributes) && is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                $selectElement .= $key . '="' . $value . '" ';
            }
        }

        $selectElement .= ">\n";
        foreach ($options as $key => $value)
            if ($key == $default) {
                $selectElement .= "<option value=\"$key\" selected >$value</option>\n";
            } else {
                $selectElement .= "<option value=\"$key\" >$value</option>\n";
            }

        $selectElement .= "</select>";
        return $selectElement;
    }

    /**
     * Construit une série de cases à cocher basée sur le tableau associatif $options,
     * cochant l'ensemble des éléments cochés signalé comme tel dans le tableaus $checked
     * et ajoute les éventuels attributs
     * @param string $name nom des champs
     * @param array $options liste des options
     * @param array $checked liste des options sélectionnées
     * @param array $attributes tableau associatif comportant des attributs
     *      complémentaires à ajouter à la balise SELECT
     * @return array tableau d'élements html input/checkbox prêts à l'emploi
     */


    public static function CheckBoxes(string $name, array $options, array $checked, $attributes = null) : array
    {
        $cbs = array();
        foreach ($options as $value => $item) {
            $cb =  '<label><input type="checkbox" name="' . $name . '[]" ' .
                'id="' . $name . $value . '"';

            if (is_array($attributes))
                foreach ($attributes as $attr => $val)
                    $cb .= ' ' . $attr . '="' . $val . '" ';
            $cb .= 'value="' . $value . '" ';

            if (in_array($value, $checked))
                $cb .= 'checked ';

            $cb .= ' />' . $item . '</label>';

            $cbs[] = $cb;
        }
        return $cbs;
    }

    /**
     * Construit une série de boutons radio basée sur le tableau associatif $options,
     * cochant l'élément coché signalé comme tel dans le paramètre $checked
     * et ajoute les éventuels attributs
     * @param string $name nom des champs
     * @param array $options liste des options
     * @param string $checked option sélectionnée
     * @param array $attributes tableau associatif comportant des attributs
     *      complémentaires à ajouter à la balise SELECT
     * @return array tableau d'élements html input/radio prêts à l'emploi
     */


    public static function RadioButtons(string $name, array $options, $checked, array $attributes = null) : array
    {
        $rbs = array();
        foreach ($options as $value => $item) {
            $rb =  '<label><input type="radio" name="' . $name . '" ' .
                'id="' . $name . $value . '"';

            if (is_array($attributes))
                foreach ($attributes as $attr => $val)
                    $rb .= ' ' . $attr . '="' . $val . '" ';
            $rb .= 'value="' . $value . '" ';

            if ($value == $checked)
                $rb .= 'checked ';

            $rb .= ' />' . $item . '</label>';

            $rbs[] = $rb;
        }
        return $rbs;
    }

    /**
     * Récupère le nom du serveur sur lequel tourne ce script
     * @return string le nom du serveur
     */
    public static function ServerName()
    {
        $t = explode(" ", php_uname());
        if ($t[0] === "Windows") {
            return $t[2];
        } else {
            return $t[1];
        }
    }
}
