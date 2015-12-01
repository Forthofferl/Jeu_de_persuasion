<?php

require_once 'Modele.php';
require_once 'Partie.php';
require_once MODEL_PATH.'Joueur.php'; // connerie de wamp qui ne fait pas la diff entre une min et un maj

class Jeu extends Modele{

  protected static $table = "pfcls_Parties_en_attente";
  protected static $primary_index = "idPartie_en_attente";

   
}

?>
