<?php

namespace Models;

use function Helpers\getDatabaseConnection;




function set2auth($token,$iduser){
    $bdd = getDatabaseConnection();
    $query=$bdd->prepare("INSERT INTO users(token) VALUES (:token) WHERE IDuser=:iduser");
    $query->execute(["token" => $token,
        "iduser" => $iduser
    ]);
}

function get2auth($iduser){
    $bdd = getDatabaseConnection();
    $query=$bdd->prepare("SELECT token FROM users WHERE IDuser=:iduser");
    $query->execute([
        "iduser" => $iduser
    ]);
    return $query->fetch();
}

function isFirst($iduser){
    $bdd = getDatabaseConnection();
    $query=$bdd->prepare("SELECT 2faUsed FROM users WHERE IDuser=:iduser");
    $query->execute([
        "iduser" => $iduser
    ]);
    $result= $query->fetch()[0];
    if($result==0){
        $query=$bdd->prepare("UPDATE users set 2faUsed=:un WHERE IDuser=:iduser");
        $query->execute([
        "iduser" => $iduser,
        "un" => 1

    ]);

    }

}

?>
