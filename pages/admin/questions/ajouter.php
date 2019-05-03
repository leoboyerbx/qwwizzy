<?php

$app = \App::getInstance();
$bdd = $app->getBdd();

if(isset($_POST['question']) AND isset($_POST['vf']) AND isset($_POST['txtrep']) AND isset($_POST['url_image']) AND isset($_POST['theme'])){ //envoi des données si renseignées
    $result = $bdd -> prepare('INSERT into question(id, nom, description, url_image) values (:key_nom, :nom, :description, :url_image)', array("key_nom" => $_POST['key_nom'], "nom" => $_POST['nom'], "description" => $_POST['description'], "url_image" => $_POST['url_image']));
    if($result){
        $app->set_flash('success', 'Question ajoutée avec succès');
        header('Location: /admin/questions');
    }
    
}

$reponse = $bdd -> query("SELECT nom, id from theme")

?>



<div class="admin-container">
    <h1>Ajouter une question</h1>
    <form method="post">
        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" class="form-control" name="question" id=question>
        </div>
        <div class="form-group">
            <label for=vrai>Vrai</label><input type=radio id=vrai name=vf value=1><label for=faux>Faux</label><input type=radio id=faux name=vf value=0>
        </div>
        <div class="form-group">
            <label for="txtrep">Texte réponse</label>
            <textarea class="form-control" name="txtrep" id=txtrep></textarea>
        </div>
        <div class="form-group">
            <label for="url_image">URL Image</label>
            <input type="text" class="form-control" name="url_image" id=url_image>
        </div>
        <div class="form-group">
            <label for="theme">Thème de la question</label>
            <select name="theme" id="theme">
                <?php
                
                foreach ($reponse as $question){
                    echo('<option value=' . $question -> id . '>' . $question -> nom . '</option>');
                }
                
                ?>
            </select>
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
    </form>
 </div>

<script type="text/javascript">document.page = "ajouter"</script>