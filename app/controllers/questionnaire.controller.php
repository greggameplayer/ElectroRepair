<?php
namespace Controllers;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use function Helpers\getRenderer;
use function Models\getAllNotifs;

function getQuestionnaireController(){
    if(isset($_SESSION["id"])){
        $twig = getRenderer();
        echo $twig->render('questionnaire.html', ["Session" => $_SESSION["id"], "Group" => $_SESSION["group"], "Notifs" => getAllNotifs($_SESSION['id'])]);
    }else {
        $twig = getRenderer();
        echo $twig->render('questionnaire.html');
    }
}
?>
