    <h2 id="mainhead"><span class="fa fa-pie-chart"></span> Statistiques</h2>
    <hr>
    <div class="row">
    <div class="col-md-12">
      <p>Cette page présente les résultats de notre projet.<br/>
        Pour en savoir plus sur celui-ci, rendez-vous sur la page <a href="index.php?action=apropos"><span class="fa fa-bar-chart"></span> À propos</a>
      </p>
      <p>
        Pour obtenir les statistiques que vous souhaitez, <br/>
        choisissez un sexe, un âge (entre 1 et 100) et une marge d'âge (entre 0 et 10).
      </p>
      <p><em>La marge est l’écart que vous donnerez à la tranche d’âge.
        Par exemple si vous choisissez un âge de 20 ans et une marge de 2 cela calculera
        des statistiques de personnes ayant entre 18 et 22 ans.
      </em></p>
      <p class="alert alert-info">
        Pour obtenir des statistiques sur un âge précis, choisir une marge de 0
      </p>
      <div class="row">
      <div class="col-md-offset-3 col-md-6">
      <form method="post" action="index.php?action=stats">
          <div>
            <input type="radio" name="sexe" id="homme" value="H" required/>
            <label for="homme">
              <span class="fa-stack">
                <i class="fa fa-circle-o fa-stack-2x"></i>
                <i class="fa fa-circle fa-stack-2x"></i>
              </span>
              <i class="fa fa-male fa-3x"></i><br/>
            </label>
            <input type="radio" name="sexe" id="femme" value="F" required/>
            <label for="femme">
              <span class="fa-stack">
                <i class="fa fa-circle-o fa-stack-2x"></i>
                <i class="fa fa-circle fa-stack-2x"></i>
              </span>
              <i class="fa fa-female fa-3x"></i><br/>
            </label>
          </div><br/>
          <div class="input-group"><span class="input-group-addon"><i class="fa fa-calculator"></i></span><input type="number" class="form-control" placeholder="Âge" name="age" id="id_age" min="1" max="100" required/></div><br/>
          <div class="input-group"><span class="input-group-addon"><i class="fa fa-arrows-h"></i></span><input type="number" class="form-control" placeholder="Marge" name="marge" id="id_marge" min="0" max="10" required/></div><br/>
          <input type="submit" class="btn btn-default" value="&#xf021; Générer les statistiques" />
      </form>
    </div>
  </div>
    </div>
  </div>
