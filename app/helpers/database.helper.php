<?php
namespace Helpers;
define("HOST","localhost:3306");
define("DB_NAME","electrorepair");
define("USER", "root");
define("PASSWORD","");
use PDO;
use PDOException;
function getDatabaseConnection()
{
    try {
        $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASSWORD);
        $db->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
        return $db;
    } catch (PDOException $e) {
       
        return $e;
    }
}
?>