-- MySQL dump 10.13  Distrib 8.2.0, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ct_event_planning_233
-- ------------------------------------------------------
-- Server version	5.6.35-log

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
-- Current Database: `ct_event_planning_233`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ct_event_planning_233` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ct_event_planning_233`;

--
-- Table structure for table `tb_attendees`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_attendees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_attendees`
--

INSERT INTO `tb_attendees` VALUES (1,'2025-10-19 04:55:02','2025-10-19 04:55:02','Emily Chen','emily.chen@example.com','1112223333','1'),(2,'2025-10-19 04:55:02','2025-10-19 04:55:02','Kevin White','kevin.white@example.com','4445556666','2'),(3,'2025-10-19 04:55:02','2025-10-19 04:55:02','Sarah Lee','sarah.lee@example.com','7778889999','3'),(4,'2025-10-19 04:55:02','2025-10-19 04:55:02','David Kim','david.kim@example.com','3334445555','4'),(5,'2025-10-19 04:55:02','2025-10-19 04:55:02','Olivia Brown','olivia.brown@example.com','6667778888','5'),(6,'2025-10-19 04:55:02','2025-10-19 04:55:02','Ava Lee','ava.lee@example.com','9990001111','1'),(7,'2025-10-19 04:55:02','2025-10-19 04:55:02','Ethan Hall','ethan.hall@example.com','2223334444','2'),(8,'2025-10-19 04:55:12','2025-10-19 04:55:12','Alice Brown','alice.brown@example.com','111-222-3333','1'),(9,'2025-10-19 04:55:12','2025-10-19 04:55:12','Mike Davis','mike.davis@example.com','444-555-6666','1'),(10,'2025-10-19 04:55:12','2025-10-19 04:55:12','Emily Taylor','emily.taylor@example.com','777-888-9999','3'),(11,'2025-10-19 04:55:12','2025-10-19 04:55:12','David White','david.white@example.com','333-444-5555','2'),(12,'2025-10-19 04:55:12','2025-10-19 04:55:12','Sarah Lee','sarah.lee@example.com','666-777-8888','4');

--
-- Table structure for table `tb_event_tasks`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_event_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `task_name` varchar(255) DEFAULT NULL,
  `due_date` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_event_tasks`
--

INSERT INTO `tb_event_tasks` VALUES (1,'2025-10-19 04:55:02','2025-10-19 04:55:02','Book Venue','2024-02-20','Pending','1','1'),(2,'2025-10-19 04:55:02','2025-10-19 04:55:02','Send Invitations','2024-03-01','Pending','2','2'),(3,'2025-10-19 04:55:02','2025-10-19 04:55:02','Plan Catering','2024-03-05','Pending','3','3'),(4,'2025-10-19 04:55:02','2025-10-19 04:55:02','Coordinate Logistics','2024-03-10','Pending','4','1'),(5,'2025-10-19 04:55:02','2025-10-19 04:55:02','Promote Event','2024-03-15','Pending','5','2'),(6,'2025-10-19 04:55:12','2025-10-19 04:55:12','Setup','2024-02-20','Pending','1','1'),(7,'2025-10-19 04:55:12','2025-10-19 04:55:12','Marketing','2024-03-10','In Progress','1','2'),(8,'2025-10-19 04:55:12','2025-10-19 04:55:12','Catering','2024-05-25','Pending','3','1'),(9,'2025-10-19 04:55:12','2025-10-19 04:55:12','Logistics','2024-04-15','In Progress','2','3'),(10,'2025-10-19 04:55:12','2025-10-19 04:55:12','Promotion','2024-05-10','Pending','5','2');

