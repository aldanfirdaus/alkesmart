<?php
require '../koneksi.php';
session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['admin_id'])) {
    echo "Anda harus login terlebih dahulu.";
    exit;
}

// Ambil data customer
$customer_query = mysqli_query($koneksi, "SELECT * FROM customers");

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Customer</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h2 { margin-top: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <img src="../assets/images/logo_bgred.png" alt="logo" style="width: 80px; height: auto;">
  <h2>Laporan Customer</h2>

  <table>
    <thead>
      <tr>
        <th>No.</th>
        <th>ID Customer</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Alamat</th>
        <th>Kode Pos</th>
        <th>Telepon</th>
        <th>Username</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      while ($customer = mysqli_fetch_assoc($customer_query)) {
      ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $customer['customer_id'] ?></td>
        <td><?= $customer['name'] ?></td>
        <td><?= $customer['email'] ?></td>
        <td><?= $customer['address'] ?></td>
        <td><?= $customer['postal_code'] ?></td>
        <td><?= $customer['phone'] ?></td>
        <td><?= $customer['username'] ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <p style="margin-top: 30px;">Data customer yang terdaftar di Alkes Mart.</p>

  <script>
    window.print(); // Otomatis tampilkan print
  </script>
</body>
</html>
