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

  public static function creerParties($idSujet,$coterSujet){
    try {
      $table  = "pp_partie_en_attente";
      $sql = "INSERT INTO pp_partie_en_attente (idPartie_en_attente,idJoueur,idSujet,coterSujet,placeSpectateurRestant) values ('',:idjoueur,:idSujet,:coterSujet,4)";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idjoueur',$_SESSION['idJoueur']);
      $stmt->bindParam(':idSujet',$idSujet[0]);
      $stmt->bindParam(':coterSujet',$coterSujet);
      $stmt->execute();

      $table  = "pp_partie_temporaire";
      $sql="INSERT INTO pp_partie_temporaire (id,idSujet,joueur1,joueur2,mess1J1,mess2J1,mess3J1,mess1J2,mess2J2,mess3J2) values ('',:idSujet,:idjoueur,NULL,'','','','','','')";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idjoueur',$_SESSION['idJoueur']);
      $stmt->bindParam(':idSujet',$idSujet[0]);
      $stmt->execute();

      $sql="SELECT id FROM pp_partie_temporaire where joueur1 = :idJoueur";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idJoueur',$_SESSION['idJoueur']);
      $stmt->execute();
      $resultat = $stmt->fetchAll()[0][0];
      $_SESSION['idPartieTemp'] = $resultat;


    } catch (PDOException $e) {
      echo $e->getMessage();
      die("Erreur lors de la recherche dans la BDD ".$table);
    }
  }

  public static function getArgJoueurs(){

    $requete="SELECT joueur1, mess1J1, mess2J1, mess3J1 FROM pp_partie_temporaire WHERE id=:id";
    $stmt = self::$pdo->prepare($requete);
    $stmt->bindParam(':id',$_SESSION['idPartieTemp']);
    $stmt->execute();
    $argsJ1 = $stmt->fetchAll();
    $joueur1 = Joueur::getJoueurByID($argsJ1[0]['joueur1']);
    $argsJ1[0]['joueur1'] = $joueur1[0]['pseudo'];

    $requete="SELECT joueur2, mess1J2, mess2J2, mess3J2 FROM pp_partie_temporaire WHERE id=:id";
    $stmt = self::$pdo->prepare($requete);
    $stmt->bindParam(':id',$_SESSION['idPartieTemp']);
    $stmt->execute();
    $argsJ2 = $stmt->fetchAll();
    if($argsJ2[0]['joueur2']!=null) {
      $joueur2 = Joueur::getJoueurByID($argsJ2[0]['joueur2']);
      $argsJ2[0]['joueur2'] = $joueur2[0]['pseudo'];
    }

    $data = array($argsJ1,$argsJ2);

    return $data;

  }

  public static function addMessage($message){
    var_dump($message);
    $sql="SELECT joueur1,joueur2,mess1J1,mess2J1,mess3J1,mess1J2,mess2J2,mess3J2 FROM pp_partie_temporaire WHERE id=:id";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':id',$_SESSION['idPartieTemp']);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    $cpt = 0;
    $bool = false;
    if($resultat['joueur1']==$_SESSION['idJoueur']){
      if(empty($resultat['mess1J1'])){
        $sql="UPDATE pp_partie_temporaire SET mess1J1 = :arg WHERE id = :id";
      }elseif(empty($resultat['mess2J1'])){
        $sql="UPDATE pp_partie_temporaire SET mess2J1 = :arg WHERE id = :id";
      }elseif(empty($resultat['mess3J1'])){
        $sql="UPDATE pp_partie_temporaire SET mess3J1 = :arg WHERE id = :id";
      }
    }
    elseif($resultat['joueur2']==$_SESSION['idJoueur']){
      if(empty($resultat['mess1J2'])){
        $sql = "UPDATE pp_partie_temporaire SET mess1J2 = :arg WHERE id = :id";
      }elseif(empty($resultat['mess2J2'])){
        $sql = "UPDATE pp_partie_temporaire SET mess2J2 = :arg WHERE id = :id";
      }elseif(empty($resultat['mess3J2'])){
        $sql = "UPDATE pp_partie_temporaire SET mess3J2 = :arg WHERE id = :id";
      }
    }
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':arg',$message);
    $stmt->bindParam(':id',$_SESSION['idPartieTemp']);
    $stmt->execute();
  }

  public static function ajoutJoueur2($id){
    $sql = "UPDATE pp_partie_temporaire SET joueur2 = :idJoueur WHERE joueur1 = :idJoueurAdverse ";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueur',$_SESSION['idJoueur']);
    $stmt->bindParam(':idJoueurAdverse',$id);
    $stmt->execute();

    $sql="SELECT id FROM pp_partie_temporaire where joueur2 = :idJoueur";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueur',$_SESSION['idJoueur']);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    $_SESSION['idPartieTemp'] = $resultat['id'];
  }

}

?>
