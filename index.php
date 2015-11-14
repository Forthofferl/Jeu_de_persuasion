<?php

require_once('config.inc.php');

$page = 'index';
if (isset($_GET['action']))
    $action = $_GET['action'];
include CTR_PATH.'ControleurIndex.php';

?>
