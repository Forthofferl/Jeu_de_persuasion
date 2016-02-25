<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <div class="panel panel-default">
            <table class="table table-hover">
                <tbody>

                <?php
                    if(empty($parties)&&$test){
                        echo "<tr>
                                <td>
                                     <span class=\"fa fa-coffee\"></span>
                                </td>
                                <td>

                                  Aucun joueur en attente.
                                </td>
                                <td class=\"text-right text-nowrap\">
                                    <input type='button' onclick=\"partie('/game')\" class=\"btn btn-xs btn-primary\" value='Créer une partie'/>
                                </td>
                            </tr>";
                    }
                    elseif(empty($parties)&&!$test){
                        ;
                    }
                    else{
                        foreach ($parties as $partie) {
                            $nom = $partie['nomJoueur'];
                            echo "<tr>
                                <td>
                                    <span class=\"fa fa-gamepad\"></span>
                                </td>
                                <td >
                                  <FONT color='red' id='nameJoueur'>" . $nom . "</FONT> est en attente
                                </td>
                                <td class=\"text-right text-nowrap\">
                                  <input name='nomJoueur' type='hidden' value='$nom' />";
                                if($partie['attenteJoueur']=="OUI") {
                                    echo "<input type='button' onclick=\"partie('/joinGame')\" class=\"btn btn-xs btn-primary\" value='Jouer'/>";
                                }
                                if($partie['nbreSpectateurRestant']>0){
                                    echo "<input type='button' onclick=\"partie('/lookGame')\" class=\"btn btn-xs btn-success\" value='Regarder'/>";
                                }

                               echo "</td>
                            </tr>";
                        }
                    }
                ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

<script type="text/javascript">
    function partie(finUrl){

        var CheminComplet = document.location.href;
        var url = CheminComplet.substring(0, CheminComplet.lastIndexOf("/")) + finUrl;
        document.formulaire.action = url;
        document.formulaire.submit();
    }
</script>