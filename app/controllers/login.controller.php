<?php
namespace Controllers;

function getLoginController(){
    \Models\getUser($_POST["Email"], $_POST["Password"]);
}