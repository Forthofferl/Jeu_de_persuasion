<?php

class ControleurJoueur{
    
    public function deconnexion(){
        if(estConnecte()){
            Joueur::deconnexion();
            header('Location: .');
        }
        else{
            header('Location: .');
        }
        $vue='default';
        $pagetitle='Le jeu';
        $page= "joueur";
        require VIEW_PATH . "vue.php";
    }
    
    public function connect(){
        if(!estConnecte()){
            if (!(isset($_POST['pseudo']) || isset($_POST['pwd']))){
                header('Location: .');
            }
            $data = array(
            "pseudo" => $_POST['pseudo'],
            "pwd" => hash('sha256',$_POST['pwd'].Config::getSeed()),
            );
            $user = Joueur::selectWhere($data);
            if($user != null) {
              if($user[0]->active == "Oui") {
                $data2 = array(
                  "idJoueur" => $user[0]->idJoueur,
                  "pseudo" => $user[0]->pseudo
                );
                Joueur::connexion($data2);
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
        else{
            header('Location: .');
        }
        $vue='default';
        $pagetitle='Le jeu';
        $page= "joueur";
        require VIEW_PATH . "vue.php";
    }
    
    public function inscription(){
        if(!estConnecte()){
            $vue="creation";
            $pagetitle="Formulaire d'inscription";
            $page= "joueur";
            require VIEW_PATH . "vue.php";
        }
        else{
          header('Location: .');
        }
    }
    
    public function profil(){
        if(estConnecte()){
            $data= array(
            "idJoueur"=>$_SESSION['idJoueur']
        );
        $infosJoueur=  Joueur::getProfil($data);
        $vue="profil";
        $pagetitle="Votre profil";
        $page= "joueur";
        require VIEW_PATH . "vue.php";
    }
    else{
      header('Location: .');
    }
    }
   /*
    if (empty($_GET)) {
      $vue="defaut";
      $pagetitle="Joueur : vos actions disponibles";
    }
    else if (isset($action)) {
        switch ($action) {

        break;
        /*
         * action=save
         * Insertion d'un joueur dans la BDD (après une inscription)
         */
        /*case "save":
            if(!estConnecte()){
              if (!(isset($_POST['pseudo']) && isset($_POST['sexe']) && isset($_POST['age']) && isset($_POST['pwd']) && isset($_POST['pwd2']) && isset($_POST['email']))) {
                  header('Location: joueur.php?action=inscription');
              }
              // il faut check les données en plus du html
              if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $messageErreur="Vous n'avez pas entré un e-mail valide !";
                break;
              }
              if($_POST['age'] < 1 || $_POST['age'] > 100){
                $messageErreur="Vous n'avez pas saisi un âge valide !";
                break;
              }
              $data = array(
                "pseudo" => $_POST["pseudo"],
                "sexe" => $_POST["sexe"],
                "age" => $_POST["age"],
                "pwd" => $_POST["pwd"],
                "email" => $_POST["email"]
              );
              $dataCheck = array(
                "pseudo" => $_POST["pseudo"],
                "email" => $_POST["email"]
              );
              $existe = Joueur::selectWhereOr($dataCheck);
              if ($existe != null) {
                $messageErreur="Ce pseudo ou cet e-mail est déjà utilisé !";
                break;
              }
			        else if($_POST['pwd']==$_POST["pwd2"]){
                  $data['pwd'] = hash('sha256',$data['pwd'].Config::getSeed());
                  $data['active'] = md5(uniqid(rand(),true));
                  $active = $data['active'];
                  $idJoueur = Joueur::insertion($data);
                  //on créer l'email et on l'envoi
                  $to = $_POST['email'];
                  $subject = "Confirmation d'inscription à PFCLS";
                  $body = nl2br("Merci de vous être inscrit sur notre site !\nPour activer votre compte, cliquez sur le lien suivant : ".URL.BASE."joueur.php?action=activation&key=$active \nL'équipe de PFCLS \n");
                  $additionalheaders = "From: <".SITEEMAIL.">\n";
                  $additionalheaders .= "Reply-To: $".SITEEMAIL."\n";
                  $additionalheaders .='Content-Type: text/html; charset="UTF-8"'."\n";
                  $additionalheaders .='Content-Transfer-Encoding: 8bit';
                  mail($to, $subject, $body, $additionalheaders);

                  $vue="created";
                  $pagetitle="Inscription terminée !";
              }
              else {
                $messageErreur="Vous avez saisi deux mots de passe différents !";
                break;
              }
            }
            else{
              header('Location: .');
            }
        break;

        case "activation":
        if(!estConnecte()){
          $active = trim($_GET['key']);
          if(!empty($active)){
            $data = array(
              "active" => $active
            );
            $user = Joueur::selectWhere($data);
            if($user != null) {
              $data2 = array(
                "idJoueur" => $user[0]->idJoueur,
                "active" => "Oui"
              );
              Joueur::update($data2);
              $vue="activated";
              $pagetitle="Validation complétée avec succès !";
            }
            else {
              $messageErreur="Votre compte est déjà activé ou ce lien est invalide !";
            }
          }
          else {
            header('Location:.');
          }
        }
        else{
          header('Location:.');
        }
        break;


        case "recoverypwd":
          if(!estConnecte()){
            $vue="recovery";
            $pagetitle="Récupération de mot de passe";
            break;
          }
          else{
            header('Location:.');
          }
        break;

        case "recoveredpwd":
          if(!estConnecte()){
            if (!(isset($_POST['email']))){
              header('Location:.');
            }
            else {
              if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $messageErreur="Vous n'avez pas entré un e-mail valide !";
              }
              else {
                $data = array(
                  "email" => $_POST['email']
                );
                $user = Joueur::selectWhere($data);
                if($user == null) {
                  $messageErreur="L'email fournit n'existe pas dans la base données !";
                }
                else {
                  $token = md5(uniqid(rand(),true));
                  $data2 = array(
                    "idJoueur" => $user[0]->idJoueur,
                    "resetToken" => $token,
                    "resetCompleted" => "Non"
                  );
                  Joueur::update($data2);
                  //on créer l'email et on l'envoi
                  $to = $_POST['email'];
                  $subject = "Remise à zéro du mot de passe";
                  $body = nl2br("Quelqu'un a demandé la remise à zéro de votre mot de passe.\nSi c'est une erreur, ignorez simplement cet e-mail et rien n'arrivera.\nPour reset votre mot de passe, cliquez sur le lien suivant : ".URL.BASE."joueur.php?action=reset&key=$token \nL'équipe de PFCLS\n");
                  $additionalheaders = "From: <".SITEEMAIL.">\r\n";
                  $additionalheaders .= "Reply-To: $".SITEEMAIL."\r\n";
                  $additionalheaders .='Content-Type: text/html; charset="UTF-8"'."\n";
                  $additionalheaders .='Content-Transfer-Encoding: 8bit';
                  mail($to, $subject, $body, $additionalheaders);

                  $vue="recovered";
                  $pagetitle="Remise à zéro du mot de passe !";
                }
              }
            }
            break;
          }
          else{
            header('Location:.');
          }
        break;

        case "reset":
          if(!estConnecte()){
            $key = trim($_GET['key']);
            if(!empty($key)){
              $data = array(
                "resetToken" => $key
              );
              $user = Joueur::selectWhere($data);
              if($user != null) {
                if($user[0]->resetCompleted == "Oui") {
                  $messageErreur="Votre mot de passe a déjà été modifié !";
                }
                else {
                  $vue="reset";
                  $pagetitle="Choisir le nouveau mot de passe";
                }
              }
              else {
                $messageErreur="Votre compte est déjà activé ou ce lien est invalide !";
              }
            }
            else {
              header('Location:.');
            }
          }
          else{
            header('Location:.');
          }
        break;

        case "reseted":
          if(!estConnecte()){
            $key = trim($_POST['key']);
            if(!empty($key)){
              if (!(isset($_POST['pwd']) && isset($_POST['pwd2']))){
                header('Location:.');
                break;
              }
              else if($_POST['pwd']!=$_POST["pwd2"]){
                $messageErreur="Vos mots de passe ne correpondent pas !";
                break;
              }
              else {
                $pwdcrypt = hash('sha256',$_POST["pwd"].Config::getSeed());
              }
              $data = array(
                "resetToken" => $key
              );
              $user = Joueur::selectWhere($data);
              if($user != null) {
                if($user[0]->resetCompleted == "Oui") {
                  $messageErreur="Votre mot de passe a déjà été changé !";
                }
                else {
                  $data2 = array(
                    "idJoueur" => $user[0]->idJoueur,
                    "resetCompleted" => "Oui",
                    "pwd" => $pwdcrypt
                  );
                  Joueur::update($data2);
                  $vue="reseted";
                  $pagetitle="Mot de passe reseted !";
                }
              }
              else {
                $messageErreur="Votre compte est déjà activé ou ce lien est invalide !";
              }
            }
            else {
              header('Location:.');
            }
          }
          else{
            header('Location:.');
          }
        break;

        case "delete":
            if(estConnecte()){
                $vue="delete";
                $pagetitle="Confirmation suppression de votre compte";
            }
            else{
              header('Location: .');
            }
        break;

        case "deleted":
            if(estConnecte()){
              $data = array(
                "idJoueur" => $_SESSION['idJoueur'],
              );
              Joueur::suppression($data);
              $dataWaiting = array(
                "idJoueur" => $_SESSION['idJoueur']
              );
              $attente = Jeu::selectWhere($dataWaiting);
              if($attente != null) { // on est en recherche d'un adversaire ?
                $dataDel = array(
                  "idJoueur" => $_SESSION['idJoueur']
                );
                Jeu::suppressionWhere($dataDel);
              }
              Joueur::deconnexion();
              $vue="deleted";
              $pagetitle="Profil supprimé !";
              }
            else{
              header('Location: .');
            }
        break;

        case "profil":
            
        break;

        case "update":
            if(estConnecte()){
                $data= array(
                  "idJoueur"=>$_SESSION['idJoueur']
                );
                $joueur = Joueur::select($data);
                $p = $joueur->pseudo;
                $a = $joueur->age;
                $s = $joueur->sexe;
                $e = $joueur->email;
                if ($s == "H") $s = "";
                else $s = "fe";
                $vue="update";
                $pagetitle="Mise à jour de votre profil";
                break;
            }
            else{
              header('Location: .');
            }
        break;

        case "updated":
            if(estConnecte()){
              if (empty($_POST)) {
                  header('Location: joueur.php?action=update');
                  break;
              }
              else {
                $data = array(
                  "idJoueur" => $_SESSION["idJoueur"],
                  "pseudo" => $_POST["pseudo"],
                  "age" => $_POST["age"],
                  "email" => $_POST["email"]
                );
                if(!empty($_POST["pwd"])){
                  $data['pwd']=hash('sha256',$_POST["pwd"].Config::getSeed());
                }
                $dataCheck = array(
                  "pseudo" => $_POST["pseudo"],
                  "email" => $_POST["email"]
                );
                $existe = Joueur::selectWhereOr($dataCheck);
                if ($existe != null && $existe[0]->idJoueur!=$_SESSION['idJoueur']) {
                  $messageErreur="Ce pseudo ou cet e-mail est déjà utilisé !";
                  break;
                }
    			      else {
                    $r = Joueur::update($data);
                    $_SESSION['pseudo'] = $_POST["pseudo"];
                    $vue="updated";
                    $pagetitle='Profil mis à jour !';
                }
              }
            }
            else{
              header('Location: .');
            }
        break;

        default :
            $messageErreur="Il semblerait que vous ayez trouvé un glitch dans le système !";

        }
      }
      else {
        $messageErreur="Il semblerait que vous ayez trouvé un glitch dans le système !";
      }*/
}
