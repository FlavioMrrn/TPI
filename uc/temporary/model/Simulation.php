<?php
// Projet: Application TPI / temporary
// Script: Modèle Simulation
// Description: définit quelques méthodes utiles pendant le développement de l'application.
// Simulation de méthodes utiles pour un candidat, mais développée par un autre.
// Simulation de l'arrivage de marchandise 
// Auteur: Pascal Comminot
// Version 1.0.0 PC 01.05.2021 / Codage initial

class Simulation{

    
    /**
     * getAllCategoriesBelongingTo fournit la liste de toutes les sous-catégories à partir d'une catégorie.
     * La construction ici est faite de manière statique et correspond au contenu de la table category fournie en début de TPI
     *
     * @param  mixed $idCategory id de la catégorie dont on souhaite connaître toutes les sous-catégories.
     * @return array tableau comprenant toutes les sous-catégories, ainsi que la catégorie passée en paramètre
     */
    public static function getAllCategoriesBelongingTo(?int $idCategory=null) : ?array{
        
        switch ($idCategory){
            case null : $result = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18); break;
            case 1: $result = array(1,3,4,5); break;
            case 2: $result = array(2,6,7,8,9,10,11,12,13,14,15,16,17,18); break;
            case 3: $result = array(3); break;
            case 4: $result = array(4); break;
            case 5: $result = array(5); break;
            case 6: $result = array(6); break;
            case 7: $result = array(7); break;
            case 8: $result = array(8); break;
            case 9: $result = array(9); break;
            case 10: $result = array(10); break;
            case 11: $result = array(11); break;
            case 12: $result = array(12); break;
            case 13: $result = array(13,14,15,16,17,18); break;
            case 14: $result = array(14); break;
            case 15: $result = array(15); break;
            case 16: $result = array(16); break;
            case 17: $result = array(17); break;
            case 18: $result = array(18); break;
            default: $result = array();
        }
        return $result;
    }

    
    /**
     * getBreadCrumbsFor fournit un fil d'Ariane correspondant à la hiérarchie des catégories fournies en début de TPI
     *
     * @param  mixed $idCategory id de la catégorie pour la quelle on désire retrouver le chemin jusqu'à la racine.
     * @return array tableau associatif (id=>nom de la catégorie)
     */
    public static function getBreadCrumbsFor(?int $idCategory) : array {

        switch ($idCategory){
            case null : $result = array(null=>'Tout'); break;
            case 1: $result = array(null=>'Tout',1=>'Ordinateurs'); break;
            case 2: $result = array(null=>'Tout',2=>'Composants'); break;
            case 3: $result = array(null=>'Tout',1=>'Ordinateurs',3=>'Ordinateurs de bureau'); break;
            case 4: $result = array(null=>'Tout',1=>'Ordinateurs',4=>'Ordinateurs portables'); break;
            case 5: $result = array(null=>'Tout',1=>'Ordinateurs',5=>'Tablettes'); break;
            case 6: $result = array(null=>'Tout',2=>'Composants',6=>'Processeurs'); break;
            case 7: $result = array(null=>'Tout',2=>'Composants',7=>'Cartes mères'); break;
            case 8: $result = array(null=>'Tout',2=>'Composants',8=>'Mémoire RAM'); break;
            case 9: $result = array(null=>'Tout',2=>'Composants',9=>'Cartes graphiques'); break;
            case 10: $result = array(null=>'Tout',2=>'Composants',10=>'Boîtiers'); break;
            case 11: $result = array(null=>'Tout',2=>'Composants',11=>'Alimentations'); break;
            case 12: $result = array(null=>'Tout',2=>'Composants',12=>'Refroidissement'); break;
            case 13: $result = array(null=>'Tout',2=>'Composants',13=>'Stockage'); break;
            case 14: $result = array(null=>'Tout',2=>'Composants',13=>'Stockage', 14=>'SSD'); break;
            case 15: $result = array(null=>'Tout',2=>'Composants',13=>'Stockage', 15=>'Disques internes HDD'); break;
            case 16: $result = array(null=>'Tout',2=>'Composants',13=>'Stockage', 16=>'Clés USB'); break;
            case 17: $result = array(null=>'Tout',2=>'Composants',13=>'Stockage', 17=>'NAS'); break;
            case 18: $result = array(null=>'Tout',2=>'Composants',13=>'Stockage', 18=>'Lecteurs optiques DVD/BD'); break;
            default: $result = array(null=>'Tout');
        }
        return $result;
    }

        
    /**
     * getAllItems retourne la liste complète de tous les articles de la table items, avec le nom de la catégorie associée
     *
     * @return array
     */
    public static function getAllItems() : array {
        $sql = 'SELECT idItem, name, manufacturer, partNumber, price, title AS categoryName FROM items LEFT JOIN categories USING(idCategory)';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_OBJ);
        $req->execute();
        return $req->fetchAll();
    }
    
    /**
     * findAllItemsByPartNumber retourne la liste des articles correspondant aux partNumbers qui ont été fournis.
     *
     * @param  arry $partNumbers liste des numéro de produits que l'on recherche
     * @return array
     */
    public static function findAllItemsByPartNumber(array $partNumbers) : array {
        $in  = str_repeat('?,', count($partNumbers) - 1) . '?';
        $sql = "SELECT idItem, name, manufacturer, partNumber, title AS categoryName ".
            "FROM items LEFT JOIN categories USING(idCategory) ".
            "WHERE partNumber IN ($in)";
        $req = DbConnection::getInstance()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_OBJ);
        $req->execute($partNumbers);
        return $req->fetchAll();
    }

    


}