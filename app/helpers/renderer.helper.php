<?php
namespace Helpers;

function getRenderer(){
    $loader = new \Twig\Loader\FilesystemLoader('app/views');
    return new \Twig\Environment($loader);
}
