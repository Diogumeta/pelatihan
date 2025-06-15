<?php
session_start();
include '../config.php';

// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

$success = $error = "";

// Proses data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pelanggan = mysqli_real_escape_string($conn, $_POST['id_pelanggan']);
    $total_harga = mysqli_real_escape_string($conn, $_POST['total_harga']);

    // Validasi pelanggan dipilih
    if (empty($id_pelanggan) || empty($total_harga)) {
        $error = "Silakan pilih pelanggan dan masukkan semua data barang.";
    } else {
        $tanggal = date('Y-m-d');

        // Simpan transaksi
        $query = "INSERT INTO transaksi (id_pelanggan, id_petugas, tanggal, total_harga)
                  VALUES ('$id_pelanggan', '1', '$tanggal', '$total_harga')";
        
        if (mysqli_query($conn, $query)) {
            $id_transaksi = mysqli_insert_id($conn);

            // Simpan detail transaksi
            foreach ($_POST['barang'] as $key => $id_barang) {
                $jumlah = isset($_POST['jumlah'][$key]) ? intval($_POST['jumlah'][$key]) : 0;
                $subtotal = isset($_POST['subtotal'][$key]) ? floatval($_POST['subtotal'][$key]) : 0;

                if ($jumlah > 0 && !empty($id_barang)) {
                    mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah, subtotal)
                                         VALUES ('$id_transaksi', '$id_barang', '$jumlah', '$subtotal')");
                    
                    // Update stok barang
                    mysqli_query($conn, "UPDATE barang SET stok = stok - $jumlah WHERE id_barang='$id_barang'");
                }
            }

            $success = "Transaksi berhasil disimpan!";
        } else {
            $error = "Gagal menyimpan transaksi: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buat Transaksi Baru - Koperasi Pegawai</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"  rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI'; }
        .form-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table-bordered td, .table-bordered th { vertical-align: middle; }
        .btn-primary { background-color: #232749; border-color: #232749; }
        .btn-primary:hover { background-color: #0b5ed7; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 form-container bg-white">

            <h2 class="text-center mb-4">Buat Transaksi Baru</h2>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php elseif (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="id_pelanggan">Pilih Pelanggan</label>
                    <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM pelanggan");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['id_pelanggan']}'>{$row['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <table class="table table-bordered mb-3">
                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="barang-body">
                        <tr>
                            <td>
                                <select class="form-select select-barang" name="barang[]" required>
                                    <option value="">-- Pilih Barang --</option>
                                    <?php
                                    $res = mysqli_query($conn, "SELECT * FROM barang");
                                    while ($b = mysqli_fetch_assoc($res)) {
                                        echo "<option value='{$b['id_barang']}' data-harga='{$b['harga']}'>{$b['nama_barang']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input type="number" class="form-control input-harga" name="harga[]" readonly></td>
                            <td><input type="number" class="form-control input-jumlah" name="jumlah[]" min="1" required></td>
                            <td><input type="number" class="form-control input-subtotal" name="subtotal[]" readonly></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success mb-3" id="add-row"><i class="fas fa-plus"></i> Tambah Barang</button>

                <div class="mb-3">
                    <label for="total_harga">Total Harga</label>
                    <input type="number" id="total_harga" name="total_harga" class="form-control" readonly>
                </div>

                <button type="submit" class="btn btn-primary w-100" name="submit">Simpan Transaksi</button>
            </form>

            <div class="mt-3 text-center">
                <a href="list_transaksi.php" class="btn btn-outline-secondary btn-sm">Kembali</a>
            </div>

        </div>
    </div>
</div>

<!-- JavaScript untuk interaktivitas -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.getElementById('barang-body');
    const addRowBtn = document.getElementById('add-row');

    function calculateSubtotal(row) {
        const hargaInput = row.querySelector('.input-harga');
        const jumlahInput = row.querySelector('.input-jumlah');
        const subtotalInput = row.querySelector('.input-subtotal');

        const harga = parseFloat(hargaInput.value) || 0;
        const jumlah = parseInt(jumlahInput.value) || 0;

        subtotalInput.value = (harga * jumlah).toFixed(2);
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.input-subtotal').forEach(input => {
            total += parseFloat(input.value || 0);
        });
        document.getElementById('total_harga').value = total.toFixed(2);
    }

    function bindEvents(row) {
        row.querySelector('.select-barang').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga') || 0;
            row.querySelector('.input-harga').value = parseFloat(harga).toFixed(2);
            calculateSubtotal(row);
        });

        row.querySelector('.input-jumlah').addEventListener('input', function () {
            calculateSubtotal(row);
        });
    }

    // Tambah baris
    addRowBtn.addEventListener('click', function () {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select class="form-select select-barang" name="barang[]">
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    mysqli_data_seek($res, 0); // Reset pointer hasil query
                    while ($b = mysqli_fetch_assoc($res)) {
                        echo "<option value='{$b['id_barang']}' data-harga='{$b['harga']}'>{$b['nama_barang']}</option>";
                    }
                    ?>
                </select>
            </td>
            <td><input type="number" class="form-control input-harga" name="harga[]" readonly></td>
            <td><input type="number" class="form-control input-jumlah" name="jumlah[]" min="1"></td>
            <td><input type="number" class="form-control input-subtotal" name="subtotal[]" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
        `;
        tbody.appendChild(newRow);
        bindEvents(newRow);
    });

    // Hapus baris
    tbody.addEventListener('click', function (e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
            calculateTotal();
        }
    });

    // Inisialisasi baris pertama
    document.querySelectorAll('#barang-body tr').forEach(bindEvents);
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> 

</body>
</html>