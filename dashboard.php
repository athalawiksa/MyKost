<?php
// Include security check
include 'cek-akses.php';
require 'cookie.php';

$pdo = include 'koneksi.php';

// Count available rooms
try {
    $stmt_available = $pdo->prepare("SELECT COUNT(*) as count FROM data_kamar WHERE status = 'Tersedia'");
    $stmt_available->execute();
    $available_rooms = $stmt_available->fetch(PDO::FETCH_ASSOC)['count'];
} catch (PDOException $e) {
    $available_rooms = 0;
    $error_message = "Error counting available rooms: " . $e->getMessage();
}

// Count total residents
try {
    $stmt_residents = $pdo->prepare("SELECT SUM(jumlah_penghuni) as count FROM data_kost");
    // $stmt_residents = $pdo->prepare("SELECT COUNT(*) as count FROM data_kost WHERE jumlah_penghuni");
    $stmt_residents->execute();
    $total_residents = $stmt_residents->fetch(PDO::FETCH_ASSOC)['count'];
} catch (PDOException $e) {
    $total_residents = 0;
    $error_message = "Error counting residents: " . $e->getMessage();
}

// Count unpaid rentals
try {
    $stmt_unpaid = $pdo->prepare("SELECT COUNT(*) as count FROM data_kost WHERE status_pembayaran = 'Belum Dibayar'");
    $stmt_unpaid->execute();
    $unpaid_count = $stmt_unpaid->fetch(PDO::FETCH_ASSOC)['count'];
} catch (PDOException $e) {
    $unpaid_count = 0;
    $error_message = "Error counting unpaid rentals: " . $e->getMessage();
}

// Data DP
try {
    $stmt_dp = $pdo->prepare("SELECT COUNT(*) as count FROM data_kost WHERE status_pembayaran = 'DP'");
    $stmt_dp->execute();
    $dp_count = $stmt_dp->fetch(PDO::FETCH_ASSOC)['count'];
} catch (PDOException $e) {
    $dp_count = 0;
    $error_message = "Error counting DP rentals: " . $e->getMessage();
}
//Data Nunggak
try {
    $stmt_nunggak = $pdo->prepare("SELECT COUNT(*) as count FROM data_kost WHERE status_pembayaran = 'Nunggak'");
    $stmt_nunggak->execute();
    $nunggak_count = $stmt_nunggak->fetch(PDO::FETCH_ASSOC)['count'];
} catch (PDOException $e) {
    $nunggak_count = 0;
    $error_message = "Error counting nunggak rentals: " . $e->getMessage();
}

// Count paid rentals
try {
    $stmt_paid = $pdo->prepare("SELECT COUNT(*) as count FROM data_kost WHERE status_pembayaran = 'Lunas'");
    $stmt_paid->execute();
    $paid_count = $stmt_paid->fetch(PDO::FETCH_ASSOC)['count'];
} catch (PDOException $e) {
    $paid_count = 0;
    $error_message = "Error counting paid rentals: " . $e->getMessage();
}

