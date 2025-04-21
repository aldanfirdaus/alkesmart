<?php
require '../koneksi.php';

if (isset($_GET['order_id']) && isset($_GET['status'])) {
    $order_id = intval($_GET['order_id']);
    $status = $_GET['status'];

    // Hanya izinkan dua status
    if ($status === 'Sudah dibayar' || $status === 'Belum dibayar') {
        mysqli_query($koneksi, "UPDATE orders SET status = '$status' WHERE order_id = $order_id");
    }
}

header("Location: transaksi.php");
exit;
