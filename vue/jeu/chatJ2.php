
<h4>Adversaire : <FONT color="red"> <?php  if(empty($_SESSION['nomJoueurAdverse'])){echo "En attente d'adversaire!";}else{ echo $_SESSION['nomJoueurAdverse'];} ?> </FONT></h4>
</br>
</br>
<div id='Global'>
    <?php

    if(!empty($gagnant)){
        echo "<p>Fin de la partie!</p>";
        if($gagnant=="joueur2") {
            echo "<p>Vous avez gagné!</p>";
        }
        elseif($gagnant=="joueur1"){
            echo "<p>Vous avez perdu!</p>";
        }
        elseif($gagnant=="EGALITE"){
            echo "<p>C'est une égalité!</p>";
        }
    }
    else {
        if ($argsJ1[0]['joueur1'] == null) {
            echo "<p>Il semblerai que le joueur adverse ait quitter la partie!</p>";
            echo "<p>Veuillez quitter la partie à votre tour!</p>";
        } else {
            echo "<div class='row'>";
            echo "<div class='col-xs-8 col-md-4 col-lg-6 centreVerticalement' >";
            foreach ($argsJ1 as $ligne) {


                if (!empty($ligne['arg1'])) {
                    $argument1 = $ligne['arg1']['argument'];
                    echo "<p style='font-size: 125%;margin-right: -60%;'>" . $ligne['joueur1'] . " - argument 1
                </p>" . "<p style='font-size: 150%; background-color:#e66b5b;border-radius:15px;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $argument1 . " </p>";
                }
                if (!empty($ligne['arg2'])) {
                    $argument2 = $ligne['arg2']['argument'];
                    echo "<p style='font-size: 125%;margin-right: -60%;'>" . $ligne['joueur1'] . " - argument 2
                </p>" . "<div id='messageGauche'> <p  style=' font-size: 150%;border-radius:15px; background-color:#e66b5b;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $argument2 . "</p></div>";
                }
                if (!empty($ligne['arg3'])) {
                    $argument3 = $ligne['arg3']['argument'];
                    echo "<p style='font-size: 125%;margin-right: -60%;'>" . $ligne['joueur1'] . " - argument 3
                </p>" . "<div id='messageGauche'> <p  style=' font-size: 150%;background-color:#e66b5b;border-radius:15px;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $argument3 . "</p></div>";
                }
            }
            echo "</div><!--";
            echo " --><div class='col-xs-8 col-md-4 col-lg-6 centreVerticalement' >";


            foreach ($argsJ2 as $ligne) {


                if (!empty($ligne['arg1'])) {
                    $argument1 = $ligne['arg1']['argument'];
                    echo "<p style='font-size: 125%;margin-left: -60%;'>" . $ligne['joueur2'] . " - argument 1
                </p>" . "<p style=' font-size: 150%; background-color:#89c3c5;border-radius:15px;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $argument1 . " </p>";
                }
                if (!empty($ligne['arg2'])) {
                    $argument2 = $ligne['arg2']['argument'];
                    echo "<p style='font-size: 125%;margin-left: -60%;'>" . $ligne['joueur2'] . " - argument 2
                </p>" . "<div id='messageGauche'> <p  style=' font-size: 150%; background-color:#89c3c5;border-radius:15px;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $argument2 . "</p></div>";
                }
                if (!empty($ligne['arg3'])) {
                    $argument3 = $ligne['arg3']['argument'];
                    echo "<p style='font-size: 125%;margin-left: -60%;'>" . $ligne['joueur2'] . " - argument 3
                </p>" . "<div id='messageGauche'> <p  style=' font-size: 150%; background-color:#89c3c5;border-radius:15px;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $argument3 . "</p></div>";
                }
            }

            echo "</div>";
            echo "</div>";
        }
    }
            ?>


</div>

