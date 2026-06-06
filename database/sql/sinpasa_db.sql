DROP TABLE IF EXISTS cache;
DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS barang_masuk;
DROP TABLE IF EXISTS cache_locks;
DROP TABLE IF EXISTS denah;
DROP TABLE IF EXISTS failed_jobs;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS job_batches;
DROP TABLE IF EXISTS kasbon;
DROP TABLE IF EXISTS konten;
DROP TABLE IF EXISTS migrations;
DROP TABLE IF EXISTS password_reset_tokens;
DROP TABLE IF EXISTS review;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS supplier;
DROP TABLE IF EXISTS tenant;
DROP TABLE IF EXISTS transaksi;
DROP TABLE IF EXISTS transaksi_barang;
DROP TABLE IF EXISTS users;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2026 at 06:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sinpasa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `barang_id` int(11) NOT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga_jual` decimal(10,2) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`barang_id`, `tenant_id`, `nama`, `harga_jual`, `stok`, `foto`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bayam', 3000.00, 18, 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fimg.mbizmarket.co.id%2Fproducts%2Fthumbs%2F800x800%2F2022%2F06%2F24%2Fbc0f5f02a5e3de48bfa3f90e9c3347e8.jpg&f=1&nofb=1&ipt=224cee24ce99d0d7315bc9e51b5f52332ea103fd2dd4a14e32ead5543d69b13f', '2026-05-16 02:06:40', '2026-06-02 07:18:04'),
(2, 1, 'Tomat', 4000.00, 2, NULL, '2026-05-17 00:10:16', '2026-05-24 06:20:12'),
(3, 1, 'Kangkung', 2000.00, 279, NULL, '2026-05-23 23:20:32', '2026-06-02 08:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `barang_masuk_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `barang_id` int(11) DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `harga_beli` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `unit` text NOT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `denah`
--

