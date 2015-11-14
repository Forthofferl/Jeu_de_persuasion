<?php

/*
 * Classe StatsPerso
 */

require_once 'Modele.php';

class StatsPerso extends Modele {

  protected static $table = "pfcls_StatistiquesPersonnelles";
  protected static $primary_index = "idStatsPerso";

  public static function selectSequence($sexe,$agemini,$agemaxi){
    $donnees = array();    try{
      $sql = "SELECT listeCoups FROM pfcls_StatistiquesPersonnelles sp ";
      $sql .= "INNER JOIN pfcls_Joueurs jo ON sp.idJoueur = jo.idJoueur ";
      $sql .= "AND jo.sexe = '".$sexe."' ";
      $sql .= "AND jo.age >= ".$agemini." ";
      $sql .= "AND jo.age <= ".$agemaxi." ";
      $req = self::$pdo->prepare($sql);
      $req->execute();
      while ($ligne = $req->fetch()) {
        array_push($donnees, $ligne['listeCoups']);
      }
      return $donnees;
    } catch (PDOException $e) {
      echo $e->getMessage();
      $messageErreur="Erreur lors de la récupération de la séquence stats";
    }
  }

}

?>
