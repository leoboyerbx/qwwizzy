<?php
$bdd = App::getInstance()->getBdd();
$question = $bdd->prepare('SELECT * FROM question WHERE id = ?', [$_POST['question_id']],null, true);
if (!empty($question)) {
    $juste = $question->reponse === $_POST['reponse'];
    $texte_reponse = $question->texte_reponse;
    
    $textval = $question->reponse ? 'VRAI': 'FAUX' ;
    if ($juste) {
        $texte_reponse = '<span>Bravo ! Bonne réponse.</span> La réponse est '. $textval . '. ' . $texte_reponse;
    } else {
        $texte_reponse = '<span>Désolé ! Mauvaise réponse.</span> La réponse est '. $textval . '. ' . $texte_reponse;
    }
    echo json_encode([
            "juste" => $juste,
            "texte_reponse" => $texte_reponse
        ]);
}