<?php
if (startsWith($page, "login")) { // pages sans template
    include ROOT . '/pages/admin/login.php';
} else if (startsWith($page, "logout")) { 
    session_destroy();
    header("Location: /");
} else if (startsWith($page, "couleur_theme")) { 
    include ROOT . '/pages/admin/general/edit_couleur_theme.php';
}  else if (startsWith($page, "themes/deplacer")) { 
    include ROOT . '/pages/admin/themes/deplacer.php';
} else {
    $auth = new Bdd\Auth($app->getBdd());
    if ($auth->estConnecte()) {
        ob_start();
        if (startsWith($page, "themes/ajouter")) {
            $auth->auth_permission(7);
            include ROOT . '/pages/admin/themes/ajouter.php';
        }

        else if (startsWith($page, "themes/supprimer")) {
            $auth->auth_permission(7);
            include ROOT . '/pages/admin/themes/supprimer.php';
        }

        else if (startsWith($page, "themes/edit/")) {
            $auth->auth_permission(7);
            $id_theme = substr($page, 12);
            include ROOT . '/pages/admin/themes/editer.php';
        }
        
        else if (startsWith($page, "questions/par_theme/")) {
            $auth->auth_permission(7);
            $id_theme = substr($page, 20);
            include ROOT . '/pages/admin/questions/liste.php';
        }
        
        else if (startsWith($page, "questions/ajout_par_theme/")) {
            $auth->auth_permission(7);
            $id_theme = substr($page, 26);
            include ROOT . '/pages/admin/questions/ajouter.php';
        }

        else if (startsWith($page, "themes")) {
            $auth->auth_permission(7);
            include ROOT . '/pages/admin/themes/liste.php';
        }

        else if (startsWith($page, "categories/ajouter")) {
            $auth->auth_permission(7);
            include ROOT . '/pages/admin/categories/ajouter.php';
        }

        else if (startsWith($page, "categories/supprimer")) {
            $auth->auth_permission(7);
            include ROOT . '/pages/admin/categories/supprimer.php';
        }

        else if (startsWith($page, "categories/edit/")) {
            $auth->auth_permission(7);
            $id_categorie = substr($page, 16);
            include ROOT . '/pages/admin/categories/editer.php';
        }
        
        else if (startsWith($page, "categories")) {
            $auth->auth_permission(7);
            include ROOT . '/pages/admin/categories/liste.php';
        }

        //Questions
        else if (startsWith($page, "questions/ajouter")) {
            $auth->auth_permission(5);
            include ROOT . '/pages/admin/questions/ajouter.php';
        }

        else if (startsWith($page, "questions/edit/")) {
            $auth->auth_permission(5);
            $id_question = substr($page, 15);
            include ROOT . '/pages/admin/questions/editer.php';
        }

        else if (startsWith($page, "questions/supprimer")) {
            $auth->auth_permission(5);
            include ROOT . '/pages/admin/questions/supprimer.php';
        }


        else if (startsWith($page, "questions")) {
            $auth->auth_permission(5);
            include ROOT . '/pages/admin/questions/liste.php';
        }
        
        // Utilisateurs

        else if (startsWith($page, "utilisateurs/changemail")) {
            include ROOT . '/pages/admin/utilisateurs/changemail.php';
        }

        else if (startsWith($page, "utilisateurs/changemdp")) {
            include ROOT . '/pages/admin/utilisateurs/changemdp.php';
        }
        else if (startsWith($page, "utilisateurs/changeimage")) {
            include ROOT . '/pages/admin/utilisateurs/changeimage.php';
        }
        else if (startsWith($page, "utilisateurs/supprimer")) {
            $auth->auth_permission(10);
            include ROOT . '/pages/admin/utilisateurs/supprimer.php';
        }
        else if (startsWith($page, "utilisateurs/ajouter")) {
            $auth->auth_permission(10);
            include ROOT . '/pages/admin/utilisateurs/ajouter.php';
        }
        else if (startsWith($page, "utilisateurs/edit/")) {
            $auth->auth_permission(10);
            $id_user = substr($page, 18);
            include ROOT . '/pages/admin/utilisateurs/editer.php';
        }

        else if (startsWith($page, "utilisateurs")) {
            $auth->auth_permission(10);
            include ROOT . '/pages/admin/utilisateurs/liste.php';
        }
        
        else if (!$page) {
            include ROOT . "/pages/admin/dashboard.php";
        }

        else {
            $noTemplate = true;
            include ROOT . '/pages/page404.php';
        }

        $content = ob_get_clean();

        //Injection du contenu dans le template correspondant
        include ROOT.'/pages/templates/admin.php';
    } else {
        $app->set_flash('warning', "Veuillez vous connecter.");
        header("Location: /admin/login");
    }
}
