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
<div class="admin-container">
    <h1>Ajouter un thème</h1>
    <form method="post">
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
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="url_image">URL Image</label>
            <input type="text" class="form-control" name="url_image">
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
    </form>
 </div>

<script type="text/javascript">document.page = "ajouter"</script>