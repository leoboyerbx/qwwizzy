
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
                <!--<p>-->
                <!--    Score moyen pour ce thème: <?= $theme->avg_score ?>-->
                <!--</p>-->
                <p>
                    <a href="/" class="btn btn-uc btn-chevron-left btn-secondary">Retour à l'accueil</a>
                    <a href="" class="btn btn-uc btn-chevron btn-primary">Rejouer</a>
                </p>
                <div class="share">
                    </br>
                    <h2> Partagez votre résultat!</h2>
                    <a id="twitter" target="_blank" class="twitter-share-button" href="https://twitter.com/intent/tweet?text=J%27ai%20obtenu%20un%20score%20de%20<?= $theme -> score ?>%20sur%20Qwwizzy%20dans%20le%20th%C3%A8me%20<?= $theme -> nom?>,%0AVenez%20vite%20m%27affronter%20!"> <i class="fab fa-twitter"></i> </a>
                </div>
            </div>
        </div>
    </main>
    
<script type="text/javascript">document.page = "finquizz"</script>