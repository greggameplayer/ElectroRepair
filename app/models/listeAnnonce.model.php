<?php
namespace Models;
use function Helpers\getDatabaseConnection;

function FiltreAnnonce(){
    $qFiltreAnnonce = getDatabaseConnection()->prepare("SELECT annonce.IDannonce, Titre, IMAGE1, IMAGE2, IMAGE3, Description, NOMCat, DateInscription, Nom, Prenom, CP, Ville, Adresse, ROUND(AVG(Note), 1) AS 'Moyenne' FROM categorieannonce, users, annonce LEFT JOIN comments ON annonce.IDannonce = comments.IDannonce WHERE categorieannonce.NomCat = :filtre AND annonce.CodeCat = categorieannonce.IDCat AND annonce.codeUser = users.IDuser GROUP BY annonce.IDannonce");
    switch ($_POST["gendre2"]){
        case 'telephoneNeDemarrePas':
        case 'telephoneNeChargePas':
        case 'telephoneNemetPlusDeSons':
        case 'ordinateurFixeNeDemarrePas':
        case 'ordinateurFixeNAfficheRien':
        case 'tabletteNeDemarrePas':
        case 'tabletteNemetPlusDeSons':
        case 'tabletteNeChargePas':
        case 'ordinateurPortableNeDemarrePas':
        case 'ordinateurPortableNeChargePas':
        case 'ordinateurPortableNemetPlusDeSons':
        case 'imprimanteMauvaiseCouleurs':
        case 'imprimanteNAcceptePlusLesCartouchesDEncre':
        case 'imprimanteEstBourre':
        case 'imprimanteNeFonctionnePLus':
            $qFiltreAnnonce->execute([
                "filtre" => $_POST['gendre2']
                ]);
            break;
        default:
            $qFiltreAnnonce->execute([
                "filtre" => $_POST['gendre3']
                ]);
            break;
    }
    return $qFiltreAnnonce->fetchAll();
}
?>