<?php


$app = \App::getInstance();
$bdd = $app->getBdd();

if(isset($_POST['key_nom']) AND isset($_POST['nom']) AND isset($_POST['description']) AND isset($_POST['url_image']) AND isset($_POST['couleur'])){ //envoi des données si renseignées
    $featured = 0;
    if($_POST['featured']) {
        $featured = 1;
    }
    $couleur = "#".strtolower($_POST['couleur']);
    $result = $bdd -> prepare('UPDATE  theme SET key_nom= :key_nom, nom= :nom, description= :description, url_image= :url_image, couleur= :couleur, featured = :featured WHERE id= :id_theme', array("key_nom" => $_POST['key_nom'], "nom" => $_POST['nom'], "description" => $_POST['description'], "url_image" => $_POST['url_image'],"couleur" => $couleur, "featured" => $featured, "id_theme" => $id_theme));
    if($result){
        $app->set_flash('success', 'Thème modifié avec succès');
        header('Location: /admin/themes');
    }
    
} else if (!empty($_POST)) {
    $app->set_flash('danger', "Un erreur s'est produite: certains champs ne sont pas remplis.");
} else {
    $result = $bdd -> prepare('SELECT * FROM theme WHERE id= ?', [$id_theme], null, true);
    if ($result) {
        $theme = $result;
        ?>
        
        

<!--Plugin editeur de texte-->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<div class="admin-container">
    <h1>Modifier le thème <i><?= $theme->nom ?></i></h1>
    <form method="post" class="form-editeur">
        <div class="form-group">
            <label for="key_nom">Nom d'url <i>(Automatique, double-cliquer pour personnaliser)</i></label>
            <input type="text" class="form-control" name="key_nom" value="<?= $theme->key_nom ?>" readonly>
        </div>
        <div class="form-group">
            <label for="nom">Nom du thème</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= $theme->nom ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            
            <input type="hidden" name="description" id="editeurval" />
            <div id="editeur">
                <?= $theme->description ?>
            </div>
            
        </div>
        <div class="row" id="edit-imgbloc">
            <div class="col-md-3">
                <div class="squareimg" id="preview-image" style="background-image: url(<?= $theme->url_image ?>)"></div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="url_image">URL de l'Image</label>
                    <input type="text" class="form-control" id="url_image" name="url_image" value="<?= $theme->url_image ?>">
                </div>
                <div class="form-group">
                    <label for="couleur">Couleur correspondante</label>
                    <input type="text" class="form-control jscolor" name="couleur" id="couleur" value="<?= $theme->couleur ?>">
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="featured" id="featured" <?= $theme->featured ? 'checked=checked' : '' ?>>
                  <label class="form-check-label" for="featured">
                    Thème mis en avant
                  </label>
                </div>
            </div>
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
        <a class="btn btn-outline-secondary btn-retour" href="/admin/themes">Retour</a>
    </form>
 </div>
 
 
 
<script defer src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script defer src="/assets/js/lib/jscolor.js"></script>
<script defer src="/assets/js/admin/edittheme.js" type="text/javascript"></script>
<script defer src="/assets/js/admin/preview-img.js"></script>
<script defer src="/assets/js/admin/editeur.js" type="text/javascript"></script>

        <?php
    } else {
        $app->set_flash('danger', "Le thème demandé est introuvable.");
        header('Location: /admin/themes');
    }
}
?>