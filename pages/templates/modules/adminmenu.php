<?php
$app = \App::getInstance();
$auth = new Bdd\Auth($app->getBdd());
$user = $auth->getUser();

if ($auth->estConnecte()) {
    ?>
    <div class="row">
        <div class="col-8">
            <a href="/admin"><div id="admin">Administration<i class="fas fa-tools"></i> </div> </a>
        </div>
        <div class="col-4" id="div_avatar_header">
            <a href="/admin"><div id="header_avatar" style="background-image: url(<?= $user->getAvatar() ?>)"></div></a>
        </div>
    </div>

<?php
} else {
    ?>
<a href="/admin/login"><div id="admin" class="float_right"> Se connecter<i class="fas fa-user"></i> </div></a>
<?php

}

/*$auth = new Bdd\Auth($app->getBdd());
$user = $auth->getUser();*/
