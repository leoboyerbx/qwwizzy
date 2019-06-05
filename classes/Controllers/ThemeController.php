<?php
/**
 * Classe chargée de controller le déroulement d'un quizz. Elle envoie la vue correspondante selon la situation.
 * Chaque vue renvoie ensuite en POST la progression.
 * 
*/

namespace Controllers;



class ThemeController {
    private $theme;
    private $id_session;
    private $bdd;
    private $iter_question;

    /**
     * ThemeController constructor.
     * @param $theme: le nom clef du thème
     */
    public function __construct($theme) {
        // On récupère la connexion à la base de données pour pouroivr l'utilise plus tard.
        $this->bdd = \App::getInstance()->getBdd();
        // Requete pour récupérer le thème. Si il y a un résultat alors le thème existe. Sinon on informe que le thème n'existe pas.
        $theme = $this->bdd->prepare("SELECT * FROM theme WHERE key_nom = ?", [$theme], null, true);
        if (empty($theme)) {
            $this->theme = null;
        } else {
            $this->theme = $theme;
        }
    }

    /**
     * Méthode appelée à chaque chargement du thème. Elle envoie une page spécifique si le thème n'existe pas.
     */
    public function quizz () {
        if ($this->theme === null) {
            include ROOT . '/pages/quizz/inexistant.php';
        } else {
            $this->auto();
        }
    }

    /**
     * Méthode chargée de déterminer l'action à effectuer en fonction du contexte. Il y a 3 cas de figure:
     *  * Le début du quizz: pas de données en POST: il faut définir un identifiants de session et envoyer la page d'accueil du thème
     *  * Durant le quizz: Il faut tirer une question au hasard et l'afficher, et stocker le score
     *  * A la fin du quizz: il faut calculer et afficher le score.
     * Pour cela on utilise la table historique_session où on enregistre le core de chaque question pour chaque session.
     */
    public function auto() {
        if (!empty($_POST['id_session'])) {
            /** Si on a reçu un identifiant de session, on doit soit afficher une question, soit le score final.
             * On commence par retenir l'identifiant de session dans l'objet.
             */
            $this->id_session = $_POST['id_session'];
            // Par défaut, on fixe l'identifiant de la question qu'on va envoyer à 1.
            $this->iter_question = 1;
            if (isset($_POST['score']) && isset($_POST['id_question']) && isset($_POST['iter_question'])) {
                /**
                 * Si on a reçu une donnée de score, un id de question et un numéro d'itération, alors il y a déjà eu une question précédente.
                 * On stocke donc le score effectué à la question précédente, et on incrément l'itération de question de 1.
                 */
                $this->stocker_score($_POST['score'], $_POST['id_question']);
                $this->iter_question = $_POST['iter_question'] + 1;
            }
            if ($this->iter_question > 10) {
                /**
                 * Si l'incrémentation des questions dépasse 10, il faut finir la partie, on appelle le méthode end().
                 */
                $this->end();
            } else {
                /**
                 * Sinon on envoie une question.
                 */
                $this->question($this->theme->id);
            }
        } else {
            /**
             * Cas de base: on définit un identifiant de session au hasard en partant du principe qu'il sera unique. On le stocke dans l'objet et on appelle la méthode start()
             */
            $id_session = rand(100, 100000);
            $this->id_session = $id_session;
            $this->start($this->theme, $id_session);
        }
    }

    /**
     * Méthode chergée d'envoyer une question tirée au hasard dans le thème passé en paramètre. La question ne doit pas avoir été éjà envoyée.
     * @param $theme_id L'identifiant du thème
     */
    public function question($theme_id) {
        // On fait un requête SQL qui récupère une question au hasard là où le noméro de thème correspond, et qui n'est pas dans celles déjà jouées lors de la même session.
        $question = $this->bdd->prepare("
            SELECT * FROM question
            WHERE theme_id = ?
                AND question.id NOT IN (
                    SELECT question_id FROM historique_session WHERE id_session = ?
                )
            ORDER BY rand()
            LIMIT 1
        ", [$theme_id, $this->id_session],null, true); // Note: on définit le dernier paramètre sur true pour ne pas avoir un tableau (on ne cherche qu'un seul résultat) - cf Classe MysqlBDD.
        if (empty($question)) {
            /**
             * S'il n'y a plus de questions dans le thème, on envoie une vue qui propose de revenir à l'accueil.
             */
            include ROOT . '/pages/quizz/vide.php';
        } else {
            /**
             * Sinon on définit ajoute une propriété iter à l'objet question renvoyé par la base de données, on renseigne l'id de session, et on envoie la page question.php
             */
            $question->iter = $this->iter_question;
            $id_session = $this->id_session;
            include ROOT.'/pages/quizz/question.php';
        }
    }

    /**
     * Envoie simplement la page de début de partie.
     * @param $theme
     * @param $id_session
     */
    public function start ($theme, $id_session) {
        include ROOT . '/pages/quizz/debut.php';
    }

    /**
     * Méthode appelée à la fin, calcule le score et affiche la page finale.
     */
    public function end () {
        // On fait la somme des scores (sachant qu'une bonne réponse vaut 1 et une mauvaise vaut 0, la somme correspondra au nombre de bonnes réponses.
        $calcul = $this->bdd->prepare("SELECT SUM(score) as score
                                               FROM historique_session
                                               WHERE id_session = ?", [$this->id_session]);
        $this->theme->score = $calcul[0]->score;
        $theme = $this->theme;
        
        include ROOT . '/pages/quizz/fin.php';
        
    }

    /**
     * Envoie une requête à la base de données pour sstocker le score de la question dans "historique_session"
     * @param $score
     * @param $id_question
     */
    public function stocker_score ($score, $id_question) {
        $this->bdd->prepare('INSERT INTO historique_session VALUES(NULL, ?, ?, ?)', [$this->id_session, $id_question, $score]);
    }
    
}