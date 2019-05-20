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
    private $bdd;
    private $iter_question;
    
    public function __construct($theme) {
        $this->bdd = \App::getInstance()->getBdd();

        $theme = $this->bdd->prepare("SELECT * FROM theme WHERE key_nom = ?", [$theme], null, true);
        if (empty($theme)) {
            $this->theme = null;
        } else {
            $this->theme = $theme;
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
            $this->iter_question = 1;
            if (isset($_POST['score']) && isset($_POST['id_question']) && isset($_POST['iter_question'])) {
                $this->stocker_score($_POST['score'], $_POST['id_question']);
                $this->iter_question = $_POST['iter_question'] + 1;
            }
            if ($this->iter_question > 10) {
                $this->end();
            } else {
                $this->question($this->theme->id);
            }
        } else {
            $id_session = rand(100, 100000);
            $this->id_session = $id_session;
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
        ", [$theme_id, $this->id_session],null, true);
        if (empty($question)) {
            include ROOT . '/pages/quizz/vide.php';
        } else {
            $question = $question;
            $question->iter = $this->iter_question;
            $id_session = $this->id_session;
            include ROOT.'/pages/quizz/question.php';
        }
    }
    
    public function start ($theme, $id_session) {
        include ROOT . '/pages/quizz/debut.php';
    }
    public function end () {
        $calcul = $this->bdd->prepare("SELECT SUM(score) as score
                                               FROM historique_session
                                               WHERE id_session = ?", [$this->id_session]);
        $this->theme->score = $calcul[0]->score;
        $theme = $this->theme;
        // $avg = $this->bdd->prepare("SELECT AVG(score) as moyenne
        //                                 FROM (SELECT SUM(score) as score
        //                                       FROM historique_session
        //                                       LEFT JOIN question ON historique_session.question_id = question.id
        //                                       WHERE question.theme_id = ?
        //                                         GROUP BY id_session) as scores", [$this->theme->id]);
        
        // $theme->avg_score = $avg[0]->moyenne;
        
        include ROOT . '/pages/quizz/fin.php';
        
    }
    
    public function stocker_score ($score, $id_question) {
        $this->bdd->prepare('INSERT INTO historique_session VALUES(NULL, ?, ?, ?)', [$this->id_session, $id_question, $score]);
    }
    
}