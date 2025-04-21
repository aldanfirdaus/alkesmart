<?php 
  session_start();
  include 'koneksi.php';

  if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit;
  }

  $user_id = $_SESSION['customer_id'];

  $query = "SELECT cart.cart_id, products.product_name, products.price, products.product_picture, cart.quantity 
            FROM cart
            JOIN products ON cart.product_id = products.product_id
            WHERE cart.customer_id = $user_id";

  $result = mysqli_query($koneksi, $query);
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
<!-- Navbar -->
<?php include('includes/header.php'); ?>

<div class="container py-4">
  <h3 class="mb-3 mt-4">Keranjang Belanja</h3>
  <form action="update_cart.php" method="POST">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Gambar</th>
          <th>Nama Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Total</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total_belanja = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $total = $row['price'] * $row['quantity'];
          $total_belanja += $total;
        ?>
          <tr>
            <td><img src="assets/images/produk/<?= $row['product_picture'] ?>" width="60"></td>
            <td><?= $row['product_name'] ?></td>
            <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
            <td><?= $row['quantity'] ?></td>
            <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
            <td>
              <!-- Tombol tambah -->
              <button type="submit" name="action" value="plus-<?= $row['cart_id'] ?>" class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
              <!-- Tombol kurang -->
              <button type="submit" name="action" value="minus-<?= $row['cart_id'] ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-minus"></i></button>
              <!-- Tombol hapus -->
              <button type="submit" name="action" value="delete-<?= $row['cart_id'] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </form>

<!-- Total belanja -->
<h5>Total Belanja: Rp <?= number_format($total_belanja, 0, ',', '.') ?></h5>


  <div class="text-end">
    <a href="produk.php" class="btn btn-danger mt-3 mb-3">Kembali</a>
    <a href="payment.php" class="btn btn-success">Lanjut Pembayaran</a>
  </div>
</div>
<?php include('includes/footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>





