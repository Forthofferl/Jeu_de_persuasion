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
          return $messageErreur;
          }
        }
        else{
            $messageErreur="Le pseudo ou le mot de passe est erroné !";
            return $messageErreur;
        }
        
    }

    public static function deconnexion(){
        session_unset();
        session_destroy();
    }

    public static function updateNbVictoire($idJ) {
            try {
                $sql="UPDATE pp_joueurs SET nbV=nbV+1 WHERE idJoueur=:idJ";
                $req = self::$pdo->prepare($sql);
                $req->bindParam(':idJ',$idJ);
                $req->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                $messageErreur="Erreur lors de la mise à jour du nb de victoire d'un joueur dans la base de données";
            }
    }

    public static function updateNbDefaite($idJ) {
            try {
                $sql="UPDATE pp_joueurs SET nbD=nbD+1 WHERE idJoueur=:idJ";
                $req = self::$pdo->prepare($sql);
                $req->bindParam(':idJ',$idJ);
                $req->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                $messageErreur="Erreur lors de la mise à jour du nb de défaite d'un joueur dans la base de données";
            }
    }

    public static function getRatio($nomDeVictoire, $nombreDeDefaite){
      $ratio = 0;
      if($nomDeVictoire==0 && $nombreDeDefaite!=0) $ratio = 0;
      if($nomDeVictoire!=0 && $nombreDeDefaite==0) {
        $ratio = $nomDeVictoire;
      }
      if($nomDeVictoire!=0 && $nombreDeDefaite!=0) {
        $ratio = $nomDeVictoire/$nombreDeDefaite;
      }
      return $ratio;
    }

    public static function getHistorique($idJ) {
      try {
        $sql = "SELECT *
                FROM pp_parties
                WHERE idJoueurGagnant =:idJ
                OR idJoueurPerdant =:idJ
                ORDER BY idPartie DESC
                LIMIT 10";
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

    
    public static function getProfil($data){
        $joueur = Joueur::select($data);
        $age = $joueur->age;
        $sexe = $joueur->sexe;
        $email = $joueur->email;
        $nombreDeVictoire = $joueur->nbV;
        $nombreDeDefaite = $joueur->nbD;
        $r = Joueur::getRatio($nombreDeVictoire,$nombreDeDefaite);

        $listeJoueurs = Joueur::selectAll();
        $classement = 1;
        $compteur = 0;
        foreach ($listeJoueurs as $joueur) {
          $compteur += 1;
          if ($joueur->idJoueur != $_SESSION['idJoueur']) {
            $ratio = Joueur::getRatio($joueur->nbV,$joueur->nbD);
            if ($ratio >= $r) $classement += 1;
          }
        }



        if ($sexe == "H") $sexe = "";
        else $sexe = "fe";

        if ($classement == 1) $eme = "er";
        else $eme = "ème";

        $r = substr($r, 0, 4); // on coupe la chaine de caractère $r 2 chiffres après la virgule


        //historique

        $listeParties = Joueur::getHistorique($_SESSION['idJoueur']);
        $tableauVue = '<div class="table-responsive"><table class="table table-bordered table-hover"><thead>
        <tr><th> Adversaire </th><th> Gagnant </th><th> Score </th></tr></thead><tbody>';
        foreach ($listeParties as $partie) {
          if ($partie['idJoueurGagnant'] == $_SESSION['idJoueur']) $idJoueurAdverse = $partie['idJoueurPerdant'];
          else $idJoueurAdverse = $partie['idJoueurGagnant'];
          $tableauVue .= '<tr><td>'.Joueur::getJoueurByID($idJoueurAdverse)[0]['pseudo'].'</td>';
          if($partie['idJoueurGagnant'] == null) {
            $tableauVue .= '<td>Aucun (NULL)</td>';
          }
          else {
            $tableauVue .= '<td>'.Joueur::getJoueurByID($partie['idJoueurGagnant'])[0]['pseudo'].'</td>';
          }
          $resultat = Partie::getResultat($partie['idPartie'],$_SESSION['idJoueur'],$idJoueurAdverse);
          $tableauVue .= '<td>'.$resultat['scoreJ1'].'/'.$resultat['scoreJ2'].'</td></tr>';
        }
        $tableauVue .= '</tbody></table></div>';
        
        $infosJoueur = array('sexe'=>$sexe,'age'=>$age,'mail'=>$email,'classement'=>$classement,'eme'=>$eme,'listeParties'=>$listeParties,'tableauVue'=>$tableauVue,'nombreDeVictoire'=>$nombreDeVictoire,'nombreDeDefaite'=>$nombreDeDefaite,'ratio'=>$r);
    
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
        $sql = "SELECT * FROM pfcls_Joueurs WHERE pfcls_Joueurs.active=:value";
        $stmt = self::$pdo->prepare($sql);
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

    public static function suppressionJoueur($idJoueur)
    {
        $sql="DELETE FROM pp_joueurs WHERE idJoueur = :idJoueur";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':idJoueur',$idJoueur);
        $stmt->execute();
    }
}

?>
