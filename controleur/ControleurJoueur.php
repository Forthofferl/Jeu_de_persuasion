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
        $page= "index";
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
            $messageErreur = Joueur::connexion($data);
        }
        else{
            header('Location: .');
        }
        if(empty($messageErreur)) {
            $vue = 'default';
            $pagetitle = 'Le jeu';
            $page = "index";
        }
        require VIEW_PATH . "vue.php";
    }
    
    public function inscription(){
        if(!estConnecte()){
            $vue="creation";
            $pagetitle="Formulaire d'inscription";
            $page= "joueur";
        }
        else{
          header('Location: .');
        }
        require VIEW_PATH . "vue.php";
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
        }
        else{
          header('Location: .');
        }
        require VIEW_PATH . "vue.php";
    }
    
    public function save(){
        if (!(isset($_POST['pseudo']) && isset($_POST['sexe']) && isset($_POST['age']) && isset($_POST['pwd']) && isset($_POST['pwd2']) && isset($_POST['email']))) {
            $vue="creation";
            $pagetitle="Formulaire d'inscription";
            $page= "joueur";
            require VIEW_PATH . "vue.php";
        }
        // il faut check les données en plus du html
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
          $messageErreur="Vous n'avez pas entré un e-mail valide !";
        }
        if($_POST['age'] < 1 || $_POST['age'] > 100){
          $messageErreur="Vous n'avez pas saisi un âge valide !";
        }
        
        if(!estConnecte()){
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
                require VIEW_PATH . "vue.php";
            }
            else if($_POST['pwd']==$_POST["pwd2"]){
                Joueur::save($data, $_POST['email']);
                $vue="created";
                $pagetitle="Inscription terminée !";
                $page= "joueur";
            }
            else {
              $messageErreur="Vous avez saisi deux mots de passe différents !";
            }
          }
          else{
            header('Location: .');
          }
          require VIEW_PATH . "vue.php";
    }
    
    public function activation($key){
        if(!estConnecte()){
          $active = trim($key);
          //echo $active;
          if(!empty($active)){
            /*$data = array(
              "active" => $active
            );*/
            //var_dump($data);
            $user = Joueur::selectWhereActive($active);
            //var_dump($user);
            if($user != null) {
              $data2 = array(
                "idJoueur" => $user[0]['idJoueur'],
                "active" => "Oui"
              );
              Joueur::update($data2);
              $vue="activated";
              $pagetitle="Validation complétée avec succès !";
              $page= "joueur";
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
          require VIEW_PATH . "vue.php";
    }
    
    public function recovery(){
        if(!estConnecte()){
            $vue="recovery";
            $pagetitle="Récupération de mot de passe";
            $page= "joueur";
          }
          else{
            header('Location:.');
          }
          require VIEW_PATH . "vue.php";
    }

    public function delete(){
        if(estConnecte()){
            $vue="delete";
            $pagetitle="Confirmation suppression de votre compte";
            $page="joueur";
        }
        else{
            header('Location: .');
        }
        require VIEW_PATH . "vue.php";
    }

    public function deleted(){
        if(estConnecte()){
            Joueur::suppressionJoueur($_SESSION['idJoueur']);
            $dataWaiting = array(
                "idJoueur" => $_SESSION['idJoueur']
            );

            $dataDel = array(
                "idJoueur" => $_SESSION['idJoueur']
            );
            Joueur::deconnexion();
            $vue="deleted";
            $page="joueur";
            $pagetitle="Profil supprimé !";
        }
        else{
            header('Location: .');
        }
        require VIEW_PATH . "vue.php";
    }

    public function update(){
        if(estConnecte()){
            $joueur = Joueur::getJoueurByID($_SESSION['idJoueur'])[0];
            $pseudo = $joueur['pseudo'];
            $age = $joueur['age'];
            $sexe = $joueur['sexe'];
            $email = $joueur['email'];
            if ($sexe == "H") $sexe = "";
            else $sexe = "fe";
            $page="joueur";
            $vue="update";
            $pagetitle="Mise à jour de votre profil";
        }
        else{
            header('Location: .');
        }
        require VIEW_PATH . "vue.php";
    }

    public function updated(){
        if(estConnecte()){
            if (empty($_POST)) {
                if(strpos(BASE, "update")!=false){$url = "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){$url= "http://".URL.BASE."update";} else{$url= "http://".URL.BASE."index.php/update";}
                header("Location: ".$url);
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
                }
                else {
                    $r = Joueur::update($data);
                    $_SESSION['pseudo'] = $_POST["pseudo"];
                    $vue="updated";
                    $page="joueur";
                    $pagetitle='Profil mis à jour !';
                }
            }
        }
        else{
            header('Location: .');
        }
        require VIEW_PATH . "vue.php";
    }
}
