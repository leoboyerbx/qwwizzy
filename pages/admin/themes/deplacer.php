<?php
$theme = $_POST['theme'];
$categorie = $_POST['categorie'];
$app = App::getInstance();
if ($app->getBdd()->prepare('UPDATE theme SET categorie_id=? WHERE id=?', [$categorie, $theme])) {
    echo "ok";
} else {
    echo "error";
}