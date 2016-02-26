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
    case '/index.php/game':
        if(empty($_POST['sujet'])||empty($_POST['coterSujet'])){
            $controleurIndex->glitch();
            //$controleurJeu->creer();
        }
        else {
            $controleurJeu->creerParties($_POST['sujet'], $_POST['coterSujet']);
        }
        break;
    case '/index.php/chat':
        if(empty($_SESSION['idPartieTemp'])){
            $controleurIndex->glitch();
        }
        else {
            $controleurJeu->chat();
        }
        break;
    case '/index.php/addmessage':

        if(empty($_POST['action'])){

            $controleurIndex->glitch();
        }
        else {
            $controleurJeu->addMessage($_POST['action']);
        }
        break;

    case '/index.php/joinGame':


        if(empty($_POST['sujet'])||empty($_POST['nomJoueur'])){

            $controleurIndex->glitch();
        }
        else {
            $controleurJeu->joinGame($_POST['nomJoueur'],$_POST['sujet']);
        }
        break;

    case '/index.php/lookGame':


        if(empty($_POST['sujet'])||empty($_POST['nomJoueur'])){

            $controleurIndex->glitch();
        }
        else {
            $controleurJeu->lookGame($_POST['nomJoueur'],$_POST['sujet']);
        }
        break;

    case '/index.php/quitter':

        $controleurJeu->quit();
        break;

    case '/index.php/vote':

        if(empty($_POST['idArg'])||empty($_POST['typeVote'])){

            $controleurIndex->glitch();
        }
        else {
            $controleurJeu->vote($_POST['idArg'],$_POST['typeVote']);
        }
        break;

    case '/index.php/statGlobal':
            $controleurIndex->selectStats($_POST['sujet']);
        break;

    default:
        $controleurIndex->defaut();
        break;
   
}

?>
