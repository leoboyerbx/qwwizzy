<?php
$bdd = \App::getInstance()->getBdd();

$id_theme = $_POST['id_theme']; // contient l'id du theme

if(!empty($_POST['id_theme'])){
    $result = $bdd -> prepare("DELETE FROM theme WHERE id = ?", array($id_theme));
    if ($result) {
        $app -> set_flash('success', 'Thème supprimé avec succès !');
        header('Location: /admin/themes');
    } else {
        $app -> set_flash('danger', "Une erreur s'est produite");
        header("Location : /admin/themes");
        
    }
} else {
    $app -> set_flash('danger', "Une erreur s'est produite");
    header("Location : /admin/themes");
    
}
/** A faire ici:
* - Se connecter à la base pour supprimer le theme dont l'id correspond à la variable
* - Définir un message de confirmation flash avec la méthode set_flash() de l'objet $app
*           -> Exemple: $app->set_flash('success', "Ceci est un message de succès")
* 
* - Rediriger l'utilisateur avec header()
*       -> https://www.commentcamarche.net/faq/878-redirection-php-redirect-header
*   (l'url à utiliser est ROOT . '/admin/themes')
* 
*/
