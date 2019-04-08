<?php
/**
 * Contrôleur des questions
 */

namespace Controllers;


class QuestionController {

    public function check() {
        echo $_POST['reponse'];
    }
}