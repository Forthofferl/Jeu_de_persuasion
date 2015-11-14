<?php

/*
 * Classe Manche
 */

require_once 'Modele.php';
require_once 'Coup.php';

class Manche extends Modele{

    protected static $table = "pfcls_Manches";
    protected static $primary_index = "idManche";

    public static function updateListeCoup($data) {
        try {
            $req = self::$pdo->prepare("UPDATE pfcls_Manches SET listeCoups = CONCAT(listeCoups,',','".$data['listeCoups']."') WHERE idManche=".$data['idManche']);
            $req->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            $messageErreur="Erreur lors de la MAJ de la liste de coups de la manche dans la base de données";
        }
    }
  /*
   * Retourne la chaine de caractère correspondant à liste des coups de la manche passé en param
   * @param id de la manche
   * @return retourne la chaine de caractères
   */
   public static function parsageListeCoups($idM) {
        $chaineListeCoups = "";
        $data = array(
          "idManche"=> $idM
        );
        $liste = self::select($data)->listeCoups;
        $listeCoups = explode(",",$liste);
        foreach ($listeCoups as $coup) {
             $chaineListeCoups .= Coup::retourneIDs($coup);
			       $chaineListeCoups .= ",";
		    }
        $chaineListeCoups=rtrim($chaineListeCoups,",");
        return $chaineListeCoups;
   }

}

?>
