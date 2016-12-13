/*
SQLyog Ultimate v8.82 
MySQL - 5.5.13 : Database - sikda_puskesmas
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sikda_puskesmas` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `sikda_puskesmas`;

/*Table structure for table `vw_alergi_obat` */

DROP TABLE IF EXISTS `vw_alergi_obat`;

/*!50001 DROP VIEW IF EXISTS `vw_alergi_obat` */;
/*!50001 DROP TABLE IF EXISTS `vw_alergi_obat` */;

/*!50001 CREATE TABLE  `vw_alergi_obat`(
 `KD_KUNJUNGAN` varchar(30) ,
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `KD_OBAT` varchar(20) ,
 `NAMA_OBAT` varchar(100) 
)*/;

/*Table structure for table `vw_banyak_kunjungan_dashboard` */

DROP TABLE IF EXISTS `vw_banyak_kunjungan_dashboard`;

/*!50001 DROP VIEW IF EXISTS `vw_banyak_kunjungan_dashboard` */;
/*!50001 DROP TABLE IF EXISTS `vw_banyak_kunjungan_dashboard` */;

/*!50001 CREATE TABLE  `vw_banyak_kunjungan_dashboard`(
 `KD_PUSKESMAS` varchar(20) ,
 `TGL_MASUK` date ,
 `TOTAL` bigint(21) 
)*/;

/*Table structure for table `vw_belajar` */

DROP TABLE IF EXISTS `vw_belajar`;

/*!50001 DROP VIEW IF EXISTS `vw_belajar` */;
/*!50001 DROP TABLE IF EXISTS `vw_belajar` */;

/*!50001 CREATE TABLE  `vw_belajar`(
 `KD_KUNJUNGAN` varchar(30) ,
 `KD_KUNJUNGAN_BUMIL` int(30) ,
 `KD_PASIEN` varchar(20) ,
 `KD_OBAT` varchar(20) ,
 `KD_PENYAKIT` varchar(20) ,
 `JNS_KASUS` varchar(10) ,
 `KD_TINDAKAN` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_KIA` int(20) 
)*/;

/*Table structure for table `vw_detail_bersalin` */

DROP TABLE IF EXISTS `vw_detail_bersalin`;

/*!50001 DROP VIEW IF EXISTS `vw_detail_bersalin` */;
/*!50001 DROP TABLE IF EXISTS `vw_detail_bersalin` */;

/*!50001 CREATE TABLE  `vw_detail_bersalin`(
 `KD_KUNJUNGAN` varchar(30) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `TANGGAL_PERSALINAN` date ,
 `JAM_KELAHIRAN` time ,
 `KD_KUNJUNGAN_BERSALIN` int(20) ,
 `UMUR_KEHAMILAN` varchar(10) ,
 `ANAK_KE` int(10) ,
 `BERAT_LAHIR` int(10) ,
 `JML_BAYI` int(10) ,
 `KET_TAMBAHAN` text ,
 `LINGKAR_KEPALA` int(10) ,
 `PANJANG_BADAN` int(10) ,
 `DOKTER_PEMERIKSA` varchar(50) ,
 `DOKTER_PETUGAS` varchar(50) ,
 `CARA_PERSALINAN` varchar(255) ,
 `KD_CARA_PERSALINAN` int(10) ,
 `JENIS_KELAHIRAN` varchar(20) ,
 `KEADAAN_KESEHATAN` varchar(60) ,
 `KD_KEADAAN_KESEHATAN` int(11) ,
 `CATATAN_DOKTER` text ,
 `CATATAN_APOTEK` text ,
 `KEADAAN_BAYI_LAHIR` varchar(341) ,
 `ASUHAN_BAYI_LAHIR` varchar(341) ,
 `STATUS_HAMIL` varchar(20) ,
 `KD_STATUS_HAMIL` int(11) ,
 `TINDAKAN` varchar(271) ,
 `RESEP_OBAT` varchar(172) ,
 `ALERGI` varchar(100) ,
 `JENIS_KELAMIN` varchar(15) 
)*/;

/*Table structure for table `vw_detail_kunjungan_bersalin` */

DROP TABLE IF EXISTS `vw_detail_kunjungan_bersalin`;

/*!50001 DROP VIEW IF EXISTS `vw_detail_kunjungan_bersalin` */;
/*!50001 DROP TABLE IF EXISTS `vw_detail_kunjungan_bersalin` */;

/*!50001 CREATE TABLE  `vw_detail_kunjungan_bersalin`(
 `KD_KUNJUNGAN` varchar(30) ,
 `KD_PASIEN` varchar(20) ,
 `TANGGAL_KUNJUNGAN` varchar(72) ,
 `JAM_KELAHIRAN` time ,
 `UMUR_KEHAMILAN` varchar(10) ,
 `JML_BAYI` int(10) ,
 `KET_TAMBAHAN` text ,
 `petugas` varchar(50) ,
 `pemeriksa` varchar(50) ,
 `CARA_PERSALINAN` varchar(255) ,
 `JENIS_KELAHIRAN` varchar(20) ,
 `KEADAAN_KESEHATAN` varchar(60) ,
 `KEADAAN_BAYI_LAHIR` varchar(50) ,
 `STATUS_HAMIL` varchar(20) ,
 `ANAK_KE` int(10) ,
 `LINGKAR_KEPALA` int(10) ,
 `BERAT_LAHIR` int(10) ,
 `PANJANG_BADAN` int(10) ,
 `JENIS_KELAMIN` varchar(15) ,
 `ASUHAN_BAYI_LAHIR` varchar(20) ,
 `TINDAKAN` text ,
 `ALERGI` text ,
 `OBAT` text 
)*/;

/*Table structure for table `vw_detail_pasien_imunisasi` */

DROP TABLE IF EXISTS `vw_detail_pasien_imunisasi`;

/*!50001 DROP VIEW IF EXISTS `vw_detail_pasien_imunisasi` */;
/*!50001 DROP TABLE IF EXISTS `vw_detail_pasien_imunisasi` */;

/*!50001 CREATE TABLE  `vw_detail_pasien_imunisasi`(
 `KD_TRANS_IMUNISASI` int(20) ,
 `KD_PASIEN` varchar(20) ,
 `TANGGAL` date ,
 `KATEGORI_IMUNISASI` varchar(20) ,
 `NAMA_LOKASI` text ,
 `ALAMAT_LOKASI` text ,
 `KELURAHAN` varchar(50) ,
 `KECAMATAN` varchar(50) ,
 `NAMA_LENGKAP` varchar(50) ,
 `TGL_LAHIR` date ,
 `JENIS_KELAMIN` varchar(15) ,
 `ALAMAT` varchar(200) ,
 `KD_PROVINSI` varchar(20) ,
 `KD_KABKOTA` varchar(20) ,
 `KD_KECAMATAN` varchar(20) ,
 `KD_KELURAHAN` varchar(20) ,
 `JENIS_PASIEN` varchar(20) ,
 `KD_JENIS_PASIEN` int(20) ,
 `PEMERIKSAAN_FISIK` text ,
 `JENIS_IMUNISASI` varchar(341) ,
 `VAKSIN` text ,
 `NAMA` varchar(50) 
)*/;

/*Table structure for table `vw_detail_pasien_kipi` */

DROP TABLE IF EXISTS `vw_detail_pasien_kipi`;

/*!50001 DROP VIEW IF EXISTS `vw_detail_pasien_kipi` */;
/*!50001 DROP TABLE IF EXISTS `vw_detail_pasien_kipi` */;

/*!50001 CREATE TABLE  `vw_detail_pasien_kipi`(
 `KD_TRANS_KIPI` int(20) ,
 `tanggal_imunisasi` date ,
 `KD_PASIEN` varchar(20) ,
 `NAMA_LENGKAP` varchar(50) ,
 `TGL_LAHIR` date ,
 `JENIS_KELAMIN` varchar(15) ,
 `alamat_pasien` varchar(200) ,
 `KD_PROVINSI` varchar(20) ,
 `KD_KABKOTA` varchar(20) ,
 `KD_KECAMATAN` varchar(20) ,
 `KD_KELURAHAN` varchar(20) ,
 `TANGGAL_KIPI` date ,
 `KATEGORI_IMUNISASI` varchar(20) ,
 `NAMA_LOKASI` text ,
 `alamat_kipi` text ,
 `kec_kipi` varchar(20) ,
 `kel_kipi` varchar(20) ,
 `GEJALA_KIPI` text ,
 `KEADAAN_KESEHATAN` varchar(60) ,
 `dokter` varchar(50) 
)*/;

/*Table structure for table `vw_detail_pemeriksaan_neonatus` */

DROP TABLE IF EXISTS `vw_detail_pemeriksaan_neonatus`;

/*!50001 DROP VIEW IF EXISTS `vw_detail_pemeriksaan_neonatus` */;
/*!50001 DROP TABLE IF EXISTS `vw_detail_pemeriksaan_neonatus` */;

/*!50001 CREATE TABLE  `vw_detail_pemeriksaan_neonatus`(
 `KD_PASIEN` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_KIA` int(20) ,
 `KD_KUNJUNGAN` varchar(30) ,
 `id` int(10) ,
 `KD_PEMERIKSAAN_NEONATUS` int(10) ,
 `TANGGAL_KUNJUNGAN` varchar(10) ,
 `KUNJUNGAN_KE` varchar(20) ,
 `BERAT_BADAN` varchar(20) ,
 `PANJANG_BADAN` varchar(20) ,
 `HRG_TINDAKAN_ANAK` double ,
 `TINDAKAN_ANAK` varchar(341) ,
 `KET_TINDAKAN_ANAK` varchar(341) ,
 `KELUHAN` text ,
 `ALERGI` text ,
 `OBAT` text ,
 `TINDAKAN_IBU` varchar(341) ,
 `dokter_pemeriksa` varchar(72) ,
 `dokter_petugas` varchar(72) ,
 `kode` int(10) 
)*/;

/*Table structure for table `vw_detail_pemkes_anak` */

DROP TABLE IF EXISTS `vw_detail_pemkes_anak`;

/*!50001 DROP VIEW IF EXISTS `vw_detail_pemkes_anak` */;
/*!50001 DROP TABLE IF EXISTS `vw_detail_pemkes_anak` */;

/*!50001 CREATE TABLE  `vw_detail_pemkes_anak`(
 `KD_KUNJUNGAN` varchar(30) ,
 `TANGGAL_KUNJUNGAN` date ,
 `TINDAKAN` varchar(271) ,
 `ALERGI` varchar(100) ,
 `RESEP_OBAT` varchar(172) ,
 `dokter_pemeriksa` varchar(50) ,
 `dokter_petugas` varchar(50) ,
 `PENYAKIT` varchar(500) 
)*/;

/*Table structure for table `vw_detail_rawat_inap` */

DROP TABLE IF EXISTS `vw_detail_rawat_inap`;

/*!50001 DROP VIEW IF EXISTS `vw_detail_rawat_inap` */;
/*!50001 DROP TABLE IF EXISTS `vw_detail_rawat_inap` */;

/*!50001 CREATE TABLE  `vw_detail_rawat_inap`(
 `KD_KUNJUNGAN` varchar(30) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `TGL_PELAYANAN` date ,
 `KD_JENIS_PASIEN` varchar(20) ,
 `CUSTOMER` varchar(20) ,
 `KD_UNIT` varchar(20) ,
 `UNIT` varchar(50) ,
 `KD_CARA_BAYAR` varchar(20) ,
 `CARA_BAYAR` varchar(255) ,
 `ANAMNESA` varchar(255) ,
 `CATATAN_FISIK` varchar(255) ,
 `CATATAN_DOKTER` text ,
 `KEADAAN_KELUAR` varchar(50) 
)*/;

/*Table structure for table `vw_detail_rawat_jalan` */

DROP TABLE IF EXISTS `vw_detail_rawat_jalan`;

/*!50001 DROP VIEW IF EXISTS `vw_detail_rawat_jalan` */;
/*!50001 DROP TABLE IF EXISTS `vw_detail_rawat_jalan` */;

/*!50001 CREATE TABLE  `vw_detail_rawat_jalan`(
 `KD_KUNJUNGAN` varchar(30) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `TGL_PELAYANAN` date ,
 `KD_JENIS_PASIEN` varchar(20) ,
 `CUSTOMER` varchar(20) ,
 `KD_UNIT` varchar(20) ,
 `UNIT` varchar(50) ,
 `KD_CARA_BAYAR` varchar(20) ,
 `CARA_BAYAR` varchar(255) ,
 `ANAMNESA` varchar(255) ,
 `CATATAN_FISIK` varchar(255) ,
 `CATATAN_DOKTER` text ,
 `KEADAAN_KELUAR` varchar(50) 
)*/;

/*Table structure for table `vw_detail_tindakan` */

DROP TABLE IF EXISTS `vw_detail_tindakan`;

/*!50001 DROP VIEW IF EXISTS `vw_detail_tindakan` */;
/*!50001 DROP TABLE IF EXISTS `vw_detail_tindakan` */;

/*!50001 CREATE TABLE  `vw_detail_tindakan`(
 `KD_KIA` int(20) ,
 `KD_KUNJUNGAN` varchar(30) ,
 `TINDAKAN` varchar(502) 
)*/;

/*Table structure for table `vw_diagnosa` */

DROP TABLE IF EXISTS `vw_diagnosa`;

/*!50001 DROP VIEW IF EXISTS `vw_diagnosa` */;
/*!50001 DROP TABLE IF EXISTS `vw_diagnosa` */;

/*!50001 CREATE TABLE  `vw_diagnosa`(
 `KD_KUNJUNGAN` varchar(30) ,
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `KD_PENYAKIT` varchar(20) ,
 `PENYAKIT` varchar(500) ,
 `JNS_KASUS` varchar(10) ,
 `JNS_DX` varchar(20) 
)*/;

/*Table structure for table `vw_imunisasi` */

DROP TABLE IF EXISTS `vw_imunisasi`;

/*!50001 DROP VIEW IF EXISTS `vw_imunisasi` */;
/*!50001 DROP TABLE IF EXISTS `vw_imunisasi` */;

/*!50001 CREATE TABLE  `vw_imunisasi`(
 `KD_PASIEN` varchar(20) ,
 `KD_PUSKESMAS` varchar(20) ,
 `KD_KECAMATAN` varchar(20) ,
 `NAMA_LENGKAP` varchar(50) ,
 `TGL_LAHIR` varchar(10) ,
 `KD_JENIS_KELAMIN` varchar(4) ,
 `KD_TRANS_IMUNISASI` int(20) ,
 `ALAMAT` varchar(200) ,
 `STATUS_MARITAL` varchar(100) ,
 `NAMA_IBU` varchar(20) ,
 `NAMA_SUAMI` varchar(20) ,
 `nid` varchar(20) ,
 `nid2` varchar(20) ,
 `FLAG_L` smallint(1) ,
 `id_trans` int(20) 
)*/;

/*Table structure for table `vw_kasir_detail` */

DROP TABLE IF EXISTS `vw_kasir_detail`;

/*!50001 DROP VIEW IF EXISTS `vw_kasir_detail` */;
/*!50001 DROP TABLE IF EXISTS `vw_kasir_detail` */;

/*!50001 CREATE TABLE  `vw_kasir_detail`(
 `KD_PEL_KASIR` varchar(16) ,
 `KD_TARIF` varchar(5) ,
 `REFF` varchar(20) ,
 `KD_PRODUK` varchar(20) ,
 `KD_UNIT` varchar(20) ,
 `HARGA_PRODUK` double ,
 `TGL_BERLAKU` date ,
 `QTY` double ,
 `TOTAL_HARGA` double ,
 `PRODUK` varchar(255) ,
 `KD_PUSKESMAS` varchar(20) 
)*/;

/*Table structure for table `vw_kunjungan_bumil` */

DROP TABLE IF EXISTS `vw_kunjungan_bumil`;

/*!50001 DROP VIEW IF EXISTS `vw_kunjungan_bumil` */;
/*!50001 DROP TABLE IF EXISTS `vw_kunjungan_bumil` */;

/*!50001 CREATE TABLE  `vw_kunjungan_bumil`(
 `KD_PASIEN` varchar(20) ,
 `TANGGAL_KUNJUNGAN` date ,
 `KELUHAN` text ,
 `TEKANAN_DARAH` varchar(20) ,
 `BERAT_BADAN` varchar(20) ,
 `UMUR_KEHAMILAN` varchar(10) ,
 `TINGGI_FUNDUS` varchar(10) ,
 `KD_LETAK_JANIN` varchar(20) ,
 `DENYUT_JANTUNG` varchar(10) ,
 `KAKI_BENGKAK` varchar(20) ,
 `HASIL_LAB` varchar(62) ,
 `KD_TINDAKAN` varchar(20) ,
 `NASEHAT` text ,
 `STATUS_HAMIL` varchar(20) ,
 `TANGGAL_KEMBALI` date ,
 `KD_UNIT_PELAYANAN` varchar(20) ,
 `PEMERIKSA` varchar(20) ,
 `PETUGAS` varchar(20) ,
 `KD_PUSKESMAS` varchar(20) 
)*/;

/*Table structure for table `vw_layanan_order_obat` */

DROP TABLE IF EXISTS `vw_layanan_order_obat`;

/*!50001 DROP VIEW IF EXISTS `vw_layanan_order_obat` */;
/*!50001 DROP TABLE IF EXISTS `vw_layanan_order_obat` */;

/*!50001 CREATE TABLE  `vw_layanan_order_obat`(
 `KD_PELAYANAN` varchar(20) ,
 `KD_OBAT` varchar(20) ,
 `SAT_BESAR` varchar(20) ,
 `SAT_KECIL` varchar(20) ,
 `HRG_DASAR` double(10,0) ,
 `HRG_JUAL` double(10,0) ,
 `QTY` double(10,0) ,
 `DOSIS` varchar(50) ,
 `RACIKAN` varchar(5) ,
 `JUMLAH` double(10,0) ,
 `KD_PETUGAS` varchar(20) ,
 `STATUS` varchar(1) ,
 `iROW` int(11) ,
 `NAMA_OBAT` varchar(100) ,
 `GENERIK` varchar(11) ,
 `SINGKATAN` varchar(20) ,
 `KD_MILIK_OBAT` varchar(20) ,
 `NO_RESEP` varchar(20) ,
 `KD_PUSKESMAS` varchar(20) ,
 `NAMA` varchar(50) ,
 `KD_PASIEN` varchar(20) ,
 `UMUR` varchar(20) ,
 `NAMA_PASIEN` varchar(50) ,
 `TGL_PELAYANAN` date ,
 `CUSTOMER` varchar(20) ,
 `ALAMAT` varchar(200) ,
 `TANGGAL` date ,
 `APT_UNIT` varchar(20) 
)*/;

/*Table structure for table `vw_lst_antrian` */

DROP TABLE IF EXISTS `vw_lst_antrian`;

/*!50001 DROP VIEW IF EXISTS `vw_lst_antrian` */;
/*!50001 DROP TABLE IF EXISTS `vw_lst_antrian` */;

