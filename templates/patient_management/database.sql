-- MySQL dump 10.13  Distrib 8.2.0, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ct_patient_management_234
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
-- Current Database: `ct_patient_management_234`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ct_patient_management_234` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ct_patient_management_234`;

--
-- Table structure for table `tb_appointments`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `patient` varchar(255) DEFAULT NULL,
  `appointment_date` varchar(255) DEFAULT NULL,
  `appointment_time` varchar(255) DEFAULT NULL,
  `doctor` varchar(255) DEFAULT NULL,
  `appointment_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_appointments`
--

INSERT INTO `tb_appointments` VALUES (1,'2025-10-20 05:36:26','2025-10-20 05:36:26','1','2024-03-01','2024-03-01 10:00:00','1','Checkup'),(2,'2025-10-20 05:36:26','2025-10-20 05:36:26','2','2024-03-05','2024-03-05 11:00:00','2','Fever'),(3,'2025-10-20 05:36:26','2025-10-20 05:36:26','3','2024-03-10','2024-03-10 12:00:00','3','Surgery'),(4,'2025-10-20 05:36:26','2025-10-20 05:36:26','4','2024-03-15','2024-03-15 13:00:00','4','Checkup'),(5,'2025-10-20 05:36:26','2025-10-20 05:36:26','5','2024-03-20','2024-03-20 14:00:00','5','Medication'),(6,'2025-10-20 05:36:26','2025-10-20 05:36:26','6','2024-03-25','2024-03-25 15:00:00','6','Fever'),(7,'2025-10-20 05:36:26','2025-10-20 05:36:26','7','2024-03-30','2024-03-30 16:00:00','7','Surgery'),(8,'2025-10-20 05:36:26','2025-10-20 05:36:26','8','2024-04-01','2024-04-01 17:00:00','8','Checkup'),(9,'2025-10-20 05:36:26','2025-10-20 05:36:26','9','2024-04-05','2024-04-05 18:00:00','9','Medication'),(10,'2025-10-20 05:36:26','2025-10-20 05:36:26','10','2024-04-10','2024-04-10 19:00:00','10','Fever');

--
-- Table structure for table `tb_doctors`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `doctor_name` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_doctors`
--

INSERT INTO `tb_doctors` VALUES (1,'2025-10-20 05:36:26','2025-10-20 05:36:26','Dr. Smith','Cardiologist','1234567890','smith@example.com'),(2,'2025-10-20 05:36:26','2025-10-20 05:36:26','Dr. Johnson','Neurologist','9876543210','johnson@example.com'),(3,'2025-10-20 05:36:26','2025-10-20 05:36:26','Dr. Thompson','Oncologist','5551234567','thompson@example.com'),(4,'2025-10-20 05:36:26','2025-10-20 05:36:26','Dr. Davis','Pediatrician','7654321098','davis@example.com'),(5,'2025-10-20 05:36:26','2025-10-20 05:36:26','Dr. Miller','Dermatologist','9012345678','miller@example.com'),(6,'2025-10-20 05:36:26','2025-10-20 05:36:26','Dr. Wilson','Psychiatrist','1112223333','wilson@example.com'),(7,'2025-10-20 05:36:26','2025-10-20 05:36:26','Dr. Anderson','Surgeon','4445556666','anderson@example.com'),(8,'2025-10-20 05:36:26','2025-10-20 05:36:26','Dr. Thomas','Anesthesiologist','7778889999','thomas@example.com'),(9,'2025-10-20 05:36:26','2025-10-20 05:36:26','Dr. Jackson','Radiologist','3332221111','jackson@example.com'),(10,'2025-10-20 05:36:26','2025-10-20 05:36:26','Dr. White','Ophthalmologist','6667778888','white@example.com');

--
-- Table structure for table `tb_patients`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_patients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `patient_name` varchar(255) DEFAULT NULL,
  `date_of_birth` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `medical_history` varchar(255) DEFAULT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_patients`
--

