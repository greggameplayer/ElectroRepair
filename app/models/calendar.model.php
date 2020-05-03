<?php
namespace Models;

use function Helpers\getDatabaseConnection;

function getCalendarId($id){
    $qGetCalendarId = getDatabaseConnection()->prepare("SELECT CalendarId FROM users WHERE IDuser = :id");
    $qGetCalendarId->execute([
       "id" => $id
    ]);
    while ($donnees = $qGetCalendarId->fetch()){
        $result = $donnees["CalendarId"];
    }
    return $result;
}