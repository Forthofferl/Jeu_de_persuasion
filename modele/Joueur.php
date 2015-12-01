<?php

/*
 * Classe Joueur
 */


class Joueur extends Modele {

  protected static $table = "pfcls_Joueurs";
  protected static $primary_index = "idJoueur";

    public static function connexion($data) {
        $_SESSION['idJoueur'] = $data['idJoueur'];
        $_SESSION['pseudo'] = $data['pseudo'];
    }

    public static function deconnexion(){
        session_unset();
        session_destroy();
    }

    public static function updateNbVictoire($idJ) {
            try {
                $req = self::$pdo->prepare('UPDATE pfcls_Joueurs SET nbV=nbV+1 WHERE idJoueur='.$idJ);
                $req->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                $messageErreur="Erreur lors de la mise à jour du nb de victoire d'un joueur dans la base de données";
            }
    }

    public static function updateNbDefaite($idJ) {
            try {
                $req = self::$pdo->prepare('UPDATE pfcls_Joueurs SET nbD=nbD+1 WHERE idJoueur='.$idJ);
                $req->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                $messageErreur="Erreur lors de la mise à jour du nb de défaite d'un joueur dans la base de données";
            }
    }

    public static function getRatio($nbv,$nbd){
      $r = 0;
      if($nbv==0 && $nbd!=0) $r = 0;
      if($nbv!=0 && $nbd==0) {
        $r = $nbv;
      }
      if($nbv!=0 && $nbd!=0) {
        $r = $nbv/$nbd;
      }
      return $r;
    }

    public static function getHistorique($idJ) {
      try {
        $sql = 'SELECT * FROM pfcls_Parties WHERE idJoueur1='.$idJ.' OR idJoueur2='.$idJ.' ORDER BY idPartie DESC LIMIT 10';
        $req = self::$pdo->query($sql);
        return $req->fetchAll(PDO::FETCH_OBJ);
      } catch (PDOException $e) {
        echo $e->getMessage();
        $messageErreur="Erreur lors de la mise à jour du nb de défaite d'un joueur dans la base de données";
      }
    }

    public static function getClassement() {
      $listeJoueurs = Joueur::selectAll();
      $tableau = array();
      foreach ($listeJoueurs as $joueur) {
          $ratio = Joueur::getRatio($joueur->nbV,$joueur->nbD);
          $tableau[$joueur->pseudo] = $ratio;
      }
      arsort($tableau);
      return $tableau;
    }

    public static function premierCoupStats($donneesDeJeu) {
      if($donneesDeJeu == NULL) {
        return array();
      }
      $var1 = $var2 = $var3 = $var4 = $var5 = 0;
      foreach ($donneesDeJeu as $key => $value) {
          $varTemp=substr($value,0,1);
          switch ($varTemp) {
            case 1: $var1 ++; break;
            case 2: $var2 ++; break;
            case 3: $var3 ++; break;
            case 4: $var4 ++; break;
            case 5: $var5 ++; break;
          }
      }
      return $arrayValeur=array(1 => $var1,$var2,$var3,$var4,$var5);
      //return array_search(max($arrayValeur),$arrayValeur);
    }

    public static function apresFigure($donneesDeJeu,$idFigure) {
      /*if($donneesDeJeu == NULL) {
        return array();
      }
      $donnees = JeuIA::coupSuiv($donneesDeJeu,$idFigure);
      $var1 = $var2 = $var3 = $var4 = $var5 = 0;
      if(!is_array($donnees)) return $arrayValeur=array(1 => $var1,$var2,$var3,$var4,$var5);
      foreach ($donnees as $key => $value) {
        switch (intval($value)) {
          case 1: $var1 ++; break;
          case 2: $var2 ++; break;
          case 3: $var3 ++; break;
          case 4: $var4 ++; break;
          case 5: $var5 ++; break;
        }
      }
      return $arrayValeur=array(1 => $var1,$var2,$var3,$var4,$var5);*/
    }
    
    public static function getProfil($data){
        $joueur = Joueur::select($data);
        $a = $joueur->age;
        $s = $joueur->sexe;
        $e = $joueur->email;
        $nbv = $joueur->nbV;
        $nbd = $joueur->nbD;
        $r = Joueur::getRatio($nbv,$nbd);

        $listeJoueurs = Joueur::selectAll();
        $cl = 1;
        $compteur = 0;
        foreach ($listeJoueurs as $joueur) {
          $compteur += 1;
          if ($joueur->idJoueur != $_SESSION['idJoueur']) {
            $ratio = Joueur::getRatio($joueur->nbV,$joueur->nbD);
            if ($ratio >= $r) $cl += 1;
          }
        }

        $progressbar = 100-intval(($cl*100)/$compteur);

        if ($progressbar <= 20) $couleurpb = " progress-bar-danger";
        else if (20 < $progressbar && $progressbar <= 40) $couleurpb = " progress-bar-warning";
        else if (40 < $progressbar && $progressbar <= 60) $couleurpb = "";
        else if (60 < $progressbar && $progressbar <= 80) $couleurpb = " progress-bar-info";
        else $couleurpb = " progress-bar-success";

        if ($s == "H") $s = "";
        else $s = "fe";

        if ($cl == 1) $eme = "er";
        else $eme = "ème";

        $r = substr($r, 0, 4); // on coupe la chaine de caractère $r 2 chiffres après la virgule

        //statistiques

        $dataJ = array('idJoueur'=> intval($_SESSION['idJoueur']));
        $donneesDeJeu = StatsPerso::selectWhere($dataJ);

        //historique

        $listeParties = Joueur::getHistorique($_SESSION['idJoueur']);
        $tableauVue = '<div class="table-responsive"><table class="table table-bordered table-hover"><thead>
        <tr><th> Adversaire </th><th> Gagnant </th><th> Score </th></tr></thead><tbody>';
        foreach ($listeParties as $partie) {
          if ($partie->idJoueur1 == $_SESSION['idJoueur']) $idJoueurAdverse = $partie->idJoueur2;
          else $idJoueurAdverse = $partie->idJoueur1;
          $data = array(
              "idJoueur"=> $idJoueurAdverse
          );
          $tableauVue .= '<tr><td>'.Joueur::select($data)->pseudo.'</td>';
          if($partie->idJoueurGagnant == null) {
            $tableauVue .= '<td>Aucun (NULL)</td>';
          }
          else {
            $data2 = array(
              "idJoueur"=> $partie->idJoueurGagnant
            );
            $tableauVue .= '<td>'.Joueur::select($data2)->pseudo.'</td>';
          }
          $resultat = Partie::getResultat($partie->idPartie,$_SESSION['idJoueur'],$idJoueurAdverse);
          $tableauVue .= '<td>'.$resultat['nbVictoireJ1'].'-'.$resultat['nbVictoireJ2'].'</td></tr>';
        }
        $tableauVue .= '</tbody></table></div>';
        
        $infosJoueur = array($s,$a,$e,$cl,$eme,$couleurpb,$progressbar,$listeParties,$tableauVue,$nbv,$nbd,$r);
    
        return $infosJoueur;
    }
}

?>
