<?php
namespace Helpers;
$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__.'/../../db.env');
define("HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("USER", $_ENV['DB_USER']);
define("PASSWORD", $_ENV['DB_PASS']);

define("HOST_SHARED", "epsi.nathanlemaitre.fr:3306");
define("DB_NAME_SHARED", "electrorepairSharedDB");
define("USER_SHARED", $_ENV['SHARED_DB_USER']);
define("PASSWORD_SHARED", $_ENV['SHARED_DB_PASS']);
use PDO;
use PDOException;
function getDatabaseConnection()
{
    try {
        $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $db->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
        return $db;
    } catch (PDOException $e) {

        return $e;
    }
}

function getSharedDatabaseConnection()
{
    try {
        $db = new PDO("mysql:host=" . HOST_SHARED . ";dbname=" . DB_NAME_SHARED, USER_SHARED, PASSWORD_SHARED, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $db->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
        return $db;
    } catch (PDOException $e) {

        return $e;
    }
}
?>
