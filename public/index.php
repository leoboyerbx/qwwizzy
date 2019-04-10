<?php
// La variable ROOT permet d'accéder à la racine du projet.
define('ROOT', dirname(__DIR__));
require ROOT . '/classes/App.php';
$app = App::getInstance();
$app->load();

function startsWith($string, $needle) {
    $length = strlen($needle);
    return (substr($string, 0, $length) === $needle);
}

ob_start();
if (!empty($_GET['p'])) {
    $page = $_GET['p'];
    if ($page === "temp"){
        
        include ROOT.'/views/temp.html';
    }
    else {
        echo 'index';
    }
}

$content = ob_get_clean();

include ROOT.'/views/templates/default.php';
