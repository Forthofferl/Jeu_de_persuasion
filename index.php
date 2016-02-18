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
$controleurIndex = new ControleurIndex();
$controleurJoueur = new ControleurJoueur();
$controleurJeu = new ControleurJeu();
$uri = $_SERVER['REQUEST_URI'];
$uri = substr($uri, strpos($uri,'/index.php'));
$uriTab = explode('?', $uri);
$uri = $uriTab[0];

   
switch ($uri) {
    case '/index.php/':
        $controleurIndex->defaut();
        break;
    case '/index.php/regles':
        $controleurIndex->regles();
        break;
    case '/index.php/statistiques':
        $controleurIndex->statistiques();
        break;
    case '/index.php/deconnexion':
        $controleurJoueur->deconnexion();
        break;
    case '/index.php/connect':
        $controleurJoueur->connect();
        break;
    case '/index.php/apropos':
        $controleurIndex->aPropos();
        break;
    case '/index.php/inscription':
        $controleurJoueur->inscription();
        break;
    case '/index.php/classement':
        $controleurIndex->classement();
        break;
    case '/index.php/profil':
        $controleurJoueur->profil();
        break;
    case '/index.php/save':
        $controleurJoueur->save();
        break;
    case '/index.php/activate':
        $controleurJoueur->activation($_GET['key']);
        break;
    case '/index.php/recovery':
        $controleurJoueur->recovery();
        break;
    case '/index.php/jouer':
        $controleurIndex->jouer();
        break;
    case '/index.php/sujet':
        if(empty($_POST['theme'])){
            $controleurIndex->glitch();
        }
        else {
            $controleurJeu->selectSujet($_POST['theme']);
        }
        break;
    case '/index.php/partie_en_attente':
        if(empty($_POST['sujet'])||empty($_POST['coterSujet'])){
            $controleurIndex->glitch();
        }
        else {
            $data = array($_POST['sujet'], $_POST['coterSujet']);
            $controleurJeu->selectPartieEnAttente($data);
        }
        break;
    case '/index.php/sujetStat':
        if(empty($_POST['theme'])){
            $controleurIndex->glitch();
        }
        else {
            $controleurIndex->sujetStat($_POST['theme']);
        }
        break;
    default:
        $controleurIndex->defaut();
        break;
   
}

?>
