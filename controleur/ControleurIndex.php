<?php
class ControleurIndex{
    
    public function defaut(){
        $vue='default';
        $pagetitle='Le jeu';
        $page= "index";
        require VIEW_PATH . "vue.php";
    }
    
    public function regles(){
        $vue="regles";
        $pagetitle="Règles du jeu";
        $page= "index";
        require VIEW_PATH . "vue.php";
    }
    
    public function statistiques(){
        $vue="statistiques";
        $pagetitle="Statistiques";
        $page= "index";
        require VIEW_PATH . "vue.php";
    }
    
    public function aPropos(){
        $vue="apropos";
        $pagetitle="À propos";
        $page= "index";
        require VIEW_PATH . "vue.php";
    }
    
    public function classement(){
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
        $vue="classement";
        $pagetitle="Classement";
        $page= "index";
        require VIEW_PATH . "vue.php";
    }
    
    public function jouer(){
        $vue='default';
        $pagetitle='Le jeu';
        $page= "index";
        $messageErreur="Il semblerait que vous ayez trouvé un glitch dans le système !";
        require VIEW_PATH . "vue.php";
        //TO DO : modifier pour appeler le chat ou le choix de difficulté
    }
   /*   switch ($action) {


        case "stats":
          $sexe = $_POST['sexe'];
          $marge = $_POST['marge'];
          $age = $_POST['age'];
          $agemini = $age-$marge;
          $agemaxi = $age+$marge;

          if ($sexe == "H") $s = "";
          else $s = "fe";

          if ($marge == 0) $trancheage = $age." ans";
          else $trancheage = $agemini." ans - ".$agemaxi." ans";

          $donneesDeJeu = StatsPerso::selectSequence($sexe,$agemini,$agemaxi);

          $listeCoupsJoueur=array();
          foreach ($donneesDeJeu as $key => $value) {
            array_push($listeCoupsJoueur, $value);
          }
          $premierCoup = Joueur::premierCoupStats($listeCoupsJoueur);
          $compte = 0;
          foreach($premierCoup as $numFi => $nb) $compte += $nb;

          $apresPierre = Joueur::apresFigure($listeCoupsJoueur,'1');
          $comptePierre = 0;
          foreach($apresPierre as $numFi => $nb) $comptePierre += $nb;

          $apresFeuille = Joueur::apresFigure($listeCoupsJoueur,'2');
          $compteFeuille = 0;
          foreach($apresFeuille as $numFi => $nb) $compteFeuille += $nb;

          $apresCiseaux = Joueur::apresFigure($listeCoupsJoueur,'3');
          $compteCiseaux = 0;
          foreach($apresCiseaux as $numFi => $nb) $compteCiseaux += $nb;

          $apresLezard = Joueur::apresFigure($listeCoupsJoueur,'4');
          $compteLezard = 0;
          foreach($apresLezard as $numFi => $nb) $compteLezard += $nb;

          $apresSpock = Joueur::apresFigure($listeCoupsJoueur,'5');
          $compteSpock = 0;
          foreach($apresSpock as $numFi => $nb) $compteSpock += $nb;

          if ($donneesDeJeu==null||$comptePierre==0||$compteFeuille==0||$compteCiseaux==0||$compteLezard==0||$compteSpock==0) {
            $messageErreur="Il n'y a pas assez de données disponibles pour ces paramètres pour établir des statistiques !<br/>
            <h3>Essayez de modifier vos paramètres !</h3>
            <h4><a href='index.php?action=statistiques'><i class='fa fa-reply'></i> Retour à la sélection des paramètres</a></<h4>";
            break;
          }

          $vue="stats";
          $pagetitle="Statistiques";
        break;

       

        

        default :
        $messageErreur="Il semblerait que vous ayez trouvé un glitch dans le système !";
      }
    }
      $messageErreur="Il semblerait que vous ayez trouvé un glitch dans le système !";
    require VIEW_PATH . "vue.php";*/
}