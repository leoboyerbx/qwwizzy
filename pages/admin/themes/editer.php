<?php
// LÉO BOSSE SUR CE FICHIER


$app = \App::getInstance();
$bdd = $app->getBdd();

if(isset($_POST['key_nom']) AND isset($_POST['nom']) AND isset($_POST['description']) AND isset($_POST['url_image'])){ //envoi des données si renseignées
    $result = $bdd -> prepare('UPDATE  theme SET key_nom= :key_nom, nom= :nom, description= :description, url_image= :url_image', array("key_nom" => $_POST['key_nom'], "nom" => $_POST['nom'], "description" => $_POST['description'], "url_image" => $_POST['url_image']));
    if($result){
        $app->set_flash('success', 'Thème modifié avec succès');
        header('Location: /admin/themes');
    }
    
} else {
    $result = $bdd -> prepare('SELECT * FROM theme WHERE id= ?', [$id_theme], true);
    if ($result) {
        $theme = $result[0];
        ?>
        
        
<div class="admin-container">
    <h1>Modifier le thème <i><?= $theme->nom ?></i></h1>
    <form method="post">
        <div class="form-group">
            <label for="key_nom">Nom d'url <i>(Automatique, double-cliquer pour personnaliser)</i></label>
            <input type="text" class="form-control" name="key_nom" value="<?= $theme->key_nom ?>" readonly>
        </div>
        <div class="form-group">
            <label for="nom">Nom du thème</label>
            <input type="text" class="form-control" name="nom" value="<?= $theme->nom ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" value="<?= $theme->description ?>"></textarea>
        </div>
        <div class="form-group">
            <label for="url_image">URL Image</label>
            <input type="text" class="form-control" name="url_image" value="<?= $theme->url_image ?>">
        </div>
        <input type=submit class="btn btn-primary" value="Ajouter">
    </form>
 </div>
 
 <script type="text/javascript">document.page="edit"</script>
        <?php
    } else {
        $app->set_flash('danger', "Le thème demandé est introuvable.");
        header('Location: /admin/themes');
    }
}
?>