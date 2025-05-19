<?php
// Include security check
include 'cek-akses.php';

// Include database connection
$pdo = include 'koneksi.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $nama_kost = isset($_POST['nama_kost']) ? trim($_POST['nama_kost']) : '';
    $nama_penghuni = isset($_POST['nama_penghuni']) ? trim($_POST['nama_penghuni']) : '';
    $no_kamar = isset($_POST['no_kamar']) ? trim($_POST['no_kamar']) : '';
    $tanggal_bayar = isset($_POST['tanggal_bayar']) ? $_POST['tanggal_bayar'] : '';
    $keterangan = isset($_POST['keterangan_bayar']) ? trim($_POST['keterangan_bayar']) : '';
    
    // Validate required fields
    if (empty($nama_kost) || empty($nama_penghuni) || empty($no_kamar) || empty($tanggal_bayar)) {
        $_SESSION['flash_message'] = "Semua field harus diisi!";
        $_SESSION['flash_type'] = "danger";
        header("Location: dashboard.php");
        exit;
    }
    
    try {
        // Begin transaction
        $pdo->beginTransaction();
        
        // Update payment date and status
        $stmt = $pdo->prepare("
            UPDATE data_kost 
            SET tanggal_bayar = :tanggal_bayar, 
                status_pembayaran = 'Lunas',
                keterangan = CASE 
                    WHEN :keterangan = '' THEN keterangan 
                    ELSE :keterangan 
                END
            WHERE nama_kost = :nama_kost 
            AND nama_penghuni = :nama_penghuni 
            AND no_kamar = :no_kamar
        ");
        
        $stmt->execute([
            'tanggal_bayar' => $tanggal_bayar,
            'keterangan' => $keterangan,
            'nama_kost' => $nama_kost,
            'nama_penghuni' => $nama_penghuni,
            'no_kamar' => $no_kamar
        ]);
        
        // Check if update was successful
        if ($stmt->rowCount() > 0) {
            // Log payment transaction (optional)
            $stmt_log = $pdo->prepare("
                INSERT INTO pembayaran_log 
                    (nama_kost, nama_penghuni, no_kamar, tanggal_bayar, tanggal_log, keterangan) 
                VALUES 
                    (:nama_kost, :nama_penghuni, :no_kamar, :tanggal_bayar, NOW(), :keterangan)
            ");
            
            // Try to log the transaction, but continue even if log fails
            try {
                $stmt_log->execute([
                    'nama_kost' => $nama_kost,
                    'nama_penghuni' => $nama_penghuni,
                    'no_kamar' => $no_kamar,
                    'tanggal_bayar' => $tanggal_bayar,
                    'keterangan' => $keterangan
                ]);
            } catch (PDOException $e) {
                // Just log error but continue with the process
                error_log("Error logging payment: " . $e->getMessage());
            }
            
            // Commit transaction
            $pdo->commit();
            
            // Set success message
            $_SESSION['flash_message'] = "Pembayaran untuk $nama_penghuni kamar $no_kamar berhasil dikonfirmasi.";
            $_SESSION['flash_type'] = "success";
        } else {
            // Rollback transaction
            $pdo->rollBack();
            
            // Set error message
            $_SESSION['flash_message'] = "Data tidak ditemukan atau tidak ada perubahan.";
            $_SESSION['flash_type'] = "warning";
        }
    } catch (PDOException $e) {
        // Rollback transaction
        $pdo->rollBack();
        
        // Set error message
        $_SESSION['flash_message'] = "Error saat memproses pembayaran: " . $e->getMessage();
        $_SESSION['flash_type'] = "danger";
    }
} else {
    // If accessed directly without POST
    $_SESSION['flash_message'] = "Akses tidak valid.";
    $_SESSION['flash_type'] = "danger";
}

// Redirect back to dashboard
header("Location: dashboard.php");
exit;
?>