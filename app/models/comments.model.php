<?php
namespace Models;

use function Helpers\getDatabaseConnection;

function getComments($IdAnnonce){
    $result = [
        "Id" => [],
        "IDuser" => [],
        "IDannonce" => [],
        "Timestamp" => [],
        "Content" => [],
        "Prenom" => [],
        "Nom" => []
    ];
    $qGetComments = getDatabaseConnection()->prepare("SELECT * FROM comments, annonce WHERE comments.IDannonce = annonce.IDannonce and annonce.IDannonce = :id ORDER BY comments.Id DESC");
    $qGetComments->execute([
       "id" => $IdAnnonce
    ]);
    while ($donnees = $qGetComments->fetch()){
        array_push($result["Id"], $donnees["Id"]);
        array_push($result["IDuser"], $donnees["IDuser"]);
        array_push($result["IDannonce"], $donnees["IDannonce"]);
        array_push($result["Timestamp"], $donnees["Timestamp"]);
        array_push($result["Content"], $donnees["Content"]);
    }
    $qGetComments->closeCursor();

    if(isset($result["IDuser"])) {
        for ($i = 0; $i < sizeof($result["IDuser"]); $i++) {
            $qGetUserName = getDatabaseConnection()->prepare("SELECT Prenom, Nom FROM users WHERE IDuser = :id");
            $qGetUserName->execute([
                "id" => $result["IDuser"][$i]
            ]);
            while ($donneesUserName = $qGetUserName->fetch()) {
                array_push($result["Prenom"], $donneesUserName["Prenom"]);
                array_push($result["Nom"], $donneesUserName["Nom"]);
            }
            $qGetUserName->closeCursor();
        }
    }


    return $result;
}

function AddComment(){
    $qAddComment = getDatabaseConnection()->prepare("INSERT INTO comments(IDuser, IDannonce, Content) VALUES(:iduser, :idannonce, :content)");
    $qAddComment->execute([
        "iduser" => $_SESSION["id"],
        "idannonce" => $_POST["IDannonce"],
        "content" => $_POST["Content"]
    ]);
    $qAddComment->closeCursor();

    \Controllers\getAnnonceController($_POST["IDannonce"]);
}