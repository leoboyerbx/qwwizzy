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
<div class="change_mdp-container">
<?= $app->get_flash() ?>
    <div class="text-center changemdp_box">
        <h1 class="spacer_change_mdp">Changer mon mot de passe</h1>
        <form method="post" id="form_change_mdp">
            <div class="form-group spacer_change_mdp">
                <!--<label for="nom">Ancien mot de passe</label>-->
                <input type="password" class="form-control" name="oldpass" placeholder="Ancien mot de passe">
            </div>
            <div class="form-group spacer_change_mdp">
                <!--<label for="nom">Nouveau mot de passe</label>-->
                <input type="password" class="form-control" name="newpass" id="mdp_a_confirm" placeholder="Nouveau mot de passe">
            </div>
            <div class="form-group spacer_change_mdp">
                <!--<label for="nom">Confirmer nouveau mot de passe</label>-->
                <input type="password" class="form-control" name="newpass" id="mdp_confirm" placeholder="Confirmer nouveau mot de passe">
            </div>
            <input type=submit class="btn btn-primary btn_changement_mdp" value="Enregistrer" id="btn_sub_change">
            <a class="btn btn-outline-secondary btn_changement_mdp btn-retour" href="/admin">Retour</a>
        </form>
    </div>
</div>


<script defer src="/assets/js/admin/changemdp.js" type="text/javascript"></script>
