-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 10, 2021 at 11:09 AM
-- Server version: 5.7.31
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gmark`
--

-- --------------------------------------------------------

--
-- Table structure for table `coc_number`
--

DROP TABLE IF EXISTS `coc_number`;
CREATE TABLE IF NOT EXISTS `coc_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `report_id` int(11) NOT NULL,
  `reg_ig` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `not_change` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_location_add`
--

DROP TABLE IF EXISTS `company_location_add`;
CREATE TABLE IF NOT EXISTS `company_location_add` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `mst_country_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_location_add`
--

INSERT INTO `company_location_add` (`location_id`, `mst_country_id`, `company_name`, `address`, `created_on`, `status`) VALUES
(1, 234, 'Geo Chem Middle East', 'Plot No.010305,<br>Techno Park P.O.Box 2209 <br> Jebel Ali Dubai(UAE) <br>Tel No :+ 971 4 8867400 <br>Fax : +971-4-8867401/8867402', '2020-04-17 03:35:35', '1'),
(2, 114, 'Geo-Chem Middle East - Jordan', 'Madinah Monawarah Street <br> Al Andalus Complex <br> Building No.273 2nd Floor - office 204<br> Tel          : +962 6 5607299 <br> Fax         : +962 6 5607288<br>', '2020-04-17 03:41:36', '1'),
(3, 103, 'Geochem Laboratories Private Limited', '306, Udhyog Vihar Phase 2<br>Gurgoan,Haryana(India)<br> Tel.: +91 124-6250500<br> Fax: +91 124-6250500', '2020-04-17 03:47:05', '1');

-- --------------------------------------------------------

--
-- Table structure for table `country_tax`
--

DROP TABLE IF EXISTS `country_tax`;
CREATE TABLE IF NOT EXISTS `country_tax` (
  `country_tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_tax_name` varchar(100) NOT NULL,
  `tax_precentage` varchar(100) DEFAULT NULL,
  `country_id` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`country_tax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2218 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_type`
--

DROP TABLE IF EXISTS `customer_type`;
CREATE TABLE IF NOT EXISTS `customer_type` (
  `customer_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_type_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `customer_type`
--

INSERT INTO `customer_type` (`customer_type_id`, `customer_type_name`, `created_on`) VALUES
(1, 'SUPPLIER', '2020-05-19 08:55:33'),
(2, 'EXPORTER', '2020-05-19 08:55:55'),
(3, 'IMPORTER', '2020-05-19 08:56:13'),
(4, 'CUSTOMER', '2020-05-19 08:56:26');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` text NOT NULL,
  `doc_need` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `document_name`, `doc_need`, `status`, `created_by`, `created_on`) VALUES
(1, 'RFC', 1, 1, '10', '2020-12-16 23:46:58'),
(2, 'Written declaration that the same application has not been lodged with any other Notified Body', 1, 1, '8', '2020-12-16 23:46:58'),
(3, 'Applicant Declaration of Conformity- Importer / Manufacturer', 1, 1, '8', '2020-12-16 23:46:58'),
(4, 'Product description of Toy', 1, 1, '8', '2020-12-16 23:46:58'),
(5, 'Properly filled and signed Application Form (Product description, List of applicable Standards. etc)', 0, 1, '1', '2020-12-16 23:46:58'),
(6, 'Manufacturer’s Risk Analysis', 0, 1, '1', '2020-12-16 23:46:58'),
(7, 'Clear Photos of the product (showing the Brand /Trade mark etc.).', 0, 1, '1', '2020-12-16 23:46:58'),
(8, 'Instruction Manuals (Assembly instruction, user manual .etc) in Arabic language at least', 0, 1, '10', '2020-12-16 23:46:58'),
(9, 'Other tech. documents, if Any', 0, 1, '1', '2020-12-16 23:46:58'),
(10, 'The addresses of the places of manufacture', 0, 1, '1', '2020-12-16 23:46:58'),
(11, 'Results of design calculations made, examinations carried out etc', 0, 1, '1', '2020-12-16 23:46:58'),
(12, 'Pro-Foma or Final Invoice', 1, 1, '8', '2020-12-16 23:46:58'),
(13, 'Packing List', 1, 1, '8', '2020-12-16 23:46:58'),
(14, 'Test Reports', 1, 1, '8', '2020-12-16 23:46:58'),
(15, 'Applicant Commercial Registry Certificate', 1, 0, '8', '2021-01-09 14:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `document_registration`
--

DROP TABLE IF EXISTS `document_registration`;
CREATE TABLE IF NOT EXISTS `document_registration` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `document_others` text,
  `upload_path` varchar(255) NOT NULL,
  `documents_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`doc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `functions`
--

DROP TABLE IF EXISTS `functions`;
CREATE TABLE IF NOT EXISTS `functions` (
  `function_id` int(11) NOT NULL AUTO_INCREMENT,
  `function_name` varchar(255) NOT NULL,
  `controller_name` varchar(255) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '0=>deactive,1=>active',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`function_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `functions`
