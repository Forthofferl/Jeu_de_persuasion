

      <div>
        <SELECT name="sujet" id="sujet" size="1" class="form-control">

          <?php
          foreach ($listSujets as $sujet) {
            echo "<OPTION>" . $sujet[0] . "</OPTION>";
          }
          ?>

        </SELECT>
      </div>

  </br>
  <input id="monBoutonSujet" type="submit"  class="btn btn-default" value="&#xf021; Génerer statistiques"/>
  </br>

<script type="text/javascript">
</script>