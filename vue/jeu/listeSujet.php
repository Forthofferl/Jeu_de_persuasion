<FORM>
    <div class=row>
        <div class="col-xs-5 col-md-6 col-lg-4 centreVerticalement">
            <div>
                <SELECT name="sujet" id="sujet" size="1" class="form-control">

                    <?php
                    foreach ($listSujets as $sujet) {
                        echo "<OPTION>" . $sujet[0];
                    }
                    ?>

                </SELECT>
            </div>
        </div><!--
            --><div class="col-xs-5 col-md-6 col-lg-2 centreVerticalement">
            <div>
                <SELECT name="coterSujet" id="coterSujet" size="1" class="form-control">

                    <OPTION>POUR</OPTION>
                    <OPTION>CONTRE</OPTION>

                </SELECT>
            </div>
        </div>

    </div>
    </br>
    <BUTTON id="monBoutonSujet" type="button" onclick="getPartie()" class="btn btn-info "><span class="fa fa-search" ></span> Chercher partie </BUTTON>
    </br>

    <div id="div_donnees_partie_en_attente"></div>

</FORM>

<script type="text/javascript">
    function getPartie(){
        var coterSujetActuel, nomSujet;
        coterSujetActuel = document.getElementById('coterSujet').value;
        nomSujet = document.getElementById('sujet').value;
        var CheminComplet = document.location.href;
        var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) )+"/partie_en_attente";
        $.post(url,
            {
                sujet : nomSujet,coterSujet : coterSujetActuel
            },function(data){
            // Tu affiches le contenu dans ta div
            $('#div_donnees_partie_en_attente').html(data);}

        );


    }
</script>
