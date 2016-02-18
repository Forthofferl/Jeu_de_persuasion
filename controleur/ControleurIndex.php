<?php
class ControleurIndex{

    public static function defaut(){
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
        $listtheme = Jeu::getNomTheme();
        require VIEW_PATH . "vue.php";
    }
    
    public function aPropos(){
        $vue="apropos";
        $pagetitle="À propos";
        $page= "index";
        require VIEW_PATH . "vue.php";
    }
    
    public function classement(){

        $classement = Joueur::getClassementGeneral();
        $tableau = $classement["tableau"];
        $tableauVue = $classement["tableauVue"];
        $vue="classement";
        $pagetitle="Classement";
        $page= "index";
        require VIEW_PATH . "vue.php";
    }
    
    public function jouer(){
        if(estConnecte()) {
            $listtheme = Jeu::getNomTheme();
            $vue = 'attente';
            $pagetitle = 'Le jeu';
            $page = "jeu";
            require VIEW_PATH . "vue.php";
        }
        else{
            $this->defaut();
        }
    }

    public function sujetStat($data){
        $listSujets = Jeu::getNomSujet($data);
        require VIEW_PATH . "index".DIRECTORY_SEPARATOR."vueStatsIndex.php";
    }

    public function glitch(){
        $messageErreur = "Vous avez trouvé un glitch dans le système!";
        require VIEW_PATH . "vue.php";
    }
}