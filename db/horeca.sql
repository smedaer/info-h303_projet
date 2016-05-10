-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: horeca
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Cafes`
--

DROP TABLE IF EXISTS `Cafes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cafes` (
  `Cafe_ID` int(10) unsigned NOT NULL DEFAULT '0',
  `Fumeur` tinyint(1) DEFAULT NULL,
  `Restauration` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`Cafe_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cafes`
--

LOCK TABLES `Cafes` WRITE;
/*!40000 ALTER TABLE `Cafes` DISABLE KEYS */;
/*!40000 ALTER TABLE `Cafes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Commentaires`
--

DROP TABLE IF EXISTS `Commentaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Commentaires` (
  `Com_ID` int(10) unsigned NOT NULL DEFAULT '0',
  `Com` text,
  `Score` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`Com_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Commentaires`
--

LOCK TABLES `Commentaires` WRITE;
/*!40000 ALTER TABLE `Commentaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `Commentaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Descriptions`
--

DROP TABLE IF EXISTS `Descriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Descriptions` (
  `Des_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Auteur` varchar(20) DEFAULT NULL,
  `Creation_date` date DEFAULT NULL,
  `User_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`Des_ID`),
  UNIQUE KEY `Des_ID` (`Des_ID`),
  KEY `User_ID` (`User_ID`),
  CONSTRAINT `Descriptions_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Descriptions`
--

LOCK TABLES `Descriptions` WRITE;
/*!40000 ALTER TABLE `Descriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `Descriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Etablissement`
--

DROP TABLE IF EXISTS `Etablissement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Etablissement` (
  `Eta_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `AdRue` varchar(50) DEFAULT NULL,
  `AdNumero` smallint(5) unsigned DEFAULT NULL,
  `AdCodePostal` smallint(5) unsigned DEFAULT NULL,
  `Longitude` smallint(5) unsigned DEFAULT NULL,
  `Latitude` smallint(5) unsigned DEFAULT NULL,
  `Tel` int(10) unsigned DEFAULT NULL,
  `Des_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`Eta_ID`),
  UNIQUE KEY `Eta_ID` (`Eta_ID`),
  KEY `Des_ID` (`Des_ID`),
  CONSTRAINT `Etablissement_ibfk_1` FOREIGN KEY (`Des_ID`) REFERENCES `Descriptions` (`Des_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Etablissement`
--

LOCK TABLES `Etablissement` WRITE;
/*!40000 ALTER TABLE `Etablissement` DISABLE KEYS */;
/*!40000 ALTER TABLE `Etablissement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Hotels`
--

DROP TABLE IF EXISTS `Hotels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Hotels` (
  `Hot_ID` int(10) unsigned NOT NULL DEFAULT '0',
  `Prix` smallint(5) unsigned DEFAULT NULL,
  `Chambres` smallint(5) unsigned DEFAULT NULL,
  `Etoiles` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`Hot_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Hotels`
--

LOCK TABLES `Hotels` WRITE;
/*!40000 ALTER TABLE `Hotels` DISABLE KEYS */;
/*!40000 ALTER TABLE `Hotels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Labels`
--

DROP TABLE IF EXISTS `Labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Labels` (
  `Lab_ID` int(10) unsigned NOT NULL DEFAULT '0',
  `Label` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`Lab_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Labels`
--

LOCK TABLES `Labels` WRITE;
/*!40000 ALTER TABLE `Labels` DISABLE KEYS */;
/*!40000 ALTER TABLE `Labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Restaurants`
--

DROP TABLE IF EXISTS `Restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Restaurants` (
  `Rest_ID` int(10) unsigned NOT NULL DEFAULT '0',
  `Prix` smallint(5) unsigned DEFAULT NULL,
  `Couverts` smallint(5) unsigned DEFAULT NULL,
  `Emporter` tinyint(1) DEFAULT NULL,
  `Livraison` tinyint(1) DEFAULT NULL,
  `Fermeture` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`Rest_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Restaurants`
--

LOCK TABLES `Restaurants` WRITE;
/*!40000 ALTER TABLE `Restaurants` DISABLE KEYS */;
/*!40000 ALTER TABLE `Restaurants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `User_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) DEFAULT NULL,
  `Email` varchar(40) DEFAULT NULL,
  `PSWD` varchar(20) DEFAULT NULL,
  `Creation_date` date DEFAULT NULL,
  `Admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`User_ID`),
  UNIQUE KEY `User_ID` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-08 18:35:36
