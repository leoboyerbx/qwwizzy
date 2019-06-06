<?php

$app = \App::getInstance();
$bdd = $app->getBdd();

$auth = new Bdd\Auth($app->getBdd());
$user = $auth->getUser();
$user->id;

if(isset($_POST['question']) AND isset($_POST['vf']) AND isset($_POST['txtrep']) AND isset($_POST['url_image']) AND isset($_POST['theme'])){ //envoi des données pour enregistrement si renseignées en post
    $result = $bdd -> prepare('INSERT into question(question, reponse, texte_reponse, url_image, theme_id, auteur_id) values (:question, :reponse, :texte_reponse, :url_image, :theme_id, :auteur_id)', array("question" => $_POST['question'], "reponse" => $_POST['vf'], "texte_reponse" => $_POST['txtrep'], "theme_id" => $_POST['theme'], "url_image" => $_POST['url_image'], "auteur_id" => $user -> id));
    if($result){//succès = message positif et redirection vers liste
        $app->set_flash('success', 'Question ajoutée avec succès');
        header('Location: /admin/questions');
        die();
    }
}


if (isset($id_theme)) { //récuperation du nom de thème via l'id
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
    <?= $app->get_flash() ?><!--On utilise le message positif pour monter que l'action précédente a réussi-->
    <form method="post" class="form-editeur">
        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" class="form-control" name="question" id="admin-question">
        </div>
        <div class="form-group">
            <input type=radio id=vrai name=vf value=1> <label for=vrai>Vrai</label><br>
            <input type=radio id=faux name=vf value=0> <label for=faux>Faux</label>
        </div>
        <div class="form-group">
            <label for="txtrep">Texte réponse</label>
            <input type="hidden" name="txtrep" id="editeurval" />
            <div id="editeur">
            </div>
        </div>
        <?php
        if (!empty($reponse)) {//si on a une réponse de la bdd, on assigne aux inputs les noms des différents champs de la bdd
            ?>
            <div class="form-group">
            <label for="theme">La question appartient au thème</label>
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
        
        <div class="row" id="edit-imgbloc">
            <div class="col-md-3">
                <div class="squareimg" id="preview-image"></div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="url_image">URL de l'Image</label>
                    <input type="text" class="form-control" id="url_image" name="url_image">
                </div>
            </div>
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
        <a class="btn btn-outline-secondary btn-retour" href="/admin/questions">Retour</a>
    </form>
 </div>

<script defer src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script defer src="/assets/js/admin/editeur.js"></script>
<script defer src="/assets/js/admin/preview-img.js"></script>