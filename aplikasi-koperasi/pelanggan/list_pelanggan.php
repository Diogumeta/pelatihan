<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan - Koperasi Pegawai</title>
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
        .table-responsive {
            overflow-x: auto;
        }
        .btn-action {
            display: inline-block;
            margin-right: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="my-4">Daftar Pelanggan</h2>
    <a href="tambah_pelanggan.php" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Tambah Pelanggan</a>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM pelanggan";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id_pelanggan']}</td>
                            <td>" . htmlspecialchars($row['nama']) . "</td>
                            <td>" . htmlspecialchars($row['alamat']) . "</td>
                            <td>" . htmlspecialchars($row['telepon']) . "</td>
                            <td>
                                <a href='edit_pelanggan.php?id={$row['id_pelanggan']}' class='btn btn-sm btn-warning btn-action'><i class='fas fa-edit'></i> Edit</a>
                                <a href='hapus_pelanggan.php?id={$row['id_pelanggan']}' onclick=\"return confirm('Hapus?')\" class='btn btn-sm btn-danger btn-action'><i class='fas fa-trash'></i> Hapus</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> 

</body>
</html>