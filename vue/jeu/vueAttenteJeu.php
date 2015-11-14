<h2 id="mainhead">Vous êtes actuellement en attente d'un adversaire !</h2>
<hr>
<span class="fa fa-spinner fa-spin choixjeu"></span>
<hr>
<p><a href="<?php $_SERVER['PHP_SELF']; ?>?action=annuler" class="btn btn-xs btn-danger"><span class="fa fa-close"></span> Annuler votre recherche d'adversaire</a></p>
<form name="waiting" id="waiting" action="<?php $_SERVER['PHP_SELF']; ?>?action=waiting" method="POST">
</form>

<script type="text/javascript">
    window.onload=function(){
        var auto = setTimeout(function(){ autoRefresh(); }, 100);

        function submitform(){
          document.forms["waiting"].submit();
        }

        function autoRefresh(){
           clearTimeout(auto);
           auto = setTimeout(function(){ submitform(); autoRefresh(); }, 5000);
        }
    }
</script>
