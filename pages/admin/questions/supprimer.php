<?php
$bdd = \App::getInstance()->getBdd();

if(!empty($_POST['id_question'])){
    $id_question = $_POST['id_question'];
    $result = $bdd -> prepare("DELETE FROM question WHERE id = ?", array($id_question));
    if ($result) {
        $app -> set_flash('success', 'Question supprimée avec succès !');
        header('Location: /admin/questions');
    } else {
        $app -> set_flash('danger', "Une erreur s'est produite");
        header("Location : /admin/questions");

    }
} else {
    $app -> set_flash('danger', "Une erreur s'est produite");
    header("Location : /admin/questions");

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