/*!50001 CREATE TABLE  `vw_lst_antrian`(
 `KD_KUNJUNGAN` varchar(30) ,
 `MYKD_KUNJUNGAN` varchar(30) ,
 `MYKD_KUNJUNGAN_APT` varchar(30) ,
 `KD_PASIEN` varchar(20) ,
 `SHORT_KD_PASIEN` varchar(7) ,
 `NAMA_PASIEN` varchar(50) ,
 `KD_JENIS_KELAMIN` varchar(4) ,
 `TGL_LAHIR` date ,
 `UMUR` varchar(20) ,
 `NAMA_UNIT` varchar(50) ,
 `TGL_MASUK` date ,
 `URUT_MASUK` int(11) ,
 `JAM_MASUK` varchar(20) ,
 `TGL_KELUAR` date ,
 `JAM_KELUAR` varchar(20) ,
 `STATUS` varchar(14) ,
 `STATUS_APT` varchar(14) ,
 `KD_STATUS` smallint(1) ,
 `KD_UNIT` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `PARENT` varchar(20) ,
 `KD_PUSKESMAS` varchar(20) ,
 `ALAMAT` varchar(200) ,
 `KK` varchar(255) ,
 `KD_DOKTER` varchar(20) ,
 `KD_UNIT_LAYANAN` varchar(20) ,
 `IS_DELETE` bit(1) 
)*/;

/*Table structure for table `vw_lst_kasir` */

DROP TABLE IF EXISTS `vw_lst_kasir`;

/*!50001 DROP VIEW IF EXISTS `vw_lst_kasir` */;
/*!50001 DROP TABLE IF EXISTS `vw_lst_kasir` */;

/*!50001 CREATE TABLE  `vw_lst_kasir`(
 `KD_PEL_KASIR` varchar(16) ,
 `KD_PASIEN` varchar(20) ,
 `KD_TARIF` varchar(5) ,
 `KD_UNIT` varchar(10) ,
 `JUMLAH_BIAYA` decimal(65,0) ,
 `STATUS` varchar(6) ,
 `STATUS_TX` smallint(1) ,
 `NAMA_LENGKAP` varchar(50) ,
 `NO_PENGENAL` varchar(20) ,
 `TEMPAT_LAHIR` varchar(50) ,
 `TGL_LAHIR` date ,
 `KD_PUSKESMAS` varchar(20) 
)*/;

/*Table structure for table `vw_lst_kasir_bayar` */

DROP TABLE IF EXISTS `vw_lst_kasir_bayar`;

/*!50001 DROP VIEW IF EXISTS `vw_lst_kasir_bayar` */;
/*!50001 DROP TABLE IF EXISTS `vw_lst_kasir_bayar` */;

/*!50001 CREATE TABLE  `vw_lst_kasir_bayar`(
 `KD_PEL_KASIR` varchar(16) ,
 `KD_TARIF` varchar(5) ,
 `KD_UNIT` varchar(10) ,
 `STATUS_TX` smallint(1) ,
 `KD_USER` varchar(20) ,
 `KD_BAYAR` varchar(20) ,
 `JUMLAH_BAYAR` double(10,0) ,
 `TGL_BAYAR` datetime ,
 `JUMLAH_DISC` double(10,0) ,
 `JUMLAH_PPN` char(5) ,
 `JUMLAH_TTL` double(10,0) ,
 `CARA_BAYAR` varchar(255) ,
 `KD_PUSKESMAS` varchar(20) 
)*/;

/*Table structure for table `vw_lst_laboratorium` */

DROP TABLE IF EXISTS `vw_lst_laboratorium`;

/*!50001 DROP VIEW IF EXISTS `vw_lst_laboratorium` */;
/*!50001 DROP TABLE IF EXISTS `vw_lst_laboratorium` */;

/*!50001 CREATE TABLE  `vw_lst_laboratorium`(
 `KD_PRODUK` int(20) ,
 `KD_GOL_PRODUK` varchar(20) ,
 `PRODUK` varchar(255) ,
 `SINGKATAN` varchar(255) ,
 `KD_UNIT` varchar(20) ,
 `HARGA_PRODUK` double ,
 `KD_TARIF` char(0) 
)*/;

/*Table structure for table `vw_lst_obat` */

DROP TABLE IF EXISTS `vw_lst_obat`;

/*!50001 DROP VIEW IF EXISTS `vw_lst_obat` */;
/*!50001 DROP TABLE IF EXISTS `vw_lst_obat` */;

/*!50001 CREATE TABLE  `vw_lst_obat`(
 `KD_PKM` varchar(20) ,
 `KD_UNIT_APT` varchar(55) ,
 `KD_OBAT` int(11) ,
 `NAMA_OBAT` varchar(100) ,
 `KD_GOL_OBAT` varchar(20) ,
 `KD_SAT_KECIL` varchar(20) ,
 `KD_SAT_BESAR` varchar(20) ,
 `KD_MILIK_OBAT` varchar(55) ,
 `JUMLAH_STOK_OBAT` decimal(42,0) ,
 `NAMA_UNIT` varchar(255) ,
 `KD_OBAT_VAL` varchar(50) ,
 `GENERIK` smallint(1) ,
 `FRACTION` double ,
 `SINGKATAN` varchar(20) ,
 `KD_TERAPI_OBAT` varchar(20) 
)*/;

/*Table structure for table `vw_mr_kunjungan` */

DROP TABLE IF EXISTS `vw_mr_kunjungan`;

/*!50001 DROP VIEW IF EXISTS `vw_mr_kunjungan` */;
/*!50001 DROP TABLE IF EXISTS `vw_mr_kunjungan` */;

/*!50001 CREATE TABLE  `vw_mr_kunjungan`(
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `TANGGAL` varchar(10) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `NAMA` varchar(50) ,
 `KD_KUNJUNGAN` varchar(30) ,
 `ANAMNESA` text ,
 `JENIS_KASUS` varchar(10) ,
 `TINDAKAN` text ,
 `CATATAN_DOKTER` text ,
 `KD_PENYAKIT` text ,
 `PENYAKIT` text ,
 `CATATAN_FISIK` text ,
 `KD_OBAT` text ,
 `NAMA_OBAT` text ,
 `NAMA_UNIT` text ,
 `KD_DOKTER` text 
)*/;

/*Table structure for table `vw_mr_kunjungan_kia` */

DROP TABLE IF EXISTS `vw_mr_kunjungan_kia`;

/*!50001 DROP VIEW IF EXISTS `vw_mr_kunjungan_kia` */;
/*!50001 DROP TABLE IF EXISTS `vw_mr_kunjungan_kia` */;

/*!50001 CREATE TABLE  `vw_mr_kunjungan_kia`(
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `TANGGAL` varchar(10) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `NAMA` varchar(50) ,
 `KD_KUNJUNGAN` varchar(30) ,
 `ANAMNESA` text ,
 `JENIS_KASUS` varchar(10) ,
 `TINDAKAN` text ,
 `CATATAN_DOKTER` text ,
 `CATATAN_FISIK` text ,
 `KD_OBAT` text ,
 `NAMA_OBAT` text ,
 `NAMA_UNIT` text ,
 `KD_DOKTER` text 
)*/;

/*Table structure for table `vw_mr_kunjungan_kia1` */

DROP TABLE IF EXISTS `vw_mr_kunjungan_kia1`;

/*!50001 DROP VIEW IF EXISTS `vw_mr_kunjungan_kia1` */;
/*!50001 DROP TABLE IF EXISTS `vw_mr_kunjungan_kia1` */;

/*!50001 CREATE TABLE  `vw_mr_kunjungan_kia1`(
 `KD_PUSKESMAS` varchar(20) ,
 `TANGGAL` varchar(10) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `NAMA` varchar(50) ,
 `KD_KUNJUNGAN` varchar(30) ,
 `ANAMNESA` text ,
 `JENIS_KASUS` varchar(10) ,
 `TINDAKAN` varchar(341) ,
 `CATATAN_DOKTER` text ,
 `CATATAN_FISIK` text ,
 `KD_OBAT` text ,
 `NAMA_OBAT` text ,
 `NAMA_UNIT` text ,
 `KD_DOKTER` text 
)*/;

/*Table structure for table `vw_mr_kunjungan_kia2` */

DROP TABLE IF EXISTS `vw_mr_kunjungan_kia2`;

/*!50001 DROP VIEW IF EXISTS `vw_mr_kunjungan_kia2` */;
/*!50001 DROP TABLE IF EXISTS `vw_mr_kunjungan_kia2` */;

/*!50001 CREATE TABLE  `vw_mr_kunjungan_kia2`(
 `KD_PUSKESMAS` varchar(20) ,
 `TANGGAL` varchar(10) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `NAMA` varchar(50) ,
 `KD_KUNJUNGAN` varchar(30) ,
 `ANAMNESA` text ,
 `JENIS_KASUS` varchar(10) ,
 `TINDAKAN` text ,
 `CATATAN_DOKTER` text ,
 `CATATAN_FISIK` text ,
 `KD_OBAT` text ,
 `NAMA_OBAT` text ,
 `NAMA_UNIT` text ,
 `KD_DOKTER` text 
)*/;

/*Table structure for table `vw_mr_kunjungan_kia3` */

DROP TABLE IF EXISTS `vw_mr_kunjungan_kia3`;

/*!50001 DROP VIEW IF EXISTS `vw_mr_kunjungan_kia3` */;
/*!50001 DROP TABLE IF EXISTS `vw_mr_kunjungan_kia3` */;

/*!50001 CREATE TABLE  `vw_mr_kunjungan_kia3`(
 `KD_PUSKESMAS` varchar(20) ,
 `TANGGAL` varchar(10) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `NAMA` varchar(50) ,
 `KD_KUNJUNGAN` varchar(30) ,
 `ANAMNESA` text ,
 `JENIS_KASUS` varchar(10) ,
 `PENYAKIT` text ,
 `TINDAKAN` text ,
 `CATATAN_DOKTER` text ,
 `CATATAN_FISIK` text ,
 `KD_OBAT` text ,
 `NAMA_OBAT` text ,
 `NAMA_UNIT` text ,
 `KD_DOKTER` text 
)*/;

/*Table structure for table `vw_pasien` */

DROP TABLE IF EXISTS `vw_pasien`;

/*!50001 DROP VIEW IF EXISTS `vw_pasien` */;
/*!50001 DROP TABLE IF EXISTS `vw_pasien` */;

/*!50001 CREATE TABLE  `vw_pasien`(
 `KD_PASIEN` varchar(20) ,
 `SHORT_KD_PASIEN` varchar(7) ,
 `NAMA_LENGKAP` varchar(50) ,
 `NAMA_DEPAN` varchar(50) ,
 `NAMA_TENGAH` varchar(50) ,
 `NAMA_BELAKANG` varchar(50) ,
 `KK` varchar(255) ,
 `NO_KK` varchar(20) ,
 `TEMPAT_LAHIR` varchar(50) ,
 `TGL_LAHIR` date ,
 `UMUR` varchar(20) ,
 `ALAMAT` varchar(200) ,
 `KD_PUSKESMAS` varchar(20) ,
 `NO_PENGENAL` varchar(20) ,
 `JENIS_KELAMIN` varchar(4) ,
 `KD_GOL_DARAH` varchar(5) ,
 `KET_WIL` varchar(20) ,
 `KD_TARIF` char(0) ,
 `KD_CARA_BAYAR` varchar(20) ,
 `CARA_BAYAR` varchar(20) ,
 `KD_CUSTOMER` varchar(20) ,
 `CUSTOMER` varchar(20) ,
 `FLAG_L` smallint(1) ,
 `JENIS_DATA` char(1) ,
 `JNS_PASIEN` varchar(20) 
)*/;

/*Table structure for table `vw_pasien_kipi` */

DROP TABLE IF EXISTS `vw_pasien_kipi`;

/*!50001 DROP VIEW IF EXISTS `vw_pasien_kipi` */;
/*!50001 DROP TABLE IF EXISTS `vw_pasien_kipi` */;

/*!50001 CREATE TABLE  `vw_pasien_kipi`(
 `KD_PASIEN` varchar(20) ,
 `KD_PUSKESMAS` varchar(20) ,
 `KD_KECAMATAN` varchar(20) ,
 `NAMA_LENGKAP` varchar(50) ,
 `TGL_LAHIR` varchar(10) ,
 `KD_JENIS_KELAMIN` varchar(4) ,
 `ALAMAT` varchar(200) ,
 `STATUS_MARITAL` varchar(100) ,
 `NAMA_IBU` varchar(20) ,
 `NAMA_SUAMI` varchar(20) ,
 `id` varchar(20) ,
 `id2` varchar(20) 
)*/;

/*Table structure for table `vw_registrasi_kia` */

DROP TABLE IF EXISTS `vw_registrasi_kia`;

/*!50001 DROP VIEW IF EXISTS `vw_registrasi_kia` */;
/*!50001 DROP TABLE IF EXISTS `vw_registrasi_kia` */;

/*!50001 CREATE TABLE  `vw_registrasi_kia`(
 `KD_KIA` int(20) ,
 `KD_PASIEN` varchar(20) ,
 `TGL_PENDAFTARAN` date ,
 `NAMA_LENGKAP` varchar(50) ,
 `KD_PUSKESMAS` varchar(20) ,
 `KATEGORI_KIA` varchar(20) ,
 `KUNJUNGAN_KIA` varchar(20) ,
 `KD_KUNJUNGAN_KIA` varchar(20) ,
 `JENIS_KELAMIN` varchar(15) 
)*/;

/*Table structure for table `vw_resep_obat` */

DROP TABLE IF EXISTS `vw_resep_obat`;

/*!50001 DROP VIEW IF EXISTS `vw_resep_obat` */;
/*!50001 DROP TABLE IF EXISTS `vw_resep_obat` */;

/*!50001 CREATE TABLE  `vw_resep_obat`(
 `KD_KUNJUNGAN` varchar(30) ,
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `KD_OBAT` varchar(20) ,
 `NAMA_OBAT` varchar(100) ,
 `SAT_BESAR` varchar(20) ,
 `SAT_KECIL` varchar(20) ,
 `DOSIS` varchar(50) ,
 `JUMLAH` double(10,0) ,
 `HARGA_JUAL` decimal(30,0) 
)*/;

/*Table structure for table `vw_rpt_kunjungan` */

DROP TABLE IF EXISTS `vw_rpt_kunjungan`;

/*!50001 DROP VIEW IF EXISTS `vw_rpt_kunjungan` */;
/*!50001 DROP TABLE IF EXISTS `vw_rpt_kunjungan` */;

/*!50001 CREATE TABLE  `vw_rpt_kunjungan`(
 `KD_KUNJUNGAN` varchar(30) ,
 `KD_PASIEN` varchar(20) ,
 `KODE` varchar(7) ,
 `KD_UNIT_LAYANAN` varchar(20) ,
 `KD_UNIT` varchar(20) ,
 `TGL_MASUK` date ,
 `URUT_MASUK` int(11) ,
 `KD_DOKTER` varchar(20) ,
 `KD_RUJUKAN` varchar(20) ,
 `KD_CUSTOMER` varchar(20) ,
 `JAM_MASUK` varchar(20) ,
 `TGL_KELUAR` date ,
 `JAM_KELUAR` varchar(20) ,
 `KEADAAN_MASUK` varchar(20) ,
 `KEADAAN_PASIEN` varchar(20) ,
 `CARA_PENERIMAAN` varchar(20) ,
 `ASAL_PASIEN` varchar(20) ,
 `CARA_MASUK` varchar(20) ,
 `CARA_KELUAR` varchar(20) ,
 `JENIS_PASIEN` varchar(20) ,
 `CARA_BAYAR` varchar(20) ,
 `KETERANGAN_WILAYAH` varchar(20) ,
 `ASURANSI` varchar(20) ,
 `NO_ASURANSI` varchar(50) ,
 `BARU` varchar(20) ,
 `SHIFT` varchar(20) ,
 `KARYAWAN` varchar(20) ,
 `KONTROL` varchar(20) ,
 `STATUS` varchar(5) ,
 `KD_PELAYANAN` varchar(20) ,
 `ANAMNESA` varchar(255) ,
 `NAMA_UNIT` varchar(50) ,
 `UNIT` varchar(50) ,
 `NAMA` varchar(152) ,
 `KD_PUSKESMAS` varchar(20) ,
 `NAMA_PUSKESMAS` varchar(255) ,
 `TGL_LAHIR` date ,
 `UMUR` varchar(20) ,
 `JENIS_KELAMIN` varchar(4) ,
 `KET_WIL` varchar(20) ,
 `KK` varchar(255) ,
 `ALAMAT` varchar(200) 
)*/;

/*Table structure for table `vw_rpt_lab` */

DROP TABLE IF EXISTS `vw_rpt_lab`;

/*!50001 DROP VIEW IF EXISTS `vw_rpt_lab` */;
/*!50001 DROP TABLE IF EXISTS `vw_rpt_lab` */;

/*!50001 CREATE TABLE  `vw_rpt_lab`(
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PENYAKIT` varchar(20) ,
 `JNS_KASUS` varchar(10) ,
 `JNS_DX` varchar(20) ,
 `TGL_PELAYANAN` date ,
 `KD_UNIT` varchar(20) ,
 `NM_UNIT` varchar(50) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `CARA_BAYAR` varchar(20) ,
 `KETERANGAN_WILAYAH` varchar(20) ,
 `JENIS_PASIEN` varchar(20) ,
 `TGL_LAHIR` date ,
 `UMURINDAYS` smallint(6) ,
 `KD_PELAYANAN_LAB` varchar(20) ,
 `KD_LAB` varchar(20) ,
 `PRODUK_LAB` varchar(255) ,
 `SEX` varchar(4) ,
 `NAMA_PUSKESMAS` varchar(255) 
)*/;

/*Table structure for table `vw_rpt_obat` */

DROP TABLE IF EXISTS `vw_rpt_obat`;

/*!50001 DROP VIEW IF EXISTS `vw_rpt_obat` */;
/*!50001 DROP TABLE IF EXISTS `vw_rpt_obat` */;

/*!50001 CREATE TABLE  `vw_rpt_obat`(
 `KD_PELAYANAN` varchar(20) ,
 `KD_PUSKESMAS` varchar(20) ,
 `KD_OBAT` varchar(20) ,
 `NO_RESEP` varchar(20) ,
 `NAMA_OBAT` varchar(100) ,
 `QTY` double(10,0) ,
 `STATUS` varchar(1) ,
 `TGL_PELAYANAN` date ,
 `KD_UNIT` varchar(20) ,
 `KD_MILIK_OBAT` varchar(20) 
)*/;

/*Table structure for table `vw_rpt_penyakitpasien` */

DROP TABLE IF EXISTS `vw_rpt_penyakitpasien`;

/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasien` */;
/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasien` */;

/*!50001 CREATE TABLE  `vw_rpt_penyakitpasien`(
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PENYAKIT` varchar(20) ,
 `JNS_KASUS` varchar(10) ,
 `JNS_DX` varchar(20) ,
 `TGL_PELAYANAN` date ,
 `KD_UNIT` varchar(20) ,
 `KD_TINDAKAN` varchar(20) ,
 `TINDAKAN` varchar(255) ,
 `NM_UNIT` varchar(50) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `CARA_BAYAR` varchar(20) ,
 `KETERANGAN_WILAYAH` varchar(20) ,
 `JENIS_PASIEN` varchar(20) ,
 `TGL_LAHIR` date ,
 `UMURINDAYS` smallint(6) ,
 `SEX` varchar(4) ,
 `NAMA_PUSKESMAS` varchar(255) 
)*/;

