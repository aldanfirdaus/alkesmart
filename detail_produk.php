<?php 
include 'koneksi.php';
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

<?php
if (!isset($_GET['id'])) {
    header('Location: produk.php');
    exit;
}

$id = (int) $_GET['id'];

// Ambil detail produk
$query = "SELECT products.*, categories.name
            FROM products
            INNER JOIN categories ON products.category_id = categories.category_id
            WHERE products.product_id = $id;";
$result = mysqli_query($koneksi, $query);
$produk = mysqli_fetch_assoc($result);

// Jika produk tidak ditemukan
if (!$produk) {
    echo "<div class='alert alert-danger mt-3'>Produk tidak ditemukan.</div>";
    exit;
}

// Produk terkait (dengan kategori sama, tapi bukan produk ini)
$related_query = "SELECT product_id, product_name, product_picture, price 
                  FROM products 
                  WHERE category_id = {$produk['category_id']} AND product_id != $id 
                  LIMIT 4";
$related_result = mysqli_query($koneksi, $related_query);
?>

<div class="container py-5">
    <div class="row">
        <!-- Gambar Produk -->
        <div class="col-md-5">
            <img src="assets/images/produk/<?= $produk['product_picture'] ?>" class="img-fluid rounded shadow" alt="<?= $produk['product_name'] ?>">
            <!-- Form Pembelian -->
            <form action="keranjang_proses.php" method="POST" class="mt-4 mb-2">
                <input type="hidden" name="product_id" value="<?= $produk['product_id'] ?>">
                
                <div class="mb-3">
                    <label for="quantity" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" min="1" value="1" style="width: 120px;" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="action" value="keranjang" class="btn btn-primary">
                      <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </div>
            </form>
            <a href="keranjang.php">
                      <button class="btn btn-danger">Checkout</button>
            </a>
        </div>

        <!-- Detail Produk -->
        <div class="col-md-7">
            <h2 class="fw-bold"><?= $produk['product_name'] ?></h2>
            <p class="text-muted">Kategori: <span class="fw-semibold"><?= $produk['name'] ?></span></p>
            <h4 class="text-danger">Rp <?= number_format($produk['price'], 0, ',', '.') ?></h4>
            <hr>
            <p><?= nl2br($produk['description']) ?></p>
            <p class="fw-bold">Sisa stok produk : <?= $produk['stock']; ?></p>
            <a href="produk.php" class="btn btn-outline-secondary mt-3 mb-3">Kembali</a>
        </div>
    </div>

    <!-- Produk Terkait -->
    <div class="mt-5">
        <h4 class="fw-semibold mb-4">Produk Terkait</h4>
        <div class="row">
            <?php while ($related = mysqli_fetch_assoc($related_result)): ?>
                <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <img src="assets/images/produk/<?= $related['product_picture'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                    <h6 class="card-title"><?= $related['product_name'] ?></h6>
                    <p class="card-text text-danger fw-bold">Rp <?= number_format($related['price'], 0, ',', '.') ?></p>
                    <a href="detail_produk.php?id=<?= $related['product_id'] ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                    </div>
                </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>


<!-- Footer -->
<?php include('includes/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>