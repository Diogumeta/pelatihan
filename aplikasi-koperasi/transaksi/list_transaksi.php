<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Transaksi - Koperasi Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"  rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: white;
        }
        .table thead {
            background-color: #162C48;
            color: white;
        }
        .badge-stok {
            font-size: 1em;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Daftar Transaksi</h4>
                    <a href="buat_transaksi.php" class="btn btn-primary"><i class="fas fa-plus"></i> Buat Transaksi</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center align-middle">
                            <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT t.id_transaksi, p.nama, t.total_harga, t.tanggal 
                                          FROM transaksi t
                                          JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan";
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) > 0):
                                    while ($row = mysqli_fetch_assoc($result)):
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id_transaksi']) ?></td>
                                        <td><?= htmlspecialchars($row['nama']) ?></td>
                                        <td>Rp <?= number_format($row['total_harga'], 2, ',', '.') ?></td>
                                        <td><?= date("d-m-Y", strtotime($row['tanggal'])) ?></td>
                                        <td>
                                            <a href="detail_transaksi.php?id=<?= $row['id_transaksi'] ?>" class="btn btn-sm btn-info text-white me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; else: ?>
                                    <tr>
                                        <td colspan="5" class="text-muted">Belum ada transaksi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>