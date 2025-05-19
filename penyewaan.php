
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>Kelola Penyewaan</title>
    <style>
        body {
            display: flex;
            background-color: #f5f5f5;
        }
        .wann {
            margin-top: 80px;
            width: 90%;
            padding: 20px;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-title {
            margin: 0;
            color: #333;
            font-weight: 600;
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        .badge {
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 4px;
        }
        .action-btn {
            width: 36px;
            height: 36px;
            padding: 6px;
            margin-right: 5px;
        }
        .btn-return {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .btn-return:hover {
            background-color: #218838;
            border-color: #1e7e34;
            color: white;
        }
        .btn-view {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }
        .btn-view:hover {
            background-color: #138496;
            border-color: #117a8b;
            color: white;
        }
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php' ?>
    <?php include 'navbar.php' ?>
    <div class="wann">
        <h1>Dashboard > Kelola Penyewaan</h1>
        
        <!-- Flash messages -->
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Data Penyewaan
                </h5>
            </div>
            <div class="card-body">
                <form method="post" action="" id="">
                    <div class="row">
                        <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Kost</label>
                                    <select class="form-select" id="" name="" required>
                                        <option value=""></option>
                                        <option value=""></option>
                                        <option value=""></option>
                                    </select>
                                </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Penghuni</label>
                                <input type="" class="form-control" id="" name="" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Jumlah Penghuni</label>
                                <input type="" class="form-control" id="" name="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Tanggal Masuk</label>
                                <input type="" class="form-control" id="" name="" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Tanggal Keluar</label>
                                <input type="" class="form-control" id="" name="" required>
                            </div>
                            <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-select" id="" name="" required>
                                        <option value=""></option>
                                        <option value=""></option>
                                    </select>
                            </div>
                            <input type="hidden" name="" value="">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <input type="hidden" name="" value="1">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-list-check me-2"></i>Data Penyewaan
                </h5>
                <div class="input-group" style="width: 300px;">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari data...">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kost</th>
                                <th>Nama Penghuni</th>
                                <th>Jumlah Penghuni</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td colspan="10" class="text-center">Belum ada data</td>
                                </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="d-flex">
                                                
                                                    <a href="" 
                                                       class="btn btn-return action-btn" 
                                                       title=""
                                                       onclick="return confirm('')">
                                                        <i class="bi bi-check-circle"></i>
                                                    </a>
                                                
                                                <button type="button" 
                                                        class="btn btn-view action-btn view-details" 
                                                        data-bs-toggle="" 
                                                        data-bs-target=""
                                                        
                                                        title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailModalLabel">Detail Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Nama Siswa</th>
                            <td width="60%" id="detail-nama"></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td id="detail-kelas"></td>
                        </tr>
                        <tr>
                            <th>Judul Buku</th>
                            <td id="detail-judul"></td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td id="detail-kategori"></td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td id="detail-jumlah"></td>
                        </tr>
                        <tr>
                            <th>Tanggal Peminjaman</th>
                            <td id="detail-pinjam"></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengembalian</th>
                            <td id="detail-kembali"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="detail-status"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="return-link" class="btn btn-success d-none">Kembalikan Buku</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>