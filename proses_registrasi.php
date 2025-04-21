<?php
include 'koneksi.php';
// Tangkap data dari form
$nama     = $_POST['nama'];
$email    = $_POST['email'];
$alamat   = $_POST['alamat'];
$kodepos  = $_POST['kodepos'];
$telp     = $_POST['telp'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

// Cek apakah username sudah terdaftar
$cek = mysqli_query($koneksi, "SELECT * FROM customers WHERE username = '$username'");
if(mysqli_num_rows($cek) > 0){
    // Redirect balik ke form dengan pesan error
    header("Location: registrasi.php?pesan=username_terpakai");
    exit;
}

// Simpan ke database
$query = "INSERT INTO customers VALUES ('','$nama', '$email', '$alamat', '$kodepos', '$telp', '$username', '$password')";

if(mysqli_query($koneksi, $query)){
    // Redirect ke halaman login atau sukses
    header("Location: login.php?pesan=registrasi_berhasil");
    exit;
} else {
    echo "Gagal menyimpan data: " . mysqli_error($koneksi);
}
?>