<h4> <FONT color="#80dd4e"> <?php if(empty($_SESSION['nomJoueur1'])){echo "En attente d'adversaire!";}else{echo $_SESSION['nomJoueur1'];} ?></FONT> <FONT color="red">VS</FONT> <FONT color="#80dd4e"> <?php if(empty($_SESSION['nomJoueur2'])||$_SESSION['nomJoueur2']=="-1"){echo "En attente d'adversaire!";}else{echo $_SESSION['nomJoueur2'];} ?></FONT> </h4>
</br>
</br>
<div id='Global' >
    <?php
    var_dump($gagnant);
    if(!empty($gagnant)){
        sleep(5);
        echo "<p>Fin de la partie!</p>";
        if($gagnant=="Joueur1") {
            echo "<p>".$_SESSION['nomJoueur1']." a gagné!</p>";
        }
        elseif($gagnant=="Joueur2"){
            echo "<p>".$_SESSION['nomJoueur2']." a gagné!</p>";
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
        if ($argsJ1[0]['joueur1'] == null || $argsJ2[0]['joueur2'] == null) {
            echo "<p>Il semblerai qu'un joueur ait quitter la partie!</p>";
            echo "<p>Veuillez quitter la partie à votre tour!</p>";
        } else {
            echo "<div class='row'>";
            echo "<div class='col-xs-8 col-md-4 col-lg-6 centreVerticalement' >";
            foreach ($argsJ2 as $ligne) {


                if (!empty($ligne['arg1'])) {
                    $argument1 = $ligne['arg1']['idArg'];
                    echo "<p style='font-size: 125%;margin-right: -40%;'>";
                    if (empty($_SESSION["'" . $argument1 . "'"])) {
                        echo "<button class='btn btn-danger' style='float: left;' id='" . $argument1 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'MOINS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument1 . "');\" > ";
                        echo "<span class='fa fa-thumbs-down'></span></button>";
                        echo "<button class='btn btn-warning' style='float: left;' id='" . $argument1 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'NEUTRE';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument1 . "');\" > ";
                        echo "<span class='fa fa-adjust'></span></button>";
                        echo "<button class='btn btn-primary' style='float: left;' id='" . $argument1 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'PLUS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument1 . "');\" > ";
                        echo "<span class='fa fa-thumbs-up'></span> </button>";
                    }
                    echo $ligne['joueur2'];
                    echo " - argument 1  </p><p style=' font-size: 150%;border-radius:15px; background-color:#e66b5b;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $ligne['arg1']['argument'] . " </p>";
                }
                if (!empty($ligne['arg2'])) {
                    $argument2 = $ligne['arg2']['idArg'];
                    echo "<p style='font-size: 125%;margin-right: -40%;'>";
                    if (empty($_SESSION["'" . $argument2 . "'"])) {
                        echo "<button class='btn btn-danger' style='float: left;' id='" . $argument2 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'MOINS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument2 . "');\" > ";
                        echo "<span class='fa fa-thumbs-down'></span></button>";
                        echo "<button class='btn btn-warning' style='float: left;' id='" . $argument2 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'NEUTRE';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument2 . "');\" > ";
                        echo "<span class='fa fa-adjust'></span></button>";
                        echo "<button class='btn btn-primary' style='float: left;' id='" . $argument2 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'PLUS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument2 . "');\" > ";
                        echo "<span class='fa fa-thumbs-up'></span> </button>";
                    }
                    echo $ligne['joueur2'];
                    echo " - argument 2 </p> <p  style=' font-size: 150%;border-radius:15px; background-color:#e66b5b;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $ligne['arg2']['argument'] . "</p> ";
                }
                if (!empty($ligne['arg3'])) {
                    $argument3 = $ligne['arg3']['idArg'];
                    echo "<p style='font-size: 125%;margin-right: -40%;'>";
                    if (empty($_SESSION["'" . $argument3 . "'"])) {
                        echo "<button class='btn btn-danger' style='float: left;' id='" . $argument3 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'MOINS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument3 . "');\" > ";
                        echo "<span class='fa fa-thumbs-down'></span></button>";
                        echo "<button class='btn btn-warning' style='float: left;' id='" . $argument3 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'NEUTRE';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument3 . "');\" > ";
                        echo "<span class='fa fa-adjust'></span></button>";
                        echo "<button class='btn btn-primary' style='float: left;' id='" . $argument3 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'PLUS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument3 . "');\" > ";
                        echo "<span class='fa fa-thumbs-up'></span> </button>";
                    }
                    echo $ligne['joueur2'];
                    echo " - argument 3 </p> <p  style=' font-size: 150%;border-radius:15px; background-color:#e66b5b;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>" . $ligne['arg3']['argument'] . "</p>";
                }
            }

            echo "</div><!--";
            echo " --><div class='col-xs-8 col-md-4 col-lg-6 centreVerticalement' '>";


            foreach ($argsJ1 as $ligne) {


                if (!empty($ligne['arg1'])) {
                    $argument1 = $ligne['arg1']['idArg'];
                    echo "<p style='font-size: 125%;margin-left: -40%;'>";
                    echo $ligne['joueur1'];
                    echo " - argument 1";
                    if (empty($_SESSION["'" . $argument1 . "'"])) {
                        echo "<button class='btn btn-primary' style='float: right;' id='" . $argument1 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'PLUS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument1 . "');\">";
                        echo "<span class='fa fa-thumbs-up'></span></button>";
                        echo "<button class='btn btn-warning' style='float: right;' id='" . $argument1 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'NEUTRE';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument1 . "');\">";
                        echo "<span class='fa fa-adjust'></span></button>";
                        echo "<button class='btn btn-danger' style='float: right;' id='" . $argument1 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'MOINS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument1 . "');\" > ";
                        echo "<span class='fa fa-thumbs-down'></span> </button>";
                    }
                    echo "</p> <p style='font-size: 150%;border-radius:15px; background-color:#89c3c5;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>";
                    echo $ligne['arg1']['argument'];
                    echo "</p>";
                }
                if (!empty($ligne['arg2'])) {
                    $argument2 = $ligne['arg2']['idArg'];
                    echo "<p style='font-size: 125%;margin-left: -40%;'> ";
                    echo $ligne['joueur1'];
                    echo " - argument 2";
                    if (empty($_SESSION["'" . $argument2 . "'"])) {
                        echo "<button class='btn btn-primary' style='float: right;' id='" . $argument2 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'PLUS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument2 . "');\" > ";
                        echo "<span class='fa fa-thumbs-up'></span></button>";
                        echo "<button class='btn btn-warning' style='float: right;' id='" . $argument2 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'NEUTRE';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument2 . "');\" > ";
                        echo "<span class='fa fa-adjust'></span></button>";
                        echo "<button class='btn btn-danger' style='float: right;' id='" . $argument2 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'MOINS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument2 . "');\" > ";
                        echo "<span class='fa fa-thumbs-down'></span> </button>";
                    }
                    echo "</p> <p  style='font-size: 150%;border-radius:15px; background-color:#89c3c5;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>";
                    echo $ligne['arg2']['argument'];
                    echo "</p>";
                }
                if (!empty($ligne['arg3'])) {
                    $argument3 = $ligne['arg3']['idArg'];
                    echo "<p style='font-size: 125%;margin-left: -40%;'>";
                    echo $ligne['joueur1'];
                    echo " - argument 3";
                    if (empty($_SESSION["'" . $argument3 . "'"])) {
                        echo "<button class='btn btn-primary' style='float: right;' id='" . $argument3 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'PLUS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument3 . "');\" > ";
                        echo "<span class='fa fa-thumbs-up'></span></button>";
                        echo "<button class='btn btn-warning' style='float: right;' id='" . $argument3 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'NEUTRE';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument3 . "');\" > ";
                        echo "<span class='fa fa-adjust'></span></button>";
                        echo "<button class='btn btn-danger' style='float: right;' id='" . $argument3 . "' onclick=\"function vote(idArgument){
                                                                                                                            var CheminComplet = document.location.href;
                                                                                                                            var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( '/' ) )+'/vote';
                                                                                                                            var typeVoteArgument = 'MOINS';
                                                                                                                            $.post(url,{idArg: idArgument, typeVote: typeVoteArgument});
                                                                                                                            console.log(idArgument);
                                                                                                                        }
                                                                                                                        vote('" . $argument3 . "');\" > ";
                        echo "<span class='fa fa-thumbs-down'></span> </button>";
                    }
                    echo "</p> <p  style='font-size: 150%;border-radius:15px; background-color:#89c3c5;-moz-border-radius:15px;-webkit-border-radius: 15px;color:#414141;'>";
                    echo $ligne['arg3']['argument'];
                    echo "</p>";
                }

            }


            echo "</div>";
            echo "</div>";
        }
    }
    ?>

</div>
