-- MySQL dump 10.13  Distrib 8.0.29, for macos12.2 (arm64)
--
-- Host: localhost    Database: upayments
-- ------------------------------------------------------
-- Server version	8.0.29

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
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sessionId` bigint DEFAULT NULL,
  `userId` int DEFAULT NULL,
  `productId` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (10,1234567,NULL,3,10,'2022-06-17 13:23:23','2022-06-17 15:07:08'),(12,12345678,NULL,12,7,NULL,'2022-06-17 16:25:00'),(21,1234567890,NULL,2,10,NULL,'2022-06-17 21:24:57'),(22,1234567890,NULL,1,3,'2022-06-17 18:28:49','2022-06-17 21:28:07'),(23,1234567890,4,1,10,'2022-06-17 19:58:24','2022-06-17 21:33:04');
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Computers','2022-06-16 17:48:59'),(2,'Mobile Phones','2022-06-16 17:48:59'),(3,'Fashion','2022-06-16 17:48:59'),(4,'Games & Toys','2022-06-16 17:48:59'),(5,'Books','2022-06-16 17:48:59'),(6,'Personal Care','2022-06-16 17:48:59'),(7,'Pharmacy','2022-06-16 17:48:59'),(8,'Stationery','2022-06-16 17:48:59');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (17,'App\\Models\\User',6,'accessToken','8b8c302263a9979e808b1a712218073547dd35465f7fb610eea4099738d8756c','[\"*\"]',NULL,'2022-06-17 15:21:24','2022-06-17 15:21:24'),(19,'App\\Models\\User',4,'accessToken','63909fdd0a863d6e8b91b733e6ba28f500ba09cda85ddcb0ccab3c2de18a4e24','[\"*\"]','2022-06-17 17:14:42','2022-06-17 15:32:46','2022-06-17 17:14:42'),(20,'App\\Models\\User',7,'accessToken','2be3559ac9b582f06c5de928a4e323c52986695f795f21cfc3bf2b533b40bb7a','[\"*\"]',NULL,'2022-06-17 16:38:20','2022-06-17 16:38:20'),(21,'App\\Models\\User',8,'accessToken','05e1f805f916ca694c865e5e7bd6b83943b802e29e7a725382529d65c74b373b','[\"*\"]',NULL,'2022-06-17 16:40:36','2022-06-17 16:40:36'),(22,'App\\Models\\User',4,'accessToken','493b21d5352ccadc63ac45ba20776bd6563be617c78d74fa6d7839f9f8149f2a','[\"*\"]',NULL,'2022-06-17 16:40:56','2022-06-17 16:40:56'),(23,'App\\Models\\User',9,'accessToken','453345350a57a80e3db3ed34cf600d129f202d96491db7a4800bcb69a21bc700','[\"*\"]',NULL,'2022-06-17 16:52:11','2022-06-17 16:52:11');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoryId` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `price` int NOT NULL,
  `description` mediumtext NOT NULL,
  `avatar` mediumtext NOT NULL,
  `developerEmail` varchar(320) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `FK_Products_Categories_idx` (`categoryId`),
  CONSTRAINT `FK_Products_Categories` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Macbook Air 2022',1200,'Discover Apple\'s thinest notebooks featuring fast processors, incredible graphics, It features a brilliant Retina display, new Magic Keyboard, Touch ID, and more. Same day delivery. Apple Premium reseller. Free shipping over 20 KD.','https://picsum.photos/id/1/200/300','sanngeetbargotra@gmail.com','2022-06-17 14:44:33','2022-06-16 19:12:22'),(2,2,'Iphone 13 Pro',999,'Apple iPhone 13 Pro smartphone. Announced Sep 2021. Features 6.1″ display, Apple A15 Bionic chipset, 3095 mAh battery, 1024 GB storage, 6 GB RAM','https://picsum.photos/id/1/200/300','sangeetofficial1@gmail.com',NULL,'2022-06-16 23:12:22'),(3,3,'T-shirt men, love code',5,'Black tshirt with white text </I love to code>','https://picsum.photos/id/1/200/300','fashionsangeet@gmail.com',NULL,'2022-06-16 23:06:25'),(5,4,'some random',500,'lorem ipsum','https://picsum.photos/id/1/200/300','hjello@gmail.com',NULL,'2022-06-17 10:52:36'),(6,8,'Uniball Pen Blue',2,'Awesome Blue Pen','https://picsum.photos/id/1/200/300','pens@gmail.com',NULL,'2022-06-17 11:13:05'),(7,8,'Natraj Pencil',1,'Beautiful Pencil for kids','https://picsum.photos/id/1/200/300','pencil@gmail.com',NULL,'2022-06-17 13:37:55'),(8,8,'Eraser',1,'Beautiful Eraser for kids','https://picsum.photos/id/1/200/300','eraser@gmail.com',NULL,'2022-06-17 13:58:35'),(9,8,'Notebook',1,'Beautiful notebook for kids','https://picsum.photos/id/1/200/300','notebook@gmail.com',NULL,'2022-06-17 14:42:57'),(10,8,'Sharpner',1,'Beautiful notebook for kids','https://picsum.photos/id/1/200/300','notebook@gmail.com',NULL,'2022-06-17 14:44:54'),(11,8,'Fountain Pen',1,'Beautiful Fountain Pen for kids','https://picsum.photos/id/1/200/300','pens@gmail.com',NULL,'2022-06-17 14:46:07'),(12,8,'Gel Pel',1,'Beautiful Gel Pen for kids','https://picsum.photos/id/1/200/300','pens@gmail.com',NULL,'2022-06-17 14:46:37'),(13,8,'Drawing sheets',1,'Beautiful Drawing sheets','https://picsum.photos/id/1/200/300','stationery@gmail.com',NULL,'2022-06-17 14:47:21'),(16,4,'1',1,'Beautiful Carom','https://picsum.photos/id/1/200/300','Carom@gmail.com',NULL,'2022-06-17 23:02:32'),(17,4,'Playstation 5',180,'Beautiful Playstation','https://picsum.photos/id/1/200/300','ps@gmail.com','2022-06-17 20:14:42','2022-06-17 23:04:22');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Siddharth Balgotra','sid@gmail.com','$2y$10$INb50aGXj7ZpR9qNzCcGv.y/QOZWtczKCyR.B4dXIdUg.aFBQyjjq','2022-06-17 07:56:21','2022-06-17 07:56:21'),(2,'Sangeet Bargotra','sangeet@gmail.com','$2y$10$ErwkG55Z1zh/7GcEkj8YL.2O1NOKSOQt7ajWcHLf96baZiqbDZsC2','2022-06-17 07:59:48','2022-06-17 07:59:48'),(3,'Rahul sharma','rahul@gmail.com','$2y$10$JjnCNKdevuOk7S14dyNZcuGuSDOnkHas5W5lG2CjyB7xHDa4OGtq2','2022-06-17 08:00:34','2022-06-17 08:00:34'),(4,'Karan sharma','karan@gmail.com','$2y$10$xx1pIlPZT4XMndAsGdoJ1eZT6IHpI2QpBS2F2TkrPu.IKKT/grRRa','2022-06-17 08:00:40','2022-06-17 08:00:40'),(5,'ahmed khan','ahmed@gmail.com','$2y$10$tCv5lGXwqtj4c6rYMVhz..w7Uj97/syjNUvOP1M4wqrNeB6KrQqaa','2022-06-17 08:00:51','2022-06-17 08:00:51'),(6,'Rashmi Patel','rashmi@gmail.com','$2y$10$kfnsO65nzjA2/VTvgF9SxOhDNxyzOSXg2aVaAReXoFBT0EXmvkjk6','2022-06-17 15:21:24','2022-06-17 15:21:24'),(7,'Abdullah M','abd@gmail.com','$2y$10$b0NXgNeMwsDfDTDDNK7nt.M/C95V3s97PWM09FHP.8YwVqEyK5VQK','2022-06-17 16:38:20','2022-06-17 16:38:20'),(8,'Abdou M','abdou@gmail.com','$2y$10$c4mKNFz0uq1V3y.ilSDR7eROJ6.a0NTEdmabGE7pCsvrfOVWO6G3W','2022-06-17 16:40:36','2022-06-17 16:40:36'),(9,'Ummer K','sadfm@sdf','$2y$10$1TC.IX2WEuib/LoY4MV0g..29OdZ7S3wWpjGDuGi35K2vE3otxnJq','2022-06-17 16:52:11','2022-06-17 16:52:11');
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

-- Dump completed on 2022-06-17 23:24:21
