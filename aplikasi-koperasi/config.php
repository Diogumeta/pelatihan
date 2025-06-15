<?php
$host = "localhost";
$user = "root"; // sesuaikan dengan server Anda
$pass = "";     // password MySQL (default kosong)
$db   = "koperasi";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>  