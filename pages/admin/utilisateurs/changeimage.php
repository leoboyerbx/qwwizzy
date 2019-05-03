<?php
$app = \App::getInstance();

if (!empty($_FILES['photo'])) {
    $user = $auth->getUser();
    $maxsize = 8388608;
    if ($_FILES['photo']['error'] > 0) $erreur = "Erreur lors du transfert";
    if ($_FILES['icone']['size'] > $maxsize) $erreur = "Le fichier est trop gros";
    $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
    $extension_upload = strtolower(  substr(  strrchr($_FILES['icone']['name'], '.')  ,1)  );
    if (!in_array($extension_upload,$extensions_valides) ) $erreur = "Extension incorrecte: uniquement des fichiers jpg ou png";
    if (empty($erreur)) {
        $nom = "avatar_{$id_membre}.{$extension_upload}";
        $path = ROOT . "public/users/avatars/$nom";
        if (move_uploaded_file($_FILES['icone']['tmp_name'],$path) {
            
        }
    } else {
        $app->set_flash('danger', "Une erreur s'est produite: $erreur");
    }
}


?>
<div class="admin-container">
<?= $app->get_flash() ?>
    <h1>Changer mon image de profil</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleFormControlFile1">Choisir une photo</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="8388608" />

            <input type="file" class="form-control-file" name="photo">
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
        <a class="btn btn-outline-secondary" href="/admin">Annuler</a>
    </form>
</div>
