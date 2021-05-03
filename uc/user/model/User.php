<?php
// Projet: Application TPI
// Script: Modèle users.php
// Description: contient la classe User et les méthodes en lien avec la table users 
// Normalement un CRUD, mais comme cette classe fait partie du TPI de M. Morrone, il n'y a que le strict
// minimum pour que cela puisse fonctionner.
// Auteur: Pascal Comminot
//      Modifié par: Morrone Flavio
// Version 0.1.0 PC 20.02.2021 / Codage initial
// Version 0.1.1 MF 03.05.2021 / Ajout du register, et du hash de password

require_once 'commons/model/DbConnection.php';


class User
{
    // Les divers rôles possibles de l'utilisateur. Correspond au SET (SQL) déclaré pour le champ Status
    const USER_ROLE_ANONYMOUS =  'Anonymous';
    const USER_ROLE_NOT_VERIFIED = 'NotVerified';
    const USER_ROLE_CUSTOMER = 'Customer';
    const USER_ROLE_SALE_MANAGER = 'SaleManager';
    const USER_ROLE_PRODUCT_MANAGER = 'ProductManager';
    const USER_ROLE_WEB_MANAGER = 'WebManager';
    const USER_ROLE_BANNED = 'Banned';
    const USER_ROLE_UNDEFINED = 'Undefined';

    const PASSWORD_SALT = "ylkdfnsdfisdk";

    /**
     * @var int
     */
    private $idUser;
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var string
     */
    private $address;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $pwdHash;
    /**
     * @var string chaine composée d'un sous-ensemble des valeurs ('Anonymous','NotVerified', 'Customer', 
     * 'SaleManager', 'ProductManager','WebManager','Banned'), séparée par des virgules
     */
    private $status;

    /**
     * @var string un parmi 'Anonymous','NotVerified', 'Customer', 'SaleManager', 'ProductManager','WebManager' or 'Banned'
     */
    private $currentRole;


    /**
     * getIdUser retourne l'id de l'utilisateur
     *
     * @return ?int L'id peut être null, dans le cas de la création d'un nouvel enregistrement.
     */
    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    /**
     * setIdUser permet de définir l'id de l'utilisateur... 
     * Cette méthode ne devrait jamais être utilisée, dans la mesure où c'est la base de donnée qui définit l'id...
     * L'id peut être null, ce qui permet de créer un nouvel enregistrement lors de la sauvegarde dans la base de données
     *
     * @param  ?int $idUser
     * @return self
     */
    public function setIdUser(?int $idUser): self
    {
        $this->idUser = $idUser;
        return $this;
    }

    /**
     * getFirstName retourne le prénom de l'utilisateur
     *
     * @return ?string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * setFirstName permet de modifier le prénom de l'utilisateur
     *
     * @param  ?string $firstName
     * @return self
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * getLastName retourne le nom de famille de l'utilisateur
     *
     * @return ?string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * getFullName retourne le nom complet l'utilisateur (Prénom Nom)
     *
     * @return ?string
     */
    public function getFullName(): ?string
    {
        return $this->firstName . ' ' . $this->lastName;
    }


    /**
     * setLastName permet de modifier le nom de famille de l'utilisateur
     *
     * @param  ?string $lastName
     * @return self
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * getAddress retourne l'adresse postale de l'utilisateur
     *
     * @return ?string
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * setAddress permet de modifier l'adresse postale de l'utilisateur
     *
     * @param  ?string $address
     * @return self
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * getEmail retourne l'email de l'utilisateur
     *
     * @return ?string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * setEmail permet de modifier l'email de l'utilisateur
     *
     * @param  ?string $email
     * @return self
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * getPwdHash retourne le mot de passe chiffré de l'utilisateur
     * Méthode protégée, car le mot de passe ne devrait pas quitter cette classe 
     * ou les classes qui en hérite...
     *
     * @return ?string
     */
    protected function getPwdHash()
    {
        return $this->pwdHash;
    }

    /**
     * setPwd permet de modifier le mod de passe de l'utilisateur
     *
     * @param  ?string $pwd en clair
     * @return self
     */ public function setPwd(?string $pwd): self
    {
        $this->pwdHash = $pwd; // à chiffrer
        return $this;
    }

    /**
     * getStatus retourne les roles de l'utilisateur
     * La donnée stockée de manière sérialisée est rendue sous la forme
     * d'un tableau
     *
     * @return array
     */
    public function getStatus(): array
    {
        return explode(',', $this->status);
    }

    /**
     * setStatus permet de modifier le rôles de l'utilisateur
     * Le tableau fourni est sérialisé avant d'être stocké dans le champ
     *
     * @param  ?string $status
     * @return self
     */
    public function setStatus(array $status): self
    {
        $this->status = implode(',', $status);
        return $this;
    }

