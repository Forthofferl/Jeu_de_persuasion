<h2 id="mainhead"><span class="fa fa-trash"></span> Suppression de votre compte</h2>
<hr>
<div class="row">
  <div class="col-md-offset-3 col-md-6">
<p><small>Êtes-vous sûr de vouloir supprimer votre compte définitivement ?<br/>
Toutes vos données seront effacées définitivement et il ne sera plus possible de les récupérer...</small></p>
<span class="fa-frown-o fa-5x"></span>
<p><a href="<?php if(strpos(BASE, "profil")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."profil";} else{echo "http://".URL.BASE."index.php/profil";} ?>" class="btn btn-info"><span class="fa fa-heart"></span> Revenir sur votre profil</a></p>
<form method="post" action="<?php if(strpos(BASE, "deleted")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."deleted";} else{echo "http://".URL.BASE."index.php/deleted";} ?>">
  <input class="btn btn-xs btn-danger" type="submit" name="submit" value=" &#xf1f8; Confirmer la suppression"/>
</form>
</div>
</div>
