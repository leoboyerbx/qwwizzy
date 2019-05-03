<?php
$app = \App::getInstance();

if (!empty($_POST['photo'])) {
    $user = $auth->getUser();
    
}


?>
<div class="admin-container">
<?= $app->get_flash() ?>
    <h1>Changer mon image de profil</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleFormControlFile1">Choisir une photo</label>
            <input type="file" class="form-control-file" name="photo">
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
        <a class="btn btn-outline-secondary" href="/admin">Annuler</a>
    </form>
</div>
