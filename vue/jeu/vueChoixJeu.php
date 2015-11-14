<h2 id="mainhead">Quel sera votre choix ?</h2>
<hr>
<div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-2">
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>?action=eval">
                  <input type="hidden" id="idFigure" name="idFigure" value="1">
                  <input type="image" src="<?= VIEW_PATH_BASE; ?>jeu/img/1.png" alt="submit"/>
            </form>
            <div class="caption">
            <h3>Pierre</h3>
            </div>
          </div>
          <div class="col-md-1">
          </div>
          <div class="col-md-2">
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>?action=eval">
                  <input type="hidden" id="idFigure" name="idFigure" value="2">
                  <input type="image" src="<?= VIEW_PATH_BASE; ?>jeu/img/2.png" alt="submit"/>
            </form>
            <div class="caption">
            <h3>Feuille</h3>
            </div>
          </div>
          <div class="col-md-1">
          </div>
          <div class="col-md-2">
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>?action=eval">
                  <input type="hidden" id="idFigure" name="idFigure" value="3">
                  <input type="image" src="<?= VIEW_PATH_BASE; ?>jeu/img/3.png" alt="submit"/>
            </form>
            <div class="caption">
            <h3>Ciseaux</h3>
            </div>
          </div>
          <div class="col-md-1">
          </div>
          <div class="col-md-2">
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>?action=eval">
                  <input type="hidden" id="idFigure" name="idFigure" value="4">
                  <input type="image" src="<?= VIEW_PATH_BASE; ?>jeu/img/4.png" alt="submit"/>
            </form>
            <div class="caption">
            <h3>Lézard</h3>
            </div>
          </div>
          <div class="col-md-1">
          </div>
          <div class="col-md-2">
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>?action=eval">
                  <input type="hidden" id="idFigure" name="idFigure" value="5">
                  <input type="image" src="<?= VIEW_PATH_BASE; ?>jeu/img/5.png" alt="submit"/>
            </form>
            <div class="caption">
            <h3>Spock</h3>
            </div>
          </div>
			</div>
      <div class="alert alert-info">
        Pour choisir votre figure, cliquez sur l'image de la figure !
      </div>
