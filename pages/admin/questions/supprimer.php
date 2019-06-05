<?php
$bdd = \App::getInstance()->getBdd();

if(!empty($_POST['id_question'])){
    $id_question = $_POST['id_question'];
    $result = $bdd -> prepare("DELETE FROM question WHERE id = ?", array($id_question)); //on prépare la requête avec l'id_question de la page précédente
    if ($result) {//suppression est effective, message positif et retour a la liste des questions
        $app -> set_flash('success', 'Question supprimée avec succès !');
        header('Location: /admin/questions');
    } else {//suppression n'a pas fonctionné, message négatif et retour aux questions
        $app -> set_flash('danger', "Une erreur s'est produite");
        header("Location : /admin/questions");

    }
} else {//si pas d'id question on redirige vers la liste car l'user n'a rien a faire ici
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
