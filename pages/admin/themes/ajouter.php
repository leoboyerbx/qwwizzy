<?php

$app = \App::getInstance();
$bdd = $app->getBdd();

if(isset($_POST['key_nom']) AND isset($_POST['nom']) AND isset($_POST['description']) AND isset($_POST['url_image'])){ //envoi des données si renseignées
    $result = $bdd -> prepare('INSERT into theme(key_nom, nom, description, url_image) values (:key_nom, :nom, :description, :url_image)', array("key_nom" => $_POST['key_nom'], "nom" => $_POST['nom'], "description" => $_POST['description'], "url_image" => $_POST['url_image']));
    if($result){
        $app->set_flash('success', 'Thème ajouté avec succès');
        header('Location: /admin/themes');
    }
    
}
?>

<!--Plugin editeur de texte-->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<div class="admin-container">
    <h1>Ajouter un thème</h1>
    <form method="post" class="form-editeur">
        <div class="form-group">
            <label for="key_nom">Nom d'url <i>(Automatique, double-cliquer pour personnaliser)</i></label>
            <input type="text" class="form-control" name="key_nom" readonly>
        </div>
        <div class="form-group">
            <label for="nom">Nom du thème</label>
            <input type="text" class="form-control" name="nom">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="hidden" name="description" id="editeurval" />
            <div id="editeur">
            </div>
        </div>
        <div class="form-group">
            <label for="url_image">URL Image</label>
            <input type="text" class="form-control" name="url_image" id='url_image'>
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
    </form>
 </div>

<script defer src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script defer src="/assets/js/admin/edittheme.js" type="text/javascript"></script>
<script defer src="/assets/js/admin/editeur.js"></script>