<?php

$app = \App::getInstance();
$bdd = $app->getBdd();

if(isset($_POST['key_nom']) AND isset($_POST['nom']) AND isset($_POST['description']) AND isset($_POST['url_image']) AND isset($_POST['couleur'])){ //envoi des données si renseignées pour enregistrement
    $result = $bdd -> prepare('INSERT into theme(key_nom, nom, description, url_image, couleur) values (:key_nom, :nom, :description, :url_image, :couleur)', array("key_nom" => $_POST['key_nom'], "nom" => $_POST['nom'], "description" => $_POST['description'], "url_image" => $_POST['url_image'], "couleur" => $_POST['couleur']));
    if($result){//succès = envoi message positif et retour page liste themes
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
        <div class="row" id="edit-imgbloc">
            <div class="col-md-3">
                <div class="squareimg" id="preview-image"></div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="url_image">URL de l'Image</label>
                    <input type="text" class="form-control" id="url_image" name="url_image" >
                </div>
                <div class="form-group">
                    <label for="couleur">Couleur correspondante</label>
                    <input type="text" class="form-control jscolor" name="couleur" id="couleur">
                </div>
            </div>
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
        <a class="btn btn-outline-secondary btn-retour" href="/admin/themes">Retour</a>
    </form>
 </div>

<script defer src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script defer src="/assets/js/lib/jscolor.js"></script>
<script defer src="/assets/js/admin/keynom.js" type="text/javascript"></script>
<script defer src="/assets/js/admin/preview-img.js"></script>
<script defer src="/assets/js/admin/editeur.js"></script>