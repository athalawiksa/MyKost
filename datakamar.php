<?php
// Include security check
include 'cek-akses.php';

// Include database connection
$pdo = include 'koneksi.php';

// Process form submission for adding data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    try {
        $nama_kost = $_POST['nama_kost'];
        $no_kamar = $_POST['no_kamar'];
        $harga = $_POST['harga'];
        $status = $_POST['status'];
        
        $stmt = $pdo->prepare("INSERT INTO data_kamar (nama_kost, no_kamar, harga, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama_kost, $no_kamar, $harga, $status]);
        
        $_SESSION['flash_message'] = "Data kamar berhasil ditambahkan!";
        $_SESSION['flash_type'] = "success";
    } catch (PDOException $e) {
        $_SESSION['flash_message'] = "Error: " . $e->getMessage();
        $_SESSION['flash_type'] = "danger";
    }
    
    header("Location: datakamar.php");
    exit;
}

// Process form submission for editing data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    try {
        $id = $_POST['id'];
        $nama_kost = $_POST['nama_kost'];
        $no_kamar = $_POST['no_kamar'];
        $harga = $_POST['harga'];
        $status = $_POST['status'];
        
        $stmt = $pdo->prepare("UPDATE data_kamar SET nama_kost = ?, no_kamar = ?, harga = ?, status = ? WHERE id = ?");
        $stmt->execute([$nama_kost, $no_kamar, $harga, $status, $id]);
        
        $_SESSION['flash_message'] = "Data kamar berhasil diperbarui!";
        $_SESSION['flash_type'] = "success";
    } catch (PDOException $e) {
        $_SESSION['flash_message'] = "Error: " . $e->getMessage();
        $_SESSION['flash_type'] = "danger";
    }
    
    header("Location: datakamar.php");
    exit;
}

