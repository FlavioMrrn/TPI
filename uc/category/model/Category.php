<?php
// Projet: Application TPI
// Script: Modèle Category.php
// Description: contient la classe Category et les méthodes en lien avec la table categories 
// Auteur: Morrone Flavio 
// Version 0.1.1 MF 12.05.2021 

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

    /**
     * Cherche dans la base de données si une catégory avec l'id mis en paramètre existe
     * @param int $id
     * @return ?Category retourne la catégorie trouvé ou null
     */
    public static function findById(?int $id): ?Category
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
        $sql = 'SELECT * FROM categories ORDER BY idCategory ASC;';
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
    public static function buildArrayWithChild(array $categories): array
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
            if ($m->getIdParent() == null) {
                if (!self::isInArray($m, $menus)) {
                    $menus[] = $m;
                }
            }
        }
        return $menus;
    }

    /**
     * Vérifie si un élément existe à n'importe quel endroit d'un tableau (sous tableau etc)
     * @param mixed l'element à vérifier
     * @param array le tableau 
     * @return bool
     */
    private static function isInArray($element, $array)
    {
        foreach ($array as $e) {
            if ($e->children != array()) {
                if (in_array($element, $e->children)) {
                    return true;
                } else if (self::isInArray($element, $e->children)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Vérifie si une catégorie possède un enfant dans la base de données
     * @param int l'id de la catégorie
     * @return bool
     */
    public static function hasChild(int $id)
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

    /**
     * Supprime une catégorie de la base de données
     * @param int l'id de la catégorie
     */
    public static function deleteCategory(int $id)
    {
        $sql = 'DELETE FROM `ecommerce`.`categories` WHERE (`idCategory` = :id);';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(':id', $id);
        $req->execute();
    }

    /**
     * Ajoute une catégorie dans la base de données
     * @param string le titre
     * @param string la description
     * @param int l'id du parent
     */
    public static function addCategory(string $title, string  $description, int $idParent): void
    {
        $sql = 'INSERT INTO `ecommerce`.`categories` (`title`, `description`, `idParentCategory`) VALUES (:title, :description, :idParent);';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(':title', $title);
        $req->bindParam(':description', $description);
        $req->bindParam(':idParent', $idParent);
        $req->execute();
    }

    /**
     * Modifie une catégorie dans la base de données
     * @param string le titre
     * @param string la description
     * @param int l'id du parent
     */
    public static function updateCategory(int $id, string $title, string $description, ?int $idParent): void
    {
        $sql = "UPDATE `ecommerce`.`categories` SET `title` = :title, `description` = :description, `idParentCategory` = :idParent WHERE (`idCategory` = :id);";
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(':id', $id);
        $req->bindParam(':title', $title);
        $req->bindParam(':description', $description);
        $req->bindParam(':idParent', $idParent);
        $req->execute();
    }

    /**
     * Créer le select pour la modification de parents
     * @param int l'id de la category actuelle
     * @param int l'id du parent de la category actuelle
     * @return string le select 
     */
    public static function makeParentSelect($id = null, $idParent = null): string
    {
        $result = "<select name='idParent' class='form-select'>";
        $result .= "<option value='' > Aucun </option>";
        $categories = self::getAllCategories();
        $category = Category::findById($id);

        foreach ($categories as $c) {
            if ($id != $c->getIdCategory()) {
                if (!self::hasCategoryChild($id, $c->getIdCategory())) {
                    $result .= "<option value='" . $c->getIdCategory() . "' " . ($idParent == $c->getIdCategory() ? "selected" : "") . " >" . $c->getTitle() . "</option>";
                }
            }
        }
        $result .= '</select>';

        return $result;
    }

    /**
     * Vérifier si une catégorie possède une autre catégorie comme enfant
     * @param int l'id du parent
     * @param int l'id de l'enfant
     * @return bool 
     */
    public static function hasCategoryChild(?int $idParent, ?int $idChild)
    {
        $child = self::findById($idChild);
        if ($child->getIdParent() != null) {
            if ($child->getIdParent() == $idParent) {
                return true;
            } else {
                return self::hasCategoryChild($idParent, $child->getIdParent());
            }
        }
        return false;
    }

    public static function CountItems(int $id)
    {
        $sql = 'SELECT COUNT(*) FROM ecommerce.items where idCategory = :id AND published = 1;';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(':id', $id);
        $req->execute();
        return $req->fetch();
    }

    public static function deleteNotPublishedItems($id)
    {
        $sql = 'SELECT * FROM ecommerce.items where idCategory = :id AND published = 0;';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->bindParam(':id', $id);
        $req->execute();
        $r = $req->fetchAll();

        foreach ($r as $i) {
            $sql = "DELETE FROM `ecommerce`.`items` WHERE (`idItem` = :id);";
            $req = DbConnection::getInstance()->prepare($sql);
            $req->bindParam(':id', $i['idItem']);
            $req->execute();
        }
    }
}
