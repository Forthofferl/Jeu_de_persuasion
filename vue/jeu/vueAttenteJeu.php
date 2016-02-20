<div id="main_game">
    <h2 id="mainhead">Choix du sujet</h2>
    </br>
    </br>
    <FORM name="formulaire" method="post" action="">
        <div class="row">
        <div class="col-md-offset-3 col-md-6">

            <SELECT name="theme" id="theme" size="1" class="form-control" onchange="test()">
                <?php
                    echo "<OPTION>Choix du thème</OPTION>";
                    foreach($listtheme as $theme){
                        echo "<OPTION>".$theme[0];
                    }
                ?>
            </SELECT>
        </div>
        </div>
        </br>
            <div id="div_donnees" ></div>
    </FORM>

</div>
<script type="text/javascript">
    function test(){
        var theme;
        theme = document.getElementById('theme').value;
        var CheminComplet = document.location.href;
        var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) )+"/sujet";
        $.post(url,{theme: theme},function(data){
            // Tu affiches le contenu dans ta div
            $('#div_donnees').html(data)
        });


    }
</script>