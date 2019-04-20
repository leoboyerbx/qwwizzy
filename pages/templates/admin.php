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
                            <div id="admin-logo" class="center"> <a href="/home"  >Qwwizzy </a> </div>
                        </div>
                    </div>  
                    <hr/>
                    <div class="row">
                        <div class="col-12">
                            <a href="#" class="menu_elements"> <div id="dashboard"> <i class="fas fa-tachometer-alt"> </i> Dashboard </div> </a>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div id="theme_menu" class="col-12">
                                <a id="admin_theme" href="/admin/themes" class="menu_elements"> <div> <i class="far fa-clipboard"></i> Thèmes </div> </a>
                                <ul id="aside_theme">
                                        <div id="ajouter_theme">
                                            <a href="/admin/themes/ajouter"> <li> Ajouter </li></a>
                                        </div>
                                        <div id="apercu_theme">
                                            <a href="/admin/themes"> <li> Aperçu </li></a>
                                        </div>
                                </ul>
                        </div>
                        <div id="question_menu" class="col-12">
                            <a id="admin_question" href="#" class="menu_elements"> <div> <i class="fas fa-question"></i> Questions </div> </a>
                            <ul id="aside_question">
                                    <div id="ajouter_question">
                                        <a> <li> Ajouter </li></a>
                                    </div>
                                    <div id="apercu_question">
                                        <a> <li> Aperçu </li></a>
                                    </div>
                            </ul>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-12">
                            <a href="#" class="menu_elements"> <div id="admin-users"> <i class="fas fa-user"></i> Utilisateurs </div> </a>
                        </div>
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
    
    <script type="text/javascript" src="/assets/js/admin.js"></script>
</body>
</html>