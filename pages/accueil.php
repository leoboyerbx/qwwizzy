<?php
// On récupère l'objet Base de données
$bdd = \App::getInstance()->getBdd();

// On récupère tous les thèmes avec leur catégorie
$all_themes = $bdd -> query('SELECT theme.*, categorie.nom as categorie, categorie.id as categorie_id FROM theme LEFT JOIN categorie ON theme.categorie_id = categorie.id');

?>
<!--On importe le CSS du carousel-->
<link rel="stylesheet" href="/assets/css/slider.css" type="text/css" />

<main class="container" id="main-container">
    <div class="row">
        <h1 id="titre_acceuil">Tous nos thèmes</h1>
    </div>
    
    <?php
    
    // On récupère tous les thèmes mis en avant et on génère une slide de carousel pour chaque.
    $featured = $bdd->query('SELECT * FROM theme WHERE featured = 1');
    // S'il y en a un ou moins, on masque le Carousel
    if (sizeof($featured) > 1):
    ?>
    <div class="row">
        <h2 class="categorie_nom d-none d-md-block">Mis en avant</h2>
        <div class="cjs-slider d-none d-md-block" id="carousel">
            <div class="cjs-slides-block">
<!--                Génération d'une slide par thème-->
                <?php foreach($featured as $element) { ?>
                <div class="cjs-slide">
                    <div class="slide-canvas" style="background-color: <?= $element->couleur ?>;">
                        <div class="row slide-content">
                            <div class="col-md-4">
                                <div class="squareimg" style="background-image: url(<?= $element->url_image ?>)"></div>
                            </div>
                            <div class="col-md-8 slide-text">
                                <h3><?= $element->nom ?></h3>
                                <p>
                                    <?= $element->description ?>
                                </p>
                                <p>
                                    <a href="/theme/<?= $element->key_nom ?>" class="btn btn-transparent-dark"><i style="margin-right: 8px" class="fas fa-play"></i> Jouer</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php } ?>
            </div>
        </div>
    </div>
<?php
endif;

// On récupère toutes les catégories et on boucle dessus.
$categories = $bdd->query('SELECT * FROM categorie');
foreach($categories as $categorie) {
    // Pour chaque catégorie, on récupère les thèmes qui correspondent
    $themes_cat = array_filter($all_themes, function ($theme) use ($categorie) {
        return $theme->categorie_id == $categorie->id;
    });
    if(!empty($themes_cat)) {
        // ON affiche chaque theme par catégorie si le thème n'est pas vide
        echo "<div class=\"row\">
        <h2 class='categorie_nom'><i class=\"fas fa-$categorie->icon\"></i> $categorie->nom</h2>
        </div>
        <div class=\"row text-center\">
        ";
        
        
        // Pour chaque catégorie, on affiche tous ses thèmes
        foreach($themes_cat as $theme) {
            ?>
            <div class="col-12 col-md-6 col-lg-4 text-center">
                <div id=id style=visibility:hidden;>
                    <?php echo($theme->id); ?>
                </div>
                <div class="card home-card" style="width: 18rem;">
                  <div class="squareimg" style="background-image: url(<?= $theme->url_image ?>)"></div>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo($theme->nom); ?></h5>
                    <a href="/theme/<?php echo($theme->key_nom); ?>" class="btn btn-theme btn-chevron btn-uc">Jouer</a> <br>
                </div>
            </div>
        </div>
            
            <?php
            
        }
        echo "</div>";
        
    }
}
?>

    <div class="row">
        <h2 class="categorie_nom d-none d-md-block"> Catégories </h2>
    </div>
    
    <div class="row">
        <?php
        // On ré affiche une liste des catégories, sous forme de boutons
        foreach($categories as $categorie) {
        ?>
            <div class="col-3 d-none d-md-block">
                <div class="bloc_categorie">
                    <a href="/categorie/<?= $categorie->key_nom ?>" class="nom_categorie">
                        <div class="row">
                            <div class="col-2">
                                <i class="fas fa-<?= $categorie->icon ?>"></i> 
                            </div>
                            <div class="col-10">
                                <div class="nom_bloc_categorie"><?= $categorie->nom ?></div>
                            </div>
                        </div>
                    </a>
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