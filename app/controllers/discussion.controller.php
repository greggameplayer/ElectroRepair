<?php
namespace Controllers;

use function Helpers\getRenderer;

function getDiscussionController(){
    if(isset($_SESSION["id"])){
            $twig = getRenderer();
            echo $twig->render('discussion.html', ["Session" => $_SESSION["id"]]);
    }else {
        $twig = getRenderer();
        echo $twig->render('discussion.html');
    }
}