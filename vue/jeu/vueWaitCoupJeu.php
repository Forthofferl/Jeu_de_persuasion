<h2 id="mainhead">Vous attendez actuellement que votre adversaire joue son coup !</h2>
<hr>
<span class="fa fa-spinner fa-spin choixjeu"></span>
<hr>
<?php if ($temps_attente>20) echo '<h4><a href="jouer.php?action=annulerPartie">Temps d\'attente trop long ? Annuler la partie !</a></h4>'; ?>
<form name="waitingCoup" id="waitingCoup" action="jouer.php?action=waitingCoup" method="POST">
   <input type="hidden" name="temps_attente" id="temps_attente" value="<?= $temps_attente+3; ?>">
</form>

<script type="text/javascript">
    window.onload=function(){
        var auto = setTimeout(function(){ autoRefresh(); }, 100);

        function submitform(){
          document.forms["waitingCoup"].submit();
        }

        function autoRefresh(){
           clearTimeout(auto);
           auto = setTimeout(function(){ submitform(); autoRefresh(); }, 3000);
        }
    }
</script>
