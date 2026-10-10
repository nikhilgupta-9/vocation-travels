-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: vocation_travels_db
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
-- Table structure for table `about_sections`
--

DROP TABLE IF EXISTS `about_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `about_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `section_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `about_sections`
--

LOCK TABLES `about_sections` WRITE;
/*!40000 ALTER TABLE `about_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `about_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_logs`
--

DROP TABLE IF EXISTS `admin_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  KEY `action` (`action`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_logs`
--

LOCK TABLES `admin_logs` WRITE;
/*!40000 ALTER TABLE `admin_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_user`
--

DROP TABLE IF EXISTS `admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `role` enum('super_admin','admin','manager') NOT NULL DEFAULT 'admin',
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL,
  `failed_attempts` tinyint(1) NOT NULL DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `password_changed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_user`
--

LOCK TABLES `admin_user` WRITE;
/*!40000 ALTER TABLE `admin_user` DISABLE KEYS */;
INSERT INTO `admin_user` VALUES (6,'admin','$2y$10$LRr7OmNpB6sLPbSSt13w3ORG2dTor/SNLMJ4Fu0ewR9DJqz1foeAe','nikhilgupta@gmail.com','Nikhil','Gupta','admin','active',NULL,NULL,0,NULL,'2025-05-08 11:37:23','2025-05-08 11:34:38','2025-05-08 11:37:23',NULL,NULL);
/*!40000 ALTER TABLE `admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_path` varchar(255) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (31,'uploads/banners/banner_6999397a849a1.png','Engineered Cutting Tools <br> You Can Trust','From customized blade solutions to dependable support, Perfect Knives is committed to helping industries achieve precision cutting and operational efficiency.','https://www.youtube.com/watch?v=owhuBrGIOsE',0,0,'2026-01-07 06:30:19','0000-00-00 00:00:00','0000-00-00 00:00:00'),(36,'uploads/banners/banner_6999393b1edef.png','Precision Blades for <br> Industrial Excellence','Perfect Knives delivers high-performance industrial knives and cutting solutions designed for durability, accuracy, and reliability across multiple manufacturing applications.','https://www.youtube.com/watch?v=owhuBrGIOsE',0,0,'2026-02-03 06:21:22','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_tags`
--

DROP TABLE IF EXISTS `blog_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`),
  CONSTRAINT `blog_tags_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_tags`
--

LOCK TABLES `blog_tags` WRITE;
/*!40000 ALTER TABLE `blog_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `slug_url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'published',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (4,'Garden Pipes The Essential Tool for Every Modern Garden','<p>A <strong>garden pipe</strong> is an indispensable tool for maintaining a healthy and flourishing garden. Whether you&rsquo;re watering plants, cleaning outdoor areas, or washing vehicles, a durable and flexible garden pipe makes every task easier. Available in various lengths, diameters, and materials, garden pipes are designed to provide steady water flow while being long-lasting and weather-resistant.</p>','garden-pipes-the-essential-tool-for-every-modern-garden','blog_4_698aee353ca8a9.67060651.png','Mohit Chauhan','2025-05-13 05:30:20','2026-02-10 04:07:09','published'),(5,'6 tips to retain your top sales talent','<p>Sed facilisis lorem in orci bibendum ullamcorper. Mauris vitae augue elementum, sodales nulla a, semper ligula. Nullam vel enim risus. Integer rhoncus hendrerit sem egestas porttitor. Integer et mi sed dolor eleifend pretium quis ut velit. Nam sit amet arcu feugiat, consequat orci at, ultrices magna</p>','6-tips-to-retain-your-top-sales-talent','blog_5_698aee47b65b50.54181546.png','Astha sen','2025-05-13 05:32:09','2026-02-10 04:07:27','published'),(6,'Why your sales forecast is off','<p>Sed facilisis lorem in orci bibendum ullamcorper. Mauris vitae augue elementum, sodales nulla a, semper ligula. Nullam vel enim risus. Integer rhoncus hendrerit sem egestas porttitor. Integer et mi sed dolor eleifend pretium quis ut velit. Nam sit amet arcu feugiat, consequat orci at, ultrices magna</p>','why-your-sales-forecast-is-off','blog_6_698aee5202baf4.44320774.png','Rohan Mehta','2025-05-13 05:33:13','2026-02-10 04:07:38','published'),(7,'WHY DO I NEED TO USE FINANCIAL ?','<p>Sed facilisis lorem in orci bibendum ullamcorper. Mauris vitae augue elementum, sodales nulla a, semper ligula. Nullam vel enim risus. Integer rhoncus hendrerit sem egestas porttitor. Integer et mi sed dolor eleifend pretium quis ut velit. Nam sit amet arcu feugiat, consequat orci at, ultrices magna</p>\r\n\r\n<p>&nbsp;</p>','why-do-i-need-to-use-financial','blog_7_698aee5c979142.79135716.png','Pooja Singh','2025-05-13 05:35:01','2026-02-10 04:07:48','published');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) NOT NULL,
  `logo_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (82,'b1','uploads/brands/1771650565_brand-v1-img1.png','2026-02-21 05:09:25'),(83,'b2','uploads/brands/1771650573_brand-v1-img2.png','2026-02-21 05:09:33'),(84,'b3','uploads/brands/1771650585_brand-v1-img3.png','2026-02-21 05:09:45'),(85,'b4','uploads/brands/1771650594_brand-v1-img4.png','2026-02-21 05:09:54');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=311 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (298,'user_6819cd6528fbe2.53784923',22625,5,'2025-05-07 05:46:07',NULL),(310,'user_681aa357f32ba0.6650221325932d5b9cf30822',22625,4,'2025-05-08 02:20:47',NULL);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cate_id` int(10) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_desc` text NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `slug_url` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `added_on` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (107,85726,'All Products','All Products','All Products','All Products','6999423d74147_1.png','all-products',1,'2026-02-18 10:46:39');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `working_hours` varchar(100) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkdin` varchar(2000) DEFAULT NULL,
  `map` varchar(500) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `wp_number` varchar(11) DEFAULT NULL,
  `telephone` varchar(11) DEFAULT NULL,
  `updated_at` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (6,'','visa@vocationtravels.com','VOCATION TRAVELS AND TOURS PRIVATE LIMITED','© 2026 All rights reserved','Sun To Thu 9:00AM To 6:00PM ','https://www.facebook.com/share/1ZXsmimYf7/?mibextid=wwXIfr','https://www.instagram.com/vocationtravels/','https://www.youtube.com/','https://www.linkedin.com/company/vocationtravels/','https://share.google/EzOt9py4AbwOfVnO1','iamnikhilgupta9@gmail.com','Room No. 309, 3rd Floor, Transport Authority Building, District Centre, Near Janakpuri Police Station, Janakpuri, New Delhi, Delhi - 110058','accounts@vocationtravels.com','','','2025-02-18 07:01:32','9999447373','7982938239','01145607479','2026-02-27 05:46:17');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deletion_logs`
--

DROP TABLE IF EXISTS `deletion_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deletion_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `inquiry_id` int(11) DEFAULT NULL,
  `inquiry_data` text DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  KEY `inquiry_id` (`inquiry_id`),
  KEY `deleted_at` (`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deletion_logs`
--

LOCK TABLES `deletion_logs` WRITE;
/*!40000 ALTER TABLE `deletion_logs` DISABLE KEYS */;
INSERT INTO `deletion_logs` VALUES (1,6,35,'{\"name\":\"nikhil tom\",\"email\":\"nike@gmail.com\",\"subject\":\"sdfas df \",\"message\":\"sadf sadf\",\"created_at\":\"2025-10-06 16:05:38\"}','2026-01-31 06:19:46'),(2,6,34,'{\"name\":\"Mohit Kumar\",\"email\":\"mohit@gmail.xcom\",\"subject\":\"\",\"message\":\"sadfasdfa\",\"created_at\":\"2025-10-06 16:03:53\"}','2026-01-31 06:19:51'),(3,6,21,'{\"name\":\"Ramesh Singh\",\"email\":\"rameshsingh@gmail.com\",\"subject\":\"this is testing\",\"message\":\"this is testing\",\"created_at\":\"2025-05-13 14:37:08\"}','2026-01-31 06:20:02'),(4,6,27,'{\"name\":\"nikhil\",\"email\":\"nikhil@gmail.com\",\"subject\":\"this is testing1\",\"message\":\"this is testing 1\",\"created_at\":\"2025-08-06 12:55:24\"}','2026-01-31 06:20:08'),(5,6,29,'{\"name\":\"nikw\",\"email\":\"nikhil@gmail.com\",\"subject\":\"this is testing 3\",\"message\":\"this is testing 3\",\"created_at\":\"2025-08-06 13:05:22\"}','2026-01-31 06:20:14'),(6,6,28,'{\"name\":\"nike\",\"email\":\"nikhil@gmail.com\",\"subject\":\"this is testing 1\",\"message\":\"this is testing 1\",\"created_at\":\"2025-08-06 13:02:49\"}','2026-01-31 06:20:20'),(7,6,33,'{\"name\":\"Ramesh Singh\",\"email\":\"rameshsingh@gmail.com\",\"subject\":\"this is testing 4\",\"message\":\"this is testing 4\",\"created_at\":\"2025-08-06 13:24:26\"}','2026-01-31 06:20:25'),(8,6,32,'{\"name\":\"Ramesh Singh\",\"email\":\"rameshsingh@gmail.com\",\"subject\":\"this is testing 4\",\"message\":\"this is testing 4\",\"created_at\":\"2025-08-06 13:18:39\"}','2026-01-31 06:20:29'),(9,6,30,'{\"name\":\"Ramesh Singh\",\"email\":\"rameshsingh@gmail.com\",\"subject\":\"this is testing 4\",\"message\":\"this is testing 4\",\"created_at\":\"2025-08-06 13:17:09\"}','2026-01-31 06:20:33'),(10,6,31,'{\"name\":\"Ramesh Singh\",\"email\":\"rameshsingh@gmail.com\",\"subject\":\"this is testing 4\",\"message\":\"this is testing 4\",\"created_at\":\"2025-08-06 13:17:52\"}','2026-01-31 06:20:36');
/*!40000 ALTER TABLE `deletion_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `travel_date` date DEFAULT NULL,
  `adults` int(11) DEFAULT 0,
  `children` int(11) DEFAULT 0,
  `destination` varchar(255) DEFAULT NULL,
  `timeline` varchar(100) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) DEFAULT 'new',
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inquiries`
--

LOCK TABLES `inquiries` WRITE;
/*!40000 ALTER TABLE `inquiries` DISABLE KEYS */;
INSERT INTO `inquiries` VALUES (22,'Ramesh Singh','rameshsingh@gmail.com','09876543210',NULL,0,0,NULL,NULL,'this ist esting ','this is testing ','2025-06-03 07:06:19','new',NULL,NULL),(36,'Nikhil Gutpa','iamnikhilgupta9@gmail.com','9021140005',NULL,0,0,NULL,NULL,'THIS IS TESTING AND IT IS WORKING','THIS IS TESTING AND IT IS WORKING','2026-01-31 06:10:27','unread',NULL,NULL),(37,'Nikhil Gutpa','nik007gutpadu@gmail.com','9540073767',NULL,0,0,NULL,NULL,'Organic Food','this is testing nilkamal','2026-02-03 01:09:49','unread',NULL,NULL),(38,'Nikhil Gutpa','iamnikhilgupta9@gmail.com','9632587412',NULL,0,0,NULL,NULL,'','casdasdasdasd','2026-02-03 06:08:59','unread',NULL,NULL),(39,'Nikhil Gupta','TIM@GMAIL.COM','08368552640','2026-02-28',2,1,'rajasthan','3','','Travel Inquiry Details:\n\nName: Nikhil Gupta\nEmail: TIM@GMAIL.COM\nPhone: 08368552640\nDate of Travel: 2026-02-28\nNumber of Adults: 2\nNumber of Children: 1\nTotal People: 3\nDestination/Package: rajasthan\nPackage Timeline: 3\nAdditional Comments:\nthis is testing 3\n','2026-02-26 19:32:27','unread','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36'),(40,'Nikhil Gupta','nikhil@gmail.com','08368552640','2026-02-28',2,1,'keral','3','','Travel Inquiry Details:\n\nName: Nikhil Gupta\nEmail: nikhil@gmail.com\nPhone: 08368552640\nDate of Travel: 2026-02-28\nNumber of Adults: 2\nNumber of Children: 1\nTotal People: 3\nDestination/Package: keral\nPackage Timeline: 3\nAdditional Comments:\nasdfsfd\n','2026-02-26 19:34:44','unread','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36'),(41,'RobertDuefe','b.estd.e.ci.s.i.onp.r@gmail.com','81991275481','1984-01-08',2147483647,2147483647,'+12153015970','+12153015970','','Travel Inquiry Details:\n\nName: RobertDuefe\nEmail: b.estd.e.ci.s.i.onp.r@gmail.com\nPhone: 81991275481\nDate of Travel: 1984-01-08\nNumber of Adults: 12153015970\nNumber of Children: 12153015970\nTotal People: 24306031940\nDestination/Package: +12153015970\nPackage Timeline: +12153015970\nAdditional Comments:\nSolve your problems once and for all! \r\nIncredible feelings you\'ve never experienced before! \r\n<a href=https://www.vigrxplus.net/ct/947141>Treat your girlfriend today ;)</a>\n','2026-03-17 13:11:32','unread','146.59.44.6','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Avast/131.0.0.0'),(42,'DavidgrinY','no.reply.AnthonvDavies@gmail.com','89725495611','1983-06-03',2,0,'Kerala, Rajasthan Tour','A new system of email circulation.','','Travel Inquiry Details:\n\nName: DavidgrinY\nEmail: no.reply.AnthonvDavies@gmail.com\nPhone: 89725495611\nDate of Travel: 1983-06-03\nNumber of Adults: 2\nNumber of Children: 0\nTotal People: 2\nDestination/Package: Kerala, Rajasthan Tour\nPackage Timeline: A new system of email circulation.\nAdditional Comments:\nHey! vocationtravels.com, \r\nWhile browsing websites I found your page. \r\nOur system sends messages through website contact forms rather than email. \r\nThis platform allows companies to reach websites in various industries. \r\n  \r\n  \r\nIf you would like to learn more, just contact us. \r\n \r\nHope you have a great day. \r\nContact us. \r\nTelegram - https://t.me/FeedbackFormEU \r\nWhatsApp - +375259112693 \r\nWhatsApp  https://wa.me/+375259112693\n','2026-04-09 06:57:39','unread','138.199.54.5','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36');
/*!40000 ALTER TABLE `inquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logos`
--

DROP TABLE IF EXISTS `logos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo_path` varchar(255) NOT NULL,
  `location` varchar(50) NOT NULL DEFAULT 'header',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logos`
--

LOCK TABLES `logos` WRITE;
/*!40000 ALTER TABLE `logos` DISABLE KEYS */;
INSERT INTO `logos` VALUES (55,'logo/logo_header_69803f3cb52d4.png','header','2026-02-02 06:07:56',0),(56,'logo/logo_footer_69803f44cfc84.png','footer','2026-02-02 06:08:04',0),(57,'logo/logo_header_698183d862589.png','header','2026-02-03 05:12:56',0),(58,'logo/logo_footer_698183e6a930f.png','footer','2026-02-03 05:13:10',0),(59,'logo/logo_header_6982fa27c6f9c.jpg','header','2026-02-04 07:49:59',0),(60,'logo/logo_footer_6982fa37b13dd.jpg','footer','2026-02-04 07:50:15',0),(61,'logo/logo_header_6989d2ba5f71c.png','header','2026-02-09 12:27:38',0),(62,'logo/logo_header_69954f85ac573.png','header','2026-02-18 05:35:01',0),(63,'logo/logo_footer_699551bcc25c9.png','footer','2026-02-18 05:44:28',0),(64,'logo/logo_header_69969834b2358.png','header','2026-02-19 04:57:24',0),(65,'logo/logo_footer_6996983ef3477.png','footer','2026-02-19 04:57:35',0),(66,'logo/logo_email_69969ede72988.png','email','2026-02-19 05:25:50',0),(67,'logo/logo_header_699850660e965.png','header','2026-02-20 12:15:34',0),(68,'logo/logo_footer_6998506e02c46.png','footer','2026-02-20 12:15:42',0),(69,'logo/logo_email_69985077cd2d1.png','email','2026-02-20 12:15:51',0),(70,'logo/logo_header_69a0e0002bd71.png','header','2026-02-27 00:06:24',0),(71,'logo/logo_footer_69a0e0069fe20.png','footer','2026-02-27 00:06:30',0),(72,'logo/logo_email_69a0e00e5fd2b.png','email','2026-02-27 00:06:38',0),(73,'logo/logo_header_69b8fd0da54a6.jpeg','header','2026-03-17 07:04:45',0),(74,'logo/logo_footer_69b8fd1a2251f.jpeg','footer','2026-03-17 07:04:58',0),(75,'logo/logo_email_69b8fd25c2c36.jpeg','email','2026-03-17 07:05:09',1),(76,'logo/logo_header_69b8fd8632ab4.png','header','2026-03-17 07:06:46',1),(77,'logo/logo_footer_69b917d95c653.png','footer','2026-03-17 08:59:05',1);
/*!40000 ALTER TABLE `logos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package_highlights`
--

DROP TABLE IF EXISTS `package_highlights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package_highlights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `highlight` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`),
  CONSTRAINT `package_highlights_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_highlights`
--

LOCK TABLES `package_highlights` WRITE;
/*!40000 ALTER TABLE `package_highlights` DISABLE KEYS */;
INSERT INTO `package_highlights` VALUES (1,1,'4 Nights Stay in Delhi, Agra & Mathura',1),(2,1,'Tour itinerary with 4-star hotel accommodations',2),(3,2,'6 Nights / 7 Days Rajasthan Package',1),(4,2,'Detailed itinerary with 4-star hotel accommodations',2),(5,3,'5 Nights / 6 Days Goa Package',1),(6,3,'Includes water sports & adventure activities',2),(7,4,'4-Star Hotel Stay',1),(8,4,'Itinerary covering Hanoi, Halong Bay & Turtle Island',2),(9,5,'4-Star Hotel Stay',1),(10,5,'Island Tours, Water Sports, Turtle Island Visit',2),(11,6,'4-Star Hotel Stay with Breakfast',1),(12,6,'Dubai & Abu Dhabi City Tours, Desert Safari, Burj Khalifa',2),(13,4,'HANOI & DANANG – 05N VIETNAM DREAMS',3),(14,7,'4-Star Hotel Stay with Breakfast',0),(15,7,'Tokyo, Nagasaki, Mount Fuji',1);
/*!40000 ALTER TABLE `package_highlights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package_inclusions`
--

DROP TABLE IF EXISTS `package_inclusions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package_inclusions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `inclusion` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`),
  CONSTRAINT `package_inclusions_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_inclusions`
--

LOCK TABLES `package_inclusions` WRITE;
/*!40000 ALTER TABLE `package_inclusions` DISABLE KEYS */;
INSERT INTO `package_inclusions` VALUES (1,1,'4 star hotel accommodation',1),(2,1,'Private chauffeured transfers',2),(3,2,'4 star hotel accommodation',1),(4,2,'Private chauffeured transfers',2),(5,3,'4 star hotel accommodation',1),(6,3,'Private chauffeured transfers',2),(7,4,'4 star hotel accommodation',1),(8,4,'Private chauffeured transfers',2),(9,5,'04 Nights Stay in Risata Bali 4★ (Superior Room) – BB',1),(10,5,'Return Airport Transfer',2),(11,5,'Beanoa Beach With Uluwatu Sunset Tour – (Jet Sky + Parasailing Adventure)',3),(12,5,'Kintamani Volcano + Ubud Village (Kintamani Volcano + Tegenungan Waterfall + Bali Swing)',4),(13,5,'Nusa Penida Tour – (Private West Island Tour + Lunch)',5),(14,5,'Ulun Danu Beratan Temple + Handara Gate + Tanah Lot Temple with Sunset at Tanah Lot',6),(15,5,'All Tours & Transfer on Private Basis',7),(16,6,'3 Nights in Dubai + 1 Night in Abu Dhabi',1),(17,6,'4-Star hotel accommodation with breakfast',2),(18,6,'Private Transfers Included',3),(19,6,'Dubai City Tour + Burj Khalifa Entry',4),(20,6,'Desert Safari with BBQ Dinner',5),(21,6,'Abu Dhabi City Tour + Grand Mosque + BAPS Temple',6),(22,7,'3 Nights in Tokyo + 1 Night in Nagasaki',0),(23,7,'4-Star hotel accommodation with breakfast',1),(24,7,'Private Transfers Included',2),(25,7,'Desert Safari with BBQ Dinner',3);
/*!40000 ALTER TABLE `package_inclusions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package_itinerary`
--

DROP TABLE IF EXISTS `package_itinerary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package_itinerary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `day_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `display_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`),
  CONSTRAINT `package_itinerary_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_itinerary`
--

LOCK TABLES `package_itinerary` WRITE;
/*!40000 ALTER TABLE `package_itinerary` DISABLE KEYS */;
INSERT INTO `package_itinerary` VALUES (1,1,1,'Arrival in Delhi & Sightseeing','Arrive in Delhi and check-in to hotel (Red Fox Hotel / Radisson blu marina / Lemon Tree Premier). Visit Old Fort and Delhi Zoo in the afternoon. Explore India Gate and Connaught Place market in the evening. Overnight stay at the hotel.',1),(2,1,2,'Delhi Sightseeing','Visit Raj Ghat, Qutub Minar, Humayun\'s Tomb and Red Fort - Chandni Chowk market. Explore Jantar Mantar and Akshardham Temple in evening. Enjoy dinner at a local restaurant.',2),(3,1,3,'Delhi to Agra Sightseeing','Drive to Agra (approximately 4 hours) and check in hotel (Sterling Agra / Clark Shiraz Hotel). Visit Sikandra, the Mausoleum of Emperor Akbar. Explore the Taj Mahal, built by Mughal Emperor Shahjahan in 1630 AD. Overnight stay in Agra.',3),(4,1,4,'Agra to Mathura Sightseeing','Visit the Taj Mahal in the morning (optional). Drive to Mathura (approximately 1.5 hours). Explore Shri Krishna Janmasthan, Janma Bhoomi Mandir, Dwarkadhish Temple, and ISKCON Vrindavan. Overnight stay at Hotel Basera Brij Bhoomi or similar 4-star hotels.',4),(5,1,5,'Mathura to Delhi Departure','Drive back to Delhi (approximately 4 hours). Complete any last-minute shopping or sightseeing. Departure from Delhi.',5),(6,2,1,'Arrival in Jaipur','Arrive in Jaipur and check-in to your hotel (The Fern Residency / Golden Tulip or similar). Visit Amber Fort, Hawa Mahal, Panna Meena Kund, Jaigarh Fort, Jal Mahal, City Palace. Explore the city\'s bustling markets and try local cuisine. Dinner at Chokhi Dhani. Overnight stay in Jaipur.',1),(7,2,2,'Jaipur to Jodhpur via Pushkar','Drive to Pushkar (approximately 2 hours). Visit the Brahma Temple, Pushkar Lake, and surrounding markets. Drive from Pushkar to Jodhpur (approximately 4.5 hours). Check in to Hotel (Ranbanka Palace / Lords Inn / Zone by Park or similar). Evening leisure.',2),(8,2,3,'Explore Jodhpur','Visit Mehrangarh Fort, Jaswant Thada, and Umaid Bhawan Museum. Explore local markets and try traditional Rajasthani cuisine. Overnight stay in Jodhpur.',3),(9,2,4,'Jodhpur to Jaisalmer','Drive to Jaisalmer (approximately 5 hours). Visit Jaisalmer Fort, Patwon ki Haveli, and Gadisar Lake. Enjoy a camel ride and sunset at Sam Sand Dunes. Overnight stay in Jaisalmer at a 4-star hotel.',4),(10,2,5,'Jaisalmer to Udaipur via Ranakpur','Drive to Ranakpur (approximately 6 to 7 hours) and visit the famous Jain Temple. Continue to Udaipur (approximately 3.5 hours) and check-in to your 4-star hotel (The Lalit / Hotel Lakend / Fern Residency). Enjoy a romantic boat ride on Lake Pichola. Overnight stay in Udaipur.',5),(11,2,6,'Udaipur Sightseeing','Visit City Palace, Jagdish Temple, Saheliyon-ki-Bari, Bagore ki Haveli, Folk dance shows. Explore local markets and try traditional cuisine. Evening at leisure. Overnight stay in Udaipur.',6),(12,2,7,'Udaipur to Jaipur','Drive back to Jaipur (approximately 6 hours).',7),(13,3,1,'Arrival in North Goa','Check-in to your 4-star hotel (The Kimaya Baga / Hyatt Place Candolim or similar). Visit Baga, Calangute, and Candolim Beaches. Enjoy water sports: parasailing, jet skiing, banana boat rides. Relax or explore local nightlife.',1),(14,3,2,'North Goa Adventures','Visit Fort Aguada. Shop at Anjuna & Vagator markets. Evening sunset cruise / boat party.',2),(15,3,3,'South Goa Getaway','Drive to South Goa and check-in (Leela Goa / Taj Exotica or similar). Visit Palolem, Agonda, and Colva Beaches. Water sports: kayaking, surfing, paddleboarding. Explore Portuguese-style architecture in Margao.',3),(16,3,4,'South Goa Adventures','Scuba diving / snorkeling at Grand Island. Dolphin spotting & scenic boat ride. Try windsurfing or flyboarding at Morjim Beach.',4),(17,3,5,'Water Sports & Relaxation','Jet skiing, parasailing, bumper rides at Majorda / Bogmalo Beach. Evening relaxation or shopping.',5),(18,3,6,'Departure','Morning shopping & souvenirs. Departure from Goa.',6),(19,4,1,'Hanoi – Arrival – City Tour','Arrive in Hanoi. Check-in and city tour.',1),(20,4,2,'Hanoi – Free at leisure','Day free for optional tours or shopping.',2),(21,4,3,'Hanoi – Fly to Danang','Flight to Danang. Check-in and explore.',3),(22,4,4,'Danang – Ba Na Hills','Visit Ba Na Hills and Golden Bridge.',4),(23,4,5,'Danang – Free at leisure','Day free for optional tours or relaxation.',5),(24,4,6,'Danang – Departure','Transfer to airport for departure.',6),(25,5,1,'Arrival in Bali','Arrival and transfer to hotel. Check-in and relax.',1),(26,5,2,'Beanoa Beach & Uluwatu','Beanoa Beach With Uluwatu Sunset Tour – (Jet Sky + Parasailing Adventure)',2),(27,5,3,'Kintamani & Ubud','Kintamani Volcano + Ubud Village (Kintamani Volcano + Tegenungan Waterfall + Bali Swing)',3),(28,5,4,'Nusa Penida Tour','Nusa Penida Tour – (Private West Island Tour + Lunch)',4),(29,5,5,'Temples Tour','Ulun Danu Beratan Temple + Handara Gate + Tanah Lot Temple with Sunset at Tanah Lot',5),(30,5,6,'Departure','Transfer to airport for departure.',6),(31,6,1,'Arrival in Dubai','Arrival and transfer to hotel. Check-in and relax. Evening free.',1),(32,6,2,'Dubai City Tour','Dubai City Tour + Burj Khalifa Entry. Evening Desert Safari with BBQ Dinner.',2),(33,6,3,'Abu Dhabi Tour','Drive to Abu Dhabi. Abu Dhabi City Tour + Grand Mosque + BAPS Temple. Overnight in Abu Dhabi.',3),(34,6,4,'Return to Dubai','Return to Dubai. Free day for shopping or optional activities.',4),(35,6,5,'Departure','Transfer to airport for departure.',5),(36,7,1,'Arrival in Tokyo','Arrival and transfer to hotel. Check-in and relax. Evening free.',0),(37,7,2,'Tokyo City','Tokoyo city main square tour',1),(38,7,3,'Mount Fuji Tour','Mount Fuji Tour',2),(39,7,4,'Nagasaki ','Nagasaki tour',3);
/*!40000 ALTER TABLE `package_itinerary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package_itinerary_days`
--

DROP TABLE IF EXISTS `package_itinerary_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package_itinerary_days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `day_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `activities` text DEFAULT NULL,
  `meals` varchar(100) DEFAULT NULL,
  `hotel` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`),
  CONSTRAINT `package_itinerary_days_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `tour_packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_itinerary_days`
--

LOCK TABLES `package_itinerary_days` WRITE;
/*!40000 ALTER TABLE `package_itinerary_days` DISABLE KEYS */;
INSERT INTO `package_itinerary_days` VALUES (1,1,1,'Arrive Udaipur Local Sightseeing Tour','Arrive at Udaipur airport and transfer to the hotel. Udaipur, \'the city of lakes\' is admired for its fairy-tale palaces, lakes, temples, and gardens among many more. Proceed for sight seeing tour of Udaipur. Built in 1559 A.D. by Maharaja Udai Singh, the city has been described as the most romantic spot on the continent of India by Col. James Todd. The places of interest include City Palace which has several carved balconies, arches and decorated pillars, Zenana Mahal, Fateh Prakash, Durbar Hall and Shambhu Niwas. Also visit Jagdish temple, Sahelion-ki-Bari (queen\'s resort for the friends). Evening Motor launch cruise(Cruise ride not included) on the placid waters of Lake Pichola and enjoy scenic view of Sunset. Overnight stay.','Arrive Udaipur Local Sightseeing Tour','Chole Chawal',''),(2,1,2,'Udaipur Local Sightseeing','Breakfast at hotel. Morning city sight seeing tour. Built in 1559 A.D. by Maharaja Udai Singh, the city has been described as the most romantic spot on the continent of India by Col. James Todd. The places of interest include City Palace which has several carved balconies, arches and decorated pillars, Zenana Mahal, Fateh Prakash, Durbar Hall and Shambhu Niwas. Also visit Jagdish temple, Sahelion-ki-Bari (queen\'s resort for the friends). Evening Motor launch cruise(Cruise ride not included) on the placid waters of Lake Pichola and enjoy scenic view of Sunset. Overnight stay.','Udaipur Local Sightseeing','Chole Chawal','');
/*!40000 ALTER TABLE `package_itinerary_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package_notes`
--

DROP TABLE IF EXISTS `package_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `display_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`),
  CONSTRAINT `package_notes_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_notes`
--

LOCK TABLES `package_notes` WRITE;
/*!40000 ALTER TABLE `package_notes` DISABLE KEYS */;
INSERT INTO `package_notes` VALUES (1,4,'Note: Price excludes international flights.',1),(2,5,'Note: Price excludes international flights.',1),(3,6,'Note: Price excludes international flights.',1),(4,1,'Note: Prices may vary during peak season.',1),(5,2,'Note: Fort shows and cultural programs included.',1),(6,3,'Note: Water sports are subject to weather conditions.',1),(7,7,'Note: Price excludes international flights.',0);
/*!40000 ALTER TABLE `package_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package_pricing`
--

DROP TABLE IF EXISTS `package_pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package_pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `pax_count` int(11) NOT NULL,
  `room_count` int(11) DEFAULT 1,
  `budget_price` decimal(10,2) DEFAULT NULL,
  `standard_price` decimal(10,2) DEFAULT NULL,
  `deluxe_price` decimal(10,2) DEFAULT NULL,
  `super_deluxe_price` decimal(10,2) DEFAULT NULL,
  `luxury_price` decimal(10,2) DEFAULT NULL,
  `extra_adult_price` decimal(10,2) DEFAULT NULL,
  `extra_child_price` decimal(10,2) DEFAULT NULL,
  `dinner_charge` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`),
  CONSTRAINT `package_pricing_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `tour_packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_pricing`
--

LOCK TABLES `package_pricing` WRITE;
/*!40000 ALTER TABLE `package_pricing` DISABLE KEYS */;
INSERT INTO `package_pricing` VALUES (1,1,'Ac Indigo 02 Pax (01 Room)',2,1,7703.00,7794.00,8035.00,8561.00,8899.00,1102.00,500.00,900.00),(2,1,'Ac Dzire / Etios 02 Pax (01 Room)',2,1,7765.00,7796.00,8355.00,8566.00,8799.00,2000.00,700.00,1000.00);
/*!40000 ALTER TABLE `package_pricing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` enum('domestic','international') NOT NULL,
  `duration` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `price_note` varchar(255) DEFAULT NULL,
  `suitable_for` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `border_color` enum('green','red','blue','orange','purple') DEFAULT 'green',
  `status` tinyint(1) DEFAULT 1,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

LOCK TABLES `packages` WRITE;
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` VALUES (1,'GOLDEN TRIANGLE PACKAGE (DELHI - AGRA - MATHURA - DELHI)','golden-triangle-package','domestic','4N/5D',599.00,'(Two Adults)','Family, Couples','Explore the famous Golden Triangle circuit covering Delhi, Agra and Mathura with 4-star hotel accommodations and private transfers.','uploads/packages/Delhi-Agra-Mathura-Tour-Itinerary.jpg','green',1,1,'2026-02-27 01:40:48','2026-02-27 01:56:34'),(2,'RANGEELO RAJASTHAN TOUR PACKAGE','rangeelo-rajasthan','domestic','6N/7D',1999.00,'(Two Adults)','Family, Couples','Experience the royal heritage of Rajasthan with this comprehensive tour covering Jaipur, Jodhpur, Jaisalmer and Udaipur.','uploads/packages/rangelo-rajasthang.jpg','red',1,1,'2026-02-27 01:40:48','2026-02-27 01:56:25'),(3,'GOA FUN FIESTA PACKAGE','goa-fun-fiesta','domestic','5N/6D',1999.00,'(Two Adults)','Family, Couples, Friends','Experience the best of Goa with exciting water sports, beach activities and luxury stays.','uploads/packages/goa-fun-fiesta.jpg','blue',1,1,'2026-02-27 01:40:48','2026-02-27 01:56:19'),(4,'Vietnam Escape','vietnam-escape','international','5N/6D',999.00,'(2 People)','Couples, Family','Explore the beautiful landscapes of Vietnam with visits to Hanoi, Halong Bay and Danang.','uploads/packages/vietnam.png','green',1,1,'2026-02-27 01:40:48','2026-02-27 01:56:05'),(5,'Bali Bliss','bali-bliss','international','5N/6D',1199.00,'(2 People)','Couples, Friends','Experience the magic of Bali with island tours, water sports and cultural experiences.','uploads/packages/bali.png','red',1,1,'2026-02-27 01:40:48','2026-02-27 01:56:00'),(6,'Dubai Delight','dubai-delight','international','4N/5D',1999.00,'(2 People)','Couples, Luxury Travelers','Experience the luxury of Dubai with city tours, desert safari and Burj Khalifa visit.','uploads/packages/dubai.png','green',1,1,'2026-02-27 01:40:48','2026-02-27 01:55:53'),(7,'Japan','japan','international','4',2499.00,'2','Couples','Japan is a captivating destination where ancient traditions blend seamlessly with futuristic innovation. From the neon-lit skyline of Tokyo to the peaceful temples of Kyoto and the iconic beauty of Mount Fuji, every corner offers a unique experience. Visitors can explore historic shrines, enjoy world-famous cuisine like sushi and ramen, witness breathtaking cherry blossoms, and experience unmatched cleanliness and hospitality.','uploads/packages/1772157276_69a0f95c80f98.png','orange',1,1,'2026-02-27 01:54:36','2026-02-27 01:54:36');
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `policies`
--

DROP TABLE IF EXISTS `policies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `policies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `policy_code` varchar(50) DEFAULT NULL,
  `version` varchar(20) DEFAULT '1.0',
  `effective_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(100) DEFAULT NULL,
  `last_updated_by` varchar(100) DEFAULT NULL,
  `policy_type` varchar(50) DEFAULT 'General',
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category` (`category`),
  KEY `policy_code` (`policy_code`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `policies`
--

LOCK TABLES `policies` WRITE;
/*!40000 ALTER TABLE `policies` DISABLE KEYS */;
INSERT INTO `policies` VALUES (1,'Privacy Policy ','<h2><strong>Privacy Policy</strong></h2>\r\n\r\n<p>At <strong>PSARA License</strong>, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you visit our website or use our services.</p>\r\n\r\n<h3><strong>1. Information We Collect</strong></h3>\r\n\r\n<p>We may collect the following information:</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Name, email address, phone number</p>\r\n	</li>\r\n	<li>\r\n	<p>Business details related to PSARA licensing</p>\r\n	</li>\r\n	<li>\r\n	<p>Documents submitted for PSARA application</p>\r\n	</li>\r\n	<li>\r\n	<p>Website usage data (cookies, IP address, browser type)</p>\r\n	</li>\r\n</ul>\r\n\r\n<h3><strong>2. How We Use Your Information</strong></h3>\r\n\r\n<p>Your information is used to:</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Process PSARA License applications</p>\r\n	</li>\r\n	<li>\r\n	<p>Communicate updates and support</p>\r\n	</li>\r\n	<li>\r\n	<p>Improve our services and website</p>\r\n	</li>\r\n	<li>\r\n	<p>Comply with legal and regulatory requirements</p>\r\n	</li>\r\n</ul>\r\n\r\n<h3><strong>3. Data Protection</strong></h3>\r\n\r\n<p>We implement appropriate security measures to protect your personal data against unauthorized access, alteration, or disclosure.</p>\r\n\r\n<h3><strong>4. Sharing of Information</strong></h3>\r\n\r\n<p>We do <strong>not sell or rent</strong> your personal data. Information may be shared only with:</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Government authorities (for PSARA processing)</p>\r\n	</li>\r\n	<li>\r\n	<p>Legal or regulatory bodies if required by law</p>\r\n	</li>\r\n</ul>\r\n\r\n<h3><strong>5. Cookies</strong></h3>\r\n\r\n<p>Our website may use cookies to enhance user experience and analyze website traffic. You can disable cookies through your browser settings.</p>\r\n\r\n<h3><strong>6. Third-Party Links</strong></h3>\r\n\r\n<p>Our website may contain links to third-party websites. We are not responsible for their privacy practices.</p>\r\n\r\n<h3><strong>7. Your Rights</strong></h3>\r\n\r\n<p>You have the right to:</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Access your personal data</p>\r\n	</li>\r\n	<li>\r\n	<p>Request correction or deletion</p>\r\n	</li>\r\n	<li>\r\n	<p>Withdraw consent at any time</p>\r\n	</li>\r\n</ul>\r\n\r\n<h3><strong>8. Updates to This Policy</strong></h3>\r\n\r\n<p>PSARA License reserves the right to update this Privacy Policy at any time. Changes will be posted on this page.</p>\r\n\r\n<h3><strong>9. Contact Us</strong></h3>\r\n\r\n<p>For privacy-related concerns, contact us at:<br />\r\n???? <strong>support@psaralicense.com</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n','General','','1.0','2026-01-01',1,'2026-01-01 07:38:49','2026-01-02 10:28:07','admin','admin','Public','Read the Privacy Policy of PSARA License to understand how we collect, use, and protect your personal information while providing PSARA licensing services','PSARA License privacy policy, PSARA consultancy privacy, security agency license privacy, PSARA data protection, personal information policy','privacy-policy'),(2,'Terms & Conditions','<p><strong>Terms &amp; Conditions</strong></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>Welcome to <strong>PSARA License</strong>. By accessing our website or using our services, you agree to comply with the following Terms &amp; Conditions.</p>\\r\\n\\r\\n<p><strong>1. Services</strong></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>PSARA License provides consultancy and assistance for obtaining PSARA licenses. Approval depends solely on the respective government authorities.</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p><strong>2. User Responsibilities</strong></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>You agree to:</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>Provide accurate and complete information</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>Submit genuine documents</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>Use our services for lawful purposes only</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p><strong>3. Fees &amp; Payments</strong></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<ul>\\r\\n	<li>\\\\r\\\\n</li>\\r\\n	<li>Service fees are non-refundable once work has commenced</li>\\r\\n	<li>\\\\r\\\\n</li>\\r\\n	<li>Government fees are separate and payable as applicable</li>\\r\\n	<li>\\\\r\\\\n</li>\\r\\n	<li></li>\\r\\n	<li>\\\\r\\\\n</li>\\r\\n	<li><strong>4. No Guarantee of Approval</strong></li>\\r\\n	<li>\\\\r\\\\n</li>\\r\\n</ul>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>PSARA License does <strong>not guarantee</strong> license approval, as final decisions rest with government authorities.</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p><strong>5. Intellectual Property</strong></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>All website content, logos, and materials are the property of PSARA License and may not be copied or reproduced without permission.</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p><strong>6. Limitation of Liability</strong></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>PSARA License shall not be liable for:</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<ul>\\r\\n	<li>\\\\r\\\\n</li>\\r\\n	<li>\\\\r\\\\n\\r\\n	<p>Delays caused by government departments</p>\\r\\n	\\\\r\\\\n</li>\\r\\n	<li>\\\\r\\\\n</li>\\r\\n	<li>\\\\r\\\\n\\r\\n	<p>Rejection due to incomplete or incorrect information provided by the client</p>\\r\\n	\\\\r\\\\n</li>\\r\\n	<li>\\\\r\\\\n</li>\\r\\n	<li>\\\\r\\\\n\\r\\n	<p>Technical issues beyond our control</p>\\r\\n	\\\\r\\\\n</li>\\r\\n	<li>\\\\r\\\\n</li>\\r\\n</ul>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p><strong>7. Termination</strong></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>We reserve the right to terminate services if false information or misuse is detected.</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p><strong>8. Governing Law</strong></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>These Terms &amp; Conditions are governed by the laws of <strong>India</strong>. Any disputes shall be subject to the jurisdiction of Indian courts.</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p><strong>9. Changes to Terms</strong></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>PSARA License may modify these Terms &amp; Conditions at any time without prior notice.</p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p><strong>10. Contact Information</strong></p>\\r\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>For questions regarding these terms, contact:<br />\\r\\n\\\\r\\\\n<strong>support@psaralicense.com</strong></p>\\r\\n\\\\r\\\\n','Terms','','1.0','2026-01-01',1,'2026-01-01 07:42:14','2026-01-02 10:01:46','admin','admin','Legal','Review the Terms & Conditions of PSARA License outlining service usage, responsibilities, and legal obligations for PSARA licensing services.','PSARA License terms and conditions, PSARA consultancy terms, security agency license rules, PSARA service agreement','terms-conditions');
/*!40000 ALTER TABLE `policies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `file_size` int(10) unsigned DEFAULT NULL,
  `mime_type` varchar(50) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (6,89339,'1759316135_services-v1-img2.jpg',NULL,NULL,'2025-10-01 10:55:35'),(8,89339,'1759316188_services-v2-img1.jpg',NULL,NULL,'2025-10-01 10:56:28'),(9,89339,'1759316188_services-v2-img2.jpg',NULL,NULL,'2025-10-01 10:56:28'),(10,89339,'1759316188_services-v2-img3.jpg',NULL,NULL,'2025-10-01 10:56:28'),(11,64116,'1759743547_p2.jpg',NULL,NULL,'2025-10-06 09:39:07'),(12,64116,'1759743547_p4.jpg',NULL,NULL,'2025-10-06 09:39:07'),(15,96095,'1759904076_PVC Super Halwa Garden Pipe.png',NULL,NULL,'2025-10-08 06:14:36'),(16,96095,'1759904145_Super Halwa Garden Pipe (2).png',NULL,NULL,'2025-10-08 06:15:45'),(17,96095,'1759904145_Super Halwa Garden Pipe (3).png',NULL,NULL,'2025-10-08 06:15:45'),(18,96095,'1759904145_Super Halwa Garden Pipe (4).png',NULL,NULL,'2025-10-08 06:15:45'),(19,96095,'1759904145_Super Halwa Garden Pipe (5).png',NULL,NULL,'2025-10-08 06:15:45'),(20,88782,'1759904265_Heavy Duty PVC  Braided Hose Pipe.png',NULL,NULL,'2025-10-08 06:17:45'),(21,88782,'1759904272_Heavy Duty PVC  Braided Hose Pipe (2).png',NULL,NULL,'2025-10-08 06:17:52'),(22,88782,'1759904272_Heavy Duty PVC  Braided Hose Pipe (3).png',NULL,NULL,'2025-10-08 06:17:52'),(23,67613,'1759904471_PVC Suction Hose Pipe (2).png',NULL,NULL,'2025-10-08 06:21:11'),(24,67613,'1759904479_PVC Suction Hose Pipe (3).png',NULL,NULL,'2025-10-08 06:21:19'),(25,67613,'1759904479_PVC Suction Hose Pipe.png',NULL,NULL,'2025-10-08 06:21:19'),(26,88771,'1759904547_PVC Heavy Duty Suction Hose Pipe (2).png',NULL,NULL,'2025-10-08 06:22:27'),(27,88771,'1759904554_PVC Heavy Duty Suction Hose Pipe (3).png',NULL,NULL,'2025-10-08 06:22:34'),(28,88771,'1759904554_PVC Heavy Duty Suction Hose Pipe (4).png',NULL,NULL,'2025-10-08 06:22:34'),(29,88771,'1759904554_PVC Heavy Duty Suction Hose Pipe.png',NULL,NULL,'2025-10-08 06:22:34'),(30,70298,'1759904879_Super Orange & White Heavy Duty Garden Pipe (2).png',NULL,NULL,'2025-10-08 06:27:59'),(31,70298,'1759904885_Super Orange & White Heavy Duty Garden Pipe (3).png',NULL,NULL,'2025-10-08 06:28:05'),(32,70298,'1759904885_Super Orange & White Heavy Duty Garden Pipe.png',NULL,NULL,'2025-10-08 06:28:05'),(33,59630,'1759904952_PVC Color Transparent 50-50  Garden Pipe (Gold Series).png',NULL,NULL,'2025-10-08 06:29:12'),(34,59630,'1759904961_Color Transparent 50-50  Garden Pipe (Gold Series) (3).png',NULL,NULL,'2025-10-08 06:29:21'),(35,59630,'1759904961_Color Transparent 50-50  Garden Pipe (Gold Series) (4).png',NULL,NULL,'2025-10-08 06:29:21'),(36,59630,'1759904961_Color Transparent 50-50  Garden Pipe (Gold Series) (5).png',NULL,NULL,'2025-10-08 06:29:21'),(37,59630,'1759904961_Colour Transparent 50-50  Garden Pipe (Gold Series) (2).png',NULL,NULL,'2025-10-08 06:29:21'),(38,24536,'1759905031_PVC Color Transparent Zebra Garden Pipe(Gold Series).png',NULL,NULL,'2025-10-08 06:30:31'),(39,24536,'1759905039_Color Transparent Zebra Garden Pipe(Gold Series) (2).png',NULL,NULL,'2025-10-08 06:30:39'),(40,24536,'1759905039_Color Transparent Zebra Garden Pipe(Gold Series) (3).png',NULL,NULL,'2025-10-08 06:30:39'),(41,24536,'1759905039_Color Transparent Zebra Garden Pipe(Gold Series) (4).png',NULL,NULL,'2025-10-08 06:30:39'),(42,24536,'1759905039_Color Transparent Zebra Garden Pipe(Gold Series) (5).png',NULL,NULL,'2025-10-08 06:30:39'),(43,33032,'1759905129_PVC Foam Pipe Garden Pipe (Gold Series) (2).png',NULL,NULL,'2025-10-08 06:32:09'),(44,33032,'1759905138_PVC Foam Pipe Garden Pipe (Gold Series) (3).png',NULL,NULL,'2025-10-08 06:32:18'),(45,33032,'1759905138_PVC Foam Pipe Garden Pipe (Gold Series) (4).png',NULL,NULL,'2025-10-08 06:32:18'),(46,33032,'1759905138_PVC Foam Pipe Garden Pipe (Gold Series) (5).png',NULL,NULL,'2025-10-08 06:32:18'),(47,33032,'1759905138_PVC Foam Pipe Garden Pipe (Gold Series).png',NULL,NULL,'2025-10-08 06:32:18'),(48,47603,'1759905183_Super Color Garden Pipe (Gold Series).png',NULL,NULL,'2025-10-08 06:33:03'),(49,47603,'1759905207_Super Color Garden Pipe (Gold Series) (2).png',NULL,NULL,'2025-10-08 06:33:27'),(50,47603,'1759905207_Super Color Garden Pipe (Gold Series) (3).png',NULL,NULL,'2025-10-08 06:33:27'),(51,47603,'1759905207_Super Color Garden Pipe (Gold Series) (4).png',NULL,NULL,'2025-10-08 06:33:27'),(52,47603,'1759905207_Super Color Garden Pipe (Gold Series) (5).png',NULL,NULL,'2025-10-08 06:33:27'),(53,40782,'1759905280_Super Halwa Garden Pipe (Gold Series) (3).png',NULL,NULL,'2025-10-08 06:34:40'),(54,40782,'1759905294_Super Halwa Garden Pipe (Gold Series) (2).png',NULL,NULL,'2025-10-08 06:34:54'),(55,40782,'1759905294_Super Halwa Garden Pipe (Gold Series) (4).png',NULL,NULL,'2025-10-08 06:34:54'),(56,40782,'1759905294_Super Halwa Garden Pipe (Gold Series) (5).png',NULL,NULL,'2025-10-08 06:34:54'),(57,40782,'1759905294_Super Halwa Garden Pipe (Gold Series).png',NULL,NULL,'2025-10-08 06:34:54'),(58,26120,'1759905380_Color Transparent Garden pipe (5).png',NULL,NULL,'2025-10-08 06:36:20'),(59,26120,'1759905392_Color Transparent Garden pipe (2).png',NULL,NULL,'2025-10-08 06:36:32'),(60,26120,'1759905392_Color Transparent Garden pipe (3).png',NULL,NULL,'2025-10-08 06:36:32'),(61,26120,'1759905392_Color Transparent Garden pipe (4).png',NULL,NULL,'2025-10-08 06:36:32'),(62,26120,'1759905392_Color Transparent Garden pipe.png',NULL,NULL,'2025-10-08 06:36:32');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_reviews`
--

DROP TABLE IF EXISTS `product_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `review_message` text NOT NULL,
  `reviewer_name` varchar(255) NOT NULL,
  `reviewer_email` varchar(255) NOT NULL,
  `reviewver_img` varchar(2000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`review_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_reviews`
--

LOCK TABLES `product_reviews` WRITE;
/*!40000 ALTER TABLE `product_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pro_id` int(10) NOT NULL,
  `pro_name` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `pro_cate` int(10) DEFAULT NULL,
  `pro_sub_cate` int(10) DEFAULT NULL,
  `short_desc` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `new_arrival` tinyint(1) DEFAULT NULL,
  `trending` tinyint(10) DEFAULT NULL,
  `qty` varchar(10) DEFAULT NULL,
  `mrp` float DEFAULT NULL,
  `selling_price` float DEFAULT NULL,
  `whole_sale_selling_price` varchar(10) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `pro_img` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `slug_url` varchar(255) NOT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_desc` varchar(2000) DEFAULT NULL,
  `meta_key` text DEFAULT NULL,
  `added_on` varchar(255) NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=271 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (269,96746,'Perforated And Tooth Knives','Perforated And Tooth Knives',85726,86383,'<p><strong>Perforated and Tooth Knives</strong> are precision-engineered cutting tools designed for clean, efficient, and consistent cutting performance in industrial and food processing applications. Their serrated and perforated design ensures smooth slicing with minimal resistance.</p>\r\n','<p><strong>Perforated and Tooth Knives</strong> are specially crafted industrial cutting tools known for their sharpness, durability, and superior performance. Designed with strategically placed perforations and precision-ground teeth, these knives reduce friction during operation, ensuring smoother cuts and enhanced efficiency.</p>\r\n\r\n<p>Commonly used in food processing, packaging, paper, textile, and industrial manufacturing units, these knives provide accurate and uniform cutting results. The perforated structure allows better airflow and reduced material sticking, while the tooth edge enhances grip and cutting strength.</p>\r\n\r\n<p>Manufactured from high-grade stainless steel or alloy steel, Perforated and Tooth Knives are resistant to wear, corrosion, and heavy-duty usage. Their robust construction ensures long-lasting performance even under continuous industrial operation.</p>\r\n\r\n<p>These knives are ideal for businesses looking to improve productivity, minimize downtime, and achieve precision cutting with reliability.</p>\r\n',0,0,'',0,0,'',0,'1.png',1,'perforated-and-tooth-knives','Perforated And Tooth Knives','Perforated And Tooth Knives','Perforated And Tooth Knives','Feb 21, 2026'),(270,38164,'Circular knifes','Circular knifes',85726,86383,'<p><strong>Circular Knives</strong> are high-performance rotary cutting tools designed for precise, smooth, and continuous cutting in industrial applications. They deliver clean cuts with high efficiency and durability.</p>\r\n','<p><strong>Circular Knives</strong>, also known as rotary blades, are precision-engineered cutting tools widely used in industrial and manufacturing environments. Designed in a round blade form, these knives provide consistent, accurate, and high-speed cutting performance.</p>\r\n\r\n<p>Manufactured from premium-grade stainless steel, carbon steel, or alloy steel, Circular Knives are known for their exceptional sharpness, wear resistance, and long operational life. Their balanced design ensures reduced vibration, smooth rotation, and minimal material wastage.</p>\r\n\r\n<p>These knives are commonly used in industries such as paper cutting, plastic processing, packaging, textile, rubber, metal sheet cutting, and food processing. Depending on the application, they are available in various diameters, thicknesses, bore sizes, and edge types (straight, serrated, or scalloped).</p>\r\n\r\n<p>Circular Knives are ideal for businesses seeking precision, durability, and enhanced productivity in continuous cutting operations.</p>\r\n',0,0,'',0,0,'',0,'2.png',1,'circular-knifes','Circular knifes','Circular knifes','Circular knifes','Feb 21, 2026');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `special_offers`
--

DROP TABLE IF EXISTS `special_offers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `special_offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `special_offers`
--

LOCK TABLES `special_offers` WRITE;
/*!40000 ALTER TABLE `special_offers` DISABLE KEYS */;
/*!40000 ALTER TABLE `special_offers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `cate_id` int(10) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_desc` text NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `sub_cat_img` varchar(255) DEFAULT NULL,
  `slug_url` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `added_on` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=401 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_categories`
--

LOCK TABLES `sub_categories` WRITE;
/*!40000 ALTER TABLE `sub_categories` DISABLE KEYS */;
INSERT INTO `sub_categories` VALUES (395,85726,86383,'Perforation Knives','Perforation Knives','Perforation Knives','Perforation Knives','img_699942686a62e1.17740115.png','perforation-knives',1,'Feb 21, 2026'),(396,85726,82115,'Vertical Foam Cutting Machine','Vertical Foam Cutting Machine','Vertical Foam Cutting Machine','Vertical Foam Cutting Machine','img_699942fc347283.96721785.png','vertical-foam-cutting-machine',1,'Feb 21, 2026'),(397,85726,17753,'Carry Bag','Carry Bag','Carry Bag','Carry Bag','img_6999433fe7eb14.00833699.png','carry-bag',1,'Feb 21, 2026'),(398,85726,91331,'Industrial Knives','Industrial Knives','Industrial Knives','Industrial Knives','img_6999438d295b80.74996090.png','industrial-knives',1,'Feb 21, 2026'),(399,85726,91582,'Perforated Sheet','Perforated Sheet','Perforated Sheet','Perforated Sheet','img_69994430178e91.45019526.png','perforated-sheet',1,'Feb 21, 2026'),(400,85726,30210,'Kitchen Tools','Kitchen Tools','Kitchen Tools','Kitchen Tools','img_699944635316a2.04161600.png','kitchen-tools',1,'Feb 21, 2026');
/*!40000 ALTER TABLE `sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `client_title` varchar(100) DEFAULT NULL,
  `client_company` varchar(100) DEFAULT NULL,
  `client_photo` varchar(255) DEFAULT NULL,
  `testimonial_text` text NOT NULL,
  `rating` tinyint(4) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `project_name` varchar(100) DEFAULT NULL,
  `project_date` date DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,'Ajay Sharma','Restaurant Owner','Acme Corp','testimonials-v1-img2.jpg','Perfect Knives has consistently delivered high-quality products that meet our manufacturing standards. Their reliable tools have improved our operational efficiency and reduced downtime.',5,'Career advice life coach','0000-00-00',1,0,'2025-05-08 10:15:18','2026-02-21 05:21:07'),(2,'Vikram Singh','Wholesale Buyer','TechStart Inc','testimonials-v1-img3.jpg','The craftsmanship and strength of Perfect Knives’ products are outstanding. Since integrating their tools into our unit, we’ve noticed a clear improvement in performance and productivity.',4,'Cotton Cloth','0000-00-00',1,0,'2025-05-08 10:15:18','2026-02-21 05:21:18'),(3,'Priya Sharma','Supermarket Manager','','testimonials-v2-1.png','We trust Perfect Knives for their superior quality and dependable service. Their tools are built to last and have played a key role in enhancing our overall manufacturing efficiency.',4,'','0000-00-00',0,0,'2025-05-08 10:15:18','2026-02-21 05:21:32'),(4,'Rajesh Kumar','CEO','Acme Corp','testimonials-v1-img1.jpg','We’ve been sourcing tools from Perfect Knives for quite some time now, and their product quality is truly exceptional. The durability and precision of their tools have helped streamline our production process significantly.',4,'','0000-00-00',1,0,'2025-05-13 05:51:45','2026-02-21 05:20:50');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_packages`
--

DROP TABLE IF EXISTS `tour_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tour_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `package_code` varchar(20) NOT NULL,
  `package_name` varchar(200) NOT NULL,
  `duration_days` int(11) NOT NULL,
  `duration_nights` int(11) NOT NULL,
  `pickup_from` varchar(100) DEFAULT NULL,
  `drop_at` varchar(100) DEFAULT NULL,
  `tour_summary` text DEFAULT NULL,
  `itinerary` text DEFAULT NULL,
  `inclusions` text DEFAULT NULL,
  `exclusions` text DEFAULT NULL,
  `valid_from` date DEFAULT NULL,
  `valid_to` date DEFAULT NULL,
  `contact_numbers` varchar(100) DEFAULT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `package_code` (`package_code`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `tour_packages_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `tourism_locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_packages`
--

LOCK TABLES `tour_packages` WRITE;
/*!40000 ALTER TABLE `tour_packages` DISABLE KEYS */;
INSERT INTO `tour_packages` VALUES (1,1,'001D03','Udaipur Tour 3 Days',3,2,'Delhi','Udaipur','ITINERARY NO: 3D-RT07\r\n\r\nUdaipur Holiday Plan\r\nBook Udaipur Tour Packages at best price. Deals are available for Udaipur Tour Packages. Tailormade itineraries are available on request.\r\n\r\nUdaipur( Arrive )- Udaipur (02 Nights)- Udaipur Drop\r\n\r\nDuration: 03 DAYS/ 02 NIGHTS',NULL,NULL,NULL,'2026-02-27','2026-03-02','9632587412','96325698745','Udaipur Tour Package | Udaipur Tour 3 Days','Udaipur Tour Package | Udaipur Tour 3 Days','Udaipur Tour Package | Udaipur Tour 3 Days',1,'2026-02-26 02:01:19');
/*!40000 ALTER TABLE `tour_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tourism_locations`
--

DROP TABLE IF EXISTS `tourism_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tourism_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `location_slug` varchar(100) NOT NULL,
  `location_description` text DEFAULT NULL,
  `location_image` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `location_slug` (`location_slug`),
  KEY `state_id` (`state_id`),
  CONSTRAINT `tourism_locations_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `tourism_states` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tourism_locations`
--

LOCK TABLES `tourism_locations` WRITE;
/*!40000 ALTER TABLE `tourism_locations` DISABLE KEYS */;
INSERT INTO `tourism_locations` VALUES (1,1,'Agra Jaipur ','agra-jaipur-','ITINERARY NO: 3D-RT01\r\nAGRA, JAIPUR\r\nDelhi( Arrive )- Agra(01 Night)- Jaipur (01 Night)- Delhi Drop\r\nDuration: 03 DAYS/ 02 NIGHTS','uploads/locations/1772070372_699fa5e42148f.jpg','Agra Jaipur Tour 3 Days | Agra Jaipur Tour Package | Agra Jaipur Tour from Delhi','Agra Jaipur Tour 3 Days | Agra Jaipur Tour Package | Agra Jaipur Tour from Delhi','Agra Jaipur Tour 3 Days | Agra Jaipur Tour Package | Agra Jaipur Tour from Delhi',1,'2026-02-26 01:46:12');
/*!40000 ALTER TABLE `tourism_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tourism_states`
--

DROP TABLE IF EXISTS `tourism_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tourism_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(100) NOT NULL,
  `state_slug` varchar(100) NOT NULL,
  `state_description` text DEFAULT NULL,
  `state_image` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `state_slug` (`state_slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tourism_states`
--

LOCK TABLES `tourism_states` WRITE;
/*!40000 ALTER TABLE `tourism_states` DISABLE KEYS */;
INSERT INTO `tourism_states` VALUES (1,'Rajasthan Tours','rajasthan-tours','Rajasthan Tour Packages - Book trip from Budget Rajasthan Tour Package to Luxury Rajasthan Tour Package. Cheap rates are available for Rajasthan Tour Packages. Best Rajasthan Tour Packages are available From Delhi, Jaipur, Ahmedabad, Udaipur and other pick up places. Rajasthan Holiday Packages can be customized from 3 days to 20 days.\r\n\r\nOm Shiv Tours offers best deal for Rajasthan Hotels. Rajasthan tour packages are available for all hotels starting from budget hotels to luxury hotels. Guests can experience Desert, Hills, Lakes, Forts, Monuments in Rajasthan. Guests can also enjoy Elephant ride, camel ride, motor cruise. Rajasthan is also famous for its culture in India and Abroad. Click on below for Rajasthan Tour itinerary.\r\n\r\nRajasthan Tour Itineraries Valid given in respective itineraries.\r\n\r\nNO COMMISSION ON Extra Person Sharing the Room, Child with Bed, Child no Bed.\r\n\r\nService Tax will be additional on package cost.','uploads/states/1772069961_699fa4493c119.jpg','Rajasthan Tour Packages | Budget Rajasthan Tour Packages | Rajasthan Tourism Packages','Rajasthan Tour Packages | Budget Rajasthan Tour Packages | Rajasthan Tourism Packages','Rajasthan Tour Packages | Budget Rajasthan Tour Packages | Rajasthan Tourism Packages',1,'2026-02-26 01:39:21'),(2,' Himachal Tours','-himachal-tours','Book Himachal tour packages at lowest price. Best offers on Himachal tour packages are available. Dreamland of Himachal Tour Packages offers rivers, hot springs and snow capped mountains and green land. In Himachal Tourism we offer Himachal Tours and Himachal Itinerary. In Himachal Tour Packages you will visit many Himachal Tourist Places. In Himachal Tour some famous places are Shimla Kullu Manali Dharamshala Dalhousie Khajjiar Chail. Best Himachal Tour Packages are available with best deals and offers. Find below package for Himachal Delighted Itineraries valid given in respective itineraries.','uploads/states/1772070050_699fa4a2d3595.jpg','Himachal Tours | Best Himachal Tour Packages from Delhi & Chandigarh','Himachal Tours | Best Himachal Tour Packages from Delhi & Chandigarh','Himachal Tours | Best Himachal Tour Packages from Delhi & Chandigarh',1,'2026-02-26 01:40:50'),(3,'Karnataka Tours','karnataka-tours','Dear Travel Partners,\r\n\r\nGreetings from Om Shiv Tours!\r\n\r\nSouth India Tour Itenararies valid given in respective itineraries.\r\n\r\nNO COMMISSION ON Extra Person Sharing the Room, Child with Bed, Child no Bed.\r\n\r\nService Tax will be additional on package cost.','uploads/states/1772070090_699fa4ca0d6df.jpg','Bangalore Mysore Ooty Coorg Kodaikanal Wayanad Package','Bangalore Mysore Ooty Coorg Kodaikanal Wayanad Package','Bangalore Mysore Ooty Coorg Kodaikanal Wayanad Package',1,'2026-02-26 01:41:30');
/*!40000 ALTER TABLE `tourism_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `last_name` varchar(55) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `remember_token'` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (41,'nikhil',NULL,NULL,'nikhil@gmail.com','$2y$10$/AkSLlcSgDaBa0cYziQQiOsFM2fOtQpqUKOtzG4lLuvkHf7YywJ8y',NULL,'2025-03-26 07:43:07',NULL,NULL,NULL,NULL,NULL),(46,'name',NULL,NULL,'email','$2y$10$F7uK.T7F8PvnVYkRS2K2YeEoG1P9uuiopJdyz/mLaKMqIOMYWc8Ou',NULL,'2025-05-07 01:13:53',NULL,NULL,NULL,NULL,NULL),(47,'nikhil','gupta','09876543210','nikhilgupta@gmail.com','$2y$10$FMhHYJbbximC27Zinqh25eAo1ckdh82okZsvrKUuGgnd2rbnVU2N6','user_47_1746669760.png','2025-05-07 01:18:39','rama road','DELHI','new deljhi','110015',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visa_cities`
--

DROP TABLE IF EXISTS `visa_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visa_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `city_order` int(11) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text DEFAULT NULL,
  `hero_h1` varchar(255) NOT NULL,
  `hero_tagline` text NOT NULL,
  `intro_heading` varchar(255) NOT NULL,
  `intro` text NOT NULL,
  `services` longtext NOT NULL COMMENT 'JSON array of {title, desc, icon, country_link}',
  `faqs` longtext NOT NULL COMMENT 'JSON array of {q, a}',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `status_order` (`status`,`city_order`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visa_cities`
--

LOCK TABLES `visa_cities` WRITE;
/*!40000 ALTER TABLE `visa_cities` DISABLE KEYS */;
INSERT INTO `visa_cities` VALUES (1,'bangalore','Bangalore',10,'Best Visa Consultants in Bangalore | Top Immigration & Student Visa Experts – Vocation Travels And Tours','Looking for the best visa consultants in Bangalore? Get expert help from top immigration consultants for student visas, Canada PR, US tourist visa, Australia visa and overseas education guidance.','best visa consultants in bangalore, top immigration consultants in bangalore, student visa consultancy bangalore, canada pr visa consultants in bangalore, us tourist visa agents bangalore, australia visa consultants bangalore, overseas education consultants in bangalore','Best Visa Consultants in Bangalore','Trusted by students, professionals and families across Bangalore for visa, immigration and overseas education guidance.','Bangalore\'s Go-To Visa & Immigration Consultants','If you\'ve been searching for the best visa consultants in Bangalore, our team supports applicants across the city with honest, document-first guidance — whether you\'re a student planning to study abroad, a professional applying for a Canada PR visa, or a family booking a US tourist visa. We combine pan-India visa expertise with a Bangalore-focused service model, so you get direct, responsive support without needing to travel to a consulate city yourself.','[{\"title\":\"Student Visa Consultancy in Bangalore\",\"keyword_note\":\"student visa consultancy bangalore\",\"desc\":\"End-to-end student visa consultancy for Bangalore-based students — university shortlisting inputs, SOP review, financial documentation and visa interview preparation for the USA, UK, Canada and Australia.\",\"icon\":\"fa-graduation-cap\"},{\"title\":\"Canada PR Visa Consultants\",\"keyword_note\":\"canada pr visa consultants in bangalore\",\"desc\":\"Guidance on Express Entry / PR-track documentation, visitor and Super Visa applications for Bangalore applicants and their families.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"US Tourist Visa Agents\",\"keyword_note\":\"us tourist visa agents bangalore\",\"desc\":\"DS-160 filing, appointment scheduling and mock interview preparation for B1/B2 tourist and visiting-family visas.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Australia Visa Consultants\",\"keyword_note\":\"australia visa consultants bangalore\",\"desc\":\"Support with visitor, student-dependent and business visa documentation for travel to Australia.\",\"icon\":\"fa-earth-oceania\",\"country_link\":\"australia\"},{\"title\":\"Overseas Education Consultants\",\"keyword_note\":\"overseas education consultants in bangalore\",\"desc\":\"Complementing our student visa services with guidance on application timelines, financial proof planning and pre-departure preparation for Bangalore students.\",\"icon\":\"fa-book-open\"},{\"title\":\"Immigration Documentation Support\",\"keyword_note\":\"top immigration consultants in bangalore\",\"desc\":\"Careful, checklist-driven documentation support across visa categories — the detail-focused approach Bangalore applicants look for in an immigration consultant.\",\"icon\":\"fa-passport\"}]','[{\"q\":\"Who are the best visa consultants in Bangalore for students and families?\",\"a\":\"We support both individual travelers and students across Bangalore with documentation, application filing and interview preparation for major visa destinations — with a focus on transparent, honest guidance rather than approval guarantees.\"},{\"q\":\"Do you offer student visa consultancy in Bangalore for the USA, UK, Canada and Australia?\",\"a\":\"Yes. Our student visa consultancy covers SOP review, financial documentation, and visa interview preparation across these destinations.\"},{\"q\":\"Can Bangalore applicants apply for a Canada PR visa through your consultants?\",\"a\":\"We guide Bangalore-based applicants through PR-track documentation and Super Visa / visitor visa applications; the final PR decision rests with IRCC.\"},{\"q\":\"How do US tourist visa agents in Bangalore help with the application?\",\"a\":\"We help with DS-160 form filing, appointment booking, document checklists and mock interview sessions to help you prepare confidently.\"},{\"q\":\"What should I look for in top immigration consultants in Bangalore?\",\"a\":\"Look for clear documentation checklists, no guaranteed-approval claims (no consultant can guarantee a visa outcome), transparent fees, and consultants who explain each step of the process.\"}]','active','2026-08-16 02:05:36','2026-08-16 02:05:36'),(2,'hyderabad','Hyderabad',20,'Best Visa Consultants in Hyderabad | Student, Work & Schengen Visa Processing Agency – Vocation Travels And Tours','Best visa consultants in Hyderabad for US & UK student visas, Schengen tourist visas and work visa applications. A Hyderabad visa processing agency you can rely on.','best visa consultants in hyderabad, top 10 immigration consultants in hyderabad, us student visa consultants in hyderabad, uk student visa consultancy hyderabad, schengen tourist visa agents hyderabad, work visa consultants in hyderabad, hyderabad visa processing agency','Best Visa Consultants in Hyderabad','A Hyderabad visa processing agency for student, work and Schengen tourist visa applicants.','Hyderabad\'s Visa Processing & Student Visa Specialists','Searching for the best visa consultants in Hyderabad? We work with students heading to the US and UK, professionals applying for work visas, and travelers planning Schengen trips — handling documentation, application filing and interview preparation as a dedicated Hyderabad visa processing agency.','[{\"title\":\"US Student Visa Consultants\",\"keyword_note\":\"us student visa consultants in hyderabad\",\"desc\":\"F-1 visa documentation guidance, DS-160 support and interview preparation for Hyderabad students admitted to US universities.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"UK Student Visa Consultancy\",\"keyword_note\":\"uk student visa consultancy hyderabad\",\"desc\":\"Support with UK student visitor documentation, financial evidence planning and application filing for Hyderabad-based students.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Schengen Tourist Visa Agents\",\"keyword_note\":\"schengen tourist visa agents hyderabad\",\"desc\":\"Documentation and appointment guidance for Schengen tourist visas covering popular European travel itineraries.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Work Visa Consultants\",\"keyword_note\":\"work visa consultants in hyderabad\",\"desc\":\"Documentation support for work-related travel and employer-sponsored visa categories across our supported destinations.\",\"icon\":\"fa-briefcase\"},{\"title\":\"Hyderabad Visa Processing Agency\",\"keyword_note\":\"hyderabad visa processing agency\",\"desc\":\"Application form filing, visa fee payment guidance and visa application centre appointment booking handled end-to-end.\",\"icon\":\"fa-passport\"},{\"title\":\"Immigration Documentation Support\",\"keyword_note\":\"top 10 immigration consultants in hyderabad\",\"desc\":\"A checklist-driven, detail-focused documentation process — the kind of thorough support applicants look for when comparing immigration consultants in Hyderabad.\",\"icon\":\"fa-magnifying-glass\"}]','[{\"q\":\"Who are the best visa consultants in Hyderabad for students and working professionals?\",\"a\":\"We assist Hyderabad-based students and professionals with documentation, application filing and interview preparation for US, UK, Schengen and work visa categories.\"},{\"q\":\"Do you provide US student visa consultancy in Hyderabad?\",\"a\":\"Yes, we support F-1 visa documentation, DS-160 filing and interview preparation for students heading to US universities.\"},{\"q\":\"Is there a UK student visa consultancy in Hyderabad that helps with financial documentation?\",\"a\":\"Yes, we guide Hyderabad students through UK student visitor visa financial evidence requirements and application filing.\"},{\"q\":\"How do Schengen tourist visa agents in Hyderabad handle the application?\",\"a\":\"We help you choose the correct Schengen entry-point country, prepare the document set and book your visa application centre appointment.\"},{\"q\":\"What does a Hyderabad visa processing agency actually handle for me?\",\"a\":\"From document checklists and form filing to appointment booking and status tracking — we manage the process end-to-end so you know what\'s happening at each stage.\"}]','active','2026-08-16 02:05:36','2026-08-16 02:05:36'),(6,'chennai','Chennai',30,'Best Visa Consultants in Chennai | US Visa, UK & Schengen Visa Experts – Vocation Travels And Tours','Looking for the best visa consultants in Chennai? Get expert help with US visa applications (Chennai Consulate), UK student visas, Schengen tourist visas and Gulf work visa documentation from a trusted Chennai visa agency.','best visa consultants in chennai, us visa consultants chennai, us consulate chennai visa agents, uk student visa chennai, schengen visa agents chennai, gulf work visa consultants chennai, chennai visa processing agency','Best Visa Consultants in Chennai','Direct US Consulate access makes Chennai a key visa hub — our consultants help applicants prepare confidently for every appointment.','Chennai\'s Trusted Visa & Immigration Consultants','Chennai is home to one of India\'s few US Consulates, which makes it a natural hub for US visa applicants — including many traveling in from across South India for their interview. Our Chennai team supports US B1/B2 and student visa applicants, alongside UK student visa, Schengen tourist visa and Gulf work visa documentation, with the same document-first, no-guarantee approach we bring to every city we serve.','[{\"title\":\"US Visa Interview Preparation\",\"desc\":\"Focused DS-160 filing support and mock interview sessions for applicants attending their US visa interview at the Chennai Consulate.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"UK Student Visa Consultancy\",\"desc\":\"Financial documentation, CAS letter review and application filing support for Chennai students heading to UK universities.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Schengen Tourist Visa Agents\",\"desc\":\"Entry-point country selection, document checklists and appointment booking for Schengen tourist trips.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Gulf Work Visa Documentation\",\"desc\":\"Documentation support for UAE, Saudi and Qatar work-visa categories for Chennai\'s manufacturing and trade professionals.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Business & Trade Visa Support\",\"desc\":\"Visa documentation for Chennai\'s automotive and manufacturing exporters traveling for trade meetings and factory visits.\",\"icon\":\"fa-handshake\",\"country_link\":\"\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven document review across visa categories, refined by handling high-volume US Consulate applications.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Why do so many South Indian applicants apply for US visas through Chennai?\",\"a\":\"Because Chennai hosts a US Consulate directly, it\'s a common interview location for B1/B2 and student visa applicants from across South India, not only Chennai residents.\"},{\"q\":\"Do you help with DS-160 filing for the Chennai Consulate?\",\"a\":\"Yes, we assist with DS-160 form filing, appointment scheduling and interview preparation specifically for the Chennai Consulate process.\"},{\"q\":\"Can Chennai\'s manufacturing and trade businesses get help with visas?\",\"a\":\"Yes, we support business and trade visa documentation for Chennai-based exporters and manufacturers traveling internationally.\"},{\"q\":\"Do you assist with Gulf work visas from Chennai?\",\"a\":\"Yes, we help with documentation for UAE, Saudi Arabia and Qatar work-visa applications.\"},{\"q\":\"Is a Chennai-based consultant better for US visa applicants?\",\"a\":\"Familiarity with the Chennai Consulate\'s process and appointment patterns can help, though the underlying visa requirements are set by the US State Department regardless of consultant location.\"}]','active','2026-08-18 00:12:16','2026-08-18 00:12:16'),(7,'pune','Pune',40,'Best Visa Consultants in Pune | Student Visa & Schengen Visa Agents – Vocation Travels And Tours','Best visa consultants in Pune for US, UK, Canada and Australia student visas, Schengen tourist visas and IT-sector work visa documentation. Trusted Pune visa consultancy.','best visa consultants in pune, student visa consultants pune, pune visa consultancy, schengen visa agents pune, it work visa consultants pune, canada study visa pune, study abroad consultants pune','Best Visa Consultants in Pune','Supporting Pune\'s students and IT professionals with student visas, work-visa documentation and Schengen tourist visa applications.','Pune\'s Student Visa & Study Abroad Specialists','Pune\'s dense concentration of engineering colleges and IT companies shapes a very specific visa mix — heavy demand for US, UK, Canada and Australia student visas, alongside IT-sector work travel and Schengen family holidays. Our Pune-focused guidance covers SOP review, financial documentation and interview preparation, tailored to the applications we see most often from this city.','[{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"University shortlisting inputs, SOP review and visa interview preparation for Pune students applying to the USA, UK, Canada and Australia.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Canada Study Permit Guidance\",\"desc\":\"Documentation support for Canada study permits and post-study work permit pathways for Pune\'s engineering and IT graduates.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"IT Sector Work Visa Support\",\"desc\":\"Work-visa documentation for Pune\'s IT and tech professionals traveling for client projects and short-term assignments.\",\"icon\":\"fa-laptop-code\",\"country_link\":\"\"},{\"title\":\"Schengen Family Holiday Visas\",\"desc\":\"Itinerary planning and document checklists for Pune families applying for Schengen tourist visas.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Australia Student & Visitor Visas\",\"desc\":\"Visitor and student-dependent visa documentation for Pune applicants traveling to Australia.\",\"icon\":\"fa-earth-oceania\",\"country_link\":\"australia\"},{\"title\":\"Financial Documentation Review\",\"desc\":\"Careful review of bank statements and sponsorship documents — the most common reason Pune student visa applications get delayed.\",\"icon\":\"fa-file-invoice-dollar\",\"country_link\":\"\"}]','[{\"q\":\"Which student visa is most in-demand among Pune applicants?\",\"a\":\"US, UK, Canada and Australia student visas are the most requested, reflecting Pune\'s large student population heading abroad for higher education.\"},{\"q\":\"Do you help with Canada post-study work permits?\",\"a\":\"We guide Pune graduates through post-study work permit documentation alongside the initial study permit application.\"},{\"q\":\"Can Pune\'s IT professionals get help with short-term work visas?\",\"a\":\"Yes, we assist with documentation for work-related travel tied to client projects and short-term assignments.\"},{\"q\":\"What\'s the biggest reason Pune student visa applications get delayed?\",\"a\":\"Incomplete or inconsistent financial documentation is the most common issue we help applicants avoid.\"},{\"q\":\"Do you handle Schengen visas for families, not just individual travelers?\",\"a\":\"Yes, we support full-family Schengen tourist visa applications including itinerary and financial documentation for each traveler.\"}]','active','2026-08-18 00:12:16','2026-08-18 00:12:16'),(8,'mumbai','Mumbai',50,'Best Visa Consultants in Mumbai | Business, US & Gulf Visa Experts – Vocation Travels And Tours','Best visa consultants in Mumbai for US tourist and business visas, UK visitor visas, Gulf trade visas and Schengen applications. Trusted visa consultancy for India\'s financial capital.','best visa consultants in mumbai, us visa agents mumbai, business visa consultants mumbai, gulf visa agents mumbai, schengen visa mumbai, mumbai visa processing agency, uk visitor visa mumbai','Best Visa Consultants in Mumbai','Serving India\'s financial capital with business, tourist and work visa documentation across every major destination.','Mumbai\'s Business & International Travel Visa Specialists','As India\'s financial and commercial capital, Mumbai generates a uniquely business-heavy visa mix — frequent US and Schengen business travel, Gulf trade visas tied to import-export activity, and UK/US visitor visas for family and leisure trips. Mumbai is also home to a US Consulate General, making it a key interview location for B1/B2 and student visa applicants across Western India. Our Mumbai guidance is built around this business-and-consulate-access reality.','[{\"title\":\"US Business & Tourist Visa Consultants\",\"desc\":\"DS-160 filing, appointment scheduling and interview preparation for B1/B2 applicants attending the Mumbai Consulate.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Gulf Trade & Business Visas\",\"desc\":\"Documentation support for UAE, Saudi Arabia and other Gulf business and trade visas for Mumbai\'s import-export professionals.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"UK Visitor Visa Agents\",\"desc\":\"Financial and itinerary documentation for UK visitor visas, covering tourism, family visits and short business trips.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"uk\"},{\"title\":\"Schengen Business & Tourist Visas\",\"desc\":\"Application support for Schengen business conferences, trade fairs and family tourist itineraries.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Canada Visitor & Super Visa Guidance\",\"desc\":\"Documentation for Canada visitor visas and Super Visa applications for Mumbai families with relatives in Canada.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Corporate Travel Visa Support\",\"desc\":\"Batch visa documentation support for Mumbai companies sending employees abroad for meetings, conferences and short assignments.\",\"icon\":\"fa-building\",\"country_link\":\"\"}]','[{\"q\":\"Does Mumbai have its own US Consulate for visa interviews?\",\"a\":\"Yes, Mumbai hosts a US Consulate General, making it a primary interview location for B1/B2 and other visa applicants across Western India.\"},{\"q\":\"Do you support corporate/company visa applications, not just individuals?\",\"a\":\"Yes, we help Mumbai businesses coordinate visa documentation for multiple employees traveling for the same trip or event.\"},{\"q\":\"What Gulf visa support do you offer Mumbai\'s trade businesses?\",\"a\":\"We assist with UAE, Saudi Arabia and other Gulf business and trade visa documentation tied to import-export and trading activity.\"},{\"q\":\"Can you help with a Canada Super Visa for parents visiting Mumbai families in Canada?\",\"a\":\"Yes, we guide Mumbai applicants through Super Visa documentation for parents and grandparents visiting family in Canada.\"},{\"q\":\"How far ahead should Mumbai business travelers apply for a Schengen visa?\",\"a\":\"We recommend applying at least 4–6 weeks ahead of a Schengen business trip to allow for appointment and processing time.\"}]','active','2026-08-18 00:12:16','2026-08-18 00:12:16'),(9,'delhi','Delhi NCR',60,'Best Visa Consultants in Delhi NCR | Embassy Visa Filing & Student Visa Experts – Vocation Travels And Tours','Best visa consultants in Delhi NCR for US, UK, Canada, Australia and Schengen visas. Direct embassy-city advantage for student, work and tourist visa applicants.','best visa consultants in delhi, visa consultants delhi ncr, embassy visa filing delhi, student visa consultants delhi, schengen visa agents delhi, canada visa consultants delhi, work visa consultants gurgaon noida','Best Visa Consultants in Delhi NCR','India\'s diplomatic capital — direct access to nearly every embassy and high commission, backed by our document-first visa guidance.','Delhi NCR\'s Embassy-City Visa Advantage','As the seat of nearly every country\'s embassy or high commission in India, Delhi NCR (Delhi, Gurgaon, Noida) applicants have a structural advantage: shorter logistics for embassy-linked appointments and access to India\'s highest concentration of visa application and biometric centres. Our Delhi NCR team supports the full range of student, work, business and tourist visa categories, with particular volume in US, UK, Canada, Australia and Schengen applications.','[{\"title\":\"Embassy & High Commission Visa Filing\",\"desc\":\"Application filing support leveraging Delhi\'s direct access to embassies and high commissions for most major destinations.\",\"icon\":\"fa-landmark\",\"country_link\":\"\"},{\"title\":\"US & Canada Student Visa Consultants\",\"desc\":\"SOP review, financial documentation and interview preparation for Delhi NCR students applying to US and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"UK & Australia Work Visa Support\",\"desc\":\"Documentation guidance for UK and Australia work-related visa categories for Delhi NCR professionals.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Schengen Visa Agents\",\"desc\":\"Entry-country selection and document checklists for Schengen tourist and business visa applicants.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Corporate & Frequent Business Travel Support\",\"desc\":\"Visa documentation for Delhi NCR corporates coordinating frequent international business travel.\",\"icon\":\"fa-building\",\"country_link\":\"\"},{\"title\":\"Gurgaon & Noida Client Support\",\"desc\":\"Remote and in-person visa documentation support for applicants based in Gurgaon and Noida, without needing a separate consultant.\",\"icon\":\"fa-city\",\"country_link\":\"\"}]','[{\"q\":\"Why is Delhi considered an advantageous city for visa applications?\",\"a\":\"Delhi hosts nearly every country\'s embassy or high commission in India, giving applicants more direct access to embassy-linked processes and the country\'s highest concentration of visa centres.\"},{\"q\":\"Do you support clients based in Gurgaon or Noida, not just Delhi itself?\",\"a\":\"Yes, our Delhi NCR service covers Gurgaon and Noida-based applicants with the same documentation and filing support.\"},{\"q\":\"What visa categories see the highest demand from Delhi NCR?\",\"a\":\"US, UK, Canada, Australia and Schengen visas across student, work, business and tourist categories.\"},{\"q\":\"Can you help Delhi NCR companies with multiple employees traveling together?\",\"a\":\"Yes, we coordinate batch visa documentation for corporate groups traveling for the same business trip.\"},{\"q\":\"Does applying from Delhi guarantee faster visa processing?\",\"a\":\"No consultant can guarantee processing speed — it depends on the destination country\'s consulate; Delhi\'s advantage is logistics and appointment access, not guaranteed approval or speed.\"}]','active','2026-08-18 00:12:16','2026-08-18 00:12:16'),(10,'kolkata','Kolkata',70,'Best Visa Consultants in Kolkata | US Consulate, UK & Schengen Visa Agents – Vocation Travels And Tours','Best visa consultants in Kolkata for US visa applications, UK student visas, Schengen tourist visas and Northeast India gateway travel documentation.','best visa consultants in kolkata, us visa agents kolkata, us consulate kolkata visa, uk student visa kolkata, schengen visa consultants kolkata, kolkata visa processing agency, northeast india visa services','Best Visa Consultants in Kolkata','A US Consulate city serving Kolkata and the wider Eastern and Northeast India region with complete visa documentation support.','Kolkata\'s Visa Consultants for Eastern & Northeast India','Kolkata\'s US Consulate General makes it an important interview hub not just for the city but for applicants across Eastern India and the Northeast, who would otherwise need to travel much further for a B1/B2 or student visa interview. Alongside US visa support, our Kolkata team handles UK and Schengen tourist visa applications and student visa documentation for the region\'s growing outbound student population.','[{\"title\":\"US Visa Consultants\",\"desc\":\"DS-160 filing and interview preparation for B1/B2 and student visa applicants attending the Kolkata Consulate.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"UK Student Visa Consultancy\",\"desc\":\"Financial documentation and application filing for Kolkata and Eastern India students heading to UK universities.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Schengen Tourist Visa Agents\",\"desc\":\"Document checklists and appointment booking for Schengen tourist visa applicants.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Northeast India Regional Support\",\"desc\":\"Visa documentation support for applicants traveling into Kolkata from Assam, Meghalaya, Sikkim and other Northeast states.\",\"icon\":\"fa-map-location-dot\",\"country_link\":\"\"},{\"title\":\"Canada Visitor & Student Visa Guidance\",\"desc\":\"Documentation support for Canada visitor visas and study permits for Kolkata-based applicants and their families.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support across visa categories for Kolkata and the wider Eastern India region.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Does Kolkata have its own US Consulate?\",\"a\":\"Yes, Kolkata hosts a US Consulate General, serving as an interview hub for Eastern India and parts of the Northeast.\"},{\"q\":\"Do you support applicants traveling from Northeast India states to Kolkata for their visa process?\",\"a\":\"Yes, we regularly support applicants from Assam, Meghalaya, Sikkim and other Northeast states who use Kolkata as their nearest visa processing hub.\"},{\"q\":\"What\'s the most requested visa type in Kolkata?\",\"a\":\"US visitor and student visas are the most requested, followed by UK student visas and Schengen tourist visas.\"},{\"q\":\"Can you help with a Canada study permit application from Kolkata?\",\"a\":\"Yes, we guide Kolkata-based students through Canada study permit documentation and application filing.\"},{\"q\":\"How does Kolkata\'s Consulate access help Northeast India applicants?\",\"a\":\"It significantly reduces travel distance for a US visa interview compared to traveling to Delhi or Mumbai.\"}]','active','2026-08-18 00:12:16','2026-08-18 00:12:16'),(11,'ahmedabad','Ahmedabad',80,'Best Visa Consultants in Ahmedabad | US, Canada & UK Visa Experts – Vocation Travels And Tours','Best visa consultants in Ahmedabad for US tourist and student visas, Canada PR-track documentation and UK visitor visas — trusted by Gujarat\'s large outbound applicant community.','best visa consultants in ahmedabad, us visa agents ahmedabad, canada visa consultants ahmedabad, gujarat visa consultants, ahmedabad visa processing agency, uk visitor visa ahmedabad, ahmedabad student visa consultants','Best Visa Consultants in Ahmedabad','Trusted by Gujarat\'s large outbound travel and immigration community for US, Canada and UK visa documentation.','Ahmedabad\'s Visa Consultants for Gujarat\'s Global Diaspora','Gujarat, and Ahmedabad in particular, has one of India\'s most established outbound migration and travel cultures — especially toward the US, UK and Canada. That history means Ahmedabad applicants often come with specific expectations shaped by family and community networks; our role is to ground that with accurate, document-first guidance for tourist, student, business and PR-track visa applications, without shortcuts or approval guarantees.','[{\"title\":\"US Tourist & Business Visa Agents\",\"desc\":\"DS-160 filing, documentation and interview preparation for Ahmedabad\'s high-volume US visitor and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Canada PR-Track & Visitor Visa Guidance\",\"desc\":\"Documentation support for Express Entry-track applicants and visitor/Super Visa applications for Ahmedabad families with Canadian relatives.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"UK Visitor & Student Visa Consultants\",\"desc\":\"Application support for UK visitor visas and student visa documentation for Ahmedabad-based applicants.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Business & Trade Visa Support\",\"desc\":\"Visa documentation for Ahmedabad\'s textile, pharmaceutical and diamond-trade professionals traveling internationally.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Family Sponsorship Documentation\",\"desc\":\"Guidance on documentation for family-sponsored visitor visa categories, common among Ahmedabad\'s diaspora-linked applicants.\",\"icon\":\"fa-people-roof\",\"country_link\":\"\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Detail-focused, checklist-driven documentation support that helps Ahmedabad applicants avoid the delays we see most often.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Why does Ahmedabad have such high demand for US and Canada visas?\",\"a\":\"Gujarat has one of India\'s most established outbound migration histories toward the US, UK and Canada, which shapes strong ongoing demand for these visa categories in Ahmedabad specifically.\"},{\"q\":\"Can you help with Canada PR-track documentation from Ahmedabad?\",\"a\":\"We guide Ahmedabad applicants through Express Entry-track documentation and Super Visa/visitor visa applications; the final PR decision rests with IRCC.\"},{\"q\":\"Do you support Ahmedabad\'s textile and diamond-trade businesses with visas?\",\"a\":\"Yes, we assist with business and trade visa documentation for professionals traveling for trade fairs, buyer meetings and factory visits.\"},{\"q\":\"What should Ahmedabad applicants know about visa approval guarantees?\",\"a\":\"No consultant, in Ahmedabad or elsewhere, can guarantee visa approval — we focus on building the strongest possible, error-free application.\"},{\"q\":\"Do you help with family-sponsored visitor visas?\",\"a\":\"Yes, we support documentation for family-sponsored visitor visa categories, which are common given Ahmedabad\'s large diaspora connections.\"}]','active','2026-08-18 00:12:16','2026-08-18 00:12:16'),(12,'kochi','Kochi',90,'Best Visa Consultants in Kochi | Gulf Work Visa & UK Visa Experts – Vocation Travels And Tours','Best visa consultants in Kochi (Cochin) for Gulf work visas, UK and US student visas, and nursing/healthcare professional visa documentation for Kerala\'s global workforce.','best visa consultants in kochi, gulf work visa agents kochi, cochin visa consultants, nursing visa consultants kerala, uk student visa kochi, kerala nri visa services, kochi visa processing agency','Best Visa Consultants in Kochi','Supporting Kerala\'s globally-connected workforce with Gulf work visas, healthcare professional visas and student visa documentation.','Kochi\'s Visa Consultants for Kerala\'s Global Workforce','Kerala has one of India\'s largest populations working abroad, particularly across the Gulf — a pattern that shapes Kochi\'s visa consultancy needs more than almost any other Indian city. Alongside Gulf work visas, we support Kochi\'s large outbound population of nurses and healthcare professionals, along with UK and US student visa applicants and Schengen tourist visa travelers.','[{\"title\":\"Gulf Work Visa Consultants\",\"desc\":\"Documentation and processing support for UAE, Saudi Arabia, Qatar and Oman work visas for Kochi and Kerala\'s outbound workforce.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Nursing & Healthcare Professional Visas\",\"desc\":\"Specialized documentation support for Kerala\'s nurses and healthcare professionals applying for international employment visas.\",\"icon\":\"fa-user-nurse\",\"country_link\":\"\"},{\"title\":\"UK Student Visa Consultancy\",\"desc\":\"Financial documentation and application filing for Kochi students heading to UK universities.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"US Student & Tourist Visa Support\",\"desc\":\"DS-160 filing and interview preparation for Kochi-based US student and tourist visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"NRI Family Visit & Sponsorship Visas\",\"desc\":\"Documentation guidance for Kochi families sponsoring visits from relatives working abroad, and vice versa.\",\"icon\":\"fa-people-roof\",\"country_link\":\"\"},{\"title\":\"Schengen Tourist Visa Agents\",\"desc\":\"Document checklists and appointment booking support for Schengen tourist visa applicants from Kochi.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"}]','[{\"q\":\"Why is Gulf work visa demand so high in Kochi?\",\"a\":\"Kerala has one of India\'s largest populations working in Gulf countries, and Kochi is the primary hub for this outbound workforce, driving consistently high demand for UAE, Saudi, Qatar and Oman work visas.\"},{\"q\":\"Do you specialize in visas for nurses and healthcare professionals?\",\"a\":\"Yes, we provide documentation support specifically tailored to Kerala\'s large outbound population of nurses and healthcare workers applying for international roles.\"},{\"q\":\"Can you help with UK student visas for Kochi-based students?\",\"a\":\"Yes, we support financial documentation and application filing for Kochi students admitted to UK universities.\"},{\"q\":\"Do you help NRI families with sponsorship documentation?\",\"a\":\"Yes, we guide Kochi families through sponsorship-related documentation for visits to and from relatives working abroad.\"},{\"q\":\"What is the typical timeline for a Gulf work visa from Kochi?\",\"a\":\"Timelines vary by country and employer, but we help applicants avoid the most common documentation delays that extend processing.\"}]','active','2026-08-18 00:12:16','2026-08-18 00:12:16'),(13,'coimbatore','Coimbatore',100,'Best Visa Consultants in Coimbatore | Business & Student Visa Experts – Vocation Travels And Tours','Best visa consultants in Coimbatore for business and trade visas, US/UK/Canada student visas and Gulf work visa documentation for Tamil Nadu\'s manufacturing hub.','best visa consultants in coimbatore, business visa consultants coimbatore, student visa consultants coimbatore, coimbatore visa processing agency, textile industry visa agents, gulf visa consultants coimbatore','Best Visa Consultants in Coimbatore','Serving Tamil Nadu\'s manufacturing and textile hub with business travel, student visa and Gulf work visa documentation.','Coimbatore\'s Visa Consultants for Business & Student Travel','Coimbatore\'s strong textile, engineering and manufacturing base drives a steady flow of business and trade visa applications, alongside a growing student visa segment from the city\'s engineering colleges. Our Coimbatore guidance covers both ends of this — corporate travel documentation for business owners and executives, and student visa support for applicants heading to the US, UK, Canada and Australia.','[{\"title\":\"Business & Trade Visa Consultants\",\"desc\":\"Documentation support for Coimbatore\'s textile, engineering and manufacturing exporters traveling for trade fairs and buyer meetings.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review, financial documentation and interview preparation for Coimbatore students applying to US, UK, Canada and Australia universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Gulf Work Visa Documentation\",\"desc\":\"Work-visa documentation support for Coimbatore professionals taking up roles in UAE, Saudi Arabia and other Gulf countries.\",\"icon\":\"fa-earth-africa\",\"country_link\":\"\"},{\"title\":\"Canada Study & Work Permit Guidance\",\"desc\":\"Study permit and post-study work permit documentation for Coimbatore\'s engineering graduates.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"US Tourist Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Coimbatore-based US tourist and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Coimbatore applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Coimbatore\'s textile and manufacturing businesses with visas?\",\"a\":\"Yes, we handle business and trade visa documentation for Coimbatore exporters and manufacturers traveling for trade fairs and buyer meetings.\"},{\"q\":\"What student visa destinations are most popular among Coimbatore students?\",\"a\":\"The US, UK, Canada and Australia are the most requested destinations, reflecting demand from Coimbatore\'s engineering college graduates.\"},{\"q\":\"Do you help with Gulf work visas for Coimbatore professionals?\",\"a\":\"Yes, we support documentation for UAE, Saudi Arabia and other Gulf work-visa categories.\"},{\"q\":\"Can Coimbatore students get help with Canada post-study work permits?\",\"a\":\"Yes, we guide applicants through both the initial study permit and the post-study work permit documentation.\"},{\"q\":\"Is Coimbatore visa processing different from Chennai\'s?\",\"a\":\"The visa requirements themselves are set by the destination country, not the city — our Coimbatore service simply brings that same standard directly to local applicants without requiring travel to Chennai.\"}]','active','2026-08-18 00:12:16','2026-08-18 00:12:16'),(14,'jaipur','Jaipur',110,'Best Visa Consultants in Jaipur | Tourist, Student & Business Visa Agents – Vocation Travels And Tours','Best visa consultants in Jaipur for UK and Schengen tourist visas, US/Canada/Australia student visas and business visa documentation for Rajasthan\'s growing outbound travelers.','best visa consultants in jaipur, schengen visa agents jaipur, student visa consultants jaipur, jaipur visa processing agency, rajasthan visa consultants, uk tourist visa jaipur','Best Visa Consultants in Jaipur','Helping Jaipur and Rajasthan\'s growing base of students, families and business travelers with complete visa documentation.','Jaipur\'s Visa Consultants for Rajasthan\'s Growing Outbound Travel Market','As Rajasthan\'s outbound travel and student visa market has grown, Jaipur applicants increasingly need the same standard of documentation support long available in larger metros. We help Jaipur-based students, families and business travelers with UK and Schengen tourist visas, US/Canada/Australia student visas, and business visa documentation, without requiring a trip to Delhi for consultancy support.','[{\"title\":\"UK & Schengen Tourist Visa Agents\",\"desc\":\"Itinerary planning, document checklists and appointment booking for Jaipur families applying for UK and Schengen tourist visas.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"uk\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation support for Jaipur students applying to US, Canada and Australia universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Business Visa Documentation\",\"desc\":\"Visa documentation for Jaipur\'s handicraft, gemstone and textile export businesses traveling internationally.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Australia Student & Visitor Visas\",\"desc\":\"Visitor and student-dependent visa documentation support for Jaipur applicants traveling to Australia.\",\"icon\":\"fa-earth-oceania\",\"country_link\":\"australia\"},{\"title\":\"Canada Visitor & Study Visa Guidance\",\"desc\":\"Documentation support for Canada visitor visas and study permits for Jaipur-based applicants.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support across visa categories, built for Jaipur applicants who previously had to travel to Delhi for this level of support.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do Jaipur applicants need to travel to Delhi for visa consultancy?\",\"a\":\"No — our Jaipur service provides the same documentation and filing support locally, without requiring a trip to Delhi.\"},{\"q\":\"What tourist visa destinations are most requested from Jaipur?\",\"a\":\"UK and Schengen tourist visas are the most requested, often tied to family visits and European travel itineraries.\"},{\"q\":\"Do you support Jaipur\'s handicraft and gemstone export businesses?\",\"a\":\"Yes, we assist with business visa documentation for Jaipur exporters traveling for trade shows and buyer meetings.\"},{\"q\":\"Can you help Jaipur students with Australia student visas?\",\"a\":\"Yes, we support visitor and student-dependent visa documentation for Jaipur applicants heading to Australia.\"},{\"q\":\"What\'s the most common reason Jaipur visa applications get delayed?\",\"a\":\"Incomplete financial or sponsorship documentation is the most frequent issue we help Jaipur applicants resolve before submission.\"}]','active','2026-08-18 00:12:16','2026-08-18 00:12:16'),(15,'chandigarh','Chandigarh',120,'Best Visa Consultants in Chandigarh | Canada Study Visa & PR-Track Experts – Vocation Travels And Tours','Best visa consultants in Chandigarh for Canada study permits, PR-track documentation, UK and Australia student visas — trusted by Punjab and Haryana\'s large outbound student community.','best visa consultants in chandigarh, canada study visa consultants chandigarh, canada pr consultants chandigarh, punjab visa consultants, chandigarh visa processing agency, uk student visa chandigarh, australia study visa chandigarh','Best Visa Consultants in Chandigarh','Chandigarh\'s Canada-focused visa consultants — trusted by Punjab and Haryana\'s large outbound student and immigration community.','Chandigarh\'s Canada Study & Immigration Visa Specialists','Few regions in India have as strong a Canada study-and-immigration pipeline as Punjab and Haryana, and Chandigarh sits at the center of it. Our Chandigarh team specializes in Canada study permit and PR-track documentation, while also supporting the UK and Australia student visa applications that make up the rest of this region\'s outbound student demand — all with the same transparent, no-guarantee approach we apply everywhere.','[{\"title\":\"Canada Study Permit Consultants\",\"desc\":\"End-to-end documentation support for Canada study permit applications, the single most requested service among Chandigarh applicants.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Canada PR-Track & Express Entry Documentation\",\"desc\":\"Guidance on Express Entry-track documentation and post-study work permit pathways for Chandigarh\'s Canada-bound graduates.\",\"icon\":\"fa-passport\",\"country_link\":\"\"},{\"title\":\"UK Student Visa Consultancy\",\"desc\":\"Financial documentation and CAS-linked application support for Chandigarh students heading to UK universities.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Australia Student Visa Support\",\"desc\":\"Student and student-dependent visa documentation for Chandigarh applicants heading to Australian institutions.\",\"icon\":\"fa-earth-oceania\",\"country_link\":\"australia\"},{\"title\":\"IELTS-Linked Application Guidance\",\"desc\":\"Guidance on aligning IELTS score timelines with study permit and student visa application deadlines.\",\"icon\":\"fa-clipboard-check\",\"country_link\":\"\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Detail-focused review built specifically around the high-volume Canada study and immigration pipeline we see from this region.\",\"icon\":\"fa-magnifying-glass\",\"country_link\":\"\"}]','[{\"q\":\"Why is Canada such a common destination for Chandigarh applicants?\",\"a\":\"Punjab and Haryana have one of India\'s strongest and longest-running Canada study-and-immigration pipelines, and Chandigarh, as the regional hub, sees this demand more than most Indian cities.\"},{\"q\":\"Can you guarantee a Canada study permit approval?\",\"a\":\"No consultant can guarantee approval — IRCC makes the final decision. We focus on building a complete, error-free application to give applicants the strongest possible chance.\"},{\"q\":\"Do you help with the transition from study permit to PR in Canada?\",\"a\":\"We guide applicants through post-study work permit and Express Entry-track documentation; the final PR decision rests with IRCC.\"},{\"q\":\"Do you support UK and Australia student visas too, or only Canada?\",\"a\":\"We support UK and Australia student visa applications as well, alongside our core Canada study and PR-track documentation work.\"},{\"q\":\"How does IELTS timing affect a Canada study permit application?\",\"a\":\"Study permit applications require a valid IELTS score aligned with your intake deadline — we help applicants plan their test date so results don\'t delay submission.\"}]','active','2026-08-18 00:12:16','2026-08-18 00:12:16'),(16,'surat','Surat',130,'Best Visa Consultants in Surat | Diamond Trade & UK/US Visa Experts – Vocation Travels And Tours','Best visa consultants in Surat for diamond & textile trade business visas, US and UK tourist visas, and Canada study visa documentation for Gujarat\'s export capital.','best visa consultants in surat, diamond trade business visa surat, textile export visa consultants surat, us visa agents surat, surat visa processing agency, canada study visa surat','Best Visa Consultants in Surat','Serving India\'s diamond and textile export capital with business, tourist and student visa documentation.','Surat\'s Trade & Export Visa Specialists','Surat\'s diamond-cutting and textile export businesses generate some of Gujarat\'s highest business travel volume — frequent trips to Belgium, Dubai, Hong Kong and the US for trade shows and buyer meetings. Alongside this, Surat\'s growing student population is increasingly applying for US, UK and Canada study visas. We support both sides of this: fast-turnaround business visa documentation for exporters, and structured student visa guidance for first-time applicants.','[{\"title\":\"Diamond & Textile Trade Visa Support\",\"desc\":\"Business visa documentation for Surat exporters traveling to Belgium, Dubai, Hong Kong and the US for trade shows and buyer meetings.\",\"icon\":\"fa-gem\",\"country_link\":\"\"},{\"title\":\"US Tourist & Business Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Surat-based US visitor and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"UK Visitor Visa Consultants\",\"desc\":\"Documentation support for UK tourism, family visit and short business trip visas.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"uk\"},{\"title\":\"Canada Study Visa Guidance\",\"desc\":\"Study permit documentation for Surat\'s growing student population applying to Canadian institutions.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review built around the fast turnaround Surat business travelers need.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you handle visas for Surat\'s diamond and textile export businesses?\",\"a\":\"Yes, we support business visa documentation for exporters traveling to Belgium, Dubai, Hong Kong and the US for trade shows and buyer meetings.\"},{\"q\":\"Can Surat exporters get fast-turnaround visa processing?\",\"a\":\"We prioritize clear, complete documentation upfront to minimize back-and-forth delays for time-sensitive trade travel, though final processing time is set by the destination country\'s consulate.\"},{\"q\":\"Do you support first-time student visa applicants from Surat?\",\"a\":\"Yes, we guide first-time applicants through the full process — university documentation, financial proof and interview preparation.\"},{\"q\":\"What visa categories are most requested in Surat?\",\"a\":\"Business and trade visas linked to the diamond and textile industries, alongside a growing share of student visa applications.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(17,'lucknow','Lucknow',140,'Best Visa Consultants in Lucknow | Student & Tourist Visa Experts – Vocation Travels And Tours','Best visa consultants in Lucknow for US, UK, Canada and Australia student visas, Schengen tourist visas and government-sector business travel documentation.','best visa consultants in lucknow, student visa consultants lucknow, lucknow visa processing agency, canada study visa lucknow, schengen visa agents lucknow, up visa consultants','Best Visa Consultants in Lucknow','Uttar Pradesh\'s capital hub for student visas, tourist travel and business visa documentation.','Lucknow\'s Student & Tourist Visa Consultants','As Uttar Pradesh\'s administrative capital, Lucknow has a steadily growing outbound student and tourist visa market, driven by the city\'s expanding higher-education and professional base. We support Lucknow applicants with US, UK, Canada and Australia student visas, Schengen family tourist visas, and documentation for government and private-sector business travel — with the same document-first approach across every category.','[{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review, financial documentation and interview preparation for Lucknow students applying to the USA, UK, Canada and Australia.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Schengen Tourist Visa Agents\",\"desc\":\"Itinerary planning and document checklists for Lucknow families applying for Schengen tourist visas.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Canada Study Visa Guidance\",\"desc\":\"Study permit documentation and post-study work permit pathway guidance for Lucknow students.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Business & Government-Sector Travel Support\",\"desc\":\"Visa documentation for Lucknow-based business and government-sector professionals traveling internationally.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven document review across visa categories for Lucknow and the wider Awadh region.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"What visa categories are most common among Lucknow applicants?\",\"a\":\"Student visas to the US, UK, Canada and Australia are the fastest-growing category, alongside Schengen family tourist visas.\"},{\"q\":\"Do you support applicants from smaller towns near Lucknow?\",\"a\":\"Yes, we regularly support applicants from across the wider Awadh region who use Lucknow as their nearest visa consultancy hub.\"},{\"q\":\"Can you help with Canada study visa applications from Lucknow?\",\"a\":\"Yes, we guide Lucknow students through study permit documentation and post-study work permit pathways.\"},{\"q\":\"Do you assist government or private-sector employees with business travel visas?\",\"a\":\"Yes, we support documentation for both government-sector and private business travel from Lucknow.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(18,'nagpur','Nagpur',150,'Best Visa Consultants in Nagpur | Business & Logistics Visa Experts – Vocation Travels And Tours','Best visa consultants in Nagpur for business and trade visas, US/UK tourist visas and student visa documentation for Central India\'s logistics hub.','best visa consultants in nagpur, business visa consultants nagpur, nagpur visa processing agency, student visa consultants nagpur, us visa agents nagpur','Best Visa Consultants in Nagpur','Serving Central India\'s logistics and trade hub with business, tourist and student visa documentation.','Nagpur\'s Business & Logistics Visa Consultants','Nagpur\'s position as India\'s geographic and logistics center — home to a major cargo hub and orange-trade exports — drives a distinct business visa demand alongside a growing student and tourist visa market. Our Nagpur team supports trade and logistics professionals traveling internationally, alongside students and families applying for study and tourist visas.','[{\"title\":\"Business & Trade Visa Consultants\",\"desc\":\"Documentation support for Nagpur\'s logistics, orange-trade and manufacturing professionals traveling for business.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"US Tourist Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Nagpur-based US tourist and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Nagpur students applying to US, UK, Canada and Australia universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"UK & Schengen Tourist Visa Support\",\"desc\":\"Document checklists and itinerary planning for UK and Schengen family tourist visa applications.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"uk\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support across visa categories for Nagpur and the wider Vidarbha region.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Nagpur\'s logistics and trade businesses with visas?\",\"a\":\"Yes, we handle business visa documentation for professionals in logistics, trade and manufacturing traveling internationally.\"},{\"q\":\"What makes Nagpur different from other Maharashtra cities for visa services?\",\"a\":\"Nagpur\'s role as a logistics and trade hub means a higher share of business visa demand compared to the student-heavy profile of cities like Pune.\"},{\"q\":\"Do you support applicants from the wider Vidarbha region?\",\"a\":\"Yes, we regularly assist applicants from across the Vidarbha region who use Nagpur as their nearest visa consultancy hub.\"},{\"q\":\"Can Nagpur students get help with study visa applications?\",\"a\":\"Yes, we support student visa documentation for Nagpur applicants heading to the US, UK, Canada and Australia.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(19,'indore','Indore',160,'Best Visa Consultants in Indore | Student & Business Visa Experts – Vocation Travels And Tours','Best visa consultants in Indore for US, UK, Canada and Australia student visas, and business visa documentation for Madhya Pradesh\'s fastest-growing city.','best visa consultants in indore, student visa consultants indore, indore visa processing agency, canada study visa indore, business visa consultants indore','Best Visa Consultants in Indore','Madhya Pradesh\'s fastest-growing city, matched with fast, document-first student and business visa guidance.','Indore\'s Student Visa & Business Travel Specialists','Indore\'s rapid growth as Madhya Pradesh\'s commercial and educational center has brought a sharp rise in outbound student visa applications, alongside steady business travel tied to its expanding trade and manufacturing base. Our Indore team focuses heavily on US, UK, Canada and Australia student visa documentation, while also supporting business visa applicants from the city\'s growing corporate sector.','[{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review, financial documentation and interview preparation for Indore students applying to the USA, UK, Canada and Australia.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Canada Study Permit Guidance\",\"desc\":\"Study permit and post-study work permit documentation for Indore\'s growing outbound student population.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Business Visa Documentation\",\"desc\":\"Visa documentation for Indore\'s trade, pharmaceutical and manufacturing businesses traveling internationally.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Australia Student & Visitor Visas\",\"desc\":\"Visitor and student-dependent visa documentation for Indore applicants heading to Australia.\",\"icon\":\"fa-earth-oceania\",\"country_link\":\"australia\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Detail-focused documentation review, built for Indore\'s fast-growing volume of first-time applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Why has student visa demand grown so quickly in Indore?\",\"a\":\"Indore\'s rapid growth as Madhya Pradesh\'s commercial and educational hub has significantly expanded its outbound student population applying to US, UK, Canada and Australia universities.\"},{\"q\":\"Do you support first-time student visa applicants from Indore?\",\"a\":\"Yes, we guide first-time applicants through the complete process, from SOP review to interview preparation.\"},{\"q\":\"Can Indore\'s trade and manufacturing businesses get visa support?\",\"a\":\"Yes, we assist with business visa documentation for professionals traveling for trade meetings and factory visits.\"},{\"q\":\"What is the most common student visa destination for Indore applicants?\",\"a\":\"Canada and Australia see particularly strong demand, alongside steady interest in US and UK universities.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(20,'bhopal','Bhopal',170,'Best Visa Consultants in Bhopal | Student & Tourist Visa Experts – Vocation Travels And Tours','Best visa consultants in Bhopal for US, UK and Canada student visas, Schengen tourist visas and government-sector business travel documentation.','best visa consultants in bhopal, student visa consultants bhopal, bhopal visa processing agency, schengen visa agents bhopal, canada visa consultants bhopal','Best Visa Consultants in Bhopal','Madhya Pradesh\'s capital hub for student visas, tourist travel and government-sector business documentation.','Bhopal\'s Visa Consultants for Students & Families','As Madhya Pradesh\'s capital, Bhopal combines a steady government and public-sector business travel base with a growing student visa market, particularly among engineering and medical graduates applying abroad. Our Bhopal team supports both — US, UK and Canada student visa documentation, and Schengen tourist visa applications for families planning European trips.','[{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Bhopal students applying to US, UK and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Schengen Tourist Visa Agents\",\"desc\":\"Document checklists and itinerary planning for Bhopal families applying for Schengen tourist visas.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Government & Public-Sector Travel Support\",\"desc\":\"Visa documentation for Bhopal-based government and public-sector professionals traveling internationally.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Canada Study Visa Guidance\",\"desc\":\"Study permit documentation for Bhopal engineering and medical graduates applying to Canadian institutions.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support across visa categories for Bhopal applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"What visa categories are most requested in Bhopal?\",\"a\":\"Student visas to the US, UK and Canada, particularly among engineering and medical graduates, alongside Schengen family tourist visas.\"},{\"q\":\"Do you support government or public-sector employees with visa documentation?\",\"a\":\"Yes, we assist Bhopal-based government and public-sector professionals with business travel visa documentation.\"},{\"q\":\"Can you help Bhopal students with Canada study visa applications?\",\"a\":\"Yes, we guide Bhopal engineering and medical graduates through Canada study permit documentation.\"},{\"q\":\"Do you support families applying for a Schengen visa together?\",\"a\":\"Yes, we handle full-family Schengen tourist visa documentation, including financial proof for each traveler.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(21,'visakhapatnam','Visakhapatnam',180,'Best Visa Consultants in Visakhapatnam | Port & IT Business Visa Experts – Vocation Travels And Tours','Best visa consultants in Visakhapatnam for port and maritime trade business visas, IT-sector work visas, and US/UK student visa documentation.','best visa consultants in visakhapatnam, vizag visa consultants, business visa consultants visakhapatnam, it work visa consultants vizag, student visa consultants visakhapatnam','Best Visa Consultants in Visakhapatnam','Andhra Pradesh\'s port and IT hub — visa documentation for maritime trade, tech and student travel.','Visakhapatnam\'s Port, IT & Student Visa Specialists','Visakhapatnam\'s dual identity as a major port city and a growing IT hub creates a distinct visa mix — maritime and trade business visas alongside IT-sector work travel and a rising student visa market. Our Vizag team supports port and shipping professionals, tech-sector applicants, and students heading abroad for higher education, each with documentation tailored to their specific visa category.','[{\"title\":\"Maritime & Port Trade Business Visas\",\"desc\":\"Documentation support for Visakhapatnam\'s shipping, port and maritime trade professionals traveling internationally.\",\"icon\":\"fa-ship\",\"country_link\":\"\"},{\"title\":\"IT Sector Work Visa Support\",\"desc\":\"Work-visa documentation for Vizag\'s growing IT and tech-sector professionals traveling for client projects.\",\"icon\":\"fa-laptop-code\",\"country_link\":\"\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Visakhapatnam students applying to US, UK and Australian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"US Tourist & Business Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Vizag-based US visitor and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Visakhapatnam applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Visakhapatnam\'s port and maritime trade businesses?\",\"a\":\"Yes, we handle business visa documentation for shipping, port and maritime trade professionals traveling internationally.\"},{\"q\":\"What\'s driving growing visa demand in Visakhapatnam?\",\"a\":\"Vizag\'s expanding IT sector alongside its established port and maritime trade base has diversified visa demand beyond traditional shipping-industry travel.\"},{\"q\":\"Can Visakhapatnam\'s IT professionals get work visa support?\",\"a\":\"Yes, we assist with work-visa documentation for tech-sector professionals traveling for client projects and assignments.\"},{\"q\":\"Do you support student visa applicants from Visakhapatnam?\",\"a\":\"Yes, we guide Vizag students through the full application process for US, UK and Australian universities.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(22,'patna','Patna',190,'Best Visa Consultants in Patna | Gulf Work Visa & Student Visa Experts – Vocation Travels And Tours','Best visa consultants in Patna for Gulf work visas, US/UK/Canada student visas — trusted by Bihar\'s large outbound workforce and student community.','best visa consultants in patna, gulf work visa agents patna, student visa consultants patna, bihar visa consultants, patna visa processing agency, canada study visa patna','Best Visa Consultants in Patna','Supporting Bihar\'s large outbound workforce and growing student community with Gulf work visas and study visa documentation.','Patna\'s Visa Consultants for Bihar\'s Outbound Workforce & Students','Bihar sends one of India\'s largest outbound labor workforces to the Gulf, alongside a rapidly growing student visa segment heading to the US, UK, Canada and Australia. Patna, as the state capital, is the natural hub for both. Our Patna team specializes in Gulf work visa documentation for skilled and semi-skilled workers, alongside full student visa support for Bihar\'s expanding pool of international university applicants.','[{\"title\":\"Gulf Work Visa Consultants\",\"desc\":\"Documentation and processing support for UAE, Saudi Arabia, Qatar and Kuwait work visas for Bihar\'s outbound workforce.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Patna students applying to US, UK, Canada and Australian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Canada Study Visa Guidance\",\"desc\":\"Study permit documentation for Patna\'s growing outbound student population.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Labor & Employment Visa Documentation\",\"desc\":\"Detailed documentation support for skilled and semi-skilled workers applying for Gulf employment visas.\",\"icon\":\"fa-people-carry-box\",\"country_link\":\"\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Patna and the wider Bihar region.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Why is Gulf work visa demand so high in Patna?\",\"a\":\"Bihar sends one of India\'s largest outbound labor workforces to the Gulf, and Patna, as the state capital, is the primary hub for this documentation and processing.\"},{\"q\":\"Do you support skilled and semi-skilled workers, not just students?\",\"a\":\"Yes, we provide dedicated documentation support for skilled and semi-skilled Gulf employment visa applicants alongside our student visa services.\"},{\"q\":\"Is student visa demand growing in Patna?\",\"a\":\"Yes, Bihar\'s student visa applications to the US, UK, Canada and Australia have grown significantly, and we support this full pipeline from SOP review to interview prep.\"},{\"q\":\"Can you help with a Canada study permit from Patna?\",\"a\":\"Yes, we guide Patna-based students through Canada study permit documentation and application filing.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(23,'vadodara','Vadodara',200,'Best Visa Consultants in Vadodara | Engineering & Petrochemical Business Visa Experts – Vocation Travels And Tours','Best visa consultants in Vadodara for petrochemical and engineering business visas, US/UK tourist visas and student visa documentation.','best visa consultants in vadodara, business visa consultants vadodara, vadodara visa processing agency, baroda visa consultants, student visa consultants vadodara','Best Visa Consultants in Vadodara','Serving Gujarat\'s engineering and petrochemical hub with business, tourist and student visa documentation.','Vadodara\'s Engineering & Business Visa Consultants','Vadodara\'s large petrochemical, engineering and public-sector-industrial base — anchored by its GIDC industrial estates — drives steady business visa demand alongside a growing student and tourist visa market. Our Vadodara team supports engineering and petrochemical-sector business travelers, along with students and families applying for study and tourist visas.','[{\"title\":\"Engineering & Petrochemical Business Visas\",\"desc\":\"Documentation support for Vadodara\'s petrochemical and engineering-sector professionals traveling for business.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"US Tourist & Business Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Vadodara-based US visitor and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Vadodara students applying to US, UK and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"UK & Schengen Tourist Visa Support\",\"desc\":\"Document checklists and itinerary planning for UK and Schengen family tourist visa applications.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"uk\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support across visa categories for Vadodara applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Vadodara\'s petrochemical and engineering businesses?\",\"a\":\"Yes, we handle business visa documentation for professionals in the petrochemical and engineering sectors traveling internationally.\"},{\"q\":\"What makes Vadodara different from Ahmedabad for visa services?\",\"a\":\"Vadodara\'s business visa demand skews more heavily toward petrochemical and engineering-sector travel, compared to Ahmedabad\'s broader diaspora-linked and trade visa mix.\"},{\"q\":\"Do you support student visa applicants from Vadodara?\",\"a\":\"Yes, we guide Vadodara students through US, UK and Canada university applications and visa documentation.\"},{\"q\":\"Can you help with Schengen visas for Vadodara families?\",\"a\":\"Yes, we support full-family Schengen tourist visa documentation and itinerary planning.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(24,'ludhiana','Ludhiana',210,'Best Visa Consultants in Ludhiana | Canada Immigration & Manufacturing Business Visa Experts – Vocation Travels And Tours','Best visa consultants in Ludhiana for Canada study and PR-track visas, manufacturing business visas, and UK/Australia student visa documentation.','best visa consultants in ludhiana, canada visa consultants ludhiana, manufacturing business visa ludhiana, punjab visa consultants ludhiana, ludhiana visa processing agency','Best Visa Consultants in Ludhiana','Punjab\'s manufacturing capital, matched with the region\'s equally strong Canada immigration expertise.','Ludhiana\'s Manufacturing Business & Canada Immigration Visa Specialists','Ludhiana is Punjab\'s industrial and manufacturing capital — home to a dense hosiery, bicycle and machine-tool export base — and sits within the same Canada-focused immigration corridor as Chandigarh and Jalandhar. Our Ludhiana team handles both: business visa documentation for manufacturing exporters, and Canada study permit and PR-track documentation for the region\'s large outbound student population.','[{\"title\":\"Manufacturing & Export Business Visas\",\"desc\":\"Documentation support for Ludhiana\'s hosiery, bicycle and machine-tool exporters traveling for trade fairs and buyer meetings.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"Canada Study Permit Consultants\",\"desc\":\"End-to-end documentation support for Canada study permit applications for Ludhiana students.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Canada PR-Track Documentation\",\"desc\":\"Guidance on Express Entry-track documentation and post-study work permit pathways for Ludhiana\'s Canada-bound graduates.\",\"icon\":\"fa-passport\",\"country_link\":\"\"},{\"title\":\"UK & Australia Student Visa Support\",\"desc\":\"Student visa documentation for Ludhiana applicants heading to UK and Australian institutions.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Detail-focused review built around Ludhiana\'s high-volume manufacturing business and Canada immigration pipeline.\",\"icon\":\"fa-magnifying-glass\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Ludhiana\'s manufacturing and export businesses with visas?\",\"a\":\"Yes, we handle business visa documentation for hosiery, bicycle and machine-tool exporters traveling for trade fairs and buyer meetings.\"},{\"q\":\"Is Canada immigration demand as strong in Ludhiana as in Chandigarh?\",\"a\":\"Yes, Ludhiana sits within the same Punjab-Haryana Canada study-and-immigration corridor as Chandigarh, and we see comparably strong demand for study permit and PR-track documentation.\"},{\"q\":\"Can you guarantee a Canada study permit approval for Ludhiana applicants?\",\"a\":\"No consultant can guarantee approval — IRCC makes the final decision. We focus on building a complete, error-free application.\"},{\"q\":\"Do you support UK and Australia student visas, or only Canada?\",\"a\":\"We support UK and Australia student visa applications as well, alongside our core Canada documentation work.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(25,'amritsar','Amritsar',220,'Best Visa Consultants in Amritsar | Canada & UK Visa Experts – Vocation Travels And Tours','Best visa consultants in Amritsar for Canada study and PR-track visas, UK visitor visas, and business visa documentation — direct international flight access from Sri Guru Ram Dass Jee International Airport.','best visa consultants in amritsar, canada visa consultants amritsar, amritsar visa processing agency, punjab visa consultants amritsar, uk visa agents amritsar','Best Visa Consultants in Amritsar','Direct international flight access and deep Canada/UK immigration expertise for Amritsar and the Majha region.','Amritsar\'s Canada & UK Visa Consultants','Amritsar\'s international airport offers some of Punjab\'s most direct flight connectivity to Canada and the UK, reinforcing what is already one of India\'s strongest regional pipelines for Canada study permits and immigration. Our Amritsar team combines this flight-access advantage with deep documentation expertise for Canada, UK and Australia student and visitor visas, serving applicants across the wider Majha region.','[{\"title\":\"Canada Study Permit Consultants\",\"desc\":\"End-to-end documentation support for Canada study permit applications for Amritsar and Majha-region students.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"UK Visitor Visa Agents\",\"desc\":\"Documentation support for UK tourism, family visit and short business trip visas.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"uk\"},{\"title\":\"Australia Student Visa Support\",\"desc\":\"Student and student-dependent visa documentation for Amritsar applicants heading to Australia.\",\"icon\":\"fa-earth-oceania\",\"country_link\":\"australia\"},{\"title\":\"Religious & Family Visit Visa Support\",\"desc\":\"Documentation guidance for family visit visas, common among Amritsar applicants with relatives in Canada, UK and the US.\",\"icon\":\"fa-people-roof\",\"country_link\":\"\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support across visa categories for Amritsar and the wider Majha region.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Does Amritsar\'s international airport make visa processing easier?\",\"a\":\"Direct flight connectivity to Canada and the UK from Sri Guru Ram Dass Jee International Airport is a logistics advantage for travel, though visa processing itself is handled by the destination country\'s consulate regardless of flight access.\"},{\"q\":\"Why is Canada such a common destination for Amritsar applicants?\",\"a\":\"Amritsar sits within Punjab\'s well-established Canada study-and-immigration corridor, alongside Chandigarh, Ludhiana and Jalandhar.\"},{\"q\":\"Do you support applicants from the wider Majha region, not just Amritsar city?\",\"a\":\"Yes, we regularly assist applicants from across the Majha region who use Amritsar as their nearest visa consultancy hub.\"},{\"q\":\"Can you help with family visit visas for relatives abroad?\",\"a\":\"Yes, we guide applicants through documentation for family visit visas to Canada, UK and the US.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(26,'guwahati','Guwahati',230,'Best Visa Consultants in Guwahati | Northeast India Visa Experts – Vocation Travels And Tours','Best visa consultants in Guwahati for student, tourist and business visas — dedicated visa consultancy for Assam and the Northeast India region.','best visa consultants in guwahati, assam visa consultants, northeast india visa services guwahati, student visa consultants guwahati, guwahati visa processing agency','Best Visa Consultants in Guwahati','Assam\'s visa consultancy hub — dedicated documentation support for the Northeast, without needing to travel to Kolkata.','Guwahati\'s Visa Consultants for Assam & the Northeast','While Kolkata has traditionally served as the Northeast\'s nearest US Consulate city, Guwahati itself has grown into a visa consultancy hub in its own right — supporting Assam\'s tea, oil and gas business sectors alongside a rising student visa market. Our Guwahati team provides direct, local documentation support for student, tourist and business visa applicants across Assam and the wider Northeast, reducing how often applicants need to travel out of the region for consultancy support.','[{\"title\":\"Tea, Oil & Gas Business Visa Support\",\"desc\":\"Documentation support for Assam\'s tea, oil and gas sector professionals traveling internationally for business.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Guwahati students applying to US, UK, Canada and Australian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"US Visa Application Support\",\"desc\":\"DS-160 filing and interview preparation for Guwahati-based US visa applicants, coordinated for the Kolkata Consulate process.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Schengen & UK Tourist Visa Agents\",\"desc\":\"Document checklists and itinerary planning for Schengen and UK family tourist visa applications.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"uk\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support across visa categories for Guwahati and the wider Northeast region.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do I still need to travel to Kolkata for my US visa interview if I use your Guwahati service?\",\"a\":\"US visa interviews are conducted at the Kolkata Consulate for most Northeast applicants, but we handle all documentation, DS-160 filing and interview preparation locally from Guwahati beforehand.\"},{\"q\":\"Do you support Assam\'s tea and oil & gas sector businesses with visas?\",\"a\":\"Yes, we assist with business visa documentation for professionals in these sectors traveling internationally.\"},{\"q\":\"Do you support applicants from other Northeast states, not just Assam?\",\"a\":\"Yes, we regularly support applicants from across the Northeast who use Guwahati as their regional visa consultancy hub.\"},{\"q\":\"Is student visa demand growing in Guwahati?\",\"a\":\"Yes, we\'ve seen steady growth in student visa applications to the US, UK, Canada and Australia from Guwahati and the wider Northeast.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(27,'bhubaneswar','Bhubaneswar',240,'Best Visa Consultants in Bhubaneswar | IT, Steel & Student Visa Experts – Vocation Travels And Tours','Best visa consultants in Bhubaneswar for IT-sector work visas, steel and mining business visas, and US/UK/Canada student visa documentation.','best visa consultants in bhubaneswar, student visa consultants bhubaneswar, odisha visa consultants, bhubaneswar visa processing agency, business visa consultants bhubaneswar','Best Visa Consultants in Bhubaneswar','Odisha\'s capital hub for IT, industrial business travel and a fast-growing student visa market.','Bhubaneswar\'s IT, Industrial & Student Visa Consultants','Bhubaneswar\'s dual growth as an emerging IT hub and Odisha\'s steel and mining-industry capital creates a visa mix spanning tech-sector work travel, industrial business visas, and a rapidly growing student visa segment. Our Bhubaneswar team supports all three, with particular focus on the student visa demand that has grown fastest in recent years.','[{\"title\":\"IT Sector Work Visa Support\",\"desc\":\"Work-visa documentation for Bhubaneswar\'s growing IT and tech-sector professionals traveling for client projects.\",\"icon\":\"fa-laptop-code\",\"country_link\":\"\"},{\"title\":\"Steel & Mining Industry Business Visas\",\"desc\":\"Documentation support for Odisha\'s steel and mining-sector professionals traveling internationally for business.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Bhubaneswar students applying to US, UK and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Canada Study Visa Guidance\",\"desc\":\"Study permit documentation for Bhubaneswar\'s growing outbound student population.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Bhubaneswar and the wider Odisha region.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Bhubaneswar\'s IT and steel-sector businesses with visas?\",\"a\":\"Yes, we handle work and business visa documentation for both IT-sector professionals and steel/mining industry travelers.\"},{\"q\":\"Why has student visa demand grown so quickly in Bhubaneswar?\",\"a\":\"Bhubaneswar\'s expanding higher-education base and rising middle-class incomes have significantly grown its outbound student population applying to US, UK and Canadian universities.\"},{\"q\":\"Can you help with a Canada study visa from Bhubaneswar?\",\"a\":\"Yes, we guide Bhubaneswar students through Canada study permit documentation and application filing.\"},{\"q\":\"Do you support applicants from across Odisha, not just Bhubaneswar city?\",\"a\":\"Yes, we regularly assist applicants from across Odisha who use Bhubaneswar as their nearest visa consultancy hub.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(28,'thiruvananthapuram','Thiruvananthapuram',250,'Best Visa Consultants in Thiruvananthapuram | IT & Gulf Work Visa Experts – Vocation Travels And Tours','Best visa consultants in Thiruvananthapuram (Trivandrum) for IT-sector work visas, Gulf employment visas, and US/UK student visa documentation for Kerala\'s capital.','best visa consultants in thiruvananthapuram, trivandrum visa consultants, it work visa consultants trivandrum, gulf visa agents thiruvananthapuram, student visa consultants trivandrum','Best Visa Consultants in Thiruvananthapuram','Kerala\'s capital and Technopark hub — visa documentation for IT professionals, Gulf workers and students alike.','Thiruvananthapuram\'s IT & Gulf Employment Visa Specialists','Thiruvananthapuram\'s Technopark IT hub sets it apart from other Kerala cities — driving strong demand for IT-sector work visas alongside Kerala\'s broader, well-established Gulf employment visa pipeline. Our Trivandrum team supports both tech professionals traveling for client assignments and the city\'s steady outbound Gulf workforce, alongside a growing student visa segment.','[{\"title\":\"IT Sector Work Visa Support\",\"desc\":\"Work-visa documentation for Thiruvananthapuram\'s Technopark-based IT and tech-sector professionals.\",\"icon\":\"fa-laptop-code\",\"country_link\":\"\"},{\"title\":\"Gulf Work Visa Consultants\",\"desc\":\"Documentation and processing support for UAE, Saudi Arabia and Qatar work visas for Trivandrum\'s outbound workforce.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Thiruvananthapuram students applying to US and UK universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"NRI Family Visit & Sponsorship Visas\",\"desc\":\"Documentation guidance for Trivandrum families sponsoring visits from relatives working abroad, and vice versa.\",\"icon\":\"fa-people-roof\",\"country_link\":\"\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support across visa categories for Thiruvananthapuram applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"How is Thiruvananthapuram different from Kochi for visa services?\",\"a\":\"Thiruvananthapuram\'s Technopark hub adds a stronger IT-sector work visa component alongside the Gulf employment visa demand it shares with Kochi and the rest of Kerala.\"},{\"q\":\"Do you support Trivandrum\'s IT professionals with work visas?\",\"a\":\"Yes, we assist with work-visa documentation for Technopark-based IT and tech-sector professionals traveling for client projects.\"},{\"q\":\"Do you help with Gulf work visas from Thiruvananthapuram?\",\"a\":\"Yes, we support documentation for UAE, Saudi Arabia and Qatar work-visa categories.\"},{\"q\":\"Can you help NRI families in Thiruvananthapuram with sponsorship visas?\",\"a\":\"Yes, we guide families through sponsorship-related documentation for visits to and from relatives working abroad.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(29,'mysuru','Mysuru',260,'Best Visa Consultants in Mysuru | Student & Heritage Tourism Visa Experts – Vocation Travels And Tours','Best visa consultants in Mysuru (Mysore) for US, UK, Canada and Australia student visas, and tourist visa documentation, serving Karnataka\'s education and heritage hub.','best visa consultants in mysuru, mysore visa consultants, student visa consultants mysuru, mysuru visa processing agency, canada study visa mysore','Best Visa Consultants in Mysuru','Karnataka\'s education and heritage city — dedicated student and tourist visa documentation, without needing to travel to Bangalore.','Mysuru\'s Student Visa Consultants','Mysuru\'s large student population — spread across its engineering, medical and arts colleges — has traditionally traveled to Bangalore for visa consultancy support. Our Mysuru service closes that gap, offering the same US, UK, Canada and Australia student visa documentation locally, alongside tourist visa support for the city\'s culturally connected families.','[{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review, financial documentation and interview preparation for Mysuru students applying to the USA, UK, Canada and Australia.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Canada Study Visa Guidance\",\"desc\":\"Study permit documentation and post-study work permit pathway guidance for Mysuru\'s engineering and arts graduates.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"UK Student Visa Consultancy\",\"desc\":\"Financial documentation and CAS-linked application support for Mysuru students heading to UK universities.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Schengen & UK Tourist Visa Agents\",\"desc\":\"Document checklists and itinerary planning for Mysuru families applying for Schengen and UK tourist visas.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support, built to save Mysuru applicants a trip to Bangalore for the same service.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do Mysuru applicants need to travel to Bangalore for visa consultancy?\",\"a\":\"No — our Mysuru service provides the same documentation and filing support locally, without requiring a trip to Bangalore.\"},{\"q\":\"What student visa destinations are most requested from Mysuru?\",\"a\":\"US, UK, Canada and Australia are the most requested, reflecting demand from the city\'s engineering, medical and arts college graduates.\"},{\"q\":\"Can you help Mysuru students with Canada study permits?\",\"a\":\"Yes, we guide applicants through both the initial study permit and post-study work permit documentation.\"},{\"q\":\"Do you support tourist visa applications for Mysuru families?\",\"a\":\"Yes, we assist with Schengen and UK tourist visa document checklists and itinerary planning.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(30,'dehradun','Dehradun',270,'Best Visa Consultants in Dehradun | Student & Defence-Sector Visa Experts – Vocation Travels And Tours','Best visa consultants in Dehradun for US, UK, Canada and Australia student visas — trusted by Uttarakhand\'s large boarding-school and defence-linked community.','best visa consultants in dehradun, student visa consultants dehradun, uttarakhand visa consultants, dehradun visa processing agency, canada study visa dehradun','Best Visa Consultants in Dehradun','Uttarakhand\'s education and defence hub — student visa expertise built for a uniquely well-prepared applicant base.','Dehradun\'s Student Visa Consultants','Dehradun\'s dense concentration of boarding schools, colleges and defence-linked institutions produces one of India\'s most education-focused applicant bases — students who are often applying alongside siblings or classmates from the same institutions. Our Dehradun team specializes in US, UK, Canada and Australia student visa documentation, alongside tourist visa support for the city\'s defence and government-linked families.','[{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review, financial documentation and interview preparation for Dehradun students applying to the USA, UK, Canada and Australia.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Canada Study Visa Guidance\",\"desc\":\"Study permit and post-study work permit documentation for Dehradun\'s growing outbound student population.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"UK & Australia Student Visa Support\",\"desc\":\"Financial documentation and application filing for Dehradun students heading to UK and Australian institutions.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Defence & Government-Linked Family Travel\",\"desc\":\"Tourist and visitor visa documentation for Dehradun families connected to the defence and government sector.\",\"icon\":\"fa-people-roof\",\"country_link\":\"\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support across visa categories for Dehradun applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Why does Dehradun have such a strong student visa applicant base?\",\"a\":\"Dehradun\'s dense concentration of boarding schools, colleges and defence-linked institutions produces a large, well-prepared pool of students applying abroad each year.\"},{\"q\":\"Do you support siblings or classmates applying together?\",\"a\":\"Yes, we regularly coordinate documentation for multiple students from the same family or institution applying in the same intake cycle.\"},{\"q\":\"Can Dehradun students get help with Canada study permits?\",\"a\":\"Yes, we guide applicants through both the initial study permit and post-study work permit documentation.\"},{\"q\":\"Do you support tourist visa applications for defence-linked families?\",\"a\":\"Yes, we assist Dehradun families connected to the defence and government sector with tourist and visitor visa documentation.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(31,'raipur','Raipur',280,'Best Visa Consultants in Raipur | Steel & Mining Business Visa Experts – Vocation Travels And Tours','Best visa consultants in Raipur for steel and mining business visas, US/UK tourist visas and student visa documentation for Chhattisgarh\'s capital.','best visa consultants in raipur, business visa consultants raipur, raipur visa processing agency, chhattisgarh visa consultants, student visa consultants raipur','Best Visa Consultants in Raipur','Chhattisgarh\'s steel and mining capital, matched with dedicated business and student visa documentation.','Raipur\'s Steel, Mining & Student Visa Consultants','Raipur\'s dense steel and mining industrial base drives most of the city\'s business visa demand, alongside a growing, still-emerging student visa market. Our Raipur team supports steel and mining-sector professionals traveling for business, and provides structured guidance for the city\'s first generation of large-scale international student visa applicants.','[{\"title\":\"Steel & Mining Industry Business Visas\",\"desc\":\"Documentation support for Raipur\'s steel and mining-sector professionals traveling internationally for business.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Raipur students applying to US, UK and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"US Tourist & Business Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Raipur-based US visitor and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"UK Visitor Visa Consultants\",\"desc\":\"Documentation support for UK tourism, family visit and short business trip visas.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"uk\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Raipur applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Raipur\'s steel and mining businesses with visas?\",\"a\":\"Yes, we handle business visa documentation for steel and mining-sector professionals traveling internationally.\"},{\"q\":\"Is student visa demand growing in Raipur?\",\"a\":\"Yes, though still emerging compared to established education hubs, we\'re seeing steady growth in Raipur applications to US, UK and Canadian universities.\"},{\"q\":\"Do you support applicants from across Chhattisgarh, not just Raipur city?\",\"a\":\"Yes, we regularly assist applicants from across Chhattisgarh who use Raipur as their nearest visa consultancy hub.\"},{\"q\":\"What business visa support do you offer Raipur\'s industrial sector?\",\"a\":\"We provide documentation support for steel, mining and related industrial-sector professionals traveling for trade meetings and factory visits.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(32,'ranchi','Ranchi',290,'Best Visa Consultants in Ranchi | Mining & Steel Business Visa Experts – Vocation Travels And Tours','Best visa consultants in Ranchi for mining and steel-industry business visas, US/UK tourist visas and student visa documentation for Jharkhand\'s capital.','best visa consultants in ranchi, business visa consultants ranchi, ranchi visa processing agency, jharkhand visa consultants, student visa consultants ranchi','Best Visa Consultants in Ranchi','Jharkhand\'s mining and steel capital, backed by dedicated business and student visa documentation support.','Ranchi\'s Mining, Steel & Student Visa Consultants','Ranchi\'s role as Jharkhand\'s mining and steel-industry capital shapes most of the city\'s business visa demand, while a steadily growing student population applies for study visas to the US, UK, Canada and Australia. Our Ranchi team supports mining and steel-sector business travelers alongside first-time student visa applicants, with the same document-first, no-guarantee approach we bring to every city.','[{\"title\":\"Mining & Steel Industry Business Visas\",\"desc\":\"Documentation support for Ranchi\'s mining and steel-sector professionals traveling internationally for business.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Ranchi students applying to US, UK, Canada and Australian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"US Tourist & Business Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Ranchi-based US visitor and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Canada Study Visa Guidance\",\"desc\":\"Study permit documentation for Ranchi\'s growing outbound student population.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Ranchi applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Ranchi\'s mining and steel-sector businesses with visas?\",\"a\":\"Yes, we handle business visa documentation for professionals in the mining and steel industries traveling internationally.\"},{\"q\":\"Do you support first-time student visa applicants from Ranchi?\",\"a\":\"Yes, we guide first-time applicants through the complete process, from SOP review to interview preparation.\"},{\"q\":\"Can you help Ranchi students with a Canada study permit?\",\"a\":\"Yes, we guide applicants through Canada study permit documentation and application filing.\"},{\"q\":\"Do you support applicants from across Jharkhand, not just Ranchi city?\",\"a\":\"Yes, we regularly assist applicants from across Jharkhand who use Ranchi as their nearest visa consultancy hub.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(33,'jalandhar','Jalandhar',300,'Best Visa Consultants in Jalandhar | Canada Immigration & Sports Goods Business Visa Experts – Vocation Travels And Tours','Best visa consultants in Jalandhar for Canada study and PR-track visas, sports goods export business visas, and UK/Australia student visa documentation.','best visa consultants in jalandhar, canada visa consultants jalandhar, sports goods export visa jalandhar, punjab doaba visa consultants, jalandhar visa processing agency','Best Visa Consultants in Jalandhar','The heart of Punjab\'s Doaba belt — deep Canada immigration expertise alongside sports goods export business visa support.','Jalandhar\'s Doaba-Belt Canada & Business Visa Specialists','Jalandhar sits at the center of Punjab\'s Doaba belt — a region with one of India\'s longest-running Canada immigration histories — while also serving as India\'s sports goods manufacturing and export hub. Our Jalandhar team specializes in Canada study permit and PR-track documentation for the region\'s large outbound student population, alongside business visa support for the city\'s export-driven manufacturing sector.','[{\"title\":\"Canada Study Permit Consultants\",\"desc\":\"End-to-end documentation support for Canada study permit applications for Jalandhar and Doaba-region students.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Canada PR-Track Documentation\",\"desc\":\"Guidance on Express Entry-track documentation and post-study work permit pathways for Jalandhar\'s Canada-bound graduates.\",\"icon\":\"fa-passport\",\"country_link\":\"\"},{\"title\":\"Sports Goods Export Business Visas\",\"desc\":\"Documentation support for Jalandhar\'s sports goods manufacturing and export businesses traveling for trade fairs.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"UK & Australia Student Visa Support\",\"desc\":\"Student visa documentation for Jalandhar applicants heading to UK and Australian institutions.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Detail-focused review built around Jalandhar\'s high-volume Canada immigration and export business pipeline.\",\"icon\":\"fa-magnifying-glass\",\"country_link\":\"\"}]','[{\"q\":\"Why is Canada such a common destination for Jalandhar applicants?\",\"a\":\"Jalandhar sits at the center of Punjab\'s Doaba belt, one of India\'s longest-running and strongest Canada study-and-immigration corridors.\"},{\"q\":\"Do you support Jalandhar\'s sports goods export businesses with visas?\",\"a\":\"Yes, we handle business visa documentation for sports goods manufacturers and exporters traveling for trade fairs and buyer meetings.\"},{\"q\":\"Can you guarantee a Canada study permit approval?\",\"a\":\"No consultant can guarantee approval — IRCC makes the final decision. We focus on building a complete, error-free application.\"},{\"q\":\"How is Jalandhar different from Ludhiana or Chandigarh for visa services?\",\"a\":\"The core Canada immigration expertise is similar across all three Doaba/Punjab cities; Jalandhar\'s distinct business visa demand comes from its sports goods export industry.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(34,'madurai','Madurai',310,'Best Visa Consultants in Madurai | Gulf Work Visa & Student Visa Experts – Vocation Travels And Tours','Best visa consultants in Madurai for Gulf work visas, US/UK student visas and textile business visa documentation for Tamil Nadu\'s temple city.','best visa consultants in madurai, gulf work visa agents madurai, student visa consultants madurai, madurai visa processing agency, textile business visa madurai','Best Visa Consultants in Madurai','Tamil Nadu\'s temple city, serving a growing base of Gulf workers, students and textile business travelers.','Madurai\'s Gulf Work Visa & Student Visa Consultants','Madurai\'s visa consultancy needs span a traditional outbound Gulf workforce, a growing student visa segment from the city\'s engineering and arts colleges, and steady business travel tied to its textile and handloom export trade. Our Madurai team supports all three — Gulf employment visa documentation, student visa guidance for US and UK-bound applicants, and business visa support for textile exporters.','[{\"title\":\"Gulf Work Visa Consultants\",\"desc\":\"Documentation and processing support for UAE, Saudi Arabia and Qatar work visas for Madurai\'s outbound workforce.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Madurai students applying to US and UK universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Textile & Handloom Export Business Visas\",\"desc\":\"Documentation support for Madurai\'s textile and handloom export businesses traveling for trade fairs.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"US Tourist Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Madurai-based US tourist and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Madurai applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Gulf work visa applicants from Madurai?\",\"a\":\"Yes, we handle documentation for UAE, Saudi Arabia and Qatar work-visa categories for Madurai\'s outbound workforce.\"},{\"q\":\"Do you support Madurai\'s textile and handloom export businesses?\",\"a\":\"Yes, we assist with business visa documentation for textile and handloom exporters traveling for trade fairs and buyer meetings.\"},{\"q\":\"Is student visa demand growing in Madurai?\",\"a\":\"Yes, we\'re seeing steady growth in applications to US and UK universities from Madurai\'s engineering and arts college graduates.\"},{\"q\":\"How is Madurai different from Chennai or Coimbatore for visa services?\",\"a\":\"Madurai\'s visa demand is more heavily weighted toward Gulf work visas and textile trade compared to Chennai\'s US Consulate access or Coimbatore\'s manufacturing focus.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(35,'tiruchirappalli','Tiruchirappalli',320,'Best Visa Consultants in Tiruchirappalli (Trichy) | Engineering Student Visa Experts – Vocation Travels And Tours','Best visa consultants in Tiruchirappalli (Trichy) for US, UK, Canada and Australia student visas — trusted by Tamil Nadu\'s engineering education hub.','best visa consultants in tiruchirappalli, trichy visa consultants, student visa consultants trichy, canada study visa trichy, engineering student visa tiruchirappalli','Best Visa Consultants in Tiruchirappalli','Trichy\'s engineering education hub, matched with student visa expertise built specifically for technical graduates.','Tiruchirappalli\'s Engineering Student Visa Consultants','Tiruchirappalli\'s dense cluster of engineering colleges — including some of Tamil Nadu\'s top-ranked institutions — makes it one of the state\'s strongest sources of outbound student visa applicants, particularly for the US, UK, Canada and Australia. Our Trichy team focuses on the specific documentation profile of engineering graduates: technical SOPs, standardized test scores and financial planning for STEM-heavy programs.','[{\"title\":\"Engineering Student Visa Consultancy\",\"desc\":\"SOP review tailored to technical and STEM applications, plus financial documentation for Trichy\'s engineering graduates.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Canada Study Permit Guidance\",\"desc\":\"Study permit and post-study work permit documentation for Trichy\'s engineering graduates heading to Canada.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"US F-1 Student Visa Support\",\"desc\":\"DS-160 filing, SEVIS documentation and interview preparation for Trichy students admitted to US universities.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Australia Student Visa Support\",\"desc\":\"Student and student-dependent visa documentation for Trichy applicants heading to Australian institutions.\",\"icon\":\"fa-earth-oceania\",\"country_link\":\"australia\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review built around Trichy\'s high-volume engineering student visa pipeline.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Why does Tiruchirappalli have such strong student visa demand?\",\"a\":\"Trichy\'s dense cluster of top-ranked engineering colleges produces one of Tamil Nadu\'s largest pools of outbound student visa applicants each year.\"},{\"q\":\"Do you specialize in visa documentation for engineering students specifically?\",\"a\":\"Yes, our SOP review and documentation guidance is tailored to the technical, STEM-focused applications engineering graduates typically submit.\"},{\"q\":\"Can Trichy students get help with US F-1 visa applications?\",\"a\":\"Yes, we support DS-160 filing, SEVIS documentation and interview preparation for US-bound students.\"},{\"q\":\"Do you help with Canada study permits for engineering graduates?\",\"a\":\"Yes, we guide Trichy engineering graduates through both study permit and post-study work permit documentation.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(36,'kanpur','Kanpur',330,'Best Visa Consultants in Kanpur | Leather & Industrial Business Visa Experts – Vocation Travels And Tours','Best visa consultants in Kanpur for leather and industrial export business visas, US/UK tourist visas and student visa documentation.','best visa consultants in kanpur, leather export business visa kanpur, kanpur visa processing agency, student visa consultants kanpur, business visa consultants kanpur','Best Visa Consultants in Kanpur','Serving Uttar Pradesh\'s leather and industrial export hub with business, tourist and student visa documentation.','Kanpur\'s Leather & Industrial Business Visa Consultants','Kanpur\'s long-established leather and industrial export base drives steady business visa demand — frequent travel to Europe, the US and the Middle East for trade fairs and buyer meetings. Alongside this, a growing student visa segment is applying to the US, UK and Canada. Our Kanpur team supports both, with particular depth in the documentation exporters need for fast, repeat business travel.','[{\"title\":\"Leather & Industrial Export Business Visas\",\"desc\":\"Documentation support for Kanpur\'s leather and industrial exporters traveling for trade fairs and buyer meetings.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"Schengen Business Visa Agents\",\"desc\":\"Application support for Schengen business visas tied to European trade fairs and buyer visits.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Kanpur students applying to US, UK and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"US Tourist & Business Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Kanpur-based US visitor and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Kanpur applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Kanpur\'s leather and industrial export businesses?\",\"a\":\"Yes, we handle business visa documentation for leather and industrial exporters traveling for trade fairs and buyer meetings.\"},{\"q\":\"Do you help with repeat business travel visas for frequent exporters?\",\"a\":\"Yes, we help Kanpur exporters build a documentation process that stays consistent across repeat business trips.\"},{\"q\":\"Is student visa demand growing in Kanpur?\",\"a\":\"Yes, we\'re seeing steady growth in applications to US, UK and Canadian universities from Kanpur students.\"},{\"q\":\"Do you support Schengen business visas for European trade fairs?\",\"a\":\"Yes, we assist Kanpur exporters with Schengen business visa applications tied to European trade fair travel.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(37,'agra','Agra',340,'Best Visa Consultants in Agra | Handicraft Export & Tourist Visa Experts – Vocation Travels And Tours','Best visa consultants in Agra for handicraft and leather export business visas, US/UK/Schengen tourist visas, and student visa documentation.','best visa consultants in agra, handicraft export business visa agra, agra visa processing agency, student visa consultants agra, tourist visa agents agra','Best Visa Consultants in Agra','Serving Agra\'s handicraft export businesses and outbound travelers with complete visa documentation support.','Agra\'s Handicraft Export & Tourist Visa Consultants','Agra\'s global reputation as a tourism destination — anchored by the Taj Mahal — sits alongside a large handicraft, leather and marble-inlay export industry that regularly travels abroad for trade fairs. Our Agra team supports these exporters with business visa documentation, while also guiding local families and students through tourist and study visa applications.','[{\"title\":\"Handicraft & Leather Export Business Visas\",\"desc\":\"Documentation support for Agra\'s handicraft, leather and marble-inlay exporters traveling for trade fairs and buyer meetings.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"US & Schengen Tourist Visa Agents\",\"desc\":\"DS-160 filing and Schengen document checklists for Agra-based tourist visa applicants.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Agra students applying to US, UK and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"UK Visitor Visa Consultants\",\"desc\":\"Documentation support for UK tourism, family visit and short business trip visas.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Agra applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Agra\'s handicraft and leather export businesses?\",\"a\":\"Yes, we handle business visa documentation for handicraft, leather and marble-inlay exporters traveling for trade fairs and buyer meetings.\"},{\"q\":\"Do you help Agra families with Schengen tourist visas?\",\"a\":\"Yes, we assist with document checklists and itinerary planning for Schengen family tourist visa applications.\"},{\"q\":\"Is student visa demand growing in Agra?\",\"a\":\"Yes, we\'re seeing steady growth in applications to US, UK and Canadian universities from Agra students.\"},{\"q\":\"Can you help with UK visitor visas for Agra families?\",\"a\":\"Yes, we support documentation for UK tourism, family visit and short business trip visas.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(38,'nashik','Nashik',350,'Best Visa Consultants in Nashik | Wine & Agri-Export Business Visa Experts – Vocation Travels And Tours','Best visa consultants in Nashik for wine and agri-export business visas, US/UK tourist visas and student visa documentation.','best visa consultants in nashik, wine export business visa nashik, agri export visa consultants nashik, nashik visa processing agency, student visa consultants nashik','Best Visa Consultants in Nashik','India\'s wine capital, matched with business visa expertise built for its wine and agri-export industry.','Nashik\'s Wine & Agri-Export Business Visa Consultants','Nashik\'s identity as India\'s wine capital, alongside its broader grape and agricultural export trade, drives a distinct business visa demand — frequent travel to Europe and Southeast Asia for trade shows, tastings and buyer meetings. Our Nashik team supports these exporters, alongside a growing student visa segment tied to the city\'s expanding education sector.','[{\"title\":\"Wine & Agri-Export Business Visas\",\"desc\":\"Documentation support for Nashik\'s wine and agricultural exporters traveling for trade shows and buyer meetings.\",\"icon\":\"fa-wine-glass\",\"country_link\":\"\"},{\"title\":\"Schengen Business Visa Agents\",\"desc\":\"Application support for Schengen business visas tied to European wine trade shows and tastings.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Nashik students applying to US, UK and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"US Tourist Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Nashik-based US tourist and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Nashik applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Nashik\'s wine and agri-export businesses with visas?\",\"a\":\"Yes, we handle business visa documentation for wine and agricultural exporters traveling for trade shows and buyer meetings.\"},{\"q\":\"Do you help with Schengen visas for European wine trade travel?\",\"a\":\"Yes, we support Schengen business visa applications tied to European wine trade shows and tastings.\"},{\"q\":\"Is student visa demand growing in Nashik?\",\"a\":\"Yes, we\'re seeing steady growth in applications to US, UK and Canadian universities from Nashik students.\"},{\"q\":\"How is Nashik different from Pune for visa services?\",\"a\":\"Nashik\'s business visa demand is more heavily weighted toward its wine and agri-export industry, compared to Pune\'s IT and education-driven mix.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(39,'rajkot','Rajkot',360,'Best Visa Consultants in Rajkot | Engineering & Auto-Parts Business Visa Experts – Vocation Travels And Tours','Best visa consultants in Rajkot for engineering and auto-parts export business visas, US/UK tourist visas and Canada visa documentation.','best visa consultants in rajkot, engineering export visa rajkot, auto parts business visa rajkot, rajkot visa processing agency, canada visa consultants rajkot','Best Visa Consultants in Rajkot','Serving Saurashtra\'s engineering and auto-parts export hub with business and outbound travel visa documentation.','Rajkot\'s Engineering & Auto-Parts Business Visa Consultants','Rajkot\'s dense cluster of engineering and auto-parts manufacturing units — a core part of the Saurashtra region\'s industrial base — generates steady business visa demand for trade fairs and buyer meetings worldwide. Our Rajkot team supports these manufacturers alongside Gujarat\'s broader pattern of strong outbound US, UK and Canada visa demand for tourist and family-visit travel.','[{\"title\":\"Engineering & Auto-Parts Export Business Visas\",\"desc\":\"Documentation support for Rajkot\'s engineering and auto-parts manufacturers traveling for trade fairs and buyer meetings.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"US Tourist & Business Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Rajkot-based US visitor and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Canada Visitor Visa Guidance\",\"desc\":\"Documentation for Canada visitor visas and Super Visa applications for Rajkot families with relatives in Canada.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"UK Visitor Visa Consultants\",\"desc\":\"Documentation support for UK tourism, family visit and short business trip visas.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Rajkot and the wider Saurashtra region.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Rajkot\'s engineering and auto-parts export businesses?\",\"a\":\"Yes, we handle business visa documentation for engineering and auto-parts manufacturers traveling for trade fairs and buyer meetings.\"},{\"q\":\"Do you support applicants from the wider Saurashtra region?\",\"a\":\"Yes, we regularly assist applicants from across Saurashtra who use Rajkot as their nearest visa consultancy hub.\"},{\"q\":\"Can you help with a Canada Super Visa for Rajkot families?\",\"a\":\"Yes, we guide Rajkot applicants through Super Visa documentation for parents and grandparents visiting family in Canada.\"},{\"q\":\"What visa categories are most requested in Rajkot?\",\"a\":\"Business visas tied to the engineering and auto-parts export industry, alongside US, UK and Canada tourist and family-visit visas.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(40,'varanasi','Varanasi',370,'Best Visa Consultants in Varanasi | Gulf Work Visa & Textile Export Experts – Vocation Travels And Tours','Best visa consultants in Varanasi for Gulf work visas, silk and textile export business visas, and student visa documentation for the Purvanchal region.','best visa consultants in varanasi, gulf work visa agents varanasi, silk textile export visa varanasi, varanasi visa processing agency, purvanchal visa consultants','Best Visa Consultants in Varanasi','Serving the Purvanchal region\'s Gulf workforce and silk export businesses with complete visa documentation.','Varanasi\'s Gulf Work Visa & Silk Export Visa Consultants','Varanasi and the wider Purvanchal region have a well-established outbound Gulf labor workforce, alongside the city\'s globally known Banarasi silk export trade. Our Varanasi team supports both — Gulf employment visa documentation for skilled and semi-skilled workers, and business visa support for silk and textile exporters traveling for international trade fairs.','[{\"title\":\"Gulf Work Visa Consultants\",\"desc\":\"Documentation and processing support for UAE, Saudi Arabia and Qatar work visas for Varanasi and the Purvanchal region\'s outbound workforce.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Silk & Textile Export Business Visas\",\"desc\":\"Documentation support for Varanasi\'s Banarasi silk and textile exporters traveling for international trade fairs.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Varanasi students applying to US, UK and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Labor & Employment Visa Documentation\",\"desc\":\"Detailed documentation support for skilled and semi-skilled workers applying for Gulf employment visas.\",\"icon\":\"fa-people-carry-box\",\"country_link\":\"\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Varanasi and the wider Purvanchal region.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Why is Gulf work visa demand high in Varanasi?\",\"a\":\"Varanasi and the wider Purvanchal region have a well-established outbound labor workforce heading to Gulf countries, and we provide dedicated documentation support for this pipeline.\"},{\"q\":\"Do you support Varanasi\'s silk and textile export businesses?\",\"a\":\"Yes, we handle business visa documentation for Banarasi silk and textile exporters traveling for international trade fairs.\"},{\"q\":\"Do you support skilled and semi-skilled Gulf employment visa applicants?\",\"a\":\"Yes, we provide dedicated documentation support for skilled and semi-skilled workers applying for Gulf employment visas.\"},{\"q\":\"Do you support applicants from across the Purvanchal region, not just Varanasi city?\",\"a\":\"Yes, we regularly assist applicants from across Purvanchal who use Varanasi as their nearest visa consultancy hub.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(41,'vijayawada','Vijayawada',380,'Best Visa Consultants in Vijayawada | Business & Student Visa Experts – Vocation Travels And Tours','Best visa consultants in Vijayawada for business and trade visas, US/UK student visas and Gulf work visa documentation for Andhra Pradesh\'s commercial hub.','best visa consultants in vijayawada, business visa consultants vijayawada, vijayawada visa processing agency, student visa consultants vijayawada, andhra pradesh visa consultants','Best Visa Consultants in Vijayawada','Andhra Pradesh\'s commercial hub, matched with complete business, student and Gulf work visa documentation.','Vijayawada\'s Business & Student Visa Consultants','Vijayawada\'s position as Andhra Pradesh\'s commercial and trading hub — now with added significance given its proximity to the developing Amaravati capital region — drives steady business visa demand alongside a growing student visa market and established Gulf work visa needs. Our Vijayawada team supports all three, tailored to the specific documentation each category requires.','[{\"title\":\"Business & Trade Visa Consultants\",\"desc\":\"Documentation support for Vijayawada\'s trading and commercial businesses traveling for international meetings.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Vijayawada students applying to US, UK and Australian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Gulf Work Visa Documentation\",\"desc\":\"Work-visa documentation support for Vijayawada professionals taking up roles in UAE, Saudi Arabia and other Gulf countries.\",\"icon\":\"fa-earth-africa\",\"country_link\":\"\"},{\"title\":\"US Tourist Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Vijayawada-based US tourist and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Vijayawada applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Vijayawada\'s trading and commercial businesses with visas?\",\"a\":\"Yes, we handle business visa documentation for Vijayawada businesses traveling for international trade meetings.\"},{\"q\":\"Is student visa demand growing in Vijayawada?\",\"a\":\"Yes, we\'re seeing steady growth in applications to US, UK and Australian universities from Vijayawada students.\"},{\"q\":\"Do you help with Gulf work visas for Vijayawada professionals?\",\"a\":\"Yes, we support documentation for UAE, Saudi Arabia and other Gulf work-visa categories.\"},{\"q\":\"Has visa demand changed with the Amaravati capital region\'s development?\",\"a\":\"We\'ve seen growing business and relocation-linked travel documentation needs tied to the region\'s ongoing development, alongside Vijayawada\'s traditional trade and student visa demand.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(42,'jodhpur','Jodhpur',390,'Best Visa Consultants in Jodhpur | Handicraft Export & Student Visa Experts – Vocation Travels And Tours','Best visa consultants in Jodhpur for handicraft export business visas, US/UK tourist visas and student visa documentation for Rajasthan\'s Blue City.','best visa consultants in jodhpur, handicraft export visa jodhpur, jodhpur visa processing agency, student visa consultants jodhpur, tourist visa agents jodhpur','Best Visa Consultants in Jodhpur','Rajasthan\'s Blue City, serving handicraft exporters, students and outbound travelers with complete visa documentation.','Jodhpur\'s Handicraft Export & Student Visa Consultants','Jodhpur\'s globally recognized handicraft, furniture and textile export trade drives regular business travel to Europe and the US for trade fairs and buyer visits. Alongside this, a growing student visa segment is applying to engineering and business programs abroad. Our Jodhpur team supports both, along with tourist visa documentation for the city\'s culturally connected families.','[{\"title\":\"Handicraft & Furniture Export Business Visas\",\"desc\":\"Documentation support for Jodhpur\'s handicraft, furniture and textile exporters traveling for trade fairs and buyer meetings.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"Schengen & UK Business Visa Agents\",\"desc\":\"Application support for Schengen and UK business visas tied to European trade fair travel.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Jodhpur students applying to US, UK and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"US Tourist Visa Agents\",\"desc\":\"DS-160 filing and interview preparation for Jodhpur-based US tourist and business visa applicants.\",\"icon\":\"fa-flag-usa\",\"country_link\":\"usa\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Jodhpur applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Jodhpur\'s handicraft and furniture export businesses?\",\"a\":\"Yes, we handle business visa documentation for handicraft, furniture and textile exporters traveling for trade fairs and buyer meetings.\"},{\"q\":\"Do you help with Schengen business visas for European trade fairs?\",\"a\":\"Yes, we support Schengen and UK business visa applications tied to European trade fair travel.\"},{\"q\":\"Is student visa demand growing in Jodhpur?\",\"a\":\"Yes, we\'re seeing steady growth in applications to US, UK and Canadian universities from Jodhpur students.\"},{\"q\":\"Do you support tourist visas for Jodhpur families?\",\"a\":\"Yes, we assist with US and Schengen tourist visa documentation for Jodhpur families.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(43,'siliguri','Siliguri',400,'Best Visa Consultants in Siliguri | Cross-Border Trade & Tourist Visa Experts – Vocation Travels And Tours','Best visa consultants in Siliguri for cross-border trade business visas, tea industry documentation, and US/UK/Schengen tourist visa support for North Bengal.','best visa consultants in siliguri, cross border trade visa siliguri, tea industry business visa siliguri, siliguri visa processing agency, north bengal visa consultants','Best Visa Consultants in Siliguri','North Bengal\'s cross-border trade gateway, serving tea industry, trade and tourist visa applicants.','Siliguri\'s Cross-Border Trade & Tourist Visa Consultants','Siliguri\'s position as the gateway to Nepal, Bhutan and Bangladesh — combined with North Bengal\'s established tea industry — creates a visa profile distinct from the rest of West Bengal. Our Siliguri team supports tea industry and cross-border trade professionals traveling internationally, alongside a steady base of tourist and student visa applicants from across North Bengal.','[{\"title\":\"Cross-Border Trade Business Visas\",\"desc\":\"Documentation support for Siliguri\'s trade businesses with cross-border operations toward Nepal, Bhutan and Bangladesh, plus wider international travel.\",\"icon\":\"fa-briefcase\",\"country_link\":\"\"},{\"title\":\"Tea Industry Business Visas\",\"desc\":\"Documentation support for North Bengal\'s tea industry professionals traveling internationally for trade and business.\",\"icon\":\"fa-mug-hot\",\"country_link\":\"\"},{\"title\":\"Schengen & UK Tourist Visa Agents\",\"desc\":\"Document checklists and itinerary planning for Siliguri families applying for Schengen and UK tourist visas.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"europe\"},{\"title\":\"Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Siliguri students applying to US, UK and Australian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Siliguri and the wider North Bengal region.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Siliguri\'s tea industry with business visas?\",\"a\":\"Yes, we handle business visa documentation for North Bengal\'s tea industry professionals traveling internationally.\"},{\"q\":\"Do you support businesses with cross-border trade operations?\",\"a\":\"Yes, we assist Siliguri\'s cross-border trade businesses with visa documentation for their wider international travel needs.\"},{\"q\":\"Do you support applicants from across North Bengal, not just Siliguri city?\",\"a\":\"Yes, we regularly assist applicants from across North Bengal who use Siliguri as their nearest visa consultancy hub.\"},{\"q\":\"Is student visa demand growing in Siliguri?\",\"a\":\"Yes, we\'re seeing steady growth in applications to US, UK and Australian universities from Siliguri students.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(44,'meerut','Meerut',410,'Best Visa Consultants in Meerut | Sports Goods Export & Student Visa Experts – Vocation Travels And Tours','Best visa consultants in Meerut for sports goods export business visas, US/UK/Canada student visas and NCR-adjacent business travel documentation.','best visa consultants in meerut, sports goods export visa meerut, meerut visa processing agency, student visa consultants meerut, business visa consultants meerut','Best Visa Consultants in Meerut','India\'s sports goods manufacturing hub, backed by dedicated business and student visa documentation support.','Meerut\'s Sports Goods Export & Student Visa Consultants','Meerut\'s globally significant sports goods manufacturing industry — supplying cricket bats and equipment worldwide — drives steady business visa demand for international trade fairs and buyer meetings. Being NCR-adjacent, Meerut also sees strong outbound student visa demand toward the US, UK and Canada. Our Meerut team supports both categories with the same document-first, no-guarantee approach we bring everywhere.','[{\"title\":\"Sports Goods Export Business Visas\",\"desc\":\"Documentation support for Meerut\'s sports goods manufacturers and exporters traveling for international trade fairs.\",\"icon\":\"fa-industry\",\"country_link\":\"\"},{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review and financial documentation for Meerut students applying to US, UK and Canadian universities.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Canada Study Visa Guidance\",\"desc\":\"Study permit documentation for Meerut\'s growing outbound student population.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"UK & Schengen Business Visa Support\",\"desc\":\"Application support for UK and Schengen business visas tied to international trade fair travel.\",\"icon\":\"fa-earth-europe\",\"country_link\":\"uk\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation review across visa categories for Meerut applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Do you support Meerut\'s sports goods export businesses with visas?\",\"a\":\"Yes, we handle business visa documentation for sports goods manufacturers and exporters traveling for international trade fairs.\"},{\"q\":\"Is Meerut visa demand similar to Delhi NCR?\",\"a\":\"Meerut\'s NCR-adjacent location brings similar strong student visa demand, alongside a distinct business visa profile driven by its sports goods manufacturing industry.\"},{\"q\":\"Can Meerut students get help with Canada study permits?\",\"a\":\"Yes, we guide Meerut students through Canada study permit documentation and application filing.\"},{\"q\":\"Do you support Schengen business visas for trade fair travel?\",\"a\":\"Yes, we assist Meerut exporters with Schengen and UK business visa applications tied to trade fair travel.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52'),(45,'gwalior','Gwalior',420,'Best Visa Consultants in Gwalior | Defence-Sector & Student Visa Experts – Vocation Travels And Tours','Best visa consultants in Gwalior for US, UK and Canada student visas, and defence and government-sector business travel documentation.','best visa consultants in gwalior, student visa consultants gwalior, gwalior visa processing agency, defence sector visa consultants gwalior, canada study visa gwalior','Best Visa Consultants in Gwalior','Madhya Pradesh\'s defence and education hub — student visa expertise built for a well-prepared applicant base.','Gwalior\'s Defence-Sector & Student Visa Consultants','Gwalior\'s strong defence-institution and educational base — including several well-regarded schools and colleges — produces a steady stream of student visa applicants heading to the US, UK and Canada. Our Gwalior team supports these students with SOP review and financial documentation, alongside visitor visa support for defence and government-linked families planning international travel.','[{\"title\":\"Study Abroad & Student Visa Consultancy\",\"desc\":\"SOP review, financial documentation and interview preparation for Gwalior students applying to the USA, UK and Canada.\",\"icon\":\"fa-graduation-cap\",\"country_link\":\"\"},{\"title\":\"Canada Study Visa Guidance\",\"desc\":\"Study permit and post-study work permit documentation for Gwalior\'s growing outbound student population.\",\"icon\":\"fa-maple-leaf\",\"country_link\":\"canada\"},{\"title\":\"Defence & Government-Linked Family Travel\",\"desc\":\"Tourist and visitor visa documentation for Gwalior families connected to the defence and government sector.\",\"icon\":\"fa-people-roof\",\"country_link\":\"\"},{\"title\":\"UK Student Visa Consultancy\",\"desc\":\"Financial documentation and CAS-linked application support for Gwalior students heading to UK universities.\",\"icon\":\"fa-book-open\",\"country_link\":\"uk\"},{\"title\":\"Immigration Documentation Support\",\"desc\":\"Checklist-driven documentation support across visa categories for Gwalior applicants.\",\"icon\":\"fa-passport\",\"country_link\":\"\"}]','[{\"q\":\"Why does Gwalior have a strong student visa applicant base?\",\"a\":\"Gwalior\'s well-regarded schools and colleges, combined with its defence-institution presence, produce a steady stream of students applying to US, UK and Canadian universities each year.\"},{\"q\":\"Can Gwalior students get help with Canada study permits?\",\"a\":\"Yes, we guide applicants through both the initial study permit and post-study work permit documentation.\"},{\"q\":\"Do you support tourist visa applications for defence-linked families?\",\"a\":\"Yes, we assist Gwalior families connected to the defence and government sector with tourist and visitor visa documentation.\"},{\"q\":\"Do you support UK student visa applications from Gwalior?\",\"a\":\"Yes, we support financial documentation and CAS-linked application filing for Gwalior students heading to UK universities.\"}]','active','2026-08-19 00:34:52','2026-08-19 00:34:52');
/*!40000 ALTER TABLE `visa_cities` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-09  7:44:53
