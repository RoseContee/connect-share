-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: connect_share
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

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
-- Table structure for table `admin_password_reset_tokens`
--

DROP TABLE IF EXISTS `admin_password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
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
INSERT INTO `admins` VALUES (1,'admin@admin.com','$2y$10$b5QDWONr7z3MG08XJxTDauuZpaAHLa98Ws7/sUka5Muksw5vpdfme',NULL,'2023-10-23 11:48:34','2023-10-23 11:48:34');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_documents`
--

DROP TABLE IF EXISTS `company_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_documents`
--

LOCK TABLES `company_documents` WRITE;
/*!40000 ALTER TABLE `company_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domains`
--

DROP TABLE IF EXISTS `domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domains` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `installed` tinyint(4) NOT NULL DEFAULT 0,
  `home_banner_title` varchar(255) DEFAULT NULL,
  `home_banner_image` varchar(255) DEFAULT NULL,
  `hide_profile_banner` tinyint(1) NOT NULL DEFAULT 0,
  `profile_banner_image` varchar(255) DEFAULT NULL,
  `rss_link` varchar(255) DEFAULT NULL,
  `widgets` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `requested_email` varchar(255) DEFAULT NULL,
  `notify_to` varchar(255) DEFAULT NULL,
  `status` enum('pending','active','blocked') NOT NULL DEFAULT 'pending',
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domains_domain_unique` (`domain`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domains`
--

LOCK TABLES `domains` WRITE;
/*!40000 ALTER TABLE `domains` DISABLE KEYS */;
INSERT INTO `domains` VALUES (1,'aforadsudmilano.org',2,'Welcome to intranet',NULL,0,'uploads/banner/iDt4zwqG2gVHxg69S48Q0HkRPbtbWkKFcmUvTV5R.png','https://xml2.corriereobjects.it/rss/homepage.xml','1,2,3,4,5','vcThv4r3nOnGeDtwkRKirLsFki7Vl3zQ','pierluigi.pisanti@aforadsudmilano.org',NULL,'active',NULL,'2023-10-23 12:59:29','2023-11-30 16:39:46');
/*!40000 ALTER TABLE `domains` ENABLE KEYS */;
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
-- Table structure for table `holiday_requests`
--

DROP TABLE IF EXISTS `holiday_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holiday_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `google_id` varchar(255) NOT NULL,
  `manager_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'paid vacation, unpaid leave, sick leave, other',
  `period` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reason` text DEFAULT NULL,
  `parent` bigint(20) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holiday_requests`
--

