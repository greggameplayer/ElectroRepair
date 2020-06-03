<?php
namespace Models;

use Google_Service_Calendar_Event;
use function Helpers\getDatabaseConnection;

function addCalendarEvent($start, $finish, $date, $idPro){
    $ProID = getCalendarId($idPro);
    $ClientID = getCalendarId($_SESSION["id"]);
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

    $qGetNomPrenomPro = getDatabaseConnection()->prepare("SELECT Prenom, Nom FROM users WHERE IDuser = :id");
    $qGetNomPrenomPro->execute([
        "id" => $idPro
    ]);
    while ($donneesPro = $qGetNomPrenomPro->fetch()){
        $eventClient = new Google_Service_Calendar_Event(array(
            'summary' => 'Rendez-vous avec ' . $donneesPro["Nom"] . ' ' . $donneesPro["Prenom"],
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

        $serviceClient = startCalendar();
        $eventClient = $serviceClient->events->insert($ClientID, $eventClient);
    }
    $qGetNomPrenomPro->closeCursor();

    $qAddDiscussion = getDatabaseConnection()->prepare("INSERT INTO discussion(IdPro, IdUser, RDV) VALUES(:idpro, :iduser, :rdv)");
    $qAddDiscussion->execute([
        "idpro" => $idPro,
        "iduser" => $_SESSION["id"],
        "rdv" => $date . 'T'. $start .':00+02:00'
    ]);

    $qAddDiscussion->closeCursor();

    addNotif($idPro, "Vous avez un nouveau rendez-vous", "{\"type\": \"rdv\"}");
    return "le rendez-vous a été correctement ajouté";
}
