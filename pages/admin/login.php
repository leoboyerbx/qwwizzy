<?php
$app = \App::getInstance();

if (!empty($_POST['pseudo']) && !empty($_POST['pass'])) {
    $auth = new Bdd\Auth($app->getBdd());
    if($auth->login($_POST['pseudo'], $_POST['pass'])) {
        header('Location: /admin');
    } else {
        App::getInstance()->set_flash('danger', "Identifiants incorrects");
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Qwwizzy</title>
    <link rel="stylesheet" href="https://use.typekit.net/esl5ggo.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <?= $app->getThemeColor() ?>
</head>
<body class="text-center">
    <header id="header_login">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <div id="logo"> <a href="/home">Qwwizzy </a> </div>
                </div>
                <div class="col-2">
                </div>
                <div class="col-6"></div>
                <div class="col-2">
                </div>
            </div>
        </div>
    </header>
    <?= $app->get_flash() ?>
    <form method="post" class="text-center">
        <div class="form-signin" id="log_form">
            <img src="/assets/img/user.svg" class="user_logo spacer_form"> 
            <div class="form-group spacer_group" id="champs_log">
                <input type="text" class="form-control spacer_form" name="pseudo" placeholder="👱     Pseudo">
                <input type="password" class="form-control spacer_form" name="pass" placeholder="🔑     Mot de passe">
                <input type=submit class="btn btn-outline-secondary btn_validation" value="Connexion" >
            </div>
        </div>
    </form>
    
    <script type="text/javascript" src="/assets/js/admin/admin.js"></script>
</body>
</html>


<!--<div class="form-group">
            <label for="key_nom">Pseudo</label>
            <input type="text" class="form-control" name="pseudo">
        </div>
        <div class="form-group">
            <label for="nom">Mot de passe</label>
            <input type="password" class="form-control" name="pass">
        </div>
        <input type=submit class="btn btn-primary" value="Connexion">-->