<?php
// Template de l'admin
$auth = new Bdd\Auth(\App::getInstance()->getBdd());

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Qwwizzy</title>
    <link rel="stylesheet" href="https://use.typekit.net/esl5ggo.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <?= \App::getInstance()->getThemeColor() ?>
    
    
    <script defer type="text/javascript" src="/assets/js/admin/dynamic-message.js"></script>
    <script defer type="text/javascript" src="/assets/js/admin/admin.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10" id="admin-content">
                <?= $content; ?>
            </div>
            <div id="admin-nav" class="col-2">
                <nav>
                    <div class="row">
                        <div class="col-12">
                            <div id="admin-logo" class="center"> <a href="/home" >Qwwizzy </a> </div>
                        </div>
                    </div>  
                    <hr/>
                    <div class="row">
                        <div class="col-12">
                            <a href="/admin" class="menu_elements"> <div id="dashboard"> <i class="fas fa-tachometer-alt"> </i> Dashboard </div> </a>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <?php
                        if ($auth->verif_permissions(7)):
                        ?>
                        <div id="theme_menu" class="col-12">
                                <a id="admin_theme" href="/admin/themes" class="menu_elements"> <div> <i class="far fa-clipboard"></i> Thèmes </div> </a>
                                <ul id="aside_theme">
                                        <div id="ajouter_theme">
                                            <a href="/admin/themes/ajouter"> <li> Ajouter </li></a>
                                        </div>
                                        <div id="apercu_theme">
                                            <a href="/admin/themes"> <li> Aperçu </li></a>
                                        </div>
                                        <div id="apercu_theme">
                                            <a href="/admin/categories"> <li><i class="fas fa-folder"></i>  Catégories </li></a>
                                        </div>
                                </ul>
                        </div>
                        <?php
                        endif;
                        
                        ?>
                        <div id="question_menu" class="col-12">
                            <a id="admin_question" href="/admin/questions" class="menu_elements"> <div> <i class="fas fa-question"></i> Questions </div> </a>
                            <ul id="aside_question">
                                    <div id="ajouter_question">
                                        <a href="/admin/questions/ajouter"> <li> Ajouter </li></a>
                                    </div>
                                    <div id="apercu_question">
                                        <a href="/admin/questions"> <li> Aperçu </li></a>
                                    </div>
                            </ul>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <?php
                        if ($auth->verif_permissions(10)):
                        ?>
                        <div id="utilisateurs_menu" class="col-12">
                            <a href="/admin/utilisateurs" class="menu_elements"> <div id="admin-users"> <i class="fas fa-user"></i> Utilisateurs </div> </a>
                            <ul id="aside_utilisateurs">
                                    <div id="ajouter_utilisateurs">
                                        <a href="/admin/utilisateurs/ajouter"> <li> Ajouter </li></a>
                                    </div>
                                    <div id="apercu_utilisateurs">
                                        <a href="/admin/utilisateurs"> <li> Aperçu </li></a>
                                    </div>
                            </ul>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-12">
                            <a href="/admin/logout" class="menu_elements"> <div id="deco"> <i class="fas fa-door-open"> </i> Déconnexion </div> </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    
</body>
</html>