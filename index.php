<?php 
include 'koneksi.php';
session_start();
// if (!isset($_SESSION['customer_id'])) {
//   header("Location: login.php");
//   exit;
// }
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

  <!-- slideshow -->
<div id="carouselAlkesMart" class="carousel slide mt-5" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselAlkesMart" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselAlkesMart" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselAlkesMart" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner position-relative">
    <div class="carousel-item active">
      <img src="assets/images/slideshow1.jpg" class="d-block mx-auto img-fluid" alt="Slide 1" style="width: 80%; max-height: 350px; border-radius: 20px; position: relative;">
    </div>
    <div class="carousel-item">
      <img src="assets/images/slideshow2.jpg" class="d-block mx-auto img-fluid" alt="Slide 2" style="width: 80%; max-height: 350px; border-radius: 20px; position: relative;"">
    </div>
    <div class="carousel-item">
      <img src="assets/images/slideshow3.jpg" class="d-block mx-auto img-fluid" alt="Slide 3" style="width: 80%; max-height: 350px; border-radius: 20px; position: relative;"">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselAlkesMart" data-bs-slide="prev" style="width: 30%;">
    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: #9c1b2e; border-radius: 50%; padding: 20px;"></span>
    <span class="visually-hidden">Sebelumnya</span>
  </button> 
  <button class="carousel-control-next" type="button" data-bs-target="#carouselAlkesMart" data-bs-slide="next" style="width: 30%;">
    <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: #9c1b2e; border-radius: 50%; padding: 20px;"></span>
    <span class="visually-hidden">Selanjutnya</span>
  </button>
</div>

<?php include 'koneksi.php'; ?>

<section class="container my-5">
  <h3 class="text-center mb-4 fw-bold">Kategori Produk</h3>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

    <?php
    $query = mysqli_query($koneksi, "SELECT * FROM categories");
    while ($data = mysqli_fetch_assoc($query)) {
    ?>

        <a href="produk.php?kategori=<?= $data['category_id']; ?>" class="text-decoration-none text-dark">
        <div class="card text-center shadow-sm h-100 hover-shadow">
            <div class="card-body">
            <img src="assets/images/kategori/<?= $data['picture']; ?>" 
                class="img-fluid mb-3" 
                style="height: 150px;" 
                alt="<?= $data['name']; ?>">
            <h5 class="card-title"><?= $data['name']; ?></h5>
            </div>
        </div>
        </a>      
    <?php } ?>

  </div>
</section>

<!-- Tentang Kami -->
<section id="tentang" class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="fw-bold">Tentang Kami</h2>
      <p class="text-muted">Kenali AlkesMart lebih dekat</p>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <p style="text-align: justify;">
          <strong>AlkesMart</strong> adalah platform e-commerce yang menyediakan berbagai alat kesehatan berkualitas, aman, dan terpercaya. Kami berkomitmen untuk memberikan kemudahan dalam memenuhi kebutuhan kesehatan Anda dengan produk yang lengkap, harga terjangkau, dan pengiriman yang cepat.
        </p>
        <p style="text-align: justify;">
          Dengan tim yang profesional dan dukungan teknologi terkini, AlkesMart hadir sebagai solusi belanja alat kesehatan modern dari rumah Anda. Kepuasan pelanggan adalah prioritas utama kami.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<?php include('includes/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>