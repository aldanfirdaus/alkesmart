<?php
session_start();
include 'koneksi.php'; // pastikan file koneksi DB ada

// Cek apakah user sudah login
if (!isset($_SESSION['customer_id'])) {
    // Redirect ke halaman login jika belum login
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];
$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);
$stok_tersedia = mysqli_query($koneksi, "SELECT stock FROM products WHERE product_id = $product_id");
$stok_tersedia = mysqli_fetch_assoc($stok_tersedia);
$stok_tersedia = $stok_tersedia['stock'];
// $action = $_POST['action']; // keranjang atau beli

if ($quantity > $stok_tersedia) {
    // Redirect dengan pesan error
    echo "<script>
        alert('Stok tidak mencukupi. Maksimal stok tersedia: $stok_tersedia');
        window.history.back();
    </script>";
    exit;
}else{
    // Cek apakah produk sudah ada di keranjang
    $check_query = mysqli_query($koneksi, "SELECT * FROM cart WHERE customer_id = $customer_id AND product_id = $product_id");

    if (mysqli_num_rows($check_query) > 0) {
        // Jika produk sudah ada, update quantity
        mysqli_query($koneksi, "UPDATE cart SET quantity = quantity + $quantity WHERE customer_id = $customer_id AND product_id = $product_id");
    } else {
        // Jika belum ada, insert baru
        mysqli_query($koneksi, "INSERT INTO cart (customer_id, product_id, quantity) VALUES ($customer_id, $product_id, $quantity)");
    }

    // Redirect sesuai aksi
    header("Location: keranjang.php");
    exit;
}

?>
