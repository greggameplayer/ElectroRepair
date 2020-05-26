<?php
namespace Controllers;

use function Helpers\getRenderer;
use function Models\getAllNotifs;


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
            case 'confirmation':
                \Models\confirmation();
            break;
            case '2auth':
                get2authController($_POST['id'],$_POST['cat']);
            break;
            case 'settings':
                getSettingsUsersController();
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
            case "discuss":
                getDiscussionController();
                break;
            case "calendar":
                echo \Models\getCalendarId($_POST["id"]);
                break;
            case "addEvent.model":
                echo \Models\addCalendarEvent($_POST["start"], $_POST["finish"], $_POST["date"], $_POST["idPro"]);
                break;
            case "captcha":
                echo \Models\getRecaptchaKeys();
                break;
            case "chatroom":
                getChatroomController();
                break;
            case "AddComment":
                \Models\AddComment();
                break;
            case "sendMessage":
                if (\Models\getChatPresence($_POST['Receiver']) == 0 && \Models\getChatID($_POST['Receiver']) != $_POST['IdDiscussion']){
                    \Models\addNotif($_POST['Receiver'], "Vous avez un nouveau message", "{\"type\": \"chat\", \"discId\": \"" . $_POST["IdDiscussion"] . "\"}");
                }
                echo \Models\saveMessage();
                break;
            case "notifsSeen":
                \Models\setSeenNotifs($_POST['ids']);
                echo getRenderer()->render('notifications.html', ["Notifs" => getAllNotifs($_SESSION['id'])]);
                break;
        }

    }else
    getHomepageController();
