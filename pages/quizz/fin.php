
    <main class="container" id="main-cont">

        <div id="question" class="row">
            <div class="col-md-12">
                <h1>Terminé !</h1>
                <p class="enonce">Votre score sur le thème "<?= $theme->nom ?>":</p>
                <p id="score">
                    <?= $theme->score ?>/10
                    <div id="barre-score" >
                        <div class="start" data-score="<?= $theme->score ?>"></div>
                    </div><br>
                </p>
                <p>
                    <a href="/" class="btn btn-uc btn-chevron-left btn-secondary">Retour à l'accueil</a>
                    <a href="" class="btn btn-uc btn-chevron btn-primary">Rejouer</a>
                </p>
            </div>
        </div>
    </main>
    
<script type="text/javascript">document.page = "finquizz"</script>