    /**
     * getCurrentRole retourne le role actuel de l'utilisateur
     *
     * @return ?string
     */
    public function getCurrentRole()
    {
        return $this->currentRole;
    }

    /**
     * setCurrentRole permet de modifier le role actuel de l'utilisateur,
     * en le limitant aux rôles dont il dispose
     * Si aucun paramètre n'est passé, un rôle arbitraire est attribué
     * en fonction des rôles dont il dispose
     * 
     * @param  ?string $currentRole
     * @return self
     */
    public function setCurrentRole(?string $currentRole = null): self
    {
        if (!empty($currentRole)) {
            if (in_array($currentRole, $this->getStatus())) {
                $this->currentRole = $currentRole;
            } else {
                $currentRole = null;
            }
        }
        if (empty($currentRole)) {
            if (empty($this->status)) {
                $this->currentRole = User::USER_ROLE_ANONYMOUS;
            } else {
                $status = $this->getStatus();
                if (in_array(User::USER_ROLE_BANNED, $status)) {
                    $this->currentRole = User::USER_ROLE_BANNED;
                } elseif (in_array(User::USER_ROLE_NOT_VERIFIED, $status)) {
                    $this->currentRole = User::USER_ROLE_NOT_VERIFIED;
                } elseif (in_array(User::USER_ROLE_WEB_MANAGER, $status)) {
                    $this->currentRole = User::USER_ROLE_WEB_MANAGER;
                } elseif (in_array(User::USER_ROLE_PRODUCT_MANAGER, $status)) {
                    $this->currentRole = User::USER_ROLE_PRODUCT_MANAGER;
                } elseif (in_array(User::USER_ROLE_SALE_MANAGER, $status)) {
                    $this->currentRole = User::USER_ROLE_SALE_MANAGER;
                } elseif (in_array(User::USER_ROLE_CUSTOMER, $status)) {
                    $this->currentRole = User::USER_ROLE_CUSTOMER;
                } else {
                    $this->currentRole = User::USER_ROLE_UNDEFINED;
                }
            }
        }
        return $this;
    }


    /**
     * isAnonymous indique si l'utilisateur actuel est anonyme
     *
     * @return bool
     */
    public function isAnonymous(): bool
    {
        return $this->currentRole == User::USER_ROLE_ANONYMOUS;
    }

    /**
     * isOwner indique si l'utilisateur actuel correspond à l'id passé en paramètre
     *
     * @return bool
     */
    public function isOwner(?int $id): bool
    {
        return $this->getIdUser() === $id;
    }


    /**
     * hasCurrentRole vérifie si le rôle courant correspond à
     * celui ou à un de ceux passés en paramètre
     *
     * @param  mixed $role string / string array a vérifier
     * @return bool
     */
    public function hasCurrentRole($role): bool
    {
        if (is_array($role)) {
            return (in_array($this->getCurrentRole(), $role));
        } else {
            return $this->getCurrentRole() === $role;
        }
    }

    /**
     * hasRole vérifie si parmi les rôles de l'utilisateur,
     * il y en a au moins un qui correspond à celui ou à un de ceux
     * passés en paramètre
     *
     * @param  mixed $roles string / string array a vérifier
     * @return bool vrai si au moins un rôle correspond
     */
    public function hasRole($roles): bool
    {
        if (is_array($roles)) {
            foreach ($roles as $r) {
                if (in_array($r, $this->getStatus())) {
                    return true;
                }
            }
        } else {
            return in_array($roles, $this->getStatus());
        }
        return false;
    }

    /**
     * __construct Constructeur de la classe User
     * Le role courant est initialisé de manière à la volée
     *
     * @return void
     */
    public function __construct()
    {
        $this->setCurrentRole();
    }

