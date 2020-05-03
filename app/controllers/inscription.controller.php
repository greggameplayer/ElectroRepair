<?php
namespace Controllers;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use function Helpers\getRenderer;

function getInscriptionController(){
    if(isset($_SESSION["id"])){
        $twig = getRenderer();
        echo $twig->render('inscriptionpage.html', ["Session" => $_SESSION["id"], "Group" => $_SESSION["group"]]);
    }else {
        $twig = getRenderer();
        echo $twig->render('inscriptionpage.html');
    }
}