<?php

$app = \App::getInstance();
$bdd = $app->getBdd();

if(isset($_POST['pseudo']) AND isset($_POST['email']) AND isset($_POST['permissions'])){ //envoi des données si renseignées
    if (!empty($_POST['newpass'])) {
        $pass_hash = password_hash($_POST['newpass'], PASSWORD_DEFAULT);
        $result = $bdd -> prepare('UPDATE utilisateur set pseudo = ?, email = ?, pass_hash = ?, permissions = ? WHERE id= ?', array($_POST['pseudo'], $_POST['email'], $pass_hash, $_POST['permissions'], $id_user));
    } else {
        $result = $bdd -> prepare('UPDATE utilisateur set pseudo = ?, email = ?, permissions = ? WHERE id= ?', array($_POST['pseudo'], $_POST['email'], $_POST['permissions'], $id_user));
    }
    if($result){
        $app->set_flash('success', 'Utilisateur modifié avec succès');
        header('Location: /admin/utilisateurs');
        die();
    } else {
        $app->set_flash('danger', 'Une erreur s\'est produite');
    }
    
} else {
    $user = $bdd -> prepare('SELECT * FROM utilisateur WHERE id= ?', [$id_user], "\\Entites\\UserEntity", true);
    if (!$user) {
        $app->set_flash('danger', "L'utilisateur n'existe pas.");
        header('Location: /admin/utilisateurs');
        die();
    }
}
?>
<div class="admin-container">
    <h1>Modifier l'utilisateur</h1>
    <form method="post">
        <div class="form-group">
            <label for="key_nom">Pseudo</label>
            <input type="text" class="form-control" name="pseudo" value="<?= $user->pseudo ?>">
        </div>
        <div class="form-group">
            <label for="nom">E-mail</label>
            <input type="email" class="form-control" name="email" value="<?= $user->email ?>">
        </div>
        <div class="form-group">
            <label for="url_image">Nouveau mot de passe <i>Laisser vide si inchangé</i></label>
            <input type="password" class="form-control" name="newpass">
        </div>
        <div class="form-group">
            <label for="permis">Niveau d'accréditation</label>
            <select name="permissions" id="permis" class="form-control">
                <option value="5" <?php if($user->permissions == "5") echo "selected"; ?>>Auteur</option>
                <option value="7" <?php if($user->permissions == "7") echo "selected"; ?>>Editeur</option>
                <option value="10" <?php if($user->permissions == "10") echo "selected"; ?>>Administrateur</option>
            </select>
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
        <a href="/admin/utilisateurs" class="btn btn-secondary">Annuler</a>
    </form>
 </div>

<script type="text/javascript">document.page = ""</script>