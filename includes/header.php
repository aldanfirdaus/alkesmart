<!-- CDN Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php 
    if (session_status() == PHP_SESSION_NONE) {
    session_start();}

    $cart_count = 0;
    if (isset($_SESSION['customer_id'])) {
        $user_id = $_SESSION['customer_id'];
        // Hitung jumlah item berbeda di keranjang
        $cart_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM cart WHERE customer_id = $user_id");
        $cart_data = mysqli_fetch_assoc($cart_query);
        $cart_count = $cart_data['total'] ?? 0;
    }
?>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container p-2">
      <a class="navbar-brand d-flex align-items-center">
        <img src="assets/images/logo_alkes.png" alt="logo" class="logo" style="position: absolute; top: 50%; transform: translateY(-50%); height: 200px; width: auto;">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="produk.php">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#tentang">Tentang Kami</a>
          </li>

          <?php if (isset($_SESSION['customer_id'])): 
            $id = $_SESSION['customer_id'];
            $query = mysqli_query($koneksi, "SELECT name FROM customers WHERE customer_id='$id'");
            $nama = mysqli_fetch_assoc($query); ?>
            <li class="nav-item">
              <a class="nav-link fs-6 fw-normal" href="akun_saya.php" role="button" title="Akun Saya">
                <i class="fa-solid fa-user fa-lg"></i> <?= $nama['name']; ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="riwayat_pesanan.php" role="button">
                Riwayat Pesanan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link position-relative" href="keranjang.php" title="keranjang belanja">
                  <i class="fa-solid fa-cart-shopping"></i>
                  <?php if ($cart_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                      <?= $cart_count ?>
                    </span>
                  <?php endif; ?>
              </a>
            </li>
            <li><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt fa-lg" title="logout"></i></a></li>
          <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="registrasi.php">Register</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
