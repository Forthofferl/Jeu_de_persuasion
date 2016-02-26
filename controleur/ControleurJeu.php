<?php

class ControleurJeu{

    public function selectSujet($data){
        if(estConnecte()) {
            $listSujets = Jeu::getNomSujet($data);
            require VIEW_PATH . "jeu" . DIRECTORY_SEPARATOR . "listeSujet.php";
        }
        else{
            ControleurIndex::defaut();
        }
    }

    public function selectPartieEnAttente($data)
    {
        $parties = null;
        if (estConnecte()) {
            $test = false;
            if($data[0]!="Choix du sujet") {
                $idSujet = Jeu::getIdSujetByNom($data[0])[0];
                $coterSujet = $data[1];
                if ($coterSujet == "POUR") {
                    $coterSujet = "CONTRE";
                } else {
                    $coterSujet = "POUR";
                }
                $partieEnAttente = Jeu::getPartieEnAttente($idSujet[0], $coterSujet);
                if(!empty($partieEnAttente)) {
                    $test=true;
                    foreach ($partieEnAttente as $partie) {
                        $partiePeutDebuter = $partie['enAttenteDeJoueur']=="NON"&&intval($partie['placeSpectateurRestant'])==0;
                        if ($partie[0] == $_SESSION['idJoueur']||$partiePeutDebuter) {
                            ;
                        } else {
                            $joueur = Joueur::getJoueurByID($partie['idJoueur'])[0];
                            $parties[] = array("nomJoueur" => $joueur['pseudo'], "attenteJoueur" => $partie['enAttenteDeJoueur'], "nbreSpectateurRestant" => intval($partie['placeSpectateurRestant']));
                        }
                    }
                }
                else{
                    $test = true;
                }
            }

                require VIEW_PATH . "jeu" . DIRECTORY_SEPARATOR . "listePartieEnAttente.php";
        }
        else{
            ControleurIndex::defaut();
        }
    }

    public function creerParties($nomSujet, $coterSujet){
        if (estConnecte()) {
            $_SESSION['type'] = "joueur";
            $_SESSION['joueur1'] = true;
            $idSujet = Jeu::getIdSujetByNom($nomSujet);
            Jeu::creerParties($idSujet[0], $coterSujet);
            $sujet= $nomSujet;
            $nom = $_SESSION['pseudo'];
            $vue = 'partie';
            $pagetitle = 'Le jeu';
            $page = "jeu";
            require VIEW_PATH . "vue.php";
        }
        else{
            ControleurIndex::defaut();
        }
    }

    public function chat(){
        if(estConnecte()) {
            $argsJoueur = Jeu::getArgJoueurs();
            var_dump($argsJoueur);
            if ($argsJoueur['statut'] == "EN COURS") {
                $argsJ1 = $argsJoueur['J1'];
                $_SESSION['nomJoueur1'] = $argsJ1[0]['joueur1'];
                $argsJ2 = $argsJoueur['J2'];
                $_SESSION['nomJoueur2'] = $argsJ2[0]['joueur2'];
                if($_SESSION['nomJoueur2']==$_SESSION['pseudo']) {
                    require VIEW_PATH . "jeu" . DIRECTORY_SEPARATOR . "chatJ2.php";
                }
                else if($_SESSION['nomJoueur1']==$_SESSION['pseudo']){
                    require VIEW_PATH . "jeu" . DIRECTORY_SEPARATOR . "chatJ1.php";
                }
                else if($_SESSION['type']=='spectateur'){
                    require VIEW_PATH . "jeu" . DIRECTORY_SEPARATOR . "chatSpectateur.php";
                }
            }
            elseif($argsJoueur['statut']=="FIN"){
                $gagnant = $argsJoueur['resultat'];
                $_SESSION['nomJoueur1'] = $argsJoueur['nomJoueur1'];
                $_SESSION['nomJoueur2'] = $argsJoueur['nomJoueur2'];
                require VIEW_PATH . "jeu" . DIRECTORY_SEPARATOR . "test.php";
            }

        }
        else{
            ControleurIndex::defaut();
        }
    }

    public function addMessage($message){
        if(estConnecte()){
            Jeu::addMessage($message);
            $this->chat();
        }
    }

    public function joinGame($nomJoueur,$nomSujet){

        if(estConnecte()){
            $_SESSION['joueur1'] = false;
            $_SESSION['type'] = "joueur";
            $_SESSION['idJoueurAdverse'] = Joueur::getIDJoueurByName($nomJoueur);
            Jeu::ajoutJoueur2($_SESSION['idJoueurAdverse']);
            $sujet= $nomSujet;
            $nom = $_SESSION['pseudo'];
            $vue = 'partie';
            $pagetitle = 'Le jeu';
            $page = "jeu";
            require VIEW_PATH . "vue.php";
        }
        else{
            ControleurIndex::defaut();
        }
    }

    public function lookGame($nomJoueur,$nomSujet){
        if(estConnecte()){
            $_SESSION['type'] = "spectateur";
            $_SESSION['joueur1'] = false;
            $_SESSION['idJoueurAdverse'] = Joueur::getIDJoueurByName($nomJoueur);
            Jeu::newSpectateur($_SESSION['idJoueurAdverse']);
            $sujet= $nomSujet;
            $nom = $_SESSION['pseudo'];
            $vue = 'partie';
            $pagetitle = 'Le jeu';
            $page = "jeu";
            require VIEW_PATH . "vue.php";
        }
        else{
            ControleurIndex::defaut();
        }
    }

    public function quit(){
        if(estConnecte()){
            if($_SESSION['type']=="joueur"){
                Jeu::deleteJoueurInPartie();
            }else  if($_SESSION['type']="spectateur"){
                Jeu::deleteSpectateurInPartie();
            }
            $vue = 'deleted';
            $pagetitle = 'Le jeu';
            $page = "jeu";
            require VIEW_PATH . "vue.php";
            $_SESSION['nomJoueurAdverse'] = null;
        }
        else{
            ControleurIndex::defaut();
        }
    }

    public function vote($idArg,$typeVote){
        if(estConnecte()){
            $idArg = $idArg;
            Jeu::updateVote($idArg,$typeVote);
            require VIEW_PATH . "jeu" . DIRECTORY_SEPARATOR . "test.php";

        }
        else{
            ControleurIndex::defaut();
        }
    }
}
