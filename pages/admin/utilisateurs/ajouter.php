<?php

$app = \App::getInstance();
$bdd = $app->getBdd();

if(isset($_POST['pseudo']) AND isset($_POST['email']) AND isset($_POST['pass']) AND isset($_POST['permissions'])){ //envoi des données si renseignées
    $pass_hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $result = $bdd -> prepare('INSERT into utilisateur(pseudo, email, pass_hash, permissions) values (? , ?, ?, ?)', array($_POST['pseudo'], $_POST['email'], $pass_hash, $_POST['permissions']));
    if($result){
        $app->set_flash('success', 'Utilisateur ajouté avec succès');
        header('Location: /admin/utilisateurs');
        die();
    } else {
        $app->set_flash('danger', 'Une erreur s\'est produite');
    }
    
}
?>
<div class="admin-container">
    <h1>Ajouter un utilisateur</h1>
    <form method="post">
        <div class="form-group">
            <label for="key_nom">Pseudo</label>
            <input type="text" class="form-control" name="pseudo">
        </div>
        <div class="form-group">
            <label for="nom">E-mail</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label for="url_image">Mot de passe</label>
            <input type="password" class="form-control" name="pass">
        </div>
        <div class="form-group">
            <label for="permis">Niveau d'accréditation</label>
            <select name="permissions" id="permis" class="form-control">
                <option value="5">Auteur</option>
                <option value="7">Editeur</option>
                <option value="10">Administrateur</option>
            </select>
        </div>
        <input type=submit class="btn btn-primary" value="Ajouter">
        <a href="/admin/utilisateurs" class="btn btn-secondary">Annuler</a>
    </form>
 </div>

<script type="text/javascript">document.page = ""</script>