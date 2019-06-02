<?php
$bdd = \App::getInstance()->getBdd();

$id_categorie = $_POST['id_categorie']; // contient l'id du theme

if(!empty($_POST['id_categorie'])){
    //on déplace les thèmes de la catégorie vers non classé
    
    $deplacer = $bdd->prepare('UPDATE theme SET categorie_id = 0 WHERE categorie_id = ?', [$_POST['id_categorie']]);
    $result = $bdd -> prepare("DELETE FROM categorie WHERE id = ?", array($id_categorie));
    if ($deplacer && $result) {
        $app -> set_flash('success', 'Catégorie supprimée avec succès !');
        header('Location: /admin/categories');
    } else {
        $app -> set_flash('danger', "Une erreur s'est produite");
        header("Location : /admin/categories");
        
    }
} else {
    $app -> set_flash('danger', "Une erreur s'est produite");
    header("Location : /admin/categories");
    
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
