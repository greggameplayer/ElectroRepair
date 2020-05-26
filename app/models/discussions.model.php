<?php
namespace Models;

use function Helpers\getDatabaseConnection;

function getAllDiscussion(){
    $qGetAllDiscuss = getDatabaseConnection()->prepare("SELECT discussion.Id, users.Prenom, users.Nom, discussion.RDV FROM discussion, users WHERE discussion.IdUser = :id and discussion.IdPro = users.IDuser or discussion.IdPro = :id and discussion.IdUser = users.IDuser");
    $qGetAllDiscuss->execute([
        "id" => $_SESSION["id"]
    ]);
    $result = $qGetAllDiscuss->fetchAll();
    $qGetAllDiscuss->closeCursor();
    return $result;
}

function getDiscussion($id){
    $qGetDiscuss = getDatabaseConnection()->prepare("SELECT discussion.Id, users.Prenom, users.Nom, users.IDuser, discussion.RDV FROM discussion, users WHERE discussion.Id = :idDiscuss and (discussion.IdUser = :id  and discussion.IdPro = users.IDuser) or (discussion.IdPro = :id  and discussion.IdUser = users.IDuser)");
    $qGetDiscuss->execute([
        "id" => $_SESSION["id"],
        "idDiscuss" => $id
    ]);
    $result = $qGetDiscuss->fetchAll();
    $qGetDiscuss->closeCursor();
    return $result;
}

function saveMessage(){
    $qSaveMsg = getDatabaseConnection()->prepare("INSERT INTO messages(IdDiscussion, Content, Sender) VALUES(:iddisc, :content, :sender)");
    $qSaveMsg->execute([
        "iddisc" => $_POST["IdDiscussion"],
        "content" => $_POST["Content"],
        "sender" => $_POST["Sender"]
    ]);
    $qSaveMsg->closeCursor();
    return "le message a bien été sauvegardé";
}

function getMessagesFromIdDiscussion($IdDiscussion){
    $qGetMessages = getDatabaseConnection()->prepare("SELECT * FROM messages WHERE IdDiscussion = :iddisc");
    $qGetMessages->execute([
       "iddisc" => $IdDiscussion
    ]);
    $result = $qGetMessages->fetchAll();
    $qGetMessages->closeCursor();
    return $result;
}
