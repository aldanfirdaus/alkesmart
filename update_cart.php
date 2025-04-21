<?php
include 'koneksi.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $parts = explode('-', $action);
    $type = $parts[0];
    $cart_id = $parts[1];
    // Ambil data produk & quantity sekarang
    $query = mysqli_query($koneksi, "SELECT cart.quantity, products.price 
                                      FROM cart 
                                      JOIN products ON cart.product_id = products.product_id 
                                      WHERE cart.cart_id = $cart_id");
    $data = mysqli_fetch_assoc($query);
  
    $quantity = $data['quantity'];

    if ($type == 'plus') {
        $quantity += 1;
        $update = mysqli_query($koneksi, "UPDATE cart SET quantity = $quantity WHERE cart_id = $cart_id");
    } elseif ($type == 'minus' && $quantity > 1) {
        $quantity -= 1;
        $update = mysqli_query($koneksi, "UPDATE cart SET quantity = $quantity WHERE cart_id = $cart_id");
    } elseif ($type == 'delete') {
        $delete = mysqli_query($koneksi, "DELETE FROM cart WHERE cart_id = $cart_id");
    }
}

header('Location: keranjang.php');
exit;
