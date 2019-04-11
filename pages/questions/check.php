<?php
$bdd = App::getInstance()->getBdd();
$question = $bdd->prepare('SELECT * FROM question WHERE id = ?', [$_POST['question_id']], true);
if (!empty($question)) {
    $juste = $question[0]->reponse === $_POST['reponse'];
    $texte_reponse = $question[0]->texte_reponse;
    
    $textval = $question[0]->reponse ? 'VRAI': 'FAUX' ;
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