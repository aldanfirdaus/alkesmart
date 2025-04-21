<?php
session_start();
include 'koneksi.php';

$username = htmlentities($_POST['username']);
$password = htmlentities($_POST['password']);

$query = mysqli_query($koneksi, "SELECT * FROM customers WHERE username='$username'");
$data = mysqli_fetch_assoc($query);

if ($data && password_verify($password, $data['password'])) {
    // Login berhasil
    session_start();
    $_SESSION['customer_id'] = $data['customer_id'];
    $_SESSION['username'] = $data['username'];
    header("Location: index.php");
    exit;
} else {
    // Login gagal
    header("Location: login.php?pesan=gagal");
    exit;
}
?>