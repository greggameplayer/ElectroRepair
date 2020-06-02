<?php
namespace Controllers;

use function Helpers\getRenderer;
use function Models\getAllNotifs;

function getMyAccountController(){
    if(isset($_SESSION["id"])){
        $calendarId = \Models\getCalendarId($_SESSION["id"]);
        if(isset($calendarId)){
            $twig = getRenderer();
            echo $twig->render('myaccount.html', ["Session" => $_SESSION["id"], "CalendarId" => $calendarId, "Group" => $_SESSION["group"], "Notifs" => getAllNotifs($_SESSION['id'])]);
        }else {
            $twig = getRenderer();
            echo $twig->render('myaccount.html', ["Session" => $_SESSION["id"], "Group" => $_SESSION["group"], "Notifs" => getAllNotifs($_SESSION['id'])]);
        }
    }else {
        $twig = getRenderer();
        echo $twig->render('myaccount.html');
    }
}