/*Table structure for table `vw_rpt_penyakitpasien2` */

DROP TABLE IF EXISTS `vw_rpt_penyakitpasien2`;

/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasien2` */;
/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasien2` */;

/*!50001 CREATE TABLE  `vw_rpt_penyakitpasien2`(
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PENYAKIT` varchar(20) ,
 `JNS_KASUS` varchar(10) ,
 `JNS_DX` varchar(20) ,
 `TGL_PELAYANAN` date ,
 `KD_UNIT` varchar(20) ,
 `KD_TINDAKAN` varchar(20) ,
 `TINDAKAN` varchar(255) ,
 `NM_UNIT` varchar(50) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `CARA_BAYAR` varchar(20) ,
 `KETERANGAN_WILAYAH` varchar(20) ,
 `JENIS_PASIEN` varchar(20) ,
 `TGL_LAHIR` date ,
 `UMURINDAYS` smallint(6) ,
 `SEX` varchar(4) ,
 `NAMA_PUSKESMAS` varchar(255) 
)*/;

/*Table structure for table `vw_rpt_penyakitpasien_grp` */

DROP TABLE IF EXISTS `vw_rpt_penyakitpasien_grp`;

/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasien_grp` */;
/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasien_grp` */;

/*!50001 CREATE TABLE  `vw_rpt_penyakitpasien_grp`(
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PENYAKIT` varchar(20) ,
 `JNS_KASUS` varchar(10) ,
 `JNS_DX` varchar(20) ,
 `TGL_PELAYANAN` date ,
 `KD_UNIT` varchar(20) ,
 `KD_TINDAKAN` varchar(20) ,
 `TINDAKAN` varchar(255) ,
 `NM_UNIT` varchar(50) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `CARA_BAYAR` varchar(20) ,
 `KETERANGAN_WILAYAH` varchar(20) ,
 `JENIS_PASIEN` varchar(20) ,
 `TGL_LAHIR` date ,
 `UMURINDAYS` smallint(6) ,
 `SEX` varchar(4) ,
 `NAMA_PUSKESMAS` varchar(255) 
)*/;

/*Table structure for table `vw_rpt_penyakitpasien_grp_old` */

DROP TABLE IF EXISTS `vw_rpt_penyakitpasien_grp_old`;

/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasien_grp_old` */;
/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasien_grp_old` */;

/*!50001 CREATE TABLE  `vw_rpt_penyakitpasien_grp_old`(
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PENYAKIT` varchar(20) ,
 `JNS_KASUS` varchar(10) ,
 `JNS_DX` varchar(20) ,
 `TGL_PELAYANAN` date ,
 `KD_UNIT` varchar(20) ,
 `KD_TINDAKAN` varchar(20) ,
 `NM_UNIT` varchar(50) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `CARA_BAYAR` varchar(20) ,
 `KETERANGAN_WILAYAH` varchar(20) ,
 `JENIS_PASIEN` varchar(20) ,
 `TGL_LAHIR` date ,
 `UMURINDAYS` smallint(6) ,
 `SEX` varchar(4) ,
 `NAMA_PUSKESMAS` varchar(255) 
)*/;

/*Table structure for table `vw_rpt_penyakitpasien_old` */

DROP TABLE IF EXISTS `vw_rpt_penyakitpasien_old`;

/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasien_old` */;
/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasien_old` */;

/*!50001 CREATE TABLE  `vw_rpt_penyakitpasien_old`(
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PENYAKIT` varchar(20) ,
 `JNS_KASUS` varchar(10) ,
 `JNS_DX` varchar(20) ,
 `TGL_PELAYANAN` date ,
 `KD_UNIT` varchar(20) ,
 `KD_TINDAKAN` varchar(20) ,
 `NM_UNIT` varchar(50) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `CARA_BAYAR` varchar(20) ,
 `KETERANGAN_WILAYAH` varchar(20) ,
 `JENIS_PASIEN` varchar(20) ,
 `TGL_LAHIR` date ,
 `UMURINDAYS` smallint(6) ,
 `SEX` varchar(4) ,
 `NAMA_PUSKESMAS` varchar(255) 
)*/;

/*Table structure for table `vw_rpt_penyakitpasienkia_grp_old` */

DROP TABLE IF EXISTS `vw_rpt_penyakitpasienkia_grp_old`;

/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasienkia_grp_old` */;
/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasienkia_grp_old` */;

/*!50001 CREATE TABLE  `vw_rpt_penyakitpasienkia_grp_old`(
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PENYAKIT` binary(0) ,
 `JNS_KASUS` binary(0) ,
 `JNS_DX` binary(0) ,
 `TGL_PELAYANAN` date ,
 `KD_UNIT` varchar(20) ,
 `KD_TINDAKAN` varchar(20) ,
 `NM_UNIT` varchar(50) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `CARA_BAYAR` varchar(20) ,
 `KETERANGAN_WILAYAH` varchar(20) ,
 `JENIS_PASIEN` varchar(20) ,
 `TGL_LAHIR` date ,
 `UMURINDAYS` smallint(6) ,
 `SEX` varchar(4) ,
 `NAMA_PUSKESMAS` varchar(255) 
)*/;

/*Table structure for table `vw_rpt_penyakitpasienkia_old` */

DROP TABLE IF EXISTS `vw_rpt_penyakitpasienkia_old`;

/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasienkia_old` */;
/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasienkia_old` */;

/*!50001 CREATE TABLE  `vw_rpt_penyakitpasienkia_old`(
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PENYAKIT` binary(0) ,
 `JNS_KASUS` binary(0) ,
 `JNS_DX` binary(0) ,
 `TGL_PELAYANAN` date ,
 `KD_UNIT` varchar(20) ,
 `KD_TINDAKAN` varchar(20) ,
 `NM_UNIT` varchar(50) ,
 `UNIT_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `CARA_BAYAR` varchar(20) ,
 `KETERANGAN_WILAYAH` varchar(20) ,
 `JENIS_PASIEN` varchar(20) ,
 `TGL_LAHIR` date ,
 `UMURINDAYS` smallint(6) ,
 `SEX` varchar(4) ,
 `NAMA_PUSKESMAS` varchar(255) 
)*/;

/*Table structure for table `vw_semua_pasien` */

DROP TABLE IF EXISTS `vw_semua_pasien`;

/*!50001 DROP VIEW IF EXISTS `vw_semua_pasien` */;
/*!50001 DROP TABLE IF EXISTS `vw_semua_pasien` */;

/*!50001 CREATE TABLE  `vw_semua_pasien`(
 `KD_PASIEN` varchar(20) ,
 `KD_PUSKESMAS` varchar(20) ,
 `KD_KECAMATAN` varchar(20) ,
 `NAMA_LENGKAP` varchar(50) ,
 `TGL_LAHIR` varchar(10) ,
 `KD_JENIS_KELAMIN` varchar(4) ,
 `ALAMAT` varchar(200) ,
 `STATUS_MARITAL` varchar(100) ,
 `NAMA_IBU` varchar(20) ,
 `NAMA_SUAMI` varchar(20) ,
 `nid` varchar(20) ,
 `nid2` varchar(20) 
)*/;

/*Table structure for table `vw_stok_sarana` */

DROP TABLE IF EXISTS `vw_stok_sarana`;

/*!50001 DROP VIEW IF EXISTS `vw_stok_sarana` */;
/*!50001 DROP TABLE IF EXISTS `vw_stok_sarana` */;

/*!50001 CREATE TABLE  `vw_stok_sarana`(
 `KD_SARANA_POSYANDU` varchar(10) ,
 `TUJUAN_SARANA` varchar(20) ,
 `NAMA_SARANA_POSYANDU` varchar(30) ,
 `STOK_AKHIR` int(10) 
)*/;

/*Table structure for table `vw_stok_sarana_masuk` */

DROP TABLE IF EXISTS `vw_stok_sarana_masuk`;

/*!50001 DROP VIEW IF EXISTS `vw_stok_sarana_masuk` */;
/*!50001 DROP TABLE IF EXISTS `vw_stok_sarana_masuk` */;

/*!50001 CREATE TABLE  `vw_stok_sarana_masuk`(
 `KD_SARANA_POSYANDU` varchar(10) ,
 `NAMA_SARANA_POSYANDU` varchar(30) ,
 `STOK_AKHIR` int(10) 
)*/;

/*Table structure for table `vw_subgrid_imunisasi` */

DROP TABLE IF EXISTS `vw_subgrid_imunisasi`;

/*!50001 DROP VIEW IF EXISTS `vw_subgrid_imunisasi` */;
/*!50001 DROP TABLE IF EXISTS `vw_subgrid_imunisasi` */;

/*!50001 CREATE TABLE  `vw_subgrid_imunisasi`(
 `KD_PASIEN` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `TANGGAL` date ,
 `JENIS_IMUNISASI` varchar(20) ,
 `NAMA_OBAT` varchar(100) ,
 `KATEGORI_IMUNISASI` varchar(20) ,
 `KECAMATAN` varchar(50) ,
 `KELURAHAN` varchar(50) ,
 `DOKTER` varchar(50) ,
 `FLAG` smallint(1) ,
 `ID` int(20) 
)*/;

/*Table structure for table `vw_subgrid_pasien_kipi` */

DROP TABLE IF EXISTS `vw_subgrid_pasien_kipi`;

/*!50001 DROP VIEW IF EXISTS `vw_subgrid_pasien_kipi` */;
/*!50001 DROP TABLE IF EXISTS `vw_subgrid_pasien_kipi` */;

/*!50001 CREATE TABLE  `vw_subgrid_pasien_kipi`(
 `KD_PASIEN` varchar(20) ,
 `TANGGAL_KIPI` date ,
 `JENIS_IMUNISASI` varchar(20) ,
 `NAMA_OBAT` varchar(100) ,
 `KATEGORI_IMUNISASI` varchar(20) ,
 `KD_KECAMATAN` varchar(20) ,
 `KELURAHAN` varchar(50) ,
 `dokter` varchar(50) ,
 `GEJALA_KIPI` text ,
 `KEADAAN_KESEHATAN` varchar(60) ,
 `KD_TRANS_KIPI` int(20) 
)*/;

/*Table structure for table `vw_tindakan` */

DROP TABLE IF EXISTS `vw_tindakan`;

/*!50001 DROP VIEW IF EXISTS `vw_tindakan` */;
/*!50001 DROP TABLE IF EXISTS `vw_tindakan` */;

/*!50001 CREATE TABLE  `vw_tindakan`(
 `KD_KUNJUNGAN` varchar(30) ,
 `KD_PUSKESMAS` varchar(20) ,
 `KD_PELAYANAN` varchar(20) ,
 `KD_PASIEN` varchar(20) ,
 `KD_TINDAKAN` varchar(20) ,
 `PRODUK` varchar(255) ,
 `HRG_TINDAKAN` double ,
 `QTY` int(11) ,
 `KETERANGAN` varchar(200) 
)*/;

/*View structure for view vw_alergi_obat */

/*!50001 DROP TABLE IF EXISTS `vw_alergi_obat` */;
/*!50001 DROP VIEW IF EXISTS `vw_alergi_obat` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_alergi_obat` AS select `a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`a`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`b`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`b`.`KD_PASIEN` AS `KD_PASIEN`,`c`.`KD_OBAT` AS `KD_OBAT`,`d`.`NAMA_OBAT` AS `NAMA_OBAT` from (((`kunjungan` `a` left join `pelayanan` `b` on((`b`.`KD_PASIEN` = `a`.`KD_PASIEN`))) left join `pasien_alergi_obt` `c` on((`c`.`KD_PASIEN` = convert(`a`.`KD_PASIEN` using utf8)))) left join `apt_mst_obat` `d` on((`d`.`KD_OBAT` = `c`.`KD_OBAT`))) group by `a`.`KD_KUNJUNGAN` */;

/*View structure for view vw_banyak_kunjungan_dashboard */

/*!50001 DROP TABLE IF EXISTS `vw_banyak_kunjungan_dashboard` */;
/*!50001 DROP VIEW IF EXISTS `vw_banyak_kunjungan_dashboard` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_banyak_kunjungan_dashboard` AS select `v`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`v`.`TGL_MASUK` AS `TGL_MASUK`,count(`v`.`KD_KUNJUNGAN`) AS `TOTAL` from `vw_rpt_kunjungan` `v` where (ucase(`v`.`KD_UNIT_LAYANAN`) = 'PUSKESMAS') group by `v`.`TGL_MASUK`,`v`.`KD_PUSKESMAS` order by `v`.`TGL_MASUK` desc */;

/*View structure for view vw_belajar */

/*!50001 DROP TABLE IF EXISTS `vw_belajar` */;
/*!50001 DROP VIEW IF EXISTS `vw_belajar` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_belajar` AS select `kunjungan`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`kunjungan_bumil`.`KD_KUNJUNGAN_BUMIL` AS `KD_KUNJUNGAN_BUMIL`,`pasien`.`KD_PASIEN` AS `KD_PASIEN`,`pel_ord_obat`.`KD_OBAT` AS `KD_OBAT`,`pel_diagnosa`.`KD_PENYAKIT` AS `KD_PENYAKIT`,`pel_diagnosa`.`JNS_KASUS` AS `JNS_KASUS`,`pel_tindakan`.`KD_TINDAKAN` AS `KD_TINDAKAN`,`pelayanan`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`trans_kia`.`KD_KIA` AS `KD_KIA` from ((((((((`kunjungan` join `kunjungan_bumil`) join `pasien`) join `pasien_alergi_obt`) join `pel_diagnosa`) join `pel_ord_obat`) join `pel_tindakan`) join `pelayanan`) join `trans_kia`) */;

/*View structure for view vw_detail_bersalin */

/*!50001 DROP TABLE IF EXISTS `vw_detail_bersalin` */;
/*!50001 DROP VIEW IF EXISTS `vw_detail_bersalin` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detail_bersalin` AS select `a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`a`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`c`.`KD_PASIEN` AS `KD_PASIEN`,`b`.`TANGGAL_PERSALINAN` AS `TANGGAL_PERSALINAN`,`b`.`JAM_KELAHIRAN` AS `JAM_KELAHIRAN`,`b`.`KD_KUNJUNGAN_BERSALIN` AS `KD_KUNJUNGAN_BERSALIN`,`b`.`UMUR_KEHAMILAN` AS `UMUR_KEHAMILAN`,`b`.`ANAK_KE` AS `ANAK_KE`,`b`.`BERAT_LAHIR` AS `BERAT_LAHIR`,`b`.`JML_BAYI` AS `JML_BAYI`,`b`.`KET_TAMBAHAN` AS `KET_TAMBAHAN`,`b`.`LINGKAR_KEPALA` AS `LINGKAR_KEPALA`,`b`.`PANJANG_BADAN` AS `PANJANG_BADAN`,`d`.`NAMA` AS `DOKTER_PEMERIKSA`,`e`.`NAMA` AS `DOKTER_PETUGAS`,`f`.`CARA_PERSALINAN` AS `CARA_PERSALINAN`,`f`.`KD_CARA_PERSALINAN` AS `KD_CARA_PERSALINAN`,`g`.`JENIS_KELAHIRAN` AS `JENIS_KELAHIRAN`,`h`.`KEADAAN_KESEHATAN` AS `KEADAAN_KESEHATAN`,`h`.`KD_KEADAAN_KESEHATAN` AS `KD_KEADAAN_KESEHATAN`,`z`.`CATATAN_DOKTER` AS `CATATAN_DOKTER`,`z`.`CATATAN_APOTEK` AS `CATATAN_APOTEK`,group_concat(distinct `i`.`KEADAAN_BAYI_LAHIR` separator ' | ') AS `KEADAAN_BAYI_LAHIR`,group_concat(distinct `j`.`ASUHAN_BAYI_LAHIR` separator ' | ') AS `ASUHAN_BAYI_LAHIR`,`k`.`STATUS_HAMIL` AS `STATUS_HAMIL`,`k`.`KD_STATUS_HAMIL` AS `KD_STATUS_HAMIL`,concat(`l`.`PRODUK`,'-','Qty:',`l`.`QTY`) AS `TINDAKAN`,concat(`m`.`NAMA_OBAT`,'-','Dosis:',`m`.`DOSIS`,'-','Qty:',`m`.`JUMLAH`) AS `RESEP_OBAT`,`n`.`NAMA_OBAT` AS `ALERGI`,`o`.`JENIS_KELAMIN` AS `JENIS_KELAMIN` from (((((((((((((((`trans_kia` `a` left join `kunjungan_bersalin` `b` on((`a`.`KD_KIA` = `b`.`KD_KIA`))) left join `pasien` `c` on((convert(`c`.`KD_PASIEN` using utf8) = `b`.`KD_PASIEN`))) left join `mst_jenis_kelamin` `o` on((`o`.`KD_JENIS_KELAMIN` = convert(`c`.`KD_JENIS_KELAMIN` using utf8)))) left join `mst_dokter` `d` on((`d`.`KD_DOKTER` = `a`.`KD_DOKTER_PEMERIKSA`))) left join `check_coment` `z` on((`z`.`KD_PELAYANAN` = `a`.`KD_PELAYANAN`))) left join `mst_dokter` `e` on((`e`.`KD_DOKTER` = `a`.`KD_DOKTER_PETUGAS`))) left join `mst_cara_persalinan` `f` on((`f`.`KD_CARA_PERSALINAN` = `b`.`KD_CARA_BERSALIN`))) left join `mst_jenis_kelahiran` `g` on((`g`.`KD_JENIS_KELAHIRAN` = `b`.`KD_JENIS_KELAHIRAN`))) left join `mst_keadaan_kesehatan` `h` on((`h`.`KD_KEADAAN_KESEHATAN` = `b`.`KD_KEADAAN_KESEHATAN`))) left join `detail_keadaan_bayi` `i` on((`i`.`KD_KUNJUNGAN_BERSALIN` = `b`.`KD_KUNJUNGAN_BERSALIN`))) left join `detail_asuhan_bayi` `j` on((`j`.`KD_KUNJUNGAN_BERSALIN` = `b`.`KD_KUNJUNGAN_BERSALIN`))) left join `mst_status_hamil` `k` on((`k`.`KD_STATUS_HAMIL` = `b`.`KD_STATUS_HAMIL`))) left join `vw_tindakan` `l` on((convert(`l`.`KD_KUNJUNGAN` using utf8) = `a`.`KD_KUNJUNGAN`))) left join `vw_resep_obat` `m` on((convert(`m`.`KD_KUNJUNGAN` using utf8) = `a`.`KD_KUNJUNGAN`))) left join `vw_alergi_obat` `n` on((convert(`n`.`KD_KUNJUNGAN` using utf8) = `a`.`KD_KUNJUNGAN`))) group by `a`.`KD_KUNJUNGAN` */;

/*View structure for view vw_detail_kunjungan_bersalin */

