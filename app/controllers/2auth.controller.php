<?php
namespace Controllers;


use function Helpers\getRenderer;
use function Models\get2auth;
use function Models\isFirst;
 
function get2authController($iduser,$catuser){
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case "test":
                $url = 'https://www.authenticatorapi.com/Validate.aspx?Pin='.$_POST['code'].'&SecretCode='. get2auth($iduser)[0];
                $data = array('Pin' => $_POST['code'], 'SecretCode' => get2auth($iduser));
                $options = array(
                    'http' => array(
                    'header'  => "Content-Type: text/html; charset=utf-8
                    \r\n",
                    'method'  => 'GET',
                    'content' => http_build_query($data)
        )
    );
    
                $context  = stream_context_create($options);
                $response = file_get_contents($url, false, $context);

                if($response != "True"){
                    $twig = getRenderer();
                    echo $twig->render('2auth.html', [
                        "token0" => get2auth($iduser)[0],
                        "Session" => $iduser,
                        "catuser" => $catuser,
                        "error" => "code"
                    ]);

                }
                else {

                $_SESSION['id']=$iduser;
                $_SESSION['group']=$catuser;
                getHomepageController();



                }

            break;
        }

    }
    else
    {
        $twig = getRenderer();
        if(isset($iduser)){
            $token=get2auth($iduser);

        }
        else{
            getHomepageController();
        }
        
        print_r(isFirst($iduser));
        if(isFirst($iduser)==0){
            echo $twig->render('2auth.html', [
                "token0" => $token[0],
                "Session" => $iduser,
                "catuser" => $catuser,
                "first" => 1
            ]);
            }
        else{
            echo $twig->render('2auth.html', [
                "token0" => $token[0],
                "Session" => $iduser,
                "catuser" => $catuser
            ]);
        }
           
    }

}

?>
