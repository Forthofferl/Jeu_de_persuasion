<h2 id="mainhead"><span class="fa fa-refresh fa-spin"></span> Mettre à jour votre profil</h2>
<hr>
<div class="row">
<div class="col-md-offset-3 col-md-6">
<form method="post" action="<?php if(strpos(BASE, "updated")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."updated";} else{echo "http://".URL.BASE."index.php/updated";} ?>">
        <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span><input type="text" class="form-control" value="<?php echo $pseudo ?>" name="pseudo" id="id_pseudo" required/></div><br/>
        <p><i class="fa fa-<?php echo $sexe; ?>male fa-2x"></i></p>
        <div class="input-group"><span class="input-group-addon"><i class="fa fa-calculator"></i></span><input type="number" class="form-control" value="<?php echo $age ?>" name="age" id="id_age" min="1" max="100" required/></div><br/>
        <div class="input-group"><span class="input-group-addon"><i class="fa fa-key"></i></span><input type="password" class="form-control strength" name="pwd" placeholder="Nouveau mot de passe" id="id_pwd" autocomplete="off"/></div><br/>
        <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span><input type="email" class="form-control" value="<?php echo $email ?>" name="email" id="id_email" required/></div><br/>
        <input type="submit" class="btn btn-default" value="&#xf021; Mettre à jour" />
</form>
</div>
</div>
