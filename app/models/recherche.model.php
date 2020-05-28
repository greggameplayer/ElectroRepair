<?php 
namespace Models;
use function Helpers\getDatabaseConnection;

function getAnnonce($search){
    $bdd=getDatabaseConnection();
    $query =$bdd->prepare("SELECT annonce.IDannonce, Titre, IMAGE1, IMAGE2, IMAGE3, Description, NOMCat, DateInscription, Nom, Prenom, CP, Ville, Adresse, ROUND(AVG(Note), 1) AS 'Moyenne', intervalstart, intervalend FROM categorieannonce, users, annonce LEFT JOIN comments ON annonce.IDannonce = comments.IDannonce WHERE annonce.Description LIKE :recherche AND annonce.CodeCat = categorieannonce.IDCat AND annonce.codeUser = users.IDuser GROUP BY annonce.IDannonce");
    $query->execute([
        "recherche" => '%'.$search.'%'
    ]);
    $result=$query->fetchAll();
    return $result;
}

function getGoodAnnonce($value){
    $bdd=getDatabaseConnection();
    $query =$bdd->prepare(" SELECT annonce.IDannonce, Titre, IMAGE1, IMAGE2, IMAGE3, Description, NOMCat, DateInscription, Nom, Prenom, CP, Ville, Adresse, ROUND(AVG(Note), 1) AS 'Moyenne', intervalstart, intervalend FROM categorieannonce, users, annonce LEFT JOIN comments ON annonce.IDannonce = comments.IDannonce WHERE annonce.IDannonce= :valeur AND annonce.CodeCat = categorieannonce.IDCat AND annonce.codeUser = users.IDuser GROUP BY annonce.IDannonce");
    $query->execute([
        "valeur" => $value
        ]);
    $result=$query->fetchAll();
    return $result;
}