// Get recent rentals
try {
    $stmt_rentals = $pdo->prepare("SELECT s.*, k.nama_kost, p.nama_penghuni 
                                  FROM sewa_kamar s
                                  LEFT JOIN data_kamar k ON s.nama_kost = k.nama_kost
                                  LEFT JOIN data_penghuni p ON s.nama_penghuni = p.nama_penghuni
                                  ORDER BY s.tanggal_masuk DESC LIMIT 10");
    $stmt_rentals->execute();
    $rentals = $stmt_rentals->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $rentals = [];
    $error_message = "Error fetching rental data: " . $e->getMessage();
}


// Disini
try {
    $stmt_transactions = $pdo->prepare("
        SELECT 
            dk.nama_kost,
            dk.nama_penghuni,
            dk.no_kamar,
            dk.status_pembayaran,
            dk.tanggal_masuk,
            dk.tanggal_bayar,
            dk.jumlah_penghuni
        FROM 
            data_kost dk
        WHERE 
            dk.nama_kost IN ('Athala Kost', 'Griya Tara 2', 'Griya Tara 1')
        ORDER BY 
            dk.tanggal_masuk DESC
        LIMIT 50
    ");
    $stmt_transactions->execute();
    $transactions = $stmt_transactions->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $transactions = [];
    $error_message = "Error fetching transaction data: " . $e->getMessage();
}

// Calculate total income
try {
    $stmt_income = $pdo->prepare("
        SELECT SUM(k.harga) as total_income 
        FROM data_kost dk
        JOIN data_kamar k ON dk.nama_kost = k.nama_kost AND dk.no_kamar = k.no_kamar
        WHERE dk.status_pembayaran = 'Lunas'
    ");
    $stmt_income->execute();
    $total_income = $stmt_income->fetch(PDO::FETCH_ASSOC)['total_income'];
    if ($total_income === null) {
        $total_income = 0;
    }
} catch (PDOException $e) {
    $total_income = 0;
    $error_message = "Error calculating total income: " . $e->getMessage();
}

// Calculate monthly income
try {
    $currentMonth = date('m');
    $currentYear = date('Y');
    $stmt_monthly = $pdo->prepare("
        SELECT SUM(k.harga) as monthly_income 
        FROM data_kost dk
        JOIN data_kamar k ON dk.nama_kost = k.nama_kost AND dk.no_kamar = k.no_kamar
        WHERE dk.status_pembayaran = 'Lunas'
        AND MONTH(dk.tanggal_masuk) = :month
        AND YEAR(dk.tanggal_masuk) = :year
    ");
    $stmt_monthly->execute([
        'month' => $currentMonth,
        'year' => $currentYear
    ]);
    $monthly_income = $stmt_monthly->fetch(PDO::FETCH_ASSOC)['monthly_income'];
    if ($monthly_income === null) {
        $monthly_income = 0;
    }
} catch (PDOException $e) {
    $monthly_income = 0;
    $error_message = "Error calculating monthly income: " . $e->getMessage();
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
    <title>MyKost</title>
    <link rel="shortcut icon" href="uploads/asset/favicon.ico" type="image/x-icon">
    <link rel="icon" href="uploads/asset/circle.png" type="image/x-icon">
    <style>
        body {
            z-index: 2;
            display: flex;
            background-color: #f5f5f5;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .wann {
            margin-top: 80px;
            width: 90%;
            padding: 20px;
        }
        .card-custom {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            height: 100%;
        }
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 20px;
        }
        .card-body h3 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .card-body p {
            font-size: 16px;
            margin-bottom: 10px;
            opacity: 0.8;
        }
        .table {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            background-color: white;
            border-radius: 8px;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        .badge {
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 4px;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        h1, h3 {
            color: #333;
            font-weight: 600;
        }
        .bg-kembali {
            background-color: #28a745;
        }
        .bg-belum {
            background-color: #dc3545;
        }
        .icon-container {
            font-size: 2.5rem;
            opacity: 0.8;
            color: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 12px;
            margin-bottom: 10px;
        }
        .card-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-block;
        }
        .card-link:hover {
            color: white;
            transform: translateX(5px);
        }
        .stat-card {
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: rgba(255, 255, 255, 0.1);
            width: 100px;
            height: 100px;
            border-radius: 50%;
            z-index: 0;
        }
        .row-cols-4 > * {
            padding: 10px;
        }
        .subtitle {
            font-weight: 300;
            color: #6c757d;
            margin-bottom: 1.5rem;
        }
        .bg-info {
            background-color: #17a2b8 !important;
        }
        .text-info {
            color: #17a2b8 !important;
        }
        .bg-info .icon-container {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .stat-card .badge {
            position: absolute;
            /* bottom: 10px; */
            left: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .table-scroll {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        
        /* Styling untuk scrollbar */
        .table-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        .table-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-scroll::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .table-scroll::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Pastikan header tetap terlihat saat scroll */
        .table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <?php include 'navbar.php'; ?>
    <div class="wann">
        <h1><i class="bi bi-speedometer2 me-2"></i>Dashboard</h1>
        <p class="subtitle">Selamat datang di Sistem Manajemen Kost</p>
                
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
                
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="container-fluid p-0 mt-4">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3">
                <div class="col">
                    <div class="card text-white bg-primary mb-3 card-custom stat-card">
                        <div class="card-body">
                            <div class="icon-container bg-primary">
                                <i class="bi bi-door-open"></i>
                            </div>
                            <h3><?php echo $available_rooms; ?></h3>
                            <p>Kamar Tersedia</p>
                            <a href="datakamar.php" class="card-link">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white bg-warning mb-3 card-custom stat-card">
                        <div class="card-body">
                            <div class="icon-container bg-warning">
                                <i class="bi bi-people"></i>
                            </div>
                            <h3><?php echo $total_residents; ?></h3>
                            <p>Total Penghuni</p>
                            <a href="#" class="card-link text-warning">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white bg-danger mb-3 card-custom stat-card">
                        <div class="card-body">
                            <div class="icon-container bg-danger">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <h3><?php echo $nunggak_count; ?></h3>
                            <p>Nunggak</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white bg-danger mb-3 card-custom stat-card">
                        <div class="card-body">
                            <div class="icon-container bg-danger">
                                <i class="bi bi-cash"></i>
                            </div>
                            <h3><?php echo $unpaid_count; ?></h3>
                            <p>Belum Dibayar</p>
                            
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white bg-success mb-3 card-custom stat-card">
                        <div class="card-body">
                            <div class="icon-container bg-success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <h3><?php echo $paid_count; ?></h3>
                            <p>Lunas</p>
                            
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white bg-info mb-3 card-custom stat-card">
                        <div class="card-body">
                            <div class="icon-container bg-info">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <h3>Rp <?php echo number_format($total_income, 0, ',', '.'); ?></h3>
                            <p>Total Pendapatan</p>
                            <span class="badge bg-light text-info mb-2">Bulan ini: <?php echo date('F Y'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-custom">
                <div class="card-header">
                    <h5 class="card-title">Riwayat Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-scroll">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Kost</th>
                                        <th>Nama Penghuni</th>
                                        <th>No. Kamar</th>
                                        <th>Jumlah Penghuni</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Status Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($transactions) > 0): ?>
                                        <?php foreach ($transactions as $transaction): ?>
                                            <tr>
                                                <td>
                                                    <span class="fw-semibold">
                                                        <?php echo htmlspecialchars($transaction['nama_kost']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($transaction['nama_penghuni']); ?></td>
                                                <td><?php echo htmlspecialchars($transaction['no_kamar']); ?></td>
                                                <td><?php echo htmlspecialchars($transaction['jumlah_penghuni']); ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($transaction['tanggal_masuk'])); ?></td>
                                                <td>
                                                    <?php if ($transaction['status_pembayaran'] == 'Lunas' && !empty($transaction['tanggal_bayar']) && $transaction['tanggal_bayar'] != '0000-00-00'): ?>
                                                        <?php echo date('d-m-Y', strtotime($transaction['tanggal_bayar'])); ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($transaction['status_pembayaran'] == 'Lunas'): ?>
                                                        <span class="badge bg-success">Lunas</span>
                                                    <?php elseif ($transaction['status_pembayaran'] == 'DP'): ?>
                                                            <span class="badge bg-info">DP</span>
                                                    <?php elseif ($transaction['status_pembayaran'] == 'Nunggak'): ?>
                                                        <span class="badge bg-warning">Nunggak</span>
                                                        <button type="button" 
                                                            class="btn btn-sm btn-outline-success ms-1" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#bayarModal" 
                                                            data-nama-kost="<?php echo htmlspecialchars($transaction['nama_kost']); ?>" 
                                                            data-nama-penghuni="<?php echo htmlspecialchars($transaction['nama_penghuni']); ?>" 
                                                            data-no-kamar="<?php echo htmlspecialchars($transaction['no_kamar']); ?>">
                                                            <i class="bi bi-cash-coin"></i> Bayar
                                                        </button>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Belum Dibayar</span>
                                                        <button type="button" 
                                                            class="btn btn-sm btn-outline-success ms-1" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#bayarModal" 
                                                            data-nama-kost="<?php echo htmlspecialchars($transaction['nama_kost']); ?>" 
                                                            data-nama-penghuni="<?php echo htmlspecialchars($transaction['nama_penghuni']); ?>" 
                                                            data-no-kamar="<?php echo htmlspecialchars($transaction['no_kamar']); ?>">
                                                            <i class="bi bi-cash-coin"></i> Bayar
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data transaksi.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Ganti tombol reset yang ada di dashboard.php -->
                    <div class="text-end mt-3">
                        <a href="konfirmasi-reset.php" class="btn btn-danger btn-sm">
                            <i class="bi bi-arrow-repeat me-1"></i>Reset Status Pembayaran (Lunas)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bayarModalLabel">Update Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="proses-pembayaran.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="modal_nama_kost" name="nama_kost">
                        <input type="hidden" id="modal_nama_penghuni" name="nama_penghuni">
                        <input type="hidden" id="modal_no_kamar" name="no_kamar">
                        
                        <div class="mb-3">
                            <label for="tanggal_bayar" class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="keterangan_bayar" class="form-label">Keterangan (opsional)</label>
                            <textarea class="form-control" id="keterangan_bayar" name="keterangan_bayar" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>Konfirmasi Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <script>
        // Check for successful login
        <?php
        if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
            // Clear the flag to prevent showing the message again on refresh
            unset($_SESSION['login_success']);
        ?>
            // Show success alert
            Swal.fire({
                title: 'Berhasil',
                text: 'Berhasil Login!',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        <?php } ?>
    </script>
    
    <script>
        // Set modal data when payment button is clicked
        document.addEventListener('DOMContentLoaded', function() {
            const bayarModal = document.getElementById('bayarModal');
            if (bayarModal) {
                bayarModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const namaKost = button.getAttribute('data-nama-kost');
                    const namaPenghuni = button.getAttribute('data-nama-penghuni');
                    const noKamar = button.getAttribute('data-no-kamar');
                    
                    document.getElementById('modal_nama_kost').value = namaKost;
                    document.getElementById('modal_nama_penghuni').value = namaPenghuni;
                    document.getElementById('modal_no_kamar').value = noKamar;
                    
                    bayarModal.querySelector('.modal-title').textContent = 
                        'Update Pembayaran - ' + namaPenghuni + ' (Kamar ' + noKamar + ')';
                });
            }
        });
    </script>
</body>
</html>