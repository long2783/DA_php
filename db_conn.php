<?php

$sName  = "localhost";
$uName  = "root";
$pass   = "";
$db_name = "blog_db";

try {
    $conn = new PDO("mysql:host={$sName};dbname={$db_name};charset=utf8", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}
