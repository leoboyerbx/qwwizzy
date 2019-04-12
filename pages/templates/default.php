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
    <header>
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <div id="logo"> <a href="/home"  >Qwwizzy </a> </div>
                </div>
                <div class="col-2">
                    <div id="categorie" class="center">
                        Catégories <i class="fas fa-chevron-down"></i> 
                        <ul id="dropdown">  
                            <a href="/theme/histoire_france"><li>Histoire de France</li></a>
                            <a href="/theme/extraterrestres" ><li>Les extraterrestres</li></a>
                            <a href="/theme/botanique" ><li>Un peu de botanique</li></a>
                            <a href="/theme/conquete_spatiale" > <li>La conquête spatiale</li></a>
                        </ul>
                    </div>
                </div>
                <div class="col-6"></div>
                <div class="col-2">
                    <div id="admin"> Admin <i class="fas fa-user"></i> </div>
                </div>
            </div>
        </div>
    </header>
    
    <?= $content; ?>
    
   
    <footer>
        <div class="container">
            <div class="row" >
                <div class="col-12">
                    <div class="center">Voila pour le site.</div>
                </div>
            </div>
        </div>
    </footer>
    
    <script type="text/javascript" src="/assets/js/app.js"></script>
</body>
</html>