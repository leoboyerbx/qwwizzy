<?php
$app = \App::getInstance();
$bdd = $app->getBdd();

if (!empty($_FILES['photo'])) {
    $user = $auth->getUser();
    $nom = "avatar_{$user->id}.{$extension_upload}";
    $path = ROOT . "/public/users/avatars/$nom";
    
    $upload = $app->upload($_FILES['photo'], $path);
    
    if ($upload['success']) {
        $result = $bdd->prepare('UPDATE utilisateur SET avatar = ? WHERE id = ?', [$nom, $user->id]);
        if($result) {
            $app->set_flash('success', "Photo modifiée avec succès");
            $auth->set_user_property('avatar', $nom);
            header('Location: /admin');
            die();
        }
    } else {
        $app->set_flash('danger', "Une erreur s'est produite: ". $upload['error']);
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
