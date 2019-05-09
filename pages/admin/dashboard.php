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

$best_contributor = $bdd->query("SELECT *
                                    FROM utilisateur
                                    WHERE id = (SELECT auteur_id
                                    FROM question 
                                    GROUP BY auteur_id HAVING count(*) >= ALL (SELECT count(*)
                                                                                FROM question
                                                                                GROUP BY auteur_id));", "\\Entites\\UserEntity", true);


$auth = new Bdd\Auth($app->getBdd());
$user = $auth->getUser();

?>

<div id="dashboard-container" class="container">
    <h1>Gestion du site Qwwizzy</h1>
    <hr>
    <?php
    echo $app->get_flash();
    ?>
    <div class="row">
        <div class="col-6">
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
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Mon compte
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3" id="admin-user-img">
                            
                            <a href="/admin/utilisateurs/changeimage"><div class="roundimg" style="background-image: url(<?= $user->getAvatar() ?>)"></div><!--<img src="" alt="user" title="Modifier ma photo">--></a>
                        </div>
                        <div class="col-md-9" class="admin-user-pseudo">
                            <h5><?= $user->pseudo ?></h5>
                            <h6><i><?= $auth->get_permission_nom() ?></i></h6>
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
        <div class="col-6">
            <div class="card" id="best_contributor_box">
                <div class="card-header">
                    Meilleur contributeur question
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div id="best_contributor_avatar" class="center" style="background-image: url(<?= $best_contributor->getAvatar() ?>)"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="best_contributor_name" class="col-md-12 dashboard-stat text-center">
                            <?= $best_contributor->pseudo ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
