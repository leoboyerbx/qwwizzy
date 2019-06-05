<?php

namespace Entites;

/**
 * Classe utilisée pour ajoute rune fonction aux objets récupérés par PDO, ici récupérer l'image avatar de l'utilisateur avec une par défaut
 */
class UserEntity {
    public function getAvatar() {
        if ($this->avatar === null) {
            return "/users/avatars/default.svg";
        } else {
            return "/users/avatars/$this->avatar";
        }
    }
}