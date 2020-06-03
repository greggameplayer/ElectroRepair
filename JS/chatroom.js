var conn;

$(document).ready(function(){
   conn = new WebSocket('ws://epsi.nathanlemaitre.fr:7070');
   conn.onopen = function(e){
       console.log('connexion établi');
       subscribe($("#channelIdchatroom").val(), $("#youIdchatroom").val());
   };

   conn.onmessage = function(e){
       console.log(e.data);
       var data = JSON.parse(e.data);
       insertChat('oth', data.msg, data.dt);
       console.log(data.clients);
   };

   conn.onerror = function(e){
       console.log('erreur')
   };
});

function sendMessage(msg){
    conn.send(msg);
}

var me = {};

var you = {};

function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

//-- No use time. It is a javaScript effect.
function insertChat(who, text, givendate, time = 0){
    var control = "";
    var date = givendate;

    if (who == "me"){

        control = '<li style="width:100%">' +
            '<div class="msj macro">' +
            '<div class="text text-l">' +
            '<p>'+ text +'</p>' +
            '<p><small>'+date+'</small></p>' +
            '</div>' +
            '</div>' +
            '</li>';
    }else{
        control = '<li style="width:100%;">' +
            '<div class="msj-rta macro">' +
            '<div class="text text-r">' +
            '<p>'+text+'</p>' +
            '<p><small>'+date+'</small></p>' +
            '</div>' +
            '<div class="avatar" style="padding:0px 0px 0px 10px !important"></div>' +
            '</div></li>';
    }
    setTimeout(
        function(){
            $("#chatlist").append(control);

        }, time);

}

function resetChat(){
    $("#chatlist").empty();
}

function convertToFrenchFormat(date){
    var result = new Date(date);
    var month = result.getMonth() + 1;
    var day = result.getDate();
    var year = result.getFullYear();
    var hours = result.getHours();
    var minutes = result.getMinutes();
    var seconds = result.getSeconds();
    return twoDigit(day) + "/" + twoDigit(month) + "/" + year + " " + twoDigit(hours) + ":" + twoDigit(minutes) + ":" + twoDigit(seconds);
}

function twoDigit(n){
    return n > 9 ? "" + n: "0" + n;
}

function subscribe(channel, id) {
    conn.send(JSON.stringify({command: "subscribe", channel: channel, realUserId: id}));
}

$(".mytext").on("keyup", function(e){
    if (e.which == 13){
        var text = $(this).val();
        var data = {
            command: "message",
            youUserId: $("#youIdchatroom").val(),
            othUserId: $("#othIdchatroom").val(),
            msg: text
        };
        if (text !== ""){
            insertChat("me", text, convertToFrenchFormat(new Date()));
            conn.send(JSON.stringify(data));
            $.post("./index.php", {page: "sendMessage", IdDiscussion: $("#channelIdchatroom").val(), Content: text, Sender: $("#youIdchatroom").val(), Receiver: $("#othIdchatroom").val()}, function (results){

            });
            $(this).val('');
        }
    }
});