--
-- Table structure for table `tb_events`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_events`
--

INSERT INTO `tb_events` VALUES (1,'2025-10-19 04:55:02','2025-10-19 04:55:02','Tech Conference','A technology conference for developers.','2024-03-15','2024-03-17','Upcoming','Conference'),(2,'2025-10-19 04:55:02','2025-10-19 11:03:52','Corporate Festival','A music festival featuring local artists.','2024-06-20','2024-06-22','Planning','Festival'),(3,'2025-10-19 04:55:02','2025-10-19 04:55:02','Wedding Reception','A wedding reception for 100 guests.','2024-08-01','2024-08-01','Upcoming','Reception'),(4,'2025-10-19 04:55:02','2025-10-19 04:55:02','Seminar','A seminar on marketing strategies.','2024-04-10','2024-04-10','Planning','Seminar'),(5,'2025-10-19 04:55:02','2025-10-19 04:55:02','Trade Show','A trade show for industry professionals.','2024-09-15','2024-09-17','Upcoming','Trade Show'),(6,'2025-10-19 04:55:12','2025-10-19 04:55:12','Tech Conference','A technology conference for developers.','2024-03-01','2024-03-03','Upcoming','Conference'),(7,'2025-10-19 04:55:12','2025-10-19 11:03:58','Corporate Festival','A music festival featuring local artists.','2024-06-01','2024-06-02','Upcoming','Festival'),(8,'2025-10-19 04:55:12','2025-10-19 04:55:12','Wedding','A wedding reception for 100 guests.','2024-08-01','2024-08-01','Upcoming','Wedding'),(9,'2025-10-19 04:55:12','2025-10-19 04:55:12','Seminar','A seminar on marketing strategies.','2024-04-01','2024-04-01','Upcoming','Seminar'),(10,'2025-10-19 04:55:12','2025-10-19 04:55:12','Trade Show','A trade show for industry professionals.','2024-05-01','2024-05-02','Upcoming','Trade Show');

--
-- Table structure for table `tb_logistics`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_logistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `catering` varchar(255) DEFAULT NULL,
  `audio_visual` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_logistics`
--

INSERT INTO `tb_logistics` VALUES (1,'2025-10-19 04:55:02','2025-10-19 04:55:02','Yes','Yes','1'),(2,'2025-10-19 04:55:02','2025-10-19 04:55:02','No','Yes','2'),(3,'2025-10-19 04:55:02','2025-10-19 04:55:02','Yes','No','3'),(4,'2025-10-19 04:55:12','2025-10-19 04:55:12','Yes','Yes','1'),(5,'2025-10-19 04:55:12','2025-10-19 04:55:12','No','Yes','2'),(6,'2025-10-19 04:55:12','2025-10-19 04:55:12','Yes','No','3');

--
-- Table structure for table `tb_marketing_promotions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_marketing_promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `promotion_name` varchar(255) DEFAULT NULL,
  `promotion_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_marketing_promotions`
--

INSERT INTO `tb_marketing_promotions` VALUES (1,'2025-10-19 04:55:02','2025-10-19 04:55:02','Social Media','Online','1'),(2,'2025-10-19 04:55:02','2025-10-19 04:55:02','Flyers','Offline','2'),(3,'2025-10-19 04:55:02','2025-10-19 04:55:02','Email Marketing','Online','3'),(4,'2025-10-19 04:55:12','2025-10-19 04:55:12','Social Media','Social Media','1'),(5,'2025-10-19 04:55:12','2025-10-19 04:55:12','Email Marketing','Email','1'),(6,'2025-10-19 04:55:12','2025-10-19 04:55:12','Flyers','Print','2');

--
-- Table structure for table `tb_post_event_evaluations`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_post_event_evaluations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `evaluation_date` varchar(255) DEFAULT NULL,
  `feedback` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_post_event_evaluations`
--

INSERT INTO `tb_post_event_evaluations` VALUES (1,'2025-10-19 04:55:02','2025-10-19 04:55:02','2024-03-18','The event was great!','1'),(2,'2025-10-19 04:55:02','2025-10-19 04:55:02','2024-06-23','The event was amazing!','2'),(3,'2025-10-19 04:55:02','2025-10-19 04:55:02','2024-08-02','The event was good.','3'),(4,'2025-10-19 04:55:12','2025-10-19 04:55:12','2024-03-05','Great conference!','1'),(5,'2025-10-19 04:55:12','2025-10-19 04:55:12','2024-06-05','Amazing festival!','2');

