<?php
try {
        $_db = new PDO('mysql:dbname=ass;host=food-ordering-db.c2pbvsssbp8t.us-east-1.rds.amazonaws.com;charset=utf8mb4', 'admin', '12345678', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ]);
} catch (PDOException $e) {
    die('database connect fail: ' . $e->getMessage());
}
