-- MySQL dump 10.16  Distrib 10.1.38-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: geochemcps.cdoa1kg91nzl.ap-south-1.rds.amazonaws.com    Database: uat_gmarks
-- ------------------------------------------------------
-- Server version	5.5.59

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
-- Table structure for table `coc_number`
--

DROP TABLE IF EXISTS `coc_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coc_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no` varchar(255) DEFAULT NULL,
  `report_id` int(11) NOT NULL,
  `reg_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `not_change` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coc_number`
--

LOCK TABLES `coc_number` WRITE;
/*!40000 ALTER TABLE `coc_number` DISABLE KEYS */;
INSERT INTO `coc_number` VALUES (1,'GC-AE-055-00001',4,4,10,'2021-01-18 10:19:51',0,1),(2,'GC-AE-055-00002',5,5,12,'2021-01-18 11:41:23',0,1);
/*!40000 ALTER TABLE `coc_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coc_number_gec`
--

DROP TABLE IF EXISTS `coc_number_gec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coc_number_gec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no` varchar(255) DEFAULT NULL,
  `report_id` int(11) NOT NULL,
  `reg_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `not_change` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coc_number_gec`
--

LOCK TABLES `coc_number_gec` WRITE;
/*!40000 ALTER TABLE `coc_number_gec` DISABLE KEYS */;
INSERT INTO `coc_number_gec` VALUES (1,'GC-AE-2021-055-00001',1,1,12,'2021-01-18 09:20:13',0,1),(2,'GC-AE-2021-055-00002',2,3,10,'2021-01-18 09:28:14',0,1),(3,'GC-AE-2021-055-00003',6,6,12,'2021-01-18 11:50:03',0,1);
/*!40000 ALTER TABLE `coc_number_gec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_location_add`
--

DROP TABLE IF EXISTS `company_location_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_location_add` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `mst_country_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_location_add`
--

LOCK TABLES `company_location_add` WRITE;
/*!40000 ALTER TABLE `company_location_add` DISABLE KEYS */;
INSERT INTO `company_location_add` VALUES (1,234,'Geo-Chem Middle East - CPS','Plot No. 18-0, Affection Plan # 597-22, <br>\r\nEBC Warehouse # 6, Dubai Investment Park II,<br>\r\nP.O.Box 5778. Dubai, United Arab Emirates.','2021-01-17 07:23:55','1');
/*!40000 ALTER TABLE `company_location_add` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country_tax`
--

DROP TABLE IF EXISTS `country_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country_tax` (
  `country_tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_tax_name` varchar(100) NOT NULL,
  `tax_precentage` varchar(100) DEFAULT NULL,
  `country_id` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`country_tax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country_tax`
--

LOCK TABLES `country_tax` WRITE;
/*!40000 ALTER TABLE `country_tax` DISABLE KEYS */;
INSERT INTO `country_tax` VALUES (1,'others','5',NULL,NULL,'2021-01-18 10:01:51','1'),(2,'others','5',NULL,NULL,'2021-01-18 10:09:45','1');
/*!40000 ALTER TABLE `country_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `code` varchar(3) CHARACTER SET utf8 NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `symbol` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES ('ALL','Leke','Lek'),('USD','Dollars','$'),('AFN','Afghanis','؋'),('ARS','Pesos','$'),('AWG','Guilders','ƒ'),('AUD','Dollars','$'),('AZN','New Manats','ман'),('BSD','Dollars','$'),('BBD','Dollars','$'),('BYR','Rubles','p.'),('EUR','Euro','€'),('BZD','Dollars','BZ$'),('BMD','Dollars','$'),('BOB','Bolivianos','$b'),('BAM','Convertible Marka','KM'),('BWP','Pula','P'),('BGN','Leva','лв'),('BRL','Reais','R$'),('GBP','Pounds','£'),('BND','Dollars','$'),('KHR','Riels','៛'),('CAD','Dollars','$'),('KYD','Dollars','$'),('CLP','Pesos','$'),('CNY','Yuan Renminbi','¥'),('COP','Pesos','$'),('CRC','Colón','₡'),('HRK','Kuna','kn'),('CUP','Pesos','₱'),('CZK','Koruny','Kč'),('DKK','Kroner','kr'),('DOP','Pesos','RD$'),('XCD','Dollars','$'),('EGP','Pounds','£'),('SVC','Colones','$'),('FKP','Pounds','£'),('FJD','Dollars','$'),('GHC','Cedis','¢'),('GIP','Pounds','£'),('GTQ','Quetzales','Q'),('GGP','Pounds','£'),('GYD','Dollars','$'),('HNL','Lempiras','L'),('HKD','Dollars','$'),('HUF','Forint','Ft'),('ISK','Kronur','kr'),('IRR','Rials','﷼'),('IMP','Pounds','£'),('ILS','New Shekels','₪'),('JMD','Dollars','J$'),('JPY','Yen','¥'),('JEP','Pounds','£'),('KZT','Tenge','лв'),('KPW','Won','₩'),('KRW','Won','₩'),('KGS','Soms','лв'),('LAK','Kips','₭'),('LVL','Lati','Ls'),('LBP','Pounds','£'),('LRD','Dollars','$'),('CHF','Switzerland Francs','CHF'),('LTL','Litai','Lt'),('MKD','Denars','ден'),('MYR','Ringgits','RM'),('MUR','Rupees','₨'),('MXN','Pesos','$'),('MNT','Tugriks','₮'),('MZN','Meticais','MT'),('NAD','Dollars','$'),('NPR','Rupees','₨'),('ANG','Guilders','ƒ'),('NZD','Dollars','$'),('NIO','Cordobas','C$'),('NGN','Nairas','₦'),('NOK','Krone','kr'),('OMR','Rials','﷼'),('PKR','Rupees','₨'),('PAB','Balboa','B/.'),('PYG','Guarani','Gs'),('PEN','Nuevos Soles','S/.'),('PHP','Pesos','Php'),('PLN','Zlotych','zł'),('QAR','Rials','﷼'),('RON','New Lei','lei'),('RUB','Rubles','руб'),('SHP','Pounds','£'),('SAR','Riyals','﷼'),('RSD','Dinars','Дин.'),('SCR','Rupees','₨'),('SGD','Dollars','$'),('SBD','Dollars','$'),('SOS','Shillings','S'),('ZAR','Rand','R'),('LKR','Rupees','₨'),('SEK','Kronor','kr'),('SRD','Dollars','$'),('SYP','Pounds','£'),('TWD','New Dollars','NT$'),('THB','Baht','฿'),('TTD','Dollars','TT$'),('TRY','Lira','₺'),('TRL','Liras','£'),('TVD','Dollars','$'),('UAH','Hryvnia','₴'),('UYU','Pesos','$U'),('UZS','Sums','лв'),('VEF','Bolivares Fuertes','Bs'),('VND','Dong','₫'),('YER','Rials','﷼'),('ZWD','Zimbabwe Dollars','Z$'),('INR','Rupees','₹');
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_type`
--

DROP TABLE IF EXISTS `customer_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_type` (
  `customer_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_type_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_type`
--

LOCK TABLES `customer_type` WRITE;
/*!40000 ALTER TABLE `customer_type` DISABLE KEYS */;
INSERT INTO `customer_type` VALUES (1,'SUPPLIER','2020-05-19 08:55:33'),(2,'EXPORTER','2020-05-19 08:55:55'),(3,'IMPORTER','2020-05-19 08:56:13'),(4,'CUSTOMER','2020-05-19 08:56:26');
/*!40000 ALTER TABLE `customer_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_registration`
--

DROP TABLE IF EXISTS `document_registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_registration` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `document_others` text,
  `upload_path` varchar(255) NOT NULL,
  `documents_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`doc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_registration`
--

LOCK TABLES `document_registration` WRITE;
/*!40000 ALTER TABLE `document_registration` DISABLE KEYS */;
INSERT INTO `document_registration` VALUES (1,1,NULL,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00001/documents/GC-DXB-GSO-2021-00001-09_06_26.jpg',1,7,'2021-01-18 09:06:26'),(2,3,NULL,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00003/documents/GC-DXB-GSO-2021-00003-09_15_06.pdf',2,10,'2021-01-18 09:15:06'),(3,3,NULL,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00003/documents/GC-DXB-GSO-2021-00003-09_15_27.pdf',1,10,'2021-01-18 09:15:27'),(4,2,NULL,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00002/documents/RFC_DOCUMENT_372.pdf',1,10,'2021-01-18 09:40:18'),(5,4,NULL,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00004/documents/GC-DXB-GSO-2021-00004-09_55_40.pdf',1,10,'2021-01-18 09:55:40'),(6,6,NULL,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00006/documents/GC-DXB-GSO-2021-00006-11_23_56.pdf',3,12,'2021-01-18 11:23:56'),(7,6,NULL,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00006/documents/GC-DXB-GSO-2021-00006-11_24_13.pdf',1,12,'2021-01-18 11:24:13'),(8,5,NULL,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00005/documents/RFC_DOCUMENT_22.pdf',1,12,'2021-01-18 11:26:40');
/*!40000 ALTER TABLE `document_registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` text NOT NULL,
  `doc_need` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (1,'RFC',1,1,'10','2020-12-16 23:46:58'),(2,'Written declaration that the same application has not been lodged with any other Notified Body',0,1,'8','2020-12-16 23:46:58'),(3,'Applicant Declaration of Conformity- Importer / Manufacturer',0,1,'8','2020-12-16 23:46:58'),(4,'Product description of Toy',0,1,'8','2020-12-16 23:46:58'),(5,'Properly filled and signed Application Form (Product description, List of applicable Standards. etc)',0,1,'1','2020-12-16 23:46:58'),(6,'Manufacturer’s Risk Analysis',0,1,'1','2020-12-16 23:46:58'),(7,'Clear Photos of the product (showing the Brand /Trade mark etc.).',0,1,'1','2020-12-16 23:46:58'),(8,'Instruction Manuals (Assembly instruction, user manual .etc) in Arabic language at least',0,1,'10','2020-12-16 23:46:58'),(9,'Other tech. documents, if Any',0,1,'1','2020-12-16 23:46:58'),(10,'The addresses of the places of manufacture',0,1,'1','2020-12-16 23:46:58'),(11,'Results of design calculations made, examinations carried out etc',0,1,'1','2020-12-16 23:46:58'),(12,'Pro-Foma or Final Invoice',0,1,'8','2020-12-16 23:46:58'),(13,'Packing List',0,1,'8','2020-12-16 23:46:58'),(14,'Test Reports',0,1,'8','2020-12-16 23:46:58'),(15,'Applicant Commercial Registry Certificate',0,0,'8','2021-01-09 14:43:47');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `functions`
--

DROP TABLE IF EXISTS `functions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `functions` (
  `function_id` int(11) NOT NULL AUTO_INCREMENT,
  `function_name` varchar(255) NOT NULL,
  `controller_name` varchar(255) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '0=>deactive,1=>active',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`function_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `functions`
--

LOCK TABLES `functions` WRITE;
/*!40000 ALTER TABLE `functions` DISABLE KEYS */;
INSERT INTO `functions` VALUES (1,'index','ApplicationType','APPLICATION LISTING',1,'2021-01-09 13:04:38'),(2,'add_application','ApplicationType','ADD APPLICATION TYPE',1,'2021-01-09 13:05:41'),(3,'edit_application','ApplicationType','EDIT APPLICATION',1,'2021-01-09 13:06:02'),(4,'index','Customer','CUSTOMER LISTING',1,'2021-01-09 13:25:28'),(5,'add_customer','Customer','ADD CUSTOMER',1,'2021-01-09 13:25:48'),(6,'edit_customer','Customer','EDIT CUSTOMER',1,'2021-01-09 13:26:01'),(7,'index','Document','DOCUMENT LISTING',1,'2021-01-09 13:26:36'),(8,'add_document','Document','ADD DOCUMENT',1,'2021-01-09 13:26:48'),(9,'edit_document','Document','EDIT DOCUMENT',1,'2021-01-09 13:27:11'),(10,'index','ExaminationMethod','EXAMINATION METHOD LISTING',1,'2021-01-09 13:27:48'),(11,'add_examination','ExaminationMethod','ADD EXAMINATION METHOD',1,'2021-01-09 13:28:08'),(12,'edit_examination','ExaminationMethod','EDIT EXAMINATION METHOD',1,'2021-01-09 13:28:24'),(13,'index','Gmark','REQUEST LISTING',1,'2021-01-09 13:30:59'),(14,'registration','Gmark','ADD REQUEST',1,'2021-01-09 13:31:20'),(15,'add_application','Gmark','ADD APPLICATION BY REQUEST',1,'2021-01-09 13:32:47'),(16,'add_lab','Gmark','ADD LAB BY REQUEST',1,'2021-01-09 13:33:10'),(17,'add_sub_lab','Gmark','ADD SUB LAB BY REQUEST',1,'2021-01-09 13:33:39'),(18,'add_legal_entity','Gmark','ADD LEGAL ENTITY BY REQUEST',1,'2021-01-09 13:34:07'),(19,'add_ex_method','Gmark','ADD EXAMINATION METHOD BY REQUEST',1,'2021-01-09 13:34:38'),(20,'insert_gmark_registration','Gmark','ADD REQUEST FORM',1,'2021-01-09 13:34:57'),(21,'edit_submit_gmark_registration','Gmark','EDIT REQUEST FORM',1,'2021-01-09 13:35:09'),(22,'customer_Add','Gmark','ADD CUSTOMER BY REQUEST',1,'2021-01-09 13:36:25'),(23,'Upload_document','Gmark','UPLOAD DOCUMENT IN REQUEST',1,'2021-01-09 13:37:03'),(24,'view_document_listing','Gmark','VIEW DOCUMENT LIST IN REQUEST',1,'2021-01-09 13:37:36'),(25,'Rfc_document','Gmark','GENERATE RFC DOCUMENT IN REQUEST',1,'2021-01-09 13:38:06'),(26,'EDIT_Rfc_document','Gmark','EDIT RFC DOCUMENT IN REQUEST',1,'2021-01-09 13:38:38'),(27,'rfc_pdf','Gmark','VIEW RFC PDF IN REQUEST',1,'2021-01-09 13:39:07'),(28,'release_rfc_pdf','Gmark','RELEASE RFC DOCUMENT IN REQUEST',1,'2021-01-09 13:39:27'),(29,'approved_request','Gmark','APPROVED REQUEST',1,'2021-01-09 13:39:54'),(30,'index','Invoice','JOB LISTING',1,'2021-01-09 13:40:55'),(31,'add_invoice','Invoice','GENERATE INVOICE',1,'2021-01-09 13:41:19'),(32,'edit_invoice','Invoice','EDIT INVOICE',1,'2021-01-09 13:41:31'),(33,'index','Lab','LAB LISTING',1,'2021-01-09 13:42:21'),(34,'add_lab','Lab','ADD LAB',1,'2021-01-09 13:42:36'),(35,'edit_lab','Lab','EDIT LAB',1,'2021-01-09 13:42:48'),(36,'index','Legal_Entity','LEGAL ENTITY LISTING',1,'2021-01-09 13:43:33'),(37,'add_legalEntity','Legal_Entity','ADD LEGAL ENTITY',1,'2021-01-09 13:43:52'),(38,'edit_legalEntity','Legal_Entity','EDIT LEGAL ENTITY',1,'2021-01-09 13:44:13'),(39,'index','Operation','OPERATION LISTING',1,'2021-01-09 13:44:35'),(40,'add','Operation','ADD OPERATION',1,'2021-01-09 13:45:04'),(41,'edit','Operation','EDIT OPERATION',1,'2021-01-09 13:45:19'),(42,'index','Regenerate','REGENERATE LISTING',1,'2021-01-09 13:46:21'),(43,'approval','Regenerate','APPROVAL REGENRATE REPORT',1,'2021-01-09 13:46:43'),(44,'approved','Regenerate','APPROVED REGENRATE REPORT REQUEST',1,'2021-01-09 13:47:20'),(45,'reject','Regenerate','REJECT REGENRATE REQUEST',1,'2021-01-09 13:47:43'),(46,'index','Reports','REPORT LISTING',1,'2021-01-09 13:48:11'),(47,'image_upload','Reports','REPORT IMAGE UPLOAD CONTENT',1,'2021-01-09 13:48:41'),(48,'pdf_view','Reports','PDF VIEW WITHOUT RELEASE',1,'2021-01-09 13:50:52'),(49,'content_upload','Reports','REPORT CONTENT UPLOAD',1,'2021-01-09 13:51:27'),(50,'edit_content_upload','Reports','EDIT REPORT CONTENT',1,'2021-01-09 13:51:42'),(51,'approved_pdf','Reports','APPROVED REPORT FOR RELEASE',1,'2021-01-09 13:52:40'),(52,'release_pdf','Reports','RELEASE REPORT',1,'2021-01-09 13:53:30'),(53,'download_pdf','Reports','DOWNLOAD PDF REPORT',1,'2021-01-09 13:53:55'),(54,'re_genrate_process','Reports','REGENRATE REPORT',1,'2021-01-09 13:54:22'),(55,'index','Role','ROLE LISTING',1,'2021-01-09 13:55:23'),(56,'add','Role','ROLE ADD',1,'2021-01-09 13:55:57'),(57,'edit','Role','ROLE EDIT',1,'2021-01-09 13:56:11'),(58,'save_permission','Role','PERMISSION SET',1,'2021-01-09 13:56:39'),(59,'index','SubLab','SUB LAB LISTING',1,'2021-01-09 13:56:54'),(60,'add_sublab','SubLab','ADD SUB LAB',1,'2021-01-09 13:57:15'),(61,'edit_sublab','SubLab','EDIT SUB LAB',1,'2021-01-09 13:57:30'),(62,'index','User','USER LISTING',1,'2021-01-09 14:30:46'),(63,'add_user','User','ADD USER',1,'2021-01-09 14:31:08'),(64,'edit_user','User','EDIT USER',1,'2021-01-09 14:31:26'),(65,'sign_upload','User','USER SIGN UPLOAD',1,'2021-01-09 14:31:49'),(66,'log','Gmark','LOG DETAILS',1,'2021-01-09 15:22:50'),(67,'view','Invoice','VIEW INVOICE',1,'2021-01-10 09:22:27'),(68,'log','Reports','LOG REPORT',1,'2021-01-10 09:38:23'),(69,'edit_gmark_registration','Gmark','EDIT FORM REQUEST',1,'2021-01-12 08:41:55'),(70,'download_all_pdf','Reports','DOWNLOAD ALL DOCUMENT PERTICULAR REPORT',1,'2021-01-13 10:37:06'),(71,'release_document_upload','Reports','UPLOAD RELEASE DOCUMENT',1,'2021-01-14 04:56:28'),(72,'get_release_document','Reports','VIEW RELEASE DOCUMENT',1,'2021-01-14 04:56:58'),(73,'delte_document','Gmark','DELETE UPLOAD DOCUMENT IN GMARK',1,'2021-01-18 14:07:28'),(74,'send_email','Reports','SEND EMAIL REPORT',1,'2021-01-18 15:32:01');
/*!40000 ALTER TABLE `functions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_application`
--

DROP TABLE IF EXISTS `gmark_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_application` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT,
  `application_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `application_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_application`
--

LOCK TABLES `gmark_application` WRITE;
/*!40000 ALTER TABLE `gmark_application` DISABLE KEYS */;
INSERT INTO `gmark_application` VALUES (1,'GEC','GULF TYPE EXMINATION CERTIFICATE','2021-01-18 08:48:54','7'),(2,'COC','CERTIFICATE OF CONFORMITY','2021-01-18 08:49:14','7');
/*!40000 ALTER TABLE `gmark_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_customers`
--

DROP TABLE IF EXISTS `gmark_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_customers` (
  `customers_id` int(11) NOT NULL AUTO_INCREMENT,
  `licence_no` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `entity_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `address` text COLLATE utf8mb4_bin NOT NULL,
  `country` int(11) NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `customer_type` int(11) NOT NULL DEFAULT '0',
  `contact_title` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `phn_no` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customers_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_customers`
--

LOCK TABLES `gmark_customers` WRITE;
/*!40000 ALTER TABLE `gmark_customers` DISABLE KEYS */;
INSERT INTO `gmark_customers` VALUES (1,'1123213','ABC COMPANY','awsdsad',1,'23432',1,'sdfdsf','sdfsdf','2123123123','asdsa@gmail.com',0,1,'2021-01-18 08:54:30'),(2,'wdas321321','XYZ COMPANY','dsfgfd',3,'fgsd',2,'fgsdf','gdsfg','334534543','xzcv@gmail.com',0,1,'2021-01-18 08:54:49'),(3,'asdasdasd','asd company','asdsad',3,'sad',4,'sadas','das','3342213123','sdsad@gmail.com',0,1,'2021-01-18 08:55:05'),(4,'','abc','dfds',32,'amit',2,'ss','dfs','fdf','ss@d.com',10,1,'2021-01-18 10:05:30');
/*!40000 ALTER TABLE `gmark_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_examination_method`
--

DROP TABLE IF EXISTS `gmark_examination_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_examination_method` (
  `ex_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_method_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `ex_method_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`ex_method_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_examination_method`
--

LOCK TABLES `gmark_examination_method` WRITE;
/*!40000 ALTER TABLE `gmark_examination_method` DISABLE KEYS */;
INSERT INTO `gmark_examination_method` VALUES (1,'asd','asdsa','2021-01-18 08:49:40','7'),(2,'dfds','dfds','2021-01-18 10:07:12','10');
/*!40000 ALTER TABLE `gmark_examination_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_laboratory_type`
--

DROP TABLE IF EXISTS `gmark_laboratory_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_laboratory_type` (
  `lab_id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `lab_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`lab_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_laboratory_type`
--

LOCK TABLES `gmark_laboratory_type` WRITE;
/*!40000 ALTER TABLE `gmark_laboratory_type` DISABLE KEYS */;
INSERT INTO `gmark_laboratory_type` VALUES (1,'sad','asd','2021-01-18 08:49:25','7'),(2,'geochem1','geochem1','2021-01-18 09:08:19','10'),(3,'fdsf','dfdsf','2021-01-18 10:06:35','10');
/*!40000 ALTER TABLE `gmark_laboratory_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_legal_entity_type`
--

DROP TABLE IF EXISTS `gmark_legal_entity_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_legal_entity_type` (
  `legal_entity_id` int(11) NOT NULL AUTO_INCREMENT,
  `legal_entity_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `legal_entity_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`legal_entity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_legal_entity_type`
--

LOCK TABLES `gmark_legal_entity_type` WRITE;
/*!40000 ALTER TABLE `gmark_legal_entity_type` DISABLE KEYS */;
INSERT INTO `gmark_legal_entity_type` VALUES (1,'sdsa','da','2021-01-18 08:49:35','7'),(2,'abc','abc','2021-01-18 09:09:41','10'),(3,'dfds','dfdsf','2021-01-18 10:07:04','10');
/*!40000 ALTER TABLE `gmark_legal_entity_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_log_all_users`
--

DROP TABLE IF EXISTS `gmark_log_all_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_log_all_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` text,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_log_all_users`
--

LOCK TABLES `gmark_log_all_users` WRITE;
/*!40000 ALTER TABLE `gmark_log_all_users` DISABLE KEYS */;
INSERT INTO `gmark_log_all_users` VALUES (1,'Add Application Name:- GEC ',7,'2021-01-18 08:48:54'),(2,'Add Application Name:- COC ',7,'2021-01-18 08:49:14'),(3,'Add LAB Name:- sad ',7,'2021-01-18 08:49:25'),(4,'Add Sub LAB Name:- sad ',7,'2021-01-18 08:49:31'),(5,'Add Legal Entity Name:- sdsa ',7,'2021-01-18 08:49:35'),(6,'Add Examination Method Name:- asd ',7,'2021-01-18 08:49:40'),(7,'Add CUSTOMER NAME :- ABC COMPANY ',7,'2021-01-18 08:54:30'),(8,'Add CUSTOMER NAME :- XYZ COMPANY ',7,'2021-01-18 08:54:49'),(9,'Add CUSTOMER NAME :- asd company ',7,'2021-01-18 08:55:05'),(10,'Add USER Name :- Jocelyn EMAIL:- Jocelyn',7,'2021-01-18 09:02:23'),(11,'G-MARK NO:- GC-DXB-GSO-2021-00001 Registration Successfully ',7,'2021-01-18 09:05:59'),(12,'GC-DXB-GSO-2021-00001 :- Documents Name: RFC UPLOADED',7,'2021-01-18 09:06:26'),(13,'GC-DXB-GSO-2021-00001 :- APPROVED JOB NO IS :- GMARK-2021-000001',7,'2021-01-18 09:06:28'),(14,'Add Invoice:- INV-21-000001 ',7,'2021-01-18 09:07:29'),(15,'Add LAB Name:- geochem1 ',10,'2021-01-18 09:08:19'),(16,'Add SUB LAB Name:- sublab1 ',10,'2021-01-18 09:09:07'),(17,'Add Legal Entity Name:- abc ',10,'2021-01-18 09:09:41'),(18,'GC-DXB-GSO-2021-00001 :- PRODUCT IMAGE INSERT FOR REPORTS ',7,'2021-01-18 09:10:42'),(19,'G-MARK NO:- GC-DXB-GSO-2021-00002 Registration Successfully ',10,'2021-01-18 09:11:07'),(20,'G-MARK NO:- GC-DXB-GSO-2021-00003 Registration Successfully ',10,'2021-01-18 09:12:56'),(21,'GC-DXB-GSO-2021-00001 :- CONTENT UPLOAD',7,'2021-01-18 09:13:35'),(22,'GC-DXB-GSO-2021-00001 :- CONTENT UPLOAD',7,'2021-01-18 09:13:54'),(23,'GC-DXB-GSO-2021-00001 :- REPORT APPROVED BY Shankar Kumar',7,'2021-01-18 09:13:56'),(24,'Edit Document Name:- RFC ',10,'2021-01-18 09:14:27'),(25,'EDIT USER Name :- Jocelyn EMAIL:- Jocelyn',7,'2021-01-18 09:14:34'),(26,'GC-DXB-GSO-2021-00003 :- Documents Name: Written declaration that the same application has not been lodged with any other Notified Body UPLOADED',10,'2021-01-18 09:15:06'),(27,'GC-DXB-GSO-2021-00003 :- Documents Name: RFC UPLOADED',10,'2021-01-18 09:15:27'),(28,'GC-DXB-GSO-2021-00003 :- APPROVED JOB NO IS :- GMARK-2021-000002',10,'2021-01-18 09:15:53'),(29,'EDIT USER Name :- Jocelyn EMAIL:- Jocelyn',7,'2021-01-18 09:16:50'),(30,'Add Invoice:- INV-21-000002 ',10,'2021-01-18 09:17:14'),(31,'GC-DXB-GSO-2021-00003 :- INVOICE EDIT NO. INV-21-000002',10,'2021-01-18 09:18:44'),(32,'UPDATE USER SIGNATURE USER Name :- Jocelyn',12,'2021-01-18 09:19:12'),(33,' :- REPORT RELEASE',12,'2021-01-18 09:20:14'),(34,'GC-DXB-GSO-2021-00003 :- PRODUCT IMAGE INSERT FOR REPORTS ',10,'2021-01-18 09:21:42'),(35,'GC-DXB-GSO-2021-00001 REQUEST FOR RE-GENERTE REPORT',12,'2021-01-18 09:23:38'),(36,'GC-DXB-GSO-2021-00001 :- RE-GENERATE REQUEST APPROVED',12,'2021-01-18 09:24:21'),(37,'GC-DXB-GSO-2021-00001 :- RE-GENERATE REPORT SUCCESSFULLY',12,'2021-01-18 09:24:32'),(38,'GC-DXB-GSO-2021-00001 :- REPORT APPROVED BY Jocelyn Teodoro',12,'2021-01-18 09:24:36'),(39,' :- REPORT RELEASE',12,'2021-01-18 09:24:49'),(40,'GC-DXB-GSO-2021-00003 :- CONTENT UPLOAD',10,'2021-01-18 09:26:51'),(41,'GC-DXB-GSO-2021-00003 :- REPORT APPROVED BY Samrendra Singh',10,'2021-01-18 09:27:56'),(42,' :- REPORT RELEASE',10,'2021-01-18 09:28:15'),(43,'GC-DXB-GSO-2021-00003 :- RELEASE DOCUMENT UPLOAD GC-AE-2021-055-00002',10,'2021-01-18 09:32:14'),(44,'GC-DXB-GSO-2021-00003 REQUEST FOR RE-GENERTE REPORT',10,'2021-01-18 09:33:52'),(45,'GC-DXB-GSO-2021-00003 :- RE-GENERATE REQUEST APPROVED',10,'2021-01-18 09:34:10'),(46,'GC-DXB-GSO-2021-00003 :- RE-GENERATE REPORT SUCCESSFULLY',10,'2021-01-18 09:34:35'),(47,'GC-DXB-GSO-2021-00003 :- CONTENT UPLOAD',10,'2021-01-18 09:34:59'),(48,'GC-DXB-GSO-2021-00003 :- REPORT APPROVED BY Samrendra Singh',10,'2021-01-18 09:35:05'),(49,' :- REPORT RELEASE',10,'2021-01-18 09:35:18'),(50,'GC-DXB-GSO-2021-00002 :- RFC DOCUMENT CREATED ',10,'2021-01-18 09:37:27'),(51,'GC-DXB-GSO-2021-00002 :- RFC DOCUMENT EDIT ',10,'2021-01-18 09:38:36'),(52,'GC-DXB-GSO-2021-00002 :- RFC DOCUMENT EDIT ',10,'2021-01-18 09:39:34'),(53,'GC-DXB-GSO-2021-00002 :- RFC DOCUMENT EDIT ',10,'2021-01-18 09:40:05'),(54,'GC-DXB-GSO-2021-00002 :- RFC GENERATE FOR RELEASE',10,'2021-01-18 09:40:18'),(55,'GC-DXB-GSO-2021-00002 :- RFC GENERATED AND SUBMIT ON DOCUMENTS',10,'2021-01-18 09:40:18'),(56,'GC-DXB-GSO-2021-00002 :- APPROVED JOB NO IS :- GMARK-2021-000003',10,'2021-01-18 09:40:25'),(57,'Add Invoice:- INV-21-000003 ',10,'2021-01-18 09:40:52'),(58,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',10,'2021-01-18 09:44:12'),(59,'GC-DXB-GSO-2021-00002 :- REPORT APPROVED BY Samrendra Singh',10,'2021-01-18 09:46:52'),(60,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',12,'2021-01-18 09:50:17'),(61,'GC-DXB-GSO-2021-00002 :- PRODUCT IMAGE INSERT FOR REPORTS ',10,'2021-01-18 09:51:50'),(62,'G-MARK NO:- GC-DXB-GSO-2021-00004 Registration Successfully ',10,'2021-01-18 09:55:27'),(63,'GC-DXB-GSO-2021-00004 :- Documents Name: RFC UPLOADED',10,'2021-01-18 09:55:40'),(64,'GC-DXB-GSO-2021-00004 :- APPROVED JOB NO IS :- GMARK-2021-000004',10,'2021-01-18 09:55:43'),(65,'GC-DXB-GSO-2021-00004 :- CONTENT UPLOAD',10,'2021-01-18 09:57:13'),(66,'GC-DXB-GSO-2021-00004 :- PRODUCT IMAGE INSERT FOR REPORTS ',10,'2021-01-18 09:57:43'),(67,'GC-DXB-GSO-2021-00004 :- REPORT APPROVED BY Jocelyn Teodoro',12,'2021-01-18 09:58:52'),(68,'Add Invoice:- INV-21-000004 ',10,'2021-01-18 10:01:52'),(69,'Add Customer Name:- abc ',10,'2021-01-18 10:05:30'),(70,'Add Customer Name:- abc ',10,'2021-01-18 10:05:47'),(71,'Add LAB Name:- fdsf ',10,'2021-01-18 10:06:35'),(72,'Add Sub LAB Name:- dfdsf ',10,'2021-01-18 10:06:54'),(73,'Add Legal Entity Name:- dfds ',10,'2021-01-18 10:07:04'),(74,'Add Examination Method Name:- dfds ',10,'2021-01-18 10:07:12'),(75,'GC-DXB-GSO-2021-00004 :- INVOICE EDIT NO. INV-21-000004',10,'2021-01-18 10:09:46'),(76,'GC-DXB-GSO-2021-00004 :- RFC DOCUMENT CREATED ',10,'2021-01-18 10:11:40'),(77,'GC-DXB-GSO-2021-00003 :- RFC DOCUMENT CREATED ',10,'2021-01-18 10:13:11'),(78,' :- REPORT RELEASE',10,'2021-01-18 10:19:53'),(79,'GC-DXB-GSO-2021-00004 REQUEST FOR RE-GENERTE REPORT',10,'2021-01-18 10:20:14'),(80,'GC-DXB-GSO-2021-00004 :- RE-GENERATE REQUEST APPROVED',12,'2021-01-18 10:23:13'),(81,'GC-AE-2021-055-00002-001 :- ALL FILES ZIP DOWNLOAD',10,'2021-01-18 10:29:10'),(82,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',10,'2021-01-18 10:30:31'),(83,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',10,'2021-01-18 10:31:43'),(84,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',10,'2021-01-18 10:32:23'),(85,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',12,'2021-01-18 10:33:17'),(86,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',12,'2021-01-18 10:33:50'),(87,'G-MARK NO:- GC-DXB-GSO-2021-00004 Registration Successfully UPDATE',10,'2021-01-18 10:49:09'),(88,'EDIT USER Name :- jyoti EMAIL:- jyoti',12,'2021-01-18 11:08:34'),(89,'EDIT USER Name :- Samrendra EMAIL:- Samrendra',12,'2021-01-18 11:09:06'),(90,'EDIT USER Name :- lakshay EMAIL:- lakshay',12,'2021-01-18 11:09:14'),(91,'EDIT USER Name :- lakshay EMAIL:- lakshay',12,'2021-01-18 11:15:09'),(92,'GC-AE-055-00001 :- ALL FILES ZIP DOWNLOAD',8,'2021-01-18 11:17:42'),(93,'G-MARK NO:- GC-DXB-GSO-2021-00005 Registration Successfully ',12,'2021-01-18 11:21:29'),(94,'G-MARK NO:- GC-DXB-GSO-2021-00006 Registration Successfully ',12,'2021-01-18 11:23:08'),(95,'GC-DXB-GSO-2021-00006 :- Documents Name: Applicant Declaration of Conformity- Importer / Manufacturer UPLOADED',12,'2021-01-18 11:23:56'),(96,'GC-DXB-GSO-2021-00006 :- Documents Name: RFC UPLOADED',12,'2021-01-18 11:24:13'),(97,'GC-DXB-GSO-2021-00006 :- APPROVED JOB NO IS :- GMARK-2021-000005',12,'2021-01-18 11:24:24'),(98,'GC-DXB-GSO-2021-00005 :- RFC DOCUMENT CREATED ',12,'2021-01-18 11:26:30'),(99,'GC-DXB-GSO-2021-00005 :- RFC GENERATE FOR RELEASE',12,'2021-01-18 11:26:40'),(100,'GC-DXB-GSO-2021-00005 :- RFC GENERATED AND SUBMIT ON DOCUMENTS',12,'2021-01-18 11:26:40'),(101,'GC-DXB-GSO-2021-00005 :- APPROVED JOB NO IS :- GMARK-2021-000006',12,'2021-01-18 11:26:52'),(102,'Add Invoice:- INV-21-000005 ',12,'2021-01-18 11:28:21'),(103,'GC-DXB-GSO-2021-00005 :- PRODUCT IMAGE INSERT FOR REPORTS ',12,'2021-01-18 11:30:46'),(104,'GC-DXB-GSO-2021-00005 :- CONTENT UPLOAD',12,'2021-01-18 11:39:39'),(105,'GC-DXB-GSO-2021-00005 :- CONTENT UPLOAD',12,'2021-01-18 11:40:12'),(106,'GC-DXB-GSO-2021-00005 :- REPORT APPROVED BY Jocelyn Teodoro',12,'2021-01-18 11:40:38'),(107,' :- REPORT RELEASE',12,'2021-01-18 11:41:28'),(108,'GC-DXB-GSO-2021-00005 :- GMARK QR CODE UPDATE ',12,'2021-01-18 11:44:19'),(109,'GC-DXB-GSO-2021-00005 :- GMARK QR CODE UPDATE ',12,'2021-01-18 11:44:31'),(110,' :- REPORT RELEASE',12,'2021-01-18 11:46:45'),(111,'GC-DXB-GSO-2021-00006 :- PRODUCT IMAGE INSERT FOR REPORTS ',12,'2021-01-18 11:48:41'),(112,'GC-DXB-GSO-2021-00006 :- CONTENT UPLOAD',12,'2021-01-18 11:49:52'),(113,'GC-DXB-GSO-2021-00006 :- REPORT APPROVED BY Jocelyn Teodoro',12,'2021-01-18 11:49:55'),(114,' :- REPORT RELEASE',12,'2021-01-18 11:50:04'),(115,'ADD OPERATION NAME DELETE UPLOAD DOCUMENT IN GMARK',7,'2021-01-18 14:07:28'),(116,'ADD OPERATION NAME SEND EMAIL REPORT',7,'2021-01-18 15:32:01');
/*!40000 ALTER TABLE `gmark_log_all_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_product_con`
--

DROP TABLE IF EXISTS `gmark_product_con`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_product_con` (
  `product_con_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `hs_code` text COLLATE utf8mb4_bin NOT NULL,
  `product` text COLLATE utf8mb4_bin NOT NULL,
  `other_con_mark` text COLLATE utf8mb4_bin,
  `applicable_standard` text COLLATE utf8mb4_bin NOT NULL,
  `test_report` text COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_con_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_product_con`
--

LOCK TABLES `gmark_product_con` WRITE;
/*!40000 ALTER TABLE `gmark_product_con` DISABLE KEYS */;
INSERT INTO `gmark_product_con` VALUES (1,1,'sad','sa','dsa','d','asdasd',1,7,'2021-01-18 09:05:59'),(2,2,'sf','ssfsa','sfa','sf','sfsa',1,10,'2021-01-18 09:11:07'),(3,3,'dgd','gd','dgd','dg','dgds',1,10,'2021-01-18 09:12:55'),(5,4,'tgew','etew','te','te','te',1,10,'2021-01-18 10:49:09'),(6,5,'sdf','gsdfgsd','fgd','fsgd','fsgsdf',1,12,'2021-01-18 11:21:29'),(7,6,'dsf','sdf','sdf','sdf','sdf',1,12,'2021-01-18 11:23:08');
/*!40000 ALTER TABLE `gmark_product_con` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_products`
--

DROP TABLE IF EXISTS `gmark_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `hs_code` text COLLATE utf8mb4_bin NOT NULL,
  `product` text COLLATE utf8mb4_bin NOT NULL,
  `trade_mark` text COLLATE utf8mb4_bin,
  `mode_type_ref` text COLLATE utf8mb4_bin NOT NULL,
  `technical_details` text COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_products`
--

LOCK TABLES `gmark_products` WRITE;
/*!40000 ALTER TABLE `gmark_products` DISABLE KEYS */;
INSERT INTO `gmark_products` VALUES (1,1,'dsa','sa','dsa','dsa','das',1,7,'2021-01-18 09:05:59'),(7,2,'fasf','sfs','sdfs','fssa','sfa',1,10,'2021-01-18 09:40:05'),(10,3,'gsssd','dgd','dg','dgdsg','dg',1,10,'2021-01-18 10:13:11'),(11,4,'erew','erewr','erewrer','wer','erew',1,10,'2021-01-18 10:49:09'),(14,5,'dfsg','dsfg','dsf','gdsf','fgsdfg',1,12,'2021-01-18 11:26:30'),(13,6,'sd','f','sdfs','f','sdfsdf',1,12,'2021-01-18 11:23:08');
/*!40000 ALTER TABLE `gmark_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_registration`
--

DROP TABLE IF EXISTS `gmark_registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_registration` (
  `registration_id` int(11) NOT NULL AUTO_INCREMENT,
  `seq_no` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `coc_type` int(11) DEFAULT NULL,
  `applicant_id` int(11) NOT NULL,
  `legal_entity_type` int(11) NOT NULL,
  `application_type` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `factory_id` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `licensee_id` int(11) NOT NULL,
  `certificate_no` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `test_report_no` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `lab_id` int(11) NOT NULL,
  `sub_lab_id` int(11) NOT NULL,
  `destination` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `reg_status` int(11) NOT NULL DEFAULT '0',
  `sign_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `examination_id` int(11) NOT NULL,
  PRIMARY KEY (`registration_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_registration`
--

LOCK TABLES `gmark_registration` WRITE;
/*!40000 ALTER TABLE `gmark_registration` DISABLE KEYS */;
INSERT INTO `gmark_registration` VALUES (1,'GC-DXB-GSO-2021-00001',1,1,0,1,1,'1',1,'asdas','dsad',1,1,'195',1,2,12,7,'2021-01-18 09:05:59',1),(2,'GC-DXB-GSO-2021-00002',2,2,0,1,3,'2',1,'0112','',2,2,'17',1,2,12,10,'2021-01-18 09:11:07',1),(3,'GC-DXB-GSO-2021-00003',2,1,0,2,1,'3',2,'0221','',2,2,'120',1,2,12,10,'2021-01-18 09:12:55',1),(4,'GC-DXB-GSO-2021-00004',2,3,1,2,3,'3',1,'2112','2121',2,2,'17,247',1,2,12,10,'2021-01-18 09:55:27',1),(5,'GC-DXB-GSO-2021-00005',2,1,0,2,1,'1',2,'','',2,2,'120,180',1,2,12,12,'2021-01-18 11:21:29',2),(6,'GC-DXB-GSO-2021-00006',1,2,0,1,2,'2',1,'dsfds','sdfsdf',1,1,'180',1,2,12,12,'2021-01-18 11:23:08',1);
/*!40000 ALTER TABLE `gmark_registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_request_log`
--

DROP TABLE IF EXISTS `gmark_request_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_request_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `gmark_registration_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_request_log`
--

LOCK TABLES `gmark_request_log` WRITE;
/*!40000 ALTER TABLE `gmark_request_log` DISABLE KEYS */;
INSERT INTO `gmark_request_log` VALUES (1,1,'G-MARK NO:- GC-DXB-GSO-2021-00001 Registration Successfully ',7,'2021-01-18 09:05:59'),(2,1,'GC-DXB-GSO-2021-00001 :- Documents Name: RFC UPLOADED',7,'2021-01-18 09:06:26'),(3,1,'GC-DXB-GSO-2021-00001 :- APPROVED JOB NO IS :- GMARK-2021-000001',7,'2021-01-18 09:06:28'),(4,1,'Add Invoice:- INV-21-000001 ',7,'2021-01-18 09:07:29'),(5,1,'GC-DXB-GSO-2021-00001 :- PRODUCT IMAGE INSERT FOR REPORTS ',7,'2021-01-18 09:10:42'),(6,2,'G-MARK NO:- GC-DXB-GSO-2021-00002 Registration Successfully ',10,'2021-01-18 09:11:07'),(7,3,'G-MARK NO:- GC-DXB-GSO-2021-00003 Registration Successfully ',10,'2021-01-18 09:12:56'),(8,1,'GC-DXB-GSO-2021-00001 :- CONTENT UPLOAD',7,'2021-01-18 09:13:35'),(9,1,'GC-DXB-GSO-2021-00001 :- CONTENT UPLOAD',7,'2021-01-18 09:13:54'),(10,1,'GC-DXB-GSO-2021-00001 :- REPORT APPROVED BY Shankar Kumar',7,'2021-01-18 09:13:56'),(11,3,'GC-DXB-GSO-2021-00003 :- Documents Name: Written declaration that the same application has not been lodged with any other Notified Body UPLOADED',10,'2021-01-18 09:15:06'),(12,3,'GC-DXB-GSO-2021-00003 :- Documents Name: RFC UPLOADED',10,'2021-01-18 09:15:27'),(13,3,'GC-DXB-GSO-2021-00003 :- APPROVED JOB NO IS :- GMARK-2021-000002',10,'2021-01-18 09:15:53'),(14,3,'Add Invoice:- INV-21-000002 ',10,'2021-01-18 09:17:14'),(15,3,'GC-DXB-GSO-2021-00003 :- INVOICE EDIT NO. INV-21-000002',10,'2021-01-18 09:18:44'),(16,3,'GC-DXB-GSO-2021-00003 :- PRODUCT IMAGE INSERT FOR REPORTS ',10,'2021-01-18 09:21:42'),(17,1,'GC-DXB-GSO-2021-00001 REQUEST FOR RE-GENERTE REPORT',12,'2021-01-18 09:23:38'),(18,1,'GC-DXB-GSO-2021-00001 :- RE-GENERATE REQUEST APPROVED',12,'2021-01-18 09:24:21'),(19,1,'GC-DXB-GSO-2021-00001 :- RE-GENERATE REPORT SUCCESSFULLY',12,'2021-01-18 09:24:32'),(20,1,'GC-DXB-GSO-2021-00001 :- REPORT APPROVED BY Jocelyn Teodoro',12,'2021-01-18 09:24:36'),(21,3,'GC-DXB-GSO-2021-00003 :- CONTENT UPLOAD',10,'2021-01-18 09:26:51'),(22,3,'GC-DXB-GSO-2021-00003 :- REPORT APPROVED BY Samrendra Singh',10,'2021-01-18 09:27:56'),(23,3,'GC-DXB-GSO-2021-00003 :- RELEASE DOCUMENT UPLOAD GC-AE-2021-055-00002',10,'2021-01-18 09:32:14'),(24,3,'GC-DXB-GSO-2021-00003 REQUEST FOR RE-GENERTE REPORT',10,'2021-01-18 09:33:51'),(25,3,'GC-DXB-GSO-2021-00003 :- RE-GENERATE REQUEST APPROVED',10,'2021-01-18 09:34:10'),(26,3,'GC-DXB-GSO-2021-00003 :- RE-GENERATE REPORT SUCCESSFULLY',10,'2021-01-18 09:34:35'),(27,3,'GC-DXB-GSO-2021-00003 :- CONTENT UPLOAD',10,'2021-01-18 09:34:59'),(28,3,'GC-DXB-GSO-2021-00003 :- REPORT APPROVED BY Samrendra Singh',10,'2021-01-18 09:35:05'),(29,2,'GC-DXB-GSO-2021-00002 :- RFC DOCUMENT CREATED ',10,'2021-01-18 09:37:27'),(30,2,'GC-DXB-GSO-2021-00002 :- RFC DOCUMENT EDIT ',10,'2021-01-18 09:38:36'),(31,2,'GC-DXB-GSO-2021-00002 :- RFC DOCUMENT EDIT ',10,'2021-01-18 09:39:34'),(32,2,'GC-DXB-GSO-2021-00002 :- RFC DOCUMENT EDIT ',10,'2021-01-18 09:40:05'),(33,2,'GC-DXB-GSO-2021-00002 :- RFC GENERATE FOR RELEASE',10,'2021-01-18 09:40:18'),(34,2,'GC-DXB-GSO-2021-00002 :- RFC GENERATED AND SUBMIT ON DOCUMENTS',10,'2021-01-18 09:40:18'),(35,2,'GC-DXB-GSO-2021-00002 :- APPROVED JOB NO IS :- GMARK-2021-000003',10,'2021-01-18 09:40:25'),(36,2,'Add Invoice:- INV-21-000003 ',10,'2021-01-18 09:40:52'),(37,2,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',10,'2021-01-18 09:44:12'),(38,2,'GC-DXB-GSO-2021-00002 :- REPORT APPROVED BY Samrendra Singh',10,'2021-01-18 09:46:52'),(39,2,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',12,'2021-01-18 09:50:17'),(40,2,'GC-DXB-GSO-2021-00002 :- PRODUCT IMAGE INSERT FOR REPORTS ',10,'2021-01-18 09:51:50'),(41,4,'G-MARK NO:- GC-DXB-GSO-2021-00004 Registration Successfully ',10,'2021-01-18 09:55:27'),(42,4,'GC-DXB-GSO-2021-00004 :- Documents Name: RFC UPLOADED',10,'2021-01-18 09:55:40'),(43,4,'GC-DXB-GSO-2021-00004 :- APPROVED JOB NO IS :- GMARK-2021-000004',10,'2021-01-18 09:55:43'),(44,4,'GC-DXB-GSO-2021-00004 :- CONTENT UPLOAD',10,'2021-01-18 09:57:13'),(45,4,'GC-DXB-GSO-2021-00004 :- PRODUCT IMAGE INSERT FOR REPORTS ',10,'2021-01-18 09:57:43'),(46,4,'GC-DXB-GSO-2021-00004 :- REPORT APPROVED BY Jocelyn Teodoro',12,'2021-01-18 09:58:52'),(47,4,'Add Invoice:- INV-21-000004 ',10,'2021-01-18 10:01:52'),(48,4,'GC-DXB-GSO-2021-00004 :- INVOICE EDIT NO. INV-21-000004',10,'2021-01-18 10:09:46'),(49,4,'GC-DXB-GSO-2021-00004 :- RFC DOCUMENT CREATED ',10,'2021-01-18 10:11:40'),(50,3,'GC-DXB-GSO-2021-00003 :- RFC DOCUMENT CREATED ',10,'2021-01-18 10:13:11'),(51,4,'GC-DXB-GSO-2021-00004 REQUEST FOR RE-GENERTE REPORT',10,'2021-01-18 10:20:14'),(52,4,'GC-DXB-GSO-2021-00004 :- RE-GENERATE REQUEST APPROVED',12,'2021-01-18 10:23:13'),(53,3,'GC-AE-2021-055-00002-001 :- ALL FILES ZIP DOWNLOAD',10,'2021-01-18 10:29:10'),(54,2,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',10,'2021-01-18 10:30:31'),(55,2,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',10,'2021-01-18 10:31:43'),(56,2,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',10,'2021-01-18 10:32:23'),(57,2,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',12,'2021-01-18 10:33:17'),(58,2,'GC-DXB-GSO-2021-00002 :- CONTENT UPLOAD',12,'2021-01-18 10:33:50'),(59,4,'G-MARK NO:- GC-DXB-GSO-2021-00004 Registration Successfully UPDATE',10,'2021-01-18 10:49:09'),(60,4,'GC-AE-055-00001 :- ALL FILES ZIP DOWNLOAD',8,'2021-01-18 11:17:42'),(61,5,'G-MARK NO:- GC-DXB-GSO-2021-00005 Registration Successfully ',12,'2021-01-18 11:21:29'),(62,6,'G-MARK NO:- GC-DXB-GSO-2021-00006 Registration Successfully ',12,'2021-01-18 11:23:08'),(63,6,'GC-DXB-GSO-2021-00006 :- Documents Name: Applicant Declaration of Conformity- Importer / Manufacturer UPLOADED',12,'2021-01-18 11:23:56'),(64,6,'GC-DXB-GSO-2021-00006 :- Documents Name: RFC UPLOADED',12,'2021-01-18 11:24:13'),(65,6,'GC-DXB-GSO-2021-00006 :- APPROVED JOB NO IS :- GMARK-2021-000005',12,'2021-01-18 11:24:24'),(66,5,'GC-DXB-GSO-2021-00005 :- RFC DOCUMENT CREATED ',12,'2021-01-18 11:26:30'),(67,5,'GC-DXB-GSO-2021-00005 :- RFC GENERATE FOR RELEASE',12,'2021-01-18 11:26:40'),(68,5,'GC-DXB-GSO-2021-00005 :- RFC GENERATED AND SUBMIT ON DOCUMENTS',12,'2021-01-18 11:26:40'),(69,5,'GC-DXB-GSO-2021-00005 :- APPROVED JOB NO IS :- GMARK-2021-000006',12,'2021-01-18 11:26:52'),(70,5,'Add Invoice:- INV-21-000005 ',12,'2021-01-18 11:28:21'),(71,5,'GC-DXB-GSO-2021-00005 :- PRODUCT IMAGE INSERT FOR REPORTS ',12,'2021-01-18 11:30:46'),(72,5,'GC-DXB-GSO-2021-00005 :- CONTENT UPLOAD',12,'2021-01-18 11:39:39'),(73,5,'GC-DXB-GSO-2021-00005 :- CONTENT UPLOAD',12,'2021-01-18 11:40:12'),(74,5,'GC-DXB-GSO-2021-00005 :- REPORT APPROVED BY Jocelyn Teodoro',12,'2021-01-18 11:40:38'),(75,5,'GC-DXB-GSO-2021-00005 :- GMARK QR CODE UPDATE ',12,'2021-01-18 11:44:19'),(76,5,'GC-DXB-GSO-2021-00005 :- GMARK QR CODE UPDATE ',12,'2021-01-18 11:44:31'),(77,6,'GC-DXB-GSO-2021-00006 :- PRODUCT IMAGE INSERT FOR REPORTS ',12,'2021-01-18 11:48:41'),(78,6,'GC-DXB-GSO-2021-00006 :- CONTENT UPLOAD',12,'2021-01-18 11:49:52'),(79,6,'GC-DXB-GSO-2021-00006 :- REPORT APPROVED BY Jocelyn Teodoro',12,'2021-01-18 11:49:55');
/*!40000 ALTER TABLE `gmark_request_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gmark_sub_laboratory_type`
--

DROP TABLE IF EXISTS `gmark_sub_laboratory_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmark_sub_laboratory_type` (
  `Sub_lab_id` int(11) NOT NULL AUTO_INCREMENT,
  `Sub_lab_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `Sub_lab_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `gmark_laboratory_type_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`Sub_lab_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gmark_sub_laboratory_type`
--

LOCK TABLES `gmark_sub_laboratory_type` WRITE;
/*!40000 ALTER TABLE `gmark_sub_laboratory_type` DISABLE KEYS */;
INSERT INTO `gmark_sub_laboratory_type` VALUES (1,'sad','asd',1,'2021-01-18 08:49:31','7'),(2,'sublab1','',2,'2021-01-18 09:09:07','10'),(3,'dfdsf','dfds',3,'2021-01-18 10:06:54','10');
/*!40000 ALTER TABLE `gmark_sub_laboratory_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_details` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `invoice_attachment_name` varchar(200) DEFAULT NULL,
  `invoice_attachment_path_name` varchar(200) DEFAULT NULL,
  `payment_amount` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `number_of_container` varchar(100) DEFAULT NULL,
  `tax_type_value` varchar(200) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_location` varchar(255) DEFAULT NULL,
  `note` text,
  `total_amount` varchar(255) DEFAULT NULL,
  `discount` varchar(200) NOT NULL,
  `country_tax` varchar(255) NOT NULL,
  `tax_type` varchar(255) NOT NULL,
  `company_country` int(11) NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_details`
--

LOCK TABLES `invoice_details` WRITE;
/*!40000 ALTER TABLE `invoice_details` DISABLE KEYS */;
INSERT INTO `invoice_details` VALUES (1,1,'INV-21-000001','GC-DXB-GSO-2021-00001-Invoice.pdf','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00001/INVOICE/GC-DXB-GSO-2021-00001-Invoice.pdf','100',7,'2021-01-18 09:07:29',NULL,'','Geo-Chem Middle East - CPS','Plot No. 18-0, Affection Plan # 597-22, <br>\r\nEBC Warehouse # 6, Dubai Investment Park II,<br>\r\nP.O.Box 5778. Dubai, United Arab Emirates.','','103.84','12','GST,18','',114),(2,3,'INV-21-000002','INV-21-000002-Invoice.pdf','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00003/INVOICE/INV-21-000002-Invoice.pdf','500',10,'2021-01-18 09:17:14',NULL,'','Geo-Chem Middle East - CPS','Plot No. 18-0, Affection Plan # 597-22, <br>\r\nEBC Warehouse # 6, Dubai Investment Park II,<br>\r\nP.O.Box 5778. Dubai, United Arab Emirates.','test','560.5','5','GST,18','',114),(3,2,'INV-21-000003','GC-DXB-GSO-2021-00002-Invoice.pdf','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00002/INVOICE/GC-DXB-GSO-2021-00002-Invoice.pdf','20000',10,'2021-01-18 09:40:52',NULL,'','Geo-Chem Middle East - CPS','Plot No. 18-0, Affection Plan # 597-22, <br>\r\nEBC Warehouse # 6, Dubai Investment Park II,<br>\r\nP.O.Box 5778. Dubai, United Arab Emirates.','uukj','20580','2','VAT,5','',114),(4,4,'INV-21-000004','INV-21-000004-Invoice.pdf','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00004/INVOICE/INV-21-000004-Invoice.pdf','200',10,'2021-01-18 10:01:51',NULL,'5','Geo-Chem Middle East - CPS','Plot No. 18-0, Affection Plan # 597-22, <br>\r\nEBC Warehouse # 6, Dubai Investment Park II,<br>\r\nP.O.Box 5778. Dubai, United Arab Emirates.','','210','0','others','others',114),(5,5,'INV-21-000005','GC-DXB-GSO-2021-00005-Invoice.pdf','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00005/INVOICE/GC-DXB-GSO-2021-00005-Invoice.pdf','5000',12,'2021-01-18 11:28:21',NULL,'','Geo-Chem Middle East - CPS','Plot No. 18-0, Affection Plan # 597-22, <br>\r\nEBC Warehouse # 6, Dubai Investment Park II,<br>\r\nP.O.Box 5778. Dubai, United Arab Emirates.','','4410','16','VAT,5','',114);
/*!40000 ALTER TABLE `invoice_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_number`
--

DROP TABLE IF EXISTS `invoice_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_number`
--

LOCK TABLES `invoice_number` WRITE;
/*!40000 ALTER TABLE `invoice_number` DISABLE KEYS */;
INSERT INTO `invoice_number` VALUES (1,1,'2021-01-18 09:07:29'),(2,3,'2021-01-18 09:17:14'),(3,2,'2021-01-18 09:40:52'),(4,4,'2021-01-18 10:01:51'),(5,5,'2021-01-18 11:28:21');
/*!40000 ALTER TABLE `invoice_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_number`
--

DROP TABLE IF EXISTS `job_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_number` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `job_no` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_number`
--

LOCK TABLES `job_number` WRITE;
/*!40000 ALTER TABLE `job_number` DISABLE KEYS */;
INSERT INTO `job_number` VALUES (1,1,'GMARK-2021-000001',1,7,'2021-01-18 09:06:28'),(2,3,'GMARK-2021-000002',1,10,'2021-01-18 09:15:53'),(3,2,'GMARK-2021-000003',1,10,'2021-01-18 09:40:25'),(4,4,'GMARK-2021-000004',1,10,'2021-01-18 09:55:43'),(5,6,'GMARK-2021-000005',1,12,'2021-01-18 11:24:24'),(6,5,'GMARK-2021-000006',1,12,'2021-01-18 11:26:52');
/*!40000 ALTER TABLE `job_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `list_certified_item`
--

DROP TABLE IF EXISTS `list_certified_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_certified_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `qty` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `manufacturer` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `test_report_details` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `standards` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_certified_item`
--

LOCK TABLES `list_certified_item` WRITE;
/*!40000 ALTER TABLE `list_certified_item` DISABLE KEYS */;
INSERT INTO `list_certified_item` VALUES (5,1,'laksdh7','kjh87kjh','9kjb98','m98','kjh9',7,'2021-01-18 09:13:54'),(4,1,'lakshay','lakshay2','lkashay3','lkshay4','lkashay5',7,'2021-01-18 09:13:54'),(6,1,'po','po1','po2','po3','po4',7,'2021-01-18 09:13:54'),(8,3,'er','rwqr','wrqr','wrw','test',10,'2021-01-18 09:34:59'),(16,2,'asd','das','d','asd','asd',12,'2021-01-18 10:33:50'),(11,4,'dgds','dgds','dgds','dgs','dgds',10,'2021-01-18 09:57:13'),(23,5,'yo','yo','yo','yo','yo',12,'2021-01-18 11:40:12'),(22,5,'dsf','sdf','sdf','dsf','sdf',12,'2021-01-18 11:40:12'),(21,5,'ak','lk','lk','kjh','jk',12,'2021-01-18 11:40:12'),(24,5,'qwer','uy','tuyt','uyt','ut,:\';@',12,'2021-01-18 11:40:12'),(25,6,'ak','lk','lk','kjh','jk',12,'2021-01-18 11:49:52'),(26,6,'dsf','sdf','sdf','dsf','sdf',12,'2021-01-18 11:49:52');
/*!40000 ALTER TABLE `list_certified_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_country`
--

DROP TABLE IF EXISTS `mst_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_country` (
  `country_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Country of id primary key , Auto Increament ',
  `country_code` varchar(10) NOT NULL COMMENT 'Country code use as short name for country name',
  `country_name` varchar(50) NOT NULL COMMENT 'Name for country ',
  `status` enum('0','1') DEFAULT '1' COMMENT 'To  perform enable and disable the country',
  `created_by` smallint(5) unsigned DEFAULT NULL COMMENT 'Who  created the country  details',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When a country is created ',
  `updated_by` smallint(5) DEFAULT NULL COMMENT 'Who update the country ',
  `updated_on` timestamp NOT NULL DEFAULT '2020-10-11 00:11:11' COMMENT 'When a Country Field is Updated ',
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `country_code_UNIQUE` (`country_code`)
) ENGINE=MyISAM AUTO_INCREMENT=253 DEFAULT CHARSET=utf8 COMMENT='Managing  Master list of Countries in the Company. ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_country`
--

LOCK TABLES `mst_country` WRITE;
/*!40000 ALTER TABLE `mst_country` DISABLE KEYS */;
INSERT INTO `mst_country` VALUES (33,'IOT','British Indian Ocean Territory','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(32,'BRA','Brazil','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(31,'BVT','Bouvet Island','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(30,'BWA','Botswana','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(29,'BIH','Bosnia and Herzegovina','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(28,'BQ','Bonaire, Sint Eustatius and Saba','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(27,'BOL','Bolivia, Plurinational State of','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(26,'BTN','Bhutan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(25,'BMU','Bermuda','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(24,'BEN','Benin','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(23,'BLZ','Belize','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(22,'BEL','Belgium','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(21,'BLR','Belarus','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(20,'BRB','Barbados','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(19,'BGD','Bangladesh','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(18,'BHS','Bahamas','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(17,'BHR','Bahrain','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(16,'AZE','Azerbaijan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(15,'AUT','Austria','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(14,'AUS','Australia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(13,'ABW','Aruba','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(12,'ARM','Armenia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(11,'ARG','Argentina','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(10,'ATG','Antigua and Barbuda','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(9,'ATA','Antarctica','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(8,'AIA','Anguilla','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(7,'AGO','Angola','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(6,'AND','Andorra','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(5,'ASM','American Samoa','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(4,'DZA','Algeria','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(3,'ALB','Albania','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(2,'ALA','├àland Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(1,'AFG','Afghanistan','1',1,'2017-06-26 23:42:24',9,'2017-07-24 22:01:27'),(34,'BRN','Brunei Darussalam','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(35,'BGR','Bulgaria','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(36,'BFA','Burkina Faso','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(37,'BDI','Burundi','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(38,'KHM','Cambodia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(39,'CMR','Cameroon','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(40,'CAN','Canada','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(41,'CPV','Cape Verde','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(42,'CYM','Cayman Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(43,'CAF','Central African Republic','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(44,'TCD','Chad','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(45,'CHL','Chile','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(46,'CHI','China','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(47,'CXR','Christmas Island','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(48,'CCK','Cocos (Keeling) Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(49,'COL','Colombia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(50,'COM','Comoros','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(51,'COG','Congo','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(52,'COD','Congo, the Democratic Republic of the','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(53,'COK','Cook Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(54,'CRI','Costa Rica','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(55,'CIV','C├┤te d\'Ivoire','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(56,'HRV','Croatia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(57,'CUB','Cuba','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(58,'CW','Cura├ºao','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(59,'CYP','Cyprus','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(60,'CZE','Czech Republic','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(61,'DNK','Denmark','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(62,'DJI','Djibouti','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(63,'DMA','Dominica','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(64,'DOM','Dominican Republic','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(65,'ECU','Ecuador','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(66,'EGY','Egypt','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(67,'SLV','El Salvador','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(68,'GNQ','Equatorial Guinea','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(69,'ERI','Eritrea','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(70,'EST','Estonia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(71,'ETH','Ethiopia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(72,'FLK','Falkland Islands (Malvinas)','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(73,'FRO','Faroe Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(74,'FJI','Fiji','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(75,'FIN','Finland','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(76,'FRA','France','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(77,'GUF','French Guiana','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(78,'PYF','French Polynesia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(79,'ATF','French Southern Territories','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(80,'GAB','Gabon','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(81,'GMB','Gambia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(82,'GEO','Georgia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(83,'DEU','Germany','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(84,'GHA','Ghana','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(85,'GIB','Gibraltar','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(86,'GRC','Greece','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(87,'GRL','Greenland','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(88,'GRD','Grenada','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(89,'GLP','Guadeloupe','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(90,'GUM','Guam','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(91,'GTM','Guatemala','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(92,'GGY','Guernsey','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(93,'GIN','Guinea','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(94,'GNB','Guinea-Bissau','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(95,'GUY','Guyana','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(96,'HTI','Haiti','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(97,'HMD','Heard Island and McDonald Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(98,'VAT','Holy See (Vatican City State)','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(99,'HND','Honduras','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(100,'HK','Hong Kong','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(101,'HUN','Hungary','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(102,'ISL','Iceland','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(103,'IND','India','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(104,'IDN','Indonesia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(250,'Irn','Iran','1',104,'2020-05-13 21:37:25',NULL,'2020-10-11 00:11:11'),(106,'IRQ','Iraq','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(107,'IRL','Ireland','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(108,'IMN','Isle of Man','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(251,'kh','Khorramshahr','1',100,'2020-10-12 22:04:47',NULL,'2020-10-11 00:11:11'),(110,'ITA','Italy','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(111,'JAM','Jamaica','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(112,'JPN','Japan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(113,'JEY','Jersey','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(114,'JOR','Jordan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(115,'KAZ','Kazakhstan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(116,'KEN','Kenya','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(117,'KIR','Kiribati','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(118,'PRK','Korea, Democratic People\'s Republic of','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(119,'KOR','Korea, Republic of','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(120,'KWT','Kuwait','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(121,'KGZ','Kyrgyzstan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(122,'LAO','Lao People\'s Democratic Republic','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(123,'LVA','Latvia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(124,'LBN','Lebanon','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(125,'LSO','Lesotho','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(126,'LBR','Liberia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(127,'LBY','Libya','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(128,'LIE','Liechtenstein','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(129,'LTU','Lithuania','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(130,'LUX','Luxembourg','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(131,'MO','Macao','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(132,'MKD','Macedonia, the Former Yugoslav Republic of','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(133,'MDG','Madagascar','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(134,'MWI','Malawi','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(135,'MYS','Malaysia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(136,'MDV','Maldives','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(137,'MLI','Mali','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(138,'MLT','Malta','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(139,'MHL','Marshall Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(140,'MTQ','Martinique','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(141,'MRT','Mauritania','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(142,'MUS','Mauritius','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(143,'MYT','Mayotte','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(144,'MEX','Mexico','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(145,'FSM','Micronesia, Federated States of','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(146,'MDA','Moldova, Republic of','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(147,'MCO','Monaco','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(148,'MNG','Mongolia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(149,'MNE','Montenegro','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(150,'MSR','Montserrat','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(151,'MAR','Morocco','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(152,'MOZ','Mozambique','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(153,'MMR','Myanmar','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(154,'NAM','Namibia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(155,'NRU','Nauru','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(156,'NPL','Nepal','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(157,'NLD','Netherlands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(158,'NCL','New Caledonia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(159,'NZL','New Zealand','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(160,'NIC','Nicaragua','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(161,'NER','Niger','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(162,'NGA','Nigeria','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(163,'NIU','Niue','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(164,'NFK','Norfolk Island','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(165,'MNP','Northern Mariana Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(166,'NOR','Norway','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(167,'OMN','Oman','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(168,'PAK','Pakistan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(169,'PLW','Palau','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(170,'PSE','Palestine, State of','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(171,'PAN','Panama','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(172,'PNG','Papua New Guinea','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(173,'PRY','Paraguay','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(174,'PER','Peru','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(175,'PHL','Philippines','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(176,'PCN','Pitcairn','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(177,'POL','Poland','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(178,'PRT','Portugal','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(179,'PRI','Puerto Rico','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(180,'QAT','Qatar','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(181,'REU','R├®union','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(182,'ROU','Romania','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(183,'RUS','Russian Federation','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(184,'RWA','Rwanda','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(185,'BLM','Saint Barth├®lemy','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(186,'SHN','Saint Helena, Ascension and Tristan da Cunha','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(187,'KNA','Saint Kitts and Nevis','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(188,'LCA','Saint Lucia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(189,'MAF','Saint Martin (French part)','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(190,'SPM','Saint Pierre and Miquelon','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(191,'VCT','Saint Vincent and the Grenadines','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(192,'WSM','Samoa','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(193,'SMR','San Marino','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(194,'STP','Sao Tome and Principe','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(195,'SAU','Saudi Arabia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(196,'SEN','Senegal','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(197,'SRB','Serbia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(198,'SYC','Seychelles','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(199,'SLE','Sierra Leone','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(200,'SGP','Singapore','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(201,'SX','Sint Maarten (Dutch part)','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(202,'SVK','Slovakia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(203,'SVN','Slovenia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(204,'SLB','Solomon Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(205,'SOM','Somalia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(206,'ZAF','South Africa','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(207,'SGS','South Georgia and the South Sandwich Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(208,'SSD','South Sudan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(209,'ESP','Spain','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(210,'LKA','Sri Lanka','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(211,'SDN','Sudan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(212,'SUR','Suriname','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(213,'SJM','Svalbard and Jan Mayen','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(214,'SWZ','Swaziland','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(215,'SWE','Sweden','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(216,'CHE','Switzerland','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(217,'SYR','Syrian Arab Republic','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(218,'TWN','Taiwan, Province of China','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(219,'TJK','Tajikistan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(220,'TZA','Tanzania, United Republic of','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(221,'THA','Thailand','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(222,'TLS','Timor-Leste','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(223,'TGO','Togo','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(224,'TKl','Tokelau','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(225,'TON','Tonga','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(226,'TTO','Trinidad and Tobago','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(227,'TUN','Tunisia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(228,'TUR','Turkey','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(229,'TKM','Turkmenistan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(230,'TCA','Turks and Caicos Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(231,'TUV','Tuvalu','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(232,'UGA','Uganda','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(233,'UKA','Ukraine','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(234,'UAE','United Arab Emirates','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(235,'GBR','United Kingdom','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(236,'USA','United States','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(237,'UMI','United States Minor Outlying Islands','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(238,'URY','Uruguay','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(239,'UZB','Uzbekistan','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(240,'VUT','Vanuatu','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(241,'VEN','Venezuela, Bolivarian Republic of','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(242,'VNM','Viet Nam','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(243,'VG','Virgin Islands, British','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(244,'VIR','Virgin Islands, U.S.','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(245,'WLF','Wallis and Futuna','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(246,'ESH','Western Sahara','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(247,'YEM','Yemen','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(248,'ZMB','Zambia','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(249,'ZWE','Zimbabwe','1',1,'2017-06-26 23:42:49',NULL,'2019-11-21 18:01:39'),(252,'XK','Republic of Kosovo ','1',7,'2020-11-10 19:39:13',NULL,'2020-10-11 00:11:11');
/*!40000 ALTER TABLE `mst_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `re_generate_request`
--

DROP TABLE IF EXISTS `re_generate_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `re_generate_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `coc_number` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0=>approve,1=>pending,2=>reject',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `re_generate_request`
--

LOCK TABLES `re_generate_request` WRITE;
/*!40000 ALTER TABLE `re_generate_request` DISABLE KEYS */;
INSERT INTO `re_generate_request` VALUES (1,1,'GC-AE-2021-055-00001','asdsaf sdafasdf sadfa dfas',0,12,'2021-01-18 09:23:38'),(2,3,'GC-AE-2021-055-00002','dvgfasdgvd',0,10,'2021-01-18 09:33:51'),(3,4,'GC-AE-055-00001','asdfe',0,10,'2021-01-18 10:20:14');
/*!40000 ALTER TABLE `re_generate_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `re_genrate_pdf`
--

DROP TABLE IF EXISTS `re_genrate_pdf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `re_genrate_pdf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `old_pdf` varchar(255) NOT NULL,
  `coc_no` varchar(255) NOT NULL,
  `release_date` varchar(255) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `re_genrate_pdf`
--

LOCK TABLES `re_genrate_pdf` WRITE;
/*!40000 ALTER TABLE `re_genrate_pdf` DISABLE KEYS */;
INSERT INTO `re_genrate_pdf` VALUES (1,1,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-AE-2021-055-00001/REPORTS/GC-DXB-GSO-2021-00001-205-18-Jan-2021-9560.pdf','GC-AE-2021-055-00001','2021-01-18 09:20:14 AM','2021-01-18 09:24:32',12,1),(2,3,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-AE-2021-055-00002/REPORTS/GC-DXB-GSO-2021-00003-803-18-Jan-2021-7198.pdf','GC-AE-2021-055-00002','2021-01-18 09:28:15 AM','2021-01-18 09:34:35',10,1);
/*!40000 ALTER TABLE `re_genrate_pdf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_seq`
--

DROP TABLE IF EXISTS `registration_seq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration_seq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_seq`
--

LOCK TABLES `registration_seq` WRITE;
/*!40000 ALTER TABLE `registration_seq` DISABLE KEYS */;
INSERT INTO `registration_seq` VALUES (1,'2021-01-18 09:05:59',7),(2,'2021-01-18 09:11:07',10),(3,'2021-01-18 09:12:55',10),(4,'2021-01-18 09:55:27',10),(5,'2021-01-18 11:21:29',12),(6,'2021-01-18 11:23:08',12);
/*!40000 ALTER TABLE `registration_seq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `release_document`
--

DROP TABLE IF EXISTS `release_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `release_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `document_no` varchar(255) NOT NULL,
  `upload_path` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `release_document`
--

LOCK TABLES `release_document` WRITE;
/*!40000 ALTER TABLE `release_document` DISABLE KEYS */;
INSERT INTO `release_document` VALUES (1,3,'GC-AE-2021-055-00002','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00003/releaseDocument/GC-DXB-GSO-2021-00003-20309_32_14.pdf',10,'2021-01-18 09:32:14');
/*!40000 ALTER TABLE `release_document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_content`
--

DROP TABLE IF EXISTS `report_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_content` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `coc_no` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `date_of_issuance` date DEFAULT NULL,
  `cab_method` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `technical_regulation` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `notify_body` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `means_shipping` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `means_other` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `shipment_doc` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `pro_name` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `trade_brand` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `country_origin` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `lot_no` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `standard_applies` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `country_complains` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `file_ref` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `certified_pro` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `electrical_rating` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `length` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `width` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `height` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `pro_dimension` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `aws_path` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `qr_code` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `gmark_qrcode` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `statuts` int(11) NOT NULL DEFAULT '1',
  `re_generate` int(11) NOT NULL DEFAULT '0' COMMENT '0=>no request,1=>request,2=>reject,3=>approved',
  `no_re_generate` int(11) NOT NULL DEFAULT '0',
  `change_coc` int(11) NOT NULL DEFAULT '0',
  `release_date` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_no` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `inv_date` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `report_ref` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_content`
--

LOCK TABLES `report_content` WRITE;
/*!40000 ALTER TABLE `report_content` DISABLE KEYS */;
INSERT INTO `report_content` VALUES (1,1,'GC-AE-2021-055-00001-001','2021-01-18','cab','tech','GEO CHEM MIDDLE EAST L.L.C - NB 055','SEA',NULL,'shipping','product','trademark','103','model no','lot','1,2,4','17,120,180','report/file','remark','electrical','100','10','20','MM','Jocelyn Teodoro',12,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-AE-2021-055-00001-001/REPORTS/GC-DXB-GSO-2021-00001-430-18-Jan-2021-6188.pdf','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/assets/QRcode/GC-DXB-GSO-2021-00001.png',NULL,1,0,1,0,'2021-01-18 09:24:48 AM',7,'2021-01-18 09:13:35','invoice no','2021-01-18','report ref'),(2,3,'GC-AE-2021-055-00002-001','2021-01-18','dds','sfdfd','GEO CHEM MIDDLE EAST L.L.C - NB 055','AIR',NULL,'gsgd','dgds','dgsg','103','dgdfh','100000','2,5','17,247','ghsdg','efds','dgds','25','15','30','MM','Samrendra Singh',10,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-AE-2021-055-00002-001/REPORTS/GC-DXB-GSO-2021-00003-64-18-Jan-2021-2497.pdf','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/assets/QRcode/GC-DXB-GSO-2021-00003.png',NULL,1,0,1,0,'2021-01-18 09:35:18 AM',10,'2021-01-18 09:26:51','42343','2021-01-15','532'),(3,2,NULL,'2021-01-20','dgd','sgdg','GEO CHEM MIDDLE EAST L.L.C - NB 055','OTHER','123','dgd','dgds','dgdsg','4','dgd','gdfsg','3,4,5','17,247','dsgdsg','','','dgd','dgd','dgd','CM','Samrendra Singh',10,NULL,NULL,NULL,1,0,0,0,NULL,10,'2021-01-18 09:44:12','dg','2021-01-19','dgdgd'),(4,4,'GC-AE-055-00001','2021-01-19','dfs','dfds','GEO CHEM MIDDLE EAST L.L.C - NB 055','LAND',NULL,'dfd','dgfds','dgs','5','fdsdf','rfef','2,5','17,247','dgfds','','','dgfdsg','dgds','dgds','CM','Jocelyn Teodoro',12,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-AE-055-00001/REPORTS/GC-DXB-GSO-2021-00004-819-18-Jan-2021-2262.pdf','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/assets/QRcode/GC-DXB-GSO-2021-00004.png',NULL,1,3,0,0,'2021-01-18 10:19:53 AM',10,'2021-01-18 09:57:13','dgfs','2021-01-18','dgfds'),(5,5,'GC-AE-055-00002','2021-01-18','cab','tech','GEO CHEM MIDDLE EAST L.L.C - NB 055','AIR',NULL,'12','12','3213213','12','213213','lot','2,3','17,167','12321321','','','10','10','10','CM','Jocelyn Teodoro',12,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-AE-055-00002/REPORTS/GC-DXB-GSO-2021-00005-397-18-Jan-2021-3066.pdf','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/assets/QRcode/GC-DXB-GSO-2021-00005.png','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00005/GMARKQRCODE/GC-DXB-GSO-2021-00005-GMARK-53911_44_31.lakshay.png',1,0,0,0,'2021-01-18 11:46:45 AM',12,'2021-01-18 11:39:39','213213','2021-01-29','12321'),(6,6,'GC-AE-2021-055-00003','2021-01-18','23423','324','GEO CHEM MIDDLE EAST L.L.C - NB 055','AIR',NULL,'324234','234','324324','12','324324','342234','2,3,4','234','432234324','','','234','324','23432','MM','Jocelyn Teodoro',12,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-AE-2021-055-00003/REPORTS/GC-DXB-GSO-2021-00006-942-18-Jan-2021-6446.pdf','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/assets/QRcode/GC-DXB-GSO-2021-00006.png',NULL,1,0,0,0,'2021-01-18 11:50:04 AM',12,'2021-01-18 11:49:52','32432','2021-01-01','32424');
/*!40000 ALTER TABLE `report_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rfc_document`
--

DROP TABLE IF EXISTS `rfc_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rfc_document` (
  `rfc_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `aws_path` varchar(255) DEFAULT NULL,
  `pdf_genrate` int(11) NOT NULL DEFAULT '0',
  `exporte_id` int(11) NOT NULL,
  `importer_id` int(11) NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `place_tel` bigint(10) DEFAULT NULL,
  `fax_number` varchar(255) DEFAULT NULL,
  `place_email` varchar(255) DEFAULT NULL,
  `place_contact_name` varchar(255) DEFAULT NULL,
  `inv_no` varchar(255) DEFAULT NULL,
  `inv_value` varchar(255) DEFAULT NULL,
  `inv_date` varchar(255) DEFAULT NULL,
  `inv_cur` varchar(255) DEFAULT NULL,
  `goods_description` text,
  `goods_condition` varchar(255) DEFAULT NULL,
  `type_of_delivery` varchar(100) DEFAULT NULL,
  `port_land` varchar(255) DEFAULT NULL,
  `port_discharge` varchar(255) DEFAULT NULL,
  `shipment_method` varchar(100) DEFAULT NULL,
  `shipment_method_desc` varchar(255) DEFAULT NULL,
  `packing_details` varchar(100) DEFAULT NULL,
  `packing_details_desc` varchar(255) DEFAULT NULL,
  `date_of_inspection` varchar(100) DEFAULT NULL,
  `iso_9001_certificate` varchar(100) DEFAULT NULL,
  `other_certification` varchar(255) DEFAULT NULL,
  `test_report_provide` varchar(255) DEFAULT NULL,
  `testing_done_by` varchar(100) DEFAULT NULL,
  `iso_17025_accredition` varchar(100) DEFAULT NULL,
  `iso_accredition_other` varchar(255) DEFAULT NULL,
  `company_request` text,
  `name_of_person` text,
  `signature` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rfc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rfc_document`
--

LOCK TABLES `rfc_document` WRITE;
/*!40000 ALTER TABLE `rfc_document` DISABLE KEYS */;
INSERT INTO `rfc_document` VALUES (1,2,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00002/documents/RFC_DOCUMENT_372.pdf',1,1,2,2,0,'rrwe','fdsf@d.com','fderfefas','01121','500000','2021-01-20','BMD','testing',NULL,'TOTAL','','','AIR','','FCL','','2021-01-25','YES','','YES',NULL,'YES','','','',NULL,10,'2021-01-18 09:37:27'),(2,4,NULL,0,2,2,1,0,'','','','gdf','dgdg','2021-01-18','GBP','',NULL,'TOTAL','','','AIR','','FCL','','','YES','','YES',NULL,NULL,'','','',NULL,10,'2021-01-18 10:11:40'),(3,3,NULL,0,1,2,1,0,'','','','dgd','dgd','2021-01-18','KHR','',NULL,NULL,'','',NULL,'',NULL,'','',NULL,'',NULL,NULL,NULL,'','','',NULL,10,'2021-01-18 10:13:11'),(4,5,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00005/documents/RFC_DOCUMENT_22.pdf',1,3,2,2,2343243,'','sadas@gmail.com','sdfds','rdgtfdsg','34324','2021-01-01','BND','dsfsdfsd','NEW','PARTIAL','dsfsd','sdfsd','RAIL','','FCL','','2021-01-01','YES','','YES',NULL,'YES','','sdfsdf','sdf',NULL,12,'2021-01-18 11:26:30');
/*!40000 ALTER TABLE `rfc_document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '0=>deactive,1=>active',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','1'),(2,'Admin','1'),(3,'Border Staff','1');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sample_photo`
--

DROP TABLE IF EXISTS `sample_photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sample_photo` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `front_img` varchar(255) DEFAULT NULL,
  `rear_img` varchar(255) DEFAULT NULL,
  `product_label` varchar(255) DEFAULT NULL,
  `product_label2` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sample_photo`
--

LOCK TABLES `sample_photo` WRITE;
/*!40000 ALTER TABLE `sample_photo` DISABLE KEYS */;
INSERT INTO `sample_photo` VALUES (1,1,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00001/sample_photo/GC-DXB-GSO-2021-00001-632-09_10_41.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00001/sample_photo/GC-DXB-GSO-2021-00001-953-09_10_41.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00001/sample_photo/GC-DXB-GSO-2021-00001-200-09_10_41.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00001/sample_photo/GC-DXB-GSO-2021-00001-145-09_10_42.jpg',1,7,'2021-01-18 09:10:42'),(2,3,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00003/sample_photo/GC-DXB-GSO-2021-00003-590-09_21_42.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00003/sample_photo/GC-DXB-GSO-2021-00003-791-09_21_42.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00003/sample_photo/GC-DXB-GSO-2021-00003-485-09_21_42.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00003/sample_photo/GC-DXB-GSO-2021-00003-841-09_21_42.jpg',1,10,'2021-01-18 09:21:42'),(3,2,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00002/sample_photo/GC-DXB-GSO-2021-00002-591-09_51_50.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00002/sample_photo/GC-DXB-GSO-2021-00002-916-09_51_50.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00002/sample_photo/GC-DXB-GSO-2021-00002-730-09_51_50.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00002/sample_photo/GC-DXB-GSO-2021-00002-426-09_51_50.jpg',1,10,'2021-01-18 09:51:50'),(4,4,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00004/sample_photo/GC-DXB-GSO-2021-00004-499-09_57_42.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00004/sample_photo/GC-DXB-GSO-2021-00004-367-09_57_42.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00004/sample_photo/GC-DXB-GSO-2021-00004-102-09_57_42.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00004/sample_photo/GC-DXB-GSO-2021-00004-588-09_57_42.jpg',1,10,'2021-01-18 09:57:43'),(5,5,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00005/sample_photo/GC-DXB-GSO-2021-00005-228-11_30_46.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00005/sample_photo/GC-DXB-GSO-2021-00005-55-11_30_46.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00005/sample_photo/GC-DXB-GSO-2021-00005-142-11_30_46.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00005/sample_photo/GC-DXB-GSO-2021-00005-462-11_30_46.jpg',1,12,'2021-01-18 11:30:46'),(6,6,'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00006/sample_photo/GC-DXB-GSO-2021-00006-160-11_48_40.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00006/sample_photo/GC-DXB-GSO-2021-00006-265-11_48_40.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00006/sample_photo/GC-DXB-GSO-2021-00006-718-11_48_40.jpg','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/GC-DXB-GSO-2021-00006/sample_photo/GC-DXB-GSO-2021-00006-67-11_48_41.jpg',1,12,'2021-01-18 11:48:41');
/*!40000 ALTER TABLE `sample_photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `set_permission`
--

DROP TABLE IF EXISTS `set_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `set_permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `function_id` text NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `set_permission`
--

LOCK TABLES `set_permission` WRITE;
/*!40000 ALTER TABLE `set_permission` DISABLE KEYS */;
INSERT INTO `set_permission` VALUES (2,1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,66,69,73,30,31,32,67,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,68,70,71,72,74,55,56,57,58,59,60,61,62,63,64,65'),(3,2,'4,5,6,7,8,9,10,11,12,13,14,16,17,18,19,20,21,22,23,24,25,26,27,28,29,66,69,30,31,32,67,33,34,35,36,37,38,42,43,44,45,46,47,48,49,50,51,52,53,54,68,70,71,72,74,59,60,61,62'),(4,3,'13,24,46,53,70');
/*!40000 ALTER TABLE `set_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `standard_applies`
--

DROP TABLE IF EXISTS `standard_applies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `standard_applies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `standard` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `standard_applies`
--

LOCK TABLES `standard_applies` WRITE;
/*!40000 ALTER TABLE `standard_applies` DISABLE KEYS */;
INSERT INTO `standard_applies` VALUES (1,'EN 71-1:2014+A1:2018\r\n','2021','2021-01-15 09:04:41',1,1),(2,'EN 71-2:2011+A1:2014','2021','2021-01-15 09:04:41',1,1),(3,'EN 71-3:2013+A3:2018','2021','2021-01-15 09:05:18',1,1),(4,'EN 71-4: 2013','2021','2021-01-15 09:05:18',1,1),(5,'EN 71-5: 2015','2021','2021-01-15 09:05:39',1,1),(6,'EN 71-7: 2014+A2: 2018','2021','2021-01-15 09:05:39',1,1),(7,'EN 71-8: 2018','2021','2021-01-15 09:05:58',1,1),(8,'EN 71-9: 2005+A1:2007','2021','2021-01-15 09:05:58',1,1),(9,'EN 71-12: 2016','2021','2021-01-15 09:06:23',1,1),(10,'EN 71-13: 2014','2021','2021-01-15 09:06:23',1,1),(11,'EN 71-14: 2018','2021','2021-01-15 09:06:48',1,1),(12,'IEC 62115: 2017\r\n','2021','2021-01-15 09:06:48',1,1),(13,'ISO 14389: 2014','2021','2021-01-15 09:06:58',1,1);
/*!40000 ALTER TABLE `standard_applies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_number` varchar(40) NOT NULL,
  `role_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` varchar(100) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '1=>active,0=>not active',
  `del_status` int(11) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `default_country` int(11) NOT NULL,
  `signatory` int(11) NOT NULL DEFAULT '0',
  `address` varchar(255) NOT NULL,
  `signature_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (7,'shankar.k@geochem-cp.com','Shankar','Kumar','562622',1,'25f9e794323b453885f5181f1b624d0b','2021-01-18 03:31:40 PM','1',1,'2019-11-14 00:01:50',103,0,'','https://cosqc-prod.s3.ap-south-1.amazonaws.com/cosqc/docs/arasu-27-Mar-9583.jpg'),(8,'developer.cps04@geochem-cp.com','lakshay','developer','344324234324',3,'827ccb0eea8a706c4c34a16891f84e7b','2021-01-18 11:15:54 AM','1',1,'2020-12-22 06:08:47',18,0,'sdfsdf',NULL),(9,'demo@geochem.com','TESTING','DONE','7894561230',1,'25f9e794323b453885f5181f1b624d0b','2021-01-14 07:08:17 AM','1',1,'2021-01-05 05:44:36',103,0,'fxgfdgfd',NULL),(10,'samrendra.cps05@geochem-cp.com','Samrendra','Singh','24323423',2,'21232f297a57a5a743894a0e4a801fc3','2021-01-18 09:07:21 AM','1',1,'2021-01-05 23:43:48',17,0,'dfdsfsd','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/USER_SIGNATURE//sam10_05_56.jpg'),(11,'developer.cps03@geochem-cp.com','jyoti','bansal','567546456546',1,'25f9e794323b453885f5181f1b624d0b','2021-01-11 11:10:54 AM','0',1,'2021-01-06 00:08:48',21,0,'sdfdsf',NULL),(12,'jocelyn.teodoro@geochemglobalae.com','Jocelyn','Teodoro','1234567890',1,'25f9e794323b453885f5181f1b624d0b','2021-01-18 11:18:04 AM','1',1,'2021-01-18 09:02:23',114,1,'DUBAI','https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/USER_SIGNATURE//Jocelyn09_19_12.png');
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

-- Dump completed on 2021-01-19  4:08:35
