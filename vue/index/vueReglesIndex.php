    <h2 id="mainhead"><span class="fa fa-file-text"></span> Règles du jeu</h2>
    </br>
    <ul style="list-style-type: none">
      <li>Si vous êtes un <b>joueur</b> votre but sera de persuader le joueur adverse que votre point de vue est meilleur que le sien.
        Pour cela vous aurez le droit d'écrire trois arguments. Ces arguments seront ensuite notés par des spectateurs et à la fin de la partie,
        nous faisons la somme des votes de chaque argument pour chacun des joueurs et celui qui a le meilleur score l'emporte!

      </li>
      </br>
      <li>
        Si vous êtes entré dans la partie en tant que <b>spectateur</b> il vous suffit d'observer le déroulement de la partie de noter chaque argument,
        pour cela vous aurez trois possibilités négativement <span class="fa fa-thumbs-down"></span>, de manière neutre <span class="fa fa-adjust"></span>
        ou encore positivement <span class="fa fa-thumbs-up"></span>. Chaque vote donne respectivement -1, 0 et 1 point à l'argument pour lequel vous venez de voter.

      </li>
    </ul>
  <hr>
  <h2 id="mainhead"><span class="fa fa-question-circle"></span> Comment jouer ?</h2>
  <hr>
  <ul class="list-group">
    <li class="list-group-item"><span class="label label-default">1</span> Rendez-vous sur la page <a href=<?php if(strpos(BASE, "jouer")!=false){echo "http://".URL.BASE;} else if(strpos(BASE, "index.php")!=false){echo "http://".URL.BASE."jouer";} else{echo "http://".URL.BASE."index.php/jouer";} ?>><span class="fa fa-gamepad"></span> Jouer</a></li>
    <li class="list-group-item"><span class="label label-default">2</span> Choisissez un thème via la liste déroulante</li>
    <li class="list-group-item"><span class="label label-default">3</span> Choisissez un sujet associé au thème précédemment choisi et si vous êtes <b>pour</b> ou <b>contre</b>.</li>
    <li class="list-group-item"><b>Si vous voulez jouer:</b></li>
    <li class="list-group-item"><span class="label label-default">4</span> Si une partie existe vous pouvez la rejoindre si le bouton <img class="imgBouton"  src="<?= VIEW_PATH_BASE; ?>img/boutonJouer.png" alt=""> est affiché, si non vous pouvez créer une partie avec le bouton <img class="imgBouton"  src="<?= VIEW_PATH_BASE; ?>img/boutonCreer.png" alt=""> </li>
    <li class="list-group-item"><b>Si vous voulez simplement regarder et noter:</b></li>
    <li class="list-group-item"><span class="label label-default">4</span> Si une partie existe vous pouvez la rejoindre si le bouton <img class="imgBouton"  src="<?= VIEW_PATH_BASE; ?>img/boutonRegarder.png" alt=""> est affiché, si non pourquoi ne pas tenter votre chance et jouer?</li>
    <li class="list-group-item"><span class="label label-default">5</span> À vous de jouer ! </li>
  </ul>
  <div class="alert alert-info">
    Vous pouvez remarquer que vous pouvez voter négativement.
    La raison est simple : pour nous assurer qu'il y ait toujours un vainqueur, nous avons dû réfléchir à un moyen de voter qui ne condamne pas le joueur si le joueur adverse est en train de gagner lorsqu'ils viennent d'écrire leurs deuxièmes arguments.
    Pour cela même si un joueur perd 3 votes à 2 après que les joueurs aient écrit leurs deuxièmes arguments, après avoir écrit leurs troisièmes arguments si le joueur qui est en train de gagner prend des votes négatifs sur ce dernier argument et que le joueur qui perdait prend des votes positif ou nul il peut très bien gagner!<br/>
    C'est un système qui permet de motivé d'avantage les joueurs et qui permet à tout moment d'inverser la tendance.

  </div>
