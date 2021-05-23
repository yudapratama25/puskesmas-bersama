<?php

session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");

$host       = 'localhost';
$username   = 'root';
$password   = '';
$db         = 'my_puskesmas';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
} catch (PDOException $a) {
    die("Terjadi Masalah: " . $a->getMessage());
}