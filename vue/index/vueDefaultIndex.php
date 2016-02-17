<div class="row featurette">
	<div class="col-md-5 intro">
			<h2 id="mainhead">PersuasionGame</h2>
			<p></p>
			<h3>PersuasionGame est une interface web permettant de jouer à un jeu de perusasion de notre cru !</h3>
			<p></p>


			<a href=<?php if(estConnecte()){
								if(strpos(BASE, "jouer")!=false){echo "http://".URL.BASE;}
								else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."jouer";}
								else{echo "http://".URL.BASE."index.php/jouer";}
							}
							else{
								if(strpos(BASE, "inscription")!=false){echo "http://".URL.BASE;}
								else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."inscription";}
								else{echo "http://".URL.BASE."index.php/inscription";}
								} ?> class="btn btn-default"><?php if(estConnecte()){ echo "Jouer!";} else{ echo "S'inscrire !";}?></a>
			<p></p>
		</div>
		<div class="col-md-7">
			<div class="tv embed-responsive embed-responsive-4by3">
                                
				<img class="featurette-image img-responsive center-block" height="420px" width="600px" src="<?php echo VIEW_PATH_BASE.'index/img/tv.png'?>">
				<video class="embed-responsive-item-tv" poster="<?php echo VIEW_PATH_BASE.'index/img/thumb.png'?>" preload="auto" autoplay loop>
					<source src="<?php echo VIEW_PATH_BASE.'index/img/video.mp4'?>" type="video/mp4" />
				</video>
			</div>
		</div>
</div>
<hr class="featurette-divider">
<div class="row featurette" id="index_description">
	<div class="col-md-3">
		<span class="fa fa-user fa-3x"></span>
		<div>
			<h3>User friendly</h3>
			<p><small>PersuasionGame est facile à utiliser. Une fois connectée(e), vous n'avez qu'à lancer une partie et à affronter votre adversaire !</small></p>
		</div>
	</div>
	<div class="col-md-3">
		<span class="fa fa-mobile fa-3x"></span>
		<div>
			<h3>Responsive</h3>
			<p><small>Utilisant les dernières innovations du web, PerusuasionGame est accessible depuis tous les supports possédant un navigateur Internet.</small></p>
		</div>
	</div>
	<div class="col-md-3">
		<span class="fa fa-github fa-3x"></span>
		<div>
			<h3>Open source</h3>
			<p><small>Notre <a href="https://www.github.com/forthofferl/Jeu_de_persuasion">code</a> est libre et est hébergé sur Github. Il est publié sous la licence open-source <a href="http://opensource.org/licenses/GPL-3.0" target="_blank">GPLv3</a>.</small></p>
		</div>
	</div>
</div>
