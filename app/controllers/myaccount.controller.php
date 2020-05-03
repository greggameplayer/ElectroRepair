<?php
namespace Controllers;

use function Helpers\getRenderer;

function getMyAccountController(){
    if(isset($_SESSION["id"])){
        $calendarId = \Models\getCalendarId($_SESSION["id"]);
        if(isset($calendarId)){
            $twig = getRenderer();
            echo $twig->render('myaccount.html', ["Session" => $_SESSION["id"], "CalendarId" => $calendarId, "Group" => $_SESSION["group"]]);
        }else {
            $twig = getRenderer();
            echo $twig->render('myaccount.html', ["Session" => $_SESSION["id"], "Group" => $_SESSION["group"]]);
        }
    }else {
        $twig = getRenderer();
        echo $twig->render('myaccount.html');
    }
}