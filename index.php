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
    elseif(file_exists('controleur'.DIRECTORY_SEPARATOR.strtolower($nomClasse).'.php')) {
        require_once('controleur'.DIRECTORY_SEPARATOR.strtolower($nomClasse).'.php');
    }
    else
    {
        throw new Exception('Impossible de charger la classe '.$nomClasse);
    }
}
 //echo strpos(BASE, "index.php");
 //echo BASE;
$controleur = new ControleurIndex();
$controleur2 = new ControleurJoueur();
$uri = $_SERVER['REQUEST_URI'];
$uri = substr($uri, strpos($uri,'/index.php'));
$uriTab = explode('?', $uri);
$uri = $uriTab[0];
switch ($uri) {
    case '/index.php':
        $controleur->defaut();
        break;
    case '/index.php/regles':
        $controleur->regles();
        break;
    case '/index.php/statistiques':
        $controleur->statistiques();
        break;
    case '/index.php/deconnexion':
        $controleur2->deconnexion();
        break;
    case '/index.php/connect':
        $controleur2->connect();
        break;
    case '/index.php/apropos':
        $controleur->aPropos();
        break;
    case '/index.php/inscription':
        $controleur2->inscription();
        break;
    case '/index.php/classement':
        $controleur->classement();
        break;
    case '/index.php/profil':
        $controleur2->profil();
        break;
    default:
        $controleur->defaut();
        break;
}

?>
