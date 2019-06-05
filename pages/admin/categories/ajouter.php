<?php

$app = \App::getInstance();
$bdd = $app->getBdd();

if(isset($_POST['key_nom']) AND isset($_POST['nom']) AND isset($_POST['description']) AND isset($_POST['icon'])){ //envoi des données si renseignées
    $result = $bdd -> prepare('INSERT into categorie(key_nom, nom, description, icon) values (:key_nom, :nom, :description, :icon)', array("key_nom" => $_POST['key_nom'], "nom" => $_POST['nom'], "description" => $_POST['description'], "icon" => $_POST['icon']));
    if($result){
        $app->set_flash('success', 'Catégorie ajoutée avec succès');
        header('Location: /admin/categories');
    }
    
}
?>

<!--Plugin editeur de texte-->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<div class="admin-container">
    <h1>Ajouter une catégorie</h1>
    <form method="post" class="form-editeur">
        <div class="form-group">
            <label for="key_nom">Nom d'url <i>(Automatique, double-cliquer pour personnaliser)</i></label>
            <input type="text" class="form-control" name="key_nom" readonly>
        </div>
        <div class="form-group">
            <label for="nom">Nom de la catégorie</label>
            <input type="text" class="form-control" name="nom">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="hidden" name="description" id="editeurval" />
            <div id="editeur">
            </div>
        </div>
        <div class="form-group">
            <label for="url_image">Code icône (voir <a href="https://fontawesome.com/icons">FontAwesome</a>)</label>
            <div class="row">
                <div class="col-1 center">
                    <i id="icon-preview"></i>
                </div>
                <div class="col-11">
                    <input type="text" class="form-control" name="icon" id='icon'>
                </div>
            </div>
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
        <a class="btn btn-outline-secondary btn-retour" href="/admin/categories">Retour</a>
    </form>
 </div>

<script defer src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script defer src="/assets/js/admin/keynom.js" type="text/javascript"></script>
<script defer src="/assets/js/admin/editeur.js"></script>
<script defer src="/assets/js/admin/autoicon.js"></script>