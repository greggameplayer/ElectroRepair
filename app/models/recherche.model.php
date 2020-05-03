<?php 
namespace Models;
use function Helpers\getDatabaseConnection;

function getAnnonce($search){
    $bdd=getDatabaseConnection();
    $query =$bdd->prepare("select * from annonce where annonce.Description LIKE '%$search%'");
    $query->execute();
    $result=$query->fetchAll();
    return $result;
}

function getGoodAnnonce($value){
    $bdd=getDatabaseConnection();
    $query =$bdd->prepare("select * from annonce where annonce.IDannonce=$value");
    $query->execute();
    $result=$query->fetchAll();
    return $result;
}