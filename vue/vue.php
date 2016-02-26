<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <title>PersuasionGame - <?php if (isset($pagetitle)) echo "$pagetitle"; else echo "Erreur" ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?= VIEW_PATH_BASE; ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= VIEW_PATH_BASE; ?>css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= VIEW_PATH_BASE; ?>css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
        <link href="<?= VIEW_PATH_BASE; ?>css/strength-meter.min.css" rel="stylesheet">
        <link href="<?= VIEW_PATH_BASE; ?>css/bootstrap-tabs-x.min.css" rel="stylesheet">
        <link href="<?= VIEW_PATH_BASE; ?>css/style.css" rel="stylesheet">
        <script src="<?= VIEW_PATH_BASE; ?>js/jquery-2.2.0.js"></script>
        <script src="<?= VIEW_PATH_BASE; ?>js/bootstrap.min.js"></script>
        <script src="<?= VIEW_PATH_BASE; ?>js/jquery.smartmenus.bootstrap.min.js"></script>
        <script src="<?= VIEW_PATH_BASE; ?>js/jquery.smartmenus.min.js"></script>
        <script type="text/javascript" src="<?= VIEW_PATH_BASE; ?>js/canvasjs.min.js"></script>
        <script type="text/javascript" src="<?= VIEW_PATH_BASE; ?>js/strength-meter.min.js"></script>
        <script type="text/javascript" src="<?= VIEW_PATH_BASE; ?>js/bootstrap-tabs-x.min.js"></script>
        <script type="text/javascript" src="<?= VIEW_PATH_BASE; ?>js/fusioncharts.js"></script>
        <script type="text/javascript" src="<?= VIEW_PATH_BASE; ?>js/fusioncharts.charts.js"></script>
    </head>
    <body>
        <!-- Menu -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <button type="button" class="navbar-toggle"  data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="fa fa-bars"></span>
                </button>
                <a href=<?php if(strpos(BASE, "index.php")){echo "http://".URL.BASE;} else {echo "http://".URL.BASE."index.php";} ?>><img class="navbar-brand img-responsive logo"  src="<?= VIEW_PATH_BASE; ?>img/logobis2.png" alt=""></a>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php if(estConnecte()) include_once VIEW_PATH.'menu'.DS.'vueMenuConnecte.php';
                    else include_once  VIEW_PATH.'menu'.DS.'vueMenuNonConnecte.php';
                    ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container -->
        </div>
        <!-- Fin du menu -->
        <div id="wrap">
        <div class="container">
        <!-- Principal -->
        <div class="row" id="main-content">
            <div class="col-md-1"></div>
            <div class="col-md-12">

                <div class="jumbotron">
                <?php if(!isset($vue)) {
                    echo "<h2>$messageErreur</h2>";
                    echo '<img class="img-responsive center-block" src="'.VIEW_PATH_BASE.'img/glitch.png" alt="Heeee ?!">';
                  }
                  else require VIEW_PATH.$page.DS.'vue'.ucfirst($vue).ucfirst($page).'.php';?>
                </div>

            </div>
        </div>
        </div>
        <!-- Fin principal -->
        <!-- Footer -->
        <div id="push"></div>
        </div>
        <div id="footer">
            <div class="container">
                <p class="credit">PersuasionGame <span class="fa fa-copyright"></span> 2016 - <a href=<?php if(strpos(BASE, "apropos")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."apropos";} else{echo "http://".URL.BASE."index.php/apropos";}?>>À propos</a></p>
            </div>
        </div>
    </body >


</html >
