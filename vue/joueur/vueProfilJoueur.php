  <div class="container">
    <div class='tabs-x tabs-above tab-align-center'>
      <ul id="onglets" class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#profil" role="tab" data-toggle="tab"><span class="fa fa-user"></span> Profil</a></li>
        <li><a href="#historique" role="tab-kv" data-toggle="tab"><span class="fa fa-history"></span> Historique des parties</a></li>
      </ul>
      <div id="contenu" class="tab-content">
        <div class="tab-pane fade in active" id="profil">
          <div class="row">
            <div class="col-md-6">
              <h2><?php echo $_SESSION['pseudo']; ?></h2>
              <h3><i class="fa fa-<?php echo $infosJoueur['sexe']; ?>male"></i> | <?php echo $infosJoueur['age']; ?> ans</h3>
              <h3><i class="fa fa-envelope"></i> <?php echo $infosJoueur['mail']; ?></h3>
              <h3>Classement - <?php echo $infosJoueur['classement']; ?><sup><?php echo $infosJoueur['eme']; ?></sup></h3>
              <div class="row">
                <div class="col-md-12">
                  <p> <a href="<?php if(strpos(BASE, "update")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."update";} else{echo "http://".URL.BASE."index.php/update";} ?>" class="btn btn-primary"><span class="fa fa-refresh"></span> Mettre à jour votre profil</a> </p>
                  <p> <a href="<?php if(strpos(BASE, "delete")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."delete";} else{echo "http://".URL.BASE."index.php/delete";} ?>" class="btn btn-danger"><span class="fa fa-trash"></span> Supprimer votre profil</a> </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h2>Ratio <?php echo $infosJoueur['ratio'] ?></h2>
              <div id="ratio" style="height: 300px; width: 100%;"></div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="historique">
          <h3>Dernières parties jouées</h3>
            <?php if (empty($infosJoueur['listeParties']))  echo "<h4>Vous n'avez pas encore joué de partie !</h4>";
              else  echo $infosJoueur['tableauVue'];
            ?>
        </div>
      </div>
    </div>
  </div>
        <script type="text/javascript">
          window.onload = function () {
            var nbv = <?php echo $infosJoueur['nombreDeVictoire'] ?>;
            var nbd = <?php echo $infosJoueur['nombreDeDefaite'] ?>;
            if(nbv+nbd==0) {
              document.getElementById("ratio").innerHTML = "Aucune données de jeu n'est disponible !";
            }
            else {
              var chartRatio = new CanvasJS.Chart("ratio",
              {
                backgroundColor: "#eeeeee",
                legend: {
                  horizontalAlign: "center", // "center" , "right"
                  verticalAlign: "bottom",  // "top" , "bottom"
                  fontFamily: "Asap"
                },
                data: [
                {
                  type: "doughnut",
                  showInLegend: true,
                  startAngle:0,
                  indexLabelFontSize: 25,
                  indexLabelFontFamily: "Asap",
                  indexLabelFontColor: "#eeeeee",
                  indexLabelLineColor: "#eeeeee",
                  indexLabelPlacement: "outside",
                  indexLabelLineThickness: 0,
                  toolTipContent: "{y} {label} - <strong>#percent%</strong>",
                  indexLabel: "",
                  dataPoints: [
                  {  y: nbv, legendText:"Victoire(s)", label: "victoire(s)" },
                  {  y: nbd, legendText:"Défaite(s)", label: "défaite(s)" }
                  ]
                }
                ]
              });
              chartRatio.render();
              chartRatio = {};
          }
         
        }
        </script>
