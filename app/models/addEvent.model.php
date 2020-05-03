<?php
namespace Models;

use Google_Service_Calendar_Event;
use function Helpers\getDatabaseConnection;

function addCalendarEvent($start, $finish, $date, $idPro){
    $ProID = getCalendarId($idPro);
    $qGetNomPrenom = getDatabaseConnection()->prepare("SELECT Prenom, Nom FROM users WHERE IDuser = :id");
    $qGetNomPrenom->execute([
        "id" => $_SESSION["id"]
    ]);
    while ($donnees = $qGetNomPrenom->fetch()){
        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'Rendez-vous ' . $donnees["Nom"] . ' ' . $donnees["Prenom"],
            'location' => '',
            'description' => '',
            'start' => array(
                'dateTime' => $date . 'T'. $start .':00+02:00',
                'timeZone' => 'Europe/Paris',
            ),
            'end' => array(
                'dateTime' => $date . 'T'. $finish .':00+02:00',
                'timeZone' => 'Europe/Paris',
            )
        ));

        $service = startCalendar();
        $event = $service->events->insert($ProID, $event);
    }
    $qGetNomPrenom->closeCursor();

    return "le rendez-vous a été correctement ajouté";
}