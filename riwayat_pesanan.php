<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];
$orders_query = mysqli_query($koneksi, "SELECT * FROM orders WHERE customer_id = $customer_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Customer - E-Commerce Alat Kesehatan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/style/fontawesome.css">
  <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
<?php include('includes/header.php'); ?>

<div class="container mt-5">
  <h4>Riwayat Pesanan Saya</h4>
  <?php if (mysqli_num_rows($orders_query) > 0): ?>
    <?php while ($order = mysqli_fetch_assoc($orders_query)): ?>
      <div class="card mb-4">
        <div class="card-header">
          <strong>Order ID: <?= $order['order_id'] ?></strong><br>
          Tanggal: <?= $order['created_at'] ?><br>
          Metode: <?= $order['payment'] ?><br>
          Status: <span class="badge bg-<?= $order['status'] == 'Sudah dibayar' ? 'success' : 'warning' ?>"><?= $order['status'] ?></span>
        </div>
        <div class="card-body">
          <ul class="list-group">
            <?php
              $order_id = $order['order_id'];
              $details = mysqli_query($koneksi, "
                SELECT od.*, p.product_name 
                FROM orderdetails od 
                JOIN products p ON od.product_id = p.product_id 
                WHERE od.order_id = $order_id
              ");
              while ($item = mysqli_fetch_assoc($details)):
            ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= $item['product_name'] ?> x <?= $item['quantity'] ?>
                <span>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
              </li>
            <?php endwhile; ?>
          </ul>
          <div class="mt-3 text-end">
            <strong>Total: Rp <?= number_format($order['total'], 0, ',', '.') ?></strong><br>
            <a href="cetak_invoice.php?order_id=<?= $order['order_id'] ?>" class="btn btn-primary mt-2" target="_blank">Cetak Invoice</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="alert alert-info">Belum ada transaksi.</div>
  <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
