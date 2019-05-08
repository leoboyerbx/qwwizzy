<?php
$bdd = \App::getInstance()->getBdd();

if(!empty($_POST['id_user'])){
    $id_user = $_POST['id_user'];
    $result = $bdd -> prepare("DELETE FROM utilisateur WHERE id = ?", array($id_user));
    if ($result) {
        $app -> set_flash('success', 'Utilisateur supprimé avec succès !');
        header('Location: /admin/utilisateurs');
    } else {
        $app -> set_flash('danger', "Une erreur s'est produite");
        header("Location : /admin/utilisateurs");

    }
} else {
    $app -> set_flash('danger', "Une erreur s'est produite");
    header("Location : /admin/utilisateurs");

}
