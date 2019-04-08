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

if (!empty($_GET['p'])) {
    $page = $_GET['p'];
    if ($page === 'index') {
        echo "index";
    } else if (startsWith($page, 'questions/check')) {
        $controller = new \Controllers\QuestionController();
        $controller->check();
    } else {
        echo "404";
    }
} else {
    echo 'index';
}
