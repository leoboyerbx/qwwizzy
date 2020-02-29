<?php

$theme = \App::getInstance()->getBdd()->query('SELECT key_nom FROM theme
                                                    ORDER BY RAND()
                                                    LIMIT 1;', null, true)->key_nom;
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
    <body id="container_intro" class="container-fluid" style="position: fixed;">
        <div class="row" id="row_intro">
           <div class="col-12 col-lg-6" id="left_part">
               <div id="qwwizzy_intro"> Qwwizzy </div>
               <div class="liens"><a href="/home" class="no_link"> PAGE D'ACCUEIL </a></div> 
           </div> 
           <div class="col-12 col-lg-6" id="right_part">
               <div id="random_title"> Thème au hasard </div>
               <div id="liens_2"><a href="/theme/<?= $theme ?>" class="no_link"> C'EST PARTI ! </a></div> 
           </div>
        </div>
    </body>

</html>