/*!50001 DROP TABLE IF EXISTS `vw_detail_kunjungan_bersalin` */;
/*!50001 DROP VIEW IF EXISTS `vw_detail_kunjungan_bersalin` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detail_kunjungan_bersalin` AS select `trans_kia`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`pasien`.`KD_PASIEN` AS `KD_PASIEN`,date_format(`kunjungan_bersalin`.`TANGGAL_PERSALINAN`,'%d-%M-%Y') AS `TANGGAL_KUNJUNGAN`,`kunjungan_bersalin`.`JAM_KELAHIRAN` AS `JAM_KELAHIRAN`,`kunjungan_bersalin`.`UMUR_KEHAMILAN` AS `UMUR_KEHAMILAN`,`kunjungan_bersalin`.`JML_BAYI` AS `JML_BAYI`,`kunjungan_bersalin`.`KET_TAMBAHAN` AS `KET_TAMBAHAN`,`mst_dokter`.`NAMA` AS `petugas`,`mst_dokter`.`NAMA` AS `pemeriksa`,`mst_cara_persalinan`.`CARA_PERSALINAN` AS `CARA_PERSALINAN`,`mst_jenis_kelahiran`.`JENIS_KELAHIRAN` AS `JENIS_KELAHIRAN`,`mst_keadaan_kesehatan`.`KEADAAN_KESEHATAN` AS `KEADAAN_KESEHATAN`,`detail_keadaan_bayi`.`KEADAAN_BAYI_LAHIR` AS `KEADAAN_BAYI_LAHIR`,`mst_status_hamil`.`STATUS_HAMIL` AS `STATUS_HAMIL`,`kunjungan_bersalin`.`ANAK_KE` AS `ANAK_KE`,`kunjungan_bersalin`.`LINGKAR_KEPALA` AS `LINGKAR_KEPALA`,`kunjungan_bersalin`.`BERAT_LAHIR` AS `BERAT_LAHIR`,`kunjungan_bersalin`.`PANJANG_BADAN` AS `PANJANG_BADAN`,`mst_jenis_kelamin`.`JENIS_KELAMIN` AS `JENIS_KELAMIN`,`detail_asuhan_bayi`.`ASUHAN_BAYI_LAHIR` AS `ASUHAN_BAYI_LAHIR`,(select group_concat(distinct concat(`mst_produk`.`PRODUK`,'-Rp.',`pel_tindakan`.`HRG_TINDAKAN`,'-Jml:',`pel_tindakan`.`QTY`,'-Ket:',`pel_tindakan`.`KETERANGAN`) separator ' | ') from ((`mst_produk` join `pel_tindakan` on((`mst_produk`.`KD_PRODUK` = `pel_tindakan`.`KD_TINDAKAN`))) join `trans_kia` on((convert(`pel_tindakan`.`KD_PELAYANAN` using utf8) = `trans_kia`.`KD_PELAYANAN`)))) AS `TINDAKAN`,group_concat(distinct `apt_mst_obat`.`NAMA_OBAT` separator ' | ') AS `ALERGI`,(select group_concat(distinct concat(`apt_mst_obat`.`NAMA_OBAT`,'-',`apt_mst_harga_obat`.`HARGA_JUAL`,'-Dosis:',`pel_ord_obat`.`DOSIS`,'-Jlh:',`pel_ord_obat`.`QTY`) separator ' | ') from ((`apt_mst_obat` join `apt_mst_harga_obat` on((`apt_mst_obat`.`KD_OBAT` = `apt_mst_harga_obat`.`KD_OBAT`))) join `pel_ord_obat` on((`apt_mst_obat`.`KD_OBAT` = `pel_ord_obat`.`KD_OBAT`)))) AS `OBAT` from ((((((`pel_ord_obat` left join ((((((((`mst_dokter` left join ((`trans_kia` left join `kunjungan_bersalin` on((`kunjungan_bersalin`.`KD_KIA` = `trans_kia`.`KD_KIA`))) left join `pasien` on((convert(`pasien`.`KD_PASIEN` using utf8) = `kunjungan_bersalin`.`KD_PASIEN`))) on((`trans_kia`.`KD_DOKTER_PEMERIKSA` = `mst_dokter`.`KD_DOKTER`))) left join `mst_cara_persalinan` on((`mst_cara_persalinan`.`KD_CARA_PERSALINAN` = `kunjungan_bersalin`.`KD_CARA_BERSALIN`))) left join `mst_jenis_kelahiran` on((`mst_jenis_kelahiran`.`KD_JENIS_KELAHIRAN` = `kunjungan_bersalin`.`KD_JENIS_KELAHIRAN`))) left join `mst_keadaan_kesehatan` on((`mst_keadaan_kesehatan`.`KD_KEADAAN_KESEHATAN` = `kunjungan_bersalin`.`KD_KEADAAN_KESEHATAN`))) left join `detail_keadaan_bayi` on((`detail_keadaan_bayi`.`KD_KUNJUNGAN_BERSALIN` = `kunjungan_bersalin`.`KD_KUNJUNGAN_BERSALIN`))) left join `mst_status_hamil` on((`mst_status_hamil`.`KD_STATUS_HAMIL` = `kunjungan_bersalin`.`KD_STATUS_HAMIL`))) left join `mst_jenis_kelamin` on((`mst_jenis_kelamin`.`KD_JENIS_KELAMIN` = convert(`pasien`.`KD_JENIS_KELAMIN` using utf8)))) left join `detail_asuhan_bayi` on((`detail_asuhan_bayi`.`KD_KUNJUNGAN_BERSALIN` = `kunjungan_bersalin`.`KD_KUNJUNGAN_BERSALIN`))) on((`trans_kia`.`KD_PELAYANAN` = convert(`pel_ord_obat`.`KD_PELAYANAN` using utf8)))) left join `pasien_alergi_obt` on((`pasien_alergi_obt`.`KD_PASIEN` = convert(`kunjungan_bersalin`.`KD_PASIEN` using utf8)))) left join `apt_mst_obat` on((`apt_mst_obat`.`KD_OBAT` = `pasien_alergi_obt`.`KD_OBAT`))) left join `apt_mst_harga_obat` on((`apt_mst_harga_obat`.`KD_OBAT` = `pasien_alergi_obt`.`KD_OBAT`))) left join `pel_tindakan` on((`pel_tindakan`.`KD_TINDAKAN` = `kunjungan_bersalin`.`KD_TINDAKAN`))) left join `mst_produk` on((`mst_produk`.`KD_PRODUK` = `pel_tindakan`.`KD_TINDAKAN`))) */;

/*View structure for view vw_detail_pasien_imunisasi */

/*!50001 DROP TABLE IF EXISTS `vw_detail_pasien_imunisasi` */;
/*!50001 DROP VIEW IF EXISTS `vw_detail_pasien_imunisasi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detail_pasien_imunisasi` AS select `a`.`KD_TRANS_IMUNISASI` AS `KD_TRANS_IMUNISASI`,`a`.`KD_PASIEN` AS `KD_PASIEN`,`a`.`TANGGAL` AS `TANGGAL`,`b`.`KATEGORI_IMUNISASI` AS `KATEGORI_IMUNISASI`,`a`.`NAMA_LOKASI` AS `NAMA_LOKASI`,`a`.`ALAMAT` AS `ALAMAT_LOKASI`,`c`.`KELURAHAN` AS `KELURAHAN`,`d`.`KECAMATAN` AS `KECAMATAN`,`e`.`NAMA_LENGKAP` AS `NAMA_LENGKAP`,`e`.`TGL_LAHIR` AS `TGL_LAHIR`,`f`.`JENIS_KELAMIN` AS `JENIS_KELAMIN`,`e`.`ALAMAT` AS `ALAMAT`,`e`.`KD_PROVINSI` AS `KD_PROVINSI`,`e`.`KD_KABKOTA` AS `KD_KABKOTA`,`e`.`KD_KECAMATAN` AS `KD_KECAMATAN`,`e`.`KD_KELURAHAN` AS `KD_KELURAHAN`,`g`.`JENIS_PASIEN` AS `JENIS_PASIEN`,`a`.`KD_JENIS_PASIEN` AS `KD_JENIS_PASIEN`,`a`.`PEMERIKSAAN_FISIK` AS `PEMERIKSAAN_FISIK`,group_concat(distinct `j`.`JENIS_IMUNISASI` separator ' | ') AS `JENIS_IMUNISASI`,group_concat(distinct `m`.`NAMA_OBAT` separator ' | ') AS `VAKSIN`,`k`.`NAMA` AS `NAMA` from ((((((((((((`vw_subgrid_imunisasi` `w` left join `trans_imunisasi` `a` on((`a`.`KD_PASIEN` = convert(`w`.`KD_PASIEN` using utf8)))) left join `mst_kategori_jenis_lokasi_imunisasi` `b` on((`b`.`KD_KATEGORI_IMUNISASI` = `a`.`KD_KATEGORI_IMUNISASI`))) left join `mst_kelurahan` `c` on((`c`.`KD_KELURAHAN` = `a`.`KD_KELURAHAN`))) left join `mst_kecamatan` `d` on((`d`.`KD_KECAMATAN` = `c`.`KD_KECAMATAN`))) left join `pasien` `e` on((convert(`e`.`KD_PASIEN` using utf8) = `a`.`KD_PASIEN`))) join `mst_jenis_kelamin` `f` on((`f`.`KD_JENIS_KELAMIN` = convert(`e`.`KD_JENIS_KELAMIN` using utf8)))) left join `mst_jenis_pasien` `g` on((`g`.`KD_JENIS_PASIEN` = `a`.`KD_JENIS_PASIEN`))) left join `pel_imunisasi` `i` on((`i`.`KD_TRANS_IMUNISASI` = `a`.`KD_TRANS_IMUNISASI`))) left join `mst_jenis_imunisasi` `j` on((`j`.`KD_JENIS_IMUNISASI` = `i`.`KD_JENIS_IMUNISASI`))) left join `pel_petugas` `l` on((`l`.`KD_TRANS_IMUNISASI` = `a`.`KD_TRANS_IMUNISASI`))) left join `mst_dokter` `k` on((`k`.`KD_DOKTER` = `l`.`KD_DOKTER`))) left join `apt_mst_obat` `m` on((`m`.`KD_OBAT` = `i`.`KD_OBAT`))) group by `a`.`KD_TRANS_IMUNISASI` desc */;

/*View structure for view vw_detail_pasien_kipi */

/*!50001 DROP TABLE IF EXISTS `vw_detail_pasien_kipi` */;
/*!50001 DROP VIEW IF EXISTS `vw_detail_pasien_kipi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detail_pasien_kipi` AS select `a`.`KD_TRANS_KIPI` AS `KD_TRANS_KIPI`,`c`.`TANGGAL` AS `tanggal_imunisasi`,`b`.`KD_PASIEN` AS `KD_PASIEN`,`b`.`NAMA_LENGKAP` AS `NAMA_LENGKAP`,`b`.`TGL_LAHIR` AS `TGL_LAHIR`,`e`.`JENIS_KELAMIN` AS `JENIS_KELAMIN`,`b`.`ALAMAT` AS `alamat_pasien`,`b`.`KD_PROVINSI` AS `KD_PROVINSI`,`b`.`KD_KABKOTA` AS `KD_KABKOTA`,`b`.`KD_KECAMATAN` AS `KD_KECAMATAN`,`b`.`KD_KELURAHAN` AS `KD_KELURAHAN`,`a`.`TANGGAL_KIPI` AS `TANGGAL_KIPI`,`f`.`KATEGORI_IMUNISASI` AS `KATEGORI_IMUNISASI`,`a`.`NAMA_LOKASI` AS `NAMA_LOKASI`,`a`.`ALAMAT_KIPI` AS `alamat_kipi`,`i`.`KD_KECAMATAN` AS `kec_kipi`,`a`.`KD_KELURAHAN` AS `kel_kipi`,`j`.`GEJALA_KIPI` AS `GEJALA_KIPI`,`m`.`KEADAAN_KESEHATAN` AS `KEADAAN_KESEHATAN`,`l`.`NAMA` AS `dokter` from (((((((((((`trans_kipi` `a` left join `trans_imunisasi` `c` on((`c`.`KD_TRANS_IMUNISASI` = `a`.`KD_TRANS_IMUNISASI`))) left join `pasien` `b` on((convert(`b`.`KD_PASIEN` using utf8) = `c`.`KD_PASIEN`))) left join `pel_gejala_kipi` `d` on((`d`.`KD_TRANS_KIPI` = `a`.`KD_TRANS_KIPI`))) left join `mst_jenis_kelamin` `e` on((`e`.`KD_JENIS_KELAMIN` = convert(`b`.`KD_JENIS_KELAMIN` using utf8)))) left join `mst_kategori_jenis_lokasi_imunisasi` `f` on((`f`.`KD_KATEGORI_IMUNISASI` = `a`.`KD_KATEGORI_IMUNISASI`))) left join `mst_kecamatan` `g` on((convert(`g`.`KD_KECAMATAN` using utf8) = `a`.`KD_KECAMATAN`))) left join `mst_kelurahan` `i` on((convert(`i`.`KD_KELURAHAN` using utf8) = `a`.`KD_KELURAHAN`))) left join `pel_gejala_kipi` `j` on((`j`.`KD_TRANS_KIPI` = `a`.`KD_TRANS_KIPI`))) left join `pel_petugas` `k` on((`k`.`KD_TRANS_KIPI` = `a`.`KD_TRANS_KIPI`))) left join `mst_dokter` `l` on((`l`.`KD_DOKTER` = `k`.`KD_DOKTER`))) left join `mst_keadaan_kesehatan` `m` on((`m`.`KD_KEADAAN_KESEHATAN` = `a`.`KONDISI_AKHIR`))) */;

/*View structure for view vw_detail_pemeriksaan_neonatus */

/*!50001 DROP TABLE IF EXISTS `vw_detail_pemeriksaan_neonatus` */;
/*!50001 DROP VIEW IF EXISTS `vw_detail_pemeriksaan_neonatus` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detail_pemeriksaan_neonatus` AS select `pa`.`KD_PASIEN` AS `KD_PASIEN`,`pa`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`k`.`KD_KIA` AS `KD_KIA`,`k`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`u`.`KD_PEMERIKSAAN_NEONATUS` AS `id`,`u`.`KD_PEMERIKSAAN_NEONATUS` AS `KD_PEMERIKSAAN_NEONATUS`,date_format(`u`.`TANGGAL_KUNJUNGAN`,'%d-%m-%Y') AS `TANGGAL_KUNJUNGAN`,`u`.`KUNJUNGAN_KE` AS `KUNJUNGAN_KE`,`u`.`BERAT_BADAN` AS `BERAT_BADAN`,`u`.`PANJANG_BADAN` AS `PANJANG_BADAN`,`a`.`HRG_TINDAKAN_ANAK` AS `HRG_TINDAKAN_ANAK`,group_concat(distinct `a`.`TINDAKAN_ANAK` separator ' | ') AS `TINDAKAN_ANAK`,group_concat(distinct `a`.`KET_TINDAKAN_ANAK` separator ' | ') AS `KET_TINDAKAN_ANAK`,`u`.`KELUHAN` AS `KELUHAN`,group_concat(distinct `m`.`NAMA_OBAT` separator ' | ') AS `ALERGI`,group_concat(distinct `n`.`NAMA_OBAT` separator ' | ') AS `OBAT`,group_concat(distinct `i`.`TINDAKAN_IBU` separator ' | ') AS `TINDAKAN_IBU`,concat(`d`.`NAMA`,'::',`d`.`JABATAN`) AS `dokter_pemeriksa`,concat(`e`.`NAMA`,'::',`e`.`JABATAN`) AS `dokter_petugas`,`u`.`KD_PEMERIKSAAN_NEONATUS` AS `kode` from (((((((((`trans_kia` `k` left join `pelayanan` `pa` on((`k`.`KD_PELAYANAN` = convert(`pa`.`KD_PELAYANAN` using utf8)))) left join `pemeriksaan_neonatus` `u` on((`u`.`KD_KIA` = `k`.`KD_KIA`))) left join `pel_ord_obat` `p` on((`k`.`KD_PELAYANAN` = convert(`p`.`KD_PELAYANAN` using utf8)))) left join `apt_mst_obat` `m` on((`p`.`KD_OBAT` = `m`.`KD_OBAT`))) left join `apt_mst_obat` `n` on((`p`.`KD_OBAT` = `n`.`KD_OBAT`))) left join `mst_dokter` `d` on((`d`.`KD_DOKTER` = `k`.`KD_DOKTER_PEMERIKSA`))) left join `mst_dokter` `e` on((`e`.`KD_DOKTER` = `k`.`KD_DOKTER_PETUGAS`))) left join `detail_tindakan_anak_pem_neo` `a` on((`a`.`KD_PEMERIKSAAN_NEONATUS` = `u`.`KD_PEMERIKSAAN_NEONATUS`))) left join `detail_tindakan_ibu_pem_neo` `i` on((`i`.`KD_PEMERIKSAAN_NEONATUS` = `u`.`KD_PEMERIKSAAN_NEONATUS`))) */;

/*View structure for view vw_detail_pemkes_anak */

/*!50001 DROP TABLE IF EXISTS `vw_detail_pemkes_anak` */;
/*!50001 DROP VIEW IF EXISTS `vw_detail_pemkes_anak` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detail_pemkes_anak` AS select `b`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`a`.`TANGGAL_KUNJUNGAN` AS `TANGGAL_KUNJUNGAN`,concat(`c`.`PRODUK`,'-','Qty:',`c`.`QTY`) AS `TINDAKAN`,`d`.`NAMA_OBAT` AS `ALERGI`,concat(`e`.`NAMA_OBAT`,'-','Dosis:',`e`.`DOSIS`,'-','Qty:',`e`.`JUMLAH`) AS `RESEP_OBAT`,`f`.`NAMA` AS `dokter_pemeriksa`,`g`.`NAMA` AS `dokter_petugas`,`h`.`PENYAKIT` AS `PENYAKIT` from (((((((`trans_kia` `b` left join `pemeriksaan_anak` `a` on((`b`.`KD_KIA` = `a`.`KD_KIA`))) left join `vw_tindakan` `c` on((convert(`c`.`KD_KUNJUNGAN` using utf8) = `b`.`KD_KUNJUNGAN`))) left join `vw_alergi_obat` `d` on((convert(`d`.`KD_KUNJUNGAN` using utf8) = `b`.`KD_KUNJUNGAN`))) left join `vw_resep_obat` `e` on((convert(`e`.`KD_KUNJUNGAN` using utf8) = `b`.`KD_KUNJUNGAN`))) left join `mst_dokter` `f` on((`f`.`KD_DOKTER` = `b`.`KD_DOKTER_PEMERIKSA`))) left join `mst_dokter` `g` on((`f`.`KD_DOKTER` = `b`.`KD_DOKTER_PETUGAS`))) left join `vw_diagnosa` `h` on((convert(`h`.`KD_KUNJUNGAN` using utf8) = `b`.`KD_KUNJUNGAN`))) */;

/*View structure for view vw_detail_rawat_inap */

/*!50001 DROP TABLE IF EXISTS `vw_detail_rawat_inap` */;
/*!50001 DROP VIEW IF EXISTS `vw_detail_rawat_inap` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detail_rawat_inap` AS select `a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`b`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`b`.`KD_PASIEN` AS `KD_PASIEN`,`b`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`b`.`JENIS_PASIEN` AS `KD_JENIS_PASIEN`,`d`.`CUSTOMER` AS `CUSTOMER`,`a`.`KD_UNIT` AS `KD_UNIT`,`c`.`UNIT` AS `UNIT`,`b`.`CARA_BAYAR` AS `KD_CARA_BAYAR`,`e`.`CARA_BAYAR` AS `CARA_BAYAR`,`b`.`ANAMNESA` AS `ANAMNESA`,`b`.`CATATAN_FISIK` AS `CATATAN_FISIK`,`b`.`CATATAN_DOKTER` AS `CATATAN_DOKTER`,`b`.`KEADAAN_KELUAR` AS `KEADAAN_KELUAR` from ((((`kunjungan` `a` left join `pelayanan` `b` on((`b`.`KD_PELAYANAN` = `a`.`KD_PELAYANAN`))) left join `mst_unit` `c` on((`c`.`KD_UNIT` = `a`.`KD_UNIT`))) left join `mst_kel_pasien` `d` on((`d`.`KD_CUSTOMER` = `b`.`JENIS_PASIEN`))) left join `mst_cara_bayar` `e` on((`e`.`KD_BAYAR` = `b`.`CARA_BAYAR`))) */;

