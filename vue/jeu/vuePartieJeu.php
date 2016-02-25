<button class="btn btn-danger btn-lg" style="float: right" onclick="sup()">Quitter la partie</button>
</br>
</br>
<input type="hidden" id="typeJoueur" value="<?php echo $_SESSION['type'];?>"/>
<h2><?php echo $sujet?></h2>


<div id="demo"></div>
<div id="demo2">
    <?php
    echo "</br></br>";
    echo "<div class='row'>";
    echo "<div class='col-xs-8 col-md-4 col-lg-6 centreVerticalement'>";
    echo "<input type='text' height='10%' name='chatsaisie' id='chatsaisie' class='form-control' onchange='chatEnter()'/> </div>";
    echo "<!--  --><div class='col-xs-8 col-md-4 col-lg-2 centreVerticalement' > <button class='btn btn-success btn-block' onclick='chatEnter()' id='boutonEnvoie'>Envoyer</button> </div> </div>";
    ?>
</div>

</div>
</div>


<script type="text/javascript" src="<?= VIEW_PATH_BASE; ?>js/game.js"></script>