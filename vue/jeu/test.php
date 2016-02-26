<?echo

"<p>Fin de la partie!</p>";
if($gagnant=="joueur1") {
echo "<p>".$_SESSION['nomJoueur1']." a gagné!</p>";
}
elseif($gagnant=="joueur2"){
echo "<p>".$_SESSION['nomJoueur2']." a gagné!</p>";
}
elseif($gagnant=="EGALITE"){
echo "<p>C'est une égalité!</p>";
}?>