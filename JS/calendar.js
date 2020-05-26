document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    $.post("./index.php", {page: "calendar", id: $("#inputprofid").val()}, function (results){
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'timeGrid', 'googleCalendar', 'interaction' ],
            locale: "fr",
            googleCalendarApiKey: 'AIzaSyBgbXcvZ1fK6nr_xo6-OUmb9pS-Qvv-Uk4',
            events: results,
            handleWindowResize: true,
            buttonText: {
                today:    'Aujourd\'hui'
            },
            allDaySlot: false,
            eventOverlap: false,
            selectOverlap: false,
            nowIndicator: true,
            dateClick: function(info){
                if ($("#calendarpopup").css("display") == "none") {
                    $("#calendarpopup").css("display", "flex");
                    $("#calendarpopup").css("top", info.jsEvent.pageY + "px");
                    $("#calendarpopup").css("left", info.jsEvent.pageX + "px");
                    let dateFin = getDateFin(info.date.getHours(), info.date.getMinutes());
                    $("#calendarpopupcontent").html("<p id='timeStart'>Début : " + pad2(info.date.getHours().toString()) + ":" + pad2(info.date.getMinutes().toString()) + "</p>" +
                    "<p id='timeFinish'>Fin : " + dateFin.hours + ":" + dateFin.minutes + "</p>" +
                    "<button id='btcalendarpopup' class='btn btn-primary'>Prendre le rendez-vous</button>");
                    $("#btcalendarpopup").off("click").on("click", {start: pad2(info.date.getHours().toString()) + ":" + pad2(info.date.getMinutes().toString()), finish: dateFin.hours + ":" + dateFin.minutes,
                        date: info.dateStr.substring(0, info.dateStr.lastIndexOf("T")), calendar: calendar} ,onClickBtCalendarPopup);
                }
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault(); // don't let the browser navigate

                if (info.event.url) {
                    (window.open(info.event.url)).focus();
                }
            },
            loading: function( isLoading ){
                document.getElementById('calendarLoading').style.display =
                    isLoading ? 'flex' : 'none';
            }
        });

        calendar.render();

        $("#cross").on("click", onClickCrossCalendar);
    });
});

function onClickCrossCalendar(_event){
    $("#calendarpopup").css("display", "none");
}

function getDateFin(hours, minutes){
    if ((minutes + 30) == 60){
        hours += 1;
        minutes = 0;
    }else{
        minutes += 30;
    }
    return  {hours: pad2(hours.toString()), minutes: pad2(minutes.toString())}
}

function onClickBtCalendarPopup(event){
    $.post("./index.php", {page: "addEvent.model", start: event.data.start, finish: event.data.finish, date: event.data.date, idPro: $("#inputprofid").val()}, function (results){
        alert(results);
        event.data.calendar.refetchEvents();
        onClickCrossCalendar();
    });
}

function pad2(number) {

    return (number < 10 ? '0' : '') + number

}

function reloadCalendar(){
    var calendarEl = document.getElementById('calendar');
    $.post("./index.php", {page: "calendar", id: $("#inputprofid").val()}, function (results){
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'timeGrid', 'googleCalendar', 'interaction' ],
            locale: "fr",
            googleCalendarApiKey: 'AIzaSyBgbXcvZ1fK6nr_xo6-OUmb9pS-Qvv-Uk4',
            events: results,
            handleWindowResize: true,
            buttonText: {
                today:    'Aujourd\'hui'
            },
            allDaySlot: false,
            eventOverlap: false,
            selectOverlap: false,
            nowIndicator: true,
            dateClick: function(info){
                if ($("#calendarpopup").css("display") == "none") {
                    $("#calendarpopup").css("display", "flex");
                    $("#calendarpopup").css("top", info.jsEvent.pageY + "px");
                    $("#calendarpopup").css("left", info.jsEvent.pageX + "px");
                    let dateFin = getDateFin(info.date.getHours(), info.date.getMinutes());
                    $("#calendarpopupcontent").html("<p id='timeStart'>Début : " + pad2(info.date.getHours().toString()) + ":" + pad2(info.date.getMinutes().toString()) + "</p>" +
                        "<p id='timeFinish'>Fin : " + dateFin.hours + ":" + dateFin.minutes + "</p>" +
                        "<button id='btcalendarpopup' class='btn btn-primary'>Prendre le rendez-vous</button>");
                    $("#btcalendarpopup").off("click").on("click", {start: pad2(info.date.getHours().toString()) + ":" + pad2(info.date.getMinutes().toString()), finish: dateFin.hours + ":" + dateFin.minutes,
                        date: info.dateStr.substring(0, info.dateStr.lastIndexOf("T")), calendar: calendar} ,onClickBtCalendarPopup);
                }
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault(); // don't let the browser navigate

                if (info.event.url) {
                    (window.open(info.event.url)).focus();
                }
            },
            loading: function( isLoading ){
                document.getElementById('calendarLoading').style.display =
                    isLoading ? 'flex' : 'none';
            }
        });

        calendar.render();

        $("#cross").on("click", onClickCrossCalendar);
    });
}
