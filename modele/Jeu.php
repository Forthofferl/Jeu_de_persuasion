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
      $sql = "SELECT DISTINCT idJoueur, enAttenteDeJoueur,placeSpectateurRestant FROM pp_partie_en_attente WHERE idSujet=:idSujet AND coterSujet=:coterSujet";
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
      $sql="INSERT INTO pp_partie_temporaire (id,idSujet,joueur1,joueur2,mess1J1,mess2J1,mess3J1,mess1J2,mess2J2,mess3J2,tourJoueur1,tourJoueur2) values ('',:idSujet,:idjoueur,-1,'','','','','','','NON','NON')";
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


      $table  = "pp_parties";
      $sql="INSERT INTO pp_parties (idPartie,idSujet,nbArg,idJoueurGagnant,idJoueurPerdant) values (:idPartie,:idSujet,6,NULL ,NULL)";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idSujet',$idSujet[0]);
      $stmt->bindParam(':idPartie',$_SESSION['idPartieTemp']);
      $stmt->execute();

    } catch (PDOException $e) {
      echo $e->getMessage();
      die("Erreur lors de la recherche dans la BDD ".$table);
    }
  }

  public static function getArgJoueurs(){

    $requete="SELECT mess1J1,mess2J1,mess3J1, mess1J2, mess2J2, mess3J2 FROM pp_partie_temporaire WHERE id=:id";
    $stmt = self::$pdo->prepare($requete);
    $stmt->bindParam(':id',$_SESSION['idPartieTemp']);
    $stmt->execute();
    $allMess = $stmt->fetchAll()[0];
    $cpt=0;
    $boolTest = true;
    while($cpt<count($allMess)&&$boolTest){
      if($allMess[$cpt]==null){
        $boolTest=false;
      }
    }

    if(!$boolTest) {
      $requete = "SELECT joueur1, tourJoueur1 FROM pp_partie_temporaire WHERE id=:id";
      $stmt = self::$pdo->prepare($requete);
      $stmt->bindParam(':id', $_SESSION['idPartieTemp']);
      $stmt->execute();
      $J1 = $stmt->fetchAll();

      if ($J1[0]['joueur1'] !== "-1") {
        if ($J1[0]['joueur1'] != null) {
          $requete = "SELECT idArg, message FROM pp_arguments WHERE idPartie=:idPartie AND idJoueur = :idJoueur";
          $stmt = self::$pdo->prepare($requete);
          $stmt->bindParam(':idPartie', $_SESSION['idPartieTemp']);
          $stmt->bindParam(':idJoueur', $J1[0]['joueur1']);
          $stmt->execute();
          $argsJ1 = $stmt->fetchAll();
          $cptArg = 1;
          foreach ($argsJ1 as $argument) {
            $tabIdArg = array('idArg' => $argument['idArg'], 'argument' => $argument['message']);
            $J1[0]['arg' . $cptArg] = $tabIdArg;
            $cptArg++;
          }
          $joueur1 = Joueur::getJoueurByID($J1[0]['joueur1']);
          $J1[0]['joueur1'] = $joueur1[0]['pseudo'];
          if (!$_SESSION['joueur1']) {
            $_SESSION['nomJoueurAdverse'] = $joueur1[0]['pseudo'];
          }
        }
      }

      $requete = "SELECT joueur2, tourJoueur2 FROM pp_partie_temporaire WHERE id=:id";
      $stmt = self::$pdo->prepare($requete);
      $stmt->bindParam(':id', $_SESSION['idPartieTemp']);
      $stmt->execute();
      $J2 = $stmt->fetchAll();

      if ($J2[0]['joueur2'] !== "-1") {
        if ($J2[0]['joueur2'] != null) {
          $requete = "SELECT idArg, message FROM pp_arguments WHERE idPartie=:idPartie AND idJoueur = :idJoueur";
          $stmt = self::$pdo->prepare($requete);
          $stmt->bindParam(':idPartie', $_SESSION['idPartieTemp']);
          $stmt->bindParam(':idJoueur', $J2[0]['joueur2']);
          $stmt->execute();
          $argsJ2 = $stmt->fetchAll();
          $cptArg = 1;
          foreach ($argsJ2 as $argument) {
            $tabIdArg = array('idArg' => $argument['idArg'], 'argument' => $argument['message']);
            $J2[0]['arg' . $cptArg] = $tabIdArg;
            $cptArg++;
          }
          $joueur2 = Joueur::getJoueurByID($J2[0]['joueur2']);
          $J2[0]['joueur2'] = $joueur2[0]['pseudo'];

          if ($_SESSION['joueur1']) {
            $_SESSION['nomJoueurAdverse'] = $joueur2[0]['pseudo'];
          }
        }
      }

      $data = array('statut'=>"EN COURS",'J1'=> $J1,'J2'=> $J2);
    }
    else{
      sleep(30);
      $data = Jeu::calculTotal();
    }
    return $data;

  }

  public static function calculTotal(){
    $requete = "SELECT joueur2, joueur1 FROM pp_partie_temporaire WHERE id=:id";
    $stmt = self::$pdo->prepare($requete);
    $stmt->bindParam(':id', $_SESSION['idPartieTemp']);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];

    $requete = "SELECT nbVote FROM pp_arguments WHERE idPartie=:idPartie AND idJoueur=:idJoueur";
    $stmt = self::$pdo->prepare($requete);
    $stmt->bindParam(':idPartie', $_SESSION['idPartieTemp']);
    $stmt->bindParam(':idJoueur', $resultat['joueur1']);
    $stmt->execute();
    $nbVoteArgJ1 = $stmt->fetchAll()[0];
    $totalVoteJ1=0;
    foreach ($nbVoteArgJ1 as $vote) {
      $totalVoteJ1 = $nbVoteArgJ1 + intval($vote);
    }

    $requete = "SELECT nbVote FROM pp_arguments WHERE idPartie=:idPartie AND idJoueur=:idJoueur";
    $stmt = self::$pdo->prepare($requete);
    $stmt->bindParam(':idPartie', $_SESSION['idPartieTemp']);
    $stmt->bindParam(':idJoueur', $resultat['joueur2']);
    $stmt->execute();
    $nbVoteArgJ2 = $stmt->fetchAll()[0];
    $totalVoteJ2=0;
    foreach ($nbVoteArgJ1 as $vote) {
      $totalVoteJ2 = $nbVoteArgJ2 + intval($vote);
    }

    $nomJoueur1 = Joueur::getJoueurByID($resultat['joueur1'])[0]['pseudo'];
    $nomJoueur2 = Joueur::getJoueurByID($resultat['joueur2'])[0]['pseudo'];

    if($totalVoteJ1>$totalVoteJ2){
      $resultat = "Joueur1";
    }
    else if($totalVoteJ2>$totalVoteJ1){
      $resultat = "Joueur2";
    }
    else{
      $resultat = "EGALITE";
    }

    $resultatFinal = array('statut'=>"FIN",'resultat'=>$resultat,'nomJoueur1'=>$nomJoueur1,'nomJoueur2'=>$nomJoueur2);
    return $resultatFinal;
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


    $sqlArg = "INSERT INTO pp_arguments (idArg,message,idPartie,idJoueur,nbVote) values ('',:message,:idPartie,:idJoueur,0)";
    $stmt = self::$pdo->prepare($sqlArg);
    $stmt->bindParam(':message',$message);
    $stmt->bindParam(':idPartie',$_SESSION['idPartieTemp']);
    $stmt->bindParam(':idJoueur',$_SESSION['idJoueur']);
    $stmt->execute();
  }

  public static function ajoutJoueur2($id){
    $sql = "SELECT placeSpectateurRestant FROM pp_partie_en_attente WHERE idJoueur = :idJoueurAdverse ";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueurAdverse',$id);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    if($resultat['placeSpectateurRestant']<=3) {
      $sql = "UPDATE pp_partie_temporaire SET joueur2 = :idJoueur, tourJoueur1 = 'OUI' WHERE joueur1 = :idJoueurAdverse ";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idJoueur', $_SESSION['idJoueur']);
      $stmt->bindParam(':idJoueurAdverse', $id);
      $stmt->execute();
    }
    else{
      $sql = "UPDATE pp_partie_temporaire SET joueur2 = :idJoueur WHERE joueur1 = :idJoueurAdverse ";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idJoueur', $_SESSION['idJoueur']);
      $stmt->bindParam(':idJoueurAdverse', $id);
      $stmt->execute();
    }
    $sql = "UPDATE pp_partie_en_attente SET enAttenteDeJoueur = 'NON' WHERE idJoueur = :idJoueurAdverse ";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueurAdverse',$id);
    $stmt->execute();

    $sql="SELECT id FROM pp_partie_temporaire where joueur2 = :idJoueur";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueur',$_SESSION['idJoueur']);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    $_SESSION['idPartieTemp'] = $resultat['id'];
  }

  public static function deleteJoueurInPartie(){
    $sql="SELECT * FROM pp_partie_temporaire where id = :id";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':id',$_SESSION['idPartieTemp']);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];

    $sqlDelPartie = "DELETE FROM pp_parties WHERE idPartie = :idPartie";
    $stmt = self::$pdo->prepare($sqlDelPartie);
    $stmt->bindParam(':idPartie',$_SESSION['idPartieTemp']);
    $stmt->execute();

    if($_SESSION['joueur1']){
      $sql="DELETE FROM pp_partie_en_attente WHERE idJoueur = :idJoueur";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idJoueur',$_SESSION['idJoueur']);
      $stmt->execute();
      if(empty($resultat['joueur2'])||$resultat['joueur2']=="-1"){
        $sql = "DELETE FROM pp_partie_temporaire WHERE id = :id ";
      }
      else {
        $sql = "UPDATE pp_partie_temporaire SET joueur1 = NULL WHERE id = :id ";
      }
    }
    else{
      $sql="DELETE FROM pp_partie_en_attente WHERE idJoueur = :idJoueur";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idJoueur',$_SESSION['idJoueurAdverse']);
      $stmt->execute();
      if(empty($resultat['joueur1'])){
        $sql = "DELETE FROM pp_partie_temporaire WHERE id = :id ";
      }
      else {
        $sql = "UPDATE pp_partie_temporaire SET joueur2 = NULL WHERE id = :id ";
      }
    }
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':id',$_SESSION['idPartieTemp']);
    $stmt->execute();
  }

  public static function deleteSpectateurInPartie()
  {
    $sql = "SELECT placeSpectateurRestant FROM pp_partie_en_attente WHERE idJoueur = :idJoueur";
    $stmt = self::$pdo->prepare($sql);

    $stmt->bindParam(':idJoueur', $_SESSION['idJoueurAdverse']);
    $stmt->execute();
    $placeSpectateurRestant = $stmt->fetchAll();
    if (!empty($placeSpectateurRestant)){
      $newPlaceRestant = $placeSpectateurRestant[0]['placeSpectateurRestant'] + 1;

      $sql = "UPDATE pp_partie_en_attente SET  placeSpectateurRestant = :newPlaceRestant WHERE idJoueur = :id ";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':id', $_SESSION['idJoueurAdverse']);
      $stmt->bindParam(':newPlaceRestant', $newPlaceRestant);
      $stmt->execute();
    }

  }

  public static function newSpectateur($idJoueur){

    $sql = "SELECT placeSpectateurRestant,enAttenteDeJoueur FROM pp_partie_en_attente WHERE idJoueur = :idJoueur";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueur',$idJoueur);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    $placeSpectateurRestant = $resultat['placeSpectateurRestant'];
    $enAttenteDeJoueur = $resultat['enAttenteDeJoueur'];

    if($enAttenteDeJoueur=="NON"){
      $sql = "UPDATE pp_partie_temporaire SET tourJoueur1 = 'OUI' WHERE joueur1 = :idJoueur ";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idJoueur', $idJoueur);
      $stmt->execute();
    }

    $sql = "UPDATE pp_partie_en_attente SET placeSpectateurRestant = :newNbreSpectateur WHERE idJoueur = :idJoueurAdverse ";
    $stmt = self::$pdo->prepare($sql);
    $newPlaceRestant = $placeSpectateurRestant-1;
    $stmt->bindParam(':newNbreSpectateur',$newPlaceRestant);
    $stmt->bindParam(':idJoueurAdverse',$idJoueur);
    $stmt->execute();

    $sql="SELECT id FROM pp_partie_temporaire where joueur1 = :idJoueur";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueur',$idJoueur);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    $_SESSION['idPartieTemp'] = $resultat['id'];

  }

  public static function updateVote($idArg,$typeVote){
    if($typeVote!="NEUTRE") {
      $sql = "SELECT nbVote FROM pp_arguments WHERE idArg = :idArg";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idArg', $idArg);
      $stmt->execute();
      $nbVote = $stmt->fetchAll()[0]['nbVote'];

      $sql = "UPDATE pp_arguments SET nbVote = :nbVote WHERE idArg = :idArg ";
      $stmt = self::$pdo->prepare($sql);
      if ($typeVote == "PLUS") {
        $newVote = $nbVote + 1;
      } else if ($typeVote == "MOINS") {
        $newVote = $nbVote - 1;
      }
      $stmt->bindParam(':nbVote', $newVote);
      $stmt->bindParam(':idArg', $idArg);
      $stmt->execute();
    }
    $_SESSION["'".$idArg."'"] = "OUI";
    $sql = "SELECT nbVote FROM pp_arguments WHERE idArg = :idArg";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idArg',$idArg);
    $stmt->execute();
    return $stmt->fetchAll()[0]['nbVote'];
  }
}

?>
