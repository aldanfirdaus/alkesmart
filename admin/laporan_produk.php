<?php
require '../koneksi.php';
session_start();

// Memastikan admin sudah login
if (!isset($_SESSION['admin_id'])) {
    echo "Anda harus login terlebih dahulu.";
    exit;
}

// Ambil data produk dari database
$product_query = mysqli_query($koneksi, "SELECT * FROM products");

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Produk</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h2 { margin-top: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .text-end { text-align: right; }
  </style>
</head>
<body>
  <img src="../assets/images/logo_bgred.png" alt="logo" style="width: 80px; height: auto;">
  <h2>Laporan Produk</h2>

  <table>
    <thead>
      <tr>
        <th>No.</th>
        <th>ID Produk</th>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      while ($product = mysqli_fetch_assoc($product_query)) {
        // Mengambil kategori produk berdasarkan category_id
        $category_query = mysqli_query($koneksi, "SELECT name FROM categories WHERE category_id = " . $product['category_id']);
        $category = mysqli_fetch_assoc($category_query);
      ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $product['product_id'] ?></td>
        <td><?= $product['product_name'] ?></td>
        <td><?= $category['name'] ?></td>
        <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
        <td><?= $product['stock'] ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <p style="margin-top: 30px;">Terima kasih telah mengelola Alkes Mart.</p>

  <script>
    window.print(); // Otomatis tampilkan print
  </script>
</body>
</html>
