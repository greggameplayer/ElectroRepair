<?php
namespace Models;

function getRecaptchaKeys() {
    $reCaptchaConfigPath = "./reCaptcha.json";
    return file_get_contents($reCaptchaConfigPath);
}