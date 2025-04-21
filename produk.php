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
    include 'koneksi.php';

    // PAGINATION
    $limit = 6; // jumlah produk per halaman
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // PENCARIAN
    $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : "";

    // QUERY JUMLAH DATA (untuk pagination)
    $count_query = "SELECT COUNT(*) as total FROM products 
                    INNER JOIN categories ON products.category_id = categories.category_id
                    WHERE products.product_name LIKE '%$search%' OR categories.name LIKE '%$search%'";
    $count_result = mysqli_query($koneksi, $count_query);
    $total_data = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_data / $limit);

    // QUERY PRODUK
    $query = "SELECT products.product_id, products.product_name, products.price, products.product_picture, products.stock, categories.name 
            FROM products 
            INNER JOIN categories ON products.category_id = categories.category_id
            WHERE products.product_name LIKE '%$search%' OR categories.name LIKE '%$search%'
            ORDER BY products.product_name ASC
            LIMIT $limit OFFSET $offset";
    $result = mysqli_query($koneksi, $query);
?>


<div class="container my-5">
  <h2 class="text-center fw-semibold mb-4">Produk AlkesMart</h2>

  <!-- Pencarian -->
  <form class="d-flex mb-4" method="GET" action="">
    <input class="form-control me-2" type="search" name="search" placeholder="Cari produk atau kategori..." value="<?= htmlspecialchars($search) ?>">
    <button class="btn btn-outline-primary" type="submit">Cari</button>
  </form>

  <!-- Daftar Produk -->
  <div class="row">
    <?php while ($produk = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-4 mb-4">
            <a href="detail_produk.php?id=<?= $produk['product_id'] ?>" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm">
                    <img src="assets/images/produk/<?= $produk['product_picture'] ?>" class="card-img-top" alt="<?= $produk['product_name'] ?>" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <small class="text-body-secondary"><?= $produk['name'] ?></small>
                        <h5 class="card-title"><?= $produk['product_name'] ?></h5>
                        <p>Sisa stok : <?= $produk['stock']; ?></p>
                        <p class="card-text text-danger fw-bold">Rp <?= number_format($produk['price'], 0, ',', '.') ?></p>
                    </div>
                </div>
            </a>
        </div>
    <?php endwhile; ?>
  </div>

  <!-- Pagination -->
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
        <li class="page-item"><a class="page-link" href="?search=<?= $search ?>&page=<?= $page - 1 ?>">Sebelumnya</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
            <a class="page-link" href="?search=<?= $search ?>&page=<?= $i ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
        <li class="page-item"><a class="page-link" href="?search=<?= $search ?>&page=<?= $page + 1 ?>">Selanjutnya</a></li>
        <?php endif; ?>
    </ul>
  </nav>

</div>
<!-- Footer -->
<?php include('includes/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>