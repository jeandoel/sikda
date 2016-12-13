-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 11, 2015 at 08:41 
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sikda_puskesmas`
--

-- --------------------------------------------------------

--
-- Table structure for table `laporan_agregat`
--

CREATE TABLE IF NOT EXISTS `laporan_agregat` (
  `Id` varchar(100) NOT NULL,
  `month` date NOT NULL,
  `kode_puskesmas` varchar(100) NOT NULL,
  `puskesmas` varchar(100) NOT NULL,
  `RawatJalanL` int(11) NOT NULL,
  `RawatJalanP` int(11) NOT NULL,
  `RawatInapL` int(11) NOT NULL,
  `RawatInapP` int(11) NOT NULL,
  `KIA_ANC` int(11) NOT NULL,
  `KIA_PNC` int(11) NOT NULL,
  `KIA_NORMAL` int(11) NOT NULL,
  `KB` int(11) NOT NULL,
  `DIRUJUK` int(11) NOT NULL,
  `RUJUKBALIK` int(11) NOT NULL,
  `RECDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `laporan_agregat`
--

INSERT INTO `laporan_agregat` VALUES('P17040202012014-01-01', '2014-01-01', 'P1704020201', 'LINAU', 3, 4, 0, 3, 3, 3, 4, 3, 3, 4, '2014-11-10 22:18:52');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-02-01', '2014-02-01', 'P1704020201', 'LINAU', 3, 3, 4, 1, 3, 3, 4, 3, 3, 4, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-03-01', '2014-03-01', 'P1704020201', 'LINAU', 3, 3, 4, 2, 23, 3, 3, 4, 3, 3, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-04-01', '2014-04-01', 'P1704020201', 'LINAU', 4, 3, 3, 5, 4, 4, 4, 4, 4, 4, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-05-01', '2014-05-01', 'P1704020201', 'LINAU', 4, 4, 4, 4, 12, 3, 4, 3, 3, 4, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-06-01', '2014-06-01', 'P1704020201', 'LINAU', 5, 5, 5, 4, 3, 3, 4, 3, 3, 4, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-07-01', '2014-07-01', 'P1704020201', 'LINAU', 5, 5, 5, 5, 4, 3, 3, 4, 3, 3, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-08-01', '2014-08-01', 'P1704020201', 'LINAU', 5, 5, 5, 5, 4, 4, 4, 4, 4, 4, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-09-01', '2014-09-01', 'P1704020201', 'LINAU', 4, 4, 4, 4, 3, 3, 4, 3, 3, 4, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-10-01', '2014-10-01', 'P1704020201', 'LINAU', 5, 5, 5, 4, 3, 3, 4, 3, 3, 4, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-11-01', '2014-11-01', 'P1704020201', 'LINAU', 5, 5, 5, 5, 4, 3, 3, 4, 3, 3, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P17040202012014-12-01', '2014-12-01', 'P1704020201', 'LINAU', 5, 5, 5, 5, 4, 4, 4, 4, 4, 4, '2014-11-10 22:08:34');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-01-01', '2014-01-01', 'P1801011101', 'BENGKUNAT', 3, 4, 0, 3, 3, 3, 4, 3, 3, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-02-01', '2014-02-01', 'P1801011101', 'BENGKUNAT', 3, 3, 4, 1, 3, 3, 4, 3, 3, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-03-01', '2014-03-01', 'P1801011101', 'BENGKUNAT', 3, 3, 4, 2, 23, 3, 3, 4, 3, 3, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-04-01', '2014-04-01', 'P1801011101', 'BENGKUNAT', 4, 3, 3, 5, 4, 4, 4, 4, 4, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-05-01', '2014-05-01', 'P1801011101', 'BENGKUNAT', 4, 4, 4, 4, 12, 3, 4, 3, 3, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-06-01', '2014-06-01', 'P1801011101', 'BENGKUNAT', 5, 5, 5, 4, 3, 3, 4, 3, 3, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-07-01', '2014-07-01', 'P1801011101', 'BENGKUNAT', 5, 5, 5, 5, 4, 3, 3, 4, 3, 3, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-08-01', '2014-08-01', 'P1801011101', 'BENGKUNAT', 5, 5, 5, 5, 4, 4, 4, 4, 4, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-09-01', '2014-09-01', 'P1801011101', 'BENGKUNAT', 4, 4, 4, 4, 3, 3, 4, 3, 3, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-10-01', '2014-10-01', 'P1801011101', 'BENGKUNAT', 5, 5, 5, 4, 3, 3, 4, 3, 3, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-11-01', '2014-11-01', 'P1801011101', 'BENGKUNAT', 5, 5, 5, 5, 4, 3, 3, 4, 3, 3, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010111012014-12-01', '2014-12-01', 'P1801011101', 'BENGKUNAT', 5, 5, 5, 5, 4, 4, 4, 4, 4, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-01-01', '2014-01-01', 'P1801010101', 'BIHA', 3, 4, 0, 3, 3, 3, 4, 3, 3, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-02-01', '2014-02-01', 'P1801010101', 'BIHA', 3, 3, 4, 1, 3, 3, 4, 3, 3, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-03-01', '2014-03-01', 'P1801010101', 'BIHA', 3, 3, 4, 2, 23, 3, 3, 4, 3, 3, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-04-01', '2014-04-01', 'P1801010101', 'BIHA', 4, 3, 3, 5, 4, 4, 4, 4, 4, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-05-01', '2014-05-01', 'P1801010101', 'BIHA', 4, 4, 4, 4, 12, 3, 4, 3, 3, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-06-01', '2014-06-01', 'P1801010101', 'BIHA', 5, 5, 5, 4, 3, 3, 4, 3, 3, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-07-01', '2014-07-01', 'P1801010101', 'BIHA', 5, 5, 5, 5, 4, 3, 3, 4, 3, 3, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-08-01', '2014-08-01', 'P1801010101', 'BIHA', 5, 5, 5, 5, 4, 4, 4, 4, 4, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-09-01', '2014-09-01', 'P1801010101', 'BIHA', 4, 4, 4, 4, 3, 3, 4, 3, 3, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-10-01', '2014-10-01', 'P1801010101', 'BIHA', 5, 5, 5, 4, 3, 3, 4, 3, 3, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-11-01', '2014-11-01', 'P1801010101', 'BIHA', 5, 5, 5, 5, 4, 3, 3, 4, 3, 3, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P18010101012014-12-01', '2014-12-01', 'P1801010101', 'BIHA', 5, 5, 5, 5, 4, 4, 4, 4, 4, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-01-01', '2014-01-01', 'P1501010101', 'LEMPUR', 3, 4, 0, 3, 3, 3, 4, 3, 3, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-02-01', '2014-02-01', 'P1501010101', 'LEMPUR', 3, 3, 4, 1, 3, 3, 4, 3, 3, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-03-01', '2014-03-01', 'P1501010101', 'LEMPUR', 3, 3, 4, 2, 23, 3, 3, 4, 3, 3, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-04-01', '2014-04-01', 'P1501010101', 'LEMPUR', 4, 3, 3, 5, 4, 4, 4, 4, 4, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-05-01', '2014-05-01', 'P1501010101', 'LEMPUR', 4, 4, 4, 4, 12, 3, 4, 3, 3, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-06-01', '2014-06-01', 'P1501010101', 'LEMPUR', 5, 5, 5, 4, 3, 3, 4, 3, 3, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-07-01', '2014-07-01', 'P1501010101', 'LEMPUR', 5, 5, 5, 5, 4, 3, 3, 4, 3, 3, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-08-01', '2014-08-01', 'P1501010101', 'LEMPUR', 5, 5, 5, 5, 4, 4, 4, 4, 4, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-09-01', '2014-09-01', 'P1501010101', 'LEMPUR', 4, 4, 4, 4, 3, 3, 4, 3, 3, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-10-01', '2014-10-01', 'P1501010101', 'LEMPUR', 5, 5, 5, 4, 3, 3, 4, 3, 3, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-11-01', '2014-11-01', 'P1501010101', 'LEMPUR', 5, 5, 5, 5, 4, 3, 3, 4, 3, 3, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat` VALUES('P15010101012014-12-01', '2014-12-01', 'P1501010101', 'LEMPUR', 5, 5, 5, 5, 4, 4, 4, 4, 4, 4, '2014-11-21 15:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_agregat_diagnosa`
--

