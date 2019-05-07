<?php

$app = App::getInstance();
$bdd = $app->getBdd();
$themes = $bdd -> query("SELECT theme.id, theme.nom, count(question) as nbr_questions
                         FROM theme
                         LEFT JOIN question ON theme.id = question.theme_id
                        GROUP BY theme.id, theme.nom, question.theme_id");
// $themes = $bdd -> query("SELECT id, nom, (SELECT count(*) FROM question) as nbr_questions
//                          FROM theme");

?>

<div class="admin-container">
    <h1>Gestion des thèmes</h1>
    <?php
    echo $app->get_flash();
    ?>
    <table class="table table-theme">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Thème</th>
                <th>Nombre de questions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
                    <?php
        foreach ($themes as $theme) {
            ?>
            <tr>
                <td><?= $theme->id ?></td>
                <td><?= $theme->nom ?></td>
                <td><?= $theme->nbr_questions ?> <a style="margin-left: 10px" href="/admin/questions/ajout_par_theme/<?= $theme->id ?>" class="btn btn-outline-secondary"><i class="fas fa-plus"></i></a></td>
                <td class="admin-actions">
                    <form method="post" action="/admin/themes/supprimer">
                        <a href="/admin/questions/par_theme/<?= $theme->id ?>" class="btn btn-outline-secondary btn-uc"><i class="fas fa-list-ul" style="margin-right: 10px"></i> Questions</a>
                        <a href="/admin/themes/edit/<?= $theme->id ?>" class="btn btn-outline-theme btn-uc"><i class="fas fa-pen" style="margin-right: 10px"></i> Modifier</a>
                        <input type="hidden" name="id_theme" value="<?= $theme->id ?>"/>
                        <button type="submit" class="btn btn-outline-danger btn-uc"><i class="fas fa-trash" style="margin-right: 10px"></i> Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php
        }
        
        ?>
            
        </tbody>
    </table>



</div>