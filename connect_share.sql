-- MySQL dump 10.13  Distrib 8.0.34, for Linux (x86_64)
--
-- Host: localhost    Database: connect_share
-- ------------------------------------------------------
-- Server version	8.0.34-0ubuntu0.23.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_password_reset_tokens`
--

DROP TABLE IF EXISTS `admin_password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_password_reset_tokens`
--

LOCK TABLES `admin_password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `admin_password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin@admin.com','$2y$10$oDLrmwKFkzSeZtkFx/ZZSOzH6MA0Gtu2sAkPXsYKnRWE7ENy3ne/i',NULL,'2023-09-29 22:00:34','2023-09-29 22:00:34');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_documents`
--

DROP TABLE IF EXISTS `company_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company_documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_documents`
--

LOCK TABLES `company_documents` WRITE;
/*!40000 ALTER TABLE `company_documents` DISABLE KEYS */;
INSERT INTO `company_documents` VALUES (1,'aforadsudmilano.org','test document','https://drive.google.com/drive/folders/0ByVQwWrSys5sfl9pakJ5elVRdlBRUFFwcU1IZVpGb3p2SG5IM0p0RG9jVW00MzREaDFzcWc?resourcekey=0-As_9HTO4ISM0GphvN34MIQ&usp=drive_link','test pdf','2023-09-30 03:03:15','2023-09-30 03:03:15');
/*!40000 ALTER TABLE `company_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domains`
--

DROP TABLE IF EXISTS `domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `domains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `installed` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domains_domain_unique` (`domain`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domains`
--

LOCK TABLES `domains` WRITE;
/*!40000 ALTER TABLE `domains` DISABLE KEYS */;
INSERT INTO `domains` VALUES (1,'aforadsudmilano.org',2,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(2,'siigep.tech',2,'2023-10-02 10:00:20','2023-10-02 10:00:21');
/*!40000 ALTER TABLE `domains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holiday_requests`
--

DROP TABLE IF EXISTS `holiday_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `holiday_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'paid vacation, unpaid leave, sick leave, other',
  `period` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `parent` bigint DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holiday_requests`
--

LOCK TABLES `holiday_requests` WRITE;
/*!40000 ALTER TABLE `holiday_requests` DISABLE KEYS */;
INSERT INTO `holiday_requests` VALUES (1,'112513161463464310301','107412138361324440137','test ferie','Paid Vacation','2023-10-03 - 2023-10-06','prova ferie','pending',NULL,NULL,'7IBfdeX7UwgMFpvyA4Kd549YpAewfWLpdkTgPW2O9LDekZdUvdd0PJw087zE8spE','2023-10-02 10:29:43','2023-10-02 10:29:43',NULL),(2,'112513161463464310301','107412138361324440137','test 2','Other','2023-10-03 - 2023-10-04','asfasfas','pending',NULL,NULL,'vT5Hj15MWclDjq1iXArPkxDnJMTHFHuwfwX7C1Ouw7duFsT0T87Wj5CSiT725PLp','2023-10-02 11:07:37','2023-10-02 11:07:37',NULL);
/*!40000 ALTER TABLE `holiday_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_09_06_223726_create_admins_table',1),(6,'2023_09_07_180418_create_settings_table',1),(7,'2023_09_12_095324_create_domains_table',1),(8,'2023_09_21_160646_create_useful_links_table',1),(9,'2023_09_21_160715_create_company_documents_table',1),(10,'2023_09_22_165026_create_holiday_requests_table',1),(11,'2023_09_29_181229_create_admin_password_reset_tokens_table',1),(12,'2023_09_29_181422_create_shortcuts_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'favicon',NULL,'2023-09-29 22:00:34','2023-09-29 22:00:34'),(2,'logo',NULL,'2023-09-29 22:00:34','2023-09-29 22:00:34'),(3,'contact_email',NULL,'2023-09-29 22:00:34','2023-09-29 22:00:34'),(4,'contact_phone',NULL,'2023-09-29 22:00:34','2023-09-29 22:00:34'),(5,'shortcut','1','2023-09-29 22:00:34','2023-09-29 22:00:34'),(6,'dark_mode','0','2023-09-29 22:00:34','2023-09-29 22:00:34');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shortcuts`
--

DROP TABLE IF EXISTS `shortcuts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shortcuts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shortcuts`
--

LOCK TABLES `shortcuts` WRITE;
/*!40000 ALTER TABLE `shortcuts` DISABLE KEYS */;
INSERT INTO `shortcuts` VALUES (1,'uploads/side-icons/gmail.png','Gmail','https://mail.google.com/mail/',1,'2023-09-29 22:00:33','2023-09-29 22:00:33'),(2,'uploads/side-icons/google-calendar.png','Google Calendar','https://calendar.google.com/calendar',1,'2023-09-29 22:00:34','2023-09-29 22:00:34'),(3,'uploads/side-icons/google-drive.png','Google Drive','https://drive.google.com/',1,'2023-09-29 22:00:34','2023-09-29 22:00:34'),(4,'uploads/side-icons/google-meet.png','Google Meet','https://meet.google.com/',1,'2023-09-29 22:00:34','2023-09-29 22:00:34');
/*!40000 ALTER TABLE `shortcuts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `useful_links`
--

DROP TABLE IF EXISTS `useful_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `useful_links` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `useful_links`
--

LOCK TABLES `useful_links` WRITE;
/*!40000 ALTER TABLE `useful_links` DISABLE KEYS */;
INSERT INTO `useful_links` VALUES (1,'aforadsudmilano.org','https://drive.google.com/drive/folders/0ByVQwWrSys5sfl9pakJ5elVRdlBRUFFwcU1IZVpGb3p2SG5IM0p0RG9jVW00MzREaDFzcWc?resourcekey=0-As_9HTO4ISM0GphvN34MIQ&usp=drive_link','drive pigi','2023-09-30 03:02:49','2023-09-30 03:02:49');
/*!40000 ALTER TABLE `useful_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `given_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `org_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drive_usage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmail_usage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photos_usage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refresh_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'114510716024122432257','pierluigi.pisanti@aforadsudmilano.org','pierluigi','pisanti','3387825309',NULL,'Head of IT Department','IT','1250','0','0','107273722462308117379',1,'aforadsudmilano.org','ya29.a0AfB_byBFiBb61NNnwkpTdWVOB2bTL3GE28xX2w0fgHAniejnJzsJZsIYTSPyh9p5vZxkXVA8Rnph2Jmes6rUxe6qH9ho-NNnXmRiayUjBELISku2NNTjjQu8Z0m5mqIOIvWArrYCcKKRRv3FQ6MmL3120ssu3NRZq1MaCgYKAbYSARESFQGOcNnConw0OsUp8rHwgZ5pu7pJHw0170',NULL,NULL,'2023-09-30 02:56:47','2023-10-03 05:43:58'),(2,'116369677540036106213','admin@aforadsudmilano.org','Pierluigi','Pisanti',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'107273722462308117379',1,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(3,'106667401027630338887','antonio.dama@aforadsudmilano.org','Antonio','Dama','3381917446',NULL,NULL,NULL,NULL,NULL,NULL,'105643730176926060463',0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(4,'100340775085679770455','enrico.gualdi@aforadsudmilano.org','Enrico','Gualdi','3398292317',NULL,NULL,'Formazione',NULL,NULL,NULL,'105643730176926060463',0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(5,'104823686477522259316','formazione@aforadsudmilano.org','Formazione','Aforad','3474628717',NULL,NULL,NULL,NULL,NULL,NULL,'105643730176926060463',0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(6,'113952317719742401178','franco.malanchini@aforadsudmilano.org','Franco','Malanchini','3357281734',NULL,'Tesoriere','FInance',NULL,NULL,NULL,'107273722462308117379',0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(7,'105643730176926060463','maurizio.ornaghi@aforadsudmilano.org','Maurizio','Ornaghi','3474628717','https://lh3.googleusercontent.com/a-/ALV-UjU6LwzpspKngYe56OuvrYr4cXT0Isl9CG1HWY_bcGVksQ=s96-c',NULL,NULL,NULL,NULL,NULL,'107273722462308117379',0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(8,'100572751295620359298','paolo.castagna@aforadsudmilano.org','paolo','castagna','3479670028','https://lh3.google.com/ao/AOOqTwLAic2i6jmtEOZUuaiFEJyNxF5Bfqe5SaBP9Ucf1iwHLTYPlniAU1ywlHAGL0_O=s96-c','IT manager','IT',NULL,NULL,NULL,'114510716024122432257',1,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(9,'107273722462308117379','presidente@aforadsudmilano.org','Ivan','Brivio','3281003080','https://lh3.googleusercontent.com/a-/ALV-UjVHjEuJsiTeiWCD78gVaRvo2lH1ChSgiGgiZxBQc_GUQQ=s96-c','Presidente',NULL,NULL,NULL,NULL,NULL,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(10,'102334154634005897898','segreteria@aforadsudmilano.org','segreteria','aforad',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'105643730176926060463',0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(11,'117270652333808361548','tesoreria@aforadsudmilano.org','Tesoreria','Aforad','3357281734',NULL,NULL,NULL,NULL,NULL,NULL,'113952317719742401178',0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(12,'112211604848499509887','test.rubrica@aforadsudmilano.org','test','rubrica',NULL,'https://lh3.googleusercontent.com/a-/ALV-UjU7Vrpqu3OViycvMzVvnbLQljvNJe5bVeBKWNq4Yr2xZg=s96-c',NULL,NULL,NULL,NULL,NULL,'114510716024122432257',0,'aforadsudmilano.org','ya29.a0AfB_byCzh82nDrpJaiYDxzzkCZbUkrBSfUIEQ9nRnbfCF9gq7UjkT7Y1CTY3OFlSuvaLS51xHi6SlXZ9vvsOzWr54VMbmlCp3OQSYFaXJHGi4CCJfmUNFCkl3eVP6RCCTqOe_aYsFH1urtk4CgYsbgCAVwkWWhXs_d4aCgYKAXkSARISFQGOcNnCp6KOHilr_7f4MKMFQ9DH9Q0170',NULL,NULL,'2023-09-30 02:56:50','2023-09-30 12:44:02'),(13,'105563183055311395607','walter.broleri@aforadsudmilano.org','walter','broleri','3285641487',NULL,NULL,NULL,NULL,NULL,NULL,'105643730176926060463',0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(14,'116800362237243583864','zoom@aforadsudmilano.org','Zoom','Aforad','3479670028',NULL,NULL,NULL,NULL,NULL,NULL,'100572751295620359298',0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(15,'113938323130778770118','zoomaforad@aforadsudmilano.org','Aforad','Zoom',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-09-30 02:56:50','2023-09-30 02:56:50'),(16,'112513161463464310301','pierluigi.pisanti@siigep.tech','Pierluigi','Pisanti',NULL,NULL,'General Manager','Direction','294651879','48172794','0','107412138361324440137',1,'siigep.tech','ya29.a0AfB_byAx79GXj17ynGcmMko3Bqi4ionDjpa3Nqar_Ll-Zasn3WCEA6mGsvojxtqeOpbtZvIQWfZFbS9D1xsVx8O2Xl9aidIss-2BIXr1O72aN-eiJiRAfxNMwdfir1-Q8Z_DYpbgBNsGOgjna_POxOKeHui-1Nyx2qUaCgYKAcoSARASFQGOcNnCzgRgU_akj5bj_Dp2PyFTJQ0170',NULL,NULL,'2023-10-02 10:00:18','2023-10-03 05:43:12'),(17,'116835713285006434917','alessandro@siigep.tech','Alessandro','Cavaliere','329 495 6296',NULL,'System Engineer','ICT',NULL,NULL,NULL,'107412138361324440137',1,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(18,'117230161509674912147','b.costa@siigep.tech','Barbara','Costa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(19,'106774014798012885443','beniamino.giordano@siigep.tech','Beniamino','Giordano',' 344 124 9370',NULL,'IT Specialist','ICT',NULL,NULL,NULL,'116835713285006434917',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(20,'107412138361324440137','biagio.garofalo@siigep.tech','Biagio','Garofalo','3939505301',NULL,'CEO','DIRECTION','588846725951','41539724751','0',NULL,1,'siigep.tech','ya29.a0AfB_byCuPAok2MgoFEUFzdv5MHNKlWgKE_5krWVP1TTQaWmmEPSsh_40ue66PCpT_syNfOwGSAbjaoXEBzNTWsPHpntB7EPbvyshiOfegz9W-DflbeG5j8LLi8TeZMtn30R5Cs4Jft0AReiNryTnX9Mf1XtKyvzFiP4UaCgYKAcMSARESFQGOcNnCVk8F1_VVeo3whqDy82kjbw0171','1//092Jrn1Xkmw55CgYIARAAGAkSNwF-L9Irlhdnm-pacR8l-uTESWQJH3AH9aayDPKSU12hLJSHe03R4YUS12lKpXkiHB38ujsPipE',NULL,'2023-10-02 10:00:20','2023-10-02 12:07:26'),(21,'101430108061899626456','ciro.siani@siigep.tech','Ciro','Siani',NULL,NULL,'Programmer','Software Department',NULL,NULL,NULL,'102139834385894348460',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(22,'112417453002258487911','cloud@siigep.tech','cloud','cloud',NULL,NULL,'Utenza di Servizio','Service',NULL,NULL,NULL,'107412138361324440137',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(23,'101506900682288669613','davide.liambo@siigep.tech','Davide','Liambo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(24,'107469852059439805097','external.consultant@siigep.tech','External','Consultant',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(25,'102656583951526368075','gennaro.annunziata@siigep.tech','Gennaro','Annunziata',NULL,NULL,'Senior Advisor','Advisor',NULL,NULL,NULL,'107412138361324440137',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(26,'101897832797766272638','giovanni.scarano@siigep.tech','Giovanni','Scarano',NULL,NULL,'IT Specialist','ICT',NULL,NULL,NULL,'116835713285006434917',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(27,'107634256092095808113','industrial.compliance@siigep.tech','Industrial','Compliance',NULL,NULL,'Utenza di Servizio','Service',NULL,NULL,NULL,'107412138361324440137',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(28,'104939094473787786218','industrial.design@siigep.tech','Industrial','Design',NULL,NULL,'Utenza di Servizio','Service',NULL,NULL,NULL,'107412138361324440137',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(29,'114638922953525685253','manuela.damiani@siigep.tech','Manuela','Damiani','3664275493',NULL,'Senior Administrative','Administration',NULL,NULL,NULL,'107412138361324440137',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(30,'104378023062435287542','marialuisa.pirri@siigep.tech','Marialuisa','Pirri','393 849 2871',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(31,'102139834385894348460','mario.cortese@siigep.tech','Mario','Cortese','334 843 3247',NULL,'Head Analyst','Software Department',NULL,NULL,NULL,'107412138361324440137',1,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(32,'118064058588075090360','marta.garofalo@siigep.tech','Marta','Garofalo',NULL,NULL,'Architect','Advisor',NULL,NULL,NULL,'107412138361324440137',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(33,'103763100444290763564','matteo.marino@siigep.tech','Matteo','Marino',NULL,NULL,'Senior Advisor','Advisor',NULL,NULL,NULL,'107412138361324440137',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(34,'118236065994822613527','milena.severino@siigep.tech','Milena','Severino',NULL,NULL,'Administrative','Administration',NULL,NULL,NULL,'114638922953525685253',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(35,'100795782385632687457','privacy.compliance@siigep.tech','Privacy','Compliance','+39 347 961 1208',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(36,'107003565405704799266','repartosviluppo@siigep.tech','Reparto','Sviluppo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(37,'102021728212566807327','salvatore.messineo@siigep.tech','Salvatore','Messineo',' 335 414 115',NULL,'Geologist','Advisor',NULL,NULL,NULL,'107412138361324440137',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(38,'105539357976783987834','serena.pascarella@siigep.tech','Serena','Pascarella',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(39,'112894523047490345105','sergio.garofalo@siigep.tech','Sergio','Garofalo',NULL,NULL,'Senior Advisor','Advisor',NULL,NULL,NULL,'107412138361324440137',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(40,'113104722860225498317','tina.giamundo@siigep.tech','Tina','Giamundo',' 339 572 2875',NULL,'System Engineer','ICT',NULL,NULL,NULL,'116835713285006434917',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(41,'107097516335152250180','valentina.desantis@siigep.tech','Valentina','De Santis','3318695912',NULL,'Administrative','Administration',NULL,NULL,NULL,'114638922953525685253',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20'),(42,'110432310543265848754','vincenzo.sica@siigep.tech','Vincenzo','Sica',NULL,NULL,'Programmer','Software Department',NULL,NULL,NULL,'102139834385894348460',0,'siigep.tech',NULL,NULL,NULL,'2023-10-02 10:00:20','2023-10-02 10:00:20');
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

-- Dump completed on 2023-10-03 12:50:01
