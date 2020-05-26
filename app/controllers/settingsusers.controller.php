<?php
namespace Controllers;


use function Helpers\getRenderer;
use function Models\get2auth;


function getSettingsUsersController(){
    $repo='img/users/';
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case "upload":
                print_r($_FILES);
                move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $repo.$_SESSION['id'].".png"); 

            break;
        }
    }

    else{
        $twig=getRenderer();
        echo $twig->render('settings_users.html', [
        "token0" => $token=get2auth($_SESSION['id'])[0]
    ]);

    }
    
    
}




?>