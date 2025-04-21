<?php 
include 'koneksi.php';
session_start();
if (!isset($_SESSION['customer_id'])) {
  header("Location: login.php");
  exit;
}

$customer_id = $_SESSION['customer_id'];
$customer_query = mysqli_query($koneksi, "SELECT * FROM customers WHERE customer_id = $customer_id");
$row = mysqli_fetch_assoc($customer_query);
$alamat = $row['address'];
$kodepos = $row['postal_code'];

$cart_query = mysqli_query($koneksi, "SELECT cart.*, products.product_name, products.price, products.product_picture FROM cart 
    JOIN products ON cart.product_id = products.product_id 
    WHERE cart.customer_id = $customer_id");
$cart_items = [];
$total_belanja = 0;

while ($row = mysqli_fetch_assoc($cart_query)) {
    $cart_items[] = $row;
    $total_belanja += $row['quantity'] * $row['price'];
}

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
  
  <div class="container mt-4">
    <h4 class="mb-3">Pembayaran</h4>

    <!-- Form Alamat & Pembayaran -->
    <form action="proses_payment.php" method="POST" enctype="multipart/form-data">
        <h5>Daftar Produk:</h5>
        <ul class="list-group mb-3">
            <?php foreach ($cart_items as $item): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <?= $item['product_name'] ?> x <?= $item['quantity'] ?>
                    <span>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
                </li>
            <?php endforeach; ?>
            <li class="list-group-item d-flex justify-content-between fw-bold">
                Total
                <span>Rp <?= number_format($total_belanja, 0, ',', '.') ?></span>
            </li>
        </ul>
        <div class="mb-3">
            <h5>Alamat Pengiriman : <?php echo $alamat;?>, Kode pos <?php echo $kodepos;?></h5>
            <label for="alamat" class="form-label"><i>Jika ubah alamat pengiriman, pergi ke akun saya</i></label>
        </div>

        <!-- Pilihan Metode Pembayaran -->
        <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                <option value="">-- Pilih Metode --</option>
                <option value="COD">COD (Bayar di Tempat)</option>
                <option value="BCA">Transfer Bank BCA</option>
                <option value="QRIS">QRIS</option>
            </select>
        </div>

        <!-- Info BCA -->
        <div id="rekening-info" class="mb-3">
            <label class="form-label">Transfer ke Rekening</label>
            <div class="alert alert-info">
                <strong>BCA:</strong> 1234567890 a.n. PT Alkes Mart Sejahtera
            </div>
        </div>

        <!-- Gambar QRIS -->
        <div id="qris-info" class="mb-3">
            <img src="assets/images/payment/qris.png" alt="QRIS" id="qris-image" class="img-thumbnail">
        </div>

        <!-- Upload Bukti Pembayaran -->
        <div id="upload-bukti" class="mb-3">
            <label class="form-label">Upload Bukti Pembayaran</label>
            <input type="file" name="bukti_transfer" class="form-control" accept="image/*" required>
        </div>

        <input type="hidden" name="total" value="<?= $total_belanja ?>">
        <a href="produk.php" class="btn btn-danger mt-3 mb-3">Kembali</a>
        <button type="submit" name="bayar" class="btn btn-success">Selesai</button>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const metodePembayaran = document.getElementById("metode_pembayaran");
        const rekeningInfo = document.getElementById("rekening-info");
        const qrisImage = document.getElementById("qris-image");
        const uploadBukti = document.getElementById("upload-bukti");

        // Fungsi untuk menyembunyikan semua info tambahan
        function resetPaymentInfo() {
            rekeningInfo.style.display = "none";
            qrisImage.style.display = "none";
            uploadBukti.style.display = "none";
        }

        // Jalankan saat halaman load
        resetPaymentInfo();

        // Saat user mengubah pilihan pembayaran
        metodePembayaran.addEventListener("change", function () {
            resetPaymentInfo();

            if (this.value === "BCA") {
                rekeningInfo.style.display = "block";
                uploadBukti.style.display = "block";
            } else if (this.value === "QRIS") {
                qrisImage.style.display = "block";
                uploadBukti.style.display = "block";
            }
        });
    });
  </script>

<!-- Footer -->
<?php include('includes/footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>