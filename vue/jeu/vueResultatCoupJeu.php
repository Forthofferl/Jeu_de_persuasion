
<div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-2"></div>
        <div class="col-md-1"></div>
          <div class="col-md-2">
          <div class="img-circle" id="left" style="position:relative;margin-left:30%;">
            <img class="img-responsive center-block" src="<?= VIEW_PATH_BASE.'jeu/img/'.$idF1.'.png'?>">
          </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-2">
          <center><div class="img-circle" id="vs" style="opacity:'0'">
            <img class="img-responsive center-block" src="<?= VIEW_PATH_BASE.'jeu/img/versus.png'?>">
          </div></center>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-2">
          <div class="img-circle" id="right" style="position:relative;margin-right:30%;">
            <img class="img-responsive center-block" src="<?= VIEW_PATH_BASE.'jeu/img/'.$idF2.'.png'?>">
          </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-2"></div>
</div>
<h1 id="mainhead"><?= $message ?></h1>
<form name="jouer" id="jouer" action="jouer.php?action=jouer" method="POST">
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
window.onload=function(){
    $("div.left").animate({
      left:'25%'
    });
});
</script>
<script>
window.onload=function(){
    $("div.right").animate({
      right:'25%'
    });
});
window.onload=function(){
    $("div.vs").animate({
      opacity:'1'
    });
});
</script>
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
