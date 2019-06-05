<!--Vue appelée au lancement de chaque thème-->
    <main class="container" id="main-cont">

        <div id="question" class="row">
            <div class="col-md-4" id="question-image">
                <div class="squareimg" style="background-image: url(<?= $theme->url_image ?>);"></div>
            </div>
            <div class="col-md-8" id="question-text">
                <h1>Thème</h1>
                <p class="enonce"><?= $theme->nom ?></p>
                <p id="texte-reponse" class="visible">
                    <?= $theme->description ?>
                </p>
                <form method="post">
                    <input type="hidden" name="id_session" value="<?= $id_session ?>" />
                    <button class="btn btn-uc btn-continue btn-chevron">Démarrer</button>
                </form>
            </div>
        </div>
    </main>
    