CREATE TABLE IF NOT EXISTS `laporan_agregat_diagnosa` (
  `ID` varchar(100) NOT NULL,
  `MONTH` date NOT NULL,
  `KD_PUSKESMAS` varchar(100) NOT NULL,
  `PUSKESMAS` varchar(100) NOT NULL,
  `TYPE` varchar(2) NOT NULL,
  `NM_ICD` varchar(100) NOT NULL,
  `KD_ICD` varchar(100) NOT NULL,
  `L` int(11) NOT NULL,
  `P` int(11) NOT NULL,
  `RECDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `laporan_agregat_diagnosa`
--

INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RJ1', '2014-09-01', 'P1704020201', 'LINAU', 'RJ', 'Demam yang tidak diketahui sebabnya', 'R50', 23, 5, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RJ2', '2014-09-01', 'P1704020201', 'LINAU', 'RJ', 'Defects of catalase and peroxidase', 'E80.3', 4, 4, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RJ3', '2014-09-01', 'P1704020201', 'LINAU', 'RJ', 'Malaria falsifarum / Malaria tropika', 'B50', 5, 5, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RJ4', '2014-09-01', 'P1704020201', 'LINAU', 'RJ', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 8, 6, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RJ5', '2014-09-01', 'P1704020201', 'LINAU', 'RJ', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 4, 5, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RJ6', '2014-09-01', 'P1704020201', 'LINAU', 'RJ', 'Demam Tifoid', 'A01.0', 6, 4, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RJ7', '2014-09-01', 'P1704020201', 'LINAU', 'RJ', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 33, 3, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RJ8', '2014-09-01', 'P1704020201', 'LINAU', 'RJ', 'Campylobacter enteritis ', 'A04.5', 4, 4, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RJ9', '2014-09-01', 'P1704020201', 'LINAU', 'RJ', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 3, 7, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RJ10', '2014-09-01', 'P1704020201', 'LINAU', 'RJ', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 5, 6, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RI1', '2014-09-01', 'P1704020201', 'LINAU', 'RI', 'Demam yang tidak diketahui sebabnya', 'R50', 88, 6, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RI2', '2014-09-01', 'P1704020201', 'LINAU', 'RI', 'Defects of catalase and peroxidase', 'E80.3', 7, 5, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RI3', '2014-09-01', 'P1704020201', 'LINAU', 'RI', 'Malaria falsifarum / Malaria tropika', 'B50', 65, 24, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RI4', '2014-09-01', 'P1704020201', 'LINAU', 'RI', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 45, 23, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RI5', '2014-09-01', 'P1704020201', 'LINAU', 'RI', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 6, 16, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RI6', '2014-09-01', 'P1704020201', 'LINAU', 'RI', 'Demam Tifoid', 'A01.0', 3, 12, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RI7', '2014-09-01', 'P1704020201', 'LINAU', 'RI', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 2, 12, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RI8', '2014-09-01', 'P1704020201', 'LINAU', 'RI', 'Campylobacter enteritis ', 'A04.5', 56, 614, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RI9', '2014-09-01', 'P1704020201', 'LINAU', 'RI', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 7, 7, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1704020201RI10', '2014-09-01', 'P1704020201', 'LINAU', 'RI', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 8, 4, '2014-12-04 16:42:00');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RJ1', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RJ', 'Demam yang tidak diketahui sebabnya', 'R50', 23, 5, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RJ2', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RJ', 'Defects of catalase and peroxidase', 'E80.3', 4, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RJ3', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RJ', 'Malaria falsifarum / Malaria tropika', 'B50', 5, 5, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RJ4', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RJ', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 8, 6, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RJ5', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RJ', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 4, 5, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RJ6', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RJ', 'Demam Tifoid', 'A01.0', 6, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RJ7', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RJ', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 33, 3, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RJ8', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RJ', 'Campylobacter enteritis ', 'A04.5', 4, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RJ9', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RJ', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 3, 7, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RJ10', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RJ', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 5, 6, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RI1', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RI', 'Demam yang tidak diketahui sebabnya', 'R50', 88, 6, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RI2', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RI', 'Defects of catalase and peroxidase', 'E80.3', 7, 5, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RI3', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RI', 'Malaria falsifarum / Malaria tropika', 'B50', 65, 24, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RI4', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RI', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 45, 23, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RI5', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RI', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 6, 16, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RI6', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RI', 'Demam Tifoid', 'A01.0', 3, 12, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RI7', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RI', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 2, 12, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RI8', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RI', 'Campylobacter enteritis ', 'A04.5', 56, 614, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RI9', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RI', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 7, 7, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801011101RI10', '2014-09-01', 'P1801011101', 'BENGKUNAT', 'RI', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 8, 4, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RJ1', '2014-09-01', 'P1801010101', 'BIHA', 'RJ', 'Demam yang tidak diketahui sebabnya', 'R50', 23, 5, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RJ2', '2014-09-01', 'P1801010101', 'BIHA', 'RJ', 'Defects of catalase and peroxidase', 'E80.3', 4, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RJ3', '2014-09-01', 'P1801010101', 'BIHA', 'RJ', 'Malaria falsifarum / Malaria tropika', 'B50', 5, 5, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RJ4', '2014-09-01', 'P1801010101', 'BIHA', 'RJ', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 8, 6, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RJ5', '2014-09-01', 'P1801010101', 'BIHA', 'RJ', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 4, 5, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RJ6', '2014-09-01', 'P1801010101', 'BIHA', 'RJ', 'Demam Tifoid', 'A01.0', 6, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RJ7', '2014-09-01', 'P1801010101', 'BIHA', 'RJ', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 33, 3, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RJ8', '2014-09-01', 'P1801010101', 'BIHA', 'RJ', 'Campylobacter enteritis ', 'A04.5', 4, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RJ9', '2014-09-01', 'P1801010101', 'BIHA', 'RJ', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 3, 7, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RJ10', '2014-09-01', 'P1801010101', 'BIHA', 'RJ', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 5, 6, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RI1', '2014-09-01', 'P1801010101', 'BIHA', 'RI', 'Demam yang tidak diketahui sebabnya', 'R50', 88, 6, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RI2', '2014-09-01', 'P1801010101', 'BIHA', 'RI', 'Defects of catalase and peroxidase', 'E80.3', 7, 5, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RI3', '2014-09-01', 'P1801010101', 'BIHA', 'RI', 'Malaria falsifarum / Malaria tropika', 'B50', 65, 24, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RI4', '2014-09-01', 'P1801010101', 'BIHA', 'RI', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 45, 23, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RI5', '2014-09-01', 'P1801010101', 'BIHA', 'RI', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 6, 16, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RI6', '2014-09-01', 'P1801010101', 'BIHA', 'RI', 'Demam Tifoid', 'A01.0', 3, 12, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RI7', '2014-09-01', 'P1801010101', 'BIHA', 'RI', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 2, 12, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RI8', '2014-09-01', 'P1801010101', 'BIHA', 'RI', 'Campylobacter enteritis ', 'A04.5', 56, 614, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RI9', '2014-09-01', 'P1801010101', 'BIHA', 'RI', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 7, 7, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1801010101RI10', '2014-09-01', 'P1801010101', 'BIHA', 'RI', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 8, 4, '2014-11-21 15:14:11');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RJ1', '2014-09-01', 'P1501010101', 'LEMPUR', 'RJ', 'Demam yang tidak diketahui sebabnya', 'R50', 23, 5, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RJ2', '2014-09-01', 'P1501010101', 'LEMPUR', 'RJ', 'Defects of catalase and peroxidase', 'E80.3', 4, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RJ3', '2014-09-01', 'P1501010101', 'LEMPUR', 'RJ', 'Malaria falsifarum / Malaria tropika', 'B50', 5, 5, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RJ4', '2014-09-01', 'P1501010101', 'LEMPUR', 'RJ', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 8, 6, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RJ5', '2014-09-01', 'P1501010101', 'LEMPUR', 'RJ', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 4, 5, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RJ6', '2014-09-01', 'P1501010101', 'LEMPUR', 'RJ', 'Demam Tifoid', 'A01.0', 6, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RJ7', '2014-09-01', 'P1501010101', 'LEMPUR', 'RJ', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 33, 3, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RJ8', '2014-09-01', 'P1501010101', 'LEMPUR', 'RJ', 'Campylobacter enteritis ', 'A04.5', 4, 4, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RJ9', '2014-09-01', 'P1501010101', 'LEMPUR', 'RJ', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 3, 7, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RJ10', '2014-09-01', 'P1501010101', 'LEMPUR', 'RJ', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 5, 6, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RI1', '2014-09-01', 'P1501010101', 'LEMPUR', 'RI', 'Demam yang tidak diketahui sebabnya', 'R50', 88, 6, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RI2', '2014-09-01', 'P1501010101', 'LEMPUR', 'RI', 'Defects of catalase and peroxidase', 'E80.3', 7, 5, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RI3', '2014-09-01', 'P1501010101', 'LEMPUR', 'RI', 'Malaria falsifarum / Malaria tropika', 'B50', 65, 24, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RI4', '2014-09-01', 'P1501010101', 'LEMPUR', 'RI', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 45, 23, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RI5', '2014-09-01', 'P1501010101', 'LEMPUR', 'RI', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 6, 16, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RI6', '2014-09-01', 'P1501010101', 'LEMPUR', 'RI', 'Demam Tifoid', 'A01.0', 3, 12, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RI7', '2014-09-01', 'P1501010101', 'LEMPUR', 'RI', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 2, 12, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RI8', '2014-09-01', 'P1501010101', 'LEMPUR', 'RI', 'Campylobacter enteritis ', 'A04.5', 56, 614, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RI9', '2014-09-01', 'P1501010101', 'LEMPUR', 'RI', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 7, 7, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa` VALUES('2014-09-01P1501010101RI10', '2014-09-01', 'P1501010101', 'LEMPUR', 'RI', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 8, 4, '2014-11-21 15:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_agregat_diagnosa_rujukan`
--

CREATE TABLE IF NOT EXISTS `laporan_agregat_diagnosa_rujukan` (
  `ID` varchar(100) NOT NULL,
  `MONTH` date NOT NULL,
  `KD_PUSKESMAS` varchar(100) NOT NULL,
  `PUSKESMAS` varchar(100) NOT NULL,
  `NM_ICD` varchar(100) NOT NULL,
  `KD_ICD` varchar(100) NOT NULL,
  `L` int(11) NOT NULL,
  `P` int(11) NOT NULL,
  `RECDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `laporan_agregat_diagnosa_rujukan`
--

INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-09-01P1704020201RJ1', '2014-09-01', 'P1704020201', 'LINAU', 'Demam yang tidak diketahui sebabnya', 'R50', 4, 6, '2014-11-12 10:58:32');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-09-01P1704020201RJ2', '2014-09-01', 'P1704020201', 'LINAU', 'Defects of catalase and peroxidase', 'E80.3', 2, 5, '2014-11-12 10:58:32');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-09-01P1704020201RJ3', '2014-09-01', 'P1704020201', 'LINAU', 'Malaria falsifarum / Malaria tropika', 'B50', 34, 32, '2014-12-04 16:42:01');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-09-01P1704020201RJ4', '2014-09-01', 'P1704020201', 'LINAU', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 2, 5, '2014-11-12 10:58:32');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-09-01P1704020201RJ5', '2014-09-01', 'P1704020201', 'LINAU', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 2, 43, '2014-12-04 16:42:01');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-09-01P1704020201RJ6', '2014-09-01', 'P1704020201', 'LINAU', 'Demam Tifoid', 'A01.0', 32, 6, '2014-12-04 16:42:01');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-09-01P1704020201RJ7', '2014-09-01', 'P1704020201', 'LINAU', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 33, 5, '2014-12-04 16:42:01');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-09-01P1704020201RJ8', '2014-09-01', 'P1704020201', 'LINAU', 'Campylobacter enteritis ', 'A04.5', 4, 3, '2014-12-04 16:42:01');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-09-01P1704020201RJ9', '2014-09-01', 'P1704020201', 'LINAU', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 3, 6, '2014-11-12 10:58:32');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-09-01P1704020201RJ10', '2014-09-01', 'P1704020201', 'LINAU', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 6, 8, '2014-12-04 16:42:01');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801011101RJ1', '2014-01-01', 'P1801011101', 'BENGKUNAT', 'Demam yang tidak diketahui sebabnya', 'R50', 4, 6, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801011101RJ2', '2014-01-01', 'P1801011101', 'BENGKUNAT', 'Defects of catalase and peroxidase', 'E80.3', 2, 5, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801011101RJ3', '2014-01-01', 'P1801011101', 'BENGKUNAT', 'Malaria falsifarum / Malaria tropika', 'B50', 34, 32, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801011101RJ4', '2014-01-01', 'P1801011101', 'BENGKUNAT', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 2, 5, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801011101RJ5', '2014-01-01', 'P1801011101', 'BENGKUNAT', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 2, 43, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801011101RJ6', '2014-01-01', 'P1801011101', 'BENGKUNAT', 'Demam Tifoid', 'A01.0', 32, 6, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801011101RJ7', '2014-01-01', 'P1801011101', 'BENGKUNAT', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 33, 5, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801011101RJ8', '2014-01-01', 'P1801011101', 'BENGKUNAT', 'Campylobacter enteritis ', 'A04.5', 4, 3, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801011101RJ9', '2014-01-01', 'P1801011101', 'BENGKUNAT', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 3, 6, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801011101RJ10', '2014-01-01', 'P1801011101', 'BENGKUNAT', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 6, 8, '2014-11-21 14:20:33');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801010101RJ1', '2014-01-01', 'P1801010101', 'BIHA', 'Demam yang tidak diketahui sebabnya', 'R50', 4, 6, '2014-11-21 15:14:12');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801010101RJ2', '2014-01-01', 'P1801010101', 'BIHA', 'Defects of catalase and peroxidase', 'E80.3', 2, 5, '2014-11-21 15:14:12');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801010101RJ3', '2014-01-01', 'P1801010101', 'BIHA', 'Malaria falsifarum / Malaria tropika', 'B50', 34, 32, '2014-11-21 15:14:12');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801010101RJ4', '2014-01-01', 'P1801010101', 'BIHA', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 2, 5, '2014-11-21 15:14:12');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801010101RJ5', '2014-01-01', 'P1801010101', 'BIHA', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 2, 43, '2014-11-21 15:14:12');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801010101RJ6', '2014-01-01', 'P1801010101', 'BIHA', 'Demam Tifoid', 'A01.0', 32, 6, '2014-11-21 15:14:12');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801010101RJ7', '2014-01-01', 'P1801010101', 'BIHA', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 33, 5, '2014-11-21 15:14:12');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801010101RJ8', '2014-01-01', 'P1801010101', 'BIHA', 'Campylobacter enteritis ', 'A04.5', 4, 3, '2014-11-21 15:14:12');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801010101RJ9', '2014-01-01', 'P1801010101', 'BIHA', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 3, 6, '2014-11-21 15:14:12');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1801010101RJ10', '2014-01-01', 'P1801010101', 'BIHA', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 6, 8, '2014-11-21 15:14:12');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1501010101RJ1', '2014-01-01', 'P1501010101', 'LEMPUR', 'Demam yang tidak diketahui sebabnya', 'R50', 4, 6, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1501010101RJ2', '2014-01-01', 'P1501010101', 'LEMPUR', 'Defects of catalase and peroxidase', 'E80.3', 2, 5, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1501010101RJ3', '2014-01-01', 'P1501010101', 'LEMPUR', 'Malaria falsifarum / Malaria tropika', 'B50', 34, 32, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1501010101RJ4', '2014-01-01', 'P1501010101', 'LEMPUR', 'Respiratory tuberculosis, bacteriologically and histological', 'A15', 2, 5, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1501010101RJ5', '2014-01-01', 'P1501010101', 'LEMPUR', 'Haemophilus influenzae [H. influenzae] as the cause of disea', 'B96.3', 2, 43, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1501010101RJ6', '2014-01-01', 'P1501010101', 'LEMPUR', 'Demam Tifoid', 'A01.0', 32, 6, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1501010101RJ7', '2014-01-01', 'P1501010101', 'LEMPUR', 'Tuberculosis of lung, confirmed by sputum microscopy with or ', 'A15.0', 33, 5, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1501010101RJ8', '2014-01-01', 'P1501010101', 'LEMPUR', 'Campylobacter enteritis ', 'A04.5', 4, 3, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1501010101RJ9', '2014-01-01', 'P1501010101', 'LEMPUR', 'Cytomegaloviral pancreatitis (K87.1*) ', 'B25.2+ ', 3, 6, '2014-11-21 15:23:08');
INSERT INTO `laporan_agregat_diagnosa_rujukan` VALUES('2014-01-01P1501010101RJ10', '2014-01-01', 'P1501010101', 'LEMPUR', 'Carotid artery syndrome (hemispheric) ', 'G45.1', 6, 8, '2014-11-21 15:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_agregat_rekap_jenis_pasien`
--

CREATE TABLE IF NOT EXISTS `laporan_agregat_rekap_jenis_pasien` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MONTH` date NOT NULL,
  `KD_PUSKESMAS` varchar(100) NOT NULL,
  `PUSKESMAS` varchar(100) NOT NULL,
  `TYPE_JAMINAN` varchar(100) NOT NULL,
  `JENIS_KELAMIN` varchar(2) NOT NULL,
  `JUMLAH` int(11) NOT NULL,
  `RECDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `laporan_agregat_rekap_jenis_pasien`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
