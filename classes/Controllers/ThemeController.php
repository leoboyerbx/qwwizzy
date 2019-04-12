<?php
/**
 * Classe chargée de controller le déroulement d'un quizz. Elle envoie la vue correspondante selon la situation.
 * NOTE: on aurait pu utiliser $_SESSION, mais cela aurait limité les appels à la base de donnée, donc on évite volontairement.
 * 
*/

namespace Controllers;



class ThemeController {
    private $theme;
    private $id_session;
    
    public function __construct($theme) {
        $this->bdd = \App::getInstance()->getBdd();

        $theme = $this->bdd->prepare("SELECT * FROM theme WHERE key_nom = ?", [$theme], true);
        if (empty($theme)) {
            $this->theme = null;
        } else {
            $this->theme = $theme[0];
        }
    }
    
    public function quizz () {
        if ($this->theme === null) {
            include ROOT . '/pages/quizz/inexistant.php';
        } else {
            $this->auto();
        }
    }
    
    public function auto() {
        if (!empty($_POST['id_session'])) {
            $this->id_session = $_POST['id_session'];
            if (isset($_POST['score']) && isset($_POST['id_question'])) {
                $this->stocker_score($_POST['score'], $_POST['id_question']);
            }
            $this->question($this->theme->id);
        } else {
            $id_session = rand(100, 100000);
            $this->id_session = $id_session;
            $theme = $this->theme;
            $this->start($this->theme, $id_session);
        }
    }
    
    public function question($theme_id) {
        $question = $this->bdd->prepare("
            SELECT * FROM question
            WHERE theme_id = ?
                AND question.id NOT IN (
                    SELECT question_id FROM historique_session WHERE id_session = ?
                )
            ORDER BY rand()
            LIMIT 1
        ", [$theme_id, $this->id_session], true);
        if (empty($question)) {
            include ROOT . '/pages/quizz/vide.php';
        } else {
            $question = $question[0];
            $id_session = $this->id_session;
            include ROOT.'/pages/questions/question.php';
        }
    }
    
    public function start ($theme, $id_session) {
        include ROOT . '/pages/quizz/debut.php';
    }
    
    public function stocker_score ($score, $id_question) {
        $this->bdd->prepare('INSERT INTO historique_session VALUES(NULL, ?, ?, ?)', [$this->id_session, $id_question, $score]);
    }
    
}