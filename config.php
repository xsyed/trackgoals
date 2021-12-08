<?php
require 'controller/Friend.class.php';

$dsn = 'mysql:dbname=dev_trackgoals;host=localhost';
$user = 'root';
$password = '';
date_default_timezone_set('America/Toronto'); // EST
$frnd_obj = "";

try
{
    $pdo = new PDO($dsn,$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $frnd_obj = new Friend($pdo);
}
catch(PDOException $e)
{
    echo "PDO error".$e->getMessage();
    die();
}
?>