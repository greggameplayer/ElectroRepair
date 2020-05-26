<?php

namespace Models;

use function Helpers\getDatabaseConnection;




function sendAnnonce($titre,$desc,$codecat,$codeuser,$img1){
    $bdd = getDatabaseConnection();
    $query=$bdd->prepare("INSERT INTO annonce(Titre,Description,CodeCat,codeUser,IMAGE1) VALUES(:titre,:desc,:codecat,:codeuser,:img1)");
    $query->execute(["titre" => $titre,
        "desc" => $desc,
        "codecat"=> $codecat,
        "codeuser" => $codeuser,
        "img1" => $img1
    ]);
}

function getCategorie(){
    $bdd = getDatabaseConnection();
    $query=$bdd->prepare("SELECT IDCat, NomCat FROM categorieannonce");
    $query->execute();
    $result=$query->fetchAll();
    return $result;
}

?>