<?php

require_once 'Modele.php';
require_once 'Partie.php';
require_once MODEL_PATH.'Joueur.php'; // connerie de wamp qui ne fait pas la diff entre une min et un maj

//modèle contenant les fonctions utilisé dans le jeu
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

  public static function getNomSujet($nomTheme){
    try {
      $sql = "SELECT DISTINCT nom FROM pp_sujets WHERE nomTheme=:nomTheme";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':nomTheme',$nomTheme);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      echo $e->getMessage();
      die("Erreur lors de la recherche dans la BDD pp_sujets");
    }
  }

  public static function getIdSujetByNom($nom){
    try {
      $sql = "SELECT DISTINCT idSujet FROM pp_sujets WHERE nom=:nom";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':nom',$nom);
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
      // création une partie en attente
      $table  = "pp_partie_en_attente";
      $sql = "INSERT INTO pp_partie_en_attente (idPartie_en_attente,idJoueur,idSujet,coterSujet,placeSpectateurRestant) values ('',:idjoueur,:idSujet,:coterSujet,5)";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idjoueur',$_SESSION['idJoueur']);
      $stmt->bindParam(':idSujet',$idSujet[0]);
      $stmt->bindParam(':coterSujet',$coterSujet);
      $stmt->execute();

      //création partie temporaire
      $table  = "pp_partie_temporaire";
      $sql="INSERT INTO pp_partie_temporaire (id,idSujet,joueur1,joueur2,tourJoueur1,tourJoueur2) values ('',:idSujet,:idjoueur,-1,'NON','NON')";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idjoueur',$_SESSION['idJoueur']);
      $stmt->bindParam(':idSujet',$idSujet[0]);
      $stmt->execute();



      // récupération de id de la partie temporaire
      $sql="SELECT id FROM pp_partie_temporaire where joueur1 = :idJoueur";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idJoueur',$_SESSION['idJoueur']);
      $stmt->execute();
      $resultat = $stmt->fetchAll()[0][0];
      $_SESSION['idPartieTemp'] = $resultat;


      //création de la partie en mettant en id le même que celui de la partie temporaire
      $table  = "pp_parties";
      $sql="INSERT INTO pp_parties (idPartie,idSujet,nbArg,idJoueurGagnant,idJoueurPerdant) values (:idPartie,:idSujet,6,NULL ,NULL)";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idSujet',$idSujet[0]);
      $stmt->bindParam(':idPartie',$_SESSION['idPartieTemp']);
      $stmt->execute();


      //insertion du coter du joueur créant la partie
      $table  = "pp_coter_sujet";
      $sql="INSERT INTO pp_coter_sujet (idPartie,idJoueur,coter) values (:idPartie,:idjoueur,:coterSujet)";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idPartie',$resultat);
      $stmt->bindParam(':idjoueur',$_SESSION['idJoueur']);
      $stmt->bindParam(':coterSujet',$coterSujet);
      $stmt->execute();

      // session empechant de mettre à jour la victoire/défaite après la fin d'une partie lorsque l'un des deux joueurs sort
      $_SESSION['updateVictoireDefaiteJoueur']=false;

    } catch (PDOException $e) {
      echo $e->getMessage();
      die("Erreur lors de la recherche dans la BDD ".$table);
    }
  }

  // fonction principale du chat elle va récupérer le arguments des deux joueurs
  public static function getArgJoueurs(){
    //compte le nombre d'argument pour savoir si la partie est fini
    $requete="SELECT COUNT( * )
              FROM pp_arguments
              WHERE idPartie =:idPartie";
    $stmt = self::$pdo->prepare($requete);
    $stmt->bindParam(':idPartie',$_SESSION['idPartieTemp']);
    $stmt->execute();
    $countArgument = $stmt->fetchAll()[0];

    // si la partie n'est pas fini on entre
    if($_SESSION['boolFin']=="NON") {
      //on récupère l'id du joueur1 et si c'est son tour
      $requete = "SELECT joueur1, tourJoueur1 FROM pp_partie_temporaire WHERE id=:id";
      $stmt = self::$pdo->prepare($requete);
      $stmt->bindParam(':id', $_SESSION['idPartieTemp']);
      $stmt->execute();
      $J1 = $stmt->fetchAll();

      //si le joueur n'a pas quitter la partie on entre
      if ($J1[0]['joueur1'] !== "-1") {
        // si il y a bien un joueur1
        if ($J1[0]['joueur1'] != null) {
          //réucpère les id et contenu de tout les arguments du joueur 1
          $requete = "SELECT idArg, message FROM pp_arguments WHERE idPartie=:idPartie AND idJoueur = :idJoueur";
          $stmt = self::$pdo->prepare($requete);
          $stmt->bindParam(':idPartie', $_SESSION['idPartieTemp']);
          $stmt->bindParam(':idJoueur', $J1[0]['joueur1']);
          $stmt->execute();
          $argsJ1 = $stmt->fetchAll();
          $cptArg = 1;
          //rempli un tableau avec les argument du joueur 1 en mettant en leur assignant un index pour facilité les tests.
          foreach ($argsJ1 as $argument) {
            $tabIdArg = array('idArg' => $argument['idArg'], 'argument' => $argument['message']);
            $J1[0]['arg' . $cptArg] = $tabIdArg;
            $cptArg++;
          }
          //récupère le nom du joueur1
          $joueur1 = Joueur::getJoueurByID($J1[0]['joueur1']);
          //remplace son id par son nom
          $J1[0]['joueur1'] = $joueur1[0]['pseudo'];
          //si le joueur n'est pas le joueur1 on met le nom du joueur1 dans une session en tant que joueur adverse
          if (!$_SESSION['joueur1']) {
            $_SESSION['nomJoueurAdverse'] = $joueur1[0]['pseudo'];
          }
        }
      }

      // on fait la même chose avec le joueur2
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

      //vérification des tours
      if($J1[0]['tourJoueur1']=="OUI"){
        $tour=$J1[0]['joueur1'];
      }
      elseif($J2[0]['tourJoueur2']=="OUI"){
        $tour=$J2[0]['joueur2'];
      }
      else{
        $tour="En attente";
      }

      //vérification fin de partie
      if($countArgument[0]==6){
        $_SESSION['boolFin'] = "OUI";
      }
      else{
        $_SESSION['boolFin'] = "NON";
      }

      $data = array('statut'=>"EN COURS",'J1'=> $J1,'J2'=> $J2,'tour'=>$tour);

    }
    else{
      // si c'est la fin de la partie on calcul qui a gagné
      $arrayFin = Jeu::calculTotal();
      $_SESSION['boolFin']="OUI";
      $data = $arrayFin;
    }
    return $data;

  }

  // permet de determiner qui a gagné
  public static function calculTotal(){
    $requete = "SELECT joueur2, joueur1 FROM pp_partie_temporaire WHERE id=:id";
    $stmt = self::$pdo->prepare($requete);
    $stmt->bindParam(':id', $_SESSION['idPartieTemp']);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    if(!empty($resultat['joueur1'])||!empty($resultat['joueur2'])) {

      // récupère les résultat des deux joueurs
      $score = Partie::getResultat($_SESSION['idPartieTemp'],$resultat['joueur1'],$resultat['joueur2']);
      $totalVoteJ1 = intval($score['scoreJ1']);
      $totalVoteJ2 = intval($score['scoreJ2']);

      $_SESSION['nomJoueur1'] = Joueur::getJoueurByID($resultat['joueur1'])[0]['pseudo'];
      $_SESSION['nomJoueur2'] = Joueur::getJoueurByID($resultat['joueur2'])[0]['pseudo'];
      // comparaison des résultats et mise à jour du gagnants et du perdant
      if ($totalVoteJ1 > $totalVoteJ2) {
        $sqlFinPartie = "UPDATE pp_parties SET idJoueurGagnant = :idJoueur1, idJoueurPerdant = :idJoueur2 WHERE idPartie = :id";
        $stmt = self::$pdo->prepare($sqlFinPartie);
        $stmt->bindParam(':id', $_SESSION['idPartieTemp']);
        $stmt->bindParam(':idJoueur2', $resultat['joueur2']);
        $stmt->bindParam(':idJoueur1', $resultat['joueur1']);
        $stmt->execute();
        if(!$_SESSION['updateVictoireDefaiteJoueur']) {

          Joueur::updateNbVictoire($resultat['joueur1']);
          Joueur::updateNbDefaite($resultat['joueur2']);
          $_SESSION['updateVictoireDefaiteJoueur']=true;
        }

        $_SESSION['resultat'] = "Joueur1";
      } else if ($totalVoteJ2 > $totalVoteJ1) {
        $sqlFinPartie = "UPDATE pp_parties SET idJoueurGagnant = :idJoueur2, idJoueurPerdant = :idJoueur1 WHERE idPartie = :id";
        $stmt = self::$pdo->prepare($sqlFinPartie);
        $stmt->bindParam(':id', $_SESSION['idPartieTemp']);
        $stmt->bindParam(':idJoueur2', $resultat['joueur2']);
        $stmt->bindParam(':idJoueur1', $resultat['joueur1']);
        $stmt->execute();
        if(!$_SESSION['updateVictoireDefaiteJoueur']) {
          Joueur::updateNbVictoire($resultat['joueur2']);
          Joueur::updateNbDefaite($resultat['joueur1']);
          $_SESSION['updateVictoireDefaiteJoueur']=true;
        }
        $_SESSION['resultat'] = "Joueur2";
      } else {
        $_SESSION['resultat'] = "EGALITE";
      }
    }
    $resultatFinal = array('statut'=>"FIN",'resultat'=>$_SESSION['resultat'],'nomJoueur1'=>$_SESSION['nomJoueur1'],'nomJoueur2'=>$_SESSION['nomJoueur2'],'tour'=>"FIN");
    return $resultatFinal;
  }

  // ajout des argument à la bdd
  public static function addMessage($message){
    $requete="SELECT COUNT( * )
              FROM pp_arguments
              WHERE idPartie =:idPartie";
    $stmt = self::$pdo->prepare($requete);
    $stmt->bindParam(':idPartie',$_SESSION['idPartieTemp']);
    $stmt->execute();
    $countArgument = $stmt->fetchAll()[0];

    $requete="SELECT joueur1,joueur2,tourJoueur1,tourJoueur2
              FROM pp_partie_temporaire
              WHERE id =:idPartie";
    $stmt = self::$pdo->prepare($requete);
    $stmt->bindParam(':idPartie',$_SESSION['idPartieTemp']);
    $stmt->execute();
    $tourJoueurs = $stmt->fetchAll()[0];
    if($tourJoueurs['tourJoueur1']=="OUI"&&$tourJoueurs['joueur1']==$_SESSION['idJoueur']){

      $tour=true;
    }
    elseif($tourJoueurs['tourJoueur2']=="OUI"&&$tourJoueurs['joueur2']==$_SESSION['idJoueur']){
      $tour=true;
    }
    else{
      $tour=false;
    }
    // vérifie si c'est la fin de partie et si c'est bien le tour du joueur qui essaye d'envoyer un argument
    if($countArgument[0]<6&&$tour) {
      $sqlArg = "INSERT INTO pp_arguments (idArg,message,idPartie,idJoueur,nbVote) values ('',:message,:idPartie,:idJoueur,0)";
      $stmt = self::$pdo->prepare($sqlArg);
      $stmt->bindParam(':message', $message);
      $stmt->bindParam(':idPartie', $_SESSION['idPartieTemp']);
      $stmt->bindParam(':idJoueur', $_SESSION['idJoueur']);
      $stmt->execute();

      $requete="SELECT joueur1,joueur2
              FROM pp_partie_temporaire
              WHERE id =:idPartie";
      $stmt = self::$pdo->prepare($requete);
      $stmt->bindParam(':idPartie',$_SESSION['idPartieTemp']);
      $stmt->execute();
      $idJoueurs = $stmt->fetchAll()[0];

      if($idJoueurs['joueur1']==$_SESSION['idJoueur']){
        $sql="UPDATE pp_partie_temporaire SET tourJoueur1 = 'NON', tourJoueur2 = 'OUI' WHERE id = :idPartie";
      }
      else{
        $sql="UPDATE pp_partie_temporaire SET tourJoueur1 = 'OUI', tourJoueur2 = 'NON' WHERE id = :idPartie";
      }
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idPartie',$_SESSION['idPartieTemp']);
      $stmt->execute();
    }



  }

  //ajout du deuxième joueur à une partie
  public static function ajoutJoueur2($id){
    $sql = "SELECT placeSpectateurRestant FROM pp_partie_en_attente WHERE idJoueur = :idJoueurAdverse ";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueurAdverse',$id);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    //si il y a au moins un spectateur on débute la partie
    if($resultat['placeSpectateurRestant']<=4) {
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

    $sql="SELECT coterSujet FROM pp_partie_en_attente where idJoueur = :idJoueur";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueur',$id);
    $stmt->execute();
    $coterSujet = $stmt->fetchAll()[0]['coterSujet'];

    if($coterSujet=="POUR"){
      $coterSujet="CONTRE";
    }
    else{
      $coterSujet="POUR";
    }

    $table  = "pp_coter_sujet";
    $sql="INSERT INTO pp_coter_sujet (idPartie,idJoueur,coter) values (:idPartie,:idjoueur,:coterSujet)";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idPartie',$resultat['id']);
    $stmt->bindParam(':idjoueur',$_SESSION['idJoueur']);
    $stmt->bindParam(':coterSujet',$coterSujet);
    $stmt->execute();
    $_SESSION['updateVictoireDefaiteJoueur']=false;
  }

  //suppresion d'un joueur d'un partie
  public static function deleteJoueurInPartie(){
    $sql="SELECT * FROM pp_partie_temporaire where id = :id";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':id',$_SESSION['idPartieTemp']);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    // vérifie si la partie est fini, car on supprime les arguments déjà inscrit si ce n'est pas le cas
    if($_SESSION['boolFin']=="NON") {
      $sqlDelPartie = "DELETE FROM pp_parties WHERE idPartie = :idPartie";
      $stmt = self::$pdo->prepare($sqlDelPartie);
      $stmt->bindParam(':idPartie', $_SESSION['idPartieTemp']);
      $stmt->execute();
    }

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
    $_SESSION['idJoueurAdverse'] = null;
  }

  public static function deleteSpectateurInPartie()
  {
    $sql = "SELECT placeSpectateurRestant FROM pp_partie_en_attente WHERE idJoueur = :idJoueur";
    $stmt = self::$pdo->prepare($sql);

    $stmt->bindParam(':idJoueur', $_SESSION['idJoueurAdverse']);
    $stmt->execute();
    $placeSpectateurRestant = $stmt->fetchAll();
    if (!empty($placeSpectateurRestant)){

      self::incrementeNbrPlaceSpectateur();
    }

  }

  // ajout d'un nouveau spectateur
  public static function newSpectateur($idJoueur){

    $sql = "SELECT placeSpectateurRestant,enAttenteDeJoueur FROM pp_partie_en_attente WHERE idJoueur = :idJoueur";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueur',$idJoueur);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    $placeSpectateurRestant = $resultat['placeSpectateurRestant'];
    $enAttenteDeJoueur = $resultat['enAttenteDeJoueur'];

    //si il y a deux joueurs on débute la partie
    if($enAttenteDeJoueur=="NON"){
      $sql = "UPDATE pp_partie_temporaire SET tourJoueur1 = 'OUI' WHERE joueur1 = :idJoueur ";
      $stmt = self::$pdo->prepare($sql);
      $stmt->bindParam(':idJoueur', $idJoueur);
      $stmt->execute();
    }

    if($placeSpectateurRestant>0) {
      self::decrementeNbrSpectateur($idJoueur, $placeSpectateurRestant);
    }

    $sql="SELECT id FROM pp_partie_temporaire where joueur1 = :idJoueur";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueur',$idJoueur);
    $stmt->execute();
    $resultat = $stmt->fetchAll()[0];
    $_SESSION['idPartieTemp'] = $resultat['id'];
    $_SESSION['updateVictoireDefaiteJoueur']=false;

  }

  // fonction de vote pour les arguments
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

  /**
   * @param $idJoueur
   * @param $placeSpectateurRestant
   * @return array
   */
  public static function decrementeNbrSpectateur($idJoueur, $placeSpectateurRestant)
  {
    $sql = "UPDATE pp_partie_en_attente SET placeSpectateurRestant = placeSpectateurRestant-1 WHERE idJoueur = :idJoueurAdverse ";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':idJoueurAdverse', $idJoueur);
    $stmt->execute();
    return array($sql, $stmt);
  }

  public static function incrementeNbrPlaceSpectateur()
  {
    $sql = "UPDATE pp_partie_en_attente SET  placeSpectateurRestant = placeSpectateurRestant+1 WHERE idJoueur = :id ";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['idJoueurAdverse']);
    $stmt->execute();
  }
}



?>