--
-- Table structure for table `tb_settings`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_settings`
--

INSERT INTO `tb_settings` VALUES (1,'2025-10-19 04:46:16','2025-10-19 04:46:16','Application Name','app_name','Event Planning'),(2,'2025-10-19 04:46:16','2025-10-19 04:46:16','Enable Authentication','auth_enabled','no');

--
-- Table structure for table `tb_speakers`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_speakers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_speakers`
--

INSERT INTO `tb_speakers` VALUES (1,'2025-10-19 04:55:02','2025-10-19 04:55:02','John Doe','A renowned expert in AI.','john.doe@example.com','1234567890','1'),(2,'2025-10-19 04:55:02','2025-10-19 04:55:02','Jane Smith','A well-known author.','jane.smith@example.com','9876543210','2'),(3,'2025-10-19 04:55:02','2025-10-19 04:55:02','Bob Johnson','A experienced entrepreneur.','bob.johnson@example.com','5551234567','3'),(4,'2025-10-19 04:55:02','2025-10-19 04:55:02','Alice Brown','A skilled developer.','alice.brown@example.com','7654321098','1'),(5,'2025-10-19 04:55:02','2025-10-19 04:55:02','Mike Davis','A talented artist.','mike.davis@example.com','9012345678','2'),(6,'2025-10-19 04:55:12','2025-10-19 04:55:12','John Doe','A renowned expert in technology.','john.doe@example.com','123-456-7890','1'),(7,'2025-10-19 04:55:12','2025-10-19 04:55:12','Jane Smith','A marketing strategist.','jane.smith@example.com','987-654-3210','4'),(8,'2025-10-19 04:55:12','2025-10-19 04:55:12','Bob Johnson','A musician and performer.','bob.johnson@example.com','555-123-4567','2');

--
-- Table structure for table `tb_users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` VALUES (1,'2025-10-19 04:46:15','2025-10-19 04:46:15','Admin User','admin','$2y$10$mY6pGnqtAUsyWv7dVQaJzu.6N48J9rlJhVfOqGq6SB31c3ukAH7X6','admin','active');

--
-- Table structure for table `tb_venues`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_venues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `venue_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_venues`
--

INSERT INTO `tb_venues` VALUES (1,'2025-10-19 04:55:02','2025-10-19 04:55:02','Convention Center','123 Main St','1000','1'),(2,'2025-10-19 04:55:02','2025-10-19 04:55:02','Park Area','456 Elm St','5000','2'),(3,'2025-10-19 04:55:02','2025-10-19 04:55:02','Hotel Ballroom','789 Oak St','2000','3'),(4,'2025-10-19 04:55:12','2025-10-19 04:55:12','Convention Center','123 Main St','1000','1'),(5,'2025-10-19 04:55:12','2025-10-19 04:55:12','Park','456 Park Ave','5000','2'),(6,'2025-10-19 04:55:12','2025-10-19 04:55:12','Hotel','789 Hotel Dr','500','3'),(7,'2025-10-19 11:06:38','2025-10-19 11:09:00','Banquet Halls','332 Elm St','500','1'),(8,'2025-10-19 11:07:04','2025-10-19 11:09:24','Sports Stadiums','443 Main St','10000','1'),(9,'2025-10-19 11:07:17','2025-10-19 11:09:35','Rooftop Terraces','866 Elm St','300','1'),(10,'2025-10-19 11:07:40','2025-10-19 11:09:46','Auditorium','987 Oak St','2000','1'),(11,'2025-10-19 11:08:26','2025-10-19 11:09:58','Restaurants ','655 Oak St','400','1');
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-30  1:54:12
