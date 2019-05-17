<?php
$app = \App::getInstance();
$auth = new Bdd\Auth($app->getBdd());
$user = $auth->getUser();

if ($auth->estConnecte()) {
    ?>
    <div class="row">
        <div class="col-8" id="div_admin_header">
            <div id="admin"> <a href="/admin">  Administration <i class="fas fa-tools"> </i>  </a> 
                <ul id="dropdown2" class="center">
                    <a href="/admin"> <li> <i class="fas fa-tachometer-alt"> </i> Dashboard </li> </a>
                    <a href="/admin/questions"> <li> <i class="fas fa-question"></i> Questions </li> </a>
                    <?php if ($auth->verif_permissions(10)):  ?>
                    <a href=/admin/themes> <li>  <i class="far fa-clipboard"></i> Thèmes </li> </a>
                    <?php endif; ?>
                    <a href="/admin/logout"> <li> <i class="fas fa-door-open"> </i> Déconnexion </li> </a>
                </ul>
            </div>
        </div>
        <div class="col-4" id="div_avatar_header">
            <a href="/admin"><div id="header_avatar" style="background-image: url(<?= $user->getAvatar() ?>)"></div></a>
        </div>
    </div>

<?php
} else {
    ?>
<a href="/admin/login"><div id="admin"> Se connecter<i class="fas fa-user"></i> </div></a>
<?php

}

