<?php

$app = App::getInstance();
$bdd = $app->getBdd();
$utilisateurs = $bdd -> query("SELECT *
                         FROM utilisateur");

?>

<div class="admin-container">
    <h1>Gestion des utilisateurs</h1>
    <?php
    echo $app->get_flash();
    ?>
    <table class="table table-theme">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
                    <?php
        foreach ($utilisateurs as $user) {
            ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->pseudo ?></td>
                <td><?= $user->email ?></td>
                <td><?= $app->get_permission_nom($user->permissions) ?></td>
                <td class="admin-actions">
                    <form method="post" action="/admin/utilisateurs/supprimer" class="form-delete">
                        <a href="/admin/utilisateurs/edit/<?= $user->id ?>" class="btn btn-outline-theme btn-uc"><i class="fas fa-pen" style="margin-right: 10px"></i> Modifier</a>
                        <input type="hidden" name="id_user" value="<?= $user->id ?>"/>
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