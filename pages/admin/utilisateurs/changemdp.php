<?php
$app = \App::getInstance();

if (!empty($_POST['oldpass']) && !empty($_POST['newpass'])) {
    $auth = new Bdd\Auth($app->getBdd());
    $user = $auth->getUser();
    if ($auth->login($user->pseudo, $_POST['oldpass'], true)) {
        $pass_hash = password_hash($_POST['newpass'], PASSWORD_DEFAULT);
        $result = $app->getBdd()->prepare("UPDATE utilisateur SET pass_hash = ? WHERE id = ?", [$pass_hash, $user->id]);
        if($result) {
            $app->set_flash('success', "Mot de passe modifié avec succès");
            header('Location: /admin');
            die(); // permet de conserver le message flash
        } else {
            $app->set_flash('danger', "Une erreur s'est produite.");
        }
    } else {
        $app->set_flash('danger', "Ancien mot de passe erroné");
    }
}


?>
<div class="admin-container">
<?= $app->get_flash() ?>
    <h1>Changer mon mot de passe</h1>
    <form method="post">
        <div class="form-group">
            <label for="nom">Ancien mot de passe</label>
            <input type="password" class="form-control" name="oldpass">
        </div>
        <div class="form-group">
            <label for="nom">Nouveau mot de passe</label>
            <input type="password" class="form-control" name="newpass" id="mdp_a_confirm">
        </div>
        <div class="form-group">
            <label for="nom">Confirmer nouveau mot de passe</label>
            <input type="password" class="form-control" name="newpass" id="mdp_confirm">
        </div>
        <input type=submit class="btn btn-primary" value="Enregistrer">
        <a class="btn btn-outline-secondary" href="/admin">Annuler</a>
    </form>
</div>

<script type="text/javascript">document.page = "changemdp"</script>
