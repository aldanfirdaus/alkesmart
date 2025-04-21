<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$admin_name = $_SESSION['admin_name'];

require '../koneksi.php';

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil data transaksi
$query = "SELECT * FROM orders ORDER BY created_at DESC LIMIT $start, $limit";
$result = mysqli_query($koneksi, $query);

// Hitung total data
$total_data = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM orders"));
$total_pages = ceil($total_data / $limit);
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
    <h2 class="mb-4">Data Transaksi</h2>

    <table class="table table-bordered table-hover table-striped bg-white">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Total</th>
                <th>Alamat</th>
                <th>Kode Pos</th>
                <th>Tanggal</th>
                <th>Pembayaran</th>
                <th>Bukti Transfer</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
            $no = $start + 1;
            while ($row = mysqli_fetch_assoc($result)):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['order_id'] ?></td>
                <td><?= $row['customer_id'] ?></td>
                <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td><?= htmlspecialchars($row['postal_code']) ?></td>
                <td><?= $row['created_at'] ?></td>
                <td><?= $row['payment'] ?></td>
                <td>
                    <?php if (!empty($row['bukti_tf'])): ?>
                        <img src="../assets/images/bukti/<?= $row['bukti_tf'] ?>" alt="Bukti" width="50" height="50" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#modalBukti<?= $row['order_id'] ?>">
                        
                        <!-- Modal Gambar -->
                        <div class="modal fade" id="modalBukti<?= $row['order_id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img src="../assets/images/bukti/<?= $row['bukti_tf'] ?>" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <span class="text-muted">Tidak ada</span>
                    <?php endif; ?>
                </td>
                <td><b><?= $row['status'] ?></b></td>
                <td>
                <a href="update_status.php?order_id=<?= $row['order_id'] ?>&status=Sudah dibayar" class="btn btn-sm btn-success mb-1">Sudah dibayar</a>
                <a href="update_status.php?order_id=<?= $row['order_id'] ?>&status=Belum dibayar" class="btn btn-sm btn-warning mb-1">Belum dibayar</a>
                <a href="hapus_transaksi.php?order_id=<?= $row['order_id'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">Hapus</a>

                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="transaksi.php?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</div>

</body>
</html>
