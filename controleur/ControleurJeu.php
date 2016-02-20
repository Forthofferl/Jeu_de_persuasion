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
        if (estConnecte()) {
            $idSujet = Jeu::getIdSujetByNom($data[0])[0];
            $coterSujet = $data[1];
            if ($coterSujet == "POUR") {
                $coterSujet = "CONTRE";
            } else {
                $coterSujet = "POUR";
            }
            $partieEnAttente = Jeu::getPartieEnAttente($idSujet[0], $coterSujet);
            foreach ($partieEnAttente as $partie) {
                if ($partie[0] == $_SESSION['idJoueur']) {
                    ;
                } else {
                    $joueur = Joueur::getJoueurByID($partie[0])[0];
                    $nomJoueur[] = $joueur[1];
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
        if(estConnecte()){
            $argsJoueur = Jeu::getArgJoueurs();
            $argsJ1 = $argsJoueur[0];
            $argsJ2 = $argsJoueur[1];
            if($argsJ2[0]['joueur2']==$_SESSION['pseudo']) {
                require VIEW_PATH . "jeu" . DIRECTORY_SEPARATOR . "chatJ2.php";
            }
            else if($argsJ1[0]['joueur1']==$_SESSION['pseudo']){
                require VIEW_PATH . "jeu" . DIRECTORY_SEPARATOR . "chatJ1.php";
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
            $idJoueurAdverse = Joueur::getIDJoueurByName($nomJoueur);
            Jeu::ajoutJoueur2($idJoueurAdverse);
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
}