/*View structure for view vw_detail_rawat_jalan */

/*!50001 DROP TABLE IF EXISTS `vw_detail_rawat_jalan` */;
/*!50001 DROP VIEW IF EXISTS `vw_detail_rawat_jalan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detail_rawat_jalan` AS select `a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`b`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`b`.`KD_PASIEN` AS `KD_PASIEN`,`b`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`b`.`JENIS_PASIEN` AS `KD_JENIS_PASIEN`,`d`.`CUSTOMER` AS `CUSTOMER`,`a`.`KD_UNIT` AS `KD_UNIT`,`c`.`UNIT` AS `UNIT`,`b`.`CARA_BAYAR` AS `KD_CARA_BAYAR`,`e`.`CARA_BAYAR` AS `CARA_BAYAR`,`b`.`ANAMNESA` AS `ANAMNESA`,`b`.`CATATAN_FISIK` AS `CATATAN_FISIK`,`b`.`CATATAN_DOKTER` AS `CATATAN_DOKTER`,`b`.`KEADAAN_KELUAR` AS `KEADAAN_KELUAR` from ((((`kunjungan` `a` left join `pelayanan` `b` on((`b`.`KD_PELAYANAN` = `a`.`KD_PELAYANAN`))) left join `mst_unit` `c` on((`c`.`KD_UNIT` = `a`.`KD_UNIT`))) left join `mst_kel_pasien` `d` on((`d`.`KD_CUSTOMER` = `b`.`JENIS_PASIEN`))) left join `mst_cara_bayar` `e` on((`e`.`KD_BAYAR` = `b`.`CARA_BAYAR`))) */;

/*View structure for view vw_detail_tindakan */

/*!50001 DROP TABLE IF EXISTS `vw_detail_tindakan` */;
/*!50001 DROP VIEW IF EXISTS `vw_detail_tindakan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_detail_tindakan` AS select `c`.`KD_KIA` AS `KD_KIA`,`c`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,concat(`a`.`PRODUK`,'-Rp.',`b`.`HRG_TINDAKAN`,'-Jml:',`b`.`QTY`,'-Ket:',`b`.`KETERANGAN`) AS `TINDAKAN` from (((`trans_kia` `c` left join `pelayanan` `d` on((convert(`d`.`KD_PELAYANAN` using utf8) = `c`.`KD_PELAYANAN`))) left join `pel_tindakan` `b` on((`b`.`KD_PELAYANAN` = `d`.`KD_PELAYANAN`))) left join `mst_produk` `a` on((`a`.`KD_PRODUK` = `b`.`KD_TINDAKAN`))) */;

/*View structure for view vw_diagnosa */

/*!50001 DROP TABLE IF EXISTS `vw_diagnosa` */;
/*!50001 DROP VIEW IF EXISTS `vw_diagnosa` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_diagnosa` AS select `a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`a`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`b`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`b`.`KD_PASIEN` AS `KD_PASIEN`,`c`.`KD_PENYAKIT` AS `KD_PENYAKIT`,`d`.`PENYAKIT` AS `PENYAKIT`,`c`.`JNS_KASUS` AS `JNS_KASUS`,`c`.`JNS_DX` AS `JNS_DX` from (((`kunjungan` `a` left join `pelayanan` `b` on((`b`.`KD_PASIEN` = `a`.`KD_PASIEN`))) left join `pel_diagnosa` `c` on((`c`.`KD_PELAYANAN` = `b`.`KD_PELAYANAN`))) left join `mst_icd` `d` on((convert(`d`.`KD_PENYAKIT` using utf8) = convert(`c`.`KD_PENYAKIT` using utf8)))) group by `a`.`KD_KUNJUNGAN` */;

/*View structure for view vw_imunisasi */

/*!50001 DROP TABLE IF EXISTS `vw_imunisasi` */;
/*!50001 DROP VIEW IF EXISTS `vw_imunisasi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_imunisasi` AS select `a`.`KD_PASIEN` AS `KD_PASIEN`,`a`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`a`.`KD_KECAMATAN` AS `KD_KECAMATAN`,`a`.`NAMA_LENGKAP` AS `NAMA_LENGKAP`,date_format(`a`.`TGL_LAHIR`,'%d-%m-%Y') AS `TGL_LAHIR`,`a`.`KD_JENIS_KELAMIN` AS `KD_JENIS_KELAMIN`,`b`.`KD_TRANS_IMUNISASI` AS `KD_TRANS_IMUNISASI`,`a`.`ALAMAT` AS `ALAMAT`,`c`.`STATUS` AS `STATUS_MARITAL`,`b`.`NAMA_IBU` AS `NAMA_IBU`,`b`.`NAMA_SUAMI` AS `NAMA_SUAMI`,`a`.`KD_PASIEN` AS `nid`,`a`.`KD_PASIEN` AS `nid2`,`a`.`FLAG_LUAR_GEDUNG` AS `FLAG_L`,`b`.`KD_TRANS_IMUNISASI` AS `id_trans` from ((`trans_imunisasi` `b` left join `pasien` `a` on((`b`.`KD_PASIEN` = convert(`a`.`KD_PASIEN` using utf8)))) left join `mst_status_marital` `c` on((`c`.`KD_STATUS` = `a`.`STATUS_MARITAL`))) group by `b`.`KD_PASIEN` desc */;

/*View structure for view vw_kasir_detail */

/*!50001 DROP TABLE IF EXISTS `vw_kasir_detail` */;
/*!50001 DROP VIEW IF EXISTS `vw_kasir_detail` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_kasir_detail` AS select `pel_kasir_detail`.`KD_PEL_KASIR` AS `KD_PEL_KASIR`,`pel_kasir_detail`.`KD_TARIF` AS `KD_TARIF`,`pel_kasir_detail`.`REFF` AS `REFF`,`pel_kasir_detail`.`KD_PRODUK` AS `KD_PRODUK`,`pel_kasir_detail`.`KD_UNIT` AS `KD_UNIT`,`pel_kasir_detail`.`HARGA_PRODUK` AS `HARGA_PRODUK`,`pel_kasir_detail`.`TGL_BERLAKU` AS `TGL_BERLAKU`,`pel_kasir_detail`.`QTY` AS `QTY`,`pel_kasir_detail`.`TOTAL_HARGA` AS `TOTAL_HARGA`,`mst_transfer`.`PRODUK_TRANSFER` AS `PRODUK`,`pel_kasir_detail`.`KD_PUSKESMAS` AS `KD_PUSKESMAS` from (`pel_kasir_detail` join `mst_transfer` on((convert(`pel_kasir_detail`.`KD_PRODUK` using utf8) = `mst_transfer`.`KD_TRANSFER`))) union all select `pel_kasir_detail`.`KD_PEL_KASIR` AS `KD_PEL_KASIR`,`pel_kasir_detail`.`KD_TARIF` AS `KD_TARIF`,`pel_kasir_detail`.`REFF` AS `REFF`,`pel_kasir_detail`.`KD_PRODUK` AS `KD_PRODUK`,`pel_kasir_detail`.`KD_UNIT` AS `KD_UNIT`,`pel_kasir_detail`.`HARGA_PRODUK` AS `HARGA_PRODUK`,`pel_kasir_detail`.`TGL_BERLAKU` AS `TGL_BERLAKU`,`pel_kasir_detail`.`QTY` AS `QTY`,`pel_kasir_detail`.`TOTAL_HARGA` AS `TOTAL_HARGA`,`mst_produk`.`PRODUK` AS `PRODUK`,`pel_kasir_detail`.`KD_PUSKESMAS` AS `KD_PUSKESMAS` from (`mst_produk` join `pel_kasir_detail` on((`mst_produk`.`KD_PRODUK` = `pel_kasir_detail`.`KD_PRODUK`))) */;

/*View structure for view vw_kunjungan_bumil */

/*!50001 DROP TABLE IF EXISTS `vw_kunjungan_bumil` */;
/*!50001 DROP VIEW IF EXISTS `vw_kunjungan_bumil` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_kunjungan_bumil` AS select `pelayanan`.`KD_PASIEN` AS `KD_PASIEN`,`kunjungan_bumil`.`TANGGAL_KUNJUNGAN` AS `TANGGAL_KUNJUNGAN`,`kunjungan_bumil`.`KELUHAN` AS `KELUHAN`,`kunjungan_bumil`.`TEKANAN_DARAH` AS `TEKANAN_DARAH`,`kunjungan_bumil`.`BERAT_BADAN` AS `BERAT_BADAN`,`kunjungan_bumil`.`UMUR_KEHAMILAN` AS `UMUR_KEHAMILAN`,`kunjungan_bumil`.`TINGGI_FUNDUS` AS `TINGGI_FUNDUS`,`kunjungan_bumil`.`KD_LETAK_JANIN` AS `KD_LETAK_JANIN`,`kunjungan_bumil`.`DENYUT_JANTUNG` AS `DENYUT_JANTUNG`,`kunjungan_bumil`.`KAKI_BENGKAK` AS `KAKI_BENGKAK`,concat(`kunjungan_bumil`.`LAB_DARAH_HB`,'-',`kunjungan_bumil`.`LAB_URIN_REDUKSI`,'-',`kunjungan_bumil`.`LAB_URIN_PROTEIN`) AS `HASIL_LAB`,`kunjungan_bumil`.`KD_TINDAKAN` AS `KD_TINDAKAN`,`kunjungan_bumil`.`NASEHAT` AS `NASEHAT`,`kunjungan_bumil`.`KD_STATUS_HAMIL` AS `STATUS_HAMIL`,`kunjungan_bumil`.`TANGGAL_KEMBALI` AS `TANGGAL_KEMBALI`,`trans_kia`.`KD_UNIT_PELAYANAN` AS `KD_UNIT_PELAYANAN`,`trans_kia`.`KD_DOKTER_PEMERIKSA` AS `PEMERIKSA`,`trans_kia`.`KD_DOKTER_PETUGAS` AS `PETUGAS`,`pasien`.`KD_PUSKESMAS` AS `KD_PUSKESMAS` from (((`kunjungan_bumil` join `trans_kia` on((`kunjungan_bumil`.`KD_KIA` = `trans_kia`.`KD_KIA`))) join `pelayanan` on((`trans_kia`.`KD_PELAYANAN` = convert(`pelayanan`.`KD_PELAYANAN` using utf8)))) join `pasien` on((`pelayanan`.`KD_PASIEN` = `pasien`.`KD_PASIEN`))) */;

/*View structure for view vw_layanan_order_obat */

/*!50001 DROP TABLE IF EXISTS `vw_layanan_order_obat` */;
/*!50001 DROP VIEW IF EXISTS `vw_layanan_order_obat` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_layanan_order_obat` AS select `pel_ord_obat`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`pel_ord_obat`.`KD_OBAT` AS `KD_OBAT`,`pel_ord_obat`.`SAT_BESAR` AS `SAT_BESAR`,`pel_ord_obat`.`SAT_KECIL` AS `SAT_KECIL`,`pel_ord_obat`.`HRG_DASAR` AS `HRG_DASAR`,`pel_ord_obat`.`HRG_JUAL` AS `HRG_JUAL`,`pel_ord_obat`.`QTY` AS `QTY`,`pel_ord_obat`.`DOSIS` AS `DOSIS`,if((`pel_ord_obat`.`RACIKAN` = '0'),' ',`pel_ord_obat`.`RACIKAN`) AS `RACIKAN`,`pel_ord_obat`.`JUMLAH` AS `JUMLAH`,`pel_ord_obat`.`KD_PETUGAS` AS `KD_PETUGAS`,`pel_ord_obat`.`STATUS` AS `STATUS`,`pel_ord_obat`.`iROW` AS `iROW`,`apt_mst_obat`.`NAMA_OBAT` AS `NAMA_OBAT`,if((`apt_mst_obat`.`GENERIK` = '1'),'GENERIK','NON GENERIK') AS `GENERIK`,`apt_mst_obat`.`SINGKATAN` AS `SINGKATAN`,ifnull(`pel_ord_obat`.`KD_MILIK_OBAT`,'APT') AS `KD_MILIK_OBAT`,`pel_ord_obat`.`NO_RESEP` AS `NO_RESEP`,`pel_ord_obat`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`mst_dokter`.`NAMA` AS `NAMA`,`pasien`.`KD_PASIEN` AS `KD_PASIEN`,`Get_Age`(`pasien`.`TGL_LAHIR`) AS `UMUR`,`pasien`.`NAMA_LENGKAP` AS `NAMA_PASIEN`,`pelayanan`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,ifnull(`mst_kel_pasien`.`CUSTOMER`,'') AS `CUSTOMER`,`pasien`.`ALAMAT` AS `ALAMAT`,`pel_ord_obat`.`TANGGAL` AS `TANGGAL`,ifnull(`pel_ord_obat`.`APT_UNIT`,'APT') AS `APT_UNIT` from (((((`pel_ord_obat` join `apt_mst_obat` on((`pel_ord_obat`.`KD_OBAT` = `apt_mst_obat`.`KD_OBAT`))) join `pelayanan` on((`pel_ord_obat`.`KD_PELAYANAN` = `pelayanan`.`KD_PELAYANAN`))) left join `mst_dokter` on((`mst_dokter`.`KD_DOKTER` = convert(`pelayanan`.`KD_DOKTER` using utf8)))) join `pasien` on((`pelayanan`.`KD_PASIEN` = `pasien`.`KD_PASIEN`))) join `mst_kel_pasien` on((`pelayanan`.`JENIS_PASIEN` = `mst_kel_pasien`.`KD_CUSTOMER`))) */;

/*View structure for view vw_lst_antrian */

/*!50001 DROP TABLE IF EXISTS `vw_lst_antrian` */;
/*!50001 DROP VIEW IF EXISTS `vw_lst_antrian` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_lst_antrian` AS select `kunjungan`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,(case when (`kunjungan`.`STATUS` = '1') then 'SUDAH' when (`kunjungan`.`STATUS` = '5') then 'CHECK' else `kunjungan`.`KD_KUNJUNGAN` end) AS `MYKD_KUNJUNGAN`,if((`kunjungan`.`STATUS` = '3'),'SUDAH',`kunjungan`.`KD_KUNJUNGAN`) AS `MYKD_KUNJUNGAN_APT`,`kunjungan`.`KD_PASIEN` AS `KD_PASIEN`,right(`kunjungan`.`KD_PASIEN`,7) AS `SHORT_KD_PASIEN`,`pasien`.`NAMA_LENGKAP` AS `NAMA_PASIEN`,`pasien`.`KD_JENIS_KELAMIN` AS `KD_JENIS_KELAMIN`,`pasien`.`TGL_LAHIR` AS `TGL_LAHIR`,`Get_Age`(`pasien`.`TGL_LAHIR`) AS `UMUR`,`mst_unit`.`UNIT` AS `NAMA_UNIT`,`kunjungan`.`TGL_MASUK` AS `TGL_MASUK`,`kunjungan`.`URUT_MASUK` AS `URUT_MASUK`,`kunjungan`.`JAM_MASUK` AS `JAM_MASUK`,`kunjungan`.`TGL_KELUAR` AS `TGL_KELUAR`,`kunjungan`.`JAM_KELUAR` AS `JAM_KELUAR`,(case when (`kunjungan`.`STATUS` = '1') then 'SUDAH DILAYANI' when (`kunjungan`.`STATUS` = '5') then 'CHECK ULANG' when (`kunjungan`.`STATUS` = '6') then 'SELESAI CHECK' else 'BELUM DILAYANI' end) AS `STATUS`,if((`kunjungan`.`STATUS` = '2'),'SUDAH DILAYANI','BELUM DILAYANI') AS `STATUS_APT`,`kunjungan`.`STATUS` AS `KD_STATUS`,`mst_unit`.`KD_UNIT` AS `KD_UNIT`,`kunjungan`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`mst_unit`.`PARENT` AS `PARENT`,`kunjungan`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`pasien`.`ALAMAT` AS `ALAMAT`,`pasien`.`KK` AS `KK`,`kunjungan`.`KD_DOKTER` AS `KD_DOKTER`,`kunjungan`.`KD_UNIT_LAYANAN` AS `KD_UNIT_LAYANAN`,`kunjungan`.`IS_DELETE` AS `IS_DELETE` from ((`kunjungan` join `pasien` on((`kunjungan`.`KD_PASIEN` = `pasien`.`KD_PASIEN`))) join `mst_unit` on((`kunjungan`.`KD_UNIT` = `mst_unit`.`KD_UNIT`))) */;

/*View structure for view vw_lst_kasir */

/*!50001 DROP TABLE IF EXISTS `vw_lst_kasir` */;
/*!50001 DROP VIEW IF EXISTS `vw_lst_kasir` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_lst_kasir` AS select `pel_kasir`.`KD_PEL_KASIR` AS `KD_PEL_KASIR`,`pel_kasir`.`KD_PASIEN` AS `KD_PASIEN`,`pel_kasir`.`KD_TARIF` AS `KD_TARIF`,`pel_kasir`.`KD_UNIT` AS `KD_UNIT`,`pel_kasir`.`JUMLAH_BIAYA` AS `JUMLAH_BIAYA`,if((`pel_kasir`.`STATUS_TX` = '1'),'CLOSED','OPEN') AS `STATUS`,`pel_kasir`.`STATUS_TX` AS `STATUS_TX`,`pasien`.`NAMA_LENGKAP` AS `NAMA_LENGKAP`,`pasien`.`NO_PENGENAL` AS `NO_PENGENAL`,`pasien`.`TEMPAT_LAHIR` AS `TEMPAT_LAHIR`,`pasien`.`TGL_LAHIR` AS `TGL_LAHIR`,`pel_kasir`.`KD_PUSKESMAS` AS `KD_PUSKESMAS` from (`pel_kasir` join `pasien` on((`pel_kasir`.`KD_PASIEN` = `pasien`.`KD_PASIEN`))) */;

/*View structure for view vw_lst_kasir_bayar */

