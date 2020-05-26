<?php
namespace Models;

function getUser($Email, $Password){
    if (! isset($_SESSION["attempts"])){
        $_SESSION["attempts"] = 0;
    }

    if(! $_POST["token"]){
        $_SESSION["failed"] = "captchaError";
        exit;
    }
    $secretKey = $_POST["privateKey"];
    $ip = $_SERVER['REMOTE_ADDR'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array('secret' => $secretKey, 'response' => $_POST["token"]);
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $responseKeys = json_decode($response,true);

    $qcheckemail = \Helpers\getDatabaseConnection()->prepare("SELECT * FROM users WHERE email = :email");
    $qcheckemail->execute([
        "email" => $Email
    ]);
    if($responseKeys["success"]) {
        if ($qcheckemail->rowCount() == 1) {
            $qcheckpassword = \Helpers\getDatabaseConnection()->prepare("SELECT PassWord, IDuser, Codecat, confirmed FROM users WHERE email = :email");
            $qcheckpassword->execute([
                "email" => $Email
            ]);
            while ($donnees = $qcheckpassword->fetch()) {
                if (password_verify($Password, $donnees["PassWord"])) {
                    $_SESSION["id"] = $donnees["IDuser"];
                    $_SESSION["group"] = $donnees["Codecat"];
                    $_SESSION["failed"] = false;
                    $_SESSION["attempts"] = 0;
                    $_SESSION["tokentest"] = $donnees["confirmed"];
                    \Controllers\getHomepageController();
                    return;
                } else {
                    $_SESSION["failed"] = "mdp";
                    $_SESSION["attempts"] += 1;
                    \Controllers\getHomepageController();
                    return;
                }
            }
            $qcheckpassword->closeCursor();
        }
        $qcheckemail->closeCursor();
        $_SESSION["failed"] = "user";
        $_SESSION["attempts"] += 1;
    } else {
        $_SESSION["failed"] = "botDetected";
        $_SESSION["attempts"] += 1;
    }
    \Controllers\getHomepageController();
}

function getUserById($id){
    $qgetUserById = \Helpers\getDatabaseConnection()->prepare("SELECT * FROM users WHERE IDuser = :id");
    $qgetUserById->execute([
        "id" => $id
    ]);
    $result = $qgetUserById->fetchAll();
    $qgetUserById->closeCursor();
    return $result;
}
