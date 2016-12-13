<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

include_once("class/fpdf/fpdf.php");
include_once("class/PHPJasperXML.inc.php");
include_once ("setting.php");
         
$lap_bidang	= $_SESSION['lap_bidang'];
switch ($lap_bidang):
	case "KIA":
		$date1      = $_SESSION['hdnTxtFrom'];
		$date2      = $_SESSION['hdnTxtTo'];
 		$pid        = $_SESSION['pid'];
 		$jenis      = $_SESSION['lstJenis'];
	break;
	case "P2":
		$date1      = $_SESSION['hdnTxtFrom'];
		$date2      = $_SESSION['hdnTxtTo'];
 		$pid        = $_SESSION['pid'];
 		$jenis      = $_SESSION['lstJenis'];
	break;
 	default :
		$date1      = $_SESSION['hdnTxtFrom'];
		$date2      = $_SESSION['hdnTxtTo'];
		$rptnm      = $_SESSION['lstLaporan'];
		$pasien     = $_SESSION['lstPasien'];
		$obat       = $_SESSION['lstObat'];
		$bulan      = $_SESSION['lstBulan'];
		$tahun      = $_SESSION['lstTahun'];
		$pid        = $_SESSION['pid']; 
		$jns_pasien = $_SESSION['lstJenisPasien']; 
		$kategori   = $_SESSION['lstKriteria'];
		$obat       = "";
		$pasien     = "";
		$unit       = $_SESSION['lstUnit'];
		$desa       = $_SESSION['lstDesa'];
		$dokter     = $_SESSION['lstDokter'];
		$jenis      = $_SESSION['lstJenis'];
		$tipe       = $_SESSION['lstTipeLap'];
		$combolt1   = $_SESSION['combolt1'];
		$combolt2   = $_SESSION['combolt2'];
		$combolt3   = $_SESSION['combolt3'];
	break;                    
endswitch;

$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;

//echo ($jenis);
//echo ($_SESSION['lstLaporan']);

set_time_limit (0); 