// Process deletion
if (isset($_GET['delete'])) {
    try {
        $id = $_GET['delete'];
        
        $stmt = $pdo->prepare("DELETE FROM data_kamar WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['flash_message'] = "Data kamar berhasil dihapus!";
        $_SESSION['flash_type'] = "success";
    } catch (PDOException $e) {
        $_SESSION['flash_message'] = "Error: " . $e->getMessage();
        $_SESSION['flash_type'] = "danger";
    }
    
    header("Location: datakamar.php");
    exit;
}

// Fetch all data
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

if (!empty($search)) {
    // First get total count without limit for pagination
    $stmt_total = $pdo->prepare("SELECT COUNT(*) as total FROM data_kamar WHERE 
                          nama_kost LIKE ? OR 
                          no_kamar LIKE ? OR 
                          status LIKE ?");
    $searchParam = "%$search%";
    $stmt_total->execute([$searchParam, $searchParam, $searchParam]);
    $total_rows = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Then get data with limit - using direct limit in query rather than parameter
    $stmt = $pdo->prepare("SELECT * FROM data_kamar WHERE 
                          nama_kost LIKE ? OR 
                          no_kamar LIKE ? OR 
                          status LIKE ? 
                          ORDER BY id DESC LIMIT " . $limit);
    $stmt->execute([$searchParam, $searchParam, $searchParam]);
} else {
    // First get total count without limit for pagination
    $stmt_total = $pdo->query("SELECT COUNT(*) as total FROM data_kamar");
    $total_rows = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Then get data with limit - using direct limit in query rather than parameter
    $stmt = $pdo->query("SELECT * FROM data_kamar ORDER BY id DESC LIMIT " . $limit);
}

$data_kamar = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_rows = count($data_kamar);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kamar - Manajemen Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="uploads/asset/favicon.ico" type="image/x-icon">
    <link rel="icon" href="uploads/asset/circle.png" type="image/x-icon">
    <style>
        body {
            z-index: 2;
            display: flex;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .wann {
            margin-top: 80px;
            width: 90%;
        }
        .card {
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-title {
            margin: 0;
            color: #333;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #1a8cff;
            border-color: #1a8cff;
        }
        .btn-primary:hover {
            background-color: #0066cc;
            border-color: #0066cc;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        .pagination {
            margin-bottom: 0;
        }
        .dataTables_info {
            padding-top: 0.85em;
            font-size: 0.9rem;
            color: #6c757d;
        }
        .dataTables_filter, .dataTables_length {
            margin-bottom: 1rem;
        }
        .btn-edit, .btn-delete {
            width: 36px;
            height: 36px;
            padding: 6px;
        }
        .btn-edit {
            background-color: #00a65a;
            border-color: #00a65a;
        }
        .btn-delete {
            background-color: #dd4b39;
            border-color: #dd4b39;
        }
        .btn-edit:hover {
            background-color: #008d4c;
            border-color: #008d4c;
        }
        .btn-delete:hover {
            background-color: #c9302c;
            border-color: #c9302c;
        }
        .modal-header {
            padding: 0.5rem 1rem;
            background-color: #1a8cff;
            color: white;
        }
        .modal-header .btn-close {
            color: white;
        }
        .table-responsive {
            overflow-x: auto;
        }
        /* Style for table sorting icons */
        .sort-icon {
            font-size: 0.8rem;
            margin-left: 5px;
            color: #999;
        }
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; 
        }
        .alert {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <?php include 'navbar.php'; ?>
    <div class="wann">
    <h1>Dashboard > Data Kamar</h1>
    
    <!-- Flash messages -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['flash_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php 
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        ?>
    <?php endif; ?>
    
    
    <div class="modal-body">
        <div class="container-fluid">
            <div class="card-header mb-2">
                <h5 class="card-title">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKamarModal">
                        <i class="bi bi-plus"></i> Data Kamar
                    </button>
                </h5>
            </div>
            <div class="modal fade" id="addKamarModal" tabindex="-1" aria-labelledby="addKamarModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addKamarModalLabel">Tambah Data Kamar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form pengisian -->
                            <form method="post" action="datakamar.php" id="addKamarForm" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="add">
                                <div class="mb-3">
                                    <label for="nama_kost" class="form-label">Nama Kost</label>
                                    <select class="form-select" id="nama_kost" name="nama_kost" required>
                                        <option value="Athala Kost">Athala Kost</option>
                                        <option value="Griya Tara 2">Griya Tara 2</option>
                                        <option value="Griya Tara Pavilion">Griya Tara Pavilion</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="no_kamar" class="form-label">No Kamar</label>
                                    <input type="number" class="form-control" id="no_kamar" name="no_kamar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Terisi">Terisi</option>
                                        <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="editKamarModal" tabindex="-1" aria-labelledby="editKamarModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKamarModalLabel">Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form edit data -->
                            <form method="post" action="datakamar.php" id="editKamarForm" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" id="edit_id">
                                <div class="mb-3">
                                    <label for="edit_nama_kost" class="form-label">Nama Kost</label>
                                    <select class="form-select" id="edit_nama_kost" name="nama_kost" required>
                                        <option value="Athala Kost">Athala Kost</option>
                                        <option value="Griya Tara 2">Griya Tara 2</option>
                                        <option value="Griya Tara Pavilion">Griya Tara Pavilion</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_no_kamar" class="form-label">No Kamar</label>
                                    <input type="number" class="form-control" id="edit_no_kamar" name="no_kamar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" id="edit_harga" name="harga" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_status" class="form-label">Status</label>
                                    <select class="form-select" id="edit_status" name="status" required>
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Terisi">Terisi</option>
                                        <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                    </select>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <label class="me-2">Show</label>
                        <select class="form-select form-select-sm" style="width: 60px;" id="limitEntries" onchange="changeLimit(this.value)">
                            <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                            <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25</option>
                            <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                            <option value="100" <?php echo $limit == 100 ? 'selected' : ''; ?>>100</option>
                        </select>
                        <label class="ms-2">entries</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <form method="get" action="">
                        <div class="input-group">
                            <span class="input-group-text">Search:</span>
                            <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" aria-label="Search">
                            <button style="z-index: 0;" type="submit" class="btn btn-primary">Go</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kost</th>
                            <th>No Kamar</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($data_kamar) > 0): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($data_kamar as $kamar): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($kamar['nama_kost']); ?></td>
                                    <td><?php echo htmlspecialchars($kamar['no_kamar']); ?></td>
                                    <td>Rp <?php echo number_format($kamar['harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php 
                                        $status_badge = '';
                                        switch($kamar['status']) {
                                            case 'Tersedia':
                                                $status_badge = 'success';
                                                break;
                                            case 'Terisi':
                                                $status_badge = 'primary';
                                                break;
                                            case 'Dalam Perbaikan':
                                                $status_badge = 'warning';
                                                break;
                                            default:
                                                $status_badge = 'secondary';
                                        }
                                        ?>
                                        <span class="badge bg-<?php echo $status_badge; ?>"><?php echo htmlspecialchars($kamar['status']); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-edit me-2 bg-success btn-edit-kamar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editKamarModal"
                                                    data-id="<?php echo $kamar['id']; ?>"
                                                    data-nama-kost="<?php echo $kamar['nama_kost']; ?>"
                                                    data-no-kamar="<?php echo $kamar['no_kamar']; ?>"
                                                    data-harga="<?php echo $kamar['harga']; ?>"
                                                    data-status="<?php echo $kamar['status']; ?>"
                                                    title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="datakamar.php?delete=<?php echo $kamar['id']; ?>" 
                                               class="btn btn-delete bg-danger" 
                                               title="Delete"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data kamar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <p>Showing <?php echo count($data_kamar); ?> of <?php echo $total_rows; ?> entries</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
// JavaScript for handling the edit modal
document.addEventListener('DOMContentLoaded', function() {
    // Get all edit buttons
    const editButtons = document.querySelectorAll('.btn-edit-kamar');
    
    // Add event listener to each edit button
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get data attributes
            const id = this.getAttribute('data-id');
            const namaKost = this.getAttribute('data-nama-kost');
            const noKamar = this.getAttribute('data-no-kamar');
            const harga = this.getAttribute('data-harga');
            const status = this.getAttribute('data-status');
            
            // Set values in the edit form
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama_kost').value = namaKost;
            document.getElementById('edit_no_kamar').value = noKamar;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_status').value = status;
        });
    });

    // Function to change entries limit
    window.changeLimit = function(limit) {
        const currentUrl = new URL(window.location.href);
        const searchParams = currentUrl.searchParams;
        
        searchParams.set('limit', limit);
        
        window.location.href = currentUrl.toString();
    };
});
</script>

</body>
</html>