/*!50001 DROP TABLE IF EXISTS `vw_lst_kasir_bayar` */;
/*!50001 DROP VIEW IF EXISTS `vw_lst_kasir_bayar` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_lst_kasir_bayar` AS select `pel_kasir`.`KD_PEL_KASIR` AS `KD_PEL_KASIR`,`pel_kasir`.`KD_TARIF` AS `KD_TARIF`,`pel_kasir`.`KD_UNIT` AS `KD_UNIT`,`pel_kasir`.`STATUS_TX` AS `STATUS_TX`,`pel_kasir`.`KD_USER` AS `KD_USER`,`pel_kasir_detail_bayar`.`KD_BAYAR` AS `KD_BAYAR`,`pel_kasir_detail_bayar`.`JUMLAH_BAYAR` AS `JUMLAH_BAYAR`,`pel_kasir_detail_bayar`.`TGL_BAYAR` AS `TGL_BAYAR`,`pel_kasir_detail_bayar`.`JUMLAH_DISC` AS `JUMLAH_DISC`,`pel_kasir_detail_bayar`.`JUMLAH_PPN` AS `JUMLAH_PPN`,`pel_kasir_detail_bayar`.`JUMLAH_TTL` AS `JUMLAH_TTL`,`mst_cara_bayar`.`CARA_BAYAR` AS `CARA_BAYAR`,`pel_kasir`.`KD_PUSKESMAS` AS `KD_PUSKESMAS` from ((`pel_kasir` join `pel_kasir_detail_bayar` on((`pel_kasir`.`KD_PEL_KASIR` = `pel_kasir_detail_bayar`.`KD_PEL_KASIR`))) join `mst_cara_bayar` on((`pel_kasir_detail_bayar`.`KD_BAYAR` = `mst_cara_bayar`.`KD_BAYAR`))) */;

/*View structure for view vw_lst_laboratorium */

/*!50001 DROP TABLE IF EXISTS `vw_lst_laboratorium` */;
/*!50001 DROP VIEW IF EXISTS `vw_lst_laboratorium` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_lst_laboratorium` AS select `mst_produk`.`KD_PRODUK` AS `KD_PRODUK`,`mst_produk`.`KD_GOL_PRODUK` AS `KD_GOL_PRODUK`,`mst_produk`.`PRODUK` AS `PRODUK`,`mst_produk`.`SINGKATAN` AS `SINGKATAN`,`mst_harga_produk`.`KD_UNIT` AS `KD_UNIT`,`mst_harga_produk`.`HARGA_PRODUK` AS `HARGA_PRODUK`,'' AS `KD_TARIF` from (`mst_produk` join `mst_harga_produk` on((`mst_produk`.`KD_PRODUK` = `mst_harga_produk`.`KD_PRODUK`))) where (`mst_produk`.`KD_GOL_PRODUK` = 'LAB') */;

/*View structure for view vw_lst_obat */

/*!50001 DROP TABLE IF EXISTS `vw_lst_obat` */;
/*!50001 DROP VIEW IF EXISTS `vw_lst_obat` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_lst_obat` AS select `apt_stok_obat`.`KD_PKM` AS `KD_PKM`,`apt_stok_obat`.`KD_UNIT_APT` AS `KD_UNIT_APT`,`apt_mst_obat`.`KD_OBAT` AS `KD_OBAT`,`apt_mst_obat`.`NAMA_OBAT` AS `NAMA_OBAT`,`apt_mst_obat`.`KD_GOL_OBAT` AS `KD_GOL_OBAT`,`apt_mst_obat`.`KD_SAT_KECIL` AS `KD_SAT_KECIL`,`apt_mst_obat`.`KD_SAT_BESAR` AS `KD_SAT_BESAR`,`apt_stok_obat`.`KD_MILIK_OBAT` AS `KD_MILIK_OBAT`,sum(`apt_stok_obat`.`JUMLAH_STOK_OBAT`) AS `JUMLAH_STOK_OBAT`,`apt_mst_unit`.`NAMA_UNIT_FAR` AS `NAMA_UNIT`,`apt_mst_obat`.`KD_OBAT_VAL` AS `KD_OBAT_VAL`,`apt_mst_obat`.`GENERIK` AS `GENERIK`,`apt_mst_obat`.`FRACTION` AS `FRACTION`,`apt_mst_obat`.`SINGKATAN` AS `SINGKATAN`,`apt_mst_obat`.`KD_TERAPI_OBAT` AS `KD_TERAPI_OBAT` from ((`apt_mst_obat` join `apt_stok_obat` on((`apt_mst_obat`.`KD_OBAT` = `apt_stok_obat`.`KD_OBAT`))) join `apt_mst_unit` on((`apt_stok_obat`.`KD_UNIT_APT` = `apt_mst_unit`.`KD_UNIT_FAR`))) group by `apt_mst_obat`.`KD_OBAT`,`apt_stok_obat`.`KD_UNIT_APT`,`apt_stok_obat`.`KD_PKM` */;

/*View structure for view vw_mr_kunjungan */

/*!50001 DROP TABLE IF EXISTS `vw_mr_kunjungan` */;
/*!50001 DROP VIEW IF EXISTS `vw_mr_kunjungan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_mr_kunjungan` AS select `p`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`p`.`KD_PELAYANAN` AS `KD_PELAYANAN`,date_format(`p`.`TGL_PELAYANAN`,'%d-%m-%Y') AS `TANGGAL`,`p`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`p`.`KD_PASIEN` AS `KD_PASIEN`,`a`.`NAMA_LENGKAP` AS `NAMA`,`kd`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,group_concat(distinct `p`.`ANAMNESA` separator ' | ') AS `ANAMNESA`,`p`.`JENIS_KASUS` AS `JENIS_KASUS`,group_concat(distinct `t`.`PRODUK` separator ' | ') AS `TINDAKAN`,group_concat(distinct `p`.`CATATAN_DOKTER` separator ' | ') AS `CATATAN_DOKTER`,group_concat(distinct `d`.`KD_PENYAKIT` separator ', ') AS `KD_PENYAKIT`,group_concat(distinct `q`.`PENYAKIT` separator ', ') AS `PENYAKIT`,group_concat(distinct `p`.`CATATAN_FISIK` separator ' | ') AS `CATATAN_FISIK`,group_concat(distinct `o`.`KD_OBAT` separator ', ') AS `KD_OBAT`,group_concat(distinct `r`.`NAMA_OBAT` separator ', ') AS `NAMA_OBAT`,group_concat(distinct `u`.`UNIT` separator ', ') AS `NAMA_UNIT`,group_concat(distinct `p`.`KD_DOKTER` separator ', ') AS `KD_DOKTER` from (((((((((`pelayanan` `p` join `pel_diagnosa` `d` on(((`d`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`) and (`d`.`KD_PUSKESMAS` = `p`.`KD_PUSKESMAS`)))) join `mst_icd` `q` on((`q`.`KD_PENYAKIT` = `d`.`KD_PENYAKIT`))) left join `pel_ord_obat` `o` on((`o`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) left join `apt_mst_obat` `r` on((`r`.`KD_OBAT` = `o`.`KD_OBAT`))) join `pasien` `a` on((`a`.`KD_PASIEN` = `p`.`KD_PASIEN`))) join `kunjungan` `kd` on((`kd`.`KD_PASIEN` = `a`.`KD_PASIEN`))) join `pel_tindakan` `m` on((`m`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) join `mst_produk` `t` on((`t`.`KD_PRODUK` = `m`.`KD_TINDAKAN`))) left join `mst_unit` `u` on((`u`.`KD_UNIT` = `p`.`KD_UNIT`))) group by `p`.`KD_PELAYANAN`,`p`.`KD_PUSKESMAS` */;

/*View structure for view vw_mr_kunjungan_kia */

/*!50001 DROP TABLE IF EXISTS `vw_mr_kunjungan_kia` */;
/*!50001 DROP VIEW IF EXISTS `vw_mr_kunjungan_kia` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_mr_kunjungan_kia` AS select `p`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`p`.`KD_PELAYANAN` AS `KD_PELAYANAN`,date_format(`p`.`TGL_PELAYANAN`,'%d-%m-%Y') AS `TANGGAL`,`p`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`p`.`KD_PASIEN` AS `KD_PASIEN`,`a`.`NAMA_LENGKAP` AS `NAMA`,`t`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,group_concat(distinct `d`.`KD_PENYAKIT` separator ', ') AS `KD_PENYAKIT`,group_concat(distinct `q`.`PENYAKIT` separator ', ') AS `PENYAKIT`,group_concat(distinct `p`.`ANAMNESA` separator ' | ') AS `ANAMNESA`,`p`.`JENIS_KASUS` AS `JENIS_KASUS`,concat(group_concat(distinct `m`.`TINDAKAN_ANAK` separator ' | '),'|',group_concat(distinct `n`.`TINDAKAN_IBU` separator ' | ')) AS `TINDAKAN`,group_concat(distinct `p`.`CATATAN_DOKTER` separator ' | ') AS `CATATAN_DOKTER`,group_concat(distinct `p`.`CATATAN_FISIK` separator ' | ') AS `CATATAN_FISIK`,group_concat(distinct `o`.`KD_OBAT` separator ', ') AS `KD_OBAT`,group_concat(distinct `r`.`NAMA_OBAT` separator ', ') AS `NAMA_OBAT`,group_concat(distinct `u`.`UNIT` separator ', ') AS `NAMA_UNIT`,group_concat(distinct `p`.`KD_DOKTER` separator ', ') AS `KD_DOKTER` from ((((((((((`pelayanan` `p` JOIN `pel_diagnosa` `d` ON (((`d`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`) AND (`d`.`KD_PUSKESMAS` = `p`.`KD_PUSKESMAS`)))) JOIN `mst_icd` `q` ON ((`q`.`KD_PENYAKIT` = `d`.`KD_PENYAKIT`))) left join `pel_ord_obat` `o` on((`o`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) left join `apt_mst_obat` `r` on((`r`.`KD_OBAT` = `o`.`KD_OBAT`))) join `pasien` `a` on((`a`.`KD_PASIEN` = `p`.`KD_PASIEN`))) join `kunjungan` `kd` on((`kd`.`KD_PASIEN` = `a`.`KD_PASIEN`))) join `detail_tindakan_anak_pem_neo` `m` on((`m`.`KD_PELAYANAN` = convert(`p`.`KD_PELAYANAN` using utf8)))) join `detail_tindakan_ibu_pem_neo` `n` on((`n`.`KD_PELAYANAN` = convert(`p`.`KD_PELAYANAN` using utf8)))) join `trans_kia` `t` on((`t`.`KD_PELAYANAN` = convert(`p`.`KD_PELAYANAN` using utf8)))) left join `mst_unit` `u` on((`u`.`KD_UNIT` = `p`.`KD_UNIT`))) group by `p`.`KD_PUSKESMAS`,`p`.`UNIT_PELAYANAN`,`a`.`KD_PASIEN`,`p`.`KD_PELAYANAN` */;

/*View structure for view vw_mr_kunjungan_kia1 */

/*!50001 DROP TABLE IF EXISTS `vw_mr_kunjungan_kia1` */;
/*!50001 DROP VIEW IF EXISTS `vw_mr_kunjungan_kia1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_mr_kunjungan_kia1` AS select `p`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,date_format(`p`.`TGL_PELAYANAN`,'%d-%m-%Y') AS `TANGGAL`,`p`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`p`.`KD_PASIEN` AS `KD_PASIEN`,`t`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`a`.`NAMA_LENGKAP` AS `NAMA`,`t`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,group_concat(distinct `d`.`KD_PENYAKIT` separator ', ') AS `KD_PENYAKIT`,group_concat(distinct `q`.`PENYAKIT` separator ', ') AS `PENYAKIT`,group_concat(distinct `p`.`ANAMNESA` separator ' | ') AS `ANAMNESA`,`p`.`JENIS_KASUS` AS `JENIS_KASUS`,group_concat(distinct `m`.`TINDAKAN` separator ' | ') AS `TINDAKAN`,group_concat(distinct `p`.`CATATAN_DOKTER` separator ' | ') AS `CATATAN_DOKTER`,group_concat(distinct `p`.`CATATAN_FISIK` separator ' | ') AS `CATATAN_FISIK`,group_concat(distinct `o`.`KD_OBAT` separator ', ') AS `KD_OBAT`,group_concat(distinct `r`.`NAMA_OBAT` separator ', ') AS `NAMA_OBAT`,group_concat(distinct `u`.`UNIT` separator ', ') AS `NAMA_UNIT`,group_concat(distinct `p`.`KD_DOKTER` separator ', ') AS `KD_DOKTER` from (((((((((`pelayanan` `p` JOIN `pel_diagnosa` `d` ON (((`d`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`) AND (`d`.`KD_PUSKESMAS` = `p`.`KD_PUSKESMAS`)))) JOIN `mst_icd` `q` ON ((`q`.`KD_PENYAKIT` = `d`.`KD_PENYAKIT`))) left join `pel_ord_obat` `o` on((`o`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) join `trans_kia` `t` on((`t`.`KD_PELAYANAN` = convert(`p`.`KD_PELAYANAN` using utf8)))) left join `apt_mst_obat` `r` on((`r`.`KD_OBAT` = `o`.`KD_OBAT`))) join `pasien` `a` on((`a`.`KD_PASIEN` = `p`.`KD_PASIEN`))) join `kunjungan` `kd` on((`kd`.`KD_PASIEN` = `a`.`KD_PASIEN`))) join `detail_tindakan_kb` `m` on((`m`.`KD_PELAYANAN` = convert(`p`.`KD_PELAYANAN` using utf8)))) left join `mst_unit` `u` on((`u`.`KD_UNIT` = `p`.`KD_UNIT`))) group by `t`.`KD_KUNJUNGAN` */;

/*View structure for view vw_mr_kunjungan_kia2 */

/*!50001 DROP TABLE IF EXISTS `vw_mr_kunjungan_kia2` */;
/*!50001 DROP VIEW IF EXISTS `vw_mr_kunjungan_kia2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_mr_kunjungan_kia2` AS select `p`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,date_format(`p`.`TGL_PELAYANAN`,'%d-%m-%Y') AS `TANGGAL`,`p`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`p`.`KD_PASIEN` AS `KD_PASIEN`,`a`.`NAMA_LENGKAP` AS `NAMA`,`tk`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,group_concat(distinct `p`.`ANAMNESA` separator ' | ') AS `ANAMNESA`,`p`.`JENIS_KASUS` AS `JENIS_KASUS`,group_concat(distinct `t`.`PRODUK` separator ' | ') AS `TINDAKAN`,group_concat(distinct `d`.`KD_PENYAKIT` separator ', ') AS `KD_PENYAKIT`,group_concat(distinct `q`.`PENYAKIT` separator ', ') AS `PENYAKIT`,group_concat(distinct `p`.`CATATAN_DOKTER` separator ' | ') AS `CATATAN_DOKTER`,group_concat(distinct `p`.`CATATAN_FISIK` separator ' | ') AS `CATATAN_FISIK`,group_concat(distinct `o`.`KD_OBAT` separator ', ') AS `KD_OBAT`,group_concat(distinct `r`.`NAMA_OBAT` separator ', ') AS `NAMA_OBAT`,group_concat(distinct `u`.`UNIT` separator ', ') AS `NAMA_UNIT`,group_concat(distinct `p`.`KD_DOKTER` separator ', ') AS `KD_DOKTER` from (((((((((`pelayanan` `p` JOIN `pel_diagnosa` `d` ON (((`d`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`) AND (`d`.`KD_PUSKESMAS` = `p`.`KD_PUSKESMAS`)))) JOIN `mst_icd` `q` ON ((`q`.`KD_PENYAKIT` = `d`.`KD_PENYAKIT`))) left join `pel_ord_obat` `o` on((`o`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) left join `apt_mst_obat` `r` on((`r`.`KD_OBAT` = `o`.`KD_OBAT`))) join `pasien` `a` on((`a`.`KD_PASIEN` = `p`.`KD_PASIEN`))) join `trans_kia` `tk` on((`tk`.`KD_PELAYANAN` = convert(`p`.`KD_PELAYANAN` using utf8)))) join `pel_tindakan` `m` on((`m`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) join `mst_produk` `t` on((`t`.`KD_PRODUK` = `m`.`KD_TINDAKAN`))) left join `mst_unit` `u` on((`u`.`KD_UNIT` = `p`.`KD_UNIT`))) where (`u`.`KD_UNIT` = 219) group by `tk`.`KD_KUNJUNGAN` */;

/*View structure for view vw_mr_kunjungan_kia3 */

/*!50001 DROP TABLE IF EXISTS `vw_mr_kunjungan_kia3` */;
/*!50001 DROP VIEW IF EXISTS `vw_mr_kunjungan_kia3` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_mr_kunjungan_kia3` AS select `p`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,date_format(`p`.`TGL_PELAYANAN`,'%d-%m-%Y') AS `TANGGAL`,`p`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`p`.`KD_PASIEN` AS `KD_PASIEN`,`a`.`NAMA_LENGKAP` AS `NAMA`,`kd`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,group_concat(distinct `p`.`ANAMNESA` separator ' | ') AS `ANAMNESA`,`p`.`JENIS_KASUS` AS `JENIS_KASUS`,group_concat(distinct `mi`.`PENYAKIT` separator ' | ') AS `PENYAKIT`,group_concat(distinct `t`.`PRODUK` separator ' | ') AS `TINDAKAN`,group_concat(distinct `p`.`CATATAN_DOKTER` separator ' | ') AS `CATATAN_DOKTER`,group_concat(distinct `p`.`CATATAN_FISIK` separator ' | ') AS `CATATAN_FISIK`,group_concat(distinct `o`.`KD_OBAT` separator ', ') AS `KD_OBAT`,group_concat(distinct `r`.`NAMA_OBAT` separator ', ') AS `NAMA_OBAT`,group_concat(distinct `u`.`UNIT` separator ', ') AS `NAMA_UNIT`,group_concat(distinct `p`.`KD_DOKTER` separator ', ') AS `KD_DOKTER` from (((((((((`pelayanan` `p` left join `pel_ord_obat` `o` on((`o`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) left join `apt_mst_obat` `r` on((`r`.`KD_OBAT` = `o`.`KD_OBAT`))) join `pasien` `a` on((`a`.`KD_PASIEN` = `p`.`KD_PASIEN`))) join `trans_kia` `kd` on((`kd`.`KD_PELAYANAN` = convert(`p`.`KD_PELAYANAN` using utf8)))) join `pel_tindakan` `m` on((`m`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) join `mst_produk` `t` on((`t`.`KD_PRODUK` = `m`.`KD_TINDAKAN`))) join `pel_diagnosa` `pd` on((`pd`.`KD_PELAYANAN` = `p`.`KD_PELAYANAN`))) join `mst_icd` `mi` on((`mi`.`KD_PENYAKIT` = `pd`.`KD_PENYAKIT`))) left join `mst_unit` `u` on((`u`.`KD_UNIT` = `p`.`KD_UNIT`))) group by `kd`.`KD_PELAYANAN` */;

/*View structure for view vw_pasien */

