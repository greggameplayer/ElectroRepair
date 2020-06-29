<?php

namespace Models;

use function Helpers\getDatabaseConnection;



function sendAnnonce($titre,$desc,$codecat,$codeuser,$img1='https://www.autronix.fr/_media/img/large/2-electronique-haute-resolution.jpg',$intervalstart,$intervalend){
    $bdd = getDatabaseConnection();
    $query=$bdd->prepare("INSERT INTO annonce(Titre,Description,CodeCat,codeUser,IMAGE1,intervalstart, intervalend ) VALUES (:titre,:desc,:codecat,:codeuser,:img1,:intstart,:intend)");
    $query->execute(["titre" => $titre,
        "desc" => $desc,
        "codecat"=> $codecat,
        "codeuser" => $codeuser,
        "img1" => $img1,
        "intstart" => $intervalstart,
        "intend" => $intervalend
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