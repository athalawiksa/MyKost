<?php 
$username = "root";
$password = "";
$host = "localhost";
$dbname = "Kostan";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo; 
    
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>