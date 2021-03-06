<?php
// Template par défaut des pages du site
$categories = \App::getInstance()->getBdd()->query('SELECT * FROM categorie');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Qwwizzy</title>
    <link rel="stylesheet" href="https://use.typekit.net/esl5ggo.css">
    <link rel="stylesheet" href="https://use.typekit.net/esl5ggo.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <?= \App::getInstance()->getThemeColor() ?>
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-8 col-md-4 col-lg-2">
                    <div id="logo"> <a href="/home"  >Qwwizzy </a> </div>
                </div>
                <div class="col-2 d-none d-lg-block">
                    <div id="categorie" class="center">
                        Catégories <i class="fas fa-chevron-down"></i> 
                        <ul id="dropdown">  
                            <?php
                                foreach($categories as $categorie) {
                            ?>
                                <a href="/categorie/<?= $categorie->key_nom ?>"/><li><?= $categorie->nom; ?></li></a>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-5 col-md-3 col-lg-5"></div>
                <div class="col-5 col-lg-3 d-none d-md-block">
                    <?php include ROOT . '/pages/templates/modules/adminmenu.php';?>
                </div>
            </div>
        </div>
    </header>
    
    <?= $content; ?>
    
   
    <footer>
        <div class="container">
            <div class="row" >
                <div class="col-7 col-lg-5 d-none d-md-block">
                    <div id="copyright"> 
                        @<span id="copyright_logo">Qwwizzy</span>, 2019 - Tout droits réservés 
                    </div>
                </div>
                <div class="col-2 col-lg-4 d-none d-md-block"></div>     <!-- Vide, centre du footer -->
                <div class="col-12 col-md-2">
                    <div class="row">
                        <div class="col-4 text-center">
                            <a href=#> <i class="fab fa-twitter-square" id="logo_footer"> </i> </a> 
                        </div>
                        <div class="col-4 text-center">
                            <a href=#><i class="fab fa-facebook" id="logo_footer"></i> </a>
                        </div>
                        <div class="col-4 text-center">
                            <a href=#> <i class="fab fa-instagram" id="logo_footer"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-sm-block d-md-none">
                    <div id="copyright">
                        @<span id="copyright_logo">Qwwizzy</span>, 2019 - Tout droits réservés
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!--<script type="text/javascript" src="/assets/js/app.js"></script>-->
</body>
</html>