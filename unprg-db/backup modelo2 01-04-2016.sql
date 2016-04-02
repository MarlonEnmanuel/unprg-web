CREATE DATABASE  IF NOT EXISTS `unprg-web2` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `unprg-web2`;
-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: 192.168.0.11    Database: unprg-web2
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.10-MariaDB

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
-- Table structure for table `agenda`
--

DROP TABLE IF EXISTS `agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenda` (
  `idAgenda` int(11) NOT NULL AUTO_INCREMENT,
  `fchInicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titulo` text COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `lugar` text COLLATE utf8_unicode_ci,
  `mapa` text COLLATE utf8_unicode_ci,
  `organizador` text COLLATE utf8_unicode_ci,
  `estado` tinyint(1) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idAgenda`),
  KEY `fk_agenda_usuario1_idx` (`idUsuario`),
  CONSTRAINT `fk_agenda_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda`
--

LOCK TABLES `agenda` WRITE;
/*!40000 ALTER TABLE `agenda` DISABLE KEYS */;
/*!40000 ALTER TABLE `agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archivo`
--

DROP TABLE IF EXISTS `archivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archivo` (
  `idArchivo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'nombre del archivo, si el type es igual a link, entonces este campo contiene el enlace a la pagina',
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'tipo del archivo, pdf, imagen, o enlace(link)',
  `rutaArch` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'ruta del archivo a mostrar',
  `fchReg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de registro del archivo',
  PRIMARY KEY (`idArchivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archivo`
--

LOCK TABLES `archivo` WRITE;
/*!40000 ALTER TABLE `archivo` DISABLE KEYS */;
/*!40000 ALTER TABLE `archivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aviso`
--

DROP TABLE IF EXISTS `aviso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aviso` (
  `idAviso` int(11) NOT NULL AUTO_INCREMENT,
  `fchReg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha de registro del aviso',
  `titulo` text COLLATE utf8_unicode_ci NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'descripcion del aviso',
  `destacado` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'si es true, el aviso parpadea para llamar la atencion',
  `emergente` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indica si el aviso se muestro al cargar la pagina',
  `estado` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'indica si el aviso está activo o inactivo',
  `link` text COLLATE utf8_unicode_ci,
  `idUsuario` int(11) NOT NULL,
  `idImagen` int(11) NOT NULL,
  PRIMARY KEY (`idAviso`),
  KEY `fk_aviso_usuario1_idx` (`idUsuario`),
  KEY `fk_aviso_imagen1_idx` (`idImagen`),
  CONSTRAINT `fk_aviso_imagen1` FOREIGN KEY (`idImagen`) REFERENCES `imagen` (`idImagen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_aviso_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aviso`
--

LOCK TABLES `aviso` WRITE;
/*!40000 ALTER TABLE `aviso` DISABLE KEYS */;
INSERT INTO `aviso` VALUES (2,'2016-04-02 00:54:26','PRUEBAsdffffffdffffffff','0',1,1,1,NULL,1,7),(3,'2016-04-02 00:58:43','PRUEBA','0',1,1,1,'0',1,8),(4,'2016-04-02 01:36:15','PRUEBA','charizar charizar charizar',1,1,1,'fghdfggd',1,9);
/*!40000 ALTER TABLE `aviso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos`
--

DROP TABLE IF EXISTS `documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documentos` (
  `idDocumentos` int(11) NOT NULL AUTO_INCREMENT,
  `fchReg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ruta` text COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `validacion` tinyint(1) DEFAULT '1',
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idDocumentos`),
  KEY `fk_documentos_usuario1_idx` (`idUsuario`),
  CONSTRAINT `fk_documentos_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos`
--

LOCK TABLES `documentos` WRITE;
/*!40000 ALTER TABLE `documentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galeria`
--

DROP TABLE IF EXISTS `galeria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galeria` (
  `idNoticia` int(11) NOT NULL,
  `idImagen` int(11) NOT NULL,
  KEY `fk_galeria_noticia1_idx` (`idNoticia`),
  KEY `fk_galeria_imagen1_idx` (`idImagen`),
  CONSTRAINT `fk_galeria_imagen1` FOREIGN KEY (`idImagen`) REFERENCES `imagen` (`idImagen`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_galeria_noticia1` FOREIGN KEY (`idNoticia`) REFERENCES `noticia` (`idNoticia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galeria`
--

LOCK TABLES `galeria` WRITE;
/*!40000 ALTER TABLE `galeria` DISABLE KEYS */;
/*!40000 ALTER TABLE `galeria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagen`
--

DROP TABLE IF EXISTS `imagen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagen` (
  `idImagen` int(11) NOT NULL AUTO_INCREMENT,
  `fchReg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ruta` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idImagen`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagen`
--

LOCK TABLES `imagen` WRITE;
/*!40000 ALTER TABLE `imagen` DISABLE KEYS */;
INSERT INTO `imagen` VALUES (7,'2016-04-02 00:54:25','img2aaaaaa','/uploads/images/8f14e45fceea167a5a36dedd4bea2543.jpeg'),(8,'2016-04-02 00:58:43','fondo','/uploads/images/c9f0f895fb98ab9159f51fd0297e236d.jpeg'),(9,'2016-04-02 01:36:15','img1a','/uploads/images/45c48cce2e2d7fbdea1afc51c7c6ad26.jpeg');
/*!40000 ALTER TABLE `imagen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticia`
--

DROP TABLE IF EXISTS `noticia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noticia` (
  `idNoticia` int(11) NOT NULL AUTO_INCREMENT,
  `fchReg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titulo` text COLLATE utf8_unicode_ci NOT NULL,
  `subtitulo` text COLLATE utf8_unicode_ci NOT NULL,
  `cuerpo` text COLLATE utf8_unicode_ci NOT NULL,
  `extras` text COLLATE utf8_unicode_ci NOT NULL,
  `validacion` tinyint(1) DEFAULT '1',
  `idImagen` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idNoticia`),
  KEY `fk_noticia_usuario1_idx` (`idUsuario`),
  KEY `fk_noticia_imagen1_idx` (`idImagen`),
  CONSTRAINT `fk_noticia_imagen1` FOREIGN KEY (`idImagen`) REFERENCES `imagen` (`idImagen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_noticia_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticia`
--

LOCK TABLES `noticia` WRITE;
/*!40000 ALTER TABLE `noticia` DISABLE KEYS */;
/*!40000 ALTER TABLE `noticia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noticias` (
  `idnoticias` int(11) NOT NULL AUTO_INCREMENT,
  `titutlo` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechReg` date DEFAULT NULL,
  `descripcion` text COLLATE utf8_unicode_ci,
  `usuario_idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idnoticias`),
  KEY `fk_noticias_usuario1_idx` (`usuario_idUsuario`),
  CONSTRAINT `fk_noticias_usuario1` FOREIGN KEY (`usuario_idUsuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticias`
--

LOCK TABLES `noticias` WRITE;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `nombres` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `oficina` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `fchReg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `permisos` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `reset` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin@admin.com','9dbf7c1488382487931d10235fc84a74bff5d2f4','admin','admin','Oficina Central de Informática','2016-03-30 01:23:57','admin,aviso,noticia,evento',1,1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-01 20:43:27
