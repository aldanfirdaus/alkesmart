<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$admin_name = $_SESSION['admin_name'];
require '../koneksi.php';

$pesan = '';

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    // Ambil data produk berdasarkan product_id
    $produk_query = mysqli_query($koneksi, "SELECT * FROM products WHERE product_id = $product_id");
    $produk = mysqli_fetch_assoc($produk_query);

    if (!$produk) {
        die("Produk tidak ditemukan.");
    }

    // Ambil kategori dari database untuk dropdown
    $kategori_query = mysqli_query($koneksi, "SELECT * FROM categories");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
        $kategori = intval($_POST['kategori']);
        $harga = intval($_POST['harga']);
        $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
        $stok = intval($_POST['stok']);
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $upload_dir = '../assets/images/Produk/';

        // Jika ada gambar baru yang di-upload
        if ($gambar != '') {
            $nama_file = time() . '_' . basename($gambar);
            $path = $upload_dir . $nama_file;

            if (move_uploaded_file($tmp, $path)) {
                // Update produk dengan gambar baru
                $update_query = "UPDATE products SET
                                 product_name = '$nama',
                                 category_id = $kategori,
                                 price = $harga,
                                 description = '$deskripsi',
                                 stock = $stok,
                                 product_picture = '$nama_file'
                                 WHERE product_id = $product_id";
            } else {
                $pesan = "Upload gambar gagal.";
            }
        } else {
            // Jika tidak ada gambar baru, update tanpa mengganti gambar
            $update_query = "UPDATE products SET
                                product_name = '$nama',
                                category_id = $kategori,
                                price = $harga,
                                description = '$deskripsi',
                                stock = $stok
                                WHERE product_id = $product_id";
        }

        if (mysqli_query($koneksi, $update_query)) {
            header("Location: produk.php");
            exit;
        } else {
            $pesan = "Gagal memperbarui produk.";
        }
    }
} else {
    die("ID produk tidak ditemukan.");
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
    <a href="customers.php">Admin</a>
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
    <h2 class="mb-4">Ubah Produk</h2>

    <?php if ($pesan): ?>
        <div class="alert alert-warning"><?= $pesan ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow rounded">
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?= htmlspecialchars($produk['product_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select name="kategori" id="kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <?php while ($kat = mysqli_fetch_assoc($kategori_query)) : ?>
                    <option value="<?= $kat['category_id'] ?>" <?= $kat['category_id'] == $produk['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kat['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" id="harga" class="form-control" value="<?= $produk['price'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required><?= htmlspecialchars($produk['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" value="<?= $produk['stock'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Produk</label>
            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar. Gambar sebelumnya:</small>
            <img src="../assets/images/Produk/<?= $produk['product_picture'] ?>" alt="Gambar Produk" class="img-fluid mt-2" width="200">
        </div>
        <div class="d-flex justify-content-between">
            <a href="produk.php" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-warning">Perbarui Produk</button>
        </div>
    </form>
</div>
</div>

</body>
</html>
