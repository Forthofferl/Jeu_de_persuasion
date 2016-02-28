
<h4>Adversaire : <FONT color="red"> <?php if(empty($_SESSION['nomJoueurAdverse'])){echo "En attente d'adversaire!";}else{ echo $_SESSION['nomJoueurAdverse'];} ?></FONT> | Partie : <?php  if(strcmp($tour,"En attente")!=0&&strcmp($tour,"FIN")!=0){echo "tour de ";} echo $tour;?></h4>
</br>
</br>
<div id='Global'>
    <?php

    if(!empty($gagnant)){
        sleep(5);
        echo "<p>Fin de la partie!</p>";
        if($gagnant=="Joueur1") {
            echo "<p>Vous avez gagné!</p>";
        }
        elseif($gagnant=="Joueur2"){
            echo "<p>Vous avez perdu!</p>";
        }
        elseif($gagnant=="EGALITE"){
            echo "<p>C'est une égalité!</p>";
        }
        echo "<p><a href='";
        if(strpos(BASE, "quitter")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."quitter";} else{echo "http://".URL.BASE."index.php/quitter";}
        echo "' class='btn btn-lg'><span class='fa fa-mail-reply'></span> Retour au choix du sujet</a></p>";
        sleep(120);
    }
    else {
        if ($argsJ2[0]['joueur2'] == null) {
            echo "<p>Il semblerai que le joueur adverse ait quitter la partie!</p>";
            echo "<p>Veuillez quitter la partie à votre tour!</p>";
        } else {
            echo "<div class='row'>";
            echo "<div class='col-xs-8 col-md-4 col-lg-6 centreVerticalement' >";
            foreach ($argsJ2 as $ligne) {


                if (!empty($ligne['arg1'])) {
                    $argument1 = $ligne['arg1']['argument'];
                    echo "<p style='font-size: 125%;margin-right: -60%;'>" . $ligne['joueur2'] . " - argument 1 </p><p style=' font-size: 150%;border-radius:15px; background-color:#e66b5b;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $argument1 . " </p>";
                }
                if (!empty($ligne['arg2'])) {
                    $argument2 = $ligne['arg2']['argument'];
                    echo "<p style='font-size: 125%;margin-right: -60%;'>" . $ligne['joueur2'] . " - argument 2 </p> <p  style=' font-size: 150%;border-radius:15px; background-color:#e66b5b;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $argument2 . "</p> ";
                }
                if (!empty($ligne['arg3'])) {
                    $argument3 = $ligne['arg3']['argument'];
                    echo "<p style='font-size: 125%;margin-right: -60%;'>" . $ligne['joueur2'] . " - argument 3 </p> <p  style=' font-size: 150%;border-radius:15px; background-color:#e66b5b;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $argument3 . "</p>";
                }
            }

            echo "</div><!--";
            echo " --><div class='col-xs-8 col-md-4 col-lg-6 centreVerticalement' '>";


            foreach ($argsJ1 as $ligne) {


                if (!empty($ligne['arg1'])) {
                    $argument1 = $ligne['arg1']['argument'];
                    echo "<p style='font-size: 125%;margin-left: -65%;'>";
                    echo $ligne['joueur1'];
                    echo " - argument 1 </p> <p style='font-size: 150%;border-radius:15px; background-color:#89c3c5;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>";
                    echo $argument1;
                    echo "</p>";
                }
                if (!empty($ligne['arg2'])) {
                    $argument2 = $ligne['arg2']['argument'];
                    echo "<p style='font-size: 125%;margin-left: -65%;'>";
                    echo $ligne['joueur1'];
                    echo " - argument 2 </p> <p  style='font-size: 150%;border-radius:15px; background-color:#89c3c5;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>";
                    echo $argument2;
                    echo "</p>";
                }
                if (!empty($ligne['arg3'])) {
                    $argument3 = $ligne['arg3']['argument'];
                    echo "<p style='font-size: 125%;margin-left: -65%;'>";
                    echo $ligne['joueur1'];
                    echo " - argument 3 </p> <p  style='font-size: 150%;border-radius:15px; background-color:#89c3c5;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>";
                    echo $argument3;
                    echo "</p>";
                }
            }


            echo "</div>";
            echo "</div>";
        }
    }
    ?>

</div>

