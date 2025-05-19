<?php
include 'cek-akses.php';
require 'cookie.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Tagihan - Manajemen Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="uploads/asset/favicon.ico" type="image/x-icon">
    <link rel="icon" href="uploads/asset/circle.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            padding: 0;
            margin: 0;
            z-index: 2;
            display: flex;
        }

        .wann {
            
            width: 90%;
            padding: 20px;
        }
        
        .container {
            padding: 30px 15px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .page-header {
            text-align: center;
            padding: 40px 0;
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            color: white;
            border-radius: 15px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .section {
            margin-bottom: 40px;
        }
        
        .section-title {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            padding-bottom: 15px;
            margin-bottom: 25px;
            border-bottom: 2px solid #e9ecef;
            color: #333;
            font-weight: 600;
        }
        
        .section-title i {
            margin-right: 15px;
            font-size: 2rem;
        }
        
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .bill-card {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 6px solid #ccc;
        }
        
        .bill-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .bill-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        
        .bill-number {
            font-family: 'Courier New', monospace;
            font-size: 1.2rem;
            font-weight: bold;
            letter-spacing: 1px;
            color: #555;
            padding: 8px 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
            display: inline-block;
            margin-top: 5px;
        }
        
        .copy-btn {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            font-size: 1.1rem;
            padding: 5px;
            margin-left: 10px;
            transition: color 0.3s;
        }
        
        .copy-btn:hover {
            color: #0d6efd;
        }
        
        .pln-card {
            border-left-color: #FFC107;
        }
        
        .pln-title {
            color: #FFC107;
        }
        
        .pam-card {
            border-left-color: #0DCAF0;
        }
        
        .pam-title {
            color: #0DCAF0;
        }
        
        .indihome-card {
            border-left-color: #DC3545;
        }
        
        .indihome-title {
            color: #DC3545;
        }
        
        .bill-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .bill-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .bill-info {
            flex-grow: 1;
        }
        
        .footer {
            text-align: center;
            margin-top: 60px;
            padding: 20px;
            color: #6c757d;
            font-size: 0.9rem;
            border-top: 1px solid #dee2e6;
        }
        
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .toast {
            background-color: #333;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-bottom: 10px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .toast.show {
            opacity: 1;
        }
        
        /* Alamat Card styles */
        .address-card {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 6px solid #4B6CB7;
            margin-bottom: 20px;
        }
        
        .address-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .address-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #4B6CB7;
        }
        
        .address-text {
            margin-bottom: 10px;
            line-height: 1.5;
        }
        
        .map-link {
            display: inline-block;
            color: #4B6CB7;
            text-decoration: none;
            padding: 8px 15px;
            background-color: rgba(75, 108, 183, 0.1);
            border-radius: 6px;
            margin-top: 10px;
            transition: all 0.3s;
        }
        
        .map-link:hover {
            background-color: rgba(75, 108, 183, 0.2);
            color: #344e86;
        }
        
        .map-link i {
            margin-right: 5px;
        }
        
        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
            
            .bill-card {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="wann">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Informasi ID Tagihan</h1>
                <p class="page-subtitle">Data pelanggan PLN, PAM, dan INDIHOME untuk properti kost</p>
            </div>
            
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-lightning-charge-fill" style="color: #FFC107;"></i>
                    PLN
                </h2>
                
                <div class="card-grid">
                    <div class="bill-card pln-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(255, 193, 7, 0.2);">
                                <i class="bi bi-building" style="color: #FFC107; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Athala Kost Paviliun</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">520551111323</span>
                            <button class="copy-btn" onclick="copyToClipboard('520551111323')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bill-card pln-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(255, 193, 7, 0.2);">
                                <i class="bi bi-building" style="color: #FFC107; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Athala Kost Barat</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">14405283707</span>
                            <button class="copy-btn" onclick="copyToClipboard('14405283707')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bill-card pln-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(255, 193, 7, 0.2);">
                                <i class="bi bi-building" style="color: #FFC107; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Griya Tara 2 Paviliun</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">520550615221</span>
                            <button class="copy-btn" onclick="copyToClipboard('520550615221')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bill-card pln-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(255, 193, 7, 0.2);">
                                <i class="bi bi-building" style="color: #FFC107; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Griya Tara 2 Lt. 1</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">520551467192</span>
                            <button class="copy-btn" onclick="copyToClipboard('520551467192')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bill-card pln-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(255, 193, 7, 0.2);">
                                <i class="bi bi-building" style="color: #FFC107; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Griya Tara 2 Pompa</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">56600369633</span>
                            <button class="copy-btn" onclick="copyToClipboard('56600369633')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-droplet-fill" style="color: #0DCAF0;"></i>
                    PAM
                </h2>
                
                <div class="card-grid">
                    <div class="bill-card pam-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(13, 202, 240, 0.2);">
                                <i class="bi bi-water" style="color: #0DCAF0; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Athala Kost</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">0201440612</span>
                            <button class="copy-btn" onclick="copyToClipboard('0201440612')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-wifi" style="color: #DC3545;"></i>
                    INDIHOME
                </h2>
                
                <div class="card-grid">
                    <div class="bill-card indihome-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(220, 53, 69, 0.2);">
                                <i class="bi bi-router" style="color: #DC3545; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Athala Kost</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">141528109412</span>
                            <button class="copy-btn" onclick="copyToClipboard('141528109412')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bill-card indihome-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(220, 53, 69, 0.2);">
                                <i class="bi bi-router" style="color: #DC3545; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Griya Tara 2</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">142528400958</span>
                            <button class="copy-btn" onclick="copyToClipboard('142528400958')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-wifi" style="color: #DC3545;"></i>
                    WiFi Password
                </h2>
                
                <div class="card-grid">
                    <div class="bill-card indihome-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(220, 53, 69, 0.2);">
                                <i class="bi bi-router" style="color: #DC3545; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Athala_Kost02</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">athalanew123</span>
                            <button class="copy-btn" onclick="copyToClipboard('athalanew123')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bill-card indihome-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(220, 53, 69, 0.2);">
                                <i class="bi bi-router" style="color: #DC3545; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Athala_Kost03</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">athalanew123</span>
                            <button class="copy-btn" onclick="copyToClipboard('athalanew123')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bill-card indihome-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(220, 53, 69, 0.2);">
                                <i class="bi bi-router" style="color: #DC3545; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Griya_Tara01</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">griyatara123</span>
                            <button class="copy-btn" onclick="copyToClipboard('griyatara123')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bill-card indihome-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(220, 53, 69, 0.2);">
                                <i class="bi bi-router" style="color: #DC3545; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Griya_Tara02</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">griyatara123</span>
                            <button class="copy-btn" onclick="copyToClipboard('griyatara123')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bill-card indihome-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(220, 53, 69, 0.2);">
                                <i class="bi bi-router" style="color: #DC3545; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Griya_Tara03</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">griyatara123</span>
                            <button class="copy-btn" onclick="copyToClipboard('griyatara123')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bill-card indihome-card">
                        <div class="bill-header">
                            <div class="bill-icon" style="background-color: rgba(220, 53, 69, 0.2);">
                                <i class="bi bi-router" style="color: #DC3545; font-size: 1.5rem;"></i>
                            </div>
                            <div class="bill-info">
                                <h3 class="bill-title">Griya Tara Pav</h3>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bill-number">221498pav</span>
                            <button class="copy-btn" onclick="copyToClipboard('221498pav')" title="Salin ID">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-geo-alt-fill" style="color: #4B6CB7;"></i>
                    ALAMAT
                </h2>
                
                <div class="address-card">
                    <h3 class="address-title">ATHALA KOST</h3>
                    <div class="d-flex align-items-center">
                        <p class="address-text mb-0">Jl. Krisna, RT 02 RW 12, Pucangan, Kartosuro, Sukoharjo, 57161</p>
                        <button class="copy-btn" onclick="copyToClipboard('Jl. Krisna, RT 02 RW 12, Pucangan, Kartosuro, Sukoharjo, 57161')" title="Salin Alamat">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <a href="https://maps.app.goo.gl/23Nxr7ztBhKLbZTy6" target="_blank" class="map-link">
                        <i class="bi bi-map"></i> Lihat di Google Maps
                    </a>
                </div>
                
                <div class="address-card">
                    <h3 class="address-title">GRIYA TARA 1</h3>
                    <div class="d-flex align-items-center">
                        <p class="address-text mb-0">Singopuran, RT 04 RW 1, Kartosuro, Sukoharjo, 57164</p>
                        <button class="copy-btn" onclick="copyToClipboard('Singopuran, RT 04 RW 1, Kartosuro, Sukoharjo, 57164')" title="Salin Alamat">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <a href="https://maps.app.goo.gl/qGup9pd4nNVPrQms6" target="_blank" class="map-link">
                        <i class="bi bi-map"></i> Lihat di Google Maps
                    </a>
                </div>
                
                <div class="address-card">
                    <h3 class="address-title">GRIYA TARA 2</h3>
                    <div class="d-flex align-items-center">
                        <p class="address-text mb-0">Jl. Wiroto, Gg III, RT 02 RW 01, Pucangan, Kartosuro, Sukoharjo, 57168</p>
                        <button class="copy-btn" onclick="copyToClipboard('Jl. Wiroto, Gg III, RT 02 RW 01, Pucangan, Kartosuro, Sukoharjo, 57168')" title="Salin Alamat">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <a href="https://maps.google.com/maps?q=-7.5546444%2C110.7358553&z=17&hl=id" target="_blank" class="map-link">
                        <i class="bi bi-map"></i> Lihat di Google Maps
                    </a>
                </div>
            </div>
            
            <div class="footer">
                <p>© <?php echo date('Y'); ?> Manajemen Kost. Semua Hak Dilindungi.</p>
            </div>
        </div>
        
        <div class="toast-container"></div>
    </div>
    
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showToast("ID berhasil disalin!");
            }, function() {
                showToast("Gagal menyalin ID.");
            });
        }
        
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.textContent = message;
            
            document.querySelector('.toast-container').appendChild(toast);
            
            setTimeout(function() {
                toast.classList.add('show');
            }, 10);
            
            setTimeout(function() {
                toast.classList.remove('show');
                setTimeout(function() {
                    toast.remove();
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>