<?php
// Include security check
include 'cek-akses.php';
require 'cookie.php';

$pdo = include 'koneksi.php';

// Hitung jumlah kamar dengan status Lunas
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM data_kost WHERE status_pembayaran = 'Lunas'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $lunas_count = $result['count'];
} catch (PDOException $e) {
    $lunas_count = 0;
    $error_message = "Error counting rooms: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <title>Konfirmasi Reset Pembayaran - MyKost</title>
    <link rel="shortcut icon" href="uploads/asset/favicon.ico" type="image/x-icon">
    <link rel="icon" href="uploads/asset/circle.png" type="image/x-icon">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .wann {
            margin-top: 80px;
            width: 90%;
            padding: 20px;
        }
        .card-custom {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .icon-warning {
            font-size: 3rem;
            color: #ffc107;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    
    <?php include 'navbar.php'; ?>
    
    <div class="wann">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-custom">
                        <div class="card-body text-center p-5">
                            <i class="bi bi-exclamation-triangle icon-warning"></i>
                            <h2 class="mb-3">Konfirmasi Reset Status Pembayaran</h2>
                            
                            <p class="mb-4">
                                Anda akan mereset status pembayaran <strong>HANYA</strong> untuk kamar berstatus <span class="badge bg-success">Lunas</span> menjadi <span class="badge bg-danger">Belum Dibayar</span>.
                            </p>
                            
                            <div class="alert alert-info">
                                <p class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Terdapat <strong><?php echo $lunas_count; ?> kamar</strong> dengan status Lunas yang akan direset.
                                </p>
                            </div>
                            
                            <div class="alert alert-warning">
                                <p class="mb-0">
                                    <i class="bi bi-shield-exclamation me-2"></i>
                                    Kamar dengan status <span class="badge bg-info">DP</span> dan <span class="badge bg-warning">Nunggak</span> tidak akan terpengaruh.
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <a href="dashboard.php" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Batal
                                </a>
                                
                                <form action="reset-pembayaran.php" method="post">
                                    <input type="hidden" name="confirm_reset" value="1">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-arrow-repeat me-2"></i>Reset Status Pembayaran
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show mt-3" role="alert">
                            <?php echo $_SESSION['flash_message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php 
                        unset($_SESSION['flash_message']);
                        unset($_SESSION['flash_type']);
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
</body>
</html>