-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 08:12 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alkesmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(64) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `fullname`) VALUES
(1, 'sons', '$2y$10$Q5e5J4dYLqHogta8nYcGnuciMO4Nf7xGvxpwGZFbzhsf0hh7ZKwk2', 'patrick sono');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(64) NOT NULL,
  `customer_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_id`, `product_id`, `quantity`) VALUES
(40, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(64) NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `picture`) VALUES
(1, 'Alat Bantu Dengar', 'alat-bantu-dengar.jpg'),
(2, 'Termometer', 'termometer.jpg'),
(3, 'Alat Fisiotrapi', 'fisiotrapi.jpg'),
(4, 'Tensimeter', 'tensimeter.jpg'),
(5, 'Alat Cek Darah', 'cek-darah.jpg'),
(6, 'Alat Bantu Jalan', 'alat-jalan.jpg'),
(7, 'Alat Terapi Pernapasan', 'terapi-pernapasan.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(64) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `address` varchar(100) NOT NULL,
  `postal_code` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `address`, `postal_code`, `phone`, `username`, `password`) VALUES
(1, 'M ALDAN ADIAR FIRDAUS', 'aldanfirdaus30@gmail.com', 'GUNUNGANYAR BARU II.B / 6', '60294', '0895606198968', 'aldan', '$2y$10$cI8lojJH/JlRMWkchjN9.u3XoWK9yRqD0qwgFThmxBxeZeUMz.zMq'),
(3, 'yani', 'aldanfirdaus30@gmail.com', 'jalan mawar no. 76', '60294', '0895606198968', 'yani', '$2y$10$9ix0QwVeou/lsgoiC1CvQe2xIRijlJ7GdzAJ4LI9hXZGPzIt/VVMq');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `detail_id` int(100) NOT NULL,
  `order_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `price` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 10, 1, 1, 500000),
(2, 11, 1, 1, 500000),
(3, 11, 4, 2, 200000),
(4, 13, 1, 4, 500000),
(5, 14, 1, 1, 500000),
(6, 15, 4, 2, 200000),
(7, 16, 3, 2, 39500),
(8, 17, 1, 1, 500000),
(9, 18, 2, 1, 950000),
(10, 19, 4, 1, 200000),
(11, 20, 4, 1, 200000),
(12, 21, 2, 1, 950000),
(13, 22, 2, 1, 950000),
(14, 23, 4, 1, 200000),
(15, 24, 2, 1, 950000),
(16, 25, 4, 1, 200000),
(17, 26, 2, 1, 950000),
(18, 27, 4, 1, 200000),
(19, 28, 4, 1, 200000),
(20, 29, 4, 1, 200000),
(21, 30, 4, 1, 200000),
(22, 30, 2, 1, 950000),
(23, 31, 2, 1, 950000),
(24, 31, 5, 2, 285000),
(25, 31, 3, 3, 39500);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `postal_code` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `payment` varchar(100) NOT NULL,
  `bukti_tf` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `total`, `address`, `postal_code`, `created_at`, `payment`, `bukti_tf`, `status`) VALUES
(18, 1, 950000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 11:11:00', 'QRIS', '1745140260_6804ba24cc54f.png', 'Belum dibayar'),
(19, 1, 200000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 13:41:21', 'BCA', '1745149281_6804dd61c68d8.jpeg', 'Belum dibayar'),
(20, 1, 200000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 13:47:44', 'BCA', '1745149664_6804dee0a1336.jpg', 'Sudah dibayar'),
(21, 1, 950000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 13:53:42', 'BCA', '1745150022_6804e0460dc2e.png', 'Belum dibayar'),
(22, 1, 950000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 13:55:50', 'BCA', '1745150150_6804e0c6bc1b1.png', 'Belum dibayar'),
(23, 1, 200000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 13:57:40', 'BCA', '1745150260_6804e13462f57.jpeg', 'Belum dibayar'),
(24, 1, 950000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 14:01:17', 'BCA', '1745150477_6804e20d828c2.jpeg', 'Belum dibayar'),
(25, 1, 200000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 14:03:00', 'BCA', '1745150580_6804e27449219.png', 'Belum dibayar'),
(26, 1, 950000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 14:04:38', 'QRIS', '1745150678_6804e2d6f0c96.jpeg', 'Belum dibayar'),
(27, 1, 200000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 14:24:26', 'BCA', '1745151866_6804e77ab7774.png', 'Belum dibayar'),
(28, 1, 200000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 14:36:43', 'BCA', '1745152603_6804ea5bab9ad.jpeg', 'Belum dibayar'),
(29, 1, 200000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 14:39:43', 'QRIS', '1745152783_6804eb0f4f4b4.png', 'Sudah dibayar'),
(30, 1, 1150000, 'GUNUNGANYAR BARU II.B / 6', '60294', '2025-04-20 14:41:02', 'QRIS', '1745152862_6804eb5e4d0aa.png', 'Sudah dibayar'),
(31, 3, 1638500, 'jalan mawar no. 76', '60294', '2025-04-20 23:45:47', 'BCA', '1745185547_68056b0b36dc8.jpeg', 'Belum dibayar');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(64) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category_id` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `description` longtext NOT NULL,
  `stock` int(100) NOT NULL,
  `product_picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category_id`, `price`, `description`, `stock`, `product_picture`) VALUES
