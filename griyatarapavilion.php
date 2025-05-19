<?php
// Include security check
include 'cek-akses.php';
require 'cookie.php';

// Include database connection
$pdo = include 'koneksi.php';

// Include common functions
include 'kost-base.php';

// Process form submissions and redirects
$redirect = false;
$redirect |= processAdd($pdo);
$redirect |= processEdit($pdo);
$redirect |= processDelete($pdo);

if ($redirect) {
    header("Location: griyatarapavilion.php");
    exit;
}

// Set the kost name for this page
$nama_kost = 'Griya Tara 1';

// Fetch available rooms
$available_rooms = getAvailableRooms($pdo, $nama_kost);

// Fetch all data
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

$data_kost = getKostData($pdo, $nama_kost, $search, $limit);
$total_rows = count($data_kost);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyKost</title>
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
        .penghuni-img {
            width: 100px;
            object-fit: cover;
        }
        .status-badge {
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <?php include 'navbar.php'; ?>
    <div class="wann">
    <h1>MyKost: Griya Tara 1</h1>
    
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
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKostModal">
                        <i class="bi bi-plus"></i> Data Kost
                    </button>
                </h5>
            </div>
            <div class="modal fade" id="addKostModal" tabindex="-1" aria-labelledby="addKostModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addKostModalLabel">Tambah Data Kost</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form pengisian -->
                            <form method="post" action="griyatarapavilion.php" id="addKostForm" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="nama_kost" value="<?php echo $nama_kost; ?>">
                                
                                <div class="mb-3">
                                    <label for="foto_penghuni" class="form-label">Foto Penghuni</label>
                                    <input type="file" class="form-control" id="foto_penghuni" name="foto_penghuni" accept="image/*">
                                    <div class="form-text">Upload foto penghuni (JPG, PNG, GIF, maksimal 2MB)</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="jumlah_penghuni" class="form-label">Jumlah Penghuni</label>
                                    <input type="number" class="form-control" id="jumlah_penghuni" name="jumlah_penghuni" required min="1">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="nama_penghuni" class="form-label">Nama Penghuni</label>
                                    <input type="text" class="form-control" id="nama_penghuni" name="nama_penghuni" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No HP</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="no_kamar" class="form-label">No Kamar</label>
                                    <select class="form-control" id="no_kamar" name="no_kamar" required>
                                        <option value="">Pilih Kamar</option>
                                        <?php foreach ($available_rooms as $room): ?>
                                            <option value="<?php echo $room['no_kamar']; ?>">
                                                Kamar <?php echo $room['no_kamar']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                                    <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                                    <select class="form-select" id="status_pembayaran" name="status_pembayaran" required>
                                        <option value="Lunas">Lunas</option>
                                        <option value="Belum Dibayar">Belum Dibayar</option>
                                        <option value="Nunggak">Nunggak</option>
                                        <option value="DP">DP</option>
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
            
            <div class="modal fade" id="editKostModal" tabindex="-1" aria-labelledby="editKostModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKostModalLabel">Edit Data Kost</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form edit data -->
                            <form method="post" action="griyatarapavilion.php" id="editKostForm" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" id="edit_id">
                                <input type="hidden" name="nama_kost" value="<?php echo $nama_kost; ?>">
                                <input type="hidden" name="no_kamar_lama" id="edit_no_kamar_lama">
                                <input type="hidden" name="foto_existing" id="edit_foto_existing">
                                
                                <div class="mb-3">
                                    <label class="form-label">Foto Saat Ini</label>
                                    <div id="current_photo_container" class="mb-2">
                                        <img id="current_photo" src="" alt="Foto Penghuni" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_foto_penghuni" class="form-label">Ganti Foto</label>
                                    <input type="file" class="form-control" id="edit_foto_penghuni" name="foto_penghuni" accept="image/*">
                                    <div class="form-text">Upload foto penghuni baru (JPG, PNG, GIF, maksimal 2MB)</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_jumlah_penghuni" class="form-label">Jumlah Penghuni</label>
                                    <input type="number" class="form-control" id="edit_jumlah_penghuni" name="jumlah_penghuni" required min="1">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_nama_penghuni" class="form-label">Nama Penghuni</label>
                                    <input type="text" class="form-control" id="edit_nama_penghuni" name="nama_penghuni" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_no_hp" class="form-label">No HP</label>
                                    <input type="text" class="form-control" id="edit_no_hp" name="no_hp" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_no_kamar" class="form-label">No Kamar</label>
                                    <input type="number" class="form-control" id="edit_no_kamar" name="no_kamar" required>
                                    <div class="form-text">Jika ingin pindah kamar, pastikan kamar tersedia di Data Kamar</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_tanggal_masuk" class="form-label">Tanggal Masuk</label>
                                    <input type="date" class="form-control" id="edit_tanggal_masuk" name="tanggal_masuk" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_status_pembayaran" class="form-label">Status Pembayaran</label>
                                    <select class="form-select" id="edit_status_pembayaran" name="status_pembayaran" required>
                                        <option value="Lunas">Lunas</option>
                                        <option value="Belum Dibayar">Belum Dibayar</option>
                                        <option value="Nunggak">Nunggak</option>
                                        <option value="DP">DP</option>
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
                            <th>Foto Penghuni</th>
                            <th>Jumlah Penghuni</th>
                            <th>Nama Penghuni</th>
                            <th>No HP</th>
                            <th>No Kamar</th>
                            <th>Tanggal Masuk</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($data_kost) > 0): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($data_kost as $kost): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <?php if (!empty($kost['foto_penghuni']) && file_exists($kost['foto_penghuni'])): ?>
                                            <img src="<?php echo $kost['foto_penghuni']; ?>" alt="Foto <?php echo htmlspecialchars($kost['nama_penghuni']); ?>" class="penghuni-img">
                                        <?php else: ?>
                                            <img src="uploads/default-user.png" alt="Default" class="penghuni-img">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($kost['jumlah_penghuni']); ?></td>
                                    <td><?php echo htmlspecialchars($kost['nama_penghuni']); ?></td>
                                    <td><?php echo htmlspecialchars($kost['no_hp']); ?></td>
                                    <td><?php echo htmlspecialchars($kost['no_kamar']); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($kost['tanggal_masuk'])); ?></td>
                                    <td>
                                        <?php if ($kost['status_pembayaran'] == 'Lunas'): ?>
                                            <span class="badge bg-success status-badge">Lunas</span>
                                        <?php elseif ($kost['status_pembayaran'] == 'Nunggak'): ?>
                                            <span class="badge bg-warning status-badge">Nunggak</span>
                                        <?php elseif ($kost['status_pembayaran'] == 'DP'): ?>
                                            <span class="badge bg-info status-badge">DP</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger status-badge">Belum Dibayar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-edit me-2 bg-success btn-edit-kost" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editKostModal"
                                                    data-id="<?php echo $kost['id']; ?>"
                                                    data-foto-penghuni="<?php echo $kost['foto_penghuni']; ?>"
                                                    data-jumlah-penghuni="<?php echo $kost['jumlah_penghuni']; ?>"
                                                    data-nama-penghuni="<?php echo $kost['nama_penghuni']; ?>"
                                                    data-no-hp="<?php echo $kost['no_hp']; ?>"
                                                    data-no-kamar="<?php echo $kost['no_kamar']; ?>"
                                                    data-tanggal-masuk="<?php echo $kost['tanggal_masuk']; ?>"
                                                    data-status-pembayaran="<?php echo $kost['status_pembayaran']; ?>"
                                                    title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="griyatarapavilion.php?delete=<?php echo $kost['id']; ?>" 
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
                                <td colspan="9" class="text-center">Tidak ada data kost.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <p>Showing <?php echo count($data_kost); ?> of <?php echo $total_rows; ?> entries</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imageViewerModal" tabindex="-1" aria-labelledby="imageViewerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageViewerModalLabel">Foto Penghuni</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="enlargedImage" src="" alt="Foto Penghuni" class="img-fluid">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    const editButtons = document.querySelectorAll('.btn-edit-kost');
    
    // Add event listener to each edit button
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get data attributes
            const id = this.getAttribute('data-id');
            const fotoPenghuni = this.getAttribute('data-foto-penghuni');
            const jumlahPenghuni = this.getAttribute('data-jumlah-penghuni');
            const namaPenghuni = this.getAttribute('data-nama-penghuni');
            const noHp = this.getAttribute('data-no-hp');
            const noKamar = this.getAttribute('data-no-kamar');
            const tanggalMasuk = this.getAttribute('data-tanggal-masuk');
            const statusPembayaran = this.getAttribute('data-status-pembayaran');
            
            // Set values in the edit form
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_jumlah_penghuni').value = jumlahPenghuni;
            document.getElementById('edit_nama_penghuni').value = namaPenghuni;
            document.getElementById('edit_no_hp').value = noHp;
            document.getElementById('edit_no_kamar').value = noKamar;
            document.getElementById('edit_no_kamar_lama').value = noKamar;
            document.getElementById('edit_tanggal_masuk').value = tanggalMasuk;
            document.getElementById('edit_status_pembayaran').value = statusPembayaran;
            document.getElementById('edit_foto_existing').value = fotoPenghuni;
            
            // Handle photo display
            const currentPhoto = document.getElementById('current_photo');
            const photoContainer = document.getElementById('current_photo_container');
            
            if (fotoPenghuni && fotoPenghuni !== '') {
                currentPhoto.src = fotoPenghuni;
                photoContainer.style.display = 'block';
            } else {
                currentPhoto.src = 'uploads/default-user.png';
                photoContainer.style.display = 'block';
            }
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
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Get all resident photos
  const residentPhotos = document.querySelectorAll('.penghuni-img');
  
  // Add click event listener to each photo
  residentPhotos.forEach(photo => {
    photo.style.cursor = 'pointer'; // Change cursor to indicate clickable
    photo.title = "Klik untuk memperbesar"; // Add tooltip
    
    photo.addEventListener('click', function() {
      // Get the source of the clicked image
      const imgSrc = this.src;
      const altText = this.alt;
      
      // Set the image source in the modal
      const enlargedImage = document.getElementById('enlargedImage');
      enlargedImage.src = imgSrc;
      enlargedImage.alt = altText;
      
      // Update modal title with resident name if available
      const modalTitle = document.getElementById('imageViewerModalLabel');
      if (altText.startsWith('Foto ')) {
        modalTitle.textContent = altText;
      } else {
        modalTitle.textContent = 'Foto Penghuni';
      }
      
      // Show the modal
      const imageModal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
      imageModal.show();
    });
  });
});

</script>

</body>
</html>