CREATE TABLE `denah` (
  `denah_id` varchar(10) NOT NULL,
  `blok` varchar(4) NOT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `posisi_x` int(100) NOT NULL,
  `posisi_y` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `denah`
--

INSERT INTO `denah` (`denah_id`, `blok`, `tenant_id`, `posisi_x`, `posisi_y`) VALUES
('KB001', 'KB', 1, 0, 0),
('KB002', 'KB', NULL, 0, 0),
('KB003', 'KB', NULL, 0, 0),
('KB004', 'KB', NULL, 0, 0),
('KB005', 'KB', NULL, 0, 0),
('KK007', 'KK', NULL, 0, 0),
('KK008', 'KK', NULL, 0, 0),
('KK009', 'KK', NULL, 0, 0),
('KK010', 'KK', NULL, 0, 0),
('KK011', 'KK', NULL, 0, 0),
('KK012', 'KK', NULL, 0, 0),
('KK013', 'KK', NULL, 0, 0),
('KK014', 'KK', NULL, 0, 0),
('KK015', 'KK', NULL, 0, 0),
('KK016', 'KK', NULL, 0, 0),
('KK017', 'KK', NULL, 0, 0),
('KK018', 'KK', NULL, 0, 0),
('KK019', 'KK', NULL, 0, 0),
('KK020', 'KK', NULL, 0, 0),
('KK021', 'KK', NULL, 0, 0),
('L001', 'L', NULL, 0, 0),
('L002', 'L', NULL, 0, 0),
('L003', 'L', NULL, 0, 0),
('L004', 'L', NULL, 0, 0),
('L005', 'L', NULL, 0, 0),
('L006', 'L', NULL, 0, 0),
('L007', 'L', NULL, 0, 0),
('L008', 'L', NULL, 0, 0),
('L009', 'L', NULL, 0, 0),
('L010', 'L', NULL, 0, 0),
('L011', 'L', NULL, 0, 0),
('L012', 'L', NULL, 0, 0),
('L013', 'L', NULL, 0, 0),
('L014', 'L', NULL, 0, 0),
('L015', 'L', NULL, 0, 0),
('L016', 'L', NULL, 0, 0),
('L017', 'L', NULL, 0, 0),
('L018', 'L', NULL, 0, 0),
('L019', 'L', NULL, 0, 0),
('L020', 'L', NULL, 0, 0),
('L021', 'L', NULL, 0, 0),
('L022', 'L', NULL, 0, 0),
('L023', 'L', NULL, 0, 0),
('L024', 'L', NULL, 0, 0),
('L025', 'L', NULL, 0, 0),
('L026', 'L', NULL, 0, 0),
('L027', 'L', NULL, 0, 0),
('L028', 'L', NULL, 0, 0),
('L029', 'L', NULL, 0, 0),
('L030', 'L', NULL, 0, 0),
('L031', 'L', NULL, 0, 0),
('L032', 'L', NULL, 0, 0),
('L033', 'L', NULL, 0, 0),
('L034', 'L', NULL, 0, 0),
('L035', 'L', NULL, 0, 0),
('L036', 'L', NULL, 0, 0),
('L037', 'L', NULL, 0, 0),
('L038', 'L', NULL, 0, 0),
('L039', 'L', NULL, 0, 0),
('L040', 'L', NULL, 0, 0),
('L041', 'L', NULL, 0, 0),
('L042', 'L', NULL, 0, 0),
('L043', 'L', NULL, 0, 0),
('L044', 'L', NULL, 0, 0),
('L045', 'L', NULL, 0, 0),
('L046', 'L', NULL, 0, 0),
('L047', 'L', NULL, 0, 0),
('L048', 'L', NULL, 0, 0),
('L049', 'L', NULL, 0, 0),
('L050', 'L', NULL, 0, 0),
('L051', 'L', NULL, 0, 0),
('L052', 'L', NULL, 0, 0),
('L053', 'L', NULL, 0, 0),
('L054', 'L', NULL, 0, 0),
('L055', 'L', NULL, 0, 0),
('L056', 'L', NULL, 0, 0),
('L057', 'L', NULL, 0, 0),
('L058', 'L', NULL, 0, 0),
('L059', 'L', NULL, 0, 0),
('L060', 'L', NULL, 0, 0),
('L061', 'L', NULL, 0, 0),
('L062', 'L', NULL, 0, 0),
('L063', 'L', NULL, 0, 0),
('L064', 'L', NULL, 0, 0),
('L065', 'L', NULL, 0, 0),
('L066', 'L', NULL, 0, 0),
('L067', 'L', NULL, 0, 0),
('L068', 'L', NULL, 0, 0),
('L069', 'L', NULL, 0, 0),
('L070', 'L', NULL, 0, 0),
('L071', 'L', NULL, 0, 0),
('L072', 'L', NULL, 0, 0),
('L073', 'L', NULL, 0, 0),
('L074', 'L', NULL, 0, 0),
('L075', 'L', NULL, 0, 0),
('L076', 'L', NULL, 0, 0),
('L077', 'L', NULL, 0, 0),
('L078', 'L', NULL, 0, 0),
('L079', 'L', NULL, 0, 0),
('L080', 'L', NULL, 0, 0),
('L081', 'L', NULL, 0, 0),
('L082', 'L', NULL, 0, 0),
('L083', 'L', NULL, 0, 0),
('L084', 'L', NULL, 0, 0),
('L085', 'L', NULL, 0, 0),
('L086', 'L', NULL, 0, 0),
('L087', 'L', NULL, 0, 0),
('L088', 'L', NULL, 0, 0),
('L089', 'L', NULL, 0, 0),
('L090', 'L', NULL, 0, 0),
('L091', 'L', NULL, 0, 0),
('L092', 'L', NULL, 0, 0),
('L093', 'L', NULL, 0, 0),
('L094', 'L', NULL, 0, 0),
('L095', 'L', NULL, 0, 0),
('L096', 'L', NULL, 0, 0),
('L097', 'L', NULL, 0, 0),
('L098', 'L', NULL, 0, 0),
('L099', 'L', NULL, 0, 0),
('L100', 'L', NULL, 0, 0),
('L101', 'L', NULL, 0, 0),
('L102', 'L', NULL, 0, 0),
('L103', 'L', NULL, 0, 0),
('L104', 'L', NULL, 0, 0),
('L105', 'L', NULL, 0, 0),
('L106', 'L', NULL, 0, 0),
('L107', 'L', NULL, 0, 0),
('L108', 'L', NULL, 0, 0),
('L109', 'L', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kasbon`
--

CREATE TABLE `kasbon` (
  `kasbon_id` int(11) NOT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `transaksi_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `tipe_kasbon` varchar(50) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `kontak` varchar(100) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `sisa` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tenggat` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kasbon`
--

INSERT INTO `kasbon` (`kasbon_id`, `tenant_id`, `transaksi_id`, `supplier_id`, `tipe_kasbon`, `nama`, `kontak`, `total`, `sisa`, `created_at`, `updated_at`, `tenggat`, `status`) VALUES
(1, 1, 2, NULL, 'pelanggan', 'Budi', '08727316972', 300000.00, 0.00, '2026-05-16 23:38:51', '2026-05-22 17:47:19', '2026-05-23', 'lunas'),
(2, 1, 9, NULL, 'pelanggan', 'Budi', NULL, 2000.00, 2000.00, '2026-05-28 08:43:15', '2026-05-28 08:43:15', '2026-06-27', 'belum_lunas');

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE `konten` (
  `konten_id` varchar(4) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `kategori` varchar(25) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konten`
--

INSERT INTO `konten` (`konten_id`, `user_id`, `judul`, `deskripsi`, `kategori`, `img_url`, `status`, `created_at`, `updated_at`) VALUES
('1', 1, 'Promo Idul Adha', 'Dalam merayakan hari raya Idul Adha, pasar sinpasa hadir dengan promo untuk semua tenant. Jangan sampai ketinggalan promo terbatas ini!', 'PROMO', '', 'nonaktif', '2026-05-30 04:48:09', '2026-05-31 07:44:38'),
('K001', 1, 'Lomba 17 Agustusan', 'Memperingati hari kemerdekaan Indonesia, Pasar Sinpasa mengadakan berbagai macam lomba untuk seluruh pengunjung pasar.', 'Event', 'konten/khdJiRscZDXJ398TlftCAr8iEWrah0D8hWEDypmY.jpg', 'aktif', '2026-05-31 07:43:47', '2026-05-31 07:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_17_050349_add_timestamps_to_tenant_table', 2),
(5, '2026_05_23_094459_add_phone_to_users_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `transaksi_id` int(11) DEFAULT NULL,
  `nama_reviewer` varchar(255) DEFAULT NULL,
  `deskripsi_review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('wWhuxiI7BHuQ2Pio1hLDMxxdmu9YSgbUiZ7sx4pd', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieUw1V3Y1Nk84emhPeHFXb0Yyb09zc2lHQ0RJemZRYTlZc3R4M0h0eiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZW5hbnQvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjE2OiJ0ZW5hbnQuZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1780414354);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `nama_supplier` varchar(255) DEFAULT NULL,
  `kontak` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `tenant_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_tenant` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `lama_kontrak` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`tenant_id`, `user_id`, `nama_tenant`, `kategori`, `foto`, `deskripsi`, `lama_kontrak`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 3, 'Toko Sayur RPL', 'Lapak Basah', 'storage/tenant-photos/01yQLlUX0l1eFXkArid34ZpfJ8dKUJdl7p6Vqsjs.png', 'Menjual berbagai macam sayuran.', 12, 1, '2026-05-16 02:00:27', '2026-05-29 08:14:26'),
(2, 9, 'Dimsum', NULL, NULL, NULL, NULL, NULL, '2026-05-17 00:07:58', '2026-05-17 00:07:58'),
(3, 10, 'Buah', NULL, NULL, NULL, NULL, NULL, '2026-05-17 00:10:58', '2026-05-17 00:10:58'),
(4, 11, 'Cilok Satsra Mesin', NULL, NULL, NULL, NULL, NULL, '2026-05-18 16:51:16', '2026-05-18 16:51:16');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `jumlah_bayar` decimal(10,2) DEFAULT NULL,
  `kembalian` decimal(10,2) DEFAULT NULL,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`transaksi_id`, `tenant_id`, `total`, `jumlah_bayar`, `kembalian`, `metode_bayar`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 6000.00, 6000.00, 0.00, 'QRIS', 'selesai', '2026-05-16 02:12:35', '2026-05-24 06:28:01'),
(2, 1, 300000.00, 250000.00, -50000.00, 'kasbon', 'diproses', '2026-05-16 23:34:06', '2026-05-24 06:28:01'),
(3, 1, 9000.00, 10000.00, 1000.00, 'tunai', 'selesai', '2026-05-17 01:07:16', '2026-05-24 06:28:01'),
(4, 1, 7000.00, 7000.00, 0.00, 'tunai', 'selesai', '2026-05-17 11:22:57', '2026-05-24 06:28:01'),
(8, 1, 46000.00, 46000.00, 0.00, 'tunai', 'selesai', '2026-05-23 23:29:34', '2026-05-23 23:29:34'),
(9, 1, 2000.00, 0.00, 0.00, 'kasbon', 'diproses', '2026-05-28 08:43:15', '2026-05-28 08:43:15'),
(10, 1, 4000.00, 6000.00, 2000.00, 'qris', 'selesai', '2026-05-28 15:10:22', '2026-05-28 15:10:22'),
(11, 1, 3000.00, 3000.00, 0.00, 'tunai', 'selesai', '2026-06-02 06:40:17', '2026-06-02 06:40:17'),
(12, 1, 3000.00, 3000.00, 0.00, 'tunai', 'selesai', '2026-06-02 07:18:04', '2026-06-02 07:18:04'),
(13, 1, 2000.00, 2000.00, 0.00, 'tunai', 'selesai', '2026-06-02 08:30:56', '2026-06-02 08:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_barang`
--

CREATE TABLE `transaksi_barang` (
  `transaksi_barang_id` int(11) NOT NULL,
  `transaksi_id` int(11) DEFAULT NULL,
  `barang_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_barang`
--

INSERT INTO `transaksi_barang` (`transaksi_barang_id`, `transaksi_id`, `barang_id`, `qty`, `harga`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 3000.00, 6000.00, '2026-05-24 06:28:39', '2026-05-24 06:28:39'),
(2, 2, 1, 100, 3000.00, 300000.00, '2026-05-24 06:28:39', '2026-05-24 06:28:39'),
(3, 3, 1, 3, 3000.00, 9000.00, '2026-05-24 06:28:39', '2026-05-24 06:28:39'),
(4, 4, 1, 1, 3000.00, 3000.00, '2026-05-24 06:28:39', '2026-05-24 06:28:39'),
(5, 4, 2, 1, 4000.00, 4000.00, '2026-05-24 06:28:39', '2026-05-24 06:28:39'),
(6, 8, 2, 3, 4000.00, 12000.00, '2026-05-24 06:29:34', '2026-05-24 06:29:34'),
(7, 8, 3, 17, 2000.00, 34000.00, '2026-05-24 06:29:34', '2026-05-24 06:29:34'),
(8, 9, 3, 1, 2000.00, 2000.00, '2026-05-28 15:43:15', '2026-05-28 15:43:15'),
(9, 10, 3, 2, 2000.00, 4000.00, '2026-05-28 22:10:22', '2026-05-28 22:10:22'),
(10, 11, 1, 1, 3000.00, 3000.00, '2026-06-02 13:40:17', '2026-06-02 13:40:17'),
(11, 12, 1, 1, 3000.00, 3000.00, '2026-06-02 14:18:04', '2026-06-02 14:18:04'),
(12, 13, 3, 1, 2000.00, 2000.00, '2026-06-02 15:30:56', '2026-06-02 15:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','tenant') NOT NULL DEFAULT 'tenant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Administrator', 'admin@sinpasa.com', NULL, NULL, '$2y$12$CiHqTMfSKBBujNRlZ14zIuU2Lc9uH9y2YGP2JnA3zxlpS3e.Vcpt6', 'UN7DZmqV6qursUmD6vOpWojoC2scGWNe5emxdHuTURfe7Re1m9WPbuRVgIpI', '2026-05-08 04:09:59', '2026-05-15 17:53:56', 'admin'),
(2, 'dadasdac', 'ellekyrabel@gmail.com', NULL, NULL, '$2y$12$42MyVaC.7Aug3bOwwDrhR.bHM41gcy9pB6tNfq3iVjh0oFLFmiT22', NULL, '2026-05-08 07:23:41', '2026-05-08 07:23:41', 'tenant'),
(3, 'rplstore', 'rpl@upi.edu', NULL, NULL, '$2y$12$be8aM/r7v5kkVRfWTaR5aOWvpzt0vZuAF/25oRGj6cOOKY0NWN3AK', 'hkyvwaIoDKJs8WH0sozAuffmaF0HnhPU49LgaPA8m1rR2lYW8aKoIfor0bF3', '2026-05-08 08:10:09', '2026-05-14 22:11:53', 'tenant'),
(9, 'Dimsum', 'dimsum@com', NULL, NULL, '$2y$12$4Fbii4i5/1oIO5BTFbbVeufT9YQ.ZTUVWA2vMICutOg0spPgPEe0S', NULL, '2026-05-17 00:07:58', '2026-05-17 00:07:58', 'tenant'),
(10, 'Buah', 'buah@com', NULL, NULL, '$2y$12$0dUko8zkh.wE5h7qhSM7/.pHjkG/VECdTOI1L5AaK/WfOjlkyLKSm', NULL, '2026-05-17 00:10:58', '2026-05-17 00:10:58', 'tenant'),
(11, 'Cilok Satsra Mesin', 'cukup@gmal.com', NULL, NULL, '$2y$12$GmrwTFV.omrndzmJsbUIzeDmovRsA97C7KMmE.ydAuMMYCX1AcRf.', NULL, '2026-05-18 16:51:16', '2026-05-18 16:51:16', 'tenant');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`barang_id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`barang_masuk_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `barang_id` (`barang_id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `denah`
--
ALTER TABLE `denah`
  ADD PRIMARY KEY (`denah_id`),
  ADD KEY `fk_denah_tenant` (`tenant_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kasbon`
--
ALTER TABLE `kasbon`
  ADD PRIMARY KEY (`kasbon_id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `konten`
--
ALTER TABLE `konten`
  ADD PRIMARY KEY (`konten_id`),
  ADD KEY `fk_konten_users` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`tenant_id`),
  ADD KEY `fk_tenant_user` (`user_id`) USING BTREE;

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  ADD PRIMARY KEY (`transaksi_barang_id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `barang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `barang_masuk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kasbon`
--
ALTER TABLE `kasbon`
  MODIFY `kasbon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `tenant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  MODIFY `transaksi_barang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`tenant_id`);

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`),
  ADD CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`tenant_id`);

--
-- Constraints for table `denah`
--
ALTER TABLE `denah`
  ADD CONSTRAINT `fk_denah_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`tenant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kasbon`
--
ALTER TABLE `kasbon`
  ADD CONSTRAINT `kasbon_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`tenant_id`),
  ADD CONSTRAINT `kasbon_ibfk_2` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`),
  ADD CONSTRAINT `kasbon_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`);

--
-- Constraints for table `konten`
--
ALTER TABLE `konten`
  ADD CONSTRAINT `fk_konten_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`);

--
-- Constraints for table `tenant`
--
ALTER TABLE `tenant`
  ADD CONSTRAINT `fk_tenant_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`tenant_id`);

--
-- Constraints for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  ADD CONSTRAINT `transaksi_barang_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`),
  ADD CONSTRAINT `transaksi_barang_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
