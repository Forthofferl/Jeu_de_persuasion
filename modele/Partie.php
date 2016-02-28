<?php

/*
 * Classe Partie
 */

class Partie extends Modele {

  public static function getResultat($idPartie,$idJoueur,$idJoueurAdverse){
      $requete = "SELECT SUM(nbVote) FROM pp_arguments WHERE idPartie=:idPartie AND idJoueur=:idJoueur";
      $stmt = self::$pdo->prepare($requete);
      $stmt->bindParam(':idPartie', $idPartie);
      $stmt->bindParam(':idJoueur', $idJoueur);
      $stmt->execute();
      $totalVoteJ1 = $stmt->fetchAll()[0][0];
      $stmt = self::$pdo->prepare($requete);
      $stmt->bindParam(':idPartie', $idPartie);
      $stmt->bindParam(':idJoueur', $idJoueurAdverse);
      $stmt->execute();
      $totalVoteJ2 = $stmt->fetchAll()[0][0];

      $data = array('scoreJ1'=>$totalVoteJ1,'scoreJ2'=>$totalVoteJ2);
      return $data;
  }
}

?>
