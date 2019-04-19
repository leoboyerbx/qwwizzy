<main class="container" id="main-container">
    <div class="row">
<?php
$bdd = \App::getInstance()->getBdd();

$result = $bdd -> query('SELECT * FROM theme');


foreach ($result as $question){
?>

    <div class="col-4">
        <div id=id style=visibility:hidden;>
            <?php echo($question->id); ?>
        </div>
        <div class="card" style="width: 18rem;">
          <!--<img class="card-img-top" src="<?php echo($question->url_image); ?>" alt="image">-->
          <div class="squareimg" style="background-image: url(<?= $question->url_image ?>)"></div>
          <div class="card-body">
            <h5 class="card-title"><?php echo($question->nom); ?></h5>
            <p class="card-text"><?php echo($question->description); ?></p>
            <a href="/theme/<?php echo($question->key_nom); ?>" class="btn btn-primary btn-chevron btn-uc">Jouer</a>
        </div>
    </div>
    </div>
    <?php
}

    ?>
    </div>
</main>