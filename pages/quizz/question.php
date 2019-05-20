    <main class="container" id="main-cont">

        <div id="question" data-id="<?= $question->id ?>" class="row">
            <div class="col-md-4" id="question-image">
                <div class="squareimg" style="background-image: url(<?= $question->url_image ?>);"></div>
            </div>
            <div class="col-md-8" id="question-text">
                <h1>Vrai ou faux ?</h1>
                <p class="enonce"><?= $question->question ?></p>
                <p class="boutons-reponse">
                    <button value="1" class="btn btn-success btn-uc btn-grow bouton-reponse" id="button-vrai">Vrai</button>
                    <button value="0" class="btn btn-danger btn-uc btn-grow bouton-reponse" id="button-faux">Faux</button>
                </p>
                <p id="texte-reponse">
                    Contenu généré en fonction de la réponse de l'utilisateur (JS)
                </p>
                <form method="post" id="form-envoi">
                    <input type="hidden" name="id_question" value="<?= $question->id ?>" />
                    <input type="hidden" name="iter_question" value="<?= $question->iter ?>" />
                    <input type="hidden" name="id_session" value="<?= $id_session ?>" />
                    <input type="hidden" name="score" value="0" id="score" />
                    <button class="btn btn-uc btn-continue btn-chevron">Continuer</button>
                </form>
            </div>
        </div>
    </main>
    
    <script defer src="/assets/js/app/question.js" type="text/javascript"></script>