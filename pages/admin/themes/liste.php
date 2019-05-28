<?php

$app = App::getInstance();
$bdd = $app->getBdd();
$themes = $bdd -> query("SELECT theme.*, count(question) as nbr_questions
                         FROM theme
                         LEFT JOIN question ON theme.id = question.theme_id
                        GROUP BY theme.id, theme.nom, question.theme_id");
$categories = $bdd -> query("SELECT categorie.id, categorie.nom, count(theme.id) as nbr_themes
                             FROM categorie
                             LEFT JOIN theme ON categorie.id = theme.categorie_id
                            GROUP BY categorie.id, categorie.nom, theme.categorie_id");   // $themes = $bdd -> query("SELECT id, nom, (SELECT count(*) FROM question) as nbr_questions
//                          FROM theme");

?>

<div class="admin-container">
    <h1>Gestion des thèmes</h1>
    <div class="right">
        <a href="/admin/themes/ajouter" class="btn btn-uc btn-theme">Ajouter un thème</a>
        <a class="btn btn-uc btn-secondary" style="color: #fff">Ajouter une catégorie</a>
        
    </div>
    <br>
    <?php
    echo $app->get_flash();
    ?>
    
</div>
    <?php
foreach ($categories as $categorie) {
    $themes_cat = array_filter($themes, function ($theme) use ($categorie) {
        return $theme->categorie_id == $categorie->id;
    });
    
    ?>
<div class="admin-container">
    <h3 class="title_cat"><?= $categorie->nom ?> <i style="font-size: 70%"><?= $categorie->nbr_themes ?> thèmes</i></h3>
    <table class="table table-theme">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Thème</th>
                <th>Nombre de questions</th>
                <th style="text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($themes_cat as $theme) {
            ?>
            <tr>
                <td><?= $theme->id ?></td>
                <td><?= $theme->nom ?></td>
                <td style="text-align: right"><?= $theme->nbr_questions ?> <a title="Ajouter des questions au thème" href="/admin/questions/ajout_par_theme/<?= $theme->id ?>" class="btn"><i class="fas fa-plus"></i></a></td>
                <td style="text-align: right" class="admin-actions">
                    <form method="post" action="/admin/themes/supprimer" class="form-delete">
                        <a href="/admin/questions/par_theme/<?= $theme->id ?>" class="btn btn-outline-secondary btn-uc"><i class="fas fa-list-ul" style="margin-right: 10px"></i> Questions</a>
                        <a href="/admin/themes/edit/<?= $theme->id ?>" class="btn btn-outline-theme btn-uc"><i class="fas fa-pen" style="margin-right: 10px"></i> Modifier</a>
                        <a href="/admin/themes/edit/<?= $theme->id ?>" class="btn btn-outline-success btn-uc" style="cursor: move;"><i class="fas fa-random" style="margin-right: 10px"></i> Déplacer</a>
                        <input type="hidden" name="id_theme" value="<?= $theme->id ?>"/>
                        <button type="submit" class="btn btn-outline-danger btn-uc"><i class="fas fa-trash" style="margin-right: 10px"></i> Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
            <?php
        }
        
        ?>


</div>
</div>

<script type="text/javascript" src="/assets/js/admin/liste_themes.js"></script>