<?php
session_start();
require '../koneksi.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$admin_name = $_SESSION['admin_name'];
// Ambil data admin dari database
$query = mysqli_query($koneksi, "SELECT * FROM customers");

if (isset($_GET['customer_id'])) {
    $cust_id = $_GET['customer_id'];
    mysqli_query($koneksi, "DELETE FROM customers WHERE customer_id = $cust_id");
    header("Location: customer.php");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Alkes Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS dan Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/style/custom.css">
</head>
<body>

<div class="sidebar">
    <img src="../assets/images/logo_alkes.png" alt="logo" class="logo" style="height: 150px; width: auto;">
    <p>Halo, <?= htmlspecialchars($admin_name) ?></p>
    <a href="dashboard.php">Dashboard</a>
    <a href="produk.php">Produk</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="data_admin.php">Admin</a>
    <!-- Dropdown untuk Laporan -->
    <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" id="dropdownLaporan" data-bs-toggle="dropdown" aria-expanded="false">
            Laporan
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownLaporan">
            <li><a class="dropdown-item text-dark" href="laporan_customer.php" target="_blank">Laporan Customer</a></li>
            <li><a class="dropdown-item text-dark" href="laporan_produk.php" target="_blank">Laporan Produk</a></li>
            <li><a class="dropdown-item text-dark" href="laporan_transaksi.php" target="_blank">Laporan Transaksi</a></li>
        </ul>
    </div>
    <a class="logout-btn" href="logout.php">Logout</a>
</div>

<div class="main-content">
<div class="container">
    <h2 class="mb-4">Data Customer</h2>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark text-center">
        <tr>
            <th>No.</th>
            <th>ID Customer</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Kode Pos</th>
            <th>Telepon</th>
            <th>Username</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($customer = mysqli_fetch_assoc($query)) {
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
                <td>
                    <a href="customer.php?customer_id=<?= $customer['customer_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus admin ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</div>

</body>
</html>
