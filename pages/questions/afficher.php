
    <main class="container" id="main-cont" >
<?php
    $bdd = App::getInstance()->getBdd();
    
    $theme = $bdd->prepare("SELECT id FROM theme WHERE key_nom = ?", [$theme], true);
    if (empty($theme)) {
        ?>
        <h1>Erreur 404</h1>
        <h2>Ce thème n'existe pas, désolé!</h2>
        <a href="/" class="btn btn-primary">Retour à l'accueil</a>
        <?php
    } else {
        $theme = $theme[0]->id;
        
        $question = $bdd->prepare("SELECT * FROM question WHERE theme_id = ?", [$theme], true);
        if (empty($question)) {
            ?> <h2>Aucune question dans ce thème</h2> <?php
        } else {
        $question = $question[0];
       ?> 

        <div id="question" data-id="3" class="row">
            <div class="col-md-4">
                <img src="<?= $question->url_image ?>" style="width: 100%"></img>
            </div>
            <div class="col-md-8" id="question-text">
                <h2>Vrai ou faux ?</h2>
                <p><?= $question->question ?></p>
                <p>
                    <button value="1" class="btn btn-success bouton-reponse" id="button-vrai">Vrai</button>
                    <button value="0" class="btn btn-danger bouton-reponse" id="button-faux">Faux</button>
                </p>
                <p id="texte-reponse">
                    Question suivante
                </p>
            </div>
        </div>
        
        <?php
        }
    }
        ?>
    </main>
    
    <script type="text/javascript">document.page = "question"</script>
