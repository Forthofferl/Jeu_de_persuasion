<h1 id="mainhead">Actions disponibles</h1>
<hr>
<div class="row">
  <div class="col-md-12">
    <p> <a href=<?php if(strpos(BASE, "deconnexion")!=false){echo "http://".URL.BASE;}
      else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."deconnexion";}
      else{echo "http://".URL.BASE."index.php/deconnexion";};?> class="btn btn-primary"><span class="fa fa-user"></span> Votre profil</a></p>
    <p> <a href=<?php if(strpos(BASE, "jouer")!=false){echo "http://".URL.BASE;}
      else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."jouer";}
      else{echo "http://".URL.BASE."index.php/jouer";} ?> class="btn btn-info"><span class="fa fa-search"></span> Jouer </a> </p>
    <p> <a href=<?php if(strpos(BASE, "deconnexion")!=false){echo "http://".URL.BASE;}
      else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."deconnexion";}
      else{echo "http://".URL.BASE."index.php/deconnexion";};?> class="btn btn-danger"><span class="fa fa-power-off"></span> Se déconnecter</a></p>
  </div>
</div>
