<?php
// On récupère l'objet Base de données
$bdd = \App::getInstance()->getBdd();

// On récupère tous les thèmes correspondant à la catégorie
$categorie = $bdd->prepare('SELECT * FROM categorie WHERE key_nom=?', [$categorie_nom], null, true);

if (!$categorie) {
    header('Location: /404');
    die();   
}
$themes = $bdd->prepare('SELECT * FROM theme WHERE categorie_id = ?', [$categorie->id]);
?>
<main class="container" id="main-container">
    <div class="row">
        <h1 id="titre_acceuil">Thèmes de la catégorie <?= $categorie->nom ?></h1>
    </div>
    <div class="row">
<?php
if (empty($themes)) {
    echo "<h3>Il n'y a aucun thème dans cette catégorie :)</h3>";
}
foreach($themes as $theme) {
            ?>
            <div class="col-md-4 text-center">
                <div id=id style=visibility:hidden;>
                    <?php echo($theme->id); ?>
                </div>
                <div class="card" style="width: 18rem;">
                  <div class="squareimg" style="background-image: url(<?= $theme->url_image ?>)"></div>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo($theme->nom); ?></h5>
                    <a href="/theme/<?php echo($theme->key_nom); ?>" class="btn btn-theme btn-chevron btn-uc">Jouer</a> <br>
                </div>
            </div>
        </div>
            
            <?php
            
        }
?>
</div>
 
</main>
<!--On importe le script du carousel et le script spécifique à cette page-->
<script defer type="text/javascript" src="/assets/js/app/cjs-slider.js"></script>
<script defer type="text/javascript" src="/assets/js/app/accueil.js"></script>