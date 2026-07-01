-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: koperasi_guru
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `angsuran`
--

DROP TABLE IF EXISTS `angsuran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `angsuran` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pinjaman_id` bigint(20) unsigned NOT NULL,
  `angsuran_ke` int(11) NOT NULL,
  `nominal_bayar` decimal(15,2) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `angsuran_pinjaman_id_foreign` (`pinjaman_id`),
  CONSTRAINT `angsuran_pinjaman_id_foreign` FOREIGN KEY (`pinjaman_id`) REFERENCES `pinjaman` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `angsuran`
--

LOCK TABLES `angsuran` WRITE;
/*!40000 ALTER TABLE `angsuran` DISABLE KEYS */;
INSERT INTO `angsuran` VALUES (1,1,1,575000.00,'2026-03-01','2026-06-29 05:57:04','2026-06-29 05:57:04'),(2,1,2,575000.00,'2026-04-01','2026-06-29 05:57:04','2026-06-29 05:57:04'),(3,1,3,575000.00,'2026-06-29','2026-06-29 06:09:26','2026-06-29 06:09:26'),(4,1,4,575000.00,'2026-06-29','2026-06-29 06:09:36','2026-06-29 06:09:36'),(5,1,5,575000.00,'2026-06-29','2026-06-29 06:10:18','2026-06-29 06:10:18'),(6,1,6,575000.00,'2026-06-29','2026-06-29 06:10:33','2026-06-29 06:10:33'),(7,1,7,575000.00,'2026-06-29','2026-06-29 06:10:47','2026-06-29 06:10:47'),(8,1,8,575000.00,'2026-06-29','2026-06-29 06:11:04','2026-06-29 06:11:04'),(9,1,9,575000.00,'2026-06-29','2026-06-29 06:11:13','2026-06-29 06:11:13'),(10,1,10,575000.00,'2026-06-29','2026-06-29 06:11:22','2026-06-29 06:11:22');
/*!40000 ALTER TABLE `angsuran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_29_000001_create_simpanan_table',1),(5,'2026_06_29_000002_create_pinjaman_table',1),(6,'2026_06_29_000003_create_angsuran_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pinjaman`
--

DROP TABLE IF EXISTS `pinjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pinjaman` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nominal_pinjaman` decimal(15,2) NOT NULL,
  `bunga_persen` decimal(5,2) NOT NULL DEFAULT 0.00,
  `lama_angsuran_bulan` int(11) NOT NULL,
  `sisa_angsuran_bulan` int(11) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak','berjalan','lunas') NOT NULL DEFAULT 'menunggu',
  `alasan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pinjaman_user_id_foreign` (`user_id`),
  CONSTRAINT `pinjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pinjaman`
--

LOCK TABLES `pinjaman` WRITE;
/*!40000 ALTER TABLE `pinjaman` DISABLE KEYS */;
INSERT INTO `pinjaman` VALUES (1,2,5000000.00,1.50,10,0,'2026-02-01','2026-12-01','lunas','Biaya perbaikan atap rumah bocor','2026-06-29 05:57:04','2026-06-29 06:11:22'),(2,3,3000000.00,1.50,6,6,'2026-06-20',NULL,'menunggu','Biaya pendaftaran sekolah anak','2026-06-29 05:57:04','2026-06-29 05:57:04'),(3,4,10000000.00,1.20,12,0,'2025-05-10','2026-05-10','lunas','Kebutuhan mendesak pengobatan keluarga','2026-06-29 05:57:04','2026-06-29 05:57:04'),(4,2,2000000.00,0.00,4,4,'2026-05-12',NULL,'ditolak','Pengajuan pinjaman ditolak karena sisa pinjaman sebelumnya masih aktif','2026-06-29 05:57:04','2026-06-29 05:57:04');
/*!40000 ALTER TABLE `pinjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('g3kIWsx3l8f6BZhbeP4sIv1gQdvh5YQYSCOcZs6A',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.8655','YTozOntzOjY6Il90b2tlbiI7czo0MDoibVdNQnVJeFRVd2dJZ0FNMWRLMWMyVks4Rk5Oa0lyVHdmQ2VublBpWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1782739160),('ofQVR7Ibg5tg7pYzbzSrdY6SLykeWnVdJzsZrc6k',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMkxvU1pVSjlLY1BIcmsxQ2N2WVFMNE9IUGVERmtpNzZJNnhRYXV6ZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3BpbmphbWFuIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hbmdnb3RhL3BpbmphbWFuL2FqdWthbiI7czo1OiJyb3V0ZSI7czoyMzoiYW5nZ290YS5waW5qYW1hbi5hanVrYW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=',1782738723);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `simpanan`
--

DROP TABLE IF EXISTS `simpanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `simpanan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `tipe_simpanan` enum('pokok','wajib','sukarela') NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `simpanan_user_id_foreign` (`user_id`),
  CONSTRAINT `simpanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `simpanan`
--

LOCK TABLES `simpanan` WRITE;
/*!40000 ALTER TABLE `simpanan` DISABLE KEYS */;
INSERT INTO `simpanan` VALUES (1,2,'pokok',500000.00,'2026-01-05','Simpanan Pokok Awal Keanggotaan','2026-06-29 05:57:04','2026-06-29 05:57:04'),(2,2,'wajib',100000.00,'2026-02-05','Simpanan Wajib Februari 2026','2026-06-29 05:57:04','2026-06-29 05:57:04'),(3,2,'wajib',100000.00,'2026-03-05','Simpanan Wajib Maret 2026','2026-06-29 05:57:04','2026-06-29 05:57:04'),(4,2,'sukarela',250000.00,'2026-03-10','Simpanan Sukarela Kegiatan Guru','2026-06-29 05:57:04','2026-06-29 05:57:04'),(5,3,'pokok',500000.00,'2026-02-15','Simpanan Pokok Awal Keanggotaan','2026-06-29 05:57:04','2026-06-29 05:57:04'),(6,3,'wajib',100000.00,'2026-03-15','Simpanan Wajib Maret 2026','2026-06-29 05:57:04','2026-06-29 05:57:04'),(7,4,'pokok',500000.00,'2026-01-10','Simpanan Pokok Awal Keanggotaan','2026-06-29 05:57:04','2026-06-29 05:57:04'),(8,4,'wajib',100000.00,'2026-02-10','Simpanan Wajib Februari 2026','2026-06-29 05:57:04','2026-06-29 05:57:04'),(9,4,'wajib',100000.00,'2026-03-10','Simpanan Wajib Maret 2026','2026-06-29 05:57:04','2026-06-29 05:57:04'),(10,4,'sukarela',1500000.00,'2026-03-25','Simpanan Sukarela THR','2026-06-29 05:57:04','2026-06-29 05:57:04');
/*!40000 ALTER TABLE `simpanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','anggota') NOT NULL DEFAULT 'anggota',
  `nip` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nip_unique` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator Koperasi','admin@koperasi.id',NULL,'$2y$12$A1f36oUo9EkxM6SgW/HCUOMd6zAEEL1TAKZ2EroRmQ.SaTPN6T.yW','admin','ADMIN-01','Kantor Tata Usaha Sekolah','081234567890','aktif',NULL,'2026-06-29 05:57:02','2026-06-29 05:57:02'),(2,'Budi Setiawan, S.Pd.','guru@koperasi.id',NULL,'$2y$12$ynKf/HKEDHc0KqCuYUdWN.7GbY5ilPAMr8I1ON2nE5JrHo5uCfIXC','anggota','198503122010011002','Jl. Pendidikan No. 45, Bandung','089876543210','aktif',NULL,'2026-06-29 05:57:02','2026-06-29 05:57:02'),(3,'Siti Aminah, M.Pd.','siti@koperasi.id',NULL,'$2y$12$3UGwSo5rf2BAS7F6dwVGI.51JBeob/d5./HVwL3E01ysgsDExYz2m','anggota','198807242014022001','Jl. Merdeka No. 12, Bandung','081223344556','aktif',NULL,'2026-06-29 05:57:03','2026-06-29 05:57:03'),(4,'Drs. Ahmad Subagja','ahmad@koperasi.id',NULL,'$2y$12$7NpmCEta2WLCPEmj0zAt1uCPK/MYyfn2g1wYDpIvSG8i4hrLcOPwq','anggota','197211051998031003','Komp. Pendidik Blok C2, Bandung','085712345678','aktif',NULL,'2026-06-29 05:57:03','2026-06-29 05:57:03'),(5,'Rina Wijaya, S.Si.','rina@koperasi.id',NULL,'$2y$12$q2DqtWnQ0oKLFPZbt8Q2qeHhtLY1vgT/oTpIpOHA9Sa8Fna9qzpwy','anggota','199209152019032011','Jl. Cihampelas No. 102, Bandung','082198765432','nonaktif',NULL,'2026-06-29 05:57:04','2026-06-29 05:57:04');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-29 20:20:43
