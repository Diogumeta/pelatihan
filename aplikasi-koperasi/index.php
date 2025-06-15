<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Koperasi Pegawai</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"  rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        <img src="assets/emyu.png" alt="Logo Koperasi" width="100">
        <h4 class="text-white">KOPERASI MU</h4>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="pelanggan/list_pelanggan.php" class="nav-link text-white"><i class="fas fa-users"></i> Pelanggan</a>
        </li>
        <li class="nav-item">
            <a href="barang/list_barang.php" class="nav-link text-white"><i class="fas fa-boxes"></i> Barang</a>
        </li>
        <li class="nav-item">
            <a href="transaksi/buat_transaksi.php" class="nav-link text-white"><i class="fas fa-cart-plus"></i> Buat Transaksi</a>
        </li>
        <li class="nav-item">
            <a href="transaksi/list_transaksi.php" class="nav-link text-white"><i class="fas fa-list"></i> Daftar Transaksi</a>
        </li>
        <li class="nav-item">
            <a href="petugas/logout.php" class="nav-link text-white"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
    </ul>
</div>

<!-- Content -->
<div class="content">
    <h2 class="mb-4">Selamat Datang di Aplikasi Koperasi Pegawai</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Pelanggan</h5>
                    <p class="card-text">Kelola data pelanggan.</p>
                    <a href="pelanggan/list_pelanggan.php" class="btn btn-primary">Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Barang</h5>
                    <p class="card-text">Kelola stok barang.</p>
                    <a href="barang/list_barang.php" class="btn btn-primary">Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Transaksi</h5>
                    <p class="card-text">Buat dan lihat transaksi.</p>
                    <a href="transaksi/list_transaksi.php" class="btn btn-primary">Lihat</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> 

</body>
</html>