LOCK TABLES `holiday_requests` WRITE;
/*!40000 ALTER TABLE `holiday_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `holiday_requests` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_09_06_223726_create_admins_table',1),(6,'2023_09_07_180418_create_settings_table',1),(7,'2023_09_12_095324_create_domains_table',1),(8,'2023_09_21_160646_create_useful_links_table',1),(9,'2023_09_21_160715_create_company_documents_table',1),(10,'2023_09_22_165026_create_widget_holiday_requests_table',1),(11,'2023_09_29_181229_create_admin_password_reset_tokens_table',1),(12,'2023_09_29_181422_create_shortcuts_table',1),(13,'2023_11_21_173554_create_widget_corporate_news_table',2);
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'favicon',NULL,'2023-10-23 11:48:34','2023-10-23 11:48:34'),(2,'logo',NULL,'2023-10-23 11:48:34','2023-10-23 11:48:34'),(3,'contact_email','info@connectshare.it','2023-10-23 11:48:34','2023-10-23 11:48:34'),(4,'contact_phone',NULL,'2023-10-23 11:48:34','2023-10-23 11:48:34'),(5,'home_banner_title','Welcome to Connect Share!','2023-10-23 11:48:34','2023-10-23 11:48:34'),(6,'home_banner_image',NULL,'2023-10-23 11:48:34','2023-10-23 11:48:34'),(7,'hide_profile_banner','0','2023-10-23 11:48:34','2023-11-24 20:42:50'),(8,'profile_banner_image',NULL,'2023-10-23 11:48:34','2023-10-23 11:48:34'),(9,'rss_link','https://www.ansa.it/sito/ansait_rss.xml','2023-10-23 11:48:34','2023-10-23 11:48:34'),(10,'shortcut','1','2023-10-23 11:48:34','2023-11-24 20:42:50'),(11,'dark_mode','0','2023-10-23 11:48:34','2023-10-23 11:48:34');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shortcuts`
--

DROP TABLE IF EXISTS `shortcuts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shortcuts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
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
INSERT INTO `shortcuts` VALUES (1,'uploads/side-icons/gmail.png','Gmail','https://mail.google.com/mail/',1,'2023-10-23 11:48:34','2023-10-23 11:48:34'),(2,'uploads/side-icons/google-calendar.png','Google Calendar','https://calendar.google.com/calendar',1,'2023-10-23 11:48:34','2023-10-23 11:48:34'),(3,'uploads/side-icons/google-drive.png','Google Drive','https://drive.google.com/',1,'2023-10-23 11:48:34','2023-10-23 11:48:34'),(4,'uploads/side-icons/google-meet.png','Google Meet','https://meet.google.com/',1,'2023-10-23 11:48:34','2023-10-23 11:48:34');
/*!40000 ALTER TABLE `shortcuts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `useful_links`
--

DROP TABLE IF EXISTS `useful_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `useful_links` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `useful_links`
--

LOCK TABLES `useful_links` WRITE;
/*!40000 ALTER TABLE `useful_links` DISABLE KEYS */;
INSERT INTO `useful_links` VALUES (1,'aforadsudmilano.org','https://www.corriere.it','Corriere della Sera','2023-11-23 10:14:01','2023-11-23 10:14:01'),(2,'aforadsudmilano.org','https://www.repubblica.it','Repubblica','2023-11-23 10:14:30','2023-11-23 10:14:30'),(3,'aforadsudmilano.org','https://www.linkedin.com','Linekdin','2023-11-23 18:41:59','2023-11-23 18:41:59'),(4,'aforadsudmilano.org','https://connectshare.it/organization','Org Chart','2023-11-25 05:42:02','2023-11-25 05:42:02'),(5,'aforadsudmilano.org','https://connectshare.it/widget/holiday-requests','Holiday Request','2023-11-25 05:43:12','2023-11-25 05:43:12');
/*!40000 ALTER TABLE `useful_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `google_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `given_name` varchar(255) DEFAULT NULL,
  `family_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `org_title` varchar(255) DEFAULT NULL,
  `org_department` varchar(255) DEFAULT NULL,
  `drive_usage` varchar(20) DEFAULT NULL,
  `gmail_usage` varchar(20) DEFAULT NULL,
  `photos_usage` varchar(20) DEFAULT NULL,
  `manager_id` varchar(255) DEFAULT NULL,
  `show_in_org` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `domain` varchar(255) NOT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `refresh_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'114510716024122432257','pierluigi.pisanti@aforadsudmilano.org','pierluigi','pisanti','3387825309','https://lh3.google.com/ao/AOOqTwLYFT28mO83AhBamoRsN-XMNOdcespIQCHwRMKxRe-PC7Td59qdnAe6npDr1Nd9=s96-c','Head of IT Department','IT','1250','0','0','107273722462308117379',1,1,'aforadsudmilano.org','ya29.a0AfB_byDWK5kUqOdddpQAo2ohYE8Xk2mSUFTINn3p8yG6p7RsWyKNKK1MLgt9U7OEKOWqfNxx6Nejm7grXa6Ji7WiB_10K3KoDptuCKGhaFiBV61wahvU4NnQyqDIGchcD4GvVGVSyvxbvIPSga2ggxJ33-AOJp4nqhKCaCgYKAQ8SARASFQHGX2MiYfO_8adgYs7Y4X8lsj7VSA0171','1//03hXOxskNEf6PCgYIARAAGAMSNwF-L9IrA_mclHYCmkLaaPp27fKl55QvpsXoMHQyQKL1e9ryg7aa1wMpa4IM0_3LJVo5yxldYxU',NULL,'2023-10-23 13:11:11','2023-12-01 21:38:25'),(2,'116369677540036106213','admin@aforadsudmilano.org','Pierluigi','Pisanti',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'107273722462308117379',1,1,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(3,'106667401027630338887','antonio.dama@aforadsudmilano.org','Antonio','Dama','3381917446',NULL,NULL,NULL,NULL,NULL,NULL,'105643730176926060463',1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(4,'100340775085679770455','enrico.gualdi@aforadsudmilano.org','Enrico','Gualdi','3398292317',NULL,NULL,'Formazione',NULL,NULL,NULL,'105643730176926060463',1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(5,'104823686477522259316','formazione@aforadsudmilano.org','Formazione','Aforad','3474628717',NULL,NULL,NULL,NULL,NULL,NULL,'105643730176926060463',1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(6,'113952317719742401178','franco.malanchini@aforadsudmilano.org','Franco','Malanchini','3357281734',NULL,'Tesoriere','FInance',NULL,NULL,NULL,'107273722462308117379',1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(7,'105643730176926060463','maurizio.ornaghi@aforadsudmilano.org','Maurizio','Ornaghi','3474628717','https://lh3.googleusercontent.com/a-/ALV-UjU6LwzpspKngYe56OuvrYr4cXT0Isl9CG1HWY_bcGVksQ=s96-c',NULL,NULL,NULL,NULL,NULL,'107273722462308117379',1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(8,'100572751295620359298','paolo.castagna@aforadsudmilano.org','paolo','castagna','3479670028','https://lh3.google.com/ao/AOOqTwLAic2i6jmtEOZUuaiFEJyNxF5Bfqe5SaBP9Ucf1iwHLTYPlniAU1ywlHAGL0_O=s96-c','IT manager','IT',NULL,NULL,NULL,'114510716024122432257',1,1,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(9,'107273722462308117379','presidente@aforadsudmilano.org','Ivan','Brivio','3281003080','https://lh3.googleusercontent.com/a-/ALV-UjVHjEuJsiTeiWCD78gVaRvo2lH1ChSgiGgiZxBQc_GUQQ=s96-c','Presidente',NULL,NULL,NULL,NULL,NULL,1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(10,'102334154634005897898','segreteria@aforadsudmilano.org','segreteria','aforad',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'105643730176926060463',1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(11,'117270652333808361548','tesoreria@aforadsudmilano.org','Tesoreria','Aforad','3357281734',NULL,NULL,NULL,NULL,NULL,NULL,'113952317719742401178',1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(12,'112211604848499509887','test.rubrica@aforadsudmilano.org','test','rubrica',NULL,'https://lh3.googleusercontent.com/a-/ALV-UjU7Vrpqu3OViycvMzVvnbLQljvNJe5bVeBKWNq4Yr2xZg=s96-c',NULL,NULL,'0','0','0','114510716024122432257',1,0,'aforadsudmilano.org','ya29.a0AfB_byCtULpNQEhOBvRi13awNvfVwSRX9hrlSnl6aW2otFjPKGdVpPizuAD4du7vXMNi3fFl3XPkavMeO9ibRvNm011XRRoQpyT9rPdW3iyDP0iXtve6RCmyVNNaMDQC-In2DO6fHPqoNoAR5v3RgFGfEd-K58RAolwaCgYKAfASARISFQHGX2Miil_HW9ZDeUic_a_OdhfQvA0170','1//09ma7GrWioh_5CgYIARAAGAkSNwF-L9IrSertq3P7SPd-RdTz3RsoAOUcZvDY2FidkTISaA2BL71sTH3blw1RNaWv__-3y7j5e2E',NULL,'2023-10-23 13:11:16','2023-11-30 14:45:08'),(13,'105563183055311395607','walter.broleri@aforadsudmilano.org','walter','broleri','3285641487',NULL,NULL,NULL,NULL,NULL,NULL,'105643730176926060463',1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(14,'116800362237243583864','zoom@aforadsudmilano.org','Zoom','Aforad','3479670028',NULL,NULL,NULL,NULL,NULL,NULL,'100572751295620359298',1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16'),(15,'113938323130778770118','zoomaforad@aforadsudmilano.org','Aforad','Zoom',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'100572751295620359298',1,0,'aforadsudmilano.org',NULL,NULL,NULL,'2023-10-23 13:11:16','2023-10-23 13:11:16');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widget_corporate_news`
--

DROP TABLE IF EXISTS `widget_corporate_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `widget_corporate_news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `refresh_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `widget_alerts_domain_unique` (`domain`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widget_corporate_news`
--

LOCK TABLES `widget_corporate_news` WRITE;
/*!40000 ALTER TABLE `widget_corporate_news` DISABLE KEYS */;
INSERT INTO `widget_corporate_news` VALUES (1,'aforadsudmilano.org','pierluigi.pisanti@aforadsudmilano.org','ya29.a0AfB_byD36XtmjJsS1tl9HElyblAEVWR502lZdgnoInqjBCnjmNZqSC53s6hbBC6-fgGu8ihZ0OfrVaseO2kct5VvfpbmIVpOXFaCV8ldgUAplPqdFtvhla6e6RJl6-9yit5t4k5yjMqd5SmYCzxIsl5a9fKHBsWI58v5jgaCgYKAWsSARASFQHGX2MiM_Naih6EOtx59V9zM1zUUg0173','1//09EUKYpzOHvG3CgYIARAAGAkSNwF-L9IrNngzIhvKytXjMl2BBnfN11NucJKgNE94vXXk8D8nlnXi8eC1_usG9nX6VOG8mIeIplM','2023-11-23 10:08:51','2023-12-01 20:07:42',NULL);
/*!40000 ALTER TABLE `widget_corporate_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widget_holiday_requests`
--

DROP TABLE IF EXISTS `widget_holiday_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `widget_holiday_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `google_id` varchar(255) NOT NULL,
  `manager_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'paid vacation, unpaid leave, sick leave, other',
  `period` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reason` text DEFAULT NULL,
  `parent` bigint(20) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widget_holiday_requests`
--

LOCK TABLES `widget_holiday_requests` WRITE;
/*!40000 ALTER TABLE `widget_holiday_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `widget_holiday_requests` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-01 23:56:48
