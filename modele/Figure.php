<?php

/*
 * Classe Figure
 */

require_once 'Modele.php';

class Figure extends Modele {

  protected static $table = "pfcls_Figures";
  protected static $primary_index = "idFigure";

	/*
	 * Vérifie si la figure passé en premier paramètre est dans les forces de la figure en deuxième param
	 * @return un booléen, vrai si elle est dans ses forces, faux sinon
	 */
			public static function estDansSesForces($idFigure1, $idFigure2) {
          $data= array(
            "idFigure" => $idFigure2
          );
          $figure2 = self::select($data);
          $forcesFigure2 = explode(",",$figure2->forces);
					return in_array($idFigure1, $forcesFigure2);
			}

	/*
	 * Vérifie si la figure passé en premier paramètre est dans les faiblesses de la figure en deuxième param
	 * @return un booléen, vrai si elle est dans ses faiblesses, faux sinon
	 */
			public static function estDansSesFaiblesses($idFigure1, $idFigure2) {
          $data= array(
            "idFigure" => $idFigure2
          );
          $figure2 = self::select($data);
          $faiblessesFigure2 = explode(",",$figure2->faiblesses);
					return in_array($idFigure1, $faiblessesFigure2);
			}

}

?>
