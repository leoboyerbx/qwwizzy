<?php

namespace Entites;


class UserEntity {
    public function getAvatar() {
        if ($this->avatar === null) {
            return "/users/avatars/default.svg";
        } else {
            return "/users/avatars/$this->avatar";
        }
    }
}