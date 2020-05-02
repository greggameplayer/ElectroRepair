<?php
namespace Controllers;

use function Helpers\getRenderer;



function getMainController(){
    if(isset($_GET['page'])) {
        switch($_GET['page']){
            case "homepage" :
                getHomepageController();
            break;
            case "post":
                getPostController();
            break;
            case "contact":
                getContactController();
            break;
            case "mail":
                sendMail();
            break;
            case "aPropos":
                getAproposController();
            break; 
            case 'CGU':
                getCGUController();
            break; 
            case 'resultat_recherche':
                getResultatController();
            break;
            case 'questionnaire':
                getQuestionnaireController();
            break;
            case 'inscription':
                getInscriptionController();
            break; 
            case 'annonce':
                getAnnonceController();
            break;
            case 'annonceQuestionnaire':
                getResultatQuestionnaireController();
            break;
            default:
                getHomepageController();
            break;
    }
    }else if(isset($_POST["page"])) {
        switch ($_POST["page"]) {
            case "inscription.model":
                \Models\setUser($_POST["Email"], $_POST["Password"], $_POST["Prenom"], $_POST["Nom"], $_POST["Adresse"], $_POST["CodePostal"], $_POST["Ville"], $_POST["Codecat"]);
                break;
            case "inscription":
                getInscriptionController();
                break;
            case "connexion":
                getLoginController();
                break;
            case "deconnexion":
                session_destroy();
                break;
            case "myaccount":
                getMyAccountController();
                break;
            case "calendar":
                echo \Models\getCalendarId($_POST["id"]);
                break;
            case "addEvent.model":
                echo \Models\addCalendarEvent($_POST["start"], $_POST["finish"], $_POST["date"], $_POST["idPro"]);
        }

    }else
        getHomepageController();


}