<?php
    require_once('config.inc.php');
    $page = 'joueur';
    if (isset($_GET['action']))
        $action = $_GET['action'];
    include CTR_PATH.'ControleurJoueur.php';
?>
