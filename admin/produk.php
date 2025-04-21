<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$admin_name = $_SESSION['admin_name'];
// Konfigurasi pagination
$batas = 5;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Pencarian
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : "";

// Ambil total data
$total_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM products $cari");
$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_halaman = ceil($total_data / $batas);

// Ambil data produk
$query = "SELECT products.product_id, products.product_name, products.price, products.product_picture, products.stock, products.description, categories.name 
            FROM products 
            INNER JOIN categories ON products.category_id = categories.category_id
            ORDER BY products.product_name ASC 
            LIMIT $halaman_awal, $batas";
$produk_query = mysqli_query($koneksi, $query);
$no = $halaman_awal + 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Alkes Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/custom.css">
    <link rel="stylesheet" href="../assets/style/fontawesome.css">
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
    <h2 class="mb-4">Manajemen Produk</h2>

    <!-- Form Pencarian -->
    <form class="mb-3 d-flex" method="GET" action="produk.php">
        <input type="text" name="cari" class="form-control me-2" placeholder="Cari produk..." value="<?= htmlspecialchars($cari) ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <!-- Tabel Produk -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($produk_query) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($produk_query)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['product_name']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td>Rp<?= number_format($row['price'], 0, ',', '.') ?></td>
                            <td><?= substr(htmlspecialchars($row['description']), 0, 30) ?>...</td>
                            <td><?= $row['stock'] ?></td>
                            <td><img src="../assets/images/Produk/<?= $row['product_picture'] ?>" class="img-thumb" alt="Gambar" style="width:100px; height:auto;"></td>
                            <td>
                                <a href="ubah_produk.php?product_id=<?= $row['product_id'] ?>" class="btn btn-sm btn-warning">Ubah</a>
                                <a href="hapus_produk.php?product_id=<?= $row['product_id'] ?>" class="btn btn-sm btn-danger mt-1" onclick="return confirm('Yakin hapus produk ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data produk.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php if ($halaman > 1): ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halaman - 1 ?>&cari=<?= $cari ?>">«</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
                <li class="page-item <?= ($i == $halaman) ? 'active' : '' ?>">
                    <a class="page-link" href="?halaman=<?= $i ?>&cari=<?= $cari ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($halaman < $total_halaman): ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halaman + 1 ?>&cari=<?= $cari ?>">»</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Tombol Tambah Produk -->
    <div class="text-end">
        <a href="tambah_produk.php" class="btn btn-success">Tambah Produk</a>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</div>

</body>
</html>
