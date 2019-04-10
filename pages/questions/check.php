<?php
$bdd = App::getInstance()->getBdd();
$question = $bdd->prepare('SELECT * FROM question WHERE id = ?', [$_POST['question_id']], true);
if (!empty($question)) {
    $juste = $question[0]->reponse === $_POST['reponse'];
    $texte_reponse = $question[0]->texte_reponse;
    
    if ($juste) {
        $textval = $question[0]->reponse ? 'VRAI': 'FAUX' ;
        $texte_reponse = '<span>Bravo ! Bonne réponse.</span> La réponse est '. $textval . '. ' . $texte_reponse;
    }
    echo json_encode([
            "juste" => $juste,
            "texte_reponse" => $texte_reponse
        ]);
}