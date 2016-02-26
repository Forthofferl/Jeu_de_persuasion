<h2><?php echo $nomSujet; ?></h2>
<h5><a href="<?php if(strpos(BASE, "statistiques")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."statistiques";} else{echo "http://".URL.BASE."index.php/statistiques";} ?>"><i class="fa fa-reply"></i> Retour à la sélection du sujet</a></<h5>


    </br>
</br>
<div class="row">
    <div class="col-md-offset-2 col-md-8">

        <input type="hidden" id="homme" value="<?php echo round($pourcentageHomme,2);?>"/>
        <input type="hidden" id="femme" value="<?php echo round($pourcentageFemme,2);?>"/>
        <div id="chart-container" ></div>
        <hr>
            <h3>Les 3 arguments les mieux noté pour ce sujet</h3>
        <div class="panel panel-default">
            <table class="table table-hover">

                <?php

                    foreach ($bestArg as $arg) {
                        $message = $arg['message'];
                        echo "<tr >
                                <td>
                                    <span class=\"fa fa-thumbs-o-up\"></span>
                                </td>
                                <td >
                                  " . $message . "
                                </td>
                        </tr>";
                    }
                ?>

            </table>
        </div>

        <hr>
            <h3>Les 3 arguments les moins bien noté pour ce sujet</h3>

        <div class="panel panel-default">
            <table class="table table-hover">

                <?php

                foreach ($worstArg as $arg) {
                    $message = $arg['message'];
                    echo "<tr>
                                <td>
                                    <span class=\"fa fa-thumbs-o-down\"></span>
                                </td>
                                <td >
                                  " . $message . "
                                </td>
                        </tr>";
                }
                ?>

            </table>

        </div>
    </div>

</div>

<script>
    FusionCharts.ready(function () {
        var revenueChart = new FusionCharts({
            type: 'doughnut2d',
            renderAt: 'chart-container',
            width: '100%',
            height: '100%',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": "Pourçentage d'homme et de femme ayant choisi ce sujet",
                    "subCaption": "",
                    "numberPrefix": "",
                    "paletteColors": "#89c3c5,#e66b5b",
                    "bgColor": "#eeeeee",
                    "showBorder": "0",
                    "use3DLighting": "0",
                    "showShadow": "0",
                    "enableSmartLabels": "0",
                    "startingAngle": "310",
                    "showLabels": "0",
                    "showPercentValues": "1",
                    "showLegend": "1",
                    "legendShadow": "0",
                    "legendBorderAlpha": "0",
                    "defaultCenterLabel": "",
                    "centerLabel": "$label: $value%",
                    "centerLabelBold": "1",
                    "showTooltip": "0",
                    "decimals": "0",
                    "captionFontSize": "16",
                    "subcaptionFontSize": "18",
                    "subcaptionFontBold": "0"
                },
                "data": [
                    {
                        "label": "Homme",
                        "value": document.getElementById("homme").value
                    },
                    {
                        "label": "Femme",
                        "value": document.getElementById("femme").value
                    }
                ]
            }
        }).render();
    });
</script>