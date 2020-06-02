<?php
namespace Models;

use function Helpers\getDatabaseConnection;
use function Helpers\getSharedDatabaseConnection;

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

function setChatPresence($id, $state){
    $qSetChatPresence = getSharedDatabaseConnection()->prepare("UPDATE users SET ChatPresence = :state WHERE IDuser = :id");
    $qSetChatPresence->execute([
       "state" => $state,
       "id" => $id
    ]);
    $qSetChatPresence->closeCursor();
}

function getChatPresence($id){
    $qGetChatPresence = getSharedDatabaseConnection()->prepare("SELECT ChatPresence FROM users WHERE IDuser = :id");
    $qGetChatPresence->execute([
       "id" => $id
    ]);
    $result = $qGetChatPresence->fetchAll();
    $qGetChatPresence->closeCursor();
    return $result[0]['ChatPresence'];
}

function setChatID($id, $ChatID){
    $qSetChatID = getSharedDatabaseConnection()->prepare("UPDATE users SET ChatID = :chatid WHERE IDuser = :id");
    $qSetChatID->execute([
       "chatid" => $ChatID,
       "id" => $id
    ]);
    $qSetChatID->closeCursor();
}

function getChatID($id){
    $qGetChatID = getSharedDatabaseConnection()->prepare("SELECT ChatID FROM users WHERE IDuser = :id");
    $qGetChatID->execute([
       "id" => $id
    ]);
    $result = $qGetChatID->fetchAll();
    $qGetChatID->closeCursor();
    return $result[0]['ChatID'];
}
