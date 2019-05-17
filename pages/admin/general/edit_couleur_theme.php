<?php
$couleurs = array(
    "main" => $_POST['main'],
    "main_lighter" => $_POST['lighter'],
    "main_darker" => $_POST['darker']
    );
$app = App::getInstance();
// $app->getBdd()->prepare('UPDATE config SET valeur=? WHERE clef=\'theme\'', [json_encode($couleurs)]);
$app->setConfig('theme', json_encode($couleurs));
echo json_encode($couleurs);