<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <div class="panel panel-default">
            <table class="table table-hover">
                <tbody>

                <?php
                    if(empty($nomJoueur)){
                        echo "<tr>
                                <td>
                                     <span class=\"fa fa-coffee\"></span>
                                </td>
                                <td>

                                  Aucun joueur en attente.
                                </td>
                                <td class=\"text-right text-nowrap\">
                                  <button class=\"btn btn-xs btn-primary\">Créer une partie</button>
                                </td>
                            </tr>";
                    }
                    else{
                        foreach ($nomJoueur as $nom) {
                            echo "<tr>
                                <td>
                                    <span class=\"fa fa-gamepad\"></span>
                                </td>
                                <td>
                                  <FONT COLOR=\"red\">" . $nom." </FONT> est en attente
                                </td>
                                <td class=\"text-right text-nowrap\">
                                  <button class=\"btn btn-xs btn-primary\">Jouer</button>
                                  <button class=\"btn btn-xs btn-success\">Regarder</button>
                                </td>
                            </tr>";
                        }
                    }
                ?>

                </tbody>
            </table>
        </div>
    </div>

</div>