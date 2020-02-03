<!--Vue appelée au moment de la fin d'un quizz-->
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
                    N'hésitez pas à rejouer pour découvrir d'autres questions et améliorer votre score !
                </p>
                <p>
                    <a href="/home" class="btn btn-uc btn-chevron-left btn-secondary">Retour à l'accueil</a>
                    <a href="" class="btn btn-uc btn-chevron btn-primary">Rejouer</a>
                </p>
                <div class="share">
                    </br>
                    <h2> Partagez votre résultat!</h2><!-- liens réseaux -->
                    <a id="twitter" target="_blank" class="twitter-share-button" href="https://twitter.com/intent/tweet?text=J%27ai%20obtenu%20un%20score%20de%20<?= $theme -> score ?>%20sur%20Qwwizzy%20dans%20le%20th%C3%A8me%20<?= $theme -> nom?>,%0AVenez%20vite%20m%27affronter%20!"> <i class="fab fa-twitter"></i> </a>
                    <a id='facebook' target='_blank' href="https://www.facebook.com/dialog/feed?app_id=1389892087910588&redirect_uri=https://qwwizzy.cf&link=https://qwwizzy.cf&picture=http://placekitten.com/500/500&caption=This%20is%20the%20caption&description=This%20is%20the%20description"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </main>
    
<script defer src="/assets/js/app/finquizz.js" type="text/javascript"></script>