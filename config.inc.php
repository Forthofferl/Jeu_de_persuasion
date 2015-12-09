<?php
define('ROOT', dirname(__FILE__));
define('DS', dirname(DIRECTORY_SEPARATOR));
define('BASE', str_replace('//', '/', dirname($_SERVER['PHP_SELF']). '/'));
//echo $_SERVER['PHP_SELF'];
define('URL', $_SERVER['SERVER_NAME']);
define('VIEW_PATH', ROOT.DS.'vue'.DS);
define('CTR_PATH', ROOT.DS.'controleur'.DS);
define('MODEL_PATH', ROOT.DS.'modele'.DS);
if(strpos(BASE,"index.php")===false){ 
    $base = BASE.'vue/';
} 
else{
    $base = substr(BASE,0,strpos(BASE,"index.php"))."vue/";
}
define('VIEW_PATH_BASE', $base);
define('SITEEMAIL','no_reply@persuasiongame.me');

session_start();

// vérifier si l'utilisateur est connecté
function estConnecte() {
    return(isset($_SESSION['idJoueur']) && !empty($_SESSION['idJoueur']));
}
