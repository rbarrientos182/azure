-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: 192.168.21.29    Database: gepp
-- ------------------------------------------------------
-- Server version	5.5.8-log

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
-- Table structure for table `familia`
--

DROP TABLE IF EXISTS `familia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `familia` (
  `idfamilia` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idfamilia`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `familia`
--

LOCK TABLES `familia` WRITE;
/*!40000 ALTER TABLE `familia` DISABLE KEYS */;
INSERT INTO `familia` VALUES (1,'Colas'),(2,'Sabores Pepsico'),(3,'Sabores Aliados'),(4,'Agua Embotellada'),(5,'Mix'),(6,'Agua Garraf?n'),(7,'Hielo'),(8,'Otros'),(10,'Mezcladores'),(11,'No Carbonatados Pepsico'),(13,'Otros No Carbonatados');
/*!40000 ALTER TABLE `familia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marca`
--

DROP TABLE IF EXISTS `marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marca` (
  `idmarca` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(45) NOT NULL,
  PRIMARY KEY (`idmarca`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` VALUES (1,'Pepsi'),(2,'Mirinda'),(3,'7 Up'),(4,'Mzna Sol'),(5,'Kas'),(6,'Power P'),(7,'M Dew'),(8,'Electropura'),(9,'Squirt'),(10,'Seagram\'s'),(11,'Garci Crespo'),(12,'San Lorenzo'),(13,'Agua de Lourdes'),(14,'Atlantis'),(15,'Jarritos'),(16,'Barrilitos'),(17,'Orange Crush'),(18,'Sidral Mundet'),(19,'Sangria Casera'),(20,'Corona'),(21,'Canada Dry'),(25,'El Rey'),(26,'Titan'),(27,'Teem'),(28,'Wink'),(29,'Lipton'),(30,'Popper'),(31,'Kas Pink'),(32,'Manía'),(34,'Pepsi Blue'),(35,'Sangria Señorial'),(36,'Be Light'),(38,'Pepsi Limon'),(39,'Agua Glacial'),(40,'Sidral Aga'),(41,'Fruco'),(42,'Pepsi Twist'),(43,'Epura'),(44,'Alegro'),(45,'Gamesa'),(46,'Gatorade'),(47,'Sabritas'),(48,'Pepsi Fire'),(49,'Propel'),(50,'Aguas Frescas'),(51,'Sun Light'),(52,'Essentials'),(53,'Garci O2'),(54,'Pepsi Clear'),(55,'Agua Bidestilada'),(56,'Pepsi Gold'),(57,'Pepsi Kaffe'),(58,'Vita'),(59,'All Sport'),(60,'Bliss'),(62,'Country Club'),(64,'Lim'),(65,'Sunleaf'),(66,'Zil'),(67,'Vita Frut'),(68,'Kirkland'),(70,'Pepsi Retro'),(71,'A. Chihuahua'),(72,'H2OH!'),(73,'Mr Q'),(74,'Vitamin Water'),(75,'Mzna Sol Exótica'),(76,'Smart'),(77,'Dynamo'),(78,'Mr Q Juicy'),(79,'Pepsi Kick'),(80,'Fitline Water'),(81,'7 Up Bite'),(82,'7 Up Diet'),(83,'7 Up Ice'),(84,'7 Up Light'),(85,'Be Senze'),(86,'Bliss Light'),(87,'Gatorade Fierce'),(88,'Gatorade Rain'),(89,'Gatorade World'),(90,'Hielo Electropura'),(91,'Kas Pink Light'),(92,'Lipton Light'),(93,'Mirinda Naramango'),(94,'Mirinda Narangotica'),(95,'Mirinda Narazul'),(96,'Mzna Sol Verde'),(97,'Pepsi Diet'),(98,'Pepsi Light'),(99,'Pepsi Max'),(100,'Sangria Señorial Light'),(101,'Squirt Citrus'),(102,'Squirt Light'),(103,'Squirt Sal y Limón'),(104,'Go Light'),(105,'Sunleaf Light'),(106,'Mirinda Fiesta'),(107,'Frappuccino'),(108,'Pepsi Natural'),(109,'Adrenaline Rush'),(110,'Gatorade Cool'),(111,'Freskibon'),(112,'RockStar'),(113,'7 Up Mojito'),(114,'Pepsi Wiwichu'),(115,'G2'),(116,'Mirinda W'),(117,'MnzaSolLib'),(118,'PcBoom'),(119,'PcCuau'),(120,'JUMEX'),(121,'SqMojito'),(122,'Ok'),(123,'Trisoda'),(124,'Santorini'),(125,'Junghans'),(126,'Di Roma'),(127,'Montebello'),(128,'Petit'),(129,'California'),(130,'Spincitr'),(131,'Plus Mineral'),(141,'Rancho Natura'),(142,'PetitCrece'),(143,'CosechaPur'),(144,'Boost'),(145,'PistoListo'),(146,'BEnerg'),(147,'LaGavilana'),(148,'JumexFresh'),(149,'Mirinda Frutas'),(150,'Jugazzo'),(151,'Refreshers'),(152,'Epurita'),(153,'Epura Bebe'),(154,'7 Up Limonada'),(155,'Mzna Sol Golden'),(156,'Jarrita'),(158,'Jumex Frutzzo'),(159,'Toronjita'),(160,'Epura con Jugo'),(161,'Gatorade Frost'),(162,'G Active'),(163,'Jumex Refreshers'),(164,'Squirt Pepino Limon'),(165,'Quaker'),(166,'Toronjita del Huerto'),(167,'Minerale'),(168,'Manzanada'),(169,'CosechaPNe'),(170,'PepsiJgoLimon'),(171,'Epurita con Jugo'),(225,'BooNor'),(901,'Promocionales'),(996,'Racks'),(997,'Mix'),(998,'Ganchos'),(999,'Tarimas'),(1000,'Sin Marca');
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operaciones`
--

DROP TABLE IF EXISTS `operaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operaciones` (
  `idoperacion` int(11) NOT NULL AUTO_INCREMENT,
  `idDeposito` int(11) NOT NULL,
  `mercado` int(11) NOT NULL DEFAULT '0' COMMENT '0- Tradicional\n1.- Moderno',
  `coordinador_despacho` varchar(150) NOT NULL,
  `nocelda` int(11) DEFAULT NULL,
  `descripcion` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`idoperacion`),
  KEY `fk_operaciones_Deposito1_idx` (`idDeposito`),
  CONSTRAINT `fk_operaciones_Deposito1` FOREIGN KEY (`idDeposito`) REFERENCES `deposito` (`idDeposito`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operaciones`
--

LOCK TABLES `operaciones` WRITE;
/*!40000 ALTER TABLE `operaciones` DISABLE KEYS */;
INSERT INTO `operaciones` VALUES (1,101,0,'Baldomero Gonzalez',NULL,NULL),(2,103,0,'Ricardo Hernandez',NULL,NULL),(3,104,0,'Fernando Suarez',NULL,NULL),(4,111,0,'Fernando Suarez',NULL,NULL),(5,117,0,'Ricardo Hernandez',NULL,NULL),(6,121,0,'Fernando Suarez',NULL,NULL),(7,123,0,'Ismael Ortega',NULL,NULL),(8,281,0,'Manuel Garcia',NULL,NULL),(9,341,0,'Roberto Barrientos',NULL,NULL),(10,361,0,'Fernando Palacios',NULL,NULL),(11,520,0,'Roberto Barrientos',NULL,NULL),(12,521,0,'Jorge Cruz',NULL,NULL),(13,701,0,'Jorge Cruz',NULL,NULL),(14,704,0,'Luis del Pilar',NULL,NULL),(15,823,0,'Manuel Martinez',NULL,NULL),(16,824,0,'Roberto Barrientos',NULL,NULL),(17,825,0,'Manuel Garcia',NULL,NULL),(18,826,0,'Fernando Palacios',NULL,NULL),(19,860,0,'Manuel Martinez',NULL,NULL),(20,924,0,'Manuel Garcia',NULL,NULL),(21,941,0,'Sergio Gonzalez',NULL,NULL),(22,963,0,'Fernando Palacios',NULL,NULL),(23,113,0,'Ismael Ortega',NULL,NULL),(24,887,0,'Luis Gallegos',NULL,NULL),(25,879,0,'Manuel Martinez',NULL,NULL),(26,124,0,'German Hernandez',NULL,NULL),(27,923,0,'David Fergadis Herrejón',NULL,NULL),(28,732,0,'Raul Sanchez',NULL,NULL),(29,345,0,'Pedro Villa',NULL,NULL),(30,819,0,'Pedro Villa',NULL,NULL),(31,531,0,'Roberto Barrientos',NULL,NULL),(32,261,0,'Fernando Suarez',NULL,NULL),(33,421,0,'Pedro Villa',NULL,NULL),(34,712,0,'Sergio Gonzalez',NULL,NULL),(35,119,0,'Raul Sanchez Gonzalez',NULL,NULL),(36,221,0,'Luis Gallegos',NULL,NULL),(37,349,0,'Jorge Cruz',NULL,NULL),(38,241,0,'GermÃ¡n Hernandez ',NULL,NULL),(39,484,0,'Manuel Martinez',NULL,NULL),(40,482,0,'Manuel Martinez',NULL,NULL),(41,483,0,'David Fergadis Herrejón',NULL,NULL),(42,873,0,'Manuel Martinez',NULL,NULL),(43,187,0,'Ismael Ortega',NULL,NULL),(44,475,0,'Luis Gallegos ',NULL,NULL),(45,441,0,'German Hernandez',NULL,NULL),(46,542,0,'Baldomero Gonzalez',NULL,NULL),(47,180,0,'Ismael Ortega',NULL,NULL),(48,184,0,'Julio Diaz Hernandez',NULL,NULL),(49,472,0,'Luis Raciel Gallegos Gonzalez',NULL,NULL),(50,470,0,'Manuel Martinez',NULL,NULL),(51,476,0,'Jorge Cruz',NULL,NULL),(52,499,0,'Roberto Barrientos',NULL,NULL),(53,368,0,'----',NULL,NULL),(54,222,0,'Manuel Martinez',NULL,NULL),(55,135,0,'Fernando Suarez',NULL,NULL);
/*!40000 ALTER TABLE `operaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paquete`
--

DROP TABLE IF EXISTS `paquete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paquete` (
  `idpaquete` int(11) NOT NULL,
  `paquete` varchar(45) NOT NULL,
  `altura` float DEFAULT NULL,
  `ancho` float DEFAULT NULL,
  `profundidad` float DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `equivalencia` float DEFAULT NULL,
  `cajasxcapa` int(11) DEFAULT NULL,
  `capasxtarima` int(11) DEFAULT NULL,
  `totalcajas` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpaquete`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paquete`
--

LOCK TABLES `paquete` WRITE;
/*!40000 ALTER TABLE `paquete` DISABLE KEYS */;
INSERT INTO `paquete` VALUES (0,'Desconocido',0,0,0,0,0,0,0,0),(1,'6.5 Oz Grb 24',25.565,30.4755,46.1485,0,1.17,8,6,48),(2,'Envase 6.5 Oz Grb',0,0,0,0,0,0,0,0),(3,'10 Oz Gnr 24',0,0,0,0,1.4,0,0,0),(4,'10 Oz Grb 24',24.1505,30.5185,46.1605,17.5,0.4,8,5,40),(5,'Envase 10 Oz',0,0,0,0,0,0,0,0),(6,'11 Oz Grb 24',25.1745,30.3958,46.1452,0,1.27,8,5,40),(7,'Envase 11 Oz. Grb',0,0,0,0,0,0,0,0),(8,'12 Oz Gnr 24',0,0,0,0,1.4,12,6,72),(9,'12 Oz Gnr 24',0,0,0,0,0.7,0,0,0),(10,'12 Oz Gnr 4 Six',0,0,0,0,1.4,0,0,0),(11,'12 Oz Gnr 6',0,0,0,0,0.35,0,0,0),(12,'12 Oz Grb 24',25.375,30.4775,46.207,18,0,8,5,40),(13,'12 Oz Grb 24',25.315,30.513,46.386,0,1.27,8,5,40),(14,'Envase 12 Oz',0,0,0,0,0,0,0,0),(15,'12 Oz Lata 15',0,0,0,0,0.79,0,0,0),(16,'12 Oz Lata 2-12Pack con Fajill',12.582,26.864,40.569,0,0.56,10,10,100),(17,'12 Oz Lata 4 Six',12.582,26.864,40.569,9.368,0.56,60,11,660),(18,'12 Oz Lata 2-12Pack con Fajill',0,0,0,0,0.56,0,0,0),(19,'12 Oz Lata 6 con Fajilla',12.328,13.205,19.945,2.342,0.14,42,10,420),(20,'12 Oz Lata 1',0,0,0,0,0.02,0,0,0),(21,'12 Oz Lata 4 Six con Fajilla',0,0,0,0,0.56,0,0,0),(22,'12 Oz Lata 12',12.317,19.839,26.729,4.684,0.35,20,11,220),(23,'12 Oz Lata 8',13,13,26,0,0.18,0,0,0),(24,'12 Oz Pet 6',0,0,0,0,0.24,0,0,0),(25,'2.5 Pet 8',0,0,0,0,0.41,0,0,0),(26,'12 Oz Pet 12',12,20,26,4.7,0.41,28,7,196),(27,'12 Oz Pet 15',0,0,0,0,0.51,0,0,0),(28,'12 Oz Pet 24',0,0,0,0,0.83,0,0,0),(29,'12 Oz Pet 4 x 6',0,0,0,0,0.35,0,0,0),(30,'12 Oz Pet 1',0,0,0,0,0.05,0,0,0),(31,'12 Oz Pet 30',0,0,0,0,1.03,0,0,0),(32,'12 Oz Pet 7',0,0,0,0,0.09,0,0,0),(33,'14 Oz Gnr 24',0,0,0,0,1.56,0,0,0),(34,'14 Oz Grb 24',0,0,0,0,1.56,0,0,0),(35,'Envase 14 Oz',0,0,0,0,0,0,0,0),(36,'16 Oz Grb 24',0,0,0,0,1.75,0,0,0),(37,'Envase 16 Oz',0,0,0,0,0,0,0,0),(38,'16 Oz Lata 24',0,0,0,0,0.64,0,0,0),(39,'16 Oz Lata 12',16,20,27,0,0.32,0,0,0),(40,'Sidral Aga',0,0,0,0,0,0,0,0),(41,'26 Oz Grb 12',0,0,0,0,0.94,0,0,0),(42,'Envase 26 Oz',0,0,0,0,0,0,0,0),(43,'340 Ml Pet 12',0,0,0,0,0.33,0,0,0),(44,'340 Ml Pet 24',0,0,0,0,0.83,0,0,0),(45,'0.5 Lts Bolsa 40',0,0,0,0,1.17,0,0,0),(46,'0.5 Lts Gnr 24',0,0,0,0,1.75,0,0,0),(47,'0.5 Lts Gnr 24',0,0,0,0,1.75,0,0,0),(48,'0.5 Lts Gnr 24',0,0,0,0,1.75,0,0,0),(49,'Envase 0.5 Lts Grb 24',0,0,0,0,0,0,0,0),(50,'0.5 Lts Grb 24',25.1745,30.3785,46.21,8.175,1.75,8,4,32),(51,'Envase O.5 Litros',0,0,0,0,0,0,0,0),(52,'0.5 Lts Pet 4',25,13,13,0,0.16,0,0,0),(53,'0.5 Lts Pet 6',23.017,13.886,19.929,0,0.25,45,6,270),(54,'0.5 Lts Pet 12',23.186,20.12,27.195,0,0.5,24,5,120),(55,'0.5 Lts Pet 15',21.4,34.5,41.7,8.75,0.51,18,6,108),(56,'0.5 Lts Pet 24',22.898,26.9285,41.2145,13.08,1,12,6,72),(57,'0.5 Lts 6x4',0,0,0,0,0.16,0,0,0),(58,'0.5 Lts Pet 1',23.3,6.15,6.25,0,0.03,0,0,0),(59,'0.5 Lts Pet 30',0,0,0,0,1.25,0,0,0),(60,'0.5 Lts Pet 12 CM',0,0,0,0,0.5,0,0,0),(61,'0.5 Lts Pet 7',0,0,0,0,0.33,0,0,0),(62,'600 Ml Pet 4',0,0,0,0,0.16,0,0,0),(63,'600 Ml Pet 6',24.883,14.018,20.489,3.86,0.25,45,5,225),(64,'600 Ml Pet 8',0,0,0,0,0.33,0,0,0),(65,'600 Ml Pet 12',1230.06,20.642,27.802,0,0.5,24,5,120),(66,'600 Ml Pet 15',24.795,20.341,34.082,0,0.62,18,5,90),(67,'600 Ml Pet 24',24.941,27.393,42.081,15.8,1,12,5,60),(68,'600 Ml Pet 2',0,0,0,0,0.08,0,0,0),(69,'600 Ml Pet 6 x 4-Pack',0,0,0,0,1,0,0,0),(70,'600 Ml Pet 1',24.5,6.3,6.87,0,0.04,0,0,0),(71,'600 Ml Pet 3',24,6.66,20,1.861,0.12,96,5,480),(72,'600 Ml Pet 4 x 6 Pack',0,0,0,0,1,0,0,0),(73,'600 Ml Pet 30 Pack',0,0,0,0,1.25,0,0,0),(74,'600 Ml Pet 28',0,0,0,0,1.16,0,0,0),(75,'600 Ml Pet 6',24.132,13.552,20.328,3.722,0.25,45,5,225),(76,'600 Ml Pet 24',0,0,0,0,1,0,0,0),(77,'600 Ml Pet 5',0,0,0,0,0.2,0,0,0),(78,'1 Lts Grb 12',0,0,0,0,1.75,0,0,0),(79,'1 Lts Pet 4',27.804,16.538,16.538,4.105,0.31,42,5,210),(80,'1 Lts Pet 6',28.481,17.109,25.453,6.156,0.48,28,4,112),(81,'1 Lts Pet 8',0,0,0,0,0.64,0,0,0),(82,'1 Lts Pet 12',28.444,25.005,33.545,0,0.97,15,5,75),(83,'1 Lts Pet 15',27.7025,24.468,32.5545,15.39,1.21,12,5,60),(84,'1 Lts. Pet  24 4-six',0,0,0,0,1.67,0,0,0),(85,'1 Lts Pet 2',26,8.5,16.5,2.052,0.16,90,5,450),(86,'1 Lts Pet 1',26,8.5,8.5,0,0.08,0,0,0),(87,'1 Lts Pet 3',26,8.5,25.5,0,0.24,0,0,0),(88,'1 Lts Pet 5',0,0,0,0,0,0,0,0),(89,'1 Lts Prb 12',0,0,0,0,0.97,0,0,0),(90,'1 Lts Prb 14',0,0,0,0,1.13,0,0,0),(91,'1 Lts Prb 15',0,0,0,0,1.21,0,0,0),(92,'1.5 Lts Pet 4',34,18,18,0,0.41,0,0,0),(93,'1.5 Lts Pet 6',33.983,18.393,27.675,9.75,0.62,28,4,112),(94,'1.5 Lts Pet 8',0,0,0,0,0.83,0,0,0),(95,'1.5 Lts Pet 9',0,0,0,0,0.93,0,0,0),(96,'1.5 Lts Pet 12',33.859,32.079,37.865,0,1.25,14,3,42),(97,'1.5 Lts Pet 15',31.21,27.12,45.2,0,1.56,0,0,0),(98,'1.5 Lts Pet 1',34.5,8.5,8.5,0,0.1,0,0,0),(99,'1.5 Lts Pet 3',34.5,8.5,25.5,0,0.31,44,3,132),(100,'1.5 Lts Pet 12  CDP 56',0,0,0,0,0.092,0,0,0),(101,'1.5 Lts Prb 8',0,0,0,0,0.97,0,0,0),(102,'1.5 Lts Prb 12',0,0,0,0,1.45,0,0,0),(103,'Envase  1.5 Litros',0,0,0,0,0,0,0,0),(104,'Plastico 12 Cavidades 1.5 Lts',0,0,0,0,0,0,0,0),(105,'2 Lts Pet 4',35,20.5,20.5,8.35,0.78,30,3,90),(106,'2 Lts Pet 6',35.937,20.6105,31.0785,12.53,0.9,20,3,60),(107,'2 Lts Pet 8',36.6214,20.8082,41.4112,0,1.17,15,3,45),(108,'2 Lts Pet 9',0,0,0,0,1.31,0,0,0),(109,'2 Lts Pet 2',35,9.75,19.5,0,0.29,30,4,120),(110,'2 Lts Pet 1',35,9.75,9.75,0,0.18,0,0,0),(111,'2 Lts Pet 3',0,0,0,0,0.54,0,0,0),(112,'2 Lts Pet 8 c/ Plastico',0,0,0,0,1.17,0,0,0),(113,'2 Lts Pet 5',35,20.5,41,17.04,15,15,3,45),(114,'2 Lts Prb 8',36.5573,30.239,40.9745,0,1.03,9,4,36),(115,'2 Lts Prb 9',0,0,0,0,1.15,0,0,0),(116,'Envase  2 Litros Prb 8 Botella',0,0,0,0,0,0,0,0),(117,'Envase  2 Lts Prb 9 Bts',0,0,0,0,0,0,0,0),(118,'2 Lts Prb 10',0,0,0,0,0,0,0,0),(119,'10 Lts Pet 1',0,0,0,0,3.89,0,0,0),(120,'19 Lts Pet',0,0,0,0,1.75,0,0,0),(121,'Garrafon Pet 1',0,0,0,0,1.75,10,4,40),(122,'Envase  Garrafon Pet',0,0,0,0,0,0,0,0),(123,'19 Lts Policarbonato',0,0,0,0,1.75,0,0,0),(124,'Envase Garrafon  Roto',0,0,0,0,0,0,0,0),(125,'19 Lts Pvc',49.5,28.5,28.5,19.74,1.75,10,4,40),(126,'Envase Garrafon  19 PVC',0,0,0,0,0,0,0,0),(127,'19 Lts Vidrio',0,0,0,0,1.9,0,0,0),(128,'Envase 19 Vidrio',0,0,0,0,0,0,0,0),(129,'20 Lts Policarbonato',48.964,28.071,28.071,0,1.75,0,0,0),(130,'Garrafon 20 litros',0,0,0,0,1.75,0,0,0),(131,'Bag in Box 2.5',0,0,0,0,0.87,0,0,0),(132,'Bag in Box 5.0',20.355,30.581,41.307,23.3,1.75,10,3,30),(133,'Bag in Box',20.355,30.581,41.307,23.3,1.75,10,3,30),(134,'Tanque 5 Galones CO2 Lleno',120,48,48,0,1.75,0,0,0),(135,'Hielo 5 kg.',0,0,0,0,0,0,0,0),(136,'Hielo 15 kg.',0,0,0,0,0,0,0,0),(137,'1.25 Lts Grb 8',0,0,0,0,1.27,0,0,0),(138,'1.25 Lts Pet  12',0,0,0,0,1.9,0,0,0),(139,'15 Oz Grb 24',0,0,0,0,1.56,0,0,0),(140,'Envase  15 Oz Grb',0,0,0,0,0,0,0,0),(141,'32 Oz Pet 12',0,0,0,0,0.94,0,0,0),(142,'8 Oz Gnr 24',0,0,0,0,0.78,0,0,0),(143,'8 Oz Gnr 24',0,0,0,0,0.78,0,0,0),(144,'8 Oz Gnr 6',0,0,0,0,0.19,0,0,0),(145,'8 Oz Lata 24',0,0,0,0,0.5,0,0,0),(146,'8 Oz Pet 12',0,0,0,0,0.41,0,0,0),(147,'8 Oz Pet 24',0,0,0,0,0.83,0,0,0),(148,'G.C.  12.5 Oz Gnr 24',0,0,0,0,1.27,0,0,0),(149,'G.C. A.  12.5 Oz Gnr 24',0,0,0,0,1.27,0,0,0),(150,'C.S. 12.5 Oz Grb 24',0,0,0,0,1.27,0,0,0),(151,'Envase   12.5 Oz Grb',0,0,0,0,0,0,0,0),(152,'Hielo 20 kg.',23.5,38,65,0,0,10,3,30),(153,'Hielo 3 kg.',0,0,0,0,0,0,0,0),(154,'250 Ml Bolsa 100',0,0,0,0,0,0,0,0),(155,'Envase Agua  1/4',0,0,0,0,0,0,0,0),(156,'250 Ml Lata 12',0,0,0,0,0.56,0,0,0),(157,'250 Ml Lata 4 x 3',0,0,0,0,0.56,0,0,0),(158,'250 Ml Lata 6 x 2',0,0,0,0,0.56,0,0,0),(159,'250 Ml Lata 24',0,0,0,0,0.56,0,0,0),(160,'250 Ml Pet 8',0,0,0,0,0.53,0,0,0),(161,'250 Ml Pet 12',0,0,0,0,0.53,0,0,0),(162,'250 Ml Pet 24',0,0,0,0,1.06,0,0,0),(163,'250 Ml Pet 1',0,0,0,0,0.02,0,0,0),(164,'250 Ml Pet 3',0,0,0,0,0.06,0,0,0),(165,'250 Ml Pet 16',0,0,0,0,0.27,0,0,0),(166,'250Ml Tb 27  Guay Fresand',0,0,0,0,0.41,0,0,0),(167,'2.5 Lts Pet 4',0,0,0,0,0.83,0,0,0),(168,'2.5 Lts Pet 6',36.631,21.883,32.819,15.87,1.24,16,3,48),(169,'2.5 Lts Pet 8',36.8433,22.637,45.082,0,1.67,12,3,36),(170,'2.5 Lts Pet 9',0,0,0,0,1.56,0,0,0),(171,'2.5 Lts Pet 2',36.3,11,22,0,0.34,0,0,0),(172,'2.5 Lts Pet 1',36.3,11,11,0,0.17,0,0,0),(173,'2.5 Lts Pet 3',0,0,0,0,0.52,0,0,0),(174,'2.5 Pet  / c-Radio 2',0,0,0,0,0.34,0,0,0),(175,'2.5 Pet  / c-Lapicero Red 2',0,0,0,0,0.34,0,0,0),(176,'2.5 Pet  / c-Lapicero Cuad 2',0,0,0,0,0.34,0,0,0),(177,'2.5 Lts Pet 2 c/Arroz 500 grs',0,0,0,0,0.34,0,0,0),(178,'2.5 Soplado Claro',0,0,0,0,0,0,0,0),(179,'2.5 Lts Prb 8',0,0,0,0,1.67,0,0,0),(180,'300 Ml Grb 24',0,0,0,0,1.06,0,0,0),(181,'300 Ml Lata 6',0,0,0,0,0.28,0,0,0),(182,'300 Ml Lata 12',14,18,24,0,0.56,0,0,0),(183,'300 Ml Lata 24',0,0,0,0,1.12,0,0,0),(184,'300 Ml Lata 2',0,0,0,0,0.09,0,0,0),(185,'300 Ml Lata 4 x 3',0,0,0,0,0.56,0,0,0),(186,'300 Ml Lata 24',0,0,0,0,1.12,0,0,0),(187,'300 Ml Lata 4 Six 4x6',0,0,0,0,1.12,0,0,0),(188,'300 Ml Lata 12',0,0,0,0,0.56,0,0,0),(189,'300 Ml Pet 12',0,0,0,0,0.41,0,0,0),(190,'300 Ml Pet 24',0,0,0,0,0.83,0,0,0),(191,'5.25 Lts Pet 4',0,0,0,0,1.94,0,0,0),(192,'5.25 Lts Pet 1',0,0,0,0,0.48,0,0,0),(193,'Post',0,0,0,0,1.75,0,0,0),(194,'Tanque CO2 Lleno',0,0,0,0,0,0,0,0),(195,'3 Lts Pet 4',10,10,10,0,0.97,0,0,0),(196,'3 Lts Pet 6',36.675,23.583,35.467,19.27,1.46,15,3,45),(197,'3 Lts Pet 8',37.0016,23.8486,47.454,25.73,1.94,10,3,30),(198,'3 Lts Pet 12',0,0,0,0,2.91,0,0,0),(199,'3 Lts Pet 2',0,0,0,0,0.48,0,0,0),(200,'3 Lts Pet 1',0,0,0,0,0.24,0,0,0),(201,'3 Lts Pet 1',0,0,0,0,0.24,0,0,0),(202,'750 Ml Pet 4',0,0,0,0,0.31,0,0,0),(203,'750 Ml Pet 6',0,0,0,0,0.47,0,0,0),(204,'750 Ml Pet 12',0,0,0,0,0.62,0,0,0),(205,'750 Ml Pet 12',27,21,28,0,0.94,0,0,0),(206,'750 Ml Pet 15',0,0,0,0,1.17,0,0,0),(207,'750 Ml Pet 24',0,0,0,0,1.88,0,0,0),(208,'750 Ml Pet 1',0,0,0,0,0.078,0,0,0),(209,'750 Ml Pet 20',0,0,0,0,0.078,0,0,0),(210,'10.1 Lts Pet 2',44,20,40,20.472,7.78,15,3,45),(211,'10.1 Lts Pet 1',43.319,19.679,19.679,0,3.89,30,3,90),(212,'10.1 Lts Pet 3',0,0,0,0,11.67,0,0,0),(213,'330 Ml Pet 6 Pack',19.529,12.523,18.127,2.08,0.2,53,7,371),(214,'330 Ml Pet 8 Tanquecito',0,0,0,0,0.27,0,0,0),(215,'330 Ml Pet 12',24,23,30,0,0.41,0,0,0),(216,'330 Ml Pet 24 Pack',17.428,23.675,36.011,8.232,0.82,15,7,105),(217,'330 Ml Pet 30 Tanquecito',0,0,0,0,1.02,0,0,0),(218,'330 Ml Pet 24 paga 22',0,0,0,0,0.82,0,0,0),(219,'330 Ml Pet 12 paga 11',24.38,23.43,30.86,0,0.41,0,0,0),(220,'Poliasa 11.35 L',0,0,0,0,3.89,0,0,0),(221,'PVC ASA 11.35 L',0,0,0,0,3.89,0,0,0),(222,'Poliasa 11.35 L',0,0,0,0,0,0,0,0),(223,'710 Ml Lata 12',0,0,0,0,0.56,0,0,0),(224,'710 Ml Pet 24',0,0,0,0,1.12,0,0,0),(225,'24 tiras 4.85 Kg',0,0,0,0,0,0,0,0),(226,'75gr Paq',0,0,0,0,0,0,0,0),(227,'5 Lts Pet 4',33.986,31.448,31.448,0,4.24,12,3,36),(228,'5 Lts Pet 2',0,0,0,0,2.12,0,0,0),(229,'5 Lts Pet 1',33.5,14.5,14.5,0,1.06,0,0,0),(230,'12gr Bol',0,0,0,0,0,0,0,0),(231,'30g Caja 16 IMP',0,0,0,0,0,0,0,0),(233,'20 Oz Pet 6',0,0,0,0,0.29,0,0,0),(234,'20 Oz Pet 12',0,0,0,0,0.58,0,0,0),(235,'20 Oz Pet 24',0,0,0,0,1.16,0,0,0),(236,'20 Oz 6x4',0,0,0,0,1.16,0,0,0),(237,'20 Oz Pet 1',0,0,0,0,0.04,0,0,0),(238,'Plastico 24 Cavidades 20 Oz',0,0,0,0,0,0,0,0),(239,'64 Oz Pet 8',0,0,0,0,1.24,0,0,0),(240,'200 Ml Tb 12',0,0,0,0,0.204,0,0,0),(241,'TB 1',11,17.5,32.5,0,0.017,0,0,0),(242,'200 Ml Tb 10',0,0,0,0,0.17,0,0,0),(243,'200 Ml Tb 40',0,0,0,0,0.68,0,0,0),(244,'2.25 Lts Pet 4',0,0,0,0,0.83,0,0,0),(245,'2.25 Lts Pet 8',0,0,0,0,1.67,0,0,0),(246,'7 Oz Grb 24',21,30,45.5,10.5,1.06,8,6,48),(247,'7 Oz Ret',0,0,0,0,0,0,0,0),(248,'720 Ml Pet 12',0,0,0,0,0.84,0,0,0),(249,'720 Ml Pet 24',0,0,0,0,1.68,0,0,0),(250,'16.5 Oz Grb 24',0,0,0,0,1.59,0,0,0),(251,'1 Galon Pet 4',0,0,0,0,4.24,0,0,0),(252,'1 Galon Pet 1',43,21,21,0,1.06,0,0,0),(253,'Plastico 4 Cavidades',0,0,0,0,0,0,0,0),(254,'0.5 Galon Pet 9',0,0,0,0,4.74,0,0,0),(255,'0.5 Galon Pet 1',0,0,0,0,0.53,0,0,0),(256,'15 Lts Pet 1',0,0,0,0,3.18,0,0,0),(257,'700 Ml Pet 4',0,0,0,0,0.27,0,0,0),(258,'700 Ml Pet  6',0,0,0,0,0.41,0,0,0),(259,'700 Ml Pet 12',25,20,26,0,0.83,0,0,0),(260,'700 Ml Pet 12',0,0,0,0,1.037,0,0,0),(261,'700 Ml Pet 24',0,0,0,0,1.66,0,0,0),(262,'700 Ml Pet  1',0,0,0,0,0.069,0,0,0),(263,'400 mL Pet 24',0,0,0,0,1,0,0,0),(264,'400 Ml Pet 12',217.8,20.0395,25.913,0,0.5,29,5,145),(265,'400 Ml Pet 24',0,0,0,0,1,0,0,0),(266,'28 Oz Grb 12',0,0,0,0,1.17,0,0,0),(267,'312Mo GNR 960',0,0,0,0,0.39,0,0,0),(268,'4 Lts Pet 4',0,0,0,0,4.24,0,0,0),(269,'4 Lts Pet 1',0,0,0,0,1.06,0,0,0),(270,'9 Oz Gnr 24',0,0,0,0,0.78,0,0,0),(271,'9 Oz Gnr 24',0,0,0,0,0.78,0,0,0),(272,'9 Oz Gnr 6-4Pack',0,0,0,0,0.78,0,0,0),(273,'9 Oz Gnr 12',0,0,0,0,0.39,0,0,0),(274,'Envase   9 Oz Gnr',0,0,0,0,0,0,0,0),(275,'236 Ml Tb 9',0,0,0,0,0.22,0,0,0),(276,'236 Ml Tetra Brik 27',0,0,0,0,0.68,0,0,0),(277,'Hielo 6 kg.',0,0,0,0,0,0,0,0),(278,'Descuento x Tacticas CSD',0,0,0,0,0,0,0,0),(279,'Descuento x Nota de Credito',0,0,0,0,0,0,0,0),(280,'Descuento x Exclusivas',0,0,0,0,0,0,0,0),(281,'Others GL',0,0,0,0,0,0,0,0),(282,'Agua a Granel',0,0,0,0,0.3,0,0,0),(283,'600 Ml/500 Ml Pet 4 + 2 600 Ml',0,0,0,0,0.3,0,0,0),(284,'Pack Saludable',0,0,0,0,0.3,0,0,0),(285,'3 Lts Pet 4PC/600 Ml Pet 4 8',0,0,0,0,0.3,0,0,0),(286,'3 Lts Pet PC/600 Ml Pet  2',0,0,0,0,0.3,0,0,0),(287,'Pack ta',0,0,0,0,0.3,0,0,0),(288,'CDP PC-Sq 2L/ 1.5L/PC 12Oz',0,0,0,0,0.3,0,0,0),(289,'500-3/PPunch12Oz-3/AFrLim2L 7',0,0,0,0,0.3,0,0,0),(290,'Pasta',0,0,0,0,0,0,0,0),(291,'Rack Refresco',0,0,0,0,0,0,0,0),(292,'Agua OSMOTICA a Granel',0,0,0,0,0,0,0,0),(293,'Plastico 8 Cavidades Europea',0,0,0,0,0,0,0,0),(294,'Plastico 12 Cavidades',0,0,0,0,0,0,0,0),(295,'Plastico 24 Cavidades',0,0,0,0,0,0,0,0),(296,'Rack  12',0,0,0,0,0,0,0,0),(297,'Rack  30',0,0,0,0,0,0,0,0),(298,'Rack  32',0,0,0,0,0,0,0,0),(299,'Rack  40',0,0,0,0,0,0,0,0),(300,'Rack  90',0,0,0,0,0,0,0,0),(301,'Rack Plastico  modular 8',48,48,48,0,0,0,0,0),(302,'TarimadePoliuretanoRM2  40 x 4',0,0,0,0,0,0,0,0),(303,'Salsa Pimiento',0,0,0,0,0,0,0,0),(304,'0.5 Lts Pet 12',23.5,19.2,25.6,6.54,0.5,24,5,120),(305,'Vaso Tequilero  Pieza',0,0,0,0,0,0,0,0),(307,'Tanque 20 Kgs CO2 Lleno',0,0,0,0,0,0,0,0),(308,'12 Oz Lata 24',0,0,0,0,0.56,0,0,0),(310,'1.5 Lts Pet Mango 6',0,0,0,0,0.54,0,0,0),(311,'600  Ml Pet 6',0,0,0,0,0.25,0,0,0),(312,'0.5 Lts Pet Jamaica 6',0,0,0,0,0.25,0,0,0),(313,'1 Lts Pet  6',0,0,0,0,0.46,0,0,0),(314,'Jersey Santos Pza',0,0,0,0,0,0,0,0),(315,'12 Oz Grb 24',25.315,30.513,46.386,0,0,8,5,40),(316,'26 Oz',0,0,0,0,0,0,0,0),(317,'Others Envase',0,0,0,0,0,0,0,0),(318,'600 Ml Pet 12 7Up/6/6   24',24.5,27.2,40.8,0,1,0,0,0),(319,'0.5 Lts Pet 12',0,0,0,0,0.5,0,0,0),(320,'Tarima Madera Roja .55 x .48',20,48,55,0,0,0,0,0),(321,'Vaso Vidrio  Frutas',0,0,0,0,0,0,0,0),(322,'Tanque CO2 10 Vacios',0,0,0,0,0,0,0,0),(323,'Tanque CO2 20 Vacios',0,0,0,0,1.75,0,0,0),(324,'Kit vaso Caja 200',0,0,0,0,0,0,0,0),(325,'Rack Horizontal GEPP 40',0,0,0,0,0,0,0,0),(326,'Promocion Vajilla  Vaso 24 pza',0,0,0,0,0,0,0,0),(327,'Promocion Vajilla  Tarro 36 pz',0,0,0,0,0,0,0,0),(328,'Promocion Vajilla  Tazon 12 pz',0,0,0,0,0,0,0,0),(329,'473 ml Lata 24',16,26.8,40.2,0,0.71,0,0,0),(330,'Racks de Plastico 20 Lts',0,0,0,0,0,0,0,0),(331,'Vaso de Vidrio',0,0,0,0,0,0,0,0),(332,'400 Ml Pet 6',20.473,12.513,17.969,0,0.21,0,0,0),(333,'3.78 L Pet 4',0,0,0,0,1.56,0,0,0),(334,'350 mL Pet 12',18.079,18.861,24.247,4.7,0.4,25,7,175),(335,'200 Ml TB 4',13,1,4.2,0,0.05,0,0,0),(336,'Vaso Tequilero  caja 48',0,0,0,0,0,0,0,0),(338,'Tanque 9 Kg CO2 Vacio',0,0,0,0,0,0,0,0),(339,'Tanque 9 Kg (20 Lbs) CO2 Lleno',0,0,0,0,0,0,0,0),(340,'600 Ml Pet /12 Oz Lata 7Up 48',0,0,0,0,1.28,0,0,0),(341,'2 Lts Pet 8 /12 Oz 24 Lata 7Up',0,0,0,0,2.26,0,0,0),(342,'400 Ml Pet/12 Oz Lata 48',0,0,0,0,1.86,0,0,0),(343,'2.5 Lts Pet 8/12 Oz 24 Lata 32',0,0,0,0,2.37,0,0,0),(344,'600MlPet24/2LtsPet8/12Oz/24Lat',0,0,0,0,2.26,0,0,0),(345,'2 Lts Pet 32',0,0,0,0,6.24,0,0,0),(346,'600 Ml Pet 48',0,0,0,0,2,0,0,0),(347,'12 Oz Lata 48',0,0,0,0,1.4,0,0,0),(348,'12 Oz Lata 56',0,0,0,0,1.63,0,0,0),(349,'12 Oz Lata 32',0,0,0,0,0.93,0,0,0),(350,'400 Ml Pet 48',0,0,0,0,2.32,0,0,0),(351,'600 Ml Pet 56',0,0,0,0,2.33,0,0,0),(352,'2.5 Lts Pet 32',0,0,0,0,6.68,0,0,0),(353,'2 Lts Pet 56',0,0,0,0,10.92,0,0,0),(354,'473 Ml Lata 12 Pack',16.3,20,26.5,6.025,0.32,0,8,0),(355,'3 Lts Pet 6 /12 Oz 24 Lata  30',0,0,0,0,2.15,0,0,0),(356,'400 Ml Pet 15',21.788,18.078,30.242,0,0.72,22,5,110),(357,'3 Lts Pet 30',0,0,0,0,5.85,0,0,0),(358,'12 Oz Lata 30',0,0,0,0,0.87,0,0,0),(359,'237 Ml Lata 24',11.2755,23.344,35.276,6.22,0.5,13,10,130),(360,'237 Ml Lata 6',11.062,11.487,17.231,0,0.13,52,10,520),(361,'12 Oz Lata 36',0,0,0,0,1.05,0,0,0),(362,'600 Ml Pet 36',0,0,0,0,1.5,0,0,0),(363,'600 Ml Pet 60',0,0,0,0,2.5,0,0,0),(364,'12 Oz Lata 60',0,0,0,0,1.75,0,0,0),(365,'200 mL TB27',12,16,36.9,6.12,0.61,19,8,152),(366,'200 Ml TP 24',0,0,0,0,0.41,0,0,0),(367,'250 ml bolsa 100',0,0,0,0,1.75,0,0,0),(368,'Rack Garrafon 40',0,0,0,0,0,0,0,0),(369,'20 Lts PVC',49.5,28.5,28.5,20.74,1.75,10,4,40),(370,'500ml TP 24',0,0,0,0,0.84,0,0,0),(371,'600 Ml Tarima 1440',0,0,0,0,34.3,0,0,0),(372,'330 ML  LATA 4',12.3,13.25,13.25,1.44,0.09,60,11,660),(373,'350 Ml Pet 24',18.015,23.941,37.987,9.51,0.8,12,7,84),(374,'750 Ml Pet 20 Bonus Pack',26.492,29.881,38.914,8.46,1.56,10,5,50),(375,'500 ML PET 24',0,0,0,0,1,0,0,0),(376,'600 Ml PET 24',24.941,27.248,42.081,15.76,1,10,5,50),(377,'1 Lts TP 12',0,0,0,0,1.17,0,0,0),(378,'1 Lts Pet 12 Pack',28.444,25.005,33.545,0,0.93,15,5,75),(379,'1 L Pet 6',28.286,17.109,24.659,6.46,0.46,30,4,120),(380,'500 Ml Pet 6',0,0,0,0,0.25,0,0,0),(381,'600 Ml Pet 6',24.883,14.034,20.489,0,0.5,45,5,225),(383,'1 Lts Pet 4',0,0,0,0,0.38,0,0,0),(385,'355 Ml Pet 6',19.5,12,18,2.35,0,56,6,336),(387,'350 Ml Pet 15',0,0,0,0,0.5,0,0,0),(388,'500 ml con manga PET 12',23.5,19.11,25.48,6.54,0.5,24,5,120),(389,'500 Ml Pet 30',0,0,0,0,1.25,0,0,0),(390,'118 Ml Pet 20',19.2,19.2,25.3,2.99,0.22,25,3,75),(391,'600 Ml Pet 8',0,0,0,0,0.33,0,0,0),(392,'500 Ml Tetra Brik 24',0,0,0,0,1.17,0,0,0),(393,'250 Ml Tetra Brik 27',0,0,0,0,0.65,0,0,0),(394,'330 Ml Tetra Brik 24',0,0,0,0,0.83,0,0,0),(395,'600 Ml Pet 12',25,20,26.5,0,0.5,0,0,0),(397,'330 ml 4/4mza/4nja PET 12 pack',19.2,18.8,25.2,4.26,0,25,6,150),(400,'Bolsa 1.4 Kg  14',31.6,23.4,43.4,21.23,0,10,4,40),(402,'Lata Chica 0.521 Kg 12',10.2,33.09,43.09,7.15,0,10,8,80),(404,'500 Ml 3Nar 2 Ll Tiras 24',0,0,0,0,0,0,0,0),(405,'Vainilla   9.5 Oz Vidrio 12',15.6,19.5,25.8,6.2,0.7,20,7,140),(406,'D.Shot 6.5 Oz Lata 12',0,0,0,0,0.58,0,0,0),(407,'Vainilla/Mocha  9.5 Oz Vidrio',0,0,0,0,0.7,0,0,0),(408,'Caramel 9.5 Oz Vidrio 6',0,0,0,0,0.7,0,0,0),(410,'35 Gr 8X8 Tubo',0,0,0,0,0,0,0,0),(411,'35 Gr',0,0,0,0,0,0,0,0),(412,'1Lt 60',14.1,19,37.5,4.85,0,0,0,0),(413,'2.26 Kg 6',0,0,0,0,0,0,0,0),(415,'Granel Caja 70',0,0,0,0,0,0,0,0),(416,'2.38 Kg 300',0,0,0,0,0,0,0,0),(417,'9.5Oz 4X4 Pack',0,0,0,0,0.52,0,0,0),(418,'500 Ml Pet 24 Chep',0,0,0,0,1.24,0,0,0),(419,'14.7 Oz Grb 24',0,0,0,0,1.56,0,0,0),(420,'200 Ml Tetra Wedge 3',11,17.5,32.5,0,0.05,0,0,0),(421,'1 L TP 1',0,0,0,0,0.09,0,0,0),(422,'473 ml lata 6',15.815,13.177,19.732,0,0.16,0,0,0),(423,'500 mL TP 12',17.392,28.497,20.018,0,0.58,0,0,0),(424,'330 mL Lata 6X4 pack',12.5913,27.2933,40.183,0,0.58,0,0,0),(425,'340 mL Grb 24',0,0,0,0,1.4,0,0,0),(426,'450 mL Grb 24',25.3707,30.3663,46.848,0,1.56,8,5,40),(427,'12 Oz Lata24/3L Pet8 32',0,0,0,0,0,0,0,0),(430,'400 mL Grb 24',0,0,0,0,1.27,8,5,40),(431,'1 Lts TP 4',21,18,24,4.2,0.39,48,4,192),(432,'Frappuccino Shot + taza',0,0,0,0,0.29,0,0,0),(434,'500 mL TP 1 Muestreo',0,0,0,0,0.04,0,0,0),(435,'237 mL Lata 12',11,17.5,23.5,3.11,0.25,27,10,270),(436,'400 Ml Pet 1',0,0,0,0,0.041,0,0,0),(437,'600 Ml Pet 1',26,6.92,6.92,0,0.041,0,0,0),(438,'330 Ml Pet 1',17,6,6,0,0.03,0,0,0),(439,'TP 330 mL Dream Cap 6X4 Pack',0,0,0,0,0.025,0,0,0),(440,'TP 330 mL Dream Cap 4 Pack',15.5,13,13,0,0.61,20,11,220),(441,'1.75 PET 6',0,0,0,0,0,0,0,0),(442,'1.75 Lts Pet 12',44,20,20,10.236,0,30,3,90),(443,'12 Oz Grb 24',24.5,30.7,47,18,0,8,5,40),(444,'Lata Grande 2.38 Kg 1 + er',22.7,14,16.3,2.7,0,52,3,156),(445,'500 ML 6 TP',17.7,28,39.2,0,0,0,0,0),(446,'1 Lts 1Mza/1Pin/1Mgo/1Gua TP 4',20.5,16,16,4.2,0,48,4,192),(447,'1.75 Lts Pet 1',0,0,0,0,0,0,0,0),(448,'600 ml PET 1152',0,0,0,0,0,0,0,0),(449,'Mochila',0,0,0,0,0,0,0,0),(450,'350 ml 2nja-2 PET 4',0,0,0,0,0,0,0,0),(451,'236 Ml Tb 4',0,0,0,0,0,0,0,0),(452,'600 ml + Cilindro Pet 7',0,0,0,0,0,0,0,0),(453,'1 Lts Pet 5',0,0,0,0,0,0,0,0),(454,'0.5 Lts GNR 12',0,0,0,0,0,0,0,0),(455,'2L Pet 1',35,10.3,10.3,0,0,0,0,0),(460,'200 Ml Tetra Wedge 3',11,17.5,32.5,0,0,0,0,0),(461,'330ml TP 1 Muestreo',0,0,0,0,0,0,0,0),(462,'330ml Dream Cap TP 12',15.5,26,36.7,0,0,0,0,0),(463,'Crec TB1',0,0,0,0,0,0,0,0),(464,'Coffe 9.5 Oz Vidrio 1',0,0,0,0,0,0,0,0),(465,'1 Lts Pet 384 + 48 Balon grand',0,0,0,0,0,0,0,0),(466,'295 Ml Lata 24',13.551,22.967,35.858,8.004,0,13,9,117),(467,'295 Ml Lata 12',13.5,16.5,23.5,0,0,52,10,520),(468,'295 Ml Lata 6',13.3645,11.5138,17.3722,0,0,27,9,243),(469,'237 Ml Lata 8',0,0,0,0,0,0,0,0),(470,'65 Ml TP 12 Muestreo',13.3,11.4,18.7,0,0,0,0,0),(471,'12 Oz Lata 12 IMPORTACIO',0,0,0,0,0,0,0,0),(472,'500 Ml TP 1 Muestreo',0,0,0,0,0,0,0,0),(473,'400 Ml Pet 4',21.5,12,12,0,0,80,6,480),(474,'750 Ml Pet 3',0,0,0,0,0,0,0,0),(475,'1.5 Lts Pet 2 + Premium',34,9,18,3.25,0,71,3,213),(476,'65ml TP 5',0,0,0,0,0,0,0,0),(477,'9.5 Oz 4 Pack',0,0,0,0,0,0,0,0),(478,'1 Lts TP 1',23.5,8.6,8.6,0,0,15,4,60),(479,'200 Ml TP 15',7.13,10.1725,16.002,3.395,0,34,8,272),(480,'500 Ml TP 12',17.7,28,39.2,6.585,0,20,6,120),(481,'1 L TP 12',25.102,24.903,29.968,0,0,0,0,0),(482,'330 Ml Lata 12',12.309,19.8105,26.3815,4.48,0,20,11,220),(483,'1 Lts  TP 6',23.8235,16.2295,22.409,0,0,0,0,0),(484,'P  200 Ml Tb 10',0,0,0,0,0,0,0,0),(485,'236 Ml Tb 27',12,21,40,0,0,0,0,0),(486,'200 Ml Tb 40',13,22,42,0,0,0,0,0),(487,'200 Ml TB 4',13,1,4.2,0,0,0,0,0),(488,'2.25 Lts Pet 6',37,44,22,14.16,0,20,3,60),(490,'Envase Garrafon  Pet 20 Lts',0,0,0,0,0,0,0,0),(500,'600 Ml Pet 9',24.5,27.2,40.8,5.92,0,30,5,150),(501,'355 Ml Pet 12',19.5,18,24,4.7,0,56,6,336),(502,'1.5 Lts Pet 16',0,0,0,0,0,0,0,0),(503,'2 Lts Pet 12',35,19.5,39,24.57,0,10,4,40),(504,'355 Ml Grb 6',25.5,31.5,46.5,0,0,32,5,160),(505,'1 Lts TP 2',25.4,25.4,29.6,2.1,0,96,4,384),(506,'200 Ml TP 6',12,8,16,1.352,0,113,8,904),(508,'0.5 Lts TP Pet 3 Pack',0,0,0,0,0,0,0,0),(509,'295 Ml Lata 8',0,0,0,0,0,0,0,0),(510,'200 Ml TP 30',12.561,15.7,41.208,0,0,0,0,0),(512,'0.5 Lts TP 15',0,0,0,0,0,0,0,0),(513,'3 Lts Pet 3 + 3',37,23,34,0,0,0,0,0),(516,'Envase Bag in Box Caja Plastic',0,0,0,0,0,0,0,0),(517,'12 Oz Grb 4',25.5,31.5,46.5,0,0,0,0,0),(518,'150 Ml Bolsa 150',0,0,0,0,0,0,0,0),(519,'237 Ml Lata 4',0,0,0,0,0,0,0,0),(520,'65 ml TP 72',0,0,0,0,0,0,0,0),(521,'9.5 Oz Vidrio 15 IMPORTACION',15.641,19.192,32.288,0,0,0,0,0),(522,'Kiwi-Fresa 710 ml Lata 6',0,0,0,0,0,0,0,0),(523,'7Up Cubo 295 ml lata 8',0,0,0,0,0,0,0,0),(524,'7Up Cubo 295 Ml lata 12',0,0,0,0,0,0,0,0),(525,'7Up Cubo 295 ml lata 24',0,0,0,0,0,0,0,0),(526,'Citrus 400 MlPet3',0,0,0,0,0,0,0,0),(528,' 9 Pzas',0,0,0,0,0,0,0,0),(529,'6 Pzas',0,0,0,0,0,0,0,0),(530,'600 Ml 12  Pepino-/3 Pet 15',0,0,0,0,0,0,0,0),(531,'295 Ml Lata 16',0,0,0,0,0,0,0,0),(532,'330 ml PET 1080',0,0,0,0,0,0,0,0),(533,'65 Ml TP 15',11.4,18.7,13.3,0,0,0,0,0),(534,'1 Lts Pet 450',0,0,0,0,0,0,0,0),(535,'Cubo 295 Ml Lata 20 + Premium',0,0,0,0,0,0,0,0),(536,'Stila Caja c/6 Pzas',0,0,0,0,0,0,0,0),(537,'PekePakes c/11 Pzas',0,0,0,0,0,0,0,0),(538,'Natural Balance c/5 Pzas',0,0,0,0,0,0,0,0),(539,'25 Gr Sachet 500',77,77,77,0,0,0,0,0),(540,'12 Oz Lata',0,0,0,0,0,0,0,0),(541,'Gatorade 30 g Caja 16 Imp',0,0,0,0,0,0,0,0),(542,'Gatorade 80 g Caja 12 Imp',0,0,0,0,0,0,0,0),(543,' 1 Lts Pet 6 TB',0,0,0,0,0,0,0,0),(544,'2.5 Lts BG Pet 6',0,0,0,0,0,0,0,0),(545,'1.5 Lts CP Pet 12',0,0,0,0,0,0,0,0),(546,'1 Lts Pet 6 TC',0,0,0,0,0,0,0,0),(547,'PDG 600 Ml Pet',0,0,0,0,0,0,0,0),(901,'Vaso de Vidrio',0,0,0,0,0,0,0,0),(996,'Rack',0,0,0,0,0,0,0,0),(997,'Mix',0,0,0,0,0,0,0,0),(998,'Ganchos',0,0,0,0,0,0,0,0),(999,'Tarima',0,0,0,0,0,0,0,0),(1000,'Desconocido',0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `paquete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presentacion`
--

DROP TABLE IF EXISTS `presentacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `presentacion` (
  `idpresentacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idpresentacion`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presentacion`
--

LOCK TABLES `presentacion` WRITE;
/*!40000 ALTER TABLE `presentacion` DISABLE KEYS */;
INSERT INTO `presentacion` VALUES (1,'6.5 Oz'),(2,'10 Oz'),(3,'11 Oz'),(4,'12 Oz'),(5,'14 Oz'),(6,'16 Oz'),(7,'26 Oz'),(8,'340 Ml'),(9,'0.5 Lts'),(10,'600 Ml'),(11,'1 Lts'),(12,'1.5 Lts'),(13,'2 Lts'),(14,'10 Lts'),(15,'19 Lts'),(16,'20 Lts'),(17,'2.5 Galones'),(18,'5 Galones'),(19,'5 Kg'),(20,'15 Kg'),(21,'1.25 Lts'),(22,'15 Oz'),(24,'32 Oz'),(25,'8 Oz'),(26,'12.5 Oz'),(27,'20 Kg'),(28,'3 Kg'),(30,'250 Ml'),(31,'2.5 Lts'),(32,'300 Ml'),(33,'5.25 Lts'),(35,'Tanque'),(36,'3 Lts'),(37,'750 Ml'),(38,'10.1 Lts'),(39,'330 Ml'),(42,'11.35 Lts'),(43,'710 Ml'),(44,'Caja'),(45,'5 Lts'),(46,'Pieza'),(47,'20 Oz'),(48,'64 Oz'),(49,'200 Ml'),(50,'2.25 Lts'),(52,'7 Oz'),(53,'720 Ml'),(54,'16.5 Oz'),(55,'1 Galón'),(56,'0.5 Galón'),(57,'15 Lts'),(58,'700 Ml'),(59,'450 Ml'),(60,'400 Ml'),(61,'28 Oz'),(62,'9.5 Oz'),(63,'4 Lts'),(64,'9 Oz'),(65,'236 Ml'),(66,'6 Kg'),(67,'473 Ml'),(69,'3.78 Lts'),(70,'350 Ml'),(71,'237 Ml'),(73,'0.521Kg'),(74,'2.38Kg'),(75,'1.4Kg'),(78,'355 Ml'),(79,'118 Ml'),(81,'35 Gr'),(82,'70 Gr'),(83,'30 Gr'),(84,'295 Ml'),(85,'65 Ml'),(86,'150 Ml'),(87,'80 Gr'),(125,'1.75 Lts'),(127,'14.7 Oz'),(901,'x Tácticas'),(902,'x Nota de Crédito'),(903,'x Exclusiva'),(904,'x Others GL'),(997,'MIXTO'),(1000,'SIN TAMAÑO');
/*!40000 ALTER TABLE `presentacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region` (
  `idRegion` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(45) NOT NULL,
  `Director` varchar(45) DEFAULT NULL,
  `Correo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idRegion`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` VALUES (1,'Metro','Moises Portilla','moises.portilla@gepp.com'),(2,'Occidente','Hugo Gomez','hugo.gomez@gepp.com'),(3,'Pacifico','Abel Salgado','abel.salgado@gepp.com'),(4,'Centro','Victor Banuelos','victor.banuelos@gepp.com'),(5,'Sur','Alfredo Solis','alfredo.solis@gepp.com'),(6,'Norte','Jorge Garzon','jorge.garzon@gepp.com');
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sabor`
--

DROP TABLE IF EXISTS `sabor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sabor` (
  `idsabor` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idsabor`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sabor`
--

LOCK TABLES `sabor` WRITE;
/*!40000 ALTER TABLE `sabor` DISABLE KEYS */;
INSERT INTO `sabor` VALUES (1,'Agua Natural'),(2,'Agua Quina'),(3,'Cereza'),(4,'Club Soda'),(5,'Cola Regular'),(6,'Cola Diet'),(7,'Cola Max'),(8,'Durazno'),(9,'Fresa'),(10,'Ginger Ale'),(11,'Guayaba'),(12,'Lima Limon'),(13,'Lima Limon Diet'),(14,'Limon'),(15,'Mandarina'),(16,'Manzana'),(17,'Agua Mineral'),(18,'Naranja'),(19,'Pi?a'),(20,'Ponche'),(21,'Sangria'),(22,'Tamarindo'),(23,'Toronja'),(24,'Toronja B.C.'),(25,'Toronja Light'),(26,'Tuti-Fruti'),(27,'Uva'),(28,'Grosella'),(29,'Cola Light'),(31,'Hielo'),(32,'Sangria Light'),(34,'Citrico'),(35,'Naramango'),(37,'Mora'),(38,'Adrenaline Rush'),(39,'Limon Verde'),(40,'Cola Blue'),(41,'Toronja Pink Light'),(42,'Manzana Verde'),(43,'Jamaica Light'),(45,'Cola Limon'),(49,'Pera Light'),(50,'Jamaica'),(71,'Sand 0 azucar'),(94,'Cascade Crash'),(95,'Blue Cherry'),(100,'Toronja-Naranja'),(101,'Mango'),(102,'Fresandía'),(103,'Purple Rain'),(104,'Tropical Storm'),(105,'Blue Thunder'),(106,'Red Tornado'),(107,'Orange Fire'),(108,'Polar Fresh'),(109,'Icy Green'),(110,'Glacier Freeze'),(111,'Frutas Tropicales'),(112,'Narangotica'),(113,'Lima Limon Ice'),(114,'Kiwi-Fresa'),(115,'Guanabana'),(124,'Pepino Citrus'),(125,'Moras Silvestres'),(126,'Berries Pensamientos'),(127,'Toronja Mandarina'),(128,'Jamaica Guarana'),(129,'Mzna-Tamarindo'),(130,'Furia Intensa'),(131,'Sandia'),(133,'Orange Squeeze'),(134,'Citric Shot'),(135,'Twisted Lime'),(136,'Fusion Citrica'),(137,'Tamarindo Citrus'),(138,'Manzana-TeVerde-Clorofila'),(139,'Horchata'),(140,'Toronja Citrus'),(141,'Cola Kaffe'),(143,'Frambuesa'),(144,'Melon'),(145,'Root Beer'),(146,'Naranja Pasion'),(147,'Té Helado'),(148,'Té Helado Light'),(151,'Sidra Negra'),(152,'Té Verde'),(153,'Té Verde Light'),(154,'Lima Limon Bite'),(155,'Mango-Mandarina'),(156,'Pera'),(157,'Manzanilla'),(158,'Clorofila'),(159,'Blue Gator'),(160,'Red Tilian'),(161,'Purplesnake'),(165,'Mocha'),(166,'Coffee'),(167,'Toronja Sal y Limón'),(168,'World Shangai'),(169,'World Sao Paulo'),(170,'World Sidney'),(171,'World Nairobi'),(172,'World Atena'),(173,'Tropical Citrus'),(176,'Mzna-Kiwi-Fresa'),(177,'Vainilla'),(179,'Citrus Punch'),(180,'Conga'),(181,'Fruit Punch'),(182,'Naranja-Piña'),(183,'Narazul'),(184,'Cola Fire'),(185,'Cola Gold'),(186,'Cola Kick'),(187,'Cola Retro'),(188,'Cola Clear'),(189,'Toronja Pink'),(190,'Lima Limon Light'),(191,'Cola Natural'),(192,'Red'),(195,'Original'),(196,'Original Light'),(198,'Cola Wiwichu'),(199,'Té frambuesa'),(201,'MznaLight'),(202,'CLightsCaf'),(203,'TeaSweet'),(204,'PepsiCuau'),(205,'Citrus'),(206,'Narkum'),(207,'TorMojito'),(208,'MANGO DURAZNO'),(209,'MANZANA ROJA'),(210,'PINA-COCO'),(212,'TORONJA VERDE'),(213,'Lim Pep'),(214,'Nat Sweet'),(215,'CoolPurple'),(216,'SdiaCitric'),(217,'VnillaLght'),(218,'MochaLight'),(219,'Dshot'),(220,'Limonada'),(221,'CoctelFr'),(222,'BooPop'),(223,'BomEn'),(224,'Tequila'),(225,'BooNor'),(226,'BooLight'),(227,'Té Vd Miel'),(228,'MngExotico'),(229,'Chocolate'),(230,'RipRush'),(231,'Té Vde Mgo'),(233,'Caramel'),(234,'MngVde'),(235,'Manzana Amarilla'),(236,'Té Vde Per Dur'),(237,'MngoMara'),(238,'MngoCoLi'),(239,'Mora Intensa'),(240,'Limonada Congelada'),(241,'TorMin'),(242,'NarMin'),(243,'DurGua'),(244,'LimMin'),(245,'ChocBco'),(246,'ManMin'),(247,'Arandano'),(248,'Arandano-Jamaica'),(249,'Cookies and Creme'),(255,'Mzna-Pera'),(256,'Maracuya'),(258,'Cola Jugo LImon'),(260,'DulceLeche'),(998,'Otros'),(999,'Multisabor'),(1000,'Sin Sabor');
/*!40000 ALTER TABLE `sabor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `segmento`
--

DROP TABLE IF EXISTS `segmento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `segmento` (
  `idsegmento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`idsegmento`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `segmento`
--

LOCK TABLES `segmento` WRITE;
/*!40000 ALTER TABLE `segmento` DISABLE KEYS */;
INSERT INTO `segmento` VALUES (1,'Refresco'),(2,'Agua Embotellada'),(3,'Garrafón'),(4,'Hielo'),(5,'Otros'),(6,'Mix'),(7,'No Carbonatados'),(8,'Envase'),(9,'Envase Garrafón'),(10,'PO1'),(11,'Alimentos'),(12,'Exhibidor'),(13,'Manufactura'),(14,'Plástico'),(15,'Promocionales'),(16,'Rack'),(17,'Tanque'),(18,'Tarimas'),(19,'Gas Carbónico');
/*!40000 ALTER TABLE `segmento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zona`
--

DROP TABLE IF EXISTS `zona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zona` (
  `idZona` int(11) NOT NULL AUTO_INCREMENT,
  `idRegion` int(11) NOT NULL,
  `zona` varchar(45) NOT NULL,
  `gerenteZona` varchar(45) NOT NULL,
  `Correo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idZona`),
  KEY `fk_zona_Region1_idx` (`idRegion`),
  CONSTRAINT `fk_zona_Region1` FOREIGN KEY (`idRegion`) REFERENCES `region` (`idRegion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zona`
--

LOCK TABLES `zona` WRITE;
/*!40000 ALTER TABLE `zona` DISABLE KEYS */;
INSERT INTO `zona` VALUES (1,1,'Oriente Metro','Jaime Martin',NULL),(2,1,'Poniente Metro','Agustin Vallejo',NULL),(3,1,'Queretaro','Pendiente',NULL),(4,2,'Guadalajara','Luis Vitela',NULL),(5,2,'Morelia','Fernando Amezcua',NULL),(6,3,'Baja Norte','Victor Valadez',NULL),(7,3,'Chihuahua','Pendiente',NULL),(8,4,'Oaxaca','Octavio Flores',NULL),(9,4,'Veracruz','Juan Morin',NULL),(10,5,'Chiapas Altos','Javier Acuna',NULL),(11,5,'Yucatan','Gustavo Flores',NULL),(12,4,'Puebla - Tlaxcala','Guillermo Esparza',NULL),(13,2,'Costa Colima - Nayarit','Pendiente',NULL),(14,2,'Celaya','Rafael Velazco',NULL),(15,3,'Sinaloa',' s',NULL),(16,3,'Sinaloa','Pendiente',NULL),(17,6,'Tampico','Miguel Angel Rico',NULL),(18,5,'Cancun','---',NULL),(19,6,'Durango','---',NULL),(20,3,'Sonora','-------',NULL),(21,4,'Morelos','Horacio Treviño',NULL),(22,2,'Leon','aaaaa',NULL),(23,4,'Guerrero','--------',NULL),(24,6,'Monterrey','-',NULL),(25,1,'Norte','--',NULL),(26,2,'Aguascalientes','-----',NULL);
/*!40000 ALTER TABLE `zona` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-12 10:07:30
