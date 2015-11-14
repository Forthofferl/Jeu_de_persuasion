<div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-2"></div>
        <div class="col-md-1"></div>
          <div class="col-md-2">
          <div class="img-circle">
            <img class="img-responsive center-block" src="<?= VIEW_PATH_BASE.'jeu/img/'.$idF.'.png'?>">
          </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-2">
          <div class="img-circle">
            <img class="img-responsive center-block" src="<?= VIEW_PATH_BASE.'jeu/img/versus.png'?>">
          </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-2">
          <div class="img-circle">
            <img class="img-responsive center-block" src="<?= VIEW_PATH_BASE.'jeu/img/'.$idF.'.png'?>">
          </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-2"></div>
</div>
<h2 id="mainhead">Vous avez joué deux figures identifiques ! Vous allez devoir rejouez le coup !</h2>
<form name="rejouerCoup" id="rejouerCoup" action="<?php $_SERVER['PHP_SELF']; ?>?action=rejouerCoup" method="POST">
</form>

<script type="text/javascript">
    window.onload=function(){
        var auto = setTimeout(function(){ autoRefresh(); }, 100);

        function submitform(){
          document.forms["rejouerCoup"].submit();
        }

        function autoRefresh(){
           clearTimeout(auto);
           auto = setTimeout(function(){ submitform(); autoRefresh(); }, 3000);
        }
    }
</script>
