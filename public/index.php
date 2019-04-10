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

// Détection de la page ciblée
$page = "home";
if (!empty($_GET['p'])) {
    $page = $_GET['p'];
}


// Récupération du contenu
ob_start();
if ($page === "home"){
    include ROOT.'/pages/accueil.php';
}
else if (startsWith($page, 'theme/')){
    $theme = substr($page, 6);
    include ROOT.'/pages/question.php';
} else {
    var_dump($app->getBdd()->query('SELECT * FROM question'));
    echo '404';
}

$content = ob_get_clean();

//Injection du contenu dans le template correspondant

include ROOT.'/pages/templates/default.php';
