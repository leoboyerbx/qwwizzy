<?php
/**
 * Page chargée uniquement de dire si la question est bonne, et qui envoie le texte de la réponse.
 * Cette page est appelée par le script question.js
 */
// On commence par charger la BDD
$bdd = App::getInstance()->getBdd();
// On récupère la question demandée
$question = $bdd->prepare('SELECT * FROM question WHERE id = ?', [$_POST['question_id']],null, true);
if (!empty($question)) {
    /**
     * Si la question existe, on vérifie si la réponse fournie correspond
     */
    $juste = $question->reponse === $_POST['reponse'];
    $texte_reponse = $question->texte_reponse;

    // On prépare un texte de réponse
    $textval = $question->reponse ? 'VRAI': 'FAUX' ;
    if ($juste) {
        $texte_reponse = '<span>Bravo ! Bonne réponse.</span> La réponse est '. $textval . '. ' . $texte_reponse;
    } else {
        $texte_reponse = '<span>Désolé ! Mauvaise réponse.</span> La réponse est '. $textval . '. ' . $texte_reponse;
    }
//    On renvoie un tableau associatif au format json
    echo json_encode([
            "juste" => $juste,
            "texte_reponse" => $texte_reponse
        ]);
}