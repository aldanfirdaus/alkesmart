<?php
include 'koneksi.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Ambil data dari form
$payment_method = $_POST['metode_pembayaran'];
$total = $_POST['total'];
$order_date = date('Y-m-d H:i:s');

$status_order = "Belum dibayar";
$bukti_transfer = null;
// Ambil alamat dari database
$customer_query = mysqli_query($koneksi, "SELECT * FROM customers WHERE customer_id = $customer_id");
$customer_data = mysqli_fetch_assoc($customer_query);
$alamat = $customer_data['address'];
$kodepos = $customer_data['postal_code'];

// Cek dan proses upload bukti jika metode BCA
if (in_array($payment_method, ["BCA", "QRIS"])) {
    if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] == 0) {
        $upload_dir = "assets/images/bukti/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Buat folder jika belum ada
        }

        $file_ext = pathinfo($_FILES['bukti_transfer']['name'], PATHINFO_EXTENSION);
        $file_name = time() . '_' . uniqid() . '.' . $file_ext;
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $target_file)) {
            $bukti_transfer = $file_name;
        } else {
            die("Gagal upload bukti pembayaran.");
        }
    } else {
        die("Bukti transfer harus diunggah untuk metode pembayaran BCA.");
    }
}

// Simpan ke tabel order
$insert_order = mysqli_query($koneksi, 
    "INSERT INTO orders (customer_id, total, address, postal_code, created_at, payment, bukti_tf, status) 
     VALUES ($customer_id, $total, '$alamat', '$kodepos', '$order_date', '$payment_method', " . 
     ($bukti_transfer ? "'$bukti_transfer'" : "NULL") . ", '$status_order')");

if ($insert_order) {
$order_id = mysqli_insert_id($koneksi); // ID pesanan

// Ambil produk dari keranjang
$cart_query = mysqli_query($koneksi, "SELECT * FROM cart WHERE customer_id = $customer_id");
if (mysqli_num_rows($cart_query) == 0) {
    die("Keranjang kosong.");
} else {
    while ($cart_item = mysqli_fetch_assoc($cart_query)) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];

        // Ambil harga produk
        $product_query = mysqli_query($koneksi, "SELECT price FROM products WHERE product_id = $product_id");
        $product_data = mysqli_fetch_assoc($product_query);
        $price = $product_data['price'];

        // Simpan ke orderdetails
        $insert_detail = mysqli_query($koneksi, 
            "INSERT INTO orderdetails (order_id, product_id, quantity, price) 
                VALUES ($order_id, $product_id, $quantity, $price)");
        if (!$insert_detail) {
            die("Gagal simpan detail: " . mysqli_error($koneksi));
        }

        // Kurangi stok
        mysqli_query($koneksi, 
            "UPDATE products SET stock = stock - $quantity WHERE product_id = $product_id");
    }
}

// Kosongkan keranjang
mysqli_query($koneksi, "DELETE FROM cart WHERE customer_id = $customer_id");

// ------------------------------------------------
// Ambil data customer & order
$customer_email = $customer_data['email'];
$customer_name = $customer_data['name'];
// $customer_address = $customer_data['address'];
// $customer_postcode = $customer_data['post_code'];
$status = mysqli_query($koneksi, "SELECT * FROM orders WHERE order_id = $order_id");
$status = mysqli_fetch_assoc($status);
// Compose isi email invoice
$subject = "Invoice Pembayaran Alkes Mart - No. Transaksi #$order_id";
$body = "
<h3>Halo $customer_name,</h3>
<p>Terima kasih telah melakukan pembayaran pesanan Anda di <strong>Alkes Mart</strong>.</p>
<p>Berikut adalah ringkasan pesanan Anda:</p>
<table border='1' cellpadding='8' cellspacing='0'>
<tr><th>Produk</th><th>Qty</th><th>Harga</th></tr>";

$order_items = mysqli_query($koneksi, "SELECT od.*, p.product_name FROM orderdetails od JOIN products p ON od.product_id = p.product_id WHERE od.order_id = $order_id");
$total_invoice = 0;
while ($item = mysqli_fetch_assoc($order_items)) {
    $subtotal = $item['quantity'] * $item['price'];
    $total_invoice += $subtotal;
    $body .= "<tr>
        <td>{$item['product_name']}</td>
        <td>{$item['quantity']}</td>
        <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
    </tr>";
}
$body .= "<tr><td colspan='2'><strong>Total</strong></td><td><strong>Rp " . number_format($total_invoice, 0, ',', '.') . "</strong></td></tr>";
$body .= "</table><br>
<p>Alamat Pengiriman: <br><strong>{$alamat}, {$kodepos}</strong></p>
<p>Status Pembayaran: <strong>{$status['status']}</strong></p>
<p>Jika ada pertanyaan, hubungi CS kami di WA: 0895606198968</p>
<hr>
<p>Alkes Mart - Solusi Alat Kesehatan Anda.</p>
";

// Kirim email pakai PHPMailer
$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Ganti dengan SMTP server kamu
    $mail->SMTPAuth = true;
    $mail->Username = 'aldanfirdaus49@gmail.com'; // Email pengirim
    $mail->Password = 'ketm jags tcrd exuy';       // Password email pengirim
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('aldanfirdaus49@gmail.com', 'Alkes Mart');
    $mail->addAddress($customer_email, $customer_name);

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
    // echo 'Email invoice terkirim.';
} catch (Exception $e) {
    echo "Gagal kirim email. Error: {$mail->ErrorInfo}";
}



// Redirect ke halaman sukses
header("Location: order_sukses.php?order_id=$order_id");
exit;
} else {
    echo "Gagal memproses pesanan.";
}
?>
