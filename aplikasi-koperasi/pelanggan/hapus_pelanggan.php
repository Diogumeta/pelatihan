<?php
include '../config.php';

$id = $_GET['id'];
if (!isset($id)) {
    header("Location: list_pelanggan.php");
    exit();
}

// Ambil data pelanggan
$result = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_pelanggan='$id'");
if (mysqli_num_rows($result) == 0) {
    header("Location: list_pelanggan.php");
    exit();
}
$pelanggan = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'delete') {
        // Hapus pelanggan
        mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");
        header("Location: list_pelanggan.php");
        exit();
    } elseif ($action === 'cancel') {
        header("Location: list_pelanggan.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hapus Pelanggan - Koperasi Pegawai</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"  rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-container {
            max-width: 500px;
            margin-top: 80px;
            padding: 20px;
        }
        .icon-warning {
            font-size: 4rem;
            color: #ffc107;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 card-container">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle icon-warning mb-3"></i>
                    <h4>Apakah Anda yakin ingin menghapus pelanggan ini?</h4>
                    <p class="text-muted"><strong><?= htmlspecialchars($pelanggan['nama']) ?></strong></p>

                    <form method="post">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="btn btn-danger me-2"><i class="fas fa-trash me-1"></i>Hapus</button>
                    </form>

                    <form method="post" class="mt-2">
                        <input type="hidden" name="action" value="cancel">
                        <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> 

</body>
</html>