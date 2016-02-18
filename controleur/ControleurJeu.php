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
}
