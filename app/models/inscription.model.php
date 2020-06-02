<?php
namespace Models;
use Google_Service_Calendar_AclRule;
use Google_Service_Calendar_AclRuleScope;
use Google_Service_Calendar_Calendar;
use function Helpers\getDatabaseConnection;
use function Helpers\getSharedDatabaseConnection;

function setUser($Email, $Password, $Prenom, $Nom, $Adresse, $CodePostal, $Ville, $Codecat){
    $token= kodex_random_string();
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
            $qinscription = getDatabaseConnection()->prepare("INSERT INTO users(email,PassWord,Prenom,Nom,Adresse,CP,Ville,Codecat, CalendarId, token) VALUES(:email,:password,:prenom,:nom,:adresse,:cp,:ville,:codecateg,:calendar,:token)");
            $qinscription->execute([
                "email" => $Email,
                "password" => $hashpassword,
                "prenom" => $Prenom,
                "nom" => $Nom,
                "adresse" => $Adresse,
                "cp" => $CodePostal,
                "ville" => $Ville,
                "codecateg" => $Codecat,
                "calendar" => $createdCalendar->getId(),
                "token" => $token
            ]);
            $qSharedInscription = getSharedDatabaseConnection()->prepare("INSERT INTO users(IDuser) VALUES(:id)");
            $qSharedInscription->execute([
               "id" => getDatabaseConnection()->lastInsertId()
            ]);
            $qinscription->closeCursor();
            $qSharedInscription->closeCursor();
        $emailconfirm = new \SendGrid\Mail\Mail();
        $emailconfirm->setFrom("contact@electrorepair.com", "Electro Repair");
        $emailconfirm->setSubject("Electro Repair | Confirmation création votre compte");
        $emailconfirm->addTo($Email, "Utilisateur");
        $emailconfirm->addContent("text/html", " <br>
        Bonjour <br>
        Veuillez confirmé votre email en cliquant sur le lien ci-dessous: <br>
        <a href='http://maritleawz.cluster028.hosting.ovh.net/?page=confirmation&token=".$token."'>Confirmé</a>");
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($emailconfirm);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
    echo (($uniquemail == 1) ? "le nouvel utilisateur a été créé" : "l'utilisateur existe déjà");
}
function kodex_random_string($length=30){
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for($i=0; $i<$length; $i++){
        $string .= $chars[rand(0, strlen($chars)-1)];
    }
    return $string;
}
