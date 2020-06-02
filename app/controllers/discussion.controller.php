<?php
namespace Controllers;

use function Helpers\getRenderer;
use function Models\getAllDiscussion;
use function Models\getAllNotifs;
use function Models\getDiscussion;
use function Models\getMessagesFromIdDiscussion;
use function Models\getUserById;

function getDiscussionController(){
    if(isset($_SESSION["id"])){
        $twig = getRenderer();
        echo $twig->render('discussion.html', ["Session" => $_SESSION["id"], "Discussions" => getAllDiscussion(), "Notifs" => getAllNotifs($_SESSION['id'])]);
    }else {
        $twig = getRenderer();
        echo $twig->render('discussion.html');
    }
}

function getChatroomController(){
    if(isset($_SESSION["id"])){
        $twig = getRenderer();
        \Models\setChatPresence($_SESSION['id'], 1);
        \Models\setChatID($_SESSION['id'], $_POST["id"]);
        echo $twig->render('chatroom.html', ["Session" => $_SESSION["id"], "Discussion" => getDiscussion($_POST["id"]), "You" => getUserById($_SESSION["id"]), "Messages" => getMessagesFromIdDiscussion($_POST["id"]), "Notifs" => getAllNotifs($_SESSION['id'])]);
    }else {
        getHomepageController();
    }
}

function getChatroomById($id){
    $twig = getRenderer();
    if(isset($_SESSION["id"])) {
        return $twig->render('chatroom.html', ["Session" => $_SESSION["id"], "Discussion" => getDiscussion($id), "You" => getUserById($_SESSION["id"]), "Messages" => getMessagesFromIdDiscussion($id), "Notifs" => getAllNotifs($_SESSION['id'])]);
    }else {
         return getHomepageController();
    }
}
