<?php
$app = \App::getInstance();
$auth = new Bdd\Auth($app->getBdd());

if ($auth->estConnecte()) {
    echo <<<END
<a href="/admin"><div id="admin">Administration<i class="fas fa-tools"></i> </div></a>
END;


} else {
    echo <<<END
<a href="/admin/login"><div id="admin"> Se connecter<i class="fas fa-user"></i> </div></a>
END;

}