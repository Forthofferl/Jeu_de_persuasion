<?php
    require_once('config.inc.php');
    function __autoload($nomClasse)
{
    if(file_exists('modele'.DIRECTORY_SEPARATOR.strtolower($nomClasse).'.php')) {
        require_once('modele'.DIRECTORY_SEPARATOR.strtolower($nomClasse).'.php');
    }
    else if(file_exists('config'.DIRECTORY_SEPARATOR.strtolower($nomClasse).'.php')){
        require_once('config'.DIRECTORY_SEPARATOR.strtolower($nomClasse).'.php');
    }
    else
    {
        throw new Exception('Impossible de charger la classe '.$nomClasse);
    }
}
    $page = 'joueur';
    if (isset($_GET['action']))
        $action = $_GET['action'];
    include CTR_PATH.'ControleurJoueur.php';
?>
