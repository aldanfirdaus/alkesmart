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

  <!-- Registration Form -->
  <div class="register-card">
    <h3 class="text-center mb-4">Registrasi Customer</h3>
    <form action="proses_registrasi.php" method="POST">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat Lengkap</label>
        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
      </div>
      <div class="mb-3">
        <label for="kodepos" class="form-label">Kode Pos</label>
        <input type="number" class="form-control" id="kodepos" name="kodepos" required>
      </div>
      <div class="mb-3">
        <label for="telp" class="form-label">No. Telepon</label>
        <input type="number" class="form-control" id="telp" name="telp" required>
      </div>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'username_terpakai') : ?>
        <div class="alert alert-danger" role="alert">
            Username sudah terdaftar. Silakan gunakan username lain.
        </div>
      <?php endif; ?>
      <div class="mb-3">
        <label for="pass" class="form-label">Password</label>
        <input type="password" class="form-control" id="pass" name="password" required>
      </div>
      <button type="submit" class="btn btn-custom w-100">Daftar Sekarang</button>
      <div class="text-center mt-3">
        <small>Sudah punya akun? <a href="login.php">Login di sini</a></small>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>