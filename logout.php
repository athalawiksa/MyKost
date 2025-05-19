<?php 
session_start();
require 'koneksi.php';
require 'cookie.php';

// Hapus token dari database jika ada
if (isset($_SESSION['user_id'])) {
    try {
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("DELETE FROM user_tokens WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
    } catch (PDOException $e) {
        // Log error jika perlu
        error_log("Token deletion error: " . $e->getMessage());
    }
}

// Hapus cookie dengan mengatur waktu kedaluwarsa ke masa lalu
setcookie('mykost_session', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);

// Hapus semua data session seperti yang sudah Anda lakukan
$_SESSION['user'] = null;
unset($_SESSION['user']);
session_destroy();

header("Location: index.php");
exit;
?>