INSERT INTO `tb_patients` VALUES (1,'2025-10-20 05:36:26','2025-10-20 05:36:26','John Doe','1990-01-01','1234567890','john@example.com','123 Main St','A Positive','Hypertension','Penicillin'),(2,'2025-10-20 05:36:26','2025-10-20 05:36:26','Jane Smith','1995-06-01','9876543210','jane@example.com','456 Elm St','O Negative','Diabetes','None'),(3,'2025-10-20 05:36:26','2025-10-20 05:36:26','Bob Johnson','1980-03-01','5551234567','bob@example.com','789 Oak St','B Positive','Heart Disease','Aspirin'),(4,'2025-10-20 05:36:26','2025-10-20 05:36:26','Maria Rodriguez','1992-09-01','7654321098','maria@example.com','321 Pine St','AB Negative','Asthma','None'),(5,'2025-10-20 05:36:26','2025-10-20 05:36:26','David Lee','1985-11-01','9012345678','david@example.com','901 Maple St','A Negative','High Cholesterol','Penicillin'),(6,'2025-10-20 05:36:26','2025-10-20 05:36:26','Emily Chen','1998-05-01','1112223333','emily@example.com','234 Cedar St','O Positive','None','None'),(7,'2025-10-20 05:36:26','2025-10-20 05:36:26','Kevin Brown','1982-07-01','4445556666','kevin@example.com','567 Cypress St','B Negative','Kidney Disease','Aspirin'),(8,'2025-10-20 05:36:26','2025-10-20 05:36:26','Sarah Taylor','1996-02-01','7778889999','sarah@example.com','890 Walnut St','AB Positive','Thyroid Disorder','None'),(9,'2025-10-20 05:36:26','2025-10-20 05:36:26','Michael Kim','1988-10-01','3332221111','michael@example.com','345 Spruce St','A Positive','Gout','Penicillin'),(10,'2025-10-20 05:36:26','2025-10-20 05:36:26','Laura Davis','1991-04-01','6667778888','laura@example.com','678 Fir St','O Negative','Cystic Fibrosis','None');

--
-- Table structure for table `tb_payments`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `patient` varchar(255) DEFAULT NULL,
  `payment_date` varchar(255) DEFAULT NULL,
  `payment_amount` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_payments`
--

INSERT INTO `tb_payments` VALUES (1,'2025-10-20 05:36:26','2025-10-20 05:36:26','1','2024-03-01','100.00','Cash'),(2,'2025-10-20 05:36:26','2025-10-20 05:36:26','2','2024-03-05','200.00','Credit'),(3,'2025-10-20 05:36:26','2025-10-20 05:36:26','3','2024-03-10','50.00','Insurance'),(4,'2025-10-20 05:36:26','2025-10-20 05:36:26','4','2024-03-15','150.00','Cash'),(5,'2025-10-20 05:36:26','2025-10-20 05:36:26','5','2024-03-20','300.00','Credit'),(6,'2025-10-20 05:36:26','2025-10-20 05:36:26','6','2024-03-25','75.00','Insurance'),(7,'2025-10-20 05:36:26','2025-10-20 05:36:26','7','2024-03-30','250.00','Cash'),(8,'2025-10-20 05:36:26','2025-10-20 05:36:26','8','2024-04-01','120.00','Credit'),(9,'2025-10-20 05:36:26','2025-10-20 05:36:26','9','2024-04-05','180.00','Insurance'),(10,'2025-10-20 05:36:26','2025-10-20 05:36:26','10','2024-04-10','220.00','Cash');

--
-- Table structure for table `tb_prescriptions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_prescriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `patient` varchar(255) DEFAULT NULL,
  `doctor` varchar(255) DEFAULT NULL,
  `prescription_date` varchar(255) DEFAULT NULL,
  `medication` varchar(255) DEFAULT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_prescriptions`
--

INSERT INTO `tb_prescriptions` VALUES (1,'2025-10-20 05:36:26','2025-10-20 05:36:26','1','1','2024-03-01','Aspirin','81mg'),(2,'2025-10-20 05:36:26','2025-10-20 05:36:26','2','2','2024-03-05','Ibuprofen','200mg'),(3,'2025-10-20 05:36:26','2025-10-20 05:36:26','3','3','2024-03-10','Lisinopril','10mg'),(4,'2025-10-20 05:36:26','2025-10-20 05:36:26','4','4','2024-03-15','Amlodipine','5mg'),(5,'2025-10-20 05:36:26','2025-10-20 05:36:26','5','5','2024-03-20','Metformin','500mg'),(6,'2025-10-20 05:36:26','2025-10-20 05:36:26','6','6','2024-03-25','Atorvastatin','20mg'),(7,'2025-10-20 05:36:26','2025-10-20 05:36:26','7','7','2024-03-30','Citalopram','20mg'),(8,'2025-10-20 05:36:26','2025-10-20 05:36:26','8','8','2024-04-01','Omeprazole','20mg'),(9,'2025-10-20 05:36:26','2025-10-20 05:36:26','9','9','2024-04-05','Acetaminophen','325mg'),(10,'2025-10-20 05:36:26','2025-10-20 05:36:26','10','10','2024-04-10','Cetirizine','10mg');

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

INSERT INTO `tb_settings` VALUES (1,'2025-10-20 05:35:45','2025-10-20 05:35:45','Application Name','app_name','Patient Management'),(2,'2025-10-20 05:35:45','2025-10-20 05:35:45','Enable Authentication','auth_enabled','no');

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

INSERT INTO `tb_users` VALUES (1,'2025-10-20 05:35:45','2025-10-20 05:35:45','Admin User','admin','$2y$10$meySgsHyR174DtqzPrRAYO4XuPKroi4RfyoFMFd8NYHwTo4ZPq73e','admin','active');
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-20  5:45:05
