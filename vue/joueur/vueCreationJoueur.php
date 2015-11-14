<h2 id="mainhead">Inscription</h2>
<hr>
<div class="row">
<div class="col-md-offset-3 col-md-6">
<form method="post" action="joueur.php?action=save">
            <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span><input type="text" class="form-control" placeholder="Pseudo" name="pseudo" id="id_pseudo" required/></div><br/>
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
            <div class="input-group"><span class="input-group-addon"><i class="fa fa-key"></i></span><input type="password" class="form-control strength" name="pwd" placeholder="Mot de passe" id="id_pwd" required/></div><br/>
            <div class="input-group"><span class="input-group-addon"><i class="fa fa-key"></i></span><input type="password" class="form-control" name="pwd2" placeholder="Confirmer votre mot de passe" id="id_pwd2" required/></div><br/>
            <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span><input type="email" class="form-control" placeholder="E-mail" name="email" id="id_email" required/></div><br/>
            <input type="submit" class="btn btn-default" value="&#xf00c; Valider votre inscription" />
</form>
</div>
</div>
