<?php

$app = \App::getInstance();
$bdd = $app->getBdd();

$auth = new Bdd\Auth($app->getBdd());
$user = $auth->getUser();
$user->id;

if(isset($_POST['question']) AND isset($_POST['vf']) AND isset($_POST['txtrep']) AND isset($_POST['url_image']) AND isset($_POST['theme'])){ //envoi des données si renseignées
    $result = $bdd -> prepare('INSERT into question(question, reponse, texte_reponse, url_image, theme_id, auteur_id) values (:question, :reponse, :texte_reponse, :url_image, :theme_id, :auteur_id)', array("question" => $_POST['question'], "reponse" => $_POST['vf'], "texte_reponse" => $_POST['txtrep'], "theme_id" => $_POST['theme'], "url_image" => $_POST['url_image'], "auteur_id" => $user -> id));
    if($result){
        $app->set_flash('success', 'Question ajoutée avec succès');
        header('Location: /admin/questions');
        die();
    }
    
}





if (isset($id_theme)) {
    $theme = $bdd->prepare('SELECT nom FROM theme WHERE id= ?', [$id_theme]);
    if(!$theme) {
        $app->set_flash('danger', "Une erreur s'est produite");
    } else {
        $theme = $theme[0]->nom;
    }
} else {
    $reponse = $bdd -> query("SELECT nom, id from theme");
}

?>



<!--Plugin editeur de texte-->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<div class="admin-container">
    <h1>Ajouter une question<?= !empty($theme) ? " au thème ".$theme : "" ?></h1>
    <?= $app->get_flash() ?>
    <form method="post" class="form-editeur">
        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" class="form-control" name="question" id="admin-question">
        </div>
        <div class="form-group">
            <label for=vrai>Vrai</label><input type=radio id=vrai name=vf value=1><label for=faux>Faux</label><input type=radio id=faux name=vf value=0>
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
            <input type="hidden" name="txtrep" id="editeurval" />
            <div id="editeur">
            </div>
        </div>
        <div class="form-group">
            <label for="url_image">URL Image</label>
            <input type="text" class="form-control" name="url_image" id="url_image">
        </div>
        <?php
        if (!empty($reponse)) {
            ?>
            <div class="form-group">
            <label for="theme">Thème de la question</label>
            <select name="theme" id="theme" class="form-control">
                <?php
                
                foreach ($reponse as $question){
                    echo('<option value=' . $question -> id . '>' . $question -> nom . '</option>');
                }
                
                ?>
            </select>
        </div>
            <?php
        } else {
        ?><input type="hidden" name="theme" id="theme" value="<?= $id_theme ?>" /><?php
        }
        ?>
        
        <input type=submit class="btn btn-primary" value="Enregistrer">
    </form>
 </div>

<script defer src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script defer src="/assets/js/admin/editeur.js"></script>