/*!50001 DROP TABLE IF EXISTS `vw_pasien` */;
/*!50001 DROP VIEW IF EXISTS `vw_pasien` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_pasien` AS select `pasien`.`KD_PASIEN` AS `KD_PASIEN`,right(`pasien`.`KD_PASIEN`,7) AS `SHORT_KD_PASIEN`,`pasien`.`NAMA_LENGKAP` AS `NAMA_LENGKAP`,`pasien`.`NAMA_DEPAN` AS `NAMA_DEPAN`,`pasien`.`NAMA_TENGAH` AS `NAMA_TENGAH`,`pasien`.`NAMA_BELAKANG` AS `NAMA_BELAKANG`,`pasien`.`KK` AS `KK`,`pasien`.`NO_KK` AS `NO_KK`,`pasien`.`TEMPAT_LAHIR` AS `TEMPAT_LAHIR`,`pasien`.`TGL_LAHIR` AS `TGL_LAHIR`,`Get_Age`(`pasien`.`TGL_LAHIR`) AS `UMUR`,`pasien`.`ALAMAT` AS `ALAMAT`,`pasien`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`pasien`.`NO_PENGENAL` AS `NO_PENGENAL`,`pasien`.`KD_JENIS_KELAMIN` AS `JENIS_KELAMIN`,`pasien`.`KD_GOL_DARAH` AS `KD_GOL_DARAH`,`pasien`.`KET_WIL` AS `KET_WIL`,'' AS `KD_TARIF`,`pasien`.`CARA_BAYAR` AS `KD_CARA_BAYAR`,`pasien`.`CARA_BAYAR` AS `CARA_BAYAR`,`pasien`.`KD_CUSTOMER` AS `KD_CUSTOMER`,`pasien`.`KD_CUSTOMER` AS `CUSTOMER`,`pasien`.`FLAG_LUAR_GEDUNG` AS `FLAG_L`,`pasien`.`JENIS_DATA` AS `JENIS_DATA`,ifnull(`mst_kel_pasien`.`CUSTOMER`,'') AS `JNS_PASIEN` from (`pasien` left join `mst_kel_pasien` on((`pasien`.`KD_CUSTOMER` = `mst_kel_pasien`.`KD_CUSTOMER`))) */;

/*View structure for view vw_pasien_kipi */

/*!50001 DROP TABLE IF EXISTS `vw_pasien_kipi` */;
/*!50001 DROP VIEW IF EXISTS `vw_pasien_kipi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_pasien_kipi` AS select `c`.`KD_PASIEN` AS `KD_PASIEN`,`c`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`c`.`KD_KECAMATAN` AS `KD_KECAMATAN`,`c`.`NAMA_LENGKAP` AS `NAMA_LENGKAP`,date_format(`c`.`TGL_LAHIR`,'%d-%m-%Y') AS `TGL_LAHIR`,`c`.`KD_JENIS_KELAMIN` AS `KD_JENIS_KELAMIN`,`c`.`ALAMAT` AS `ALAMAT`,`d`.`STATUS` AS `STATUS_MARITAL`,`b`.`NAMA_IBU` AS `NAMA_IBU`,`b`.`NAMA_SUAMI` AS `NAMA_SUAMI`,`c`.`KD_PASIEN` AS `id`,`c`.`KD_PASIEN` AS `id2` from (((`trans_kipi` `a` left join `trans_imunisasi` `b` on((`b`.`KD_TRANS_IMUNISASI` = `a`.`KD_TRANS_IMUNISASI`))) left join `pasien` `c` on((convert(`c`.`KD_PASIEN` using utf8) = `b`.`KD_PASIEN`))) left join `mst_status_marital` `d` on((`d`.`KD_STATUS` = `c`.`STATUS_MARITAL`))) group by `b`.`KD_PASIEN` desc */;

/*View structure for view vw_registrasi_kia */

/*!50001 DROP TABLE IF EXISTS `vw_registrasi_kia` */;
/*!50001 DROP VIEW IF EXISTS `vw_registrasi_kia` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_registrasi_kia` AS select `trans_kia`.`KD_KIA` AS `KD_KIA`,`pasien`.`KD_PASIEN` AS `KD_PASIEN`,`pasien`.`TGL_PENDAFTARAN` AS `TGL_PENDAFTARAN`,`pasien`.`NAMA_LENGKAP` AS `NAMA_LENGKAP`,`pasien`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`mst_kategori_kia`.`KATEGORI_KIA` AS `KATEGORI_KIA`,`mst_kunjungan_kia`.`KUNJUNGAN_KIA` AS `KUNJUNGAN_KIA`,`mst_kunjungan_kia`.`KD_KUNJUNGAN_KIA` AS `KD_KUNJUNGAN_KIA`,`mst_jenis_kelamin`.`JENIS_KELAMIN` AS `JENIS_KELAMIN` from (((((`trans_kia` left join `pelayanan` on((convert(`pelayanan`.`KD_PELAYANAN` using utf8) = `trans_kia`.`KD_PELAYANAN`))) left join `pasien` on((`pasien`.`KD_PASIEN` = `pelayanan`.`KD_PASIEN`))) left join `mst_jenis_kelamin` on((`mst_jenis_kelamin`.`KD_JENIS_KELAMIN` = convert(`pasien`.`KD_JENIS_KELAMIN` using utf8)))) left join `mst_kategori_kia` on((`mst_kategori_kia`.`KD_KATEGORI_KIA` = `trans_kia`.`KD_KATEGORI_KIA`))) left join `mst_kunjungan_kia` on((`mst_kunjungan_kia`.`KD_KUNJUNGAN_KIA` = `trans_kia`.`KD_KUNJUNGAN_KIA`))) */;

/*View structure for view vw_resep_obat */

/*!50001 DROP TABLE IF EXISTS `vw_resep_obat` */;
/*!50001 DROP VIEW IF EXISTS `vw_resep_obat` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_resep_obat` AS select `a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`a`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`b`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`b`.`KD_PASIEN` AS `KD_PASIEN`,`c`.`KD_OBAT` AS `KD_OBAT`,`e`.`NAMA_OBAT` AS `NAMA_OBAT`,`c`.`SAT_BESAR` AS `SAT_BESAR`,`c`.`SAT_KECIL` AS `SAT_KECIL`,`c`.`DOSIS` AS `DOSIS`,`c`.`JUMLAH` AS `JUMLAH`,`d`.`HARGA_JUAL` AS `HARGA_JUAL` from ((((`kunjungan` `a` left join `pelayanan` `b` on((`b`.`KD_PASIEN` = `a`.`KD_PASIEN`))) left join `pel_ord_obat` `c` on((`c`.`KD_PELAYANAN` = `b`.`KD_PELAYANAN`))) left join `apt_mst_harga_obat` `d` on((`d`.`KD_OBAT` = convert(`c`.`KD_OBAT` using utf8)))) left join `apt_mst_obat` `e` on((`e`.`KD_OBAT` = `c`.`KD_OBAT`))) group by `a`.`KD_KUNJUNGAN` */;

/*View structure for view vw_rpt_kunjungan */

/*!50001 DROP TABLE IF EXISTS `vw_rpt_kunjungan` */;
/*!50001 DROP VIEW IF EXISTS `vw_rpt_kunjungan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_kunjungan` AS select `kunjungan`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`kunjungan`.`KD_PASIEN` AS `KD_PASIEN`,substr(`kunjungan`.`KD_PASIEN`,12,7) AS `KODE`,`kunjungan`.`KD_UNIT_LAYANAN` AS `KD_UNIT_LAYANAN`,`kunjungan`.`KD_UNIT` AS `KD_UNIT`,`kunjungan`.`TGL_MASUK` AS `TGL_MASUK`,`kunjungan`.`URUT_MASUK` AS `URUT_MASUK`,`kunjungan`.`KD_DOKTER` AS `KD_DOKTER`,`kunjungan`.`KD_RUJUKAN` AS `KD_RUJUKAN`,`kunjungan`.`KD_CUSTOMER` AS `KD_CUSTOMER`,`kunjungan`.`JAM_MASUK` AS `JAM_MASUK`,`kunjungan`.`TGL_KELUAR` AS `TGL_KELUAR`,`kunjungan`.`JAM_KELUAR` AS `JAM_KELUAR`,`kunjungan`.`KEADAAN_MASUK` AS `KEADAAN_MASUK`,`kunjungan`.`KEADAAN_PASIEN` AS `KEADAAN_PASIEN`,`kunjungan`.`CARA_PENERIMAAN` AS `CARA_PENERIMAAN`,`kunjungan`.`ASAL_PASIEN` AS `ASAL_PASIEN`,`kunjungan`.`CARA_MASUK` AS `CARA_MASUK`,`kunjungan`.`CARA_KELUAR` AS `CARA_KELUAR`,`kunjungan`.`JENIS_PASIEN` AS `JENIS_PASIEN`,`kunjungan`.`CARA_BAYAR` AS `CARA_BAYAR`,`kunjungan`.`KETERANGAN_WILAYAH` AS `KETERANGAN_WILAYAH`,`kunjungan`.`ASURANSI` AS `ASURANSI`,`kunjungan`.`NO_ASURANSI` AS `NO_ASURANSI`,`kunjungan`.`BARU` AS `BARU`,`kunjungan`.`SHIFT` AS `SHIFT`,`kunjungan`.`KARYAWAN` AS `KARYAWAN`,`kunjungan`.`KONTROL` AS `KONTROL`,(case `kunjungan`.`STATUS` when 0 then 'BELUM' when 1 then 'SUDAH' end) AS `STATUS`,`kunjungan`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`kunjungan`.`ANAMNESA` AS `ANAMNESA`,`mst_unit_pelayanan`.`NAMA_UNIT` AS `NAMA_UNIT`,`mst_unit`.`UNIT` AS `UNIT`,concat(`pasien`.`NAMA_DEPAN`,' ',`pasien`.`NAMA_TENGAH`,' ',`pasien`.`NAMA_BELAKANG`) AS `NAMA`,`kunjungan`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,(select `sys_setting`.`KEY_VALUE` AS `KEY_VALUE` from `sys_setting` where ((`sys_setting`.`KEY_DATA` = 'LEVEL_NAME') and (`sys_setting`.`PUSKESMAS` = convert(`kunjungan`.`KD_PUSKESMAS` using utf8))) limit 1) AS `NAMA_PUSKESMAS`,`pasien`.`TGL_LAHIR` AS `TGL_LAHIR`,`Get_Age`(`pasien`.`TGL_LAHIR`) AS `UMUR`,`pasien`.`KD_JENIS_KELAMIN` AS `JENIS_KELAMIN`,`pasien`.`KET_WIL` AS `KET_WIL`,`pasien`.`KK` AS `KK`,`pasien`.`ALAMAT` AS `ALAMAT` from (((`kunjungan` join `mst_unit_pelayanan` on((`kunjungan`.`KD_UNIT_LAYANAN` = `mst_unit_pelayanan`.`KD_UNIT_LAYANAN`))) join `mst_unit` on((`kunjungan`.`KD_UNIT` = `mst_unit`.`KD_UNIT`))) join `pasien` on((`kunjungan`.`KD_PASIEN` = `pasien`.`KD_PASIEN`))) where (`kunjungan`.`KD_UNIT` <> 6) */;

/*View structure for view vw_rpt_lab */

/*!50001 DROP TABLE IF EXISTS `vw_rpt_lab` */;
/*!50001 DROP VIEW IF EXISTS `vw_rpt_lab` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_lab` AS select `d`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`d`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`d`.`KD_PENYAKIT` AS `KD_PENYAKIT`,`d`.`JNS_KASUS` AS `JNS_KASUS`,`d`.`JNS_DX` AS `JNS_DX`,`y`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`y`.`KD_UNIT` AS `KD_UNIT`,(select `mst_unit`.`UNIT` from `mst_unit` where ((`mst_unit`.`KD_UNIT` = `y`.`KD_UNIT`) and (`mst_unit`.`KD_KELAS` = '4') and (`mst_unit`.`PARENT` = '2'))) AS `NM_UNIT`,`y`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`y`.`KD_PASIEN` AS `KD_PASIEN`,`y`.`CARA_BAYAR` AS `CARA_BAYAR`,`y`.`KETERANGAN_WILAYAH` AS `KETERANGAN_WILAYAH`,`y`.`JENIS_PASIEN` AS `JENIS_PASIEN`,`p`.`TGL_LAHIR` AS `TGL_LAHIR`,`Get_AgeInDays`(`y`.`TGL_PELAYANAN`,`p`.`TGL_LAHIR`) AS `UMURINDAYS`,`m`.`KD_PELAYANAN_LAB` AS `KD_PELAYANAN_LAB`,`m`.`KD_LAB` AS `KD_LAB`,(select `mst_produk`.`PRODUK` from `mst_produk` where ((`mst_produk`.`KD_PRODUK` = `m`.`KD_LAB`) and (`mst_produk`.`KD_GOL_PRODUK` = 'LAB'))) AS `PRODUK_LAB`,`p`.`KD_JENIS_KELAMIN` AS `SEX`,(select `sys_setting`.`KEY_VALUE` AS `KEY_VALUE` from `sys_setting` where ((`sys_setting`.`KEY_DATA` = 'LEVEL_NAME') and (`sys_setting`.`PUSKESMAS` = convert(`d`.`KD_PUSKESMAS` using utf8))) limit 1) AS `NAMA_PUSKESMAS` from (((`pel_diagnosa` `d` left join `pelayanan` `y` on((`y`.`KD_PELAYANAN` = `d`.`KD_PELAYANAN`))) left join `pasien` `p` on((`p`.`KD_PASIEN` = `y`.`KD_PASIEN`))) left join `pel_ord_lab` `m` on((`m`.`KD_PELAYANAN` = `d`.`KD_PELAYANAN`))) where ((`d`.`KD_PUSKESMAS` is not null) and (`d`.`KD_PUSKESMAS` <> '')) */;

/*View structure for view vw_rpt_obat */

/*!50001 DROP TABLE IF EXISTS `vw_rpt_obat` */;
/*!50001 DROP VIEW IF EXISTS `vw_rpt_obat` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_obat` AS select `vw_layanan_order_obat`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`vw_layanan_order_obat`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`vw_layanan_order_obat`.`KD_OBAT` AS `KD_OBAT`,`vw_layanan_order_obat`.`NO_RESEP` AS `NO_RESEP`,`vw_layanan_order_obat`.`NAMA_OBAT` AS `NAMA_OBAT`,`vw_layanan_order_obat`.`QTY` AS `QTY`,`vw_layanan_order_obat`.`STATUS` AS `STATUS`,`pelayanan`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`pelayanan`.`KD_UNIT` AS `KD_UNIT`,`vw_layanan_order_obat`.`KD_MILIK_OBAT` AS `KD_MILIK_OBAT` from (`vw_layanan_order_obat` join `pelayanan` on((`vw_layanan_order_obat`.`KD_PELAYANAN` = `pelayanan`.`KD_PELAYANAN`))) where (`vw_layanan_order_obat`.`STATUS` = 1) */;

/*View structure for view vw_rpt_penyakitpasien */

/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasien` */;
/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasien` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_penyakitpasien` AS select `d`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`d`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`d`.`KD_PENYAKIT` AS `KD_PENYAKIT`,`d`.`JNS_KASUS` AS `JNS_KASUS`,`d`.`JNS_DX` AS `JNS_DX`,`y`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`y`.`KD_UNIT` AS `KD_UNIT`,`m`.`KD_TINDAKAN` AS `KD_TINDAKAN`,`k`.`PRODUK` AS `TINDAKAN`,(select `mst_unit`.`UNIT` from `mst_unit` where ((`mst_unit`.`KD_UNIT` = `y`.`KD_UNIT`) and (`mst_unit`.`KD_KELAS` = '4') and (`mst_unit`.`PARENT` = '2'))) AS `NM_UNIT`,`y`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`y`.`KD_PASIEN` AS `KD_PASIEN`,`y`.`CARA_BAYAR` AS `CARA_BAYAR`,`y`.`KETERANGAN_WILAYAH` AS `KETERANGAN_WILAYAH`,(select `mst_kel_pasien`.`CUSTOMER` from `mst_kel_pasien` where (`mst_kel_pasien`.`KD_CUSTOMER` = `y`.`JENIS_PASIEN`)) AS `JENIS_PASIEN`,`p`.`TGL_LAHIR` AS `TGL_LAHIR`,`Get_AgeInDays`(`y`.`TGL_PELAYANAN`,`p`.`TGL_LAHIR`) AS `UMURINDAYS`,`p`.`KD_JENIS_KELAMIN` AS `SEX`,(select `sys_setting`.`KEY_VALUE` AS `KEY_VALUE` from `sys_setting` where ((`sys_setting`.`KEY_DATA` = 'LEVEL_NAME') and (`sys_setting`.`PUSKESMAS` = convert(`d`.`KD_PUSKESMAS` using utf8))) limit 1) AS `NAMA_PUSKESMAS` from ((((`pelayanan` `y` left join `pasien` `p` on((`p`.`KD_PASIEN` = `y`.`KD_PASIEN`))) left join `pel_tindakan` `m` on((`y`.`KD_PELAYANAN` = `m`.`KD_PELAYANAN`))) left join `pel_diagnosa` `d` on((`y`.`KD_PELAYANAN` = `d`.`KD_PELAYANAN`))) left join `mst_produk` `k` on((`k`.`KD_PRODUK` = `m`.`KD_TINDAKAN`))) where ((`d`.`KD_PUSKESMAS` is not null) and (`d`.`KD_PUSKESMAS` <> '')) */;

/*View structure for view vw_rpt_penyakitpasien2 */

/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasien2` */;
/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasien2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_penyakitpasien2` AS select `y`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`y`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`d`.`KD_PENYAKIT` AS `KD_PENYAKIT`,`d`.`JNS_KASUS` AS `JNS_KASUS`,`d`.`JNS_DX` AS `JNS_DX`,`y`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`y`.`KD_UNIT` AS `KD_UNIT`,`m`.`KD_TINDAKAN` AS `KD_TINDAKAN`,`k`.`PRODUK` AS `TINDAKAN`,(select `mst_unit`.`UNIT` from `mst_unit` where ((`mst_unit`.`KD_UNIT` = `y`.`KD_UNIT`) and (`mst_unit`.`KD_KELAS` = '4') and (`mst_unit`.`PARENT` = '2'))) AS `NM_UNIT`,`y`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`y`.`KD_PASIEN` AS `KD_PASIEN`,`y`.`CARA_BAYAR` AS `CARA_BAYAR`,`y`.`KETERANGAN_WILAYAH` AS `KETERANGAN_WILAYAH`,(select `mst_kel_pasien`.`CUSTOMER` from `mst_kel_pasien` where (`mst_kel_pasien`.`KD_CUSTOMER` = `y`.`JENIS_PASIEN`)) AS `JENIS_PASIEN`,`p`.`TGL_LAHIR` AS `TGL_LAHIR`,`Get_AgeInDays`(`y`.`TGL_PELAYANAN`,`p`.`TGL_LAHIR`) AS `UMURINDAYS`,`p`.`KD_JENIS_KELAMIN` AS `SEX`,(select `sys_setting`.`KEY_VALUE` AS `KEY_VALUE` from `sys_setting` where ((`sys_setting`.`KEY_DATA` = 'NAMA_PUSKESMAS') and (`sys_setting`.`PUSKESMAS` = convert(`y`.`KD_PUSKESMAS` using utf8))) limit 1) AS `NAMA_PUSKESMAS` from ((((`pelayanan` `y` left join `pasien` `p` on((`p`.`KD_PASIEN` = `y`.`KD_PASIEN`))) left join `pel_tindakan` `m` on((`y`.`KD_PELAYANAN` = `m`.`KD_PELAYANAN`))) left join `pel_diagnosa` `d` on((`y`.`KD_PELAYANAN` = `d`.`KD_PELAYANAN`))) left join `mst_produk` `k` on((`k`.`KD_PRODUK` = `m`.`KD_TINDAKAN`))) where ((`y`.`KD_PUSKESMAS` is not null) and (`y`.`KD_PUSKESMAS` <> '')) */;

/*View structure for view vw_rpt_penyakitpasien_grp */

/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasien_grp` */;
/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasien_grp` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_penyakitpasien_grp` AS select `v`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`v`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`v`.`KD_PENYAKIT` AS `KD_PENYAKIT`,`v`.`JNS_KASUS` AS `JNS_KASUS`,`v`.`JNS_DX` AS `JNS_DX`,`v`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`v`.`KD_UNIT` AS `KD_UNIT`,`v`.`KD_TINDAKAN` AS `KD_TINDAKAN`,`v`.`TINDAKAN` AS `TINDAKAN`,`v`.`NM_UNIT` AS `NM_UNIT`,`v`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`v`.`KD_PASIEN` AS `KD_PASIEN`,`v`.`CARA_BAYAR` AS `CARA_BAYAR`,`v`.`KETERANGAN_WILAYAH` AS `KETERANGAN_WILAYAH`,`v`.`JENIS_PASIEN` AS `JENIS_PASIEN`,`v`.`TGL_LAHIR` AS `TGL_LAHIR`,`v`.`UMURINDAYS` AS `UMURINDAYS`,`v`.`SEX` AS `SEX`,`v`.`NAMA_PUSKESMAS` AS `NAMA_PUSKESMAS` from `vw_rpt_penyakitpasien2` `v` group by `v`.`KD_PUSKESMAS`,`v`.`KD_PELAYANAN`,`v`.`KD_UNIT` */;

