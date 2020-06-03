<?php
namespace Models;

use function Helpers\getDatabaseConnection;

function getAllNotifs($id){
    $qGetNotifs = getDatabaseConnection()->prepare("SELECT * FROM notifications WHERE IdUser = :iduser and Seen = :seen");
    $qGetNotifs->execute([
       "iduser" => $id,
       "seen" => 0
    ]);
    $result = $qGetNotifs->fetchAll();
    $qGetNotifs->closeCursor();
    return $result;
}

function setSeenNotifs($ids){
    for($i = 0; $i < sizeof($ids); $i++){
        $qsetSeen = getDatabaseConnection()->prepare("UPDATE notifications SET Seen = :state");
        $qsetSeen->execute([
           "state" => 1
        ]);
        $qsetSeen->closeCursor();
    }
}

function addNotif($IdUser, $Content, $LinkTo){
    $qAddNotif = getDatabaseConnection()->prepare("INSERT INTO notifications(IdUser, Content, LinkTo) VALUES(:id, :content, :linkto)");
    $qAddNotif->execute([
       "id" => $IdUser,
       "content" => $Content,
       "linkto" => $LinkTo
    ]);
    $qAddNotif->closeCursor();
}
