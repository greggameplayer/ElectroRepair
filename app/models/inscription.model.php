<?php
namespace Models;
use Google_Service_Calendar_AclRule;
use Google_Service_Calendar_AclRuleScope;
use Google_Service_Calendar_Calendar;
use function Helpers\getDatabaseConnection;

function setUser($Email, $Password, $Prenom, $Nom, $Adresse, $CodePostal, $Ville, $Codecat){
    $uniquemail = 1;
    $qcheckmail = getDatabaseConnection()->prepare("SELECT users.IDuser FROM users where users.email = :email");
    $qcheckmail->execute([
        "email" => $Email
    ]);
    if($qcheckmail->rowCount() > 0){
        $uniquemail = 0;
    }
    $qcheckmail->closeCursor();
    if($uniquemail == 1) {
        $options = [
            "cost" => 12,
        ];
        $hashpassword = password_hash($Password, PASSWORD_BCRYPT, $options);
            $calendar = new Google_Service_Calendar_Calendar();
            $calendar->setSummary($Nom . " " . $Prenom);
            $calendar->setTimeZone('Europe/Paris');
            $service = startCalendar();
            $createdCalendar = $service->calendars->insert($calendar);
            $rule = new Google_Service_Calendar_AclRule();
            $scope = new Google_Service_Calendar_AclRuleScope();

            $scope->setType("default");
            $scope->setValue("");
            $rule->setScope($scope);
            $rule->setRole("reader");

            $createdRule = $service->acl->insert($createdCalendar->getId(), $rule);
            $qinscription = getDatabaseConnection()->prepare("INSERT INTO users(email,PassWord,Prenom,Nom,Adresse,CP,Ville,Codecat, CalendarId) VALUES(:email,:password,:prenom,:nom,:adresse,:cp,:ville,:codecateg,:calendar)");
            $qinscription->execute([
                "email" => $Email,
                "password" => $hashpassword,
                "prenom" => $Prenom,
                "nom" => $Nom,
                "adresse" => $Adresse,
                "cp" => $CodePostal,
                "ville" => $Ville,
                "codecateg" => $Codecat,
                "calendar" => $createdCalendar->getId()
            ]);
            $qinscription->closeCursor();
    }
    echo (($uniquemail == 1) ? "le nouvel utilisateur a été créé" : "l'utilisateur existe déjà");
}