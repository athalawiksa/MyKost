<?php
session_start();
require 'koneksi.php';
require 'cookie.php'; // Include file cookie.php

$error = ""; 

// Jika user sudah login (melalui session atau cookie), redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Cek apakah "Remember Me" dicentang
    $remember_me = isset($_POST['remember_me']) ? true : false;

    if (empty($email) || empty($password)) {
        $error = "Email dan password harus diisi.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    
                    // Jika "Remember Me" dicentang, buat cookie persisten
                    if ($remember_me) {
                        createPersistentCookie($user['id'], $user['email']);
                    }
                    
                    // Set successful login flag for SweetAlert
                    $_SESSION['login_success'] = true;
                    
                    header("Location: dashboard.php");
                    exit;
                } else {
                    // Set error for SweetAlert
                    $_SESSION['login_error'] = 'Password salah.';
                    $error = "Password salah.";
                }
            } else {
                // Set error for SweetAlert
                $_SESSION['login_error'] = 'Email tidak ditemukan.';
                $error = "Email tidak ditemukan.";
            }
        } catch (PDOException $e) {
            // Set error for SweetAlert
            $_SESSION['login_error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            $error = "Terjadi kesalahan: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyKost: Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="uploads/asset/favicon.ico" type="image/x-icon">
    <link rel="icon" href="uploads/asset/circle.png" type="image/x-icon">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <style>
        :root {
            --primary-color: #1a8cff;
            --primary-dark: #0066cc;
            --secondary-color: #5a6268;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --success-color: #28a745;
            --danger-color: #dc3545;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            background-image: url('data:image/svg+xml,%3Csvg width="52" height="26" viewBox="0 0 52 26" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.05"%3E%3Cpath d="M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 15px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 25px 15px;
            border-bottom: none;
        }
        
        .card-header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-label {
            font-weight: 500;
            font-size: 14px;
            color: var(--secondary-color);
        }
        
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e1e5eb;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(26, 140, 255, 0.15);
        }
        
        .input-group-text {
            background-color: transparent;
            border-right: none;
            cursor: pointer;
        }
        
        .form-control.password {
            border-left: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 15px;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .alert {
            border-radius: 8px;
            font-size: 14px;
            padding: 15px;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .logo {
            height: 60px;
            width: auto;
        }
        
        .form-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--secondary-color);
        }
        
        .form-check-label {
            font-size: 14px;
            color: var(--secondary-color);
        }
        
        @media (max-width: 576px) {
            .login-container {
                padding: 0;
            }
            
            .card {
                border-radius: 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    

<div class="login-container">
        <div class="logo-container">
            <!-- Replace with your logo or use text logo -->
            <h1 class="text-white mb-3"><i class="bi bi-house-door-fill"></i> MyKost</h1>
        </div>
        
        <div class="card">
            <div class="card-header">

                <h1>Selamat Datang</h1>
                <p class="mb-0">Silahkan login untuk mengelola kost Anda</p>
            </div>
            
            <div class="card-body">
                <form method="post" action="" id="loginForm">
                    <div class="mb-4">
                        <label class="form-label" for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-light">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" class="form-control border-start-0" id="email" name="email" placeholder="Masukkan email Anda" required/>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-light">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Masukkan password Anda" required/>
                            <span class="input-group-text border-start-0 bg-light" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Tambahkan checkbox "Remember Me" -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                        <label class="form-check-label" for="remember_me">Ingat saya</label>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </button>
                    </div>
                </form>
                
                <div class="form-footer">
                    <p>© <?php echo date('Y'); ?> MyKost. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
        
        // Display SweetAlert for errors
        <?php if (!empty($error)): ?>
        Swal.fire({
            title: 'Gagal',
            text: '<?php echo addslashes($error); ?>',
            icon: 'error',
            showConfirmButton: true,
            timer: 3000,
            timerProgressBar: true
        });
        <?php endif; ?>
        
        // Submit form with SweetAlert
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            // Log remember_me checkbox status (untuk debugging)
            console.log("Remember Me status:", document.getElementById('remember_me').checked);
            
            // Form will still submit normally, but we'll show a loading indicator
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    </script>
</body>
</html>