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

?>
