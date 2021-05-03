<?php
// Projet: Application TPI
// Script: Session.php
// Description: Librairie de fonctions en lien avec la gestion des rôles à l'aide de la session
// Auteur: Pascal Comminot
// Version 1.0.0 PC 02.10.2017 / Codage initial

require_once "uc/user/model/User.php";

class Session
{
    public const SESSION_USER_SIGNATURE = "SessionUser";
    /**
     * Retourne les roles de l'utilisateur courant
     * @return array les roles de l'utilisateur
     */
    public static function getRoles(): array
    {
        return $_SESSION[Session::SESSION_USER_SIGNATURE]->getStatus();
    }


    /**
     * getCurrentRole retourne le role actuel de l'utilisateur connecté
     * @return string
     */
    public static function getCurrentRole(): string
    {
        return $_SESSION[Session::SESSION_USER_SIGNATURE]->getCurrentRole();
    }

    /**
     * setCurrentRole définit nouveau rôle actuel de l'utilisateur. 
     * Celui-ci fait forcément partie de la palette des rôles de l'utilisateur
     *
     * @param  mixed $role
     * @return void
     */
    public static function setCurrentRole(string $role)
    {
        $_SESSION[Session::SESSION_USER_SIGNATURE]->setCurrentRole($role);
    }

    /**
     * setUser définit l'utilisateur courant pour la session
     *
     * @param  User $user
     * @return void
     */
    public static function setUser(User $user)
    {
        $_SESSION[Session::SESSION_USER_SIGNATURE] = $user;
    }

    /**
     * getUser retourne l'utilisateur courant défini dans la session
     *
     * @return User
     */
    public static function getUser(): User
    {
        return $_SESSION[Session::SESSION_USER_SIGNATURE];
    }

    /**
     * forgetUser supprime l'utilisateur courant de la session
     * La session n'est pas supprimée, car les messages Flash sont également basés sur la session.
     * @return void
     */
    public static function forgetUser()
    {
        $_SESSION[Session::SESSION_USER_SIGNATURE] = new User();
    }
    
    /**
     * Set définit une variable de session
     *
     * @param  mixed $key nom de la variable de session
     * @param  mixed $value valeur associée
     * @return void
     */
    public static function Set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Get retourne la valeur stockée dans la session, associée à la clé, si elle existe
     * Retourne null si la clé n'est pas définie
     * @param  mixed $key
     * @return mixed
     */
    public static function Get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    /**
     * Démarre la session, et crée l'utilisateur par défaut s'il n'existe pas.
     */
    public static function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();

            if (empty($_SESSION[Session::SESSION_USER_SIGNATURE])) {
                $user = new User();
                $_SESSION[Session::SESSION_USER_SIGNATURE] = $user;
            }
        }
    }
}
