<?php

require_once 'Modele.php';

class JeuIA extends Modele{

	protected static $table = "pfcls_StatistiquesPersonnelles";
	protected static $primary_index = "idStatsPerso";

	public static function premierCoup($idJoueur){
		$dataDejaJoue = array('idJoueur'=>$idJoueur);
		$dejaJoue=StatsPerso::selectWhere($dataDejaJoue);
		if($dejaJoue!=NULL){
			$listeCoupsJoueur="";
			foreach ($dejaJoue as $key => $value) {
				$listeCoupsJoueur .= str_replace(',', '', $value->listeCoups);
			}
			$figureCount = array(
				'1'=>substr_count($listeCoupsJoueur,'1',0,strlen($listeCoupsJoueur)),
				'2'=>substr_count($listeCoupsJoueur,'2',0,strlen($listeCoupsJoueur)),
				'3'=>substr_count($listeCoupsJoueur,'3',0,strlen($listeCoupsJoueur)),
				'4'=>substr_count($listeCoupsJoueur,'4',0,strlen($listeCoupsJoueur)),
				'5'=>substr_count($listeCoupsJoueur,'5',0,strlen($listeCoupsJoueur))
			);
			$nbOccumax=$figuremax=0;
			foreach($figureCount as $figure => $nbOccu){
				if($nbOccu>$nbOccumax){
					$nbOccumax=$nbOccu;
					$figuremax=$figure;
				}
			}
			$dataFaiblesses = array('idFigure'=>$figuremax);
			$faiblesses=Figure::select($dataFaiblesses)->faiblesses;
			$valeurs = explode(",",$faiblesses);
			$faiblesserandom = array_rand($valeurs);
			$choixFigure = $valeurs[$faiblesserandom];
		}
		else{
			$choixFigure = mt_rand(1,5);
		}
		return $choixFigure;
	}

	public static function IA($idJoueur,$sequence,$age,$sexe){

		$sequenceClone=$sequence;

		$boolean=false;
		if($sexe=="M")  $sexeOpposer="F";
		else{ $sexeOpposer="M";}
		$coupSuiv=0;
		while($boolean==false){
			$listeSequences = JeuIA::recupSequence($idJoueur,$sequenceClone);
			if($listeSequences!=null){
				$coupSuiv=JeuIA::figureAJouer(JeuIA::occurence(JeuIA::coupSuiv($listeSequences,$sequenceClone)));
				$boolean=true;
			}
			// si y'a pas de séquences trouvées
			else {
				//on réduit si on peut
				if(strlen($sequenceClone)>3){
					$sequenceClone=JeuIA::reducSeq($sequenceClone);
					// mieux !
				}
				//sinon on sort
				else{
					$boolean=true;
				}
			}
		}

		//ici il faut pas check si $coupSuiv existe ?
		// si oui on fait return $coupSuiv;
		//sinon on continue à chercher

		if($coupSuiv!=0) return $coupSuiv; //one line bitch, yes i know biatch

			$sequenceClone=$sequence;


			$boolean=false;
			while($boolean==false){
				$listeSequenceAutre=JeuIA::recupSequenceAll($sexe,$age-2,$age+2,$sequenceClone);
				if($listeSequenceAutre!=null){
					$coupSuiv=JeuIA::figureAJouer(JeuIA::occurence(JeuIA::coupSuiv($listeSequences,$sequenceClone)));
					$boolean=true;
				}
				else {
					//on réduit si on peut
					if(strlen($sequenceClone)>3){
						$sequenceClone=JeuIA::reducSeq($sequenceClone);
						// mieux !
					}
					//sinon on sort
					else{
						$boolean=true;
					}
				}
			}



		if($coupSuiv!=0) return $coupSuiv;

			$sequenceClone=$sequence;


			$boolean=false;
			while($boolean==false){
				$listeSequenceAutre=JeuIA::recupSequenceAll($sexeOpposer,$age-2,$age+2,$sequenceClone);
				if($listeSequenceAutre!=null){
					$coupSuiv=JeuIA::figureAJouer(JeuIA::occurence(JeuIA::coupSuiv($listeSequences,$sequenceClone)));
					$boolean=true;
				}
				else {
					//on réduit si on peut
					if(strlen($sequenceClone)>3){
						$sequenceClone=JeuIA::reducSeq($sequenceClone);
						// mieux !
					}
					//sinon on sort
					else{
						$boolean=true;
					}
				}
			}

		if($coupSuiv!=0) return $coupSuiv;

			$sequenceClone=$sequence;


			$boolean=false;
			while($boolean==false){
				$listeSequenceAutre=JeuIA::recupSequenceAll($sexe,$age-5,$age+5,$sequenceClone);
				if($listeSequenceAutre!=null){
					$coupSuiv=JeuIA::figureAJouer(JeuIA::occurence(JeuIA::coupSuiv($listeSequences,$sequenceClone)));
					$boolean=true;
				}
				else {
					//on réduit si on peut
					if(strlen($sequenceClone)>3){
						$sequenceClone=JeuIA::reducSeq($sequenceClone);
						// mieux !
					}
					//sinon on sort
					else{
						$boolean=true;
					}
				}
			}

		if($coupSuiv!=0) return $coupSuiv;

			$sequenceClone=$sequence;


			$boolean=false;
			while($boolean==false){
				$listeSequenceAutre=JeuIA::recupSequenceAll($sexeOpposer,$age-5,$age+5,$sequenceClone);
				if($listeSequenceAutre!=null){
					$coupSuiv=JeuIA::figureAJouer(JeuIA::occurence(JeuIA::coupSuiv($listeSequences,$sequenceClone)));
					$boolean=true;
				}
				else {
					//on réduit si on peut
					if(strlen($sequenceClone)>3){
						$sequenceClone=JeuIA::reducSeq($sequenceClone);
						// mieux !
					}
					//sinon on sort
					else{
						$boolean=true;
					}
				}
			}

		if($coupSuiv!=0) return $coupSuiv;
		return mt_rand(1,5);
	}

