<?php

require_once MODEL_PATH."JeuIA.php";
require_once MODEL_PATH."Jeu.php";
require_once MODEL_PATH."StatsPerso.php";

if (empty($_GET)) {
  if(estConnecte()){
    $vue="choixIA";
    $pagetitle="Choisissez votre nombre de manches";
  }

}
else if (isset($action)) {
  switch ($action) {

    case "begin":
    if(estConnecte()){
      $data2 = array(
        "idJoueur1" => $_SESSION['idJoueur'],
        "idJoueur2" => 0,
        "nbManche" => $_POST['nbManche']
      );
      $_SESSION['idPartieEnCours'] = Partie::insertion($data2);
      $dataManche = array(
        "idPartie" => $_SESSION['idPartieEnCours']
      );
      $_SESSION['idMancheEnCours'] = Manche::insertion($dataManche);
      $data5 = array(
        "listeManches" =>   $_SESSION['idMancheEnCours'],
        "idPartie" => $_SESSION['idPartieEnCours']
      );
      Partie::update($data5); // ajout la manche dans listeManches de la partie
      $data3 = array(
        "idJoueur1" => $_SESSION['idJoueur'],
        "idJoueur2" => 0,
        "idManche" => $_SESSION['idMancheEnCours']
      );
      $_SESSION['idCoupEnCours'] = Coup::insertion($data3);
      $data4 = array(
        "listeCoups" =>   $_SESSION['idCoupEnCours'],
        "idManche" => $_SESSION['idMancheEnCours']
      );
      Manche::update($data4); // ajout le coup dans listeCoups de la manche
      //on récup le sexe et l'age du monsieur en SESSION
      $dataJoueur= array("idJoueur" =>$_SESSION['idJoueur']);
      $joueur = Joueur::select($dataJoueur);
      $_SESSION['sexe'] = $joueur->sexe;
      $_SESSION['age'] = $joueur->age;
      $_SESSION['sequenceCoups'] = "";
      $vue="choix";
      $pagetitle="Choisissez votre figure";
    }
    else{
      $messageErreur="Vous n'êtes pas connecté !";
    }
    break;

    case "eval":
        if(estConnecte()){

          // algo de l'IA
          if($_SESSION['sequenceCoups']==""){
            $choixFigure = JeuIA::premierCoup($_SESSION['idJoueur']);
          }
          else{
            //pas premier coup on appelle la grosse fonction qui va renvoyer
            //l'id de la figure à jouer
            $choixFigure = JeuIA::IA($_SESSION['idJoueur'],$_SESSION['sequenceCoups'],$_SESSION['age'],$_SESSION['sexe']);
          }
          //on enregistre le coup de l'IA
          $dataIA = array(
            "idCoup" => $_SESSION['idCoupEnCours'],
            "idFigure2" => $choixFigure
          );
          Coup::update($dataIA);
          //on enregistre le coup du joueur
          $data = array(
            "idFigure1" => $_POST['idFigure'],
            "idCoup" => $_SESSION['idCoupEnCours']
          );
          Coup::update($data);
          //et on stocke son coup dans la sequence
          if(($_SESSION['sequenceCoups'])!=""){
            $_SESSION['sequenceCoups'] .= ",";
          }
          $_SESSION['sequenceCoups'] .= $_POST['idFigure'];
          //evaluation du coup
          if (!Coup::estUnDraw($_SESSION['idCoupEnCours'])) {
            Coup::evaluer($_SESSION['idCoupEnCours']);
            $data= array(
              "idCoup" =>$_SESSION['idCoupEnCours']
            );
            $coup = Coup::select($data);
            $idF1 = $coup->idFigure1;
            $idF2 = $coup->idFigure2;
            $idJG = $coup->idJoueurGagnant;
            $data= array(
              "idJoueur"=> $idJG
            );
            $nomJoueurGagnant = Joueur::select($data)->pseudo;
            if($idJG == $_SESSION['idJoueur']) {
              $message = "Vous remportez la manche !";
            }
            else {
              $message = $nomJoueurGagnant." remporte la manche !";
            }
            $data5 = array(
            "idManche" => $_SESSION['idMancheEnCours'],
            "idJoueurGagnant" => $idJG
            );
            $r = Manche::update($data5); // stocke le gagnant
            $vue="resulatCoup";
            $pagetitle="Résultat du coup !";
          }
          else {
            $data3 = array(
            "idJoueur1" => $_SESSION['idJoueur'],
            "idJoueur2" => 0,
            "idManche" => $_SESSION['idMancheEnCours']
            );
            $_SESSION['idCoupEnCours'] = Coup::insertion($data3);
            $data4 = array(
            "listeCoups" =>  $_SESSION['idCoupEnCours'],
            "idManche" => $_SESSION['idMancheEnCours']
            );
            Manche::updateListeCoup($data4); // ajout le coup dans listeCoup de la manche
            $idF = $_POST['idFigure'];
            $vue="resultatDraw";
            $pagetitle="Et c'est le draw !";
          }

    }
    else{
      $messageErreur="Vous n'êtes pas encore connecté !";
    }
    break;

    case "jouer":
    if(estConnecte()){
        if(Partie::estTerminee($_SESSION['idPartieEnCours'],$_SESSION['idJoueur'],0)) {
          $data= array(
            "idPartie"=> $_SESSION['idPartieEnCours']
          );
          $idJoueurGagnant = Partie::select($data)->idJoueurGagnant;
          $data= array(
            "idJoueur"=> $idJoueurGagnant
          );
          $nomJoueurGagnant = Joueur::select($data)->pseudo;
          if($idJoueurGagnant == $_SESSION['idJoueur']) {
            Joueur::updateNbVictoire($_SESSION['idJoueur']);
            Joueur::updateNbDefaite(0);
            $messageFinal = "Vous remportez la partie !";
          }
          else {
            Joueur::updateNbVictoire(0);
            Joueur::updateNbDefaite($_SESSION['idJoueur']);
            $messageFinal = $nomJoueurGagnant." remporte la partie !";
          }
          $resultat = Partie::getResultat($_SESSION['idPartieEnCours'],$_SESSION['idJoueur'],0);
          $victoireJ1 = $resultat['nbVictoireJ1'];
          $victoireJ2 = $resultat['nbVictoireJ2'];
          $dataStats = array(
            "idJoueur1" =>   $_SESSION['idJoueur'],
            "idJoueur2" => 0,
            "idPartie" => $_SESSION['idPartieEnCours']
          );
          Partie::ajoutStatsGlobales($dataStats);
          // supprimer les variables de session de la partie
          unset($_SESSION['idPartieEnCours']);
          unset($_SESSION['idMancheEnCours']);
          unset($_SESSION['idCoupEnCours']);
          unset($_SESSION['JoueurMaster']);
          unset($_SESSION['sequenceCoups']);
          unset($_SESSION['sexe']);
          unset($_SESSION['age']);
          $vue="resultatPartie";
          $pagetitle="Partie terminée";
        }
        else {
          $dataManche = array(
            "idPartie" => $_SESSION['idPartieEnCours']
          );
          $_SESSION['idMancheEnCours'] = Manche::insertion($dataManche);
          $data5 = array(
            "listeManches" =>   $_SESSION['idMancheEnCours'],
            "idPartie" => $_SESSION['idPartieEnCours']
            );
            Partie::updateListeManche($data5);
            $data3 = array(
            "idJoueur1" => $_SESSION['idJoueur'],
            "idJoueur2" => 0,
            "idManche" => $_SESSION['idMancheEnCours']
            );
            $_SESSION['idCoupEnCours'] = Coup::insertion($data3);
            $data4 = array(
            "listeCoups" =>   $_SESSION['idCoupEnCours'],
            "idManche" => $_SESSION['idMancheEnCours']
            );
            Manche::update($data4);
            $vue="choix";
            $pagetitle="Choisissez votre figure";
          }

      }
      else{
        $messageErreur="Vous n'êtes pas connecté !";
      }
      break;

      case "rejouerCoup":
      if(estConnecte()){
        $vue="choix";
        $pagetitle="Choisissez votre figure";
      }
      else{
        $messageErreur="Vous n'êtes pas connecté !";
      }
      break;

    default :
        $messageErreur="Il semblerait que vous ayez trouvé un glitch dans le système !";
  }
}
else {

        $messageErreur="Il semblerait que vous ayez trouvé un glitch dans le système !";
}
require VIEW_PATH."vue.php";
