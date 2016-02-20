

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
    button="</br></br>" +
        "<div class='row'>"
        +"<div class='col-xs-8 col-md-4 col-lg-6 centreVerticalement'>"
        +"<input type='text' name='chatsaisie' id='chatsaisie' class='form-control'/> </div>"
        +"<!--  --><div class='col-xs-8 col-md-4 col-lg-2 centreVerticalement' style='margin-left: -5%'> <button class='btn btn-success' onclick='chatEnter()'>Envoyer</button> </div>";
    document.getElementById("demo2").innerHTML=button;

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
    $.ajax({ // ajax
        url: 'sup.php?action=', // url de la page à charger
        cache: false, // pas de mise en cache


        error:function(XMLHttpRequest, textStatus, errorThrows){ // erreur durant la requete
            alert(errorThrows);
        }
    });
    //document.getElementById('chatsaisie').value ="";
    //document.onload = chat();
    setTimeout(function(){document.onload = chat()},500);
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
                document.getElementById("demo").innerHTML=html;
                console.log("refresh Chat");
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