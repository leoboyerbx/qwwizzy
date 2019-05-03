<?php
$bdd = App::getInstance()->getBdd();
$result = $bdd->query("SELECT count(*) as nbrquestions
                                FROM question");
$nbr_questions = $result[0]->nbrquestions;
$result = $bdd->query("SELECT count(*) as nbrthemes
                                FROM theme");
$nbr_themes = $result[0]->nbrthemes;
$result = $bdd->query("SELECT count(DISTINCT id_session) as nbrparties
                                FROM historique_session");
$nbr_parties = $result[0]->nbrparties;

$auth = new Bdd\Auth($app->getBdd());
$user = $auth->getUser();

?>

<div class="admin-container">
    <h1>Gestion du site Qwwizzy</h1>
    <hr>
    <?php
    echo $app->get_flash();
    ?>
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    Vue d'ensemble
                </div>
                <div class="card-body center">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="card-title">Nombre de questions</h5>
                            <p class="card-text dashboard-stat"><?= $nbr_questions ?></p>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="card-title">Nombre de thèmes</h5>
                            <p class="card-text dashboard-stat"><?= $nbr_themes ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="card-title">Nombre de parties jouées</h5>
                            <p class="card-text dashboard-stat"><?= $nbr_parties ?></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    Mon compte
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3" id="admin-user-img">
                            <a href="/admin/utilisateurs/changeimage"><img src="/users/avatars/<?= $user->avatar == "" ? 'default.svg' : $user->avatar ?>" alt="user" title="Modifier ma photo"></a>
                        </div>
                        <div class="col-md-9" class="admin-user-pseudo">
                            <h5><?= $user->pseudo ?></h5>
                            <?= $user->email ?> <a style="margin-left: 8px;" href="/admin/utilisateurs/changemail" class="btn btn-outline-theme">Modifier</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 center">
                            <a href="/admin/utilisateurs/changemdp" class="btn btn-theme">Changer mon mot de passe</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
