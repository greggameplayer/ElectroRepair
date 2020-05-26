<?php
namespace Controllers;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use function Helpers\getRenderer;

function getHomepageController(){
    if(isset($_SESSION["id"]) && isset($_SESSION["failed"]) && $_SESSION["failed"] == false){
        $twig = getRenderer();
        if(isset($_SESSION["tokenactivated"])){
            echo $twig->render('homepage.html', ["Session" => $_SESSION["id"], "Group" => $_SESSION["group"], "Token" => $_SESSION["tokenactivated"]]);
            unset($_SESSION["tokenactivated"]);
        }else if(isset($_SESSION["tokentest"]) && $_SESSION["tokentest"] == 0){
            echo $twig->render('homepage.html', ["Tokentest" => $_SESSION["tokentest"]]);
        }else{
            echo $twig->render('homepage.html', ["Session" => $_SESSION["id"], "Group" => $_SESSION["group"], "Tokentest" => $_SESSION["tokentest"]]);
        }
    }else if(isset($_SESSION["failed"]) && ($_SESSION["failed"] == "mdp" || $_SESSION["failed"] == "user")){
        $twig = getRenderer();
        echo $twig->render('homepage.html', ["Failed" => $_SESSION["failed"]]);
        $_SESSION["failed"] = false;
    }else{
        $twig = getRenderer();
        echo $twig->render('homepage.html');
    }
    
}
 

?>
