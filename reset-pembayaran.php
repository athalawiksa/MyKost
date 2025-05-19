<?php
// Include security check
include 'cek-akses.php';
require 'cookie.php';

$pdo = include 'koneksi.php';

// Tambahkan konfirmasi sebelum proses reset
if (!isset($_POST['confirm_reset'])) {
    // Redirect ke halaman konfirmasi
    $_SESSION['flash_type'] = 'warning';
    $_SESSION['flash_message'] = 'Silakan konfirmasi untuk melakukan reset status pembayaran.';
    header("Location: konfirmasi-reset.php");
    exit;
}

try {
    // Mulai transaksi untuk memastikan semua perubahan berhasil atau tidak sama sekali
    $pdo->beginTransaction();
    
    // Hanya update status "Lunas" menjadi "Belum Dibayar"
    // Status "DP" dan "Nunggak" tidak diubah
    $stmt = $pdo->prepare("
        UPDATE data_kost 
        SET status_pembayaran = 'Belum Dibayar', 
            tanggal_bayar = NULL
        WHERE status_pembayaran = 'Lunas'
    ");
    
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    
    // Commit transaksi jika berhasil
    $pdo->commit();
    
    // Set pesan sukses
    $_SESSION['flash_type'] = 'success';
    $_SESSION['flash_message'] = 'Berhasil mereset ' . $rowCount . ' kamar dengan status pembayaran Lunas.';
    
} catch (PDOException $e) {
    // Rollback jika terjadi error
    $pdo->rollBack();
    
    // Set pesan error
    $_SESSION['flash_type'] = 'danger';
    $_SESSION['flash_message'] = 'Gagal mereset status pembayaran: ' . $e->getMessage();
}

// Redirect kembali ke dashboard
header("Location: dashboard.php");
exit;
?>