<?php
include '../config.php';

$id_transaksi = $_GET['id'];
$query = "SELECT t.id_transaksi, p.nama, p.telepon, p.alamat, t.total_harga, t.tanggal 
          FROM transaksi t
          JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
          WHERE t.id_transaksi = '$id_transaksi'";
$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_assoc($result);

// Ambil detail transaksi
$detailQuery = "SELECT b.nama_barang, dt.jumlah, dt.subtotal 
                FROM detail_transaksi dt
                JOIN barang b ON dt.id_barang = b.id_barang
                WHERE dt.id_transaksi = '$id_transaksi'";
$detailResult = mysqli_query($conn, $detailQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi #<?= $transaksi['id_transaksi'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"  rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <style>
        body { background-color: #f8f9fa; }
        .invoice-box {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <h4 class="text-center mb-4">Detail Transaksi #<?= $transaksi['id_transaksi'] ?></h4>

    <div class="row mb-3">
        <div class="col-md-6">
            <strong>Nama:</strong> <?= htmlspecialchars($transaksi['nama']) ?><br>
            <strong>Telepon:</strong> <?= htmlspecialchars($transaksi['telepon']) ?><br>
            <strong>Alamat:</strong> <?= htmlspecialchars($transaksi['alamat']) ?>
        </div>
        <div class="col-md-6 text-md-end">
            <strong>Tanggal:</strong> <?= date("d-m-Y", strtotime($transaksi['tanggal'])) ?><br>
            <strong>ID Transaksi:</strong> <?= $transaksi['id_transaksi'] ?>
        </div>
    </div>

    <hr>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-primary">
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($detail = mysqli_fetch_assoc($detailResult)): ?>
                    <tr>
                        <td><?= htmlspecialchars($detail['nama_barang']) ?></td>
                        <td><?= $detail['jumlah'] ?></td>
                        <td>Rp <?= number_format($detail['subtotal'] / $detail['jumlah'], 2, ',', '.') ?></td>
                        <td>Rp <?= number_format($detail['subtotal'], 2, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="text-end mt-3">
        <h5><strong>Total: Rp <?= number_format($transaksi['total_harga'], 2, ',', '.') ?></strong></h5>
    </div>

    <div class="mt-4 text-center">
        <a href="list_transaksi.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>