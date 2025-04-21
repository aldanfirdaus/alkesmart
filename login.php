<?php 
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - AlkesMart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style/style.css">
</head>
<body class="login-page">
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
    <div class="login-wrapper">
    <img src="assets/images/logo_bgred.png" alt="logo" class="logo mx-auto d-block rounded-4 mb-2" style="width: 130px; height: auto;">
      <div class="text-center mb-4">
        <h4 class="fw-bold text-dark">Selamat Datang di AlkesMart</h4>
        <p class="text-muted mb-1">Silakan login untuk melanjutkan belanja alat kesehatan berkualitas.</p>
      </div>
      <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
        <div class="alert alert-danger" role="alert">
          Username atau password salah.
        </div>
      <?php endif; ?>

      <form action="proses_login.php" method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-custom w-100">Login</button>
      </form>

      <div class="text-center mt-3">
        <small>Belum punya akun? <a href="registrasi.php">Registrasi di sini</a></small>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
