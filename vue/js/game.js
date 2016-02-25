

var clicChat=false;
var refChat;
//page chat
function chat(){

    clicChat=true;
    Refresh(clicChat);
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


}

chat();
function chatEnter(){
    var recupchatsaisie=document.getElementById('chatsaisie').value;


    var CheminComplet = document.location.href;
    var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) )+"/addmessage";
    $.post( url, {action : recupchatsaisie});

    console.log(recupchatsaisie);
    setTimeout(chat(),500);
}


function sup(){
    var CheminComplet = document.location.href;
    var url = CheminComplet.substring(0, CheminComplet.lastIndexOf("/")) + "/quitter";
    location.href = url;
}




//-----------------------------------

function Refresh(clicChat){
    if(clicChat==true){
        clearInterval(refChat);// Important sinon à chaque entrée de l'utilisateur on relance l'interval, et il y en a de plus en plus.
        var CheminComplet = document.location.href;
        var url = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) )+"/chat";
        refChat=setInterval(function(){$.ajax({ // ajax
            url: url, // url de la page à charger
            cache: false, // pas de mise en cache
            success:function(html){
                update = html;
                document.getElementById("demo").innerHTML=html;console.log("refresh Chat");
            },

            error:function(XMLHttpRequest, textStatus, errorThrows){ // erreur durant la requete
                alert(errorThrows);
            }
        })},1000);
    }
    if(clicChat==false){
        console.log("clearInterval");
        clearInterval(refChat);
    }
}

function enableButton(state){
    if(state.isEqual("OUI")){
        if(document.getElementById("boutonEnvoie").disabled!=false) {
            document.getElementById("boutonEnvoie").disabled = false;
        }
    }
    else{
        if(document.getElementById("boutonEnvoie").disabled!=true) {
            document.getElementById("boutonEnvoie").disabled = true;
        }
    }
}