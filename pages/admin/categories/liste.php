<?php

$app = App::getInstance();
$bdd = $app->getBdd();
$categories = $bdd -> query("SELECT categorie.id, categorie.nom, count(theme.id) as nbr_themes
                         FROM categorie
                         LEFT JOIN theme ON categorie.id = theme.categorie_id
                        GROUP BY categorie.id, categorie.nom, theme.categorie_id");
// $categories = $bdd -> query("SELECT id, nom, (SELECT count(*) FROM question) as nbr_questions
//                          FROM theme");

?>

<div class="admin-container">
    <h1>Gestion des catégories</h1>
    <p>
        <a href="/admin/categories/ajouter" class="btn btn-theme">Ajouter une catégorie</a>
    </p>
    <?php
    echo $app->get_flash();
    ?>
    <table class="table table-theme">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Catégorie</th>
                <th>Nombre de thèmes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
                    <?php
        foreach ($categories as $categorie) {
            ?>
            <tr>
                <td><?= $categorie->id ?></td>
                <td><?= $categorie->nom ?></td>
                <td style="text-align: right"><?= $categorie->nbr_themes ?> <a title="Ajouter des thèmes à la catégorie" href="/admin/questions/ajout_par_theme/<?= $categorie->id ?>" class="btn"><i class="fas fa-plus"></i></a></td>
                <td class="admin-actions">
                    <form method="post" action="/admin/themes/supprimer" class="form-delete">
                        <a href="/admin/questions/par_theme/<?= $categorie->id ?>" class="btn btn-outline-secondary btn-uc"><i class="fas fa-list-ul" style="margin-right: 10px"></i> Questions</a>
                        <a href="/admin/themes/edit/<?= $categorie->id ?>" class="btn btn-outline-theme btn-uc"><i class="fas fa-pen" style="margin-right: 10px"></i> Modifier</a>
                        <input type="hidden" name="id_theme" value="<?= $categorie->id ?>"/>
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