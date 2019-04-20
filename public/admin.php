<?php
if (startsWith($page, "login")) { // pages sans template
    include ROOT . '/pages/admin/login.php';
} else if (startsWith($page, "logout")) { // pages sans template
    session_destroy();
    header("Location: /");
} else {
    $auth = new Bdd\Auth($app->getBdd());
    if ($auth->estConnecte()) {
        ob_start();
        if (startsWith($page, "themes/ajouter")) {
            include ROOT . '/pages/admin/themes/ajouter.php';
        } else if (startsWith($page, "themes/supprimer")) {
            include ROOT . '/pages/admin/themes/supprimer.php';
        } else if (startsWith($page, "themes/edit/")) {
            $id_theme = substr($page, 12);
            include ROOT . '/pages/admin/themes/editer.php';
        } else if (startsWith($page, "themes")) {
            include ROOT . '/pages/admin/themes/liste.php';

        }

        $content = ob_get_clean();

        //Injection du contenu dans le template correspondant
        include ROOT.'/pages/templates/admin.php';
    } else {
        $app->set_flash('warning', "Veuillez vous connecter.");
        header("Location: /admin/login");
    }
}
