<button class="btn btn-danger btn-lg" style="float: right" onclick="sup()">Quitter la partie</button>
</br>
</br>
<input type="hidden" id="typeJoueur" value="<?php echo $_SESSION['type'];?>"/>

<input type="hidden" id="boolFinStart" value="NON"/>
<h2><?php echo $sujet?></h2>


<div id="demo"></div>
<div id="demo2"></div>

</div>
</div>


<script type="text/javascript" src="<?= VIEW_PATH_BASE; ?>js/game.js"></script>