/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `alats`;
CREATE TABLE `alats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_alat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint unsigned DEFAULT NULL,
  `kode_alat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alats_kode_alat_unique` (`kode_alat`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kategoris`;
CREATE TABLE `kategoris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `peminjamans`;
CREATE TABLE `peminjamans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `alat_id` bigint unsigned NOT NULL,
  `jumlah_pinjam` int NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `status` enum('pending','dipinjam','dikembalikan','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `denda` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peminjamans_user_id_foreign` (`user_id`),
  KEY `peminjamans_alat_id_foreign` (`alat_id`),
  CONSTRAINT `peminjamans_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alats` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peminjamans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `activity_logs` (`id`, `user_id`, `activity`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tambah Kategori', 'admin menambah kategori baru: Alat Kebersihan', '2026-04-07 17:06:18', '2026-04-07 17:06:18'),
(2, 1, 'Tambah Kategori', 'admin menambah kategori baru: Elektronik', '2026-04-07 17:06:29', '2026-04-07 17:06:29'),
(3, 1, 'Tambah Alat', 'admin menambahkan alat baru: Sapu lidi (1)', '2026-04-07 17:07:09', '2026-04-07 17:07:09'),
(4, 1, 'Tambah Alat', 'admin menambahkan alat baru: Sapu ijuk (2)', '2026-04-07 17:07:31', '2026-04-07 17:07:31'),
(5, 1, 'Tambah Alat', 'admin menambahkan alat baru: Serokan (3)', '2026-04-07 17:07:59', '2026-04-07 17:07:59'),
(6, 1, 'Tambah Alat', 'admin menambahkan alat baru: Pel (4)', '2026-04-07 17:08:27', '2026-04-07 17:08:27'),
(7, 1, 'Tambah Alat', 'admin menambahkan alat baru: Kemoceng (5)', '2026-04-07 17:08:53', '2026-04-07 17:08:53'),
(8, 1, 'Tambah Alat', 'admin menambahkan alat baru: ember (6)', '2026-04-07 17:09:17', '2026-04-07 17:09:17'),
(9, 1, 'Tambah Alat', 'admin menambahkan alat baru: laptop (7)', '2026-04-07 17:09:39', '2026-04-07 17:09:39'),
(10, 1, 'Tambah Alat', 'admin menambahkan alat baru: Laptop (8)', '2026-04-07 17:10:02', '2026-04-07 17:10:02'),
(11, 1, 'Tambah User', 'admin menambah user baru: Petugas Sarpras ()', '2026-04-08 14:46:13', '2026-04-08 14:46:13'),
(12, 1, 'Update User', 'admin mengubah data user: Petugas Sarpras', '2026-04-08 14:50:26', '2026-04-08 14:50:26'),
(13, 1, 'Hapus User', 'admin menghapus user: Test User', '2026-04-09 15:10:29', '2026-04-09 15:10:29'),
(14, 1, 'Tambah User', 'admin menambah user baru: arizky ()', '2026-04-09 15:11:36', '2026-04-09 15:11:36'),
(15, 1, 'Tambah User', 'admin menambah user baru: aulia sebagai ', '2026-04-17 07:47:17', '2026-04-17 07:47:17'),
(16, 1, 'Tambah Kategori', 'admin menambah kategori baru: Furniture', '2026-04-17 11:42:13', '2026-04-17 11:42:13'),
(17, 1, 'Tambah Alat', 'admin menambahkan alat baru: tempat sampah (9)', '2026-04-17 11:43:23', '2026-04-17 11:43:23'),
(18, 1, 'Tambah Kategori', 'admin menambah kategori baru: Peralatan Olahraga', '2026-04-17 11:43:55', '2026-04-17 11:43:55'),
(19, 1, 'Tambah Alat', 'admin menambahkan alat baru: kursi (10)', '2026-04-17 11:45:43', '2026-04-17 11:45:43'),
(20, 1, 'Tambah Alat', 'admin menambahkan alat baru: meja (11)', '2026-04-17 11:46:04', '2026-04-17 11:46:04'),
(21, 1, 'Tambah Alat', 'admin menambahkan alat baru: lemari buku (12)', '2026-04-17 11:46:29', '2026-04-17 11:46:29'),
(22, 1, 'Tambah Alat', 'admin menambahkan alat baru: bola basket (13)', '2026-04-17 11:46:55', '2026-04-17 11:46:55'),
(23, 1, 'Tambah Alat', 'admin menambahkan alat baru: bola volly (14)', '2026-04-17 11:47:23', '2026-04-17 11:47:23'),
(24, 1, 'Tambah Alat', 'admin menambahkan alat baru: bola futsal (15)', '2026-04-17 11:48:26', '2026-04-17 11:48:26'),
(25, 1, 'Tambah Alat', 'admin menambahkan alat baru: Net (16)', '2026-04-17 11:49:12', '2026-04-17 11:49:12'),
(26, 1, 'Update Alat', 'admin memperbarui data alat: bola futsal', '2026-04-17 11:49:29', '2026-04-17 11:49:29'),
(27, 1, 'Update Alat', 'admin memperbarui data alat: bola volly', '2026-04-17 11:49:49', '2026-04-17 11:49:49'),
(28, 1, 'Update Alat', 'admin memperbarui data alat: bola basket', '2026-04-17 11:50:08', '2026-04-17 11:50:08'),
(29, 1, 'Tambah Alat', 'admin menambahkan alat baru: matras (17)', '2026-04-17 11:50:55', '2026-04-17 11:50:55'),
(30, 1, 'Tambah Alat', 'admin menambahkan alat baru: komputer (18)', '2026-04-17 11:51:57', '2026-04-17 11:51:57'),
(31, 1, 'Tambah Alat', 'admin menambahkan alat baru: proyektor (19)', '2026-04-17 11:52:45', '2026-04-17 11:52:45'),
(32, 1, 'Tambah Alat', 'admin menambahkan alat baru: printer (20)', '2026-04-17 11:53:20', '2026-04-17 11:53:20'),
(33, 1, 'Tambah Alat', 'admin menambahkan alat baru: speaker (21)', '2026-04-17 11:53:43', '2026-04-17 11:53:43'),
(34, 1, 'Tambah Alat', 'admin menambahkan alat baru: terminal (22)', '2026-04-17 11:57:52', '2026-04-17 11:57:52');
INSERT INTO `alats` (`id`, `nama_alat`, `kategori_id`, `kode_alat`, `kondisi`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 'Sapu lidi', 1, '1', 'baru', 16, '2026-04-07 17:07:09', '2026-04-20 08:24:52'),
(2, 'Sapu ijuk', 1, '2', 'baru', 9, '2026-04-07 17:07:31', '2026-04-20 08:18:54'),
(3, 'Serokan', 1, '3', 'baru', 13, '2026-04-07 17:07:59', '2026-04-20 07:55:15'),
(4, 'Pel', 1, '4', 'baru', 12, '2026-04-07 17:08:27', '2026-04-20 07:55:06'),
(5, 'Kemoceng', 1, '5', 'baru', 11, '2026-04-07 17:08:53', '2026-04-16 13:34:38'),
(6, 'ember', 1, '6', 'baru', 11, '2026-04-07 17:09:17', '2026-04-16 13:34:30'),
(7, 'laptop', 2, '7', 'baru', 10, '2026-04-07 17:09:39', '2026-04-07 17:09:39'),
(8, 'Laptop', 2, '8', 'bekas', 10, '2026-04-07 17:10:02', '2026-04-07 17:10:02'),
(9, 'tempat sampah', 1, '9', 'baru', 20, '2026-04-17 11:43:23', '2026-04-17 11:43:23'),
(10, 'kursi', 3, '10', 'baru', 100, '2026-04-17 11:45:43', '2026-04-17 11:45:43'),
(11, 'meja', 3, '11', 'baru', 100, '2026-04-17 11:46:04', '2026-04-17 11:46:04'),
(12, 'lemari buku', 3, '12', 'baru', 12, '2026-04-17 11:46:29', '2026-04-17 11:46:29'),
(13, 'bola basket', 4, '13', 'bekas', 5, '2026-04-17 11:46:55', '2026-04-17 11:50:08'),
(14, 'bola volly', 4, '14', 'bekas', 5, '2026-04-17 11:47:23', '2026-04-17 11:49:49'),
(15, 'bola futsal', 4, '15', 'bekas', 5, '2026-04-17 11:48:26', '2026-04-17 11:49:29'),
(16, 'Net', 4, '16', 'bekas', 2, '2026-04-17 11:49:12', '2026-04-17 11:49:12'),
(17, 'matras', 4, '17', 'bekas', 5, '2026-04-17 11:50:55', '2026-04-17 11:50:55'),
(18, 'komputer', 2, '18', 'bekas', 5, '2026-04-17 11:51:57', '2026-04-17 11:51:57'),
(19, 'proyektor', 2, '19', 'bekas', 4, '2026-04-17 11:52:45', '2026-04-17 11:52:45'),
(20, 'printer', 2, '20', 'bekas', 2, '2026-04-17 11:53:20', '2026-04-17 11:53:20'),
(21, 'speaker', 2, '21', 'bekas', 5, '2026-04-17 11:53:43', '2026-04-17 11:53:43'),
(22, 'terminal', 2, '22', 'bekas', 5, '2026-04-17 11:57:52', '2026-04-17 11:57:52');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-nadira123@gmail.com|127.0.0.1', 'i:1;', 1775579013),
('laravel-cache-nadira123@gmail.com|127.0.0.1:timer', 'i:1775579013;', 1775579013),
('laravel-cache-nadiraarizky12@gmail.com|127.0.0.1', 'i:2;', 1775580116),
('laravel-cache-nadiraarizky12@gmail.com|127.0.0.1:timer', 'i:1775580116;', 1775580116);




INSERT INTO `kategoris` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Alat Kebersihan', '2026-04-07 17:06:18', '2026-04-07 17:06:18'),
(2, 'Elektronik', '2026-04-07 17:06:29', '2026-04-07 17:06:29'),
(3, 'Furniture', '2026-04-17 11:42:13', '2026-04-17 11:42:13'),
(4, 'Peralatan Olahraga', '2026-04-17 11:43:55', '2026-04-17 11:43:55');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_07_093746_create_alats_table', 1),
(5, '2026_02_09_140928_add_role_to_users_table', 1),
(6, '2026_02_10_020018_create_roles_table', 1),
(7, '2026_02_10_134917_create_kategoris_table', 1),
(8, '2026_02_10_151339_tambah_kategori_ke_alats', 1),
(9, '2026_02_10_152050_create_peminjamans_table', 1),
(10, '2026_02_11_120751_create_activity_logs_table', 1);

INSERT INTO `peminjamans` (`id`, `user_id`, `alat_id`, `jumlah_pinjam`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `denda`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 3, '2026-04-08 17:13:41', '2026-04-10 17:13:41', 'dikembalikan', '0.00', '2026-04-08 17:13:41', '2026-04-08 17:31:42'),
(2, 3, 1, 1, '2026-04-08 17:21:36', '2026-04-08 07:30:00', 'dikembalikan', '0.00', '2026-04-08 17:21:36', '2026-04-08 14:04:38'),
(3, 3, 1, 3, '2026-04-08 15:30:08', '2026-04-08 23:04:00', 'dikembalikan', '0.00', '2026-04-08 15:30:08', '2026-04-08 23:02:31'),
(4, 3, 3, 1, '2026-04-08 15:30:23', '2026-04-09 22:35:00', 'dikembalikan', '0.00', '2026-04-08 15:30:23', '2026-04-08 15:39:17'),
(5, 3, 4, 1, '2026-04-08 15:30:50', '2026-04-08 22:33:00', 'dikembalikan', '0.00', '2026-04-08 15:30:50', '2026-04-08 15:39:09'),
(6, 3, 1, 1, '2026-04-08 22:46:08', '2026-04-08 23:02:00', 'dikembalikan', '0.00', '2026-04-08 22:46:08', '2026-04-08 23:02:23'),
(7, 3, 1, 1, '2026-04-08 23:08:03', '2026-04-11 23:08:03', 'ditolak', '0.00', '2026-04-08 23:08:03', '2026-04-08 23:34:22'),
(8, 3, 2, 1, '2026-04-08 23:16:49', '2026-04-08 22:23:00', 'dikembalikan', '0.00', '2026-04-08 23:16:49', '2026-04-10 16:14:03'),
(9, 3, 1, 1, '2026-04-09 15:07:44', '2026-04-10 15:59:00', 'dikembalikan', '5000.00', '2026-04-09 15:07:44', '2026-04-10 17:50:56'),
(10, 3, 2, 1, '2026-04-09 15:08:02', '2026-04-10 15:59:00', 'dikembalikan', '0.00', '2026-04-09 15:08:02', '2026-04-10 15:58:11'),
(11, 3, 3, 1, '2026-04-09 15:08:17', '2026-04-09 15:16:00', 'dikembalikan', '0.00', '2026-04-09 15:08:17', '2026-04-10 16:14:11'),
(12, 3, 3, 1, '2026-04-09 15:08:32', '2026-04-09 15:15:00', 'dikembalikan', '0.00', '2026-04-09 15:08:32', '2026-04-10 16:27:26'),
(13, 3, 4, 1, '2026-04-09 15:08:49', '2026-04-09 15:15:00', 'dikembalikan', '0.00', '2026-04-09 15:08:49', '2026-04-10 16:28:00'),
(14, 3, 5, 1, '2026-04-09 15:09:04', '2026-04-09 15:14:00', 'dikembalikan', '5000.00', '2026-04-09 15:09:04', '2026-04-09 16:42:36'),
(15, 3, 6, 1, '2026-04-09 15:09:17', '2026-04-09 15:14:00', 'dikembalikan', '5000.00', '2026-04-09 15:09:17', '2026-04-09 17:35:26'),
(16, 6, 1, 1, '2026-04-10 15:55:23', '2026-04-10 15:58:00', 'dikembalikan', '5000.00', '2026-04-10 15:55:23', '2026-04-10 15:59:08'),
(17, 3, 1, 1, '2026-04-10 17:46:12', '2026-04-10 17:51:00', 'dikembalikan', '5000.00', '2026-04-10 17:46:12', '2026-04-10 17:51:04'),
(18, 3, 2, 1, '2026-04-10 17:46:27', '2026-04-10 17:51:00', 'dikembalikan', '5000.00', '2026-04-10 17:46:27', '2026-04-10 17:51:11'),
(19, 3, 1, 1, '2026-04-10 17:51:48', '2026-04-16 09:00:00', 'dikembalikan', '5000.00', '2026-04-10 17:51:48', '2026-04-16 12:58:32'),
(20, 3, 3, 1, '2026-04-10 17:52:13', '2026-04-16 09:00:00', 'dikembalikan', '5000.00', '2026-04-10 17:52:13', '2026-04-16 12:45:20'),
(21, 3, 4, 1, '2026-04-10 17:52:42', '2026-04-17 13:00:00', 'dikembalikan', '5000.00', '2026-04-10 17:52:42', '2026-04-20 07:55:06'),
(22, 6, 1, 1, '2026-04-16 07:22:48', '2026-04-16 09:00:00', 'dipinjam', '0.00', '2026-04-16 07:22:48', '2026-04-16 07:26:22'),
(23, 6, 2, 1, '2026-04-16 07:23:14', '2026-04-16 09:00:00', 'dipinjam', '0.00', '2026-04-16 07:23:14', '2026-04-16 07:33:29'),
(24, 6, 3, 1, '2026-04-16 07:23:30', '2026-04-16 09:00:00', 'dikembalikan', '5000.00', '2026-04-16 07:23:30', '2026-04-17 11:35:56'),
(25, 3, 1, 1, '2026-04-16 07:34:46', '2026-04-16 09:00:00', 'dikembalikan', '5000.00', '2026-04-16 07:34:46', '2026-04-16 12:58:38'),
(26, 3, 1, 1, '2026-04-16 12:58:51', '2026-04-19 12:58:51', 'pending', '0.00', '2026-04-16 12:58:51', '2026-04-16 12:58:51'),
(27, 3, 3, 1, '2026-04-16 12:59:02', '2026-04-16 16:40:00', 'dikembalikan', '5000.00', '2026-04-16 12:59:02', '2026-04-20 07:55:15'),
(28, 3, 4, 1, '2026-04-16 13:00:20', '2026-04-16 13:40:00', 'dikembalikan', '0.00', '2026-04-16 13:00:20', '2026-04-16 13:34:46'),
(29, 3, 5, 1, '2026-04-16 13:00:32', '2026-04-16 13:40:00', 'dikembalikan', '0.00', '2026-04-16 13:00:32', '2026-04-16 13:34:38'),
(30, 3, 6, 1, '2026-04-16 13:03:29', '2026-04-16 13:40:00', 'dikembalikan', '0.00', '2026-04-16 13:03:29', '2026-04-16 13:34:30'),
(31, 3, 7, 1, '2026-04-16 13:06:29', '2026-04-19 13:06:29', 'pending', '0.00', '2026-04-16 13:06:29', '2026-04-16 13:06:29'),
(32, 3, 3, 1, '2026-04-16 13:10:51', '2026-04-19 13:10:51', 'pending', '0.00', '2026-04-16 13:10:51', '2026-04-16 13:10:51'),
(33, 3, 1, 1, '2026-04-16 13:19:10', '2026-04-19 13:19:10', 'pending', '0.00', '2026-04-16 13:19:10', '2026-04-16 13:19:10'),
(34, 3, 1, 2, '2026-04-16 13:34:19', '2026-04-17 12:00:00', 'dikembalikan', '5000.00', '2026-04-16 13:34:19', '2026-04-20 07:55:22'),
(35, 7, 1, 4, '2026-04-17 07:48:56', '2026-04-20 07:48:56', 'ditolak', '0.00', '2026-04-17 07:48:56', '2026-04-17 07:50:07'),
(36, 7, 2, 1, '2026-04-17 07:52:16', '2026-04-17 11:04:00', 'dipinjam', '0.00', '2026-04-17 07:52:16', '2026-04-17 07:53:31'),
(37, 7, 1, 1, '2026-04-17 07:55:18', '2026-04-20 07:55:18', 'pending', '0.00', '2026-04-17 07:55:18', '2026-04-17 07:55:18'),
(38, 6, 1, 2, '2026-04-17 11:35:49', '2026-04-20 11:35:49', 'pending', '0.00', '2026-04-17 11:35:49', '2026-04-17 11:35:49'),
(39, 6, 2, 1, '2026-04-17 11:36:13', '2026-04-20 11:36:13', 'pending', '0.00', '2026-04-17 11:36:13', '2026-04-17 11:36:13'),
(40, 6, 4, 1, '2026-04-17 11:36:25', '2026-04-20 11:36:25', 'pending', '0.00', '2026-04-17 11:36:25', '2026-04-17 11:36:25'),
(41, 6, 5, 1, '2026-04-17 11:37:18', '2026-04-20 11:37:18', 'pending', '0.00', '2026-04-17 11:37:18', '2026-04-17 11:37:18'),
(42, 3, 1, 1, '2026-04-20 07:56:19', '2026-04-23 07:56:19', 'pending', '0.00', '2026-04-20 07:56:19', '2026-04-20 07:56:19'),
(43, 3, 1, 1, '2026-04-20 08:14:53', '2026-04-20 09:00:00', 'dikembalikan', '0.00', '2026-04-20 08:14:53', '2026-04-20 08:24:52'),
(44, 3, 2, 1, '2026-04-20 08:17:43', '2006-01-02 09:00:00', 'dipinjam', '0.00', '2026-04-20 08:17:43', '2026-04-20 08:18:54');

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ZJLPcC7XHdoSy9jyVlL0u12FeMgbR58b2cj3FrFu', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibDh6S0ZMRFVTbDJreFBSWHV5WU1mSFAzc1luSXVpYURBMkNraTQ3VCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXR1Z2FzL3BlbWluamFtYW5zL2V4cG9ydC1wZGYiO3M6NToicm91dGUiO3M6Mjk6InBldHVnYXMucGVtaW5qYW1hbnMuZXhwb3J0UERGIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1776648345);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$SMadfpg08aFd6utOEeqzIO6dpzI8w6TP8/lAq7Iwguwx2E23aK/GG', 'admin', NULL, '2026-04-07 16:24:22', '2026-04-07 16:24:22'),
(3, 'nadira', 'nadiraaja123@gmail.com', NULL, '$2y$12$ehS7.ci6Bz7UHKqnDKhsyulzlOutZhrVQzkzlxktPeTFkcuuVr0/q', 'user', NULL, '2026-04-07 16:53:16', '2026-04-07 16:53:16'),
(5, 'Petugas Sarpras', 'petugas@gmail.com', NULL, '$2y$12$/NvnEWOjTIrXF9ExjDTNJe.SDgDRI.RAw1wwQ2x.aXd1jT5nAcIDu', 'petugas', NULL, '2026-04-08 14:46:13', '2026-04-08 14:50:26'),
(6, 'arizky', 'arizky@gmail.com', NULL, '$2y$12$hTKhRhe1Qgr7AEK9x4XIIOmvfj3lMJD4Kv/.hi3zsBHoMCDrGECPW', 'user', NULL, '2026-04-09 15:11:36', '2026-04-09 15:11:36'),
(7, 'aulia', 'vaniaul226@gmail.com', NULL, '$2y$12$8mBBLI9Oi6r7e0NY1C3uve7ZFzeVCkkXWtts6FXLMjhs65EkuQmcC', 'user', NULL, '2026-04-17 07:47:17', '2026-04-17 07:47:17');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;