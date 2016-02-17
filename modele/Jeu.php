<?php

require_once 'Modele.php';
require_once 'Partie.php';
require_once MODEL_PATH.'Joueur.php'; // connerie de wamp qui ne fait pas la diff entre une min et un maj

class Jeu extends Modele{



  public static function getNomTheme(){
    try {
      $sql = "SELECT DISTINCT nomTheme FROM pp_sujets";
      $stmt = self::$pdo->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      echo $e->getMessage();
      die("Erreur lors de la recherche dans la BDD pp_sujets");
    }
  }

  public static function getNomSujet($data){
    try {
      $sql = "SELECT DISTINCT nom FROM pp_sujets WHERE nomTheme=:nomTheme";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':nomTheme',$data);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      echo $e->getMessage();
      die("Erreur lors de la recherche dans la BDD pp_sujets");
    }
  }

  public static function getIdSujetByNom($data){
    try {
      $sql = "SELECT DISTINCT idSujet FROM pp_sujets WHERE nom=:nom";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':nom',$data);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      echo $e->getMessage();
      die("Erreur lors de la recherche dans la BDD pp_sujets");
    }
  }

  public static function getPartieEnAttente($idSujet,$coterSujet){
    try {
      $sql = "SELECT DISTINCT idJoueur FROM pp_partie_en_attente WHERE idSujet=:idSujet AND coterSujet=:coterSujet";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idSujet',$idSujet);
      $stmt->bindParam(':coterSujet',$coterSujet);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      echo $e->getMessage();
      die("Erreur lors de la recherche dans la BDD pp_sujets");
    }
  }

}

?>
