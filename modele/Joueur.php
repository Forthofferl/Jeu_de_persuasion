<?php

/*
 * Classe Joueur
 */


class Joueur extends Modele {

  protected static $table = "pp_joueurs";
  protected static $primary_index = "idJoueur";

    public static function connexion($data) {
        $user = Joueur::selectWhere($data);
        if($user != null) {
          if($user[0]->active == "Oui") {
            $_SESSION['idJoueur'] = $user[0]->idJoueur;
            $_SESSION['pseudo'] = $user[0]->pseudo;
            if(isset($_POST['redirurl'])) $url = $_POST['redirurl'];
            else $url = ".";
            header("Location:$url");
          }
          else {
            $messageErreur="Votre compte n'est pas activé ! Vérifié vos e-mails et cliquez sur le lien d'activation !";
          }
        }
        else{
            $messageErreur="Le pseudo ou le mot de passe est erroné !";
        }
        
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
        $sql = "SELECT * FROM pp_parties WHERE idJoueur1=:idJ OR idJoueur2=:idJ ORDER BY idPartie DESC LIMIT 10";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':idJ',$idJ);
        $stmt->execute();
        return $stmt->fetchAll();
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
    
    public static function getClassementGeneral(){
        $tableau = Joueur::getClassement();

        $tableauVue = '<div class="table-responsive"><table class="table table-bordered table-hover"><thead>
        <tr><th> Classement </th><th> Pseudo </th><th> Ratio </th></tr></thead><tbody>';
        $compteur = 1;
        foreach ($tableau as $pseudo=>$ratio) {
          $tableauVue .= '<tr';
          if ($compteur == 1) $tableauVue .= ' style ="background-color: #FDD017;"';
          else if ($compteur == 2) $tableauVue .= ' style ="background-color: #C0C0C0;"';
          else if ($compteur == 3) $tableauVue .= ' style ="background-color: #B87333;"';
          $tableauVue .= '><td>'.$compteur.'</td><td>'.$pseudo.'</td><td>'.$ratio.'</td></tr>';
          $compteur += 1;
        }
        $tableauVue .= '</tbody></table></div>';
        $classement = array("tableau" => $tableau, "tableauVue" => $tableauVue);
        return $classement;
    }
    
    public static function save($data,$email){
        
        
        $data['pwd'] = hash('sha256',$data['pwd'].Config::getSeed());
        $data['active'] = md5(uniqid(rand(),true));
        $active = $data['active'];
        $idJoueur = Joueur::insertion($data);
        //on créer l'email et on l'envoi
        $to = $email;
        $subject = "Confirmation d'inscription à PersuasionGame";
        $body = nl2br("Merci de vous être inscrit sur notre site !\nPour activer votre compte, cliquez sur le lien suivant : ".URL.BASE."activate?key=$active \nL'équipe de PersuasionGame \n");
        $additionalheaders = "From: <".SITEEMAIL.">\n";
        $additionalheaders .= "Reply-To: $".SITEEMAIL."\n";
        $additionalheaders .='Content-Type: text/html; charset="UTF-8"'."\n";
        $additionalheaders .='Content-Transfer-Encoding: 8bit';
        mail($to, $subject, $body, $additionalheaders);
    }
    
    public static function selectWhereActive($value) {
      try {
        $table = static::$table;
        $primary = static::$primary_index;
        //echo $where;
        $sql = "SELECT * FROM pfcls_Joueurs WHERE pfcls_Joueurs.active=:value";
        $stmt = self::$pdo->prepare($sql);
        /*$stmt->bindParam(':table', $table);
        $stmt->bindParam(':key',$key);*/
        $stmt->bindParam(':value',$value);
        $stmt->execute();
        
        return $stmt->fetchAll();
      } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de la recherche dans la BDD " . static::$table);
      }
    }

    public static function getJoueurByID($id) {
        try {
            //echo $where;
            $sql = "SELECT * FROM pp_joueurs WHERE idJoueur = :id";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la BDD " . static::$table);
        }
    }

    public static function getIDJoueurByName($name){
        try {
            //echo $where;
            $sql = "SELECT idJoueur FROM pp_joueurs WHERE pseudo = :pseudo";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(':pseudo',$name);
            $stmt->execute();

            return $stmt->fetchAll()[0]['idJoueur'];
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la BDD " . static::$table);
        }
    }
}

?>
