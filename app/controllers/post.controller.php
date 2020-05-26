<?php
namespace Controllers;

use function Helpers\getRenderer;
use function Models\sendAnnonce;
use function Models\getCategorie;





function getPostController(){
    $repo='img/annonce/';
    $categorie=getCategorie();
    $twig = getRenderer();
    if(isset($_SESSION["id"])){
        if(isset($_GET['action']) and $_GET['action'] =="send") {
            print_r($_FILES);
            $t=bin2hex(random_bytes(6));
            
            
            move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $repo.$t.".png"); 
            $linkimg=$repo.$t.".png";
            var_dump($linkimg);
            
            
            sendAnnonce($_POST['title'],$_POST['detail'],$_POST['cat'],$_SESSION['id'],$linkimg);
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