switch ($jenis){                        // Untuk Melihat jenis Laporan , apakah.  Harian, Bulanan, Tahunan
    case '1':                           // Untuk Laporan dengan Jenis Laporan Harian
        switch ($rptnm){                // Untuk Melihat nama Laporan , apakah. Laporan Kunjungan, Laporan Obat 
            case 'rpt_kunjungan':       // Untuk Laporan dengan nama Laporan Kunjungan 
                switch ($kategori){     // Untuk Melihat Kategori dari Laporan Kunjungan
                    case '2':           // nilai 2 untuk pemilihan Per Poli mewakili  Laporan Kunjungan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_kunjungan_perpoli.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                    case '4':           // nilai 4 untuk pemilihan Per Dokter mewakili  Laporan Kunjungan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_kunjungan_perdokter.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $dokter . "'", "parameter1"=>"'". $pid . "'");
                        break; 
                    case '5':           // nilai 5 untuk pemilihan Per Desa mewakili  Laporan Kunjungan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_kunjungan_perdesa.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $desa . "'", "parameter1"=>"'". $pid . "'");
                        break; 
                    case '6':           // nilai 6 untuk pemilihan Per kelompok mewakili  Laporan kunjungan pada tabel user_mod_laporan
                        //echo ($jns_pasien);
                        $xml = simplexml_load_file("rd/rpt_kunjungan_jnspasien.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $jns_pasien . "'", "parameter1"=>"'". $pid . "'");
                        break; 
                    case '7':           // nilai 7 untuk pemilihan All Desa mewakili  Laporan Kunjungan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_kunjungan_alldesa.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break;              
                    case '8':           // nilai 8 untuk pemilihan All Poli mewakili  Laporan Kunjungan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_kunjungan_allpoli.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break; 

                    case '9':           // nilai 9 untuk pemilihan All Kelompok mewakili  Laporan Kunjungan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_kunjungan_allkelompok.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break; 
                    case '10':           // nilai 10 untuk pemilihan All Dokter mewakili  Laporan Kunjungan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_kunjungan_alldokter.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break; 
					case '18':           // nilai 18 untuk pemilihan Laporan Kunjungan Rawat Jalan  mewakili  Laporan Kunjungan pada tabel user_mod_laporan
                        //echo ($kategori);
						$xml = simplexml_load_file("rd/rpt_kunjungan_RJ.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break; 							
					case '19':           // nilai 19 untuk pemilihan Laporan Kunjungan Rawat Inap  mewakili  Laporan Kunjungan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_kunjungan_RI.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break; 	                   
                }     
                break;
           case 'rpt_obat': // Obat// nilai 2 mewakili perpoli pada tabel user_mod_laporan
               switch ($kategori){
                    case '1':           // nilai 1 untuk pemilihan Per Pasien mewakili  Laporan Obat pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_obat_perpasien.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $pasien . "'", "parameter1"=>"'". $pid . "'");
                        break;              
                    case '3':           // nilai 3 untuk pemilihan Per Obat mewakili  Laporan Obat pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_obat_perobat.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $obat . "'", "parameter1"=>"'". $pid . "'");
                        break;              
                    case '11':           // nilai 11 untuk pemilihan Per Poli mewakili  Laporan Obat pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_obat_perpoli.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break; 
                    case '12':           // nilai 12 untuk pemilihan Per Dokter mewakili  Laporan Obat pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_obat_perdokter.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $dokter . "'", "parameter1"=>"'". $pid . "'");
                        break; 
                    case '13':           // nilai 13 untuk pemilihan Semua Pasien mewakili  Laporan Obat pada tabel user_mod_laporan
                       $xml = simplexml_load_file("rd/rpt_obat_allpasien.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break; 
                     case '14':           // nilai 14 untuk pemilihan Semua Obat mewakili  Laporan Obat pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_obat_allobat.jrxml");
						
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break; 
                    case '15':           // nilai 15 untuk pemilihan Semua Poli mewakili  Laporan Obat pada tabel user_mod_laporan
                        $xml = simplexml_load_file("rd/rpt_obat_allpoli.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break; 
                    case '16':           // nilai 16 untuk pemilihan Semua Dokter mewakili  Laporan Obat pada tabel user_mod_laporan
                        //echo ("test alldokter o");
                        $xml = simplexml_load_file("rd/rpt_obat_alldokter.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break; 
					case '17':           // nilai 17 untuk pemilihan Laporan Obat Jumlah Resep mewakili  Laporan Obat pada tabel user_mod_laporan
						$xml = simplexml_load_file("rd/rpt_jml_resep.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
                        break; 	
               }     
               break;
// Untuk Laporan berdasarkan Jenis Pasien dan Unit Pelayanan
// Untuk Laporan dengan Jenis Laporan LABORATORIUM
			case 'rpt_lab':
				//echo ("test laboratorium");
 				$xml =  simplexml_load_file("rd/rpt_lab.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
        		break;
			case 'rpt_rad':
				//echo ("test laboratorium");
 				$xml =  simplexml_load_file("rd/rpt_rad.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
        		break;	
			case 'rpt_restribusi':
 				$xml =  simplexml_load_file("rd/rpt_jml_retribusi.jrxml");
				//$xml =  simplexml_load_file("rd/rpt_restribusi2_RJ.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
        		break;	
            case 'rpt_top_dx': 

				$xml =  simplexml_load_file("rd/rpt_penyakit_terbanyak.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break; 
            case 'rpt_top_kematian': 
				$xml =  simplexml_load_file("rd/rpt_penyakit_penyebab_kematian.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;				 				
       }
        break;
			
    case '2': // Untuk Laporan dengan Jenis Laporan Bulanan
		switch ($rptnm){
            case 'rpt_lb1': // LB1
                $xml =  simplexml_load_file("rm/rpt_lb1.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;	
            case 'rpt_lb2': // LB2
                $xml =  simplexml_load_file("rm/rpt_lb2.jrxml");
				$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;	
            case 'rpt_lb3': // LB3
                $xml =  simplexml_load_file("rm/rpt_lb3test.jrxml");
				//$xml =  simplexml_load_file("rm/rpt_lb3.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;	
            case 'rpt_lb4': // LB4
                $xml =  simplexml_load_file("rm/rpt_lb4.jrxml");
                //$xml =  simplexml_load_file("rm/rpt_lb4.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;	
            case 'rpt_lb5': // LB5
                $xml =  simplexml_load_file("rm/rpt_lb5.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;
            case 'rpt_gigimulut': // Laporan Gigi dan Mulut Puskesmas
				//$xml =  simplexml_load_file("rm/rpt_gigimuluttest.jrxml");
                $xml =  simplexml_load_file("rm/rpt_gigimulut_pkm.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;
            case 'rpt_gigi_sekolah': // Laporan Gigi dan Mulut Puskesmas
				//$xml =  simplexml_load_file("rm/rpt_gigimuluttest.jrxml");
                $xml =  simplexml_load_file("rm/rpt_gigi_sekolah.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;	
            case 'rpt_ukgmd': // Laporan Gigi dan Mulut Puskesmas
				//$xml =  simplexml_load_file("rm/rpt_gigimuluttest.jrxml");
                $xml =  simplexml_load_file("rm/rpt_ukgmd.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;													
        }
        break;

    case '3': // Untuk Laporan dengan Jenis Laporan Tahunan
        switch ($rptnm){
            case 'rpt_lt1': // Laporan Tahunan 1
                switch ($combolt1) {
                case '1':           // nilai 1 untuk pemilihan Laporan Gaky mewakili  Laporan Tahunan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt1_gaky.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '2':           // nilai 2 untuk pemilihan Laporan Keadaan Fisik mewakili  Laporan Tahunan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt1_keadaan_fisik.jrxml");
                        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '3':           // nilai 3 untuk pemilihan Laporan Gigi mewakili  Laporan Tahunan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt1_gigi.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '4':           // nilai 4 untuk pemilihan Laporan Kesling mewakili  Laporan Tahunan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt1_kesling.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '5':           // nilai 5 untuk pemilihan Laporan DB dan Rabies mewakili  Laporan Tahunan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt1_db_rabies.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '6':           // nilai 6 untuk pemilihan Laporan Malaria mewakili  Laporan Tahunan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt1_malaria.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '7':           // nilai 7 untuk pemilihan Laporan UKBM mewakili  Laporan Tahunan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt1_ukbm.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '8':           // nilai 8 untuk pemilihan Laporan Air Bersih mewakili  Laporan Tahunan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt1_perpoli.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '9':           // nilai 9 untuk pemilihan Laporan UKS mewakili  Laporan Tahunan pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt1_uks.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                }
                break;	
            case 'rpt_lt2': // Laporan Tahunan 2
                switch ($combolt1) {
                case '1':           // nilai 1 untuk pemilihan Laporan Pegawai yang Pensiun mewakili  Laporan Tahunan 2 pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt2_pp.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '2':           // nilai 2 untuk pemilihan Laporan Pegawai yang Aktif mewakili  Laporan Tahunan 2 pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt2_pa.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '3':           // nilai 3 untuk pemilihan Laporan Pegawai yang Naik Pangkat mewakili  Laporan Tahunan 2 pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt2_pnp.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                }
                break;	
            case 'rpt_lt3': // Laporan Tahunan 3
                switch ($combolt1) {
                case '1':           // nilai 1 untuk pemilihan Per Poli mewakili  Laporan Tahunan 3 pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt3_alat_diag_klinik.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '2':           // nilai 2 untuk pemilihan Per Poli mewakili  Laporan Tahunan 3 pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt3_alat_gigi.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '3':           // nilai 3 untuk pemilihan Per Poli mewakili  Laporan Tahunan 3 pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt3_laboratorium.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '4':           // nilai 4 untuk pemilihan Per Poli mewakili  Laporan Tahunan 3 pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt3_peralatan_linen.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '5':           // nilai 5 untuk pemilihan Per Poli mewakili  Laporan Tahunan 3 pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt3_peralatan_non_medik.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '6':           // nilai 6 untuk pemilihan Per Poli mewakili  Laporan Tahunan 3 pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt3_peralatan_penyuluhan.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                case '7':           // nilai 7 untuk pemilihan Per Poli mewakili  Laporan Tahunan 3 pada tabel user_mod_laporan
                        $xml = simplexml_load_file("ry/rpt_lt3_peralatan_tindak_medis.jrxml");
                        //$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter2"=>"'". $unit . "'", "parameter1"=>"'". $pid . "'");
                        break;
                }
                break;	
            case 'rpt_lt4': // LB2
                $xml =  simplexml_load_file("ry/rpt_lt4.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;	
            case 'rpt_lt5': // LB2
                $xml =  simplexml_load_file("ry/rpt_lt5.jrxml");
                $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
                break;	
      
        }
        break;
	case 'rpt_pws_kia':
		//$xml =  simplexml_load_file("rm/rpt_pws_kiatest.jrxml");
		$xml =  simplexml_load_file("rm/rpt_pws_kia.jrxml");
        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
        break;
	case 'rpt_imunisasi_bayi':
		$xml =  simplexml_load_file("rm/rpt_imunisasi_bayi.jrxml");
		
        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
        break;
	case 'rpt_imunisasi_bumil':
		$xml =  simplexml_load_file("rm/rpt_imunisasi_bumil.jrxml");
		
        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
        break;					
	case 'rpt_imunisasi_wus':
		$xml =  simplexml_load_file("rm/rpt_imunisasi_wus.jrxml");
		
        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
        break;
	case 'rpt_kohort_bayi':
		$xml =  simplexml_load_file("rm/rpt_kohort_bayi.jrxml");
		
        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
        break;
	case 'rpt_kohort_bumil':
		$xml =  simplexml_load_file("rm/rpt_kohort_bumil.jrxml");
	
        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
        break;					
}





$PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I"); //page output method I:standard output  D:Download file    F:Save to Local File


?>
