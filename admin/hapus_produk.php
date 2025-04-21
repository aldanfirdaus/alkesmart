<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
require '../koneksi.php';

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    mysqli_query($koneksi, "DELETE FROM products WHERE product_id='$product_id'")or die(mysql_error());
    header("location:produk.php?pesan=hapus");
}
?>