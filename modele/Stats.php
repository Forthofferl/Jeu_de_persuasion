<?php

/*
 * Classe StatsPerso
 */


class Stats extends Modele {


  // récupère le
  public static function selectStat($nomSujet){
    $donnees = array();
    try{
      $idSujet = Jeu::getIdSujetByNom($nomSujet)[0][0];
      $sql = "SELECT message
              FROM  `pp_arguments`
              JOIN pp_parties ON pp_arguments.idPartie=pp_parties.idPartie
              WHERE idSujet = :idSujet
              ORDER BY nbVote ASC
              LIMIT 3";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idSujet', $idSujet);
      $stmt->execute();
      $worstArgSujet = $stmt->fetchAll();
      $sql = "SELECT message
              FROM  `pp_arguments`
              JOIN pp_parties ON pp_arguments.idPartie=pp_parties.idPartie
              WHERE idSujet = :idSujet
              ORDER BY nbVote DESC
              LIMIT 3";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idSujet', $idSujet);
      $stmt->execute();
      $bestArgSujet = $stmt->fetchAll();


      $sql="SELECT COUNT( DISTINCT (pp_joueurs.idJoueur) )
            FROM pp_parties
            JOIN pp_coter_sujet ON pp_parties.idPartie= pp_coter_sujet.idPartie
            JOIN pp_joueurs ON pp_joueurs.idJoueur = pp_coter_sujet.idJoueur
            WHERE idSujet = :idSujet
            AND sexe = 'F' AND coter = 'POUR'";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idSujet', $idSujet);
      $stmt->execute();
      $nombreFemmePour = intval($stmt->fetchAll()[0][0]);

      $sql="SELECT COUNT( DISTINCT (pp_joueurs.idJoueur) )
            FROM pp_parties
            JOIN pp_coter_sujet ON pp_parties.idPartie= pp_coter_sujet.idPartie
            JOIN pp_joueurs ON pp_joueurs.idJoueur = pp_coter_sujet.idJoueur
            WHERE idSujet = :idSujet
            AND sexe = 'F' AND coter = 'CONTRE'";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idSujet', $idSujet);
      $stmt->execute();
      $nombreFemmeContre = intval($stmt->fetchAll()[0][0]);

      $sql="SELECT COUNT( DISTINCT (pp_joueurs.idJoueur) )
            FROM pp_parties
            JOIN pp_coter_sujet ON pp_parties.idPartie= pp_coter_sujet.idPartie
            JOIN pp_joueurs ON pp_joueurs.idJoueur = pp_coter_sujet.idJoueur
            WHERE idSujet = :idSujet
            AND sexe = 'H' AND coter = 'POUR'";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idSujet', $idSujet);
      $stmt->execute();
      $nombreHommePour = intval($stmt->fetchAll()[0][0]);

      $sql="SELECT COUNT( DISTINCT (pp_joueurs.idJoueur) )
            FROM pp_parties
            JOIN pp_coter_sujet ON pp_parties.idPartie= pp_coter_sujet.idPartie
            JOIN pp_joueurs ON pp_joueurs.idJoueur = pp_coter_sujet.idJoueur
            WHERE idSujet = :idSujet
            AND sexe = 'H' AND coter = 'CONTRE'";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idSujet', $idSujet);
      $stmt->execute();
      $nombreHommeContre = intval($stmt->fetchAll()[0][0]);

      $sql="SELECT COUNT( DISTINCT (pp_joueurs.idJoueur) )
            FROM pp_parties
            JOIN pp_arguments ON pp_arguments.idPartie = pp_parties.idPartie
            JOIN pp_joueurs ON pp_joueurs.idJoueur = pp_arguments.idJoueur
            WHERE idSujet = :idSujet";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idSujet', $idSujet);
      $stmt->execute();
      $nombreJoueurTotal = intval($stmt->fetchAll()[0][0]);

      if($nombreJoueurTotal!=0) {
        $pourcentageFemmePour = ($nombreFemmePour / $nombreJoueurTotal) * 100;
        $pourcentageFemmeContre = ($nombreFemmeContre / $nombreJoueurTotal) * 100;
        $pourcentageHommePour = ($nombreHommePour / $nombreJoueurTotal) * 100;
        $pourcentageHommeContre = ($nombreHommeContre / $nombreJoueurTotal) * 100;

        $data = array('bestArg'=>$bestArgSujet,'worstArg'=>$worstArgSujet,'pourcentageHommePour'=>$pourcentageHommePour,'pourcentageFemmePour'=>$pourcentageFemmePour,'pourcentageHommeContre'=>$pourcentageHommeContre,'pourcentageFemmeContre'=>$pourcentageFemmeContre);

      }
      else{
        $data=null;
      }
      return $data;

    } catch (PDOException $e) {
      echo $e->getMessage();
      $messageErreur="Erreur lors de la récupération de la séquence stats";
    }
  }

}

?>
