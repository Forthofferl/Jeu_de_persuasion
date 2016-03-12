

var clicChat=false;
var refChat;
//page chat
function chat(){

    clicChat=true;
    Refresh(clicChat);// démarrage du refresh
    var CheminComplet = document.location.href;

    var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) )+"/chat";

    $.ajax({ // ajax
        url: url, // url de la page � charger
        type : 'POST',
        success: function (html) {

            document.getElementById("demo").innerHTML = html;
        },

        error: function (XMLHttpRequest, textStatus, errorThrows) { // erreur durant la requete
            alert(errorThrows);
        }

    });
    //ajout de l'input et du bouton pour envoyer un argument
    button="</br></br>" +
        "<div class='row'>"
        +"<div class='col-xs-8 col-md-4 col-lg-6 centreVerticalement'>"
        +"<input type='text' name='chatsaisie' id='chatsaisie' class='form-control' onchange='chatEnter()'/> </div>"
        +"<!--  --><div class='col-xs-8 col-md-4 col-lg-2 centreVerticalement' style='margin-left: -5%'> "
        +"<button class='btn btn-success' onclick='chatEnter()'>Envoyer</button> </div>";
    var typeJoueur = document.getElementById('typeJoueur').value;
    if(typeJoueur=="joueur") {
        document.getElementById("demo2").innerHTML = button;
    }
}

chat();
// fonction d'enregistrement de l'argument
function chatEnter(){
    var recupchatsaisie=document.getElementById('chatsaisie').value;


    var CheminComplet = document.location.href;
    var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) )+"/addmessage";
    $.post( url, {action : recupchatsaisie});

    console.log(recupchatsaisie);
    setTimeout(chat(),500);
}

// fonction pour quitter une partie
function sup(){
    var CheminComplet = document.location.href;
    var url = CheminComplet.substring(0, CheminComplet.lastIndexOf("/")) + "/quitter";
    location.href = url;
}




//-----------------------------------
// fonction de rafraichissement des vues chat
function Refresh(clicChat){
    if(clicChat==true){
        clearInterval(refChat);// Important sinon à chaque entrée de l'utilisateur on relance l'interval, et il y en a de plus en plus.
        var CheminComplet = document.location.href;
        var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) )+"/chat";
            refChat = setInterval(function () {
                $.ajax({ // ajax
                    url: url, // url de la page à charger
                    cache: false, // pas de mise en cache
                    success: function (html) {
                        document.getElementById("demo").innerHTML = html;
                        console.log("refresh Chat");
                    },

                    error: function (XMLHttpRequest, textStatus, errorThrows) { // erreur durant la requete
                        alert(errorThrows);
                    }
                })
            }, 1000);
        }
    if(clicChat==false){
        console.log("clearInterval");
        clearInterval(refChat);
    }
}