(1, 'Alat Bantu Dengar Taff Omicron', '1', 49997, '\"Omicron alat bantu dengar\" mengacu pada alat bantu dengar yang diproduksi atau dipasarkan dengan merek \"Omicron\". Alat bantu dengar ini biasanya berbentuk earphone in-ear yang dirancang untuk membantu orang dengan gangguan pendengaran, terutama lansia, untuk mendengar lebih jelas. \r\nFitur dan Keunggulan:\r\nIn-Ear:\r\nBentuknya yang kecil dan pas di telinga memberikan kenyamanan dan kemudahan penggunaan. \r\nPengaturan Volume:\r\nMemiliki tombol pengaturan volume yang memungkinkan pengguna menyesuaikan suara sesuai kebutuhan mereka. \r\nBaterai Rechargeable:\r\nBeberapa model Omicron dilengkapi dengan baterai yang bisa diisi ulang, sehingga lebih praktis dan ekonomis. \r\nTahan Air:\r\nBeberapa model dirancang untuk tahan air, sehingga cocok untuk penggunaan di lingkungan yang lembab atau aktivitas sehari-hari. \r\nSuara Jernih:\r\nMampu meningkatkan kualitas suara yang didengar, sehingga memudahkan komunikasi dan aktivitas sehari-hari.', 3, 'alat_dengar.jpg'),
(2, 'Jumper Non Contac Forehead Thermometer JPD- FR202 / Thermometer', '2', 950000, 'Features One second read the temperature Suport to measure the body temperature and Object temperature Three backlight Support silent mode Provide two temperature modes and F Memory recalls last 20 temperature readings Intelligent Fever Alarm (Over 37.5/99.5F) Specification: Working voltage : DC3V Battey: AAA2 Battery life: 20000 times Operation mode : continuous work Display mode : LCD screen Measuring time: 1s Measuring distance: 15cm temperature modes : F Measurement range: (1)Body temperature: 32.042.289.6F-108.0F (2)Object temperature: 0.0100.032.0F212.0F Accuracy : 0.3 /0.6F Fever Alarm : 37.5 Repeatability:0.1 Memories: 20 datas Backlight: Green , Red , White Auto off time: 10 seconds', 5, 'infrared_termometer.jpeg'),
(3, 'Melife ME-210 Termometer Digital Flexible 10 Detik', '2', 39500, 'Termometer Digital Dengan Ujung Flexibel Melife ME-210\r\n\r\nKelebihan :\r\n\r\n- Ujung Fleksibel yang Nyaman\r\n\r\n- Notifikasi Bunyi Beep Elegan\r\n\r\n- Waktu Pengukuran Cepat dalam 10 Detik\r\n\r\n- Rentang Pengukuran: 32,0 °C hingga 42,9 °C\r\n\r\n- Alarm Demam Cerdas\r\n\r\n- Desain Tahan Air Premium\r\n\r\n- Pengingat Pembacaan Terakhir yang Praktis\r\n\r\n- Indikator Garis Demam yang Terlihat Jelas\r\n\r\n- Fitur Mati Otomatis yang Hemat Energi\r\n\r\n- Termasuk Baterai 1,5 V untuk Penggunaan Langsung', 26, 'termometer.png'),
(4, 'Alat fisioterapi set Lampu Terapi infra red PHILIPS 150W Hi', '3', 200000, 'Alat fisioterapi set Lampu Terapi infra red infra merah infrared Terapi otot  sendi pegal stroke\r\n\r\n\r\n\r\nSET KOMPLIT TINGGAL PAKAI GAK PAKEK RIBET.\r\n\r\n\r\n\r\n\"AWAS TERTIPU BARANG MURAHAN, KAMI JAMIN BARANG KAMI ADALAH ORIGINAL YANG MANA ORIGINAL ADALAH KUALITAS TERBAIK !!! \" \r\n\r\n(LAMPU ORI PHILIPS 100watt - 150watt\r\n\r\nNote : Fitting/ model sudah disesuaikan untuk lampu terapi 100watt - 150watt. Garansi!!\r\n\r\nHati-hati dengan barang terlihat murah tapi tidak sesuai standart bisa merusak lampu/meleleh rusak.\r\nBohlam Infraphill Philips merupakan lampu terapi inframerah dengan penetrasi sinar infra merah yang mampu menembus ke dalam lapisan kulit, menimbulkan sensasi hangat dan nyaman sekaligus menghasilkan segudang manfaat bagi tubuh.\r\nManfaat :\r\n- Meremajakan kulit, mencerahkan warna dan elastisitas kulit \r\n- Memperlancar peredaran darah dan metabolisme tubuh \r\n- Membantu meredakan rasa nyeri, pegal dan sakit akibat ketegangan otot atau persendian\r\n- Meningkatkan kekebalan tubuh terhadap penyakit\r\n- cocok digunakan untuk penderita rematik oestoporosi, pegal pegal, batuk dan pilek. ', 25, 'terapi_infra_red.jpg'),
(5, 'Walker Alat Bantu Jalan Lansia Manula / Walker GEA ', '6', 285000, 'Walker FS913L merupakan alat bantu jalan untuk orang tua, yang berbentuk seperti jemuran, tanpa roda.\r\n\r\nWalker / alat bantu jalan ini sangat cocok untuk digunakan sebagai alat fisioterapi, ataupun digunakan oleh orang tua karena dapat dijadikan tumpuan tubuh melalui kedua tangan.\r\n\r\nSelain itu, Walker GEA / Sella / Onemed ini dapat diatur ketinggiannya untuk disesuaikan dengan tinggi tubuh penggunanya.\r\n\r\nSpesifikasi produk:\r\n- Bahan: Stainless\r\n- Ketinggian: 80-98cm (Dapat diatur/adjustable dengan 4 buah pin di setiap kaki)\r\n- Berat Bersih: 2.5 kg\r\n- Lebar Luar: 51 cm\r\n- Lebar Dalam: 45 cm\r\n- Tinggi Minimal: 78 cm\r\n- Tinggi Maksimal: 92 cm', 6, '1745182894_bbbe78d17bed366567fd9cd4a0db7acf.jpeg'),
(7, 'nebulizer alat uap dewasa Alat Terapi Bantu Pernafasan Ultrasonic Nebulizer Portable Inhaler', '7', 109500, 'Detail produk nebulizer alat uap dewasa Alat Terapi Bantu Pernafasan Ultrasonic Nebulizer Portable Inhaler Alat Bantu Sesak Nafas Terapi Uap Nebulizer Inhaler Portable Mesh Alat Bantu Pernapasan Uap Mini Genggam Yang Dapat diisi Ulang Bantu Terapi\r\n\r\nNama: Alat penyemprot ultrasonik medis\r\nCatu daya: baterai lithium 1200mA\r\nTingkat semprotan: Lebih besar dari 0,5mL / mnt\r\nDiameter partikel semprotan: Proporsi partikel semprotan kurang dari 9um lebih besar dari 50%\r\nKapasitas cangkir cair: Max.8ML\r\nKebisingan: Di bawah 50db\r\nWaktu atomisasi: Waktu yang tersedia terisi penuh lebih dari 120 menit\r\nBerat: Sekitar 100g\r\nAlat ini dapat digunakan untuk memberikan obat ke dalam paru paru seseorang dalam bentuk partikel halus / cairan ke uap, memberikan kelegaan pada pernafasan Anda agar menjadi lebih baik dan sehat\r\nNebulizer Inhale Alat ini dapat memberikan terapi yang baik dan kelegaan bagi pernafasan Anda, biasanya orang tua dan para perokok berat akan mengalami gangguan pernafasan, ataupun bagi para penderita paru-paru basah / bronhitis\r\nPompa piston efisiensi tinggi bebas oli. Meredakan dahak dan batuk\r\nOperasi Yang Hening Alat ini bekerja tanpa menimbulkan kebisingan, Anda tetap dapat istirahat dengan tenang menggunakan alat ini.\r\nDapat Digunakan Pada Berbagai Area Anda dapat menggunakan alat ini melalui hidung ataupun mulut, Telah tersedia berbagai betuk corong udara untuk keperluan pengobatan\r\nMudah Digunakan Cara penggunaan alat ini mudah, cukup isi tabung air dengan air obat dan nyalakan alat, tunggu beberapa saat', 17, '1745182675_Sf4e658da421443c085d578b21d0e495a7.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `detail_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
