<?php
// الاتصال بقاعدة البيانات
$dsn = "mysql:host=localhost;dbname=dlms;charset=utf8mb4";
$username = "root";
$password = "Ammar999?";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
