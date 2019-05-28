<?php

if (empty($_GET['pseudo'])) {
    die('pseudo non spécifié.');
}

$app = \App::getInstance();
$bdd = $app->getBdd();
$sms = $app->getSms('sync');

$token = mt_rand(100000, 999999);

$req = $bdd->prepare('UPDATE utilisateur SET otp = ? WHERE pseudo = ?', [$token, $_GET['pseudo']]);
if ($req) {
    $sms->send('0782459332', "Info Qwwizzy\nVotre code de récupération est le $token");
    echo "ok";
} else {
    echo "erreur au niveau de la BDD.";
}
