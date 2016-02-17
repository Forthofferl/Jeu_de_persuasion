<?php

class ControleurJeu{

    public function selectSujet($data){
        $listSujets = Jeu::getNomSujet($data);
        require VIEW_PATH . "jeu".DIRECTORY_SEPARATOR."listeSujet.php";
    }

    public function selectPartieEnAttente($data){
        $idSujet = Jeu::getIdSujetByNom($data[0])[0];
        $coterSujet = $data[1];
        if($coterSujet=="POUR") {
            $coterSujet = "CONTRE";
        }else{
            $coterSujet="POUR";
        }
        $partieEnAttente = Jeu::getPartieEnAttente($idSujet[0],$coterSujet);
        foreach($partieEnAttente as $partie){
            if($partie[0]==$_SESSION['idJoueur']){
                ;
            }
            else {
                $joueur = Joueur::getJoueurByID($partie[0])[0];
                $nomJoueur[] = $joueur[1];
            }
        }

        require VIEW_PATH . "jeu".DIRECTORY_SEPARATOR."listePartieEnAttente.php";
    }
    /*if (empty($_GET)) {
      if(estConnecte()){
        $dataWaiting = array(
          "idJoueur" => $_SESSION['idJoueur']
        );
        $attente = Jeu::selectWhere($dataWaiting);
        if (isset($_SESSION['idJoueurAdverse'])) { // on est dans une partie ?
          $vue="waitLoad";
          $pagetitle="Chargement en cours des nouvelles données...";
        }
        else if($attente != null) { // on est en recherche d'un adversaire ?
            $pagetitle="En attente d'un adversaire !";
            $vue="attente";
        }
        else {
            $listeJoueurs = Jeu::listeAttente();
            $pagetitle="Jouer !";
            $vue="recherche";
        }

      }
      else {
          $messageErreur="Vous n'êtes pas connecté, vous ne pouvez pas jouer !";
      }

    }
    else if (isset($action)) {
        switch ($action) {

            case "jouer":

                $theme=Jeu::getNomTheme();


                break;
            /*case "annulerPartie":
                if(estConnecte()){
                  $dataWaiting = array(
                    "idJoueur" => $_SESSION['idJoueur']
                  );
                  $attente = Jeu::selectWhere($dataWaiting);
                    if (isset($_SESSION['idJoueurAdverse'])) { // on est dans une partie ?
                      $data = array(
                          "idPartie" => $_SESSION['idPartieEnCours']
                      );
                      Partie::suppression($data);
                      unset($_SESSION['idJoueurAdverse']);
                      unset($_SESSION['idPartieEnCours']);
                      unset($_SESSION['idMancheEnCours']); // si elle existe pas, rien ne sera fait
                      unset($_SESSION['idCoupEnCours']);
                      unset($_SESSION['JoueurMaster']);
                      $vue="partieAnnulee";
                      $pagetitle="Partie annulée !";
                    }
                    else if($attente != null) { // on est en recherche d'un adversaire ?
                        $pagetitle="En attente d'un adversaire !";
                        $vue="attente";
                    }
                    else {
                        $listeJoueurs = Jeu::listeAttente();
                        $pagetitle="Jouer !";
                        $vue="recherche";
                    }
                }
                else{
                    $messageErreur="Vous n'êtes pas connecté !";
                }
            break;

            case "annuler":
                if(estConnecte()){
                  $dataWaiting = array(
                    "idJoueur" => $_SESSION['idJoueur']
                  );
                  $attente = Jeu::selectWhere($dataWaiting);
                    if (isset($_SESSION['idJoueurAdverse'])) { // on est dans une partie ?
                      $vue="waitLoad";
                      $pagetitle="Chargement en cours des nouvelles données...";
                      break;
                    }
                    else if($attente != null) { // on est en recherche d'un adversaire ?
                      $dataDel = array(
                        "idJoueur" => $_SESSION['idJoueur']
                      );
                      Jeu::suppressionWhere($dataDel);
                        $vue="deleted";
                        $pagetitle="Annulation de la recherche d'une partie !";
                        break;
                    }
                    else{
                        $messageErreur="Vous n'êtes pas dans la liste d'attente !";
                    }
                }
                else{
                    $messageErreur="Vous n'êtes pas connecté !";
                }
            break;

           

            
        default :
            $dataWaiting = array(
              "idJoueur" => $_SESSION['idJoueur']
            );
            $attente = Jeu::selectWhere($dataWaiting);
            if($attente != null) { // on est en recherche d'un adversaire ?
                $pagetitle="En attente d'un adversaire !";
                $vue="attente";
                break;
            }
            else if (isset($_SESSION['idJoueurAdverse'])) { // on est dans une partie ?
              $vue="waitLoad";
              $pagetitle="Chargement en cours des nouvelles données...";
              break;
            } // donc une erreur
            $messageErreur="Il semblerait que vous ayez trouvé un glitch dans le système !";
        }
      }
      else {
        $dataWaiting = array(
          "idJoueur" => $_SESSION['idJoueur']
        );
        $attente = Jeu::selectWhere($dataWaiting);
        if($attente != null) { // on est en recherche d'un adversaire ?
            $pagetitle="En attente d'un adversaire !";
            $vue="attente";
        }
        else if (isset($_SESSION['idJoueurAdverse'])) { // on est dans une partie ?
          $vue="waitLoad";
          $pagetitle="Chargement en cours des nouvelles données...";
        } // donc une erreur
        $messageErreur="Il semblerait que vous ayez trouvé un glitch dans le système !";
      }*/
}
