<?php
$host = 'localhost';
$db   = 'praktikum7'; // nama database kamu
$user = 'root';       // sesuaikan dengan MySQL kamu
$pass = '';           // default kosong jika pakai XAMPP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
