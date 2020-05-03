<?php
namespace Controllers;

use function Helpers\getRenderer;
use function Models\sendAnnonce;
use function Models\getCategorie;

//NE PAS TOUCHER MERCI 

//TODO Upload Image 
//TODO Lier Utilisateur 


function getPostController(){
    $categorie=getCategorie();
    $twig = getRenderer();
    if(isset($_SESSION["id"])){
        if(isset($_GET['action']) and $_GET['action'] =="send") {
            
            sendAnnonce($_POST['title'],$_POST['detail'],$_POST['cat'],$_SESSION['id'],$_POST['img1']);
            echo $twig->render('post.html', [
                "Session" => $_SESSION["id"],
                "categorie" => $categorie,
                "Group" => $_SESSION["group"]
            ]);
        }
        else
        {
            echo $twig->render('post.html', [
                "Session" => $_SESSION["id"],
                "categorie" => $categorie,
                "Group" => $_SESSION["group"]
            ]);
        }
    }else {
        getHomepageController();
    
    }
    
}



?>