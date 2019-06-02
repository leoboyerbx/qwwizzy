<?php


$app = \App::getInstance();
$bdd = $app->getBdd();
if(isset($_POST['key_nom']) && isset($_POST['nom']) AND isset($_POST['description']) AND isset($_POST['icon'])){ //envoi des données si renseignées
    $result = $bdd -> prepare('UPDATE categorie SET key_nom= :key_nom, nom= :nom, description= :description, icon= :icon WHERE id= :id_categorie', array("key_nom" => $_POST['key_nom'], "nom" => $_POST['nom'], "description" => $_POST['description'], "icon" => $_POST['icon'], "id_categorie" => $id_categorie));
    if($result){
        $app->set_flash('success', 'Catégorie modifié avec succès');
        header('Location: /admin/categories');
    } else {
        $app->set_flash('danger', "Une erreur s'est produite ua niveau de la base de données
        ");
    }
    
} else {
    $result = $bdd -> prepare('SELECT * FROM categorie WHERE id= ?', [$id_categorie], null, true);
    if ($result) {
        $categorie = $result;
        ?>
        
        

<!--Plugin editeur de texte-->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<div class="admin-container">
    <h1>Modifier la catégorie <i><?= $categorie->nom ?></i></h1>
    <form method="post" class="form-editeur">
        <div class="form-group">
            <label for="key_nom">Nom d'url <i>(Automatique, double-cliquer pour personnaliser)</i></label>
            <input type="text" class="form-control" name="key_nom" value="<?= $categorie->key_nom ?>" readonly>
        </div>
        <div class="form-group">
            <label for="nom">Nom de la catégorie</label>
            <input type="text" class="form-control" name="nom" value="<?= $categorie->nom ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            
            <input type="hidden" name="description" id="editeurval" />
            <div id="editeur">
                <?= $categorie->description ?>
            </div>
            
        </div>
        <div class="form-group">
            <label for="url_image">Code icône (voir <a href="https://fontawesome.com/icons">FontAwesome</a>)</label>
            <div class="row">
                <div class="col-1 center">
                    <i id="icon-preview" class="fas fa-<?= $categorie->icon ?>"></i>                    
                </div>
                <div class="col-11">
                    <input type="text" class="form-control" name="icon" id='icon' value="<?= $categorie->icon ?>">
                </div>
            </div>
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
        <a class="btn btn-outline-secondary btn-retour" href="/admin/categories">Retour</a>
    </form>
 </div>
 
 
 
<script defer src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script defer src="/assets/js/admin/keynom.js" type="text/javascript"></script>
<script defer src="/assets/js/admin/editeur.js" type="text/javascript"></script>
<script defer src="/assets/js/admin/autoicon.js" type="text/javascript"></script>

        <?php
    } else {
        $app->set_flash('danger', "La catégorie demandée est introuvable.");
        header('Location: /admin/categories');
    }
}
?>