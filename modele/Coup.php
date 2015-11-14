<?php

/*
 * Classe Coup
 */

require_once 'Figure.php';
require_once 'Modele.php';

class Coup extends Modele {

  protected static $table = "pfcls_Coups";
  protected static $primary_index = "idCoup";

    public static function getDernierCoup($data) {
        try {
                $req = self::$pdo->prepare("SELECT MAX(idCoup) AS id FROM pfcls_Coups WHERE idJoueur1 = :idJoueur1 AND idJoueur2 = :idJoueur2");
                $req->execute($data);
                if ($req->rowCount() != 0) {
                    $data_recup = $req->fetch(PDO::FETCH_OBJ);
                    return $data_recup->id;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                die("Erreur lors de la récupération du coup dans la BDD");
            }
    }

    public static function getDernierCoupNul($data) {
        try {
                $req = self::$pdo->prepare("SELECT MAX(idCoup) AS id FROM pfcls_Coups WHERE idJoueur1 = :idJoueur1 AND idJoueur2 = :idJoueur2 AND idFigure1 IS NULL AND idFigure2 IS NULL AND idJoueurGagnant IS NULL");
                $req->execute($data);
                if ($req->rowCount() != 0) {
                    $data_recup = $req->fetch(PDO::FETCH_OBJ);
                    return $data_recup->id;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                die("Erreur lors de la récupération du coup dans la BDD");
            }
    }

    public static function whoUpdateCoup($data) {
        try {
                $req = self::$pdo->prepare("SELECT MAX(idCoup) AS id FROM pfcls_Coups WHERE idJoueur2= :idJoueur2 AND idFigure2 IS NULL");
                $req->execute($data);
                if ($req->rowCount() != 0) {
                    $data_recup = $req->fetch(PDO::FETCH_OBJ);
                    return $data_recup->id;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                $messageErreur="Erreur lors de who MAJ d'un coup dans la BDD";
            }
    }

    public static function checkCoupPretAEvaluer($idC) {
        try {
                $req = self::$pdo->prepare("SELECT * FROM pfcls_Coups WHERE idCoup = ".$idC." AND (idFigure1 IS NULL OR idFigure2 IS NULL)");
                $req->execute();
                return ($req->rowCount() == 0);
            } catch (PDOException $e) {
                echo $e->getMessage();
                $messageErreur="Erreur lors de check evaluation d'un coup dans la BDD";
            }
    }

    public static function checkCoupEstEvaluer($idC) {
        try {
                $req = self::$pdo->prepare("SELECT * FROM pfcls_Coups WHERE idCoup = ".$idC." AND idJoueurGagnant IS NOT NULL");
                $req->execute();
                return ($req->rowCount() == 0);
            } catch (PDOException $e) {
                echo $e->getMessage();
                $messageErreur="Erreur lors de check evaluation 2 d'un coup dans la BDD";
            }
    }

    public static function evaluer($id) {
            $data = array(
              "idCoup" => $id
            );
            $coup = self::select($data);
            $idF1 = $coup->idFigure1;
            $idF2 = $coup->idFigure2;
            $idJ1 = $coup->idJoueur1;
            $idJ2 = $coup->idJoueur2;
            $J1Win = Figure::estDansSesForces($idF2,$idF1);
            $J1Win = ($J1Win && Figure::estDansSesFaiblesses($idF1,$idF2));
            if ($J1Win) {
              $data = array(
                "idCoup" => $id,
                "idJoueurGagnant" => $idJ1
              );
                self::update($data);
            }
            else {
              $data = array(
                "idCoup" => $id,
                "idJoueurGagnant" => $idJ2
              );
              self::update($data);
            }
    }

    public static function estUnDraw($id) {
      $data = array(
        "idCoup" => $id
      );
      $coup = self::select($data);
      $idF1 = $coup->idFigure1;
      $idF2 = $coup->idFigure2;
        return ($idF1 == $idF2);
    }

    public static function retourneIDs($id){
      $data = array(
        "idCoup" => $id
      );
      $coup = self::select($data);
      $idF1 = $coup->idFigure1;
      $idF2 = $coup->idFigure2;
	     return $idF1.$idF2;
    }
}

?>
