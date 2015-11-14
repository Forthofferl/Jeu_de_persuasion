<div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-2"></div>
        <div class="col-md-1"></div>
          <div class="col-md-2">
          <div class="img-circle">
            <img class="img-responsive center-block" src="<?= VIEW_PATH_BASE.'jeu/img/'.$idF1.'.png'?>">
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
            <img class="img-responsive center-block" src="<?= VIEW_PATH_BASE.'jeu/img/'.$idF2.'.png'?>">
          </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-2"></div>
</div>
<h2 id="mainhead"><?= $message ?></h2>
<form name="jouer" id="jouer" action="<?php $_SERVER['PHP_SELF']; ?>?action=jouer" method="POST">
</form>

<script type="text/javascript">
    window.onload=function(){
        var auto = setTimeout(function(){ autoRefresh(); }, 100);

        function submitform(){
          document.forms["jouer"].submit();
        }

        function autoRefresh(){
           clearTimeout(auto);
           auto = setTimeout(function(){ submitform(); autoRefresh(); }, 5000);
        }
    }
</script>
