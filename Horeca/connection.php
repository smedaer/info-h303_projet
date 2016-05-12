<?php

$dbhost = 'localhost';
$dbname=  'horeca';
$dbuser = 'root';
$dbpassword = '';
try {
    $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');
} catch (PDOException $e) {
    throw new PDOException("Error : " . $e->getMessage());
}
