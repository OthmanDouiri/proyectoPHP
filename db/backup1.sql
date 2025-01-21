-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: auth_db
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.24.04.1

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
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `User` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'rusben','rusben@elpuig.xeill.net','$2y$10$aDrd9uFrnJgyDBwoTtUqZOl0v/t8jWNP4D2.nzauiwDldKUAPAZxe','','2024-10-29 15:48:50','user'),(2,'othman','enamhto@sdf.com','$2y$10$vGCMNeV6qJNqiz1ojf2UeO4P2TSAAQmB03D0jPLd8jKCxNBruxyPO','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhdXRoLmxvY2FsIiwiaWF0IjoxNzM3NDYwNjM3LCJleHAiOjE3MzgwNjU0MzcsInVzZXJJZCI6MiwidXNlcm5hbWUiOiJvdGhtYW4iLCJyb2xlIjoidXNlciJ9.JPZOHPMOSUTZMr98BB06yuxIBfjoKueXzpcckA3uGqk','2024-11-01 15:56:34','user'),(3,'oth','jksnfjskdf@gmail.com','$2y$10$DYsbMrVjrHxGpWSMFi4Na.aFs6l9DV12rgHn0MB9XJuszCVjdP2Z.','','2024-11-01 16:01:36','user'),(4,'ruben','othman@gmail.com','$2y$10$lZIjAHhXXLBFOx48dLKaeOHsK9GY9lYW9I7We2wstHJebZYrOCTiG','0dadd43a46d13991fad5e7d848b89723','2024-11-01 23:00:37','user'),(6,'admin','admin@gmail.com','$2y$10$/hx5wiUEpj64xgmjhdhHyO6q/H8uj5phm9X1R9fG3/02Y2XDKaG7q','','2024-11-11 16:01:00','user'),(7,'ahmed','ahmed@gmail.com','$2y$10$k1ORZqgOeKXGmFDaDSxMF.FH1kBghCzv578Wp7Fv47Pt0r4YnTGDm','4ef4a7a0abfaa255b69bc948da5d5b95','2024-11-12 21:26:00','user'),(8,'teest','teest@gmail.com','$2y$10$XmwA/PNglLQUSMeFUFyerekwLeZBf0/oqKKv.sFBHk8pQVTq5RnT.','bc53e98e3e1344eac419c054630374d1','2024-11-24 16:46:06','user'),(9,'test','tes@gmail.com','$2y$10$u..nX3LJPQHqYVshNPAZKel35fjezQ7Nwup5O9SpxLClTftEjAlyS','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhdXRoLmxvY2FsIiwiaWF0IjoxNzM3MTY0ODUzLCJleHAiOjE3Mzc3Njk2NTMsInVzZXJJZCI6OSwidXNlcm5hbWUiOiJ0ZXN0Iiwicm9sZSI6InVzZXIifQ.r4iglRlB90u6p8gzU_wnWzoJ3pSsKd3h_952fXXdZX0','2024-12-09 14:57:53','user'),(10,'othman2','othman2@gmail.com','$2y$10$1nh4nB8quzrfy3zwIOQFJ.4fIfjYxgp0nn0oS/dzEkoBDevmLDjnS','9606408a11ef58d5bfc2ed70d3534d60','2025-01-09 15:55:48','user'),(11,'testachraf','testachraf@gmail.com','$2y$10$h.nj9bZbbiembebdBCp9e.GNyJoGotnJ304hJyqxMxAMAFB6yvEBW','','2025-01-16 15:17:00','user'),(12,'ok','ok@gmail.com','$2y$10$oitVBB1LXiWQu2rHuiWF3uD9IeZBtYVyOL3VoV16shStIMnNDIWb2','','2025-01-18 00:06:55','user'),(13,'test12','test1212@gmail.com','$2y$10$/SKRodh/J7H3b.d7cnBTgOvfEnejCMbW3dv2NlQx2VL3waS83Vz5.','','2025-01-18 00:08:37','user');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marca`
--

DROP TABLE IF EXISTS `marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `marca` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` VALUES (1,'Apple'),(2,'Samsung'),(3,'Xiaomi'),(4,'Google');
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phone`
--

DROP TABLE IF EXISTS `phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phone` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `marca_id` int DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_phone_marca` (`marca_id`),
  CONSTRAINT `fk_phone_marca` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=409 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone`
--

