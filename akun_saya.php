<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];
$alert = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $postal_code = $_POST['postal_code'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];

    // Cek jika username sudah digunakan user lain
    $check_username = mysqli_query($koneksi, "SELECT * FROM customers WHERE username = '$username' AND customer_id != $customer_id");
    if (mysqli_num_rows($check_username) > 0) {
        $alert = "<div class='alert alert-danger'>Username sudah digunakan oleh user lain.</div>";
    } else {
        mysqli_query($koneksi, "UPDATE customers SET name='$name', email='$email', address='$address', postal_code='$postal_code', phone='$phone', username='$username' WHERE customer_id=$customer_id");
        $alert = "<div class='alert alert-success'>Profil berhasil diperbarui.</div>";
    }
}

// Ganti Password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    $user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT password FROM customers WHERE customer_id = $customer_id"));
    if (!password_verify($old_password, $user['password'])) {
        $alert = "<div class='alert alert-danger'>Password lama salah.</div>";
    } else {
        $hashed_new = password_hash($new_password, PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE customers SET password='$hashed_new' WHERE customer_id = $customer_id");
        $alert = "<div class='alert alert-success'>Password berhasil diubah.</div>";
    }
}

// Ambil data user
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM customers WHERE customer_id = $customer_id"));
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

    <div class="container mt-5">
        <h3>Akun Saya</h3>
        <?= $alert ?>

        <!-- Form Update Profil -->
        <form method="POST" class="mb-5">
            <input type="hidden" name="update_profile" value="1">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="<?= $data['name'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Alamat</label>
                    <input type="text" name="address" class="form-control" value="<?= $data['address'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Kode Pos</label>
                    <input type="text" name="postal_code" class="form-control" value="<?= $data['postal_code'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>No. Telepon</label>
                    <input type="text" name="phone" class="form-control" value="<?= $data['phone'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Profil</button>
        </form>

        <!-- Form Ganti Password -->
        <form method="POST">
            <input type="hidden" name="change_password" value="1">
            <h5>Ganti Password</h5>
            <div class="mb-3">
                <label>Password Lama</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning">Update Password</button>
        </form>
    </div>

  <?php include('includes/footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>