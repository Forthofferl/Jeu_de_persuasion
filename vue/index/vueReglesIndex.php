    <h2 id="mainhead"><span class="fa fa-file-text"></span> Règles du jeu</h2>
    <hr>
  <p>Une petite explication en vidéo du jeu par <em>Sheldon Cooper</em> de la série <em>The Big Bang Theory</em> (en anglais)</p>
  <p>
  <div class="embed-responsive embed-responsive-16by9">
    <iframe class="embed-responsive-item" src="//www.youtube.com/embed/_PUEoDYpUyQ"></iframe>
  </div>
  </p>
  <hr>
  <div class="row featurette">
    <div class="col-md-7">
      <h3 class="featurette-heading">Si vous n'avez pas tous suivi, pas d'inquiétude, voici un récapitulatif des règles accompagné d'un schéma</h3>
      <p class="lead">
        <ul class="list-group">
          <li class="list-group-item"> La pierre écrase le lézard </li>
          <li class="list-group-item"> Le lézard empoisonne Spock </li>
          <li class="list-group-item"> Spock casse les ciseaux </li>
          <li class="list-group-item"> Les ciseaux décapitent le lézard </li>
          <li class="list-group-item"> Le lézard mange la feuille </li>
          <li class="list-group-item"> La feuille désavoue Spock </li>
          <li class="list-group-item"> Spock vaporise la pierre </li>
        </ul>
      </p>
    </div>
    <div class="col-md-5">
      <img class="featurette-image img-responsive center-block" height="80%" width="80%" src="<?php echo VIEW_PATH_BASE.'index/img/regles.png'?>" alt="Schéma des règles">
      <div class="caption">
        <h3>Schéma des règles</h3>
        <small><em>Source : Wikipedia</em></small>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <h3 class="featurette-heading">Ainsi qu'un tableau qui liste toutes les possibilités</h3>
    <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th> # </th>
          <th> Pierre </th>
          <th> Feuille </th>
          <th> Ciseaux </th>
          <th> Lézard </th>
          <th> Spock </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th> Pierre </th>
          <td> Draw </td>
          <td> Feuille </td>
          <td> Pierre </td>
          <td> Pierre </td>
          <td> Spock </td>
        </tr>
        <tr>
          <th> Feuille </th>
          <td> Feuille </td>
          <td> Draw </td>
          <td> Ciseaux </td>
          <td> Lézard </td>
          <td> Feuille </td>
        </tr>
        <tr>
          <th> Ciseaux </th>
          <td> Pierre </td>
          <td> Ciseaux </td>
          <td> Draw </td>
          <td> Ciseaux </td>
          <td> Spock </td>
        </tr>
        <tr>
          <th> Lézard </th>
          <td> Pierre </td>
          <td> Lézard </td>
          <td> Ciseaux </td>
          <td> Draw </td>
          <td> Lézard </td>
        </tr>
        <tr>
          <th> Spock </th>
          <td> Spock </td>
          <td> Feuille </td>
          <td> Spock </td>
          <td> Lézard </td>
          <td> Draw </td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
  <h2 id="mainhead"><span class="fa fa-question-circle"></span> Comment jouer ?</h2>
  <hr>

  <ul class="list-group">
    <li class="list-group-item"><span class="label label-default">1</span> Rendez-vous sur la page <a href="index.php?action=choixmode"><span class="fa fa-gamepad"></span> Jouer</a></li>
    <li class="list-group-item"><span class="label label-default">2</span> Choisisssez si vous souhaitez jouer contre un adversaire humain <span class="fa fa-user"></span> ou contre l'ordinateur <span class="fa fa-code"></span></li>
    <li class="list-group-item"><span class="label label-default">3</span> Choisissez le nombre de manches que vous souhaitez jouer</li>
    <li class="list-group-item"><span class="label label-default">4</span> À vous de jouer ! </li>
  </ul>

  <div class="alert alert-info">
    Vous remarquerez peut-être que le nombre de manches à jouer qui vous est toujours impair.
    La raison est simple : pour s'assurer qu'il y ait toujours un vainqueur, nous avons choisi d'utiliser le format <em>best-of</em>, un système de jeu présent dans la plupart des jeux à des deux joueurs.
    Ce format spécifie que le premier des deux joueurs qui remportent la majorité des manches de la série (définie au début de la partie), remporte la partie.<br/>
    Exemple pour illustrer : dans un best of 5, celui qui remportent trois manches, remportent la partie.
  </div>