/*View structure for view vw_rpt_penyakitpasien_grp_old */

/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasien_grp_old` */;
/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasien_grp_old` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_penyakitpasien_grp_old` AS select `v`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`v`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`v`.`KD_PENYAKIT` AS `KD_PENYAKIT`,`v`.`JNS_KASUS` AS `JNS_KASUS`,`v`.`JNS_DX` AS `JNS_DX`,`v`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`v`.`KD_UNIT` AS `KD_UNIT`,`v`.`KD_TINDAKAN` AS `KD_TINDAKAN`,`v`.`NM_UNIT` AS `NM_UNIT`,`v`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`v`.`KD_PASIEN` AS `KD_PASIEN`,`v`.`CARA_BAYAR` AS `CARA_BAYAR`,`v`.`KETERANGAN_WILAYAH` AS `KETERANGAN_WILAYAH`,`v`.`JENIS_PASIEN` AS `JENIS_PASIEN`,`v`.`TGL_LAHIR` AS `TGL_LAHIR`,`v`.`UMURINDAYS` AS `UMURINDAYS`,`v`.`SEX` AS `SEX`,`v`.`NAMA_PUSKESMAS` AS `NAMA_PUSKESMAS` from `vw_rpt_penyakitpasien_old` `v` group by `v`.`KD_PUSKESMAS`,`v`.`KD_PELAYANAN`,`v`.`KD_PENYAKIT` */;

/*View structure for view vw_rpt_penyakitpasien_old */

/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasien_old` */;
/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasien_old` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_penyakitpasien_old` AS select `d`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`d`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`d`.`KD_PENYAKIT` AS `KD_PENYAKIT`,`d`.`JNS_KASUS` AS `JNS_KASUS`,`d`.`JNS_DX` AS `JNS_DX`,`y`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`y`.`KD_UNIT` AS `KD_UNIT`,`m`.`KD_TINDAKAN` AS `KD_TINDAKAN`,(select `mst_unit`.`UNIT` from `mst_unit` where ((`mst_unit`.`KD_UNIT` = `y`.`KD_UNIT`) and (`mst_unit`.`KD_KELAS` = '4') and (`mst_unit`.`PARENT` = '2'))) AS `NM_UNIT`,`y`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`y`.`KD_PASIEN` AS `KD_PASIEN`,`y`.`CARA_BAYAR` AS `CARA_BAYAR`,`y`.`KETERANGAN_WILAYAH` AS `KETERANGAN_WILAYAH`,(select `mst_kel_pasien`.`CUSTOMER` from `mst_kel_pasien` where (`mst_kel_pasien`.`KD_CUSTOMER` = `y`.`JENIS_PASIEN`)) AS `JENIS_PASIEN`,`p`.`TGL_LAHIR` AS `TGL_LAHIR`,`Get_AgeInDays`(`y`.`TGL_PELAYANAN`,`p`.`TGL_LAHIR`) AS `UMURINDAYS`,`p`.`KD_JENIS_KELAMIN` AS `SEX`,(select `sys_setting`.`KEY_VALUE` AS `KEY_VALUE` from `sys_setting` where ((`sys_setting`.`KEY_DATA` = 'LEVEL_NAME') and (`sys_setting`.`PUSKESMAS` = convert(`d`.`KD_PUSKESMAS` using utf8))) limit 1) AS `NAMA_PUSKESMAS` from (((`pel_diagnosa` `d` left join `pelayanan` `y` on((`y`.`KD_PELAYANAN` = `d`.`KD_PELAYANAN`))) left join `pel_tindakan` `m` on((`m`.`KD_PELAYANAN` = `d`.`KD_PELAYANAN`))) left join `pasien` `p` on((`p`.`KD_PASIEN` = `y`.`KD_PASIEN`))) where ((`d`.`KD_PUSKESMAS` is not null) and (`d`.`KD_PUSKESMAS` <> '')) */;

/*View structure for view vw_rpt_penyakitpasienkia_grp_old */

/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasienkia_grp_old` */;
/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasienkia_grp_old` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_penyakitpasienkia_grp_old` AS select `v`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`v`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`v`.`KD_PENYAKIT` AS `KD_PENYAKIT`,`v`.`JNS_KASUS` AS `JNS_KASUS`,`v`.`JNS_DX` AS `JNS_DX`,`v`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`v`.`KD_UNIT` AS `KD_UNIT`,`v`.`KD_TINDAKAN` AS `KD_TINDAKAN`,`v`.`NM_UNIT` AS `NM_UNIT`,`v`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`v`.`KD_PASIEN` AS `KD_PASIEN`,`v`.`CARA_BAYAR` AS `CARA_BAYAR`,`v`.`KETERANGAN_WILAYAH` AS `KETERANGAN_WILAYAH`,`v`.`JENIS_PASIEN` AS `JENIS_PASIEN`,`v`.`TGL_LAHIR` AS `TGL_LAHIR`,`v`.`UMURINDAYS` AS `UMURINDAYS`,`v`.`SEX` AS `SEX`,`v`.`NAMA_PUSKESMAS` AS `NAMA_PUSKESMAS` from `vw_rpt_penyakitpasienkia_old` `v` group by `v`.`KD_PUSKESMAS`,`v`.`KD_PELAYANAN`,`v`.`KD_PENYAKIT` */;

/*View structure for view vw_rpt_penyakitpasienkia_old */

/*!50001 DROP TABLE IF EXISTS `vw_rpt_penyakitpasienkia_old` */;
/*!50001 DROP VIEW IF EXISTS `vw_rpt_penyakitpasienkia_old` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_penyakitpasienkia_old` AS select `y`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`y`.`KD_PELAYANAN` AS `KD_PELAYANAN`,NULL AS `KD_PENYAKIT`,NULL AS `JNS_KASUS`,NULL AS `JNS_DX`,`y`.`TGL_PELAYANAN` AS `TGL_PELAYANAN`,`y`.`KD_UNIT` AS `KD_UNIT`,`m`.`KD_TINDAKAN` AS `KD_TINDAKAN`,(select `mst_unit`.`UNIT` from `mst_unit` where ((`mst_unit`.`KD_UNIT` = `y`.`KD_UNIT`) and (`mst_unit`.`KD_KELAS` = '4') and (`mst_unit`.`PARENT` = '2'))) AS `NM_UNIT`,`y`.`UNIT_PELAYANAN` AS `UNIT_PELAYANAN`,`y`.`KD_PASIEN` AS `KD_PASIEN`,`y`.`CARA_BAYAR` AS `CARA_BAYAR`,`y`.`KETERANGAN_WILAYAH` AS `KETERANGAN_WILAYAH`,(select `mst_kel_pasien`.`CUSTOMER` from `mst_kel_pasien` where (`mst_kel_pasien`.`KD_CUSTOMER` = `y`.`JENIS_PASIEN`)) AS `JENIS_PASIEN`,`p`.`TGL_LAHIR` AS `TGL_LAHIR`,`Get_AgeInDays`(`y`.`TGL_PELAYANAN`,`p`.`TGL_LAHIR`) AS `UMURINDAYS`,`p`.`KD_JENIS_KELAMIN` AS `SEX`,(select `sys_setting`.`KEY_VALUE` AS `KEY_VALUE` from `sys_setting` where ((`sys_setting`.`KEY_DATA` = 'NAMA_PUSKESMAS') and (`sys_setting`.`PUSKESMAS` = convert(`y`.`KD_PUSKESMAS` using utf8))) limit 1) AS `NAMA_PUSKESMAS` from ((`pelayanan` `y` left join `pel_tindakan` `m` on((`m`.`KD_PELAYANAN` = `y`.`KD_PELAYANAN`))) left join `pasien` `p` on((`p`.`KD_PASIEN` = `y`.`KD_PASIEN`))) where ((`y`.`KD_PUSKESMAS` is not null) and (`y`.`KD_PUSKESMAS` <> '') and (`y`.`KD_UNIT` = '219')) */;

/*View structure for view vw_semua_pasien */

/*!50001 DROP TABLE IF EXISTS `vw_semua_pasien` */;
/*!50001 DROP VIEW IF EXISTS `vw_semua_pasien` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_semua_pasien` AS select `a`.`KD_PASIEN` AS `KD_PASIEN`,`a`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`a`.`KD_KECAMATAN` AS `KD_KECAMATAN`,`a`.`NAMA_LENGKAP` AS `NAMA_LENGKAP`,date_format(`a`.`TGL_LAHIR`,'%d-%m-%Y') AS `TGL_LAHIR`,`a`.`KD_JENIS_KELAMIN` AS `KD_JENIS_KELAMIN`,`a`.`ALAMAT` AS `ALAMAT`,`c`.`STATUS` AS `STATUS_MARITAL`,`b`.`NAMA_IBU` AS `NAMA_IBU`,`b`.`NAMA_SUAMI` AS `NAMA_SUAMI`,`a`.`KD_PASIEN` AS `nid`,if(`b`.`KD_TRANS_IMUNISASI`,`a`.`KD_PASIEN`,'TIDAK BOLEH') AS `nid2` from ((`pasien` `a` left join `trans_imunisasi` `b` on((`b`.`KD_PASIEN` = convert(`a`.`KD_PASIEN` using utf8)))) left join `mst_status_marital` `c` on((`c`.`KD_STATUS` = `a`.`STATUS_MARITAL`))) group by `a`.`KD_PASIEN` */;

/*View structure for view vw_stok_sarana */

/*!50001 DROP TABLE IF EXISTS `vw_stok_sarana` */;
/*!50001 DROP VIEW IF EXISTS `vw_stok_sarana` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_stok_sarana` AS select `a`.`KD_SARANA_POSYANDU` AS `KD_SARANA_POSYANDU`,`a`.`TUJUAN_SARANA` AS `TUJUAN_SARANA`,`b`.`NAMA_SARANA_POSYANDU` AS `NAMA_SARANA_POSYANDU`,`a`.`STOK_AKHIR` AS `STOK_AKHIR` from (`trans_sarana` `a` left join `mst_sarana_posyandu` `b` on((`a`.`KD_SARANA_POSYANDU` = `b`.`KD_SARANA_POSYANDU`))) group by `a`.`KD_SARANA_POSYANDU`,`a`.`TUJUAN_SARANA` */;

/*View structure for view vw_stok_sarana_masuk */

/*!50001 DROP TABLE IF EXISTS `vw_stok_sarana_masuk` */;
/*!50001 DROP VIEW IF EXISTS `vw_stok_sarana_masuk` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_stok_sarana_masuk` AS select `a`.`KD_SARANA_POSYANDU` AS `KD_SARANA_POSYANDU`,`b`.`NAMA_SARANA_POSYANDU` AS `NAMA_SARANA_POSYANDU`,`a`.`STOK_AKHIR` AS `STOK_AKHIR` from (`trans_sarana` `a` left join `mst_sarana_posyandu` `b` on((`a`.`KD_SARANA_POSYANDU` = `b`.`KD_SARANA_POSYANDU`))) group by `a`.`KD_SARANA_POSYANDU` */;

/*View structure for view vw_subgrid_imunisasi */

/*!50001 DROP TABLE IF EXISTS `vw_subgrid_imunisasi` */;
/*!50001 DROP VIEW IF EXISTS `vw_subgrid_imunisasi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_subgrid_imunisasi` AS select `a`.`KD_PASIEN` AS `KD_PASIEN`,`a`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`a`.`TANGGAL` AS `TANGGAL`,`b`.`JENIS_IMUNISASI` AS `JENIS_IMUNISASI`,`d`.`NAMA_OBAT` AS `NAMA_OBAT`,`e`.`KATEGORI_IMUNISASI` AS `KATEGORI_IMUNISASI`,`h`.`KECAMATAN` AS `KECAMATAN`,`g`.`KELURAHAN` AS `KELURAHAN`,`i`.`NAMA` AS `DOKTER`,`w`.`FLAG_L` AS `FLAG`,`a`.`KD_TRANS_IMUNISASI` AS `ID` from (((((((((`vw_imunisasi` `w` left join `trans_imunisasi` `a` on((`a`.`KD_PASIEN` = convert(`w`.`KD_PASIEN` using utf8)))) left join `pel_imunisasi` `c` on((`c`.`KD_TRANS_IMUNISASI` = `a`.`KD_TRANS_IMUNISASI`))) left join `mst_jenis_imunisasi` `b` on((`b`.`KD_JENIS_IMUNISASI` = `c`.`KD_JENIS_IMUNISASI`))) left join `apt_mst_obat` `d` on((`d`.`KD_OBAT` = `c`.`KD_OBAT`))) left join `mst_kategori_jenis_lokasi_imunisasi` `e` on((`e`.`KD_KATEGORI_IMUNISASI` = `a`.`KD_KATEGORI_IMUNISASI`))) left join `mst_kelurahan` `g` on((`g`.`KD_KELURAHAN` = `a`.`KD_KELURAHAN`))) left join `mst_kecamatan` `h` on((`h`.`KD_KECAMATAN` = `g`.`KD_KECAMATAN`))) left join `pel_petugas` `j` on((`j`.`KD_TRANS_IMUNISASI` = `a`.`KD_TRANS_IMUNISASI`))) left join `mst_dokter` `i` on((`i`.`KD_DOKTER` = `j`.`KD_DOKTER`))) where ((`w`.`FLAG_L` = '2') or '3') group by `a`.`KD_TRANS_IMUNISASI` desc */;

/*View structure for view vw_subgrid_pasien_kipi */

/*!50001 DROP TABLE IF EXISTS `vw_subgrid_pasien_kipi` */;
/*!50001 DROP VIEW IF EXISTS `vw_subgrid_pasien_kipi` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_subgrid_pasien_kipi` AS select `b`.`KD_PASIEN` AS `KD_PASIEN`,`a`.`TANGGAL_KIPI` AS `TANGGAL_KIPI`,`d`.`JENIS_IMUNISASI` AS `JENIS_IMUNISASI`,`e`.`NAMA_OBAT` AS `NAMA_OBAT`,`f`.`KATEGORI_IMUNISASI` AS `KATEGORI_IMUNISASI`,`a`.`KD_KECAMATAN` AS `KD_KECAMATAN`,`g`.`KELURAHAN` AS `KELURAHAN`,`i`.`NAMA` AS `dokter`,`j`.`GEJALA_KIPI` AS `GEJALA_KIPI`,`k`.`KEADAAN_KESEHATAN` AS `KEADAAN_KESEHATAN`,`a`.`KD_TRANS_KIPI` AS `KD_TRANS_KIPI` from ((((((((((`trans_kipi` `a` left join `pel_imunisasi` `c` on((`c`.`KD_TRANS_IMUNISASI` = `a`.`KD_TRANS_IMUNISASI`))) join `apt_mst_obat` `e` on((`e`.`KD_OBAT` = `c`.`KD_OBAT`))) join `mst_jenis_imunisasi` `d` on((`d`.`KD_JENIS_IMUNISASI` = `c`.`KD_JENIS_IMUNISASI`))) join `trans_imunisasi` `b` on((`b`.`KD_TRANS_IMUNISASI` = `c`.`KD_TRANS_IMUNISASI`))) join `mst_kategori_jenis_lokasi_imunisasi` `f` on((`f`.`KD_KATEGORI_IMUNISASI` = `b`.`KD_KATEGORI_IMUNISASI`))) join `mst_kelurahan` `g` on((convert(`g`.`KD_KELURAHAN` using utf8) = `a`.`KD_KELURAHAN`))) join `pel_petugas` `h` on((`h`.`KD_TRANS_KIPI` = `a`.`KD_TRANS_KIPI`))) join `mst_dokter` `i` on((`i`.`KD_DOKTER` = `h`.`KD_DOKTER`))) join `pel_gejala_kipi` `j` on((`j`.`KD_TRANS_KIPI` = `a`.`KD_TRANS_KIPI`))) join `mst_keadaan_kesehatan` `k` on((`k`.`KD_KEADAAN_KESEHATAN` = `a`.`KONDISI_AKHIR`))) group by `a`.`KD_TRANS_KIPI` desc */;

/*View structure for view vw_tindakan */

/*!50001 DROP TABLE IF EXISTS `vw_tindakan` */;
/*!50001 DROP VIEW IF EXISTS `vw_tindakan` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_tindakan` AS select `a`.`KD_KUNJUNGAN` AS `KD_KUNJUNGAN`,`a`.`KD_PUSKESMAS` AS `KD_PUSKESMAS`,`b`.`KD_PELAYANAN` AS `KD_PELAYANAN`,`b`.`KD_PASIEN` AS `KD_PASIEN`,`c`.`KD_TINDAKAN` AS `KD_TINDAKAN`,`d`.`PRODUK` AS `PRODUK`,`c`.`HRG_TINDAKAN` AS `HRG_TINDAKAN`,`c`.`QTY` AS `QTY`,`c`.`KETERANGAN` AS `KETERANGAN` from (((`kunjungan` `a` left join `pelayanan` `b` on((`b`.`KD_PASIEN` = `a`.`KD_PASIEN`))) left join `pel_tindakan` `c` on((`c`.`KD_PELAYANAN` = `b`.`KD_PELAYANAN`))) left join `mst_produk` `d` on((convert(`c`.`KD_TINDAKAN` using utf8) = convert(`d`.`KD_PRODUK` using utf8)))) group by `a`.`KD_KUNJUNGAN` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

ALTER TABLE pasien ADD CMLAMA VARCHAR(11);
ALTER TABLE apt_trans_obat MODIFY nupdate_oleh VARCHAR(25) DEFAULT NULL, MODIFY nupdate_tgl DATE DEFAULT NULL;
ALTER TABLE kunjungan_bumil ADD HPHT DATE,ADD HPL DATE;
ALTER TABLE kunjungan_bumil ADD TINGGI_BADAN VARCHAR(20),ADD LILA VARCHAR(20);
ALTER TABLE t_ds_kematian_anak ADD JML_P_PA_KE_KSD_5_L VARCHAR(20),ADD JML_P_PA_KE_L_5_L VARCHAR(20);

ALTER TABLE pelayanan ADD PRIMARY KEY (kd_pelayanan);
