<?php
$bdd = \App::getInstance()->getBdd();

$all_themes = $bdd -> query('SELECT theme.*, categorie.nom as categorie, categorie.id as categorie_id FROM theme LEFT JOIN categorie ON theme.categorie_id = categorie.id');

?>

<link rel="stylesheet" href="/assets/css/slider.css" type="text/css" />

<main class="container" id="main-container">
    <div class="row">
        <h1 id="titre_acceuil">Tous nos thèmes</h1>
    </div>
    
    <?php
    $featured = $bdd->query('SELECT * FROM theme WHERE featured = 1');
    
    if (sizeof($featured) > 1):
    ?>
    <div class="row">
        <h2 class="categorie_nom">Mis en avant</h2>
        <div class="cjs-slider" id="carousel">
            <div class="cjs-slides-block">
                
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


$categories = $bdd->query('SELECT * FROM categorie');
foreach($categories as $categorie) {
    
    $themes_cat = array_filter($all_themes, function ($theme) use ($categorie) {
        return $theme->categorie_id == $categorie->id;
    });
    echo "<div class=\"row\">
    <h2 class='categorie_nom'>$categorie->nom</h2>
    </div>
    <div class=\"row\">
    ";
    
    
    foreach($themes_cat as $theme) {
        ?>
        <div class="col text-center">
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
    echo "</div>";
}
?>

    <div class="row">
        <h2 class="categorie_nom"> Catégories </h2>
    </div>
    
    <div class="row">
        <?php
        foreach($categories as $categorie) {
        ?>
            <div class="col-3 bloc_categorie">
                <a href="/theme/<?php $categorie->key_nom ?>" class="nom_categorie">
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
        <?php
        }
        ?>
    </div>
</main>

<script defer type="text/javascript" src="/assets/js/app/cjs-slider.js"></script>
<script defer type="text/javascript" src="/assets/js/app/accueil.js"></script>