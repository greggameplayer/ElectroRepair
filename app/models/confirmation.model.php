<?php

namespace Models;

use function Helpers\getDatabaseConnection;

function confirmation(){
    $qconfirmation = getDatabaseConnection()->prepare("SELECT token, confirmed FROM users WHERE IDuser = :id");
    $qconfirmation->execute([
        "id" => $_SESSION["id"]
    ]);
        while($donnees=$qconfirmation->fetch()){
            if($donnees["confirmed"] == 0 && $_GET["token"] == $donnees["token"]){
                $qconfirmer = getDatabaseConnection()->prepare("UPDATE users SET confirmed = :state WHERE IDuser = :id");
                $qconfirmer->execute([
                    "id" => $_SESSION["id"],
                    "state" => 1
                ]);
                $qconfirmer->closeCursor();
                $_SESSION["tokenactivated"] = 1;
            }
        }
        \Controllers\getHomepageController();
        $qconfirmation->closeCursor();
}
