<?php
$app = \App::getInstance();
$auth = new Bdd\Auth($app->getBdd());
$user = $auth->getUser();

if (!empty($_POST['newmail'])) {
    $_POST['newmail'];
    $newmail = $_POST['newmail'];
    $result = $app->getBdd()->prepare("UPDATE utilisateur SET email = ? WHERE id = ?", [$newmail, $user->id]);
    if($result) {
        $app->set_flash('success', "Email modifié avec succès");
        $auth->set_user_property('email', $newmail);
        header('Location: /admin');
        die(); // permet de conserver le message flash
    } else {
        $app->set_flash('danger', "Une erreur s'est produite.");
    }
}

$email = $user->email;
?>

<div class="change_mdp-container">
<?= $app->get_flash() ?>
    <div class="text-center changemdp_box">
        <h1 class="spacer_change_mdp">Changer mon mot de passe</h1>
        <form method="post" id="form_change_mdp">
            <div class="form-group spacer_change_mdp">
                <b>Votre email actuel:</b> <?= $email?>
            </div>
            <div class="form-group spacer_change_mdp">
                <!--<label for="nom">Nouveau mot de passe</label>-->
                <input type="email" class="form-control" name="newmail" id="newmail" placeholder="Rentrez votre nouveau email">
            </div>
            <input type=submit class="btn btn-primary btn_changement_mdp" value="Enregistrer" id="btn_sub_change">
            <a class="btn btn-outline-secondary btn_changement_mdp btn-retour" href="/admin">Retour</a>
        </form>
    </div>
</div>

