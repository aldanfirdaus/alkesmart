<?php
require '../koneksi.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "Anda harus login terlebih dahulu.";
    exit;
}

$transaksi = mysqli_query($koneksi, "
    SELECT o.*, c.name AS customer_name
    FROM orders o
    JOIN customers c ON o.customer_id = c.customer_id
    ORDER BY o.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Transaksi - Alkes Mart</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h2 { margin-top: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; }
    th { background-color: #f2f2f2; }
    img.bukti { width: 80px; height: auto; }
  </style>
</head>
<body>
  <img src="../assets/images/logo_bgred.png" alt="logo" style="width: 80px; height: auto;">
  <h2>Laporan Transaksi</h2>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Alamat</th>
        <th>Kode Pos</th>
        <th>Tanggal</th>
        <th>Pembayaran</th>
        <th>Status</th>
        <th>Bukti Transfer</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      while ($row = mysqli_fetch_assoc($transaksi)):
      ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['order_id'] ?></td>
        <td><?= $row['customer_name'] ?></td>
        <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
        <td><?= $row['address'] ?></td>
        <td><?= $row['postal_code'] ?></td>
        <td><?= $row['created_at'] ?></td>
        <td><?= $row['payment'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
          <?php if (!empty($row['bukti_transfer'])): ?>
            <img class="bukti" src="../assets/bukti/<?= $row['bukti_transfer'] ?>" alt="Bukti">
          <?php else: ?>
            Tidak ada
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <p style="margin-top: 30px;">Laporan ini dicetak dari sistem Alkes Mart.</p>

  <script>
    window.print(); // otomatis tampilkan dialog cetak
  </script>
</body>
</html>
