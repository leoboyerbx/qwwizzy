<?php

$app = App::getInstance();
$bdd = $app->getBdd();
$auth = new Bdd\Auth($bdd);
$user = $auth->getUser();

$isAdmin = $auth->verif_permissions(7);

if (!empty($id_theme) && $isAdmin) {
    $questions = $bdd -> prepare("SELECT question.id, question.question, utilisateur.pseudo as auteur, theme.nom as theme_nom
                             FROM question
                             LEFT JOIN utilisateur ON utilisateur.id = question.auteur_id
                             LEFT JOIN theme ON theme.id = question.theme_id
                             WHERE question.theme_id = ?", [$id_theme]);

} else {
    if ($isAdmin) {
        $questions = $bdd -> query("SELECT question.id, question.question, utilisateur.pseudo as auteur, theme.nom as theme_nom
                                 FROM question
                                 LEFT JOIN utilisateur ON utilisateur.id = question.auteur_id
                                 LEFT JOIN theme ON theme.id = question.theme_id");
    } else {
        $questions = $bdd -> prepare("SELECT question.id, question.question, utilisateur.pseudo as auteur, theme.nom as theme_nom
                                 FROM question
                                 LEFT JOIN utilisateur ON utilisateur.id = question.auteur_id
                                 LEFT JOIN theme ON theme.id = question.theme_id
                                 WHERE auteur_id = ?", [$user->id]);
        
    }

}
// $themes = $bdd -> query("SELECT id, nom, (SELECT count(*) FROM question) as nbr_questions
//                          FROM theme");
function crop($chaine) {
    if (strlen($chaine) >= 40) {
        return substr($chaine, 0, 40)."...";
    }
    return $chaine;
}

?>

<div class="admin-container">
    <h1>Gestion des questions</h1>
    <?php
    if (!empty($id_theme) AND count($questions) > 0) {
        echo <<<END
        <h4>Thème: <i style=\"color: #888\">{$questions[0]->theme_nom}</i></h4>
        <a href="/admin/themes" class="btn btn-outline-secondary btn-uc">Retour à la liste de thèmes</a>
        <a href="/admin/questions/ajout_par_theme/{$id_theme}" class="btn btn-secondary btn-uc"><i class="fas fa-plus"></i> Ajouter une question</a>
        <br>
<br>
END;
    } else if (!empty($id_theme)) {
        $req= $bdd->prepare('SELECT nom FROM theme WHERE id = ?', [$id_theme], null, true);

        echo <<<END
<h4>Thème: <i style=\"color: #888\">{$req->nom}</i></h4>
<b>Aucune question dans ce thème</b><br>
        <a href="/admin/themes" class="btn btn-outline-secondary btn-uc">Retour à la liste de thèmes</a><br>
END;

    }
    echo $app->get_flash();
    ?>
    <table class="table table-theme">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Question</th>
            <th>Thème</th>
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
                <td><?= crop($question->theme_nom); ?></td>
                <td><?= $question->auteur ?></td>
                <td class="admin-actions">
                    <form method="post" action="/admin/questions/supprimer" class="form-delete">
                        <a href="/admin/questions/edit/<?= $question->id ?>" class="btn btn-outline-theme btn-uc"><i class="fas fa-pen" style="margin-right: 10px"></i> Modifier</a>
                        <input type="hidden" name="id_question" value="<?= $question->id; ?>" />
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