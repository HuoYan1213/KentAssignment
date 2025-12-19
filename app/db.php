<?php
$host = 'food-ordering-db.c2pbvsssbp8t.us-east-1.rds.amazonaws.com';
$dbname = 'ass';
$user = 'admin';
$pass = '12345678';

try {
    $_db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_TIMEOUT => 5
    ]);

} catch (PDOException $e) {
    die("<h1 style='color:red'>數據庫連接炸了: " . $e->getMessage() . "</h1>");
}