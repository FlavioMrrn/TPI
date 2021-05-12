<?php
// Projet: Application TPI
// Script: Modèle Log.php
// Description: contient la classe log et les méthodes en lien avec la table logs 
// Auteur: Morrone Flavio 
// Version 0.1.1 MF 06.05.2021 

require_once 'commons/model/DbConnection.php';

class Category
{

    /**
     * @var int
     */
    private $idCategory;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $idParentCategory;


    /**
     * @var array
     */
    public $children = [];


    /**
     * get retourne l'id de la category
     *
     * @return ?int L'id peut être null, dans le cas de la création d'un nouvel enregistrement.
     */
    public function getIdCategory(): ?int
    {
        return $this->idCategory;
    }

    /**
     * get retourne le message
     *
     * @return ?int L'id peut être null, dans le cas de la création d'un nouvel enregistrement.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * get retourne l'id de la log
     *
     * @return ?int L'id peut être null, dans le cas de la création d'un nouvel enregistrement.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /**
     * get retourne l'id de la category parent 
     *
     * @return ?int L'id peut être null, dans le cas de la création d'un nouvel enregistrement.
     */
    public function getIdParent(): ?int
    {
        return $this->idParentCategory;
    }

    /**
     * setIdLog permet de définir l'id de la Log... 
     * Cette méthode ne devrait jamais être utilisée, dans la mesure où c'est la base de donnée qui définit l'id...
     * L'id peut être null, ce qui permet de créer un nouvel enregistrement lors de la sauvegarde dans la base de données
     *
     * @param  ?int $idLog
     * @return self
     */
    public function setIdCategory(?int $idCategory): self
    {
        $this->idCategory = $idCategory;
        return $this;
    }


    /**
     * setMessage permet de modifier le message de la Log
     *
     * @param  ?string $message
     * @return self
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * setDate permet de modifier la date de la Log
     *
     * @param  ?DateTime $date
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * setIdLog permet de définir l'id de la Log... 
     * Cette méthode ne devrait jamais être utilisée, dans la mesure où c'est la base de donnée qui définit l'id...
     * L'id peut être null, ce qui permet de créer un nouvel enregistrement lors de la sauvegarde dans la base de données
     *
     * @param  ?int $idLog
     * @return self
     */
    public function setIdParent(?int $idParentCategory): self
    {
        $this->idParentCategory = $idParentCategory;
        return $this;
    }

    public static function findById($id): ?Category
    {
        $sql = 'SELECT * FROM categories WHERE idCategory = :id';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $req->bindParam(':id', $id);
        $req->execute();
        $r = $req->fetch();

        if ($r === false) {
            return null;
        }

        return $r;
    }

    /**
     * Récupère toutes les catégories de la base de données
     * @return array
     */
    public static function getAllCategories(): array
    {
        $sql = 'SELECT * FROM categories ORDER BY idParentCategory ASC;';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * Créer un tableau propre avec les parents contenants les enfants
     * @param array les catégories de la base
     * @return array
     */
    public static function buildArrayWithChild($categories): array
    {
        $sous_menu = [];
        foreach ($categories as $c) {
            $sous_menu[$c->getIdCategory()] = $c;
        }

        foreach ($sous_menu as $key => &$c) {
            if ($c->getIdParent() !== null) {
                $sous_menu[$c->getIdParent()]->children[] = $c;
            }
        }

        $menus = [];
        foreach ($sous_menu as $m) {
            if ($m->children != array() || $m->getIdParent() == null) {
                if (!self::isInArray($m, $menus)) {
                    $menus[] = $m;
                }
            }
        }
        return $menus;
    }

    private static function  isInArray($element, $array)
    {
        foreach ($array as $m) {
            if ($m->children != array()) {
                if (in_array($element, $m->children)) {
                    return true;
                } else if (self::isInArray($element, $m->children)) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function hasChild($id)
    {
        $sql = 'SELECT * FROM categories WHERE idParentCategory = :id;';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(':id', $id);
        $req->execute();
        $r = $req->fetchAll();
        if ($r == false) {
            return false;
        } else {
            return true;
        }
    }

    public static function deleteCategory($id)
    {
        $sql = 'DELETE FROM `ecommerce`.`categories` WHERE (`idCategory` = :id);';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(':id', $id);
        $req->execute();
    }

    public static function addCategory($title, $description, $idParent)
    {
        $sql = 'INSERT INTO `ecommerce`.`categories` (`title`, `description`, `idParentCategory`) VALUES (:title, :description, :idParent);';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(':title', $title);
        $req->bindParam(':description', $description);
        $req->bindParam(':idParent', $idParent);
        $req->execute();
    }

    public static function makeParentSelect(): string
    {
        $result = "<select name='idParent' class='form-select'>";
        $result .= "<option selected> Aucun </option>";
        $categories = self::getAllCategories();
        foreach ($categories as $c) {
            $result .= "<option value='" . $c->getIdCategory() . "'>" . $c->getTitle() . "</option>";
        }
        $result .= '</select>';

        return $result;
    }
}
