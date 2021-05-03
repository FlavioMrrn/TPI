<?php
// Projet: Application TPI
// Script: Menu.php
// Description: Gestion logique du menu de l'application. 
// La partie graphique réalisée avec Boostrap se trouve dans la classe commons/views/Html
// Auteur: Pascal Comminot
// Version 1.0.0 PC 16.04.2021 / Codage initial
// Version 1.0.1 PC 22.04.2021 / Ajout de la gestion des menus gauche et droite, ajout de la couleur de fond pour les items

class Menu {
    const MENU_DIVIDER = '---';
    const MENU_MAIN_MENU_LEFT = 'MainMenuLeft';
    const MENU_MAIN_MENU_RIGHT = 'MainMenuRight';
    const MENU_STANDARD_ITEM = 'MenuStandardItem';

    const MENU_BG_COLOR_DEFAULT = null;
    const MENU_BG_COLOR_PRIMARY = 'primary';
    const MENU_BG_COLOR_SEDONDARY = 'secondary';
    const MENU_BG_COLOR_SUCCESS = 'success';
    const MENU_BG_COLOR_DANGER = 'danger';
    const MENU_BG_COLOR_WARNING = 'warning';
    const MENU_BG_COLOR_INFO = 'info';
    const MENU_BG_COLOR_ALERT = 'alert';
    const MENU_BG_COLOR_LIGHT = 'light';
    const MENU_BG_COLOR_DARK = 'dark';

    /**
     * @var string Texte affiché dans le menu
     */ 
    public $text;

    /**
     * @var string référence à l'action à réaliser quand ce menu est sélectionné
     */
    public $href;

    /**
     * @var bool indique si le menu est actif ou nom
     */
    public $enabled;

    /**
     * @var int Numéro unique du menu, utile pour associer un sous-menu à l'item courant
     */
    public $id;

    /**
     * @var string Couleur de fond spécifique à l'item courant
     */
    public $bg_color;

    /**
     * @var array of Menu sous-menu du menu courant
     */
    protected $items;

    /**
     * @var array menu principal de l'application
     */
    private static $rootLeft = array();

    /**
     * @var array menu principal de l'application
     */
    private static $rootRight = array();

    /**
     * @var int ID attribué au prochaine menu qui sera créé
     */
    private static $nextId = 1;
    
    /**
     * __construct Constructeur de la classe Menu
     *
     * @param  string $text Texte du menu
     * @param  string $href Lien associé au menu
     * @param  bool $enabled indique si le menu est activé
     * @param  string $menuStatus indique si le menu apparaît dans la barre de navigation de l'application
     * @return void
     */
    public function __construct(string $text,?string $href,?bool $enabled=true,string $menuStatus=Menu::MENU_STANDARD_ITEM){
        $this->text = $text;
        $this->href = $href;
        $this->enabled = $enabled;
        $this->items = array();
        $this->bg_color = null;
        $this->id = Menu::$nextId++;
        if ($menuStatus===Menu::MENU_MAIN_MENU_LEFT){
            Menu::$rootLeft[] = $this;
        } elseif ($menuStatus===Menu::MENU_MAIN_MENU_RIGHT){
            Menu::$rootRight[] = $this;
        } 
    }
    
    /**
     * AddItem rajoute un sous-menu au menu courant
     *
     * @param  Menu $item
     * @return Menu
     */
    public function AddItem(Menu $item) : Menu{
        $this->items[] = $item;
        return $this;
    }

    /**
     * AddDivider rajoute une barre de séparation dans le menu
     *
     * @param  Menu $item
     * @return Menu
     */
    public function AddDivider() : Menu {
        $this->AddItem(new Menu(Menu::MENU_DIVIDER,null,false,Menu::MENU_STANDARD_ITEM));
        return $this;
    }

        
    /**
     * SetBgColor permet de modifier la couleur de fond de l'item, selon les couleur Bootstrap
     *
     * @param  mixed $bg
     * @return Menu
     */
    public function SetBgColor(string $bg) : Menu {
        $this->bg_color = $bg;
        return $this;
    }

    /**
     * IsDivider indique si l'item est une barre de séparation ou non
     *
     * @return bool
     */
    public function IsDivider() : bool {
        return ($this->text === Menu::MENU_DIVIDER) && ($this->href===null) && ($this->enabled===false);
    }
    
    /**
     * IsEnabled indique si l'item est activé ou non 
     *
     * @return bool
     */
    public function IsEnabled() : bool {
        return ($this->enabled===true);
    }
    
    /**
     * HasChildren indique si le menu se compose d'un sous-menu ou non
     *
     * @return bool
     */
    public function HasChildren() :bool {
        return (!empty($this->items));
    }

    
    /**
     * RootItems retourne le menu principal de droite qui sera utilisé pour la barre de navigation
     *
     * @return array
     */
    public static function RootRightItems() : array {
        return Menu::$rootRight;
    }

    /**
     * RootItems retourne le menu principal de gauche qui sera utilisé pour la barre de navigation
     *
     * @return array
     */
    public static function RootLeftItems() : array {
        return Menu::$rootLeft;
    }
    

    /**
     * MenuItems retourne les items composant le sous-menu
     *
     * @return array
     */
    public function MenuItems() : array {
        return $this->items;
    }
}

