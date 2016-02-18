<FORM>

      <div>
        <SELECT name="sujet" id="sujet" size="1" class="form-control">

          <?php
          foreach ($listSujets as $sujet) {
            echo "<OPTION>" . $sujet[0];
          }
          ?>

        </SELECT>
      </div>

  </br>
  <BUTTON id="monBoutonSujet" type="button" onclick="getStat()" class="btn btn-default "><span class="fa fa-refresh" ></span> Génerer statistiques</BUTTON>
  </br>

</FORM>

<script type="text/javascript">
  function getStat(){
    var nomSujet;
    nomSujet = document.getElementById('sujet').value;
    var CheminComplet = document.location.href;
    var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) )+"/statsglobale";
    $.post(url,
        {
          sujet : nomSujet
        },
        function(data){
          // Tu affiches le contenu dans ta div
          $('#div_donnees_partie_en_attente').html(data);
        }

    );


  }
</script>