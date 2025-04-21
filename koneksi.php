<?php

$host     = "localhost";      // biasanya localhost
$user     = "root";           // user default XAMPP
$password = "";               // default kosong
$database = "alkesmart";  // ganti dengan nama database kamu

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    // echo "Koneksi berhasil!";
}
?>