    /**
     * récupère tous les enregistrements de la table users
     * @return array tableau contenant les enregistrements 
     */
    public static function findAll(): array
    {
        $sql = 'SELECT idUser, firstName, lastName, address, email, pwdHash, status  FROM users';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, 'User');
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * retourne un objet user correspondant à l'enregistrement idUser
     * @param int $idUser ID de l'utilsateur dont on veut le détail
     * @return User|null
     */
    public static function findById(int $id): User
    {
        $sql = "SELECT idUser, firstName, lastName, address, email, pwdHash, status FROM users WHERE idUser= :id";
        $req = DbConnection::getInstance()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, 'User');
        $req->bindParam(':id', $id);
        $req->execute();
        return $req->fetch();
    }


    /** 
     * retourne la liste des utilisateurs sous la forme d'un tableu associatif
     * @return array tableau associatif (idUser=>"Prenom Nom") contenant les enregistrements 
     */
    public static function getAllUsersNames()
    {
        $sql = "SELECT idUser, CONCAT(FirstName,' ',LastName) AS Name FROM users ORDER BY LastName, FirstName";
        $req = DbConnection::getInstance()->prepare($sql);
        //$req->setFetchMode(PDO::FETCH_OBJ);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
     * retourne un objet user correspondant à l'enregistrement idUser
     * @param string $email email de l'utilsateur dont on veut le détail
     * @return User|null
     */
    public static function findByEmail(string $email): ?User
    {
        $sql = "SELECT idUser, firstName, lastName, address, email, pwdHash, status FROM users WHERE email= :email";
        $req = DbConnection::getInstance()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, 'User');
        $req->bindParam(':email', $email);
        $req->execute();
        $r = $req->fetch();
        if ($r === false) {
            $r = null;
        }
        return $r;
    }


    /**
     * Vérifie si les données passées en paramètres correspondent à un utilisateur ou non
     * @param string $email L'email à vérifier
     * @param string $pwd le mot de passe à vérifier (actuellement pas corrélé avec la base)
     * @return mixed soit un tableau avec le profil de l'utilisateur, 
     *               Soit null si l'identification n'a pas pu être vérifiée
     */
    public static function checkUserIdentification($email, $pwd): ?User
    {
        if ($pwd != '1234') {
            return null;
        }
        return self::findByEmail($email);
    }

    /**
     * Permet l'enregistrement de l'utilisateur dans la base de données
     * @param string $name Le nom de l'utilisateur
     * @param string $email L'email de l'utilisateur
     * @param string $firstname Le prénom de l'utilisateur
     * @param string $pwd le mot de passe 
     * @return void
     */
    public static function register(string $name, string $firstname, string $email, string $password, string $address, string $status = 'NotVerified', string $validationDate, string $validationToken): void
    {
        $sql = "INSERT INTO users (firstname, lastname, email, pwdHash, address, status, validationToken, validationDate) VALUES (:firstName, :name, :email, :pwd, :address, :status, :validationToken, :validationDate);";
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(":firstName", $firstname);
        $req->bindParam(":name", $name);
        $req->bindParam(":email", $email);
        $req->bindParam(":address", $address);
        $req->bindParam(":pwd", $password);
        $req->bindParam(":status", $status);
        $req->bindParam(":validationDate", $validationDate);
        $req->bindParam(":validationToken", $validationToken);
        $req->execute();
    }


    /**
     * Permet de saler et de chiffrer le mot de passe en sha256 afin de ne pas pouvoir le défiffrer
     * @param string $password Le mot de passe à chiffrer
     * @return string le mot de passe chiffré en sha256
     */
    public static function hashPassword(string $password): string
    {
        $password .= User::PASSWORD_SALT;
        $password = hash('sha256', $password);
        return $password;
    }

    /**
     * Compte le nombre d'utilisateurs dans la base de données
     * @return int le nombre d'utilisateurs de la base
     */
    public static function countUsers()
    {
        $sql = 'SELECT COUNT(*) FROM users';
        $req = DbConnection::getInstance()->prepare($sql);
        $req->execute();
        return $req->fetch();
    }

    /**
     * Génère le token de validation pour un user
     * @param int nombre de caractères
     * @return string une chaine aléatoire
     */
    public static function generateToken($length = 50)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    /**
     * Récupère la date limite de validation du compte
     * @param string l'email du compte 
     * @return DateTime la date limite de validation 
     */
    public static function getValidationDate(string $email)
    {
        $sql = "SELECT validationDate FROM users WHERE email = :email";
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(":email", $email);
        $req->execute();
        return $req->fetch();
    }


    /**
     * Vérifie si le token correspond a l'email
     * @param string le token a vérifier
     * @param string l'email du compte
     * @return bool true si il correspond false si correspond pas
     */
    public static function verifyTokenEmail(string $token, string $email): bool
    {
        $sql = "SELECT * FROM users WHERE validationToken = :token AND email = :email;";
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(":email", $email);
        $req->bindParam(":token", $token);
        $req->execute();

        if ($req->fetch() === false) {
            return false;
        }

        return true;
    }


    /**
     * Valide le compte comportant l'email mis en paramètre
     * @param string l'email du compte
     * @return void
     */
    public static function validateAccount($email)
    {
        $sql = "UPDATE `ecommerce`.`users` SET `status` = 'Customer', `validationToken` = null, `validationDate` = null WHERE email = :email;";
        $req = DbConnection::getInstance()->prepare($sql);
        $req->bindParam(":email", $email);
        $req->execute();
    }
}
