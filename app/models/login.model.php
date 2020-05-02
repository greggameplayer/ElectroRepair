<?php
namespace Models;

function getUser($Email, $Password){
    $qcheckemail = \Helpers\getDatabaseConnection()->prepare("SELECT * FROM users WHERE email = :email");
    $qcheckemail->execute([
        "email" => $Email
    ]);
    if ($qcheckemail->rowCount() == 1) {
        $qcheckpassword = \Helpers\getDatabaseConnection()->prepare("SELECT PassWord, IDuser, Codecat FROM users WHERE email = :email");
        $qcheckpassword->execute([
            "email" => $Email
        ]);
        while ($donnees = $qcheckpassword->fetch()) {
            if (password_verify($Password, $donnees["PassWord"])) {
                $_SESSION["id"] = $donnees["IDuser"];
                $_SESSION["group"] = $donnees["Codecat"];
                $_SESSION["failed"] = false;
                \Controllers\getHomepageController();
                return;
            }else{
                $_SESSION["failed"] = "mdp";
                \Controllers\getHomepageController();
                return;
            }
        }
        $qcheckpassword->closeCursor();
    }
    $qcheckemail->closeCursor();
    $_SESSION["failed"] = "user";
    \Controllers\getHomepageController();
}