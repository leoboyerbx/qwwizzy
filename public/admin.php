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
        }

        else if (startsWith($page, "themes/supprimer")) {
            include ROOT . '/pages/admin/themes/supprimer.php';
        }

        else if (startsWith($page, "themes/edit/")) {
            $id_theme = substr($page, 12);
            include ROOT . '/pages/admin/themes/editer.php';
        }

        else if (startsWith($page, "themes")) {
            include ROOT . '/pages/admin/themes/liste.php';
        }

        else if (startsWith($page, "questions/ajouter")) {
            include ROOT . '/pages/admin/questions/ajouter.php';
        }

        else if (startsWith($page, "questions/supprimer")) {
            include ROOT . '/pages/admin/questions/supprimer.php';
        }

        else if (startsWith($page, "questions/par_theme/")) {
            $id_theme = substr($page, 20);
            include ROOT . '/pages/admin/questions/liste.php';
        }

        else if (startsWith($page, "questions")) {
            include ROOT . '/pages/admin/questions/liste.php';
        }

        else if (startsWith($page, "utilisateurs/changemdp")) {
            include ROOT . '/pages/admin/utilisateurs/changemdp.php';
        }
        else if (startsWith($page, "utilisateurs/changeimage")) {
            include ROOT . '/pages/admin/utilisateurs/changeimage.php';
        }

        else if (!$page) {
            include ROOT . "/pages/admin/dashboard.php";
        }

        else {
            echo "Pas encore implémenté";
        }

        $content = ob_get_clean();

        //Injection du contenu dans le template correspondant
        include ROOT.'/pages/templates/admin.php';
    } else {
        $app->set_flash('warning', "Veuillez vous connecter.");
        header("Location: /admin/login");
    }
}
