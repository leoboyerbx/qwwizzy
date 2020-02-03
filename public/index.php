<?php
//voir les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// La variable ROOT permet d'accéder à la racine du projet.
define('ROOT', dirname(__DIR__));

// On récupère la classe App, classe globale.
require ROOT . '/classes/App.php';
$app = App::getInstance();
// On charge l'application
$app->load();

/**
 * Vérifie si la chaîne passée en paramètre commence par la valeur recherchée
 * @param $string La chaine à explorer
 * @param $q La valeur recherchée
 * @return bool
 */
function startsWith($string, $q) {
    $length = strlen($q);
    return (substr($string, 0, $length) === $q);
}

// Apache nous envoie en paramètre 'p' la route demandée par le client. Si elle n'est pas spécifiée, on lui donne une valeur par défaut, l'accueil.
$page = "intro";
if (!empty($_GET['p'])) {
    $page = $_GET['p'];
}

// Pages sans mise en page, qui font du traitement uniquement
if (startsWith($page,"question/check")) {
    include ROOT.'/pages/questions/check.php';
} else if (startsWith($page, "sandbox")) {
} else {
    // Pages dont le contenu doit s'intégrer dans notre template
    // Récupération du contenu
    $noTemplate = false;
    if(startsWith($page, 'admin')) {
        // Dans le cas d'une page de l'administration, le routage est effectué par admin.php
        $page = substr($page, 6);
        include './admin.php';
        
    } else {
        // On démarre la bufferisation de sortie pour récupérer dans une variable le contenu renvoyé par les pages.
        ob_start();

        // Pour chacune des routes prédéfinies, on inclut la vue correspondante (dans le dossier /pages)
        if ($page === "home"){
            include ROOT.'/pages/accueil.php';
        } else if ($page === "intro"){
            $noTemplate = true;
            include ROOT.'/pages/intro.php';
        } else if (startsWith($page, 'apropos')) {
            include ROOT . '/pages/apropos.php';
        } else if (startsWith($page, 'theme/')){
            // Cas particulier: Lorsqu'on joue un thème, il y a un contrôleur pour gérer l'évolution du quizz
            $cont = new Controllers\ThemeController(substr($page, 6));
            $cont->quizz();
        }  else if (startsWith($page, 'categorie/')){
            $categorie_nom = substr($page, 10);
            include ROOT . "/pages/categories/categorie.php";
        } else {
            // Page 404: Elle n'utilise pas de template.
            $noTemplate = true;
            include ROOT . '/pages/page404.php';
        }
        
        if (!$noTemplate) {
            // Si la page est à intégrer dans un template, on récupère la sortie dans une variable.
            $content = ob_get_clean();
            //Injection du contenu dans le template correspondant
            include ROOT.'/pages/templates/default.php';
        }
        
    }
    
}

