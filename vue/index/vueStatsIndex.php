    <h2 id="mainhead"><span class="fa fa-pie-chart"></span> Statistiques</h2>
    <hr>
    <h2><i class="fa fa-<?php echo $s; ?>male"></i> | <?php echo $trancheage; ?></h2>
    <h5><a href="index.php?action=statistiques"><i class="fa fa-reply"></i> Retour à la sélection des paramètres</a></<h5>
    <hr>
    <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div id="premiereFigure" style="height: 400px; width: 100%;"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div id="apresPierre" style="height: 400px; width: 100%;"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div id="apresFeuille" style="height: 400px; width: 100%;"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div id="apresCiseaux" style="height: 400px; width: 100%;"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div id="apresLezard" style="height: 400px; width: 100%;"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div id="apresSpock" style="height: 400px; width: 100%;"></div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  window.onload = function () {
    var compte = <?php echo $compte ?>;
    if(compte==0) {
      document.getElementById("premiereFigure").innerHTML = "Aucune données de jeu n'est disponible !";
    }
    else {
      var f1 = <?php echo $premierCoup['1']*100/$compte ?>;
      var f2 = <?php echo $premierCoup['2']*100/$compte ?>;
      var f3 = <?php echo $premierCoup['3']*100/$compte ?>;
      var f4 = <?php echo $premierCoup['4']*100/$compte ?>;
      var f5 = <?php echo $premierCoup['5']*100/$compte ?>;
      var chartPremierCoup = new CanvasJS.Chart("premiereFigure",
      {
        backgroundColor: "#eeeeee",
        legend: {
          horizontalAlign: "center", // "center" , "right"
          verticalAlign: "bottom",  // "top" , "bottom"
          fontFamily: "Asap"
        },
        title:{
          text: "Première figure jouée"
        },
        axisY: {
          title: "Pourcentage"
        },
        data: [
        {
          type: "column",
          showInLegend: false,
          indexLabelFontSize: 25,
          indexLabelFontFamily: "Asap",
          indexLabelFontColor: "#eeeeee",
          indexLabelLineColor: "#eeeeee",
          indexLabelPlacement: "outside",
          //indexLabelLineThickness: 0,
          toolTipContent: "{y}% de {label}",
          valueFormatString: "0.00",
          indexLabel: "",
          dataPoints: [
          {y: f1, label: "Pierre" },
          {y: f2,  label: "Feuille" },
          {y: f3,  label: "Ciseaux" },
          {y: f4,  label: "Lézard" },
          {y: f5,  label: "Spock" },
          ]
        }
        ]
      });
      chartPremierCoup.render();
      chartPremierCoup = {};

    }
    // nouveau chart
    var comptePierre = <?php echo $comptePierre ?>;
    if(comptePierre==0) {
      document.getElementById("apresPierre").innerHTML = "Aucune données de jeu n'est disponible !";
    }
    else {
      var f1 = <?php echo $apresPierre['1']*100/$comptePierre ?>;
      var f2 = <?php echo $apresPierre['2']*100/$comptePierre ?>;
      var f3 = <?php echo $apresPierre['3']*100/$comptePierre ?>;
      var f4 = <?php echo $apresPierre['4']*100/$comptePierre ?>;
      var f5 = <?php echo $apresPierre['5']*100/$comptePierre ?>;
      var chartApresPierre = new CanvasJS.Chart("apresPierre",
      {
        backgroundColor: "#eeeeee",
        legend: {
          horizontalAlign: "center", // "center" , "right"
          verticalAlign: "bottom",  // "top" , "bottom"
          fontFamily: "Asap"
        },
        title:{
          text: "Figure jouée après une pierre"
        },
        axisY: {
          title: "Pourcentage"
        },
        data: [
        {
          type: "column",
          showInLegend: false,
          indexLabelFontSize: 25,
          indexLabelFontFamily: "Asap",
          indexLabelFontColor: "#eeeeee",
          indexLabelLineColor: "#eeeeee",
          indexLabelPlacement: "outside",
          //indexLabelLineThickness: 0,
          toolTipContent: "{y}% de {label}",
          valueFormatString: "0.00",
          indexLabel: "",
          dataPoints: [
          {y: f1, label: "Pierre" },
          {y: f2,  label: "Feuille" },
          {y: f3,  label: "Ciseaux" },
          {y: f4,  label: "Lézard" },
          {y: f5,  label: "Spock" },
          ]
        }
        ]
      });
      chartApresPierre.render();
      chartApresPierre = {};

    }

    // nouveau chart
    var compteFeuille = <?php echo $compteFeuille ?>;
    if(compteFeuille==0) {
      document.getElementById("apresFeuille").innerHTML = "Aucune données de jeu n'est disponible !";
    }
    else {
      var f1 = <?php echo $apresFeuille['1']*100/$compteFeuille ?>;
      var f2 = <?php echo $apresFeuille['2']*100/$compteFeuille ?>;
      var f3 = <?php echo $apresFeuille['3']*100/$compteFeuille ?>;
      var f4 = <?php echo $apresFeuille['4']*100/$compteFeuille ?>;
      var f5 = <?php echo $apresFeuille['5']*100/$compteFeuille ?>;
      var chartApresFeuille = new CanvasJS.Chart("apresFeuille",
      {
        backgroundColor: "#eeeeee",
        legend: {
          horizontalAlign: "center", // "center" , "right"
          verticalAlign: "bottom",  // "top" , "bottom"
          fontFamily: "Asap"
        },
        title:{
          text: "Figure jouée après une feuille"
        },
        axisY: {
          title: "Pourcentage"
        },
        data: [
        {
          type: "column",
          showInLegend: false,
          indexLabelFontSize: 25,
          indexLabelFontFamily: "Asap",
          indexLabelFontColor: "#eeeeee",
          indexLabelLineColor: "#eeeeee",
          indexLabelPlacement: "outside",
          //indexLabelLineThickness: 0,
          toolTipContent: "{y}% de {label}",
          valueFormatString: "0.00",
          indexLabel: "",
          dataPoints: [
          {y: f1, label: "Pierre" },
          {y: f2,  label: "Feuille" },
          {y: f3,  label: "Ciseaux" },
          {y: f4,  label: "Lézard" },
          {y: f5,  label: "Spock" },
          ]
        }
        ]
      });
      chartApresFeuille.render();
      chartApresFeuille = {};

    }

    // nouveau chart
    var compteCiseaux = <?php echo $compteCiseaux ?>;
    if(compteCiseaux==0) {
      document.getElementById("apresCiseaux").innerHTML = "Aucune données de jeu n'est disponible !";
    }
    else {
      var f1 = <?php echo $apresCiseaux['1']*100/$compteCiseaux ?>;
      var f2 = <?php echo $apresCiseaux['2']*100/$compteCiseaux ?>;
      var f3 = <?php echo $apresCiseaux['3']*100/$compteCiseaux ?>;
      var f4 = <?php echo $apresCiseaux['4']*100/$compteCiseaux ?>;
      var f5 = <?php echo $apresCiseaux['5']*100/$compteCiseaux ?>;
      var chartApresCiseaux = new CanvasJS.Chart("apresCiseaux",
      {
        backgroundColor: "#eeeeee",
        legend: {
          horizontalAlign: "center", // "center" , "right"
          verticalAlign: "bottom",  // "top" , "bottom"
          fontFamily: "Asap"
        },
        title:{
          text: "Figure jouée après des ciseaux"
        },
        axisY: {
          title: "Pourcentage"
        },
        data: [
        {
          type: "column",
          showInLegend: false,
          indexLabelFontSize: 25,
          indexLabelFontFamily: "Asap",
          indexLabelFontColor: "#eeeeee",
          indexLabelLineColor: "#eeeeee",
          indexLabelPlacement: "outside",
          //indexLabelLineThickness: 0,
          toolTipContent: "{y}% de {label}",
          valueFormatString: "0.00",
          indexLabel: "",
          dataPoints: [
          {y: f1, label: "Pierre" },
          {y: f2,  label: "Feuille" },
          {y: f3,  label: "Ciseaux" },
          {y: f4,  label: "Lézard" },
          {y: f5,  label: "Spock" },
          ]
        }
        ]
      });
      chartApresCiseaux.render();
      chartApresCiseaux = {};

    }

    // nouveau chart
    var compteLezard = <?php echo $compteLezard ?>;
    if(compteLezard==0) {
      document.getElementById("apresLezard").innerHTML = "Aucune données de jeu n'est disponible !";
    }
    else {
      var f1 = <?php echo $apresLezard['1']*100/$compteLezard ?>;
      var f2 = <?php echo $apresLezard['2']*100/$compteLezard ?>;
      var f3 = <?php echo $apresLezard['3']*100/$compteLezard ?>;
      var f4 = <?php echo $apresLezard['4']*100/$compteLezard ?>;
      var f5 = <?php echo $apresLezard['5']*100/$compteLezard ?>;
      var chartApresLezard = new CanvasJS.Chart("apresLezard",
      {
        backgroundColor: "#eeeeee",
        legend: {
          horizontalAlign: "center", // "center" , "right"
          verticalAlign: "bottom",  // "top" , "bottom"
          fontFamily: "Asap"
        },
        title:{
          text: "Figure jouée après un lézard"
        },
        axisY: {
          title: "Pourcentage"
        },
        data: [
        {
          type: "column",
          showInLegend: false,
          indexLabelFontSize: 25,
          indexLabelFontFamily: "Asap",
          indexLabelFontColor: "#eeeeee",
          indexLabelLineColor: "#eeeeee",
          indexLabelPlacement: "outside",
          //indexLabelLineThickness: 0,
          toolTipContent: "{y}% de {label}",
          valueFormatString: "0.00",
          indexLabel: "",
          dataPoints: [
          {y: f1, label: "Pierre" },
          {y: f2,  label: "Feuille" },
          {y: f3,  label: "Ciseaux" },
          {y: f4,  label: "Lézard" },
          {y: f5,  label: "Spock" },
          ]
        }
        ]
      });
      chartApresLezard.render();
      chartApresLezard = {};

    }

    // nouveau chart
    var compteSpock = <?php echo $compteSpock ?>;
    if(compteSpock==0) {
      document.getElementById("apresSpock").innerHTML = "Aucune données de jeu n'est disponible !";
    }
    else {
      var f1 = <?php echo $apresSpock['1']*100/$compteSpock ?>;
      var f2 = <?php echo $apresSpock['2']*100/$compteSpock ?>;
      var f3 = <?php echo $apresSpock['3']*100/$compteSpock ?>;
      var f4 = <?php echo $apresSpock['4']*100/$compteSpock ?>;
      var f5 = <?php echo $apresSpock['5']*100/$compteSpock ?>;
      var chartApresSpock = new CanvasJS.Chart("apresSpock",
      {
        backgroundColor: "#eeeeee",
        legend: {
          horizontalAlign: "center", // "center" , "right"
          verticalAlign: "bottom",  // "top" , "bottom"
          fontFamily: "Asap"
        },
        title:{
          text: "Figure jouée après Spock"
        },
        axisY: {
          title: "Pourcentage"
        },
        data: [
        {
          type: "column",
          showInLegend: false,
          indexLabelFontSize: 25,
          indexLabelFontFamily: "Asap",
          indexLabelFontColor: "#eeeeee",
          indexLabelLineColor: "#eeeeee",
          indexLabelPlacement: "outside",
          //indexLabelLineThickness: 0,
          toolTipContent: "{y}% de {label}",
          valueFormatString: "0.00",
          indexLabel: "",
          dataPoints: [
          {y: f1, label: "Pierre" },
          {y: f2,  label: "Feuille" },
          {y: f3,  label: "Ciseaux" },
          {y: f4,  label: "Lézard" },
          {y: f5,  label: "Spock" },
          ]
        }
        ]
      });
      chartApresSpock.render();
      chartApresSpock = {};

    }
  }
</script>
