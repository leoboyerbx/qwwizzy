<?php

namespace Bdd;

use \App;

class Auth {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($pseudo, $pass) {
        $result = $this->db->prepare('SELECT * FROM utilisateur WHERE pseudo = ?', [$pseudo], true);
        if ($result) {
            $user = $result[0];
            if (password_verify($pass, $user->pass_hash)) {
                $_SESSION['auth'] = $user;
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
}