    <h2 id="mainhead"><span class="fa fa-pie-chart"></span> Statistiques</h2>
    <hr>
    <div class="row">
    <div class="col-md-12">
      <p>Cette page présente les résultats de notre projet.<br/>
        Pour en savoir plus sur celui-ci, rendez-vous sur la page <a href=<?php if(strpos(BASE, "apropos")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."apropos";} else{echo "http://".URL.BASE."index.php/apropos";} ?>><span class="fa fa-bar-chart"></span> À propos</a>
      </p>
      <p>
        Pour obtenir les statistiques que vous souhaitez, <br/>
        choisissez un thème, un sujet et appuyer sur le bouton "Génerer les statistiques".
      </p>
      </br>
      </br>
      <div class="row">
      <div class="col-md-offset-3 col-md-6">
        <form>
          <SELECT name="theme" id="theme" size="1" class="form-control" onchange="test()">
            <?php
            echo "<OPTION>Choix du thème</OPTION>";
            foreach($listtheme as $theme){
              echo "<OPTION>".$theme[0];
            }
            ?>
          </SELECT>
        </form>
        </br>
        <div id="div_donnees"></div>
      </div>
    </div>
    </div>
  </div>
    <script type="text/javascript">
      function test(){
        var theme;
        theme = document.getElementById('theme').value;
        var CheminComplet = document.location.href;
        var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) )+"/sujetStat";
        $.post(url,{theme: theme},function(data){
          // Tu affiches le contenu dans ta div
          $('#div_donnees').html(data)
        });


      }
    </script>