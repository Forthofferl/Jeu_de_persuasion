<h2><?php echo $nomSujet; ?></h2>
<h5><a href="<?php if(strpos(BASE, "statistiques")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."statistiques";} else{echo "http://".URL.BASE."index.php/statistiques";} ?>"><i class="fa fa-reply"></i> Retour à la sélection du sujet</a></h5>


    </br>
</br>
<div class="row">
    <div class="col-md-offset-2 col-md-8">

        <input type="hidden" id="hommePour" value="<?php echo round($pourcentageHommePour,2);?>"/>
        <input type="hidden" id="femmePour" value="<?php echo round($pourcentageFemmePour,2);?>"/>
        <input type="hidden" id="hommeContre" value="<?php echo round($pourcentageHommeContre,2);?>"/>
        <input type="hidden" id="femmeContre" value="<?php echo round($pourcentageFemmeContre,2);?>"/>
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
        // graphique
        var revenueChart = new FusionCharts({
            type: 'doughnut2d',
            renderAt: 'chart-container',
            width: '100%',
            height: '100%',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": "Pourcentage d'homme et de femme ayant choisi ce sujet",
                    "subCaption": "",
                    "numberPrefix": "",
                    "paletteColors": "#89c3c5,#e66b5b,#66ccff,#ff6600",
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
                        "label": "Homme pour",
                        "value": document.getElementById("hommePour").value
                    },
                    {
                        "label": "Femme pour",
                        "value": document.getElementById("femmePour").value
                    },
                    {
                        "label": "Homme contre",
                        "value": document.getElementById("hommeContre").value
                    },
                    {
                        "label": "Femme contre",
                        "value": document.getElementById("femmeContre").value
                    }
                ]
            }
        }).render();
    });
</script>