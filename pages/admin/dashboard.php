<?php

/**
 * Vue du dashboard, On fait toutes les requêtes nécessaires pour afficher les statistiques
 * 
 * */
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
                                                                                        
$result = $bdd->query("SELECT count(auteur_id) as best_contributor_nb
                        FROM question 
                        GROUP BY auteur_id HAVING count(*) >= ALL (SELECT count(*)
                                                                    FROM question
                                                                    GROUP BY auteur_id);");
$best_contributor_nb = $result[0]->best_contributor_nb;

$result = $bdd->query("SELECT question as top_question              
                            FROM question
                            WHERE id = (SELECT question_id
			                            FROM historique_session 
			                            GROUP BY question_id HAVING count(*) >= ALL (SELECT count(*)
                                            			                             FROM historique_session
                                            			                             GROUP BY question_id) LIMIT 1);");  /*Permet de récupérer l'énoncé de la question la plus jouée*/
$top_question = $result[0]->top_question;

$result = $bdd->query("SELECT url_image as top_question_avatar
                            FROM question
                            WHERE id = (SELECT question_id
			                            FROM historique_session 
			                            GROUP BY question_id HAVING count(*) >= ALL (SELECT count(*)
                                            			                             FROM historique_session
                                            			                             GROUP BY question_id) LIMIT 1);");    /*Permet de récupérer l'image de la question la plus jouée*/
$top_question_avatar = $result[0]->top_question_avatar;

$result = $bdd->query("SELECT count(question_id) as nb_jeux_top_question
			            FROM historique_session 
			            GROUP BY question_id HAVING count(*) >= ALL (SELECT count(*)
                                            			             FROM historique_session
                                            			             GROUP BY question_id);"); /*Permet de récupérer le nombre de fois qu'à était jouée la question la plus jouée */
$nb_jeux_top_question = $result[0]->nb_jeux_top_question;

$result = $bdd->query("SELECT count(pseudo) as nb_users
                       FROM utilisateur;");    /*  Récupère le nombre de comptes*/
$nbr_users = $result[0]->nb_users;

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
        <div class="col-3 stat_row">
            <div class="stat_box" id="box_nb_questions">
                <div class="row">
                    <div class="col-9">
                        <span class="stat"> <?= $nbr_questions ?> questions</span> 
                    </div>
                    <div class="col-3"> 
                        <i class="fas fa-question"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 stat_row">
            <div class="stat_box" id="box_nb_themes">
                <div class="row">
                    <div class="col-9">
                        <span class="stat"> <?= $nbr_themes ?> thèmes</span> 
                    </div>
                    <div class="col-3"> 
                        <i class="far fa-clipboard"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 stat_row">
            <div class="stat_box" id="box_nb_parties">
                <div class="row">
                    <div class="col-9">
                        <span class="stat"> <?= $nbr_parties ?> parties</span> 
                    </div>
                    <div class="col-3"> 
                        <i class="fas fa-gamepad"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 stat_row">
            <div class="stat_box" id="box_nb_inscrits">
                <div class="row">
                    <div class="col-9">
                        <span class="stat"> <?= $nbr_users ?> inscrits</span> 
                    </div>
                    <div class="col-3"> 
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-12">
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
                            <hr>
                            <div class="row">
                                <div id="top_question" class="col-md-12 dashboard-stat text-center">
                                    Nombre de questions créées : <b><?= $best_contributor_nb ?></b> questions
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card" id="best_contributor_box">
                        <div class="card-header">
                            Question la plus jouée
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div id="top_question_avatar" style="background-image: url(<?= $top_question_avatar ?>)"></div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div id="top_question" class="col-md-12 dashboard-stat text-center">
                                    <?= $top_question ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div id="top_question" class="col-md-12 dashboard-stat text-center">
                                    Question jouée <b><?= $nb_jeux_top_question ?></b> fois.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Mon compte
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3" id="admin-user-img">
                                    
                                    <a href="/admin/utilisateurs/changeimage"><div class="roundimg" style="background-image: url(<?= $user->getAvatar() ?>)"></div><!--<img src="" alt="user" title="Modifier ma photo">--></a>
                                </div>
                                <div class="col-sm-9" class="admin-user-pseudo">
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
            </div>
            <?php if ($auth->verif_permissions(10)):  ?>
            <div class="row">
                <div class="col-12" id="personnalisation_box">
                    <div class="card">
                        <div class="card-header">
                            Personnalisation
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Couleur dominante du site</label>
                                <input type="text" class="form-control jscolor" name="jscolor" id="sitecolor" value="<?= $app->getConfig('theme')->main ?>">
                            </div>
                            <hr>
                            <p>Utiliser un préréglage</p>
                            <div id="colorpresets">
                                <a style="background-color: #c10000" data-color="#c10000" class="btn colorpreset"></a>
                                <a style="background-color: #260033" data-color="#260033" class="btn colorpreset"></a>
                                <a style="background-color: #05445c" data-color="#05445c" class="btn colorpreset"></a>
                                <a style="background-color: #4bc2c5" data-color="#4bc2c5" class="btn colorpreset"></a>
                                <a style="background-color: #005792" data-color="#005792" class="btn colorpreset"></a>
                                <a style="background-color: #fd5f00" data-color="#fd5f00" class="btn colorpreset"></a>
                                <a style="background-color: #2E94B9" data-color="#2E94B9" class="btn colorpreset"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>



<script src="/assets/js/lib/jscolor.js"></script>
<script defer src="/assets/js/admin/dashboard.js"></script>