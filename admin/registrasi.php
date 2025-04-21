<?php
// Koneksi ke database
include '../koneksi.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fullname = mysqli_real_escape_string($koneksi, $_POST['fullname']);

    // Cek apakah username sudah ada
    $check = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        // Simpan ke database
        $insert = mysqli_query($koneksi, "INSERT INTO admin (username, password, fullname) VALUES ('$username', '$password', '$fullname')");
        if ($insert) {
            $success = "Registrasi berhasil! Silakan login.";
        } else {
            $error = "Gagal registrasi: " . mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Admin - Alkes Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #00c3ff, #ffff1c);
            min-height: 100vh;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        .btn-primary {
            border-radius: 20px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="container p-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 bg-white">
                    <h3 class="text-center mb-4">Registrasi Admin Alkes Mart</h3>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="fullname" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Daftar Admin</button>
                        </div>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="login_admin.php">Sudah punya akun? Login di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
