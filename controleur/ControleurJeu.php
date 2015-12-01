<?php

//class ControleurJeu{
  //  private static $page="jeu";
    if (empty($_GET)) {
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
            break;*/

           

            
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
      }
//}
require VIEW_PATH."vue.php";
