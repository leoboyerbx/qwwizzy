<?php

$app = App::getInstance();
$bdd = $app->getBdd();
$questions = $bdd -> query("SELECT question.id, question.question, utilisateur.pseudo as auteur
                         FROM question
                         LEFT JOIN utilisateur ON utilisateur.id = question.auteur_id");
// $themes = $bdd -> query("SELECT id, nom, (SELECT count(*) FROM question) as nbr_questions
//                          FROM theme");
function crop($chaine) {
    if (strlen($chaine) >= 60) {
        return substr($chaine, 0, 60)."...";
    }
    return $chaine;
}

?>

<div class="admin-container">
    <h1>Gestion des questions</h1>
    <?php
    echo $app->get_flash();
    ?>
    <table class="table table-theme">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Question</th>
            <th>Auteur</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($questions as $question) {
            ?>
            <tr>
                <td><?= $question->id ?></td>
                <td><?= crop($question->question); ?></td>
                <td><?= $question->auteur ?></td>
                <td class="admin-actions">
                    <form method="post" action="/admin/questions/supprimer">
                        <a href="/admin/questions/edit/<?= $question->id ?>" class="btn btn-outline-theme btn-uc"><i class="fas fa-pen" style="margin-right: 10px"></i> Modifier</a>
                        <input type="hidden" name="id_theme"/>
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