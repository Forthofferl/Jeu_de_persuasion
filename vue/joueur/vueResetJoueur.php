<h2 id="mainhead"></i> Remise à zéro du mot de passe</h2>
<hr>
<div class="row">
<div class="col-md-offset-3 col-md-6">
<form method="post" action="joueur.php?action=reseted">
      <div class="input-group"><span class="input-group-addon"><i class="fa fa-key"></i></span><input type="password" class="form-control strength" name="pwd" placeholder="Mot de passe" id="id_pwd" autocomplete="off" required/></div><br/>
      <div class="input-group"><span class="input-group-addon"><i class="fa fa-key"></i></span><input type="password" class="form-control" name="pwd2" placeholder="Confirmer votre mot de passe" id="id_pwd2" autocomplete="off" required/></div><br/>
      <input type="hidden" name="key" value ="<?php echo $key ?>"required/>
      <input type="submit" class="btn btn-default" value="&#xf00c; Remettre à zéro" />
</form>
</div>
</div>
