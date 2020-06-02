<?php
namespace Controllers;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use function Helpers\getRenderer;
use function Models\getAllNotifs;
use function Models\getAnnonce;
use function Models\getGoodAnnonce;
use function Models\FiltreAnnonce;

function getContactController(){
    if(isset($_SESSION["id"])){
        $twig = getRenderer();
        echo $twig->render('contact.html', ["Session" => $_SESSION["id"], "Group" => $_SESSION["group"], "Notifs" => getAllNotifs($_SESSION['id'])]);
    }else {
        $twig = getRenderer();
        echo $twig->render('contact.html');
    }
}

function sendMail(){
    if(isset($_POST["mailform"])){
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("contact@electrorepair.com", "Electro Repair");
        $email->setSubject("Contact");
        $email->addTo($_POST["email"], "Utilisateur");
        $email->addContent("text/plain", $_POST["subject"]);
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }
    if(isset($_SESSION["id"])){
        $twig = getRenderer();
        echo $twig->render('homepage.html', ["Session" => $_SESSION["id"], "Group" => $_SESSION["group"], "Notifs" => getAllNotifs($_SESSION['id'])]);
    }else {
        $twig = getRenderer();
        echo $twig->render('homepage.html');
    }
}

function getAproposController(){
    if(isset($_SESSION["id"])) {
        $twig = getRenderer();
        echo $twig->render('aPropos.html', ["Session" => $_SESSION["id"], "Group" => $_SESSION["group"], "Notifs" => getAllNotifs($_SESSION['id'])]);
    }else{
        $twig = getRenderer();
        echo $twig->render('aPropos.html');
    }
}

function getCGUController(){
    if(isset($_SESSION["id"])) {
        $twig = getRenderer();
        echo $twig->render('CGU.html', ["Session" => $_SESSION["id"], "Group" => $_SESSION["group"], "Notifs" => getAllNotifs($_SESSION['id'])]);
    }else{
        $twig = getRenderer();
        echo $twig->render('CGU.html');
    }
}


function getResultatController(){
    $recherche=$_POST['problème'];
    if(isset($_SESSION["id"])){
        echo getRenderer()->render('resultat_recherche.html',[
            "AllAnnonce" => getAnnonce($recherche),
            "Session" => $_SESSION["id"],
            "Group" => $_SESSION["group"],
            "Notifs" => getAllNotifs($_SESSION['id'])
        ]);
    }else {
        echo getRenderer()->render('resultat_recherche.html',[
            "AllAnnonce" => getAnnonce($recherche)
        ]);
    }
}

function getAnnonceController($value=0){
    if(isset($_GET['annonce'])) {
        $value = $_GET['annonce'];
    }
    if(isset($_SESSION["id"])){
        echo getRenderer()->render('afficheAnnonce.html',[
            "Myannonce" => getGoodAnnonce($value),
            "Session" => $_SESSION["id"],
            "Group" => $_SESSION["group"],
            "Comments" => \Models\getComments($value),
            "Notifs" => getAllNotifs($_SESSION['id'])
        ]);
    }else {
        getHomepageController();
        sleep(1);
        echo "<script>alert(\"veuillez-vous connecter pour voir le détail de l'annonce !\");</script>";
    }
}

function getResultatQuestionnaireController(){
    if(isset($_SESSION["id"])) {
        echo getRenderer()->render('resultat_recherche.html', [
            "AllAnnonce" => FiltreAnnonce(),
            "Session" => $_SESSION["id"],
            "Group" => $_SESSION["group"],
            "Notifs" => getAllNotifs($_SESSION['id'])
        ]);
    }else{
        echo getRenderer()->render('resultat_recherche.html', [
            "AllAnnonce" => FiltreAnnonce()
        ]);
    }
}
