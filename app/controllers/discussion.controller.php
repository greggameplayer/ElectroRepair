<?php
namespace Controllers;

use function Helpers\getRenderer;
use function Models\getAllDiscussion;
use function Models\getDiscussion;
use function Models\getMessagesFromIdDiscussion;
use function Models\getUserById;

function getDiscussionController(){
    if(isset($_SESSION["id"])){
        $twig = getRenderer();
        echo $twig->render('discussion.html', ["Session" => $_SESSION["id"], "Discussions" => getAllDiscussion()]);
    }else {
        $twig = getRenderer();
        echo $twig->render('discussion.html');
    }
}

function getChatroomController(){
    if(isset($_SESSION["id"])){
        $twig = getRenderer();
        echo $twig->render('chatroom.html', ["Session" => $_SESSION["id"], "Discussion" => getDiscussion($_POST["id"]), "You" => getUserById($_SESSION["id"]), "Messages" => getMessagesFromIdDiscussion($_POST["id"])]);
    }else {
        getHomepageController();
    }
}

function getChatroomById($id){
    $twig = getRenderer();
    if(isset($_SESSION["id"])) {
        return $twig->render('chatroom.html', ["Session" => $_SESSION["id"], "Discussion" => getDiscussion($id), "You" => getUserById($_SESSION["id"]), "Messages" => getMessagesFromIdDiscussion($id)]);
    }else {
         return getHomepageController();
    }
}
