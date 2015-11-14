<h2 id="mainhead">Préparation des données, veuillez patienter...</h2>
<hr>
<span class="fa fa-spinner fa-spin choixjeu"></span>
<hr>
<form name="waitingLoad" id="waitingLoad" action="jouer.php?action=waitingLoad" method="POST">
</form>

<script type="text/javascript">
    window.onload=function(){
        var auto = setTimeout(function(){ autoRefresh(); }, 100);

        function submitform(){
          document.forms["waitingLoad"].submit();
        }

        function autoRefresh(){
           clearTimeout(auto);
           auto = setTimeout(function(){ submitform(); autoRefresh(); }, 5000);
        }
    }
</script>
