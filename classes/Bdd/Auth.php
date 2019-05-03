<?php

namespace Bdd;

use \App;

class Auth {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public function login($pseudo, $pass, $bypass = false) {
        $result = $this->db->prepare('SELECT * FROM utilisateur WHERE pseudo = ?', [$pseudo], true);
        if ($result) {
            $user = $result[0];
            if (password_verify($pass, $user->pass_hash)) {
                if (!$bypass) { // permet de simplement vérifier le mot de passe de l'utilisateur, sans le logger à nouveau.
                    $_SESSION['auth'] = $user;
                }
                return true;
            }
        }
        return false;
    }
    public function estConnecte() {
        return !empty($_SESSION['auth']);
    }
    public function getUser () {
        if (!empty($_SESSION['auth'])) {
            return $_SESSION['auth'];
        }
        return false;
    }
    public function set_user_property($prop, $value) {
        if (!empty($_SESSION['auth'])) {
            $_SESSION['auth']->$prop = $value;
            return true;
        }
        return false;
    }
}