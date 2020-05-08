<?php
namespace Helpers;
define("HOST","maritleawzvictor.mysql.db");
define("DB_NAME","maritleawzvictor");
define("USER", "maritleawzvictor");
define("PASSWORD","Electrorepair123456");
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
?>