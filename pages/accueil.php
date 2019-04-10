<main class="container">
<?php
$bdd = \App::getInstance()->getBdd();

$result = $bdd -> query('SELECT * FROM theme');

echo('<div class=container>'.'<div class=row>');

foreach ($result as $question){
?>

    <div class=col-4>
        <div id=id style=visibility:hidden;>
            <?php echo($question->id); ?>
        </div>
        <div id=key_nom style=visibility:hidden;>
            <?php echo($question->key_nom); ?>
        </div>
        <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="<?php echo($question->url_image); ?>" alt="image">
          <div class="card-body">
            <h5 class="card-title"><?php echo($question->nom); ?></h5>
            <p class="card-text"><?php echo($question->description) ?></p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
    </div>
    <?php
}

echo('</div>'.'</div>');
    ?>
</main>