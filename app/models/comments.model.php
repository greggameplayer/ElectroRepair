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
        "Nom" => [],
        "Notation" => []
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
        array_push($result["Notation"], $donnees["Note"]);
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
    $qAddComment = getDatabaseConnection()->prepare("INSERT INTO comments(IDuser, IDannonce, Content, Note) VALUES(:iduser, :idannonce, :content, :notation)");
    $qAddComment->execute([
        "iduser" => $_SESSION["id"],
        "idannonce" => $_POST["IDannonce"],
        "content" => $_POST["Content"],
        "notation"=> $_POST["Notation"]
    ]);
    $qAddComment->closeCursor();

    addNotif(getUserIdByAnnonceId($_POST["IDannonce"])[0]['codeUser'], "Vous avez reçu un nouveau commentaire", "{\"type\": \"comment\", \"IDannonce\": \"" . $_POST["IDannonce"] . "\"}");

    \Controllers\getAnnonceController($_POST["IDannonce"]);
}

function getUserIdByAnnonceId($id){
    $qGetUserID = getDatabaseConnection()->prepare("SELECT codeUser FROM annonce WHERE IDannonce = :idannonce");
    $qGetUserID->execute([
       "idannonce" =>  $id
    ]);
    $result = $qGetUserID->fetchAll();
    $qGetUserID->closeCursor();
    return $result;
}
