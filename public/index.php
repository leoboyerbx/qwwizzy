<?php
// La variable ROOT permet d'accéder à la racine du projet.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

    // Pages sans mise en page, qui font du traitement uniquement
if (startsWith($page,"question/check")) {
    include ROOT.'/pages/questions/check.php';
} else {
    // Pages Avec une mise en page
    // Récupération du contenu
    $noTemplate = false;
    if(startsWith($page, 'admin')) {
        $page = substr($page, 6);
        include './admin.php';
        
    } else {
        ob_start();
        if ($page === "home"){
            include ROOT.'/pages/accueil.php';
        }
        else if (startsWith($page, 'theme/')){
            $cont = new Controllers\ThemeController(substr($page, 6));
            $cont->quizz();
        } else {
            $noTemplate = true;
            include ROOT . '/pages/page404.php';
        }
        
        if (!$noTemplate) {
            $content = ob_get_clean();
            //Injection du contenu dans le template correspondant
            include ROOT.'/pages/templates/default.php';
        }
        
    }
    
}

