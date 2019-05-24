<?php
$bdd = \App::getInstance()->getBdd();

$all_themes = $bdd -> query('SELECT theme.*, categorie.nom as categorie, categorie.id as categorie_id FROM theme LEFT JOIN categorie ON theme.categorie_id = categorie.id');

?>

<main class="container" id="main-container">
    <div class="row">
        <h1>Tous nos thèmes</h1>
    </div>
<?php
$categories =$bdd->query('SELECT * FROM categorie');
foreach($categories as $categorie) {
    
    $themes_cat = array_filter($all_themes, function ($theme) use ($categorie) {
        return $theme->categorie_id == $categorie->id;
    });
    echo "<div class=\"row\">
    <h2>$categorie->nom</h2>
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
    </div>
</main>