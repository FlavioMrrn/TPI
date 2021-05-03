<?php
// Projet: Application TPI
// Script: Gestionnaire des routes de l'application
// Description: permet de définir et de rechercher les routes prévues dans l'application
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.02.2021 / Codage initial

class Routes{

    private static $routes = array();

    
    /**
     * AddRoute Ajoute une route dans l'application
     *
     * @param  string $uc
     * @param  string $action
     * @param  string $path
     * @return void
     */
    public static function AddRoute($uc,$action,$path){
       Routes::$routes["$uc-$action"] = $path;
    }
    
    /**
     * FindRoute retourne la route recherchée. Si elle n'est pas trouvée, la valeur booléenne FALSE est retournée
     *
     * @param  string $uc
     * @param  string $action
     * @return mixed string / boolean
     */
    public static function FindRoute($uc,$action){
        if (empty($uc)&& empty($action)){
            $uc = 'main';
            $action = 'home';
        }
        if (isset(Routes::$routes["$uc-$action"])){
            return Routes::$routes["$uc-$action"];
        }
        // si on arrive ici, c'est que la route demandée n'a pas été trouvée
        return FALSE;
    }
    
    /**
     * RouteExists indique si une route existe ou non
     *
     * @param  mixed $uc
     * @param  mixed $action
     * @return bool
     */
    public static function RouteExists($uc,$action) : bool {
        return (isset(Routes::$routes["$uc-$action"]));
    }
    
    /**
     * PathTo construit les paramètres de l'URL correspondant au use case et à l'action
     *
     * @param  string $uc
     * @param  string $action
     * @param  bool $valid
     * @return string
     */
    public static function PathTo(string $uc,string $action,bool $valid=true):string{
        if (Routes::RouteExists($uc,$action) || !$valid){
            return "index.php?uc=$uc&action=$action";
        } else {
            return ""; 
        }
    }

}