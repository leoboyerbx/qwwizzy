<?php


$app = \App::getInstance();
$bdd = $app->getBdd();
$auth = new Bdd\Auth($bdd);
$user = $auth->getUser();


$question = $bdd -> prepare('SELECT * FROM question WHERE id= ?', [$id_question], null, true);

if (!$auth->verif_permissions(7) && $question && $question->auteur_id != $user->id) { //  Si l'auteur n'a pas le droit de modifier la question
    $app->set_flash('danger', "Vous n'avez pas le droit de modifier cette question, car vous n'en êtes pas l'auteur.");
    header('Location: /admin/questions');
    die();
}



if(isset($_POST['question']) AND isset($_POST['vf']) AND isset($_POST['txtrep']) AND isset($_POST['theme']) AND isset($_POST['url_image'])){ //envoi des données si renseignées
    $result = $bdd -> prepare('UPDATE  question SET question= ?, reponse = ?, texte_reponse = ?, theme_id=?, url_image= ? WHERE id= ?', array($_POST['question'], $_POST['vf'], $_POST['txtrep'], $_POST['theme'], $_POST['url_image'], $id_question));
    if($result){
        $app->set_flash('success', 'Question modifiée avec succès');
        header('Location: /admin/questions');
        die();
    } else {
        $app->set_flash('danger', "Une erreur s'est produite.");
    }

} else {
    
    if ($question) {
        $themes = $bdd -> query("SELECT nom, id from theme");
        


?>

<!--Plugin editeur de texte-->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="admin-container">
    <h1>Modifier une question</h1>
    <?= $app->get_flash() ?>
    <form method="post" class="form-editeur">
        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" class="form-control" name="question" id="admin-question" value="<?= $question->question ?>">
        </div>
        <div class="form-group">
            <label for=vrai>Vrai</label><input type=radio id=vrai name=vf value=1 <?php if($question->reponse == "1") echo "checked"; ?>><label for=faux>Faux</label><input type=radio id=faux name=vf value=0 <?php if($question->reponse == "0") echo "checked"; ?>>
        </div>
        <!--<div class="btn-group btn-group-toggle" id="vraifaux">-->
        <!--  <label class="btn btn-secondary">-->
        <!--    <input type="radio" name="vf" id="option1" autocomplete="off" value="1"> Vrai-->
        <!--  </label>-->
        <!--  <label class="btn btn-secondary">-->
        <!--    <input type="radio" name="vf" id="option2" autocomplete="off" value="0"> Faux-->
        <!--  </label>-->
        <!--</div>-->
        <div class="form-group">
            <label for="txtrep">Texte réponse</label>
            <input type="hidden" class="form-control" name="txtrep" id="editeurval" />
            <div id="editeur">
                <?= $question->texte_reponse ?>
            </div>
        </div>
        <div class="form-group">
            <label for="url_image">URL Image</label>
            <input type="text" class="form-control" name="url_image" id=url_image value="<?= $question->url_image ?>">
        </div>
            <div class="form-group">
            <label for="theme">Thème de la question</label>
            <select name="theme" id="theme" class="form-control">
                <?php
                
                foreach ($themes as $theme){
                    if ($theme->id == $question->theme_id) {
                        echo('<option neme="theme" selected value=' . $theme -> id . '>' . $theme -> nom . '</option>');
                        
                    } else {
                        echo('<option value=' . $theme -> id . '>' . $theme -> nom . '</option>');
                        
                    }
                }
                
                ?>
            </select>
        </div>
        
        <input type=submit class="btn btn-primary" value="Enregistrer">
    </form>
    
    
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script defer src="/assets/js/admin/editeur.js"></script>
 </div>
        <?php
    } else {
        $app->set_flash('danger', "La question demandée est introuvable.");
        header('Location: /admin/questions');
    }
}
?>