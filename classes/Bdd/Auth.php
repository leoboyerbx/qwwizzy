<?php

namespace Bdd;

use \App;

class Auth {
    private $db;

    /**
     * Auth constructeur.
     * @param $db
     */
    public function __construct($db) {
        $this->db = $db;
    }


    /**
     * Connecte l'utilisateur à partir des identifiants fournis en paramètres
     *
     * @param $pseudo
     * @param $pass
     * @param bool $bypass Si vrai, vérifie uniquement sans connecter l'utilisateur
     * @return bool
     */
    public function login($pseudo, $pass, $bypass = false) {
        $user = $this->db->prepare('SELECT * FROM utilisateur WHERE pseudo = ?', [$pseudo], "\\Entites\\UserEntity", true);
        if ($user) {
            if (password_verify($pass, $user->pass_hash)) {
                if (!$bypass) { // permet de simplement vérifier le mot de passe de l'utilisateur, sans le logger à nouveau.
                    $_SESSION['auth'] = $user;
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Renvoie si l'utilisateur est connecté
     * @return bool
     */
    public function estConnecte() {
        return !empty($_SESSION['auth']);
    }

    /**
     * Renvoie l'objet Utilisateur actuellement connecté
     * @return bool|mixed
     */
    public function getUser () {
        if (!empty($_SESSION['auth'])) {
            return $_SESSION['auth'];
        }
        return false;
    }

    /**
     * Met a jour une propriété de l'utilisateur dans la session
     * @param $prop
     * @param $value
     * @return bool
     */
    public function set_user_property($prop, $value) {
        if (!empty($_SESSION['auth'])) {
            $_SESSION['auth']->$prop = $value;
            return true;
        }
        return false;
    }


    /**
     * Vérifie que l'utilisateur connecté a au moins le niveau d'autorisation passé en paramètre.
     * @param $requiredLevel
     * @return bool
     */
    public function verif_permissions($requiredLevel) {
        return $this->getUser()->permissions >= $requiredLevel;
    }

    /**
     * Renvoie le nom de permission de l'utilisateur connecté
     * @return mixed|string
     */
    public function get_permission_nom () {
        return \App::getInstance()->get_permission_nom($this->getUser()->permissions);
    }

    /**
     * Vérifie le niveau d'autorisation et rediriger vers Interdit si le niveau n'est pas assez haut
     * @param $requiredLevel
     */
    public function auth_permission($requiredLevel) {
        if (!$this->verif_permissions($requiredLevel)) {
            \App::getInstance()->interdit();
        }
    }
}