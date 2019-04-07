<?php
// La variable ROOT permet d'accéder à la racine du projet.
define('ROOT', dirname(__DIR__));
require ROOT . '/classes/App.php';
$app = App::getInstance();
$app->load();

if (isset($_GET['p'])) {
    $page = $_GET['p'];
    switch ($page){
        case 'index':
        case null:
            echo "index";
            break;
        default:
            echo "404";
            break;
    }
} else {
    echo 'index';
}