	public static function reducSeq($sequence){
		return substr($sequence,2);
	}

	public static function occurence($arrayValeur){
		$a = $b = $c = $d = $e = 0;
		for($i=0;$i<count($arrayValeur);$i++){
			if ((strcasecmp($arrayValeur[$i],"1"))==0){
				$a=$a+1;
			} elseif ((strcasecmp($arrayValeur[$i],"2"))==0) {
				$b=$b+1;
			} elseif ((strcasecmp($arrayValeur[$i],"3"))==0) {
				$c=$c+1;
			} elseif ((strcasecmp($arrayValeur[$i],"4"))==0) {
				$d=$d+1;
			} elseif ((strcasecmp($arrayValeur[$i],"5"))==0) {
				$e=$e+1;
			}
		}
		$arrayValeur=array(1 => $a,$b,$c,$d,$e);
		return array_search(max($arrayValeur),$arrayValeur);
	}

	public static function figureAJouer($figure){
		if ($figure==0) return 0;
		$dataFaiblesses = array('idFigure'=>$figure);
		$faiblesses=Figure::select($dataFaiblesses)->faiblesses;
		$valeurs = explode(",",$faiblesses);
		$faiblesserandom = array_rand($valeurs);
		$choixFigure = $valeurs[$faiblesserandom];
		return $choixFigure;
	}

	public static function coupSuiv($array, $sequence){
		//12123 123
		// maintenant on récupère uniquement le coup jouer après les séquences stocker dans $arrayValeurs
		$donnees = array();
		for($j=0;$j<count($array);$j++){
			$boolean=false;
			$arrayClone=$array[$j];

			while((strlen($arrayClone)>strlen($sequence))&&($boolean==false)){
				$arrayClone = strstr($arrayClone,$sequence);
				if($arrayClone!=false){
					//si y'a une occurrence dans la chaine
					$longueur = (strlen($arrayClone))-(strlen($sequence));
					if($longueur>1) {
						//si il y une suite, c'est ok on stock
						$del_debut = (strlen($sequence)+1);
						$del_fin = -((strlen($arrayClone))-(strlen($sequence))-2);
						if ($del_fin==0) $valeur = substr($arrayClone, $del_debut);
						else $valeur = substr($arrayClone, $del_debut,$del_fin);
						array_push($donnees, $valeur);
						// et on racourci la seq
						$arrayClone = substr($arrayClone,strlen($sequence)+1);
					}
					//sinon s'il y a pas de suite bah on sort on passe au suivant
					else{
						$boolean=true;
					}
					// si y'a pas une occurence y'en aura pas d'autre donc au suivant
				}
				else{
					$boolean=true;
				}
			}
		}
		if (empty($donnees)) return 0;
		else return $donnees; // renvoie le nombre d'occurence du caractère q
	}

	public static function recupSequence($idJoueur,$sequence){
		$data = array(
			"listeCoups" => "%".$sequence."%",
			"idJoueur" => $idJoueur
		);
		$donnees = array();
		try{
			$req = self::$pdo->prepare('SELECT listeCoups FROM pfcls_StatistiquesPersonnelles WHERE idJoueur = :idJoueur AND listeCoups LIKE :listeCoups');
			$req->execute($data);
			while ($ligne = $req->fetch()) {
				array_push($donnees, $ligne['listeCoups']);
			}
			return $donnees;
		} catch (PDOException $e) {
       echo $e->getMessage();
       $messageErreur="Erreur lors de la récupération de la séquence 1";
      }
  }

	public static function recupSequenceAll($sexe,$agemini,$agemaxi,$sequence){
		$data = array(
			"listeCoups" => "%".$sequence."%",
		);
		$donnees = array();
		try{
			$sql = "SELECT listeCoups FROM pfcls_StatistiquesPersonnelles sp ";
			$sql .= "INNER JOIN pfcls_Joueurs jo ON sp.idJoueur = jo.idJoueur ";
			$sql .= "AND jo.sexe = '".$sexe."' ";
			$sql .= "AND jo.age >= ".$agemini." ";
			$sql .= "AND jo.age <= ".$agemaxi." ";
			$sql .= "AND sp.listeCoups LIKE :listeCoups";
			$req = self::$pdo->prepare($sql);
			$req->execute($data);
			while ($ligne = $req->fetch()) {
				array_push($donnees, $ligne['listeCoups']);
			}
			return $donnees;
		} catch (PDOException $e) {
			echo $e->getMessage();
			$messageErreur="Erreur lors de la récupération de la séquence 2";
		}
	}

}

?>
