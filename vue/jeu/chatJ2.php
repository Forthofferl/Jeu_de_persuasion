</br>
<div id='Global'>
    <div class=row>
        <div class="col-xs-8 col-md-4 col-lg-6 centreVerticalement">
            <?php
            foreach ($argsJ1 as $ligne){


                if(!empty( $ligne['mess1J1'])){
                    echo "<p style='font-size: 125%;margin-right: -60%;'>".$ligne['joueur1']." - argument 1
                </p>"."<p style='font-size: 150%; background-color:#e66b5b;border-radius:20px;-moz-border-radius:20px;-webkit-border-radius: 20px;color:#414141;'>".$ligne['mess1J1']." </p>";
                }
                if(!empty( $ligne['mess2J1'])){
                    echo "<p style='font-size: 125%;margin-right: -60%;'>".$ligne['joueur1']." - argument 2
                </p>"."<div id='messageGauche'> <p  style=' font-size: 150%;border-radius:20px; background-color:#e66b5b;-moz-border-radius:20px;-webkit-border-radius: 20px;color:#414141;'>".$ligne['mess2J1']."</p></div>";
                }
                if(!empty( $ligne['mess3J1'])){
                    echo "<p style='font-size: 125%;margin-right: -60%;'>".$ligne['joueur1']." - argument 3
                </p>"."<div id='messageGauche'> <p  style=' font-size: 150%;background-color:#e66b5b;border-radius:20px;-moz-border-radius:20px;-webkit-border-radius: 20px;color:#414141;'>".$ligne['mess3J1']."</p></div>";
                }
            }
            ?>

        </div><!--
            --><div class="col-xs-8 col-md-4 col-lg-6 centreVerticalement" style="margin-top: 10%;">


            <?php
            foreach ($argsJ2 as $ligne){


                if(!empty( $ligne['mess1J2'])){
                    echo "<p style='font-size: 125%;margin-left: -60%;'>".$ligne['joueur2']." - argument 1
                </p>"."<p style=' font-size: 150%; background-color:#89c3c5;border-radius:20px;-moz-border-radius:20px;-webkit-border-radius: 20px;color:#414141;'>".$ligne['mess1J2']." </p>";
                }
                if(!empty( $ligne['mess2J2'])){
                    echo "<p style='font-size: 125%;margin-left: -60%;'>".$ligne['joueur2']." - argument 2
                </p>"."<div id='messageGauche'> <p  style=' font-size: 150%; background-color:#89c3c5;border-radius:20px;-moz-border-radius:20px;-webkit-border-radius: 20px;color:#414141;'>".$ligne['mess2J2']."</p></div>";
                }
                if(!empty( $ligne['mess3J2'])){
                    echo "<p style='font-size: 125%;margin-left: -60%;'>".$ligne['joueur2']." - argument 3
                </p>"."<div id='messageGauche'> <p  style=' font-size: 150%; background-color:#89c3c5;border-radius:20px;-moz-border-radius:20px;-webkit-border-radius: 20px;color:#414141;'>".$ligne['mess3J2']."</p></div>";
                }
            }

            ?>
        </div>
    </div>


</div>