--

INSERT INTO `functions` (`function_id`, `function_name`, `controller_name`, `alias`, `status`, `created_on`) VALUES
(1, 'index', 'ApplicationType', 'APPLICATION LISTING', 1, '2021-01-09 13:04:38'),
(2, 'add_application', 'ApplicationType', 'ADD APPLICATION TYPE', 1, '2021-01-09 13:05:41'),
(3, 'edit_application', 'ApplicationType', 'EDIT APPLICATION', 1, '2021-01-09 13:06:02'),
(4, 'index', 'Customer', 'CUSTOMER LISTING', 1, '2021-01-09 13:25:28'),
(5, 'add_customer', 'Customer', 'ADD CUSTOMER', 1, '2021-01-09 13:25:48'),
(6, 'edit_customer', 'Customer', 'EDIT CUSTOMER', 1, '2021-01-09 13:26:01'),
(7, 'index', 'Document', 'DOCUMENT LISTING', 1, '2021-01-09 13:26:36'),
(8, 'add_document', 'Document', 'ADD DOCUMENT', 1, '2021-01-09 13:26:48'),
(9, 'edit_document', 'Document', 'EDIT DOCUMENT', 1, '2021-01-09 13:27:11'),
(10, 'index', 'ExaminationMethod', 'EXAMINATION METHOD LISTING', 1, '2021-01-09 13:27:48'),
(11, 'add_examination', 'ExaminationMethod', 'ADD EXAMINATION METHOD', 1, '2021-01-09 13:28:08'),
(12, 'edit_examination', 'ExaminationMethod', 'EDIT EXAMINATION METHOD', 1, '2021-01-09 13:28:24'),
(13, 'index', 'Gmark', 'REQUEST LISTING', 1, '2021-01-09 13:30:59'),
(14, 'registration', 'Gmark', 'ADD REQUEST', 1, '2021-01-09 13:31:20'),
(15, 'add_application', 'Gmark', 'ADD APPLICATION BY REQUEST', 1, '2021-01-09 13:32:47'),
(16, 'add_lab', 'Gmark', 'ADD LAB BY REQUEST', 1, '2021-01-09 13:33:10'),
(17, 'add_sub_lab', 'Gmark', 'ADD SUB LAB BY REQUEST', 1, '2021-01-09 13:33:39'),
(18, 'add_legal_entity', 'Gmark', 'ADD LEGAL ENTITY BY REQUEST', 1, '2021-01-09 13:34:07'),
(19, 'add_ex_method', 'Gmark', 'ADD EXAMINATION METHOD BY REQUEST', 1, '2021-01-09 13:34:38'),
(20, 'insert_gmark_registration', 'Gmark', 'ADD REQUEST FORM', 1, '2021-01-09 13:34:57'),
(21, 'edit_submit_gmark_registration', 'Gmark', 'EDIT REQUEST FORM', 1, '2021-01-09 13:35:09'),
(22, 'customer_Add', 'Gmark', 'ADD CUSTOMER BY REQUEST', 1, '2021-01-09 13:36:25'),
(23, 'Upload_document', 'Gmark', 'UPLOAD DOCUMENT IN REQUEST', 1, '2021-01-09 13:37:03'),
(24, 'view_document_listing', 'Gmark', 'VIEW DOCUMENT LIST IN REQUEST', 1, '2021-01-09 13:37:36'),
(25, 'Rfc_document', 'Gmark', 'GENERATE RFC DOCUMENT IN REQUEST', 1, '2021-01-09 13:38:06'),
(26, 'EDIT_Rfc_document', 'Gmark', 'EDIT RFC DOCUMENT IN REQUEST', 1, '2021-01-09 13:38:38'),
(27, 'rfc_pdf', 'Gmark', 'VIEW RFC PDF IN REQUEST', 1, '2021-01-09 13:39:07'),
(28, 'release_rfc_pdf', 'Gmark', 'RELEASE RFC DOCUMENT IN REQUEST', 1, '2021-01-09 13:39:27'),
(29, 'approved_request', 'Gmark', 'APPROVED REQUEST', 1, '2021-01-09 13:39:54'),
(30, 'index', 'Invoice', 'JOB LISTING', 1, '2021-01-09 13:40:55'),
(31, 'add_invoice', 'Invoice', 'GENERATE INVOICE', 1, '2021-01-09 13:41:19'),
(32, 'edit_invoice', 'Invoice', 'EDIT INVOICE', 1, '2021-01-09 13:41:31'),
(33, 'index', 'Lab', 'LAB LISTING', 1, '2021-01-09 13:42:21'),
(34, 'add_lab', 'Lab', 'ADD LAB', 1, '2021-01-09 13:42:36'),
(35, 'edit_lab', 'Lab', 'EDIT LAB', 1, '2021-01-09 13:42:48'),
(36, 'index', 'Legal_Entity', 'LEGAL ENTITY LISTING', 1, '2021-01-09 13:43:33'),
(37, 'add_legalEntity', 'Legal_Entity', 'ADD LEGAL ENTITY', 1, '2021-01-09 13:43:52'),
(38, 'edit_legalEntity', 'Legal_Entity', 'EDIT LEGAL ENTITY', 1, '2021-01-09 13:44:13'),
(39, 'index', 'Operation', 'OPERATION LISTING', 1, '2021-01-09 13:44:35'),
(40, 'add', 'Operation', 'ADD OPERATION', 1, '2021-01-09 13:45:04'),
(41, 'edit', 'Operation', 'EDIT OPERATION', 1, '2021-01-09 13:45:19'),
(42, 'index', 'Regenerate', 'REGENERATE LISTING', 1, '2021-01-09 13:46:21'),
(43, 'approval', 'Regenerate', 'APPROVAL REGENRATE REPORT', 1, '2021-01-09 13:46:43'),
(44, 'approved', 'Regenerate', 'APPROVED REGENRATE REPORT REQUEST', 1, '2021-01-09 13:47:20'),
(45, 'reject', 'Regenerate', 'REJECT REGENRATE REQUEST', 1, '2021-01-09 13:47:43'),
(46, 'index', 'Reports', 'REPORT LISTING', 1, '2021-01-09 13:48:11'),
(47, 'image_upload', 'Reports', 'REPORT IMAGE UPLOAD CONTENT', 1, '2021-01-09 13:48:41'),
(48, 'pdf_view', 'Reports', 'PDF VIEW WITHOUT RELEASE', 1, '2021-01-09 13:50:52'),
(49, 'content_upload', 'Reports', 'REPORT CONTENT UPLOAD', 1, '2021-01-09 13:51:27'),
(50, 'edit_content_upload', 'Reports', 'EDIT REPORT CONTENT', 1, '2021-01-09 13:51:42'),
(51, 'approved_pdf', 'Reports', 'APPROVED REPORT FOR RELEASE', 1, '2021-01-09 13:52:40'),
(52, 'release_pdf', 'Reports', 'RELEASE REPORT', 1, '2021-01-09 13:53:30'),
(53, 'download_pdf', 'Reports', 'DOWNLOAD PDF REPORT', 1, '2021-01-09 13:53:55'),
(54, 're_genrate_process', 'Reports', 'REGENRATE REPORT', 1, '2021-01-09 13:54:22'),
(55, 'index', 'Role', 'ROLE LISTING', 1, '2021-01-09 13:55:23'),
(56, 'add', 'Role', 'ROLE ADD', 1, '2021-01-09 13:55:57'),
(57, 'edit', 'Role', 'ROLE EDIT', 1, '2021-01-09 13:56:11'),
(58, 'save_permission', 'Role', 'PERMISSION SET', 1, '2021-01-09 13:56:39'),
(59, 'index', 'SubLab', 'SUB LAB LISTING', 1, '2021-01-09 13:56:54'),
(60, 'add_sublab', 'SubLab', 'ADD SUB LAB', 1, '2021-01-09 13:57:15'),
(61, 'edit_sublab', 'SubLab', 'EDIT SUB LAB', 1, '2021-01-09 13:57:30'),
(62, 'index', 'User', 'USER LISTING', 1, '2021-01-09 14:30:46'),
(63, 'add_user', 'User', 'ADD USER', 1, '2021-01-09 14:31:08'),
(64, 'edit_user', 'User', 'EDIT USER', 1, '2021-01-09 14:31:26'),
(65, 'sign_upload', 'User', 'USER SIGN UPLOAD', 1, '2021-01-09 14:31:49'),
(66, 'log', 'Gmark', 'LOG DETAILS', 1, '2021-01-09 15:22:50'),
(67, 'view', 'Invoice', 'VIEW INVOICE', 1, '2021-01-10 09:22:27'),
(68, 'log', 'Reports', 'LOG REPORT', 1, '2021-01-10 09:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `gmark_application`
--

DROP TABLE IF EXISTS `gmark_application`;
CREATE TABLE IF NOT EXISTS `gmark_application` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT,
  `application_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `application_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `gmark_application`
--

INSERT INTO `gmark_application` (`application_id`, `application_name`, `application_desc`, `created_on`, `created_by`) VALUES
(1, 'GULF TYPE EXAMINATION CERTIFICATE', 'GEC CERTIFICATE', '2021-01-10 11:07:13', '8'),
(2, 'CERTIFICATION OF CONFORMITY', 'COC CERTIFICATE', '2021-01-10 11:07:33', '8');

-- --------------------------------------------------------

--
-- Table structure for table `gmark_customers`
--

DROP TABLE IF EXISTS `gmark_customers`;
CREATE TABLE IF NOT EXISTS `gmark_customers` (
  `customers_id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gmark_examination_method`
--

DROP TABLE IF EXISTS `gmark_examination_method`;
CREATE TABLE IF NOT EXISTS `gmark_examination_method` (
  `ex_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_method_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `ex_method_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`ex_method_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gmark_laboratory_type`
--

DROP TABLE IF EXISTS `gmark_laboratory_type`;
CREATE TABLE IF NOT EXISTS `gmark_laboratory_type` (
  `lab_id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `lab_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`lab_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gmark_legal_entity_type`
--

DROP TABLE IF EXISTS `gmark_legal_entity_type`;
CREATE TABLE IF NOT EXISTS `gmark_legal_entity_type` (
  `legal_entity_id` int(11) NOT NULL AUTO_INCREMENT,
  `legal_entity_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `legal_entity_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`legal_entity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gmark_log_all_users`
--

DROP TABLE IF EXISTS `gmark_log_all_users`;
CREATE TABLE IF NOT EXISTS `gmark_log_all_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` text,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gmark_log_all_users`
--

INSERT INTO `gmark_log_all_users` (`id`, `desc`, `created_by`, `created_on`) VALUES
(1, 'Add Application Name:- GULF TYPE EXAMINATION CERTIFICATE ', 8, '2021-01-10 11:07:13'),
(2, 'Add Application Name:- CERTIFICATION OF CONFORMITY ', 8, '2021-01-10 11:07:33');

-- --------------------------------------------------------

--
-- Table structure for table `gmark_products`
--

DROP TABLE IF EXISTS `gmark_products`;
CREATE TABLE IF NOT EXISTS `gmark_products` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gmark_product_con`
--

DROP TABLE IF EXISTS `gmark_product_con`;
CREATE TABLE IF NOT EXISTS `gmark_product_con` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gmark_registration`
--

DROP TABLE IF EXISTS `gmark_registration`;
CREATE TABLE IF NOT EXISTS `gmark_registration` (
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
  `sign_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `sign_title` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `reg_status` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `examination_id` int(11) NOT NULL,
  PRIMARY KEY (`registration_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gmark_request_log`
--

DROP TABLE IF EXISTS `gmark_request_log`;
CREATE TABLE IF NOT EXISTS `gmark_request_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `gmark_registration_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gmark_sub_laboratory_type`
--

DROP TABLE IF EXISTS `gmark_sub_laboratory_type`;
CREATE TABLE IF NOT EXISTS `gmark_sub_laboratory_type` (
  `Sub_lab_id` int(11) NOT NULL AUTO_INCREMENT,
  `Sub_lab_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `Sub_lab_desc` longtext COLLATE utf8mb4_bin NOT NULL,
  `gmark_laboratory_type_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`Sub_lab_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
CREATE TABLE IF NOT EXISTS `invoice_details` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_number`
--

DROP TABLE IF EXISTS `invoice_number`;
CREATE TABLE IF NOT EXISTS `invoice_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_number`
--

DROP TABLE IF EXISTS `job_number`;
CREATE TABLE IF NOT EXISTS `job_number` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `job_no` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_certified_item`
--

DROP TABLE IF EXISTS `list_certified_item`;
CREATE TABLE IF NOT EXISTS `list_certified_item` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mst_country`
--

DROP TABLE IF EXISTS `mst_country`;
CREATE TABLE IF NOT EXISTS `mst_country` (
  `country_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Country of id primary key , Auto Increament ',
  `country_code` varchar(10) NOT NULL COMMENT 'Country code use as short name for country name',
  `country_name` varchar(50) NOT NULL COMMENT 'Name for country ',
  `status` enum('0','1') DEFAULT '1' COMMENT 'To  perform enable and disable the country',
  `created_by` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Who  created the country  details',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When a country is created ',
  `updated_by` smallint(5) DEFAULT NULL COMMENT 'Who update the country ',
  `updated_on` timestamp NOT NULL DEFAULT '2020-10-11 00:11:11' COMMENT 'When a Country Field is Updated ',
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `country_code_UNIQUE` (`country_code`)
) ENGINE=MyISAM AUTO_INCREMENT=253 DEFAULT CHARSET=utf8 COMMENT='Managing  Master list of Countries in the Company. ';

--
-- Dumping data for table `mst_country`
--

INSERT INTO `mst_country` (`country_id`, `country_code`, `country_name`, `status`, `created_by`, `created_on`, `updated_by`, `updated_on`) VALUES
(33, 'IOT', 'British Indian Ocean Territory', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(32, 'BRA', 'Brazil', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(31, 'BVT', 'Bouvet Island', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(30, 'BWA', 'Botswana', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(29, 'BIH', 'Bosnia and Herzegovina', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(28, 'BQ', 'Bonaire, Sint Eustatius and Saba', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(27, 'BOL', 'Bolivia, Plurinational State of', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(26, 'BTN', 'Bhutan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(25, 'BMU', 'Bermuda', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(24, 'BEN', 'Benin', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(23, 'BLZ', 'Belize', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(22, 'BEL', 'Belgium', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(21, 'BLR', 'Belarus', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(20, 'BRB', 'Barbados', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(19, 'BGD', 'Bangladesh', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(18, 'BHS', 'Bahamas', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(17, 'BHR', 'Bahrain', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(16, 'AZE', 'Azerbaijan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(15, 'AUT', 'Austria', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(14, 'AUS', 'Australia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(13, 'ABW', 'Aruba', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(12, 'ARM', 'Armenia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(11, 'ARG', 'Argentina', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(10, 'ATG', 'Antigua and Barbuda', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(9, 'ATA', 'Antarctica', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(8, 'AIA', 'Anguilla', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(7, 'AGO', 'Angola', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(6, 'AND', 'Andorra', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(5, 'ASM', 'American Samoa', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(4, 'DZA', 'Algeria', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(3, 'ALB', 'Albania', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(2, 'ALA', '├àland Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(1, 'AFG', 'Afghanistan', '1', 1, '2017-06-26 23:42:24', 9, '2017-07-24 22:01:27'),
(34, 'BRN', 'Brunei Darussalam', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(35, 'BGR', 'Bulgaria', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(36, 'BFA', 'Burkina Faso', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(37, 'BDI', 'Burundi', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(38, 'KHM', 'Cambodia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(39, 'CMR', 'Cameroon', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(40, 'CAN', 'Canada', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(41, 'CPV', 'Cape Verde', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(42, 'CYM', 'Cayman Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(43, 'CAF', 'Central African Republic', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(44, 'TCD', 'Chad', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(45, 'CHL', 'Chile', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(46, 'CHI', 'China', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(47, 'CXR', 'Christmas Island', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(48, 'CCK', 'Cocos (Keeling) Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(49, 'COL', 'Colombia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(50, 'COM', 'Comoros', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(51, 'COG', 'Congo', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(52, 'COD', 'Congo, the Democratic Republic of the', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(53, 'COK', 'Cook Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(54, 'CRI', 'Costa Rica', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(55, 'CIV', 'C├┤te d\'Ivoire', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(56, 'HRV', 'Croatia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(57, 'CUB', 'Cuba', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(58, 'CW', 'Cura├ºao', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(59, 'CYP', 'Cyprus', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(60, 'CZE', 'Czech Republic', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(61, 'DNK', 'Denmark', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(62, 'DJI', 'Djibouti', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(63, 'DMA', 'Dominica', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(64, 'DOM', 'Dominican Republic', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(65, 'ECU', 'Ecuador', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(66, 'EGY', 'Egypt', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(67, 'SLV', 'El Salvador', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(68, 'GNQ', 'Equatorial Guinea', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(69, 'ERI', 'Eritrea', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(70, 'EST', 'Estonia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(71, 'ETH', 'Ethiopia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(72, 'FLK', 'Falkland Islands (Malvinas)', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(73, 'FRO', 'Faroe Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(74, 'FJI', 'Fiji', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(75, 'FIN', 'Finland', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(76, 'FRA', 'France', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(77, 'GUF', 'French Guiana', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(78, 'PYF', 'French Polynesia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(79, 'ATF', 'French Southern Territories', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(80, 'GAB', 'Gabon', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(81, 'GMB', 'Gambia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(82, 'GEO', 'Georgia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(83, 'DEU', 'Germany', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(84, 'GHA', 'Ghana', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(85, 'GIB', 'Gibraltar', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(86, 'GRC', 'Greece', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(87, 'GRL', 'Greenland', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(88, 'GRD', 'Grenada', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(89, 'GLP', 'Guadeloupe', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(90, 'GUM', 'Guam', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(91, 'GTM', 'Guatemala', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(92, 'GGY', 'Guernsey', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(93, 'GIN', 'Guinea', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(94, 'GNB', 'Guinea-Bissau', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(95, 'GUY', 'Guyana', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(96, 'HTI', 'Haiti', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(97, 'HMD', 'Heard Island and McDonald Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(98, 'VAT', 'Holy See (Vatican City State)', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(99, 'HND', 'Honduras', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(100, 'HK', 'Hong Kong', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(101, 'HUN', 'Hungary', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(102, 'ISL', 'Iceland', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(103, 'IND', 'India', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(104, 'IDN', 'Indonesia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(250, 'Irn', 'Iran', '1', 104, '2020-05-13 21:37:25', NULL, '2020-10-11 00:11:11'),
(106, 'IRQ', 'Iraq', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(107, 'IRL', 'Ireland', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(108, 'IMN', 'Isle of Man', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(251, 'kh', 'Khorramshahr', '1', 100, '2020-10-12 22:04:47', NULL, '2020-10-11 00:11:11'),
(110, 'ITA', 'Italy', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(111, 'JAM', 'Jamaica', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(112, 'JPN', 'Japan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(113, 'JEY', 'Jersey', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(114, 'JOR', 'Jordan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(115, 'KAZ', 'Kazakhstan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(116, 'KEN', 'Kenya', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(117, 'KIR', 'Kiribati', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(118, 'PRK', 'Korea, Democratic People\'s Republic of', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(119, 'KOR', 'Korea, Republic of', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(120, 'KWT', 'Kuwait', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(121, 'KGZ', 'Kyrgyzstan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(122, 'LAO', 'Lao People\'s Democratic Republic', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(123, 'LVA', 'Latvia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(124, 'LBN', 'Lebanon', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(125, 'LSO', 'Lesotho', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(126, 'LBR', 'Liberia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(127, 'LBY', 'Libya', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(128, 'LIE', 'Liechtenstein', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(129, 'LTU', 'Lithuania', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(130, 'LUX', 'Luxembourg', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(131, 'MO', 'Macao', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(132, 'MKD', 'Macedonia, the Former Yugoslav Republic of', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(133, 'MDG', 'Madagascar', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(134, 'MWI', 'Malawi', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(135, 'MYS', 'Malaysia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(136, 'MDV', 'Maldives', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(137, 'MLI', 'Mali', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(138, 'MLT', 'Malta', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(139, 'MHL', 'Marshall Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(140, 'MTQ', 'Martinique', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(141, 'MRT', 'Mauritania', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(142, 'MUS', 'Mauritius', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(143, 'MYT', 'Mayotte', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(144, 'MEX', 'Mexico', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(145, 'FSM', 'Micronesia, Federated States of', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(146, 'MDA', 'Moldova, Republic of', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(147, 'MCO', 'Monaco', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(148, 'MNG', 'Mongolia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(149, 'MNE', 'Montenegro', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(150, 'MSR', 'Montserrat', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(151, 'MAR', 'Morocco', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(152, 'MOZ', 'Mozambique', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(153, 'MMR', 'Myanmar', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(154, 'NAM', 'Namibia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(155, 'NRU', 'Nauru', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(156, 'NPL', 'Nepal', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(157, 'NLD', 'Netherlands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(158, 'NCL', 'New Caledonia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(159, 'NZL', 'New Zealand', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(160, 'NIC', 'Nicaragua', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(161, 'NER', 'Niger', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(162, 'NGA', 'Nigeria', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(163, 'NIU', 'Niue', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(164, 'NFK', 'Norfolk Island', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(165, 'MNP', 'Northern Mariana Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(166, 'NOR', 'Norway', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(167, 'OMN', 'Oman', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(168, 'PAK', 'Pakistan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(169, 'PLW', 'Palau', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(170, 'PSE', 'Palestine, State of', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(171, 'PAN', 'Panama', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(172, 'PNG', 'Papua New Guinea', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(173, 'PRY', 'Paraguay', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(174, 'PER', 'Peru', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(175, 'PHL', 'Philippines', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(176, 'PCN', 'Pitcairn', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(177, 'POL', 'Poland', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(178, 'PRT', 'Portugal', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(179, 'PRI', 'Puerto Rico', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(180, 'QAT', 'Qatar', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(181, 'REU', 'R├®union', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(182, 'ROU', 'Romania', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(183, 'RUS', 'Russian Federation', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(184, 'RWA', 'Rwanda', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(185, 'BLM', 'Saint Barth├®lemy', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(186, 'SHN', 'Saint Helena, Ascension and Tristan da Cunha', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(187, 'KNA', 'Saint Kitts and Nevis', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(188, 'LCA', 'Saint Lucia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(189, 'MAF', 'Saint Martin (French part)', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(190, 'SPM', 'Saint Pierre and Miquelon', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(191, 'VCT', 'Saint Vincent and the Grenadines', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(192, 'WSM', 'Samoa', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(193, 'SMR', 'San Marino', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(194, 'STP', 'Sao Tome and Principe', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(195, 'SAU', 'Saudi Arabia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(196, 'SEN', 'Senegal', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(197, 'SRB', 'Serbia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(198, 'SYC', 'Seychelles', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(199, 'SLE', 'Sierra Leone', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(200, 'SGP', 'Singapore', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(201, 'SX', 'Sint Maarten (Dutch part)', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(202, 'SVK', 'Slovakia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(203, 'SVN', 'Slovenia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(204, 'SLB', 'Solomon Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(205, 'SOM', 'Somalia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(206, 'ZAF', 'South Africa', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(207, 'SGS', 'South Georgia and the South Sandwich Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(208, 'SSD', 'South Sudan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(209, 'ESP', 'Spain', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(210, 'LKA', 'Sri Lanka', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(211, 'SDN', 'Sudan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(212, 'SUR', 'Suriname', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(213, 'SJM', 'Svalbard and Jan Mayen', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(214, 'SWZ', 'Swaziland', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(215, 'SWE', 'Sweden', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(216, 'CHE', 'Switzerland', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(217, 'SYR', 'Syrian Arab Republic', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(218, 'TWN', 'Taiwan, Province of China', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(219, 'TJK', 'Tajikistan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(220, 'TZA', 'Tanzania, United Republic of', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(221, 'THA', 'Thailand', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(222, 'TLS', 'Timor-Leste', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(223, 'TGO', 'Togo', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(224, 'TKl', 'Tokelau', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(225, 'TON', 'Tonga', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(226, 'TTO', 'Trinidad and Tobago', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(227, 'TUN', 'Tunisia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(228, 'TUR', 'Turkey', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(229, 'TKM', 'Turkmenistan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(230, 'TCA', 'Turks and Caicos Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(231, 'TUV', 'Tuvalu', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(232, 'UGA', 'Uganda', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(233, 'UKA', 'Ukraine', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(234, 'UAE', 'United Arab Emirates', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(235, 'GBR', 'United Kingdom', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(236, 'USA', 'United States', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(237, 'UMI', 'United States Minor Outlying Islands', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(238, 'URY', 'Uruguay', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(239, 'UZB', 'Uzbekistan', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(240, 'VUT', 'Vanuatu', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(241, 'VEN', 'Venezuela, Bolivarian Republic of', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(242, 'VNM', 'Viet Nam', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(243, 'VG', 'Virgin Islands, British', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(244, 'VIR', 'Virgin Islands, U.S.', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(245, 'WLF', 'Wallis and Futuna', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(246, 'ESH', 'Western Sahara', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(247, 'YEM', 'Yemen', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(248, 'ZMB', 'Zambia', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(249, 'ZWE', 'Zimbabwe', '1', 1, '2017-06-26 23:42:49', NULL, '2019-11-21 18:01:39'),
(252, 'XK', 'Republic of Kosovo ', '1', 7, '2020-11-10 19:39:13', NULL, '2020-10-11 00:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `report_content`
--

DROP TABLE IF EXISTS `report_content`;
CREATE TABLE IF NOT EXISTS `report_content` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `coc_no` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `date_of_issuance` date DEFAULT NULL,
  `cab_method` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `technical_regulation` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `notify_body` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `means_shipping` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
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
  `pro_dimension` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `aws_path` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `qr_code` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `statuts` int(11) NOT NULL DEFAULT '1',
  `re_generate` int(11) NOT NULL DEFAULT '0' COMMENT '0=>no request,1=>request,2=>reject,3=>approved',
  `no_re_generate` int(11) NOT NULL DEFAULT '0',
  `change_coc` int(11) NOT NULL DEFAULT '0',
  `release_date` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`report_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `re_generate_request`
--

DROP TABLE IF EXISTS `re_generate_request`;
CREATE TABLE IF NOT EXISTS `re_generate_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `coc_number` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0=>approve,1=>pending,2=>reject',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `re_genrate_pdf`
--

DROP TABLE IF EXISTS `re_genrate_pdf`;
CREATE TABLE IF NOT EXISTS `re_genrate_pdf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `old_pdf` varchar(255) NOT NULL,
  `coc_no` varchar(255) NOT NULL,
  `release_date` varchar(255) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rfc_document`
--

DROP TABLE IF EXISTS `rfc_document`;
CREATE TABLE IF NOT EXISTS `rfc_document` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '0=>deactive,1=>active',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `name`, `status`) VALUES
(1, 'Super Admin', '1'),
(2, 'Admin', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sample_photo`
--

DROP TABLE IF EXISTS `sample_photo`;
CREATE TABLE IF NOT EXISTS `sample_photo` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `set_permission`
--

DROP TABLE IF EXISTS `set_permission`;
CREATE TABLE IF NOT EXISTS `set_permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `function_id` text NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `set_permission`
--

INSERT INTO `set_permission` (`permission_id`, `role_id`, `function_id`) VALUES
(2, 1, '7,8,9,4,5,6,1,2,3,30,31,32,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,66,10,11,12,33,34,35,36,37,38,39,40,41,46,47,48,49,50,51,52,53,54,59,60,61,42,43,44,45,55,56,57,58,62,63,64,65');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
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
  `address` varchar(255) NOT NULL,
  `signature_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `phone_number`, `role_id`, `password`, `last_login`, `status`, `del_status`, `created_on`, `default_country`, `address`, `signature_path`) VALUES
(7, 'shankar.k@geochem-cp.com', 'Shankar', 'Kumar', '562622', 1, '25f9e794323b453885f5181f1b624d0b', '2021-01-10 10:47:14 AM', '1', 1, '2019-11-14 00:01:50', 103, '', 'https://cosqc-prod.s3.ap-south-1.amazonaws.com/cosqc/docs/arasu-27-Mar-9583.jpg'),
(8, 'developer.cps04@geochem-cp.com', 'lakshay', 'developer', 'sdfdsf', 1, 'd41d8cd98f00b204e9800998ecf8427e', '', '1', 1, '2020-12-22 06:08:47', 18, 'sdfsdf', NULL),
(9, 'demo@geochem.com', 'TESTING', 'DONE', '7894561230', 1, '25f9e794323b453885f5181f1b624d0b', '2021-01-07 08:48:31 AM', '1', 1, '2021-01-05 05:44:36', 103, 'fxgfdgfd', NULL),
(10, 'samrendra.cps05@geochem-cp.com', 'Samrendra', 'Singh', '24323423', 1, '25f9e794323b453885f5181f1b624d0b', '2021-01-08 04:21:11 AM', '1', 1, '2021-01-05 23:43:48', 17, 'dfdsfsd', 'https://s3.ap-south-1.amazonaws.com/demo-portal-app.log/GMARK/USER_SIGNATURE//sam10_05_56.jpg'),
(11, 'developer.cps03@geochem-cp.com', 'jyoti', 'bansal', '567546456546', 1, '25f9e794323b453885f5181f1b624d0b', '', '1', 1, '2021-01-06 00:08:48', 21, 'sdfdsf', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
