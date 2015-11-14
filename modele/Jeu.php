<?php

require_once 'Modele.php';
require_once 'Partie.php';
require_once MODEL_PATH.'Joueur.php'; // connerie de wamp qui ne fait pas la diff entre une min et un maj

class Jeu extends Modele{

  protected static $table = "pfcls_Parties_en_attente";
  protected static $primary_index = "idPartie_en_attente";

    public static function recherchePartie($nbManche) {
        if(estConnecte()){
            try {
                $idJoueurR=$_SESSION['idJoueur'];
                $req = self::$pdo->prepare('SELECT idJoueur FROM pfcls_Parties_en_attente WHERE nbManche= '.$nbManche.' AND idJoueur != '.$idJoueurR);
                $req->execute();
                if ($req->rowCount() != 0) {
                    $data_recup = $req->fetch(PDO::FETCH_OBJ);
                    $idAdversaire=$data_recup->idJoueur;
                    return $idAdversaire;
                }
                else{
                    return NULL;
                }
            }catch (PDOException $e) {
                echo $e->getMessage();
                $messageErreur="Échec lors de la recherche d'une partie en attente";
            }
        }
        else{
            $messageErreur="Vous n'êtes pas connecté!";
        }
    }

    public static function listeAttente(){
        try {
            $req = self::$pdo->prepare('SELECT j.pseudo, pa.nbManche FROM pfcls_Joueurs j JOIN pfcls_Parties_en_attente pa ON pa.idJoueur=j.idJoueur');
            $req->execute();
            return $req->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            $messageErreur="Erreur lors de la sélection de joueurs en attente dans la base de données";
        }
    }
}

?>
