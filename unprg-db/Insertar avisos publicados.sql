-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: unprg-web
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.9-MariaDB

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
-- Dumping data for table `archivo`
--

LOCK TABLES `archivo` WRITE;
/*!40000 ALTER TABLE `archivo` DISABLE KEYS */;
INSERT INTO `archivo` VALUES (1,'Comunicado','img','/frontend/avisos/c4ca4238a0b923820dcc509a6f75849b.jpg','2016-01-26 17:00:00'),(2,'Acta 001-2016-VRINV','doc','/frontend/avisos/c81e728d9d4c2f636f067f89cc14862c.pdf','2016-01-28 17:00:00'),(3,'http://unprg.edu.pe/resexm/index.html','link','/frontend/avisos/eccbc87e4b5ce2fe28308fd9f2a7baf3.jpg','2016-02-07 17:00:00'),(4,'16/documentos/','link','/frontend/avisos/a87ff679a2f3e71d9181a67b7542122c.jpg','2016-02-08 17:00:00'),(9,'UNPRG_Invitacion','img','/frontend/avisos/45c48cce2e2d7fbdea1afc51c7c6ad26.jpeg','2016-02-23 17:34:37'),(10,'unprg_comunicado','img','/frontend/avisos/d3d9446802a44259755d38e6d163e820.jpeg','2016-02-23 17:37:06');
/*!40000 ALTER TABLE `archivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `aviso`
--

LOCK TABLES `aviso` WRITE;
/*!40000 ALTER TABLE `aviso` DISABLE KEYS */;
INSERT INTO `aviso` VALUES (1,'2016-01-26 17:00:00','La Oficina General de Recursos Humanos se dirige al personal de trabajadores de la UNPRG para expresar disculpas',0,0,1,1,0,1,1),(2,'2016-01-28 17:00:00','Acta N° 001-2016-VRINV Reunión de Trabajo del Vicerrectorado de Investigación',0,0,1,1,0,2,1),(3,'2016-02-07 17:00:00','Resultados del Primer Parcial del Centro Pre UNPRG Ciclo 2016-I',1,0,1,1,0,3,1),(4,'2016-02-08 17:00:00','El Vicerrectorado de Investigación, en su proceso de implementación, pone a su disposición los siguientes documentos',0,1,1,1,0,4,1),(9,'2016-02-23 17:34:37','CEREMONIA DE ASUNCIÓN DEL RECTOR DE LA UNPRG (Periodo 2016-2020)',0,1,1,1,0,9,1),(10,'2016-02-23 17:37:06','El Rector, ViceRectores, Decanos y funcionarios de la nueva administración de la UNPRG, con el pleno respaldo que la ley otorga y en primacía del principio de autoridad, hace de conocimiento a la comunidad universitaria.',0,1,1,1,0,10,1);
/*!40000 ALTER TABLE `aviso` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-23 12:56:18