LOCK TABLES `phone` WRITE;
/*!40000 ALTER TABLE `phone` DISABLE KEYS */;
INSERT INTO `phone` VALUES (389,'Apple iPhone 13 128GB - Rosa (Reacondicionado)','379€',1,'https://m.media-amazon.com/images/I/61CGRxr55fL._AC_UL320_.jpg'),(390,'Apple iPhone 13 128GB - Verde (Reacondicionado)','379€',1,'https://m.media-amazon.com/images/I/61LLhELDAbL._AC_UL320_.jpg'),(391,'Apple iPhone 13 128GB - Azul (Reacondicionado)','379€',1,'https://m.media-amazon.com/images/I/71b+DwdvTrL._AC_UL320_.jpg'),(392,'Apple iPhone 12, 128GB, Azul - (Reacondicionado)','315€',1,'https://m.media-amazon.com/images/I/71ZOtNdaZCL._AC_UL320_.jpg'),(393,'Apple iPhone 13, 128GB, Rosa - (Reacondicionado)','379€',1,'https://m.media-amazon.com/images/I/61CGRxr55fL._AC_UL320_.jpg'),(394,'Apple iPhone SE 2 Gen 64GB - Blanco (Reacondicionado)','148€',1,'https://m.media-amazon.com/images/I/71FEmBuwOjL._AC_UL320_.jpg'),(395,'Xiaomi C51 Telefonos Moviles Libres - 18GB RAM + 128GB ROM/SD 1TB, 6.8\" Pantalla HD+ 90Hz Telefono Movil, Batería 5150mAh, Cámara 13MP Android 13 Smartphone, 4G Dual SIM, Face ID/Fingerprint, Azul','126€',3,'https://m.media-amazon.com/images/I/91VxM0e9zVL._AC_UL320_.jpg'),(396,'Xiaomi Smartphone,Moviles Android 14,6.75\" Pantalla HD+90Hz Teléfono Móvil Libres,8GB+128GB/1TB, Batería 5000mAh 13MP+8MP,Telefonos Moviles Dual Sim,Face ID/Fingerprint/OTG/GPS,2.4G/5G WIFI Verde','124€',3,'https://m.media-amazon.com/images/I/6142buHFecL._AC_UL320_.jpg'),(397,'Google Pixel 8a - Smartphone Android Libre con Cámara Pixel Avanzada, batería de 24 Horas de duración y potentes Funciones de Seguridad - Celeste, 128GB','399€',4,'https://m.media-amazon.com/images/I/71Kb1+U1zwL._AC_UL320_.jpg'),(398,'Apple iPhone 15 (128 GB) - Azul','789€',1,'https://m.media-amazon.com/images/I/71vKy5OHuPL._AC_UL320_.jpg'),(399,'Apple iPhone 16 de 128 GB: Smartphone 5G con Control de Cámara, Chip A18 y un subidón en autonomía. Compatible con los AirPods; Negro','887€',1,'https://m.media-amazon.com/images/I/619HAuZ95QL._AC_UL320_.jpg'),(400,'Apple iPhone 13 (128 GB) - en Blanco Estrella','529€',1,'https://m.media-amazon.com/images/I/61HNv77Xe4L._AC_UL320_.jpg'),(401,'Apple iPhone 15 128 GB - Negro (Reacondicionado)','579€',1,'https://m.media-amazon.com/images/I/61eEYLATF9L._AC_UL320_.jpg'),(402,'Apple iPhone 11, 64GB, Negro (Reacondicionado)','236€',1,'https://m.media-amazon.com/images/I/61XqEVC8Z4L._AC_UL320_.jpg'),(403,'Apple iPhone 12 mini, 128GB, Negro - (Reacondicionado)','273€',1,'https://m.media-amazon.com/images/I/71uuDYxn3XL._AC_UL320_.jpg'),(404,'Apple iPhone XR 64GB - Negro (Reacondicionado)','215€',1,'https://m.media-amazon.com/images/I/61cDgjwmmcL._AC_UL320_.jpg'),(405,'Apple iPhone 14 Plus (128 GB) - Azul','769€',1,'https://m.media-amazon.com/images/I/61BGE6iu4AL._AC_UL320_.jpg'),(406,'Apple iPhone 11 128GB - Negro - Desbloqueado (Reacondicionado)','279€',1,'https://m.media-amazon.com/images/I/71B62qVvfML._AC_UL320_.jpg'),(407,'Apple iPhone 13 Pro, 128GB, Grafito - (Reacondicionado)','499€',1,'https://m.media-amazon.com/images/I/61Z9q1+EINL._AC_UL320_.jpg'),(408,'hohem iSteady M7 Estabilizador de Móvil Gimbal para iPhone, Luz de Relleno magnética AI Tracker, Mando a Distancia táctil Desmontable, Alargadera incorporada, 500g Carga útil, Gimbal para Móvil','299€',2,'https://m.media-amazon.com/images/I/71AifusyMkL._AC_UL320_.jpg');
/*!40000 ALTER TABLE `phone` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-21 14:30:18
