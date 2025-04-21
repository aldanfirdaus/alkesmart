<?php
include 'koneksi.php';
session_start();

if (!isset($_GET['order_id'])) {
    echo "Order ID tidak ditemukan.";
    exit;
}

$order_id = intval($_GET['order_id']);
$order_query = mysqli_query($koneksi, "
    SELECT o.*, c.name, c.email 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.customer_id 
    WHERE o.order_id = $order_id
");

if (mysqli_num_rows($order_query) == 0) {
    echo "Data pesanan tidak ditemukan.";
    exit;
}

$order = mysqli_fetch_assoc($order_query);
$details = mysqli_query($koneksi, "
    SELECT od.*, p.product_name 
    FROM orderdetails od 
    JOIN products p ON od.product_id = p.product_id 
    WHERE od.order_id = $order_id
");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>No. Transaksi #<?= $order['order_id'] ?></title>
  <style>
    body { font-family: Arial; padding: 20px; }
    h2 { margin-top: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; }
    th { background-color: #f2f2f2; }
    .text-end { text-align: right; }
  </style>
</head>
<body>
  <img src="assets/images/logo_bgred.png" alt="logo" style="width: 80px; height: auto;">
  <h2>No. Transaksi #<?= $order['order_id'] ?></h2>
  <p>
    Nama: <?= $order['name'] ?><br>
    Email: <?= $order['email'] ?><br>
    Alamat: <?= $order['address'] ?>, <?= $order['postal_code'] ?><br>
    Tanggal: <?= $order['created_at'] ?><br>
    Metode Pembayaran: <?= $order['payment'] ?><br>
    Status: <?= $order['status'] ?>
  </p>

  <table>
    <thead>
      <tr>
        <th>Produk</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $grand_total = 0; while ($item = mysqli_fetch_assoc($details)): 
        $subtotal = $item['quantity'] * $item['price'];
        $grand_total += $subtotal;
      ?>
      <tr>
        <td><?= $item['product_name'] ?></td>
        <td><?= $item['quantity'] ?></td>
        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
        <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
      </tr>
      <?php endwhile; ?>
      <tr>
        <th colspan="3" class="text-end">Total</th>
        <th>Rp <?= number_format($grand_total, 0, ',', '.') ?></th>
      </tr>
    </tbody>
  </table>

  <p style="margin-top: 30px;">Terima kasih telah berbelanja di Alkes Mart.</p>

  <script>
    window.print(); // Otomatis tampilkan print
  </script>
</body>
</html>
