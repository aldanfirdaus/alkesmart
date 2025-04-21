<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$admin_name = $_SESSION['admin_name'];

require '../koneksi.php';

// Ambil data admin dari database
$query = mysqli_query($koneksi, "SELECT * FROM admin");

if (isset($_GET['id_admin'])) {
    $admin_id = intval($_GET['id_admin']);
    mysqli_query($koneksi, "DELETE FROM admin WHERE id_admin = $admin_id");
    header("Location: data_admin.php");
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Alkes Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h2 class="mb-4">Data Admin</h2>

    <a href="tambah_admin.php" class="btn btn-primary mb-3">➕ Tambah Admin</a>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Nama Lengkap</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?= $row['id_admin'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td>••••••••</td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td>
                        <a href="edit_admin.php?id_admin=<?= $row['id_admin'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="data_admin.php?id_admin=<?= $row['id_admin'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus admin ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
