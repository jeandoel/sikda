<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
	html,body{font-family:helvetica;font-size:15px;width:100%}
	table, td
	{
	border: 1px solid #000;padding:3px;
	}
	table
	{
	font-family:helvetica;font-size:13px;
	width:95%;
	border-collapse: collapse;
	}
.style1 {font-size: 9px}
.style2 {font-size: 10px}
</style>
</head>

<body>
<div>
	<span class="style2"><b>LAPORAN  BULANAN  KEGIATAN PUSKESMAS</b></span>
	<span class="style2"><br>
	BULAN : <?php echo $waktu->bulan;?></span>
	<span class="style2"><br>
	TAHUN : <?php echo $waktu->TAHUN;?></span>
	<span class="style2"><br>
	DINAS KESEHATAN KAB/KOTA <?php echo $waktu->KABUPATEN;?></span>
	<br>
	<span></span>
	<br>
</div>
<table width="1500" border="1">
 <tr>
    <td width="35" rowspan="3" bgcolor="#CCCCCC"><div align="center" class="style1"><b>NO</b></div></td>
    <td width="115" rowspan="3" bgcolor="#CCCCCC"><div align="center" class="style1"><b>PUSKESMAS</b></div></td>
    <td colspan="9" rowspan="2" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Kegiatan Rujukan</b></div></td>
    <td colspan="4" rowspan="2" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Kegiatan Laboratorium</b></div></td>
    <td colspan="8" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Kegiatan Perawatan Kesehatan Masyarakat</b></div></td>
    <td colspan="3" rowspan="2" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Kegiatan Kunjungan</b></div></td>
    <td colspan="6" rowspan="2" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Rawat Tinggal</b></div></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Pembinaan Keluarga Rawan</b></div></td>
    <td colspan="2" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Tindak Lanjut Perawatan yg Selesai dibina</b></div></td>
    <td colspan="2" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Pembinaan Gol Resiko Bumil &amp; Balita</b></div></td>
    <td width="22" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Pembinaan Kelompok Khusus/Panti</b></div></td>
  </tr>
  <tr>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Dirujuk dr Puskesmas</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Rujukan Balik RS</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Rujukan Kader ke Puskesmas</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Rujukan Posyandu ke Puskesmas</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Rujukan Pustu ke Puskesmas</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Rujukan Sekolah ke Puskesmas</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Lain-lain Rujukan ke Puskesmas</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Rujukan ke Puskesmas</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Kunjungan Dokter Ahli</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Pemeriksaan Specimen Darah</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Pemeriksaan Specimen Urine / Air Seni</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Pemeriksaan Specimen Tinja </b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Pemeriksaan Specimen Lain</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Kel. Rawan Tercatat dipuskesmas</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Kel. Rawan yg selesai dibina</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Kunj. Ke Keluarga Rawan selesai dibina</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Kasus Tindak Lanjut Perawatan Selesai dibina</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>dibina</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Bumil dpt asuhan perawatan</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Balita dpt asuhan perawatan</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Kel. Khusus/ Panti yg Dibina</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Kunj. Umum Bayar</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Kunj. Askes</b></div></td>
    <td width="115" bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Kunj. JPS/Kartu Sehat</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Penderita yg Dirawat</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Hari Perawatan</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Tempat Tidur</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Hari Buka</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Penderita Keluar Meninggal &lt; 48</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>Jml Penderita Keluar Meninggal &gt; 48</b></div></td>
  </tr>
 <tr>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>1</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>2</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>3</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>4</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>5</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>6</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>7</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>8</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>9</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>10</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>11</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>12</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>13</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>14</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>15</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>16</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>17</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>18</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>19</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>20</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>21</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>22</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>23</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>24</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>25</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>26</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>27</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>28</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>29</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>30</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>31</b></div></td>
    <td bgcolor="#CCCCCC"><div align="center" class="style1"><b>32</b></div></td>
  </tr>
  <?php
	$no=1;
	$JML_KR_DARI_PUSKESMAS=0;
	$JML_KR_B_RUMAH_SAKIT=0;
	$JML_KR_KA_PUSKESMAS=0;
	$JML_KR_PO_PUSKESMAS=0;
	$JML_KR_PU_PUSKESMAS=0;
	$JML_KR_SE_PUSKESMAS=0;
	$JML_KR_LAIN_PUSKESMAS=0;
	$JML_KR_KE_PUSKESMAS=0;
	$JML_KR_K_DOKTER_AHLI=0;
	$KL_PS_DARAH=0;
	$KL_PS_URINE=0;
	$KL_PS_TINJA=0;
	$KL_PS_LAIN=0;
	$JML_PKR_PUSKESMAS=0;
	$JML_PKR_DIBINA=0;
	$JML_PKR_KUNJUNGAN_DIBINA=0;
	$JML_KASUS_TLPSB=0;
	$JML_KUNJ_TLPSB=0;
	$JML_PGR_BUMIL_PERAWATAN=0;
	$JML_PGR_BALITA_PERAWATAN=0;
	$JML_PKKP_DIBINA=0;
	$JML_KK_UMUM_BAYAR=0;
	$JML_KK_ASKES=0;
	$JML_KK_JPS_K_SEHAT=0;
	$JML_RT_P_DIRAWAT=0;
	$JML_RT_H_PERAWATAN=0;
	$JML_RT_T_TIDUR=0;
	$JML_RT_H_BUKA=0;
	$JML_RT_PK_MENINGGAL_K_48=0;
	$JML_RT_PK_MENINGGAL_L_48=0;
	
	foreach($kegiatanpuskesmas as $key=>$row){
  ?>
  <tr>
   	<td align="center"class="style1"><?=$no;?></div></td>
    <td><div class="style1"><?=$row['PUSKESMAS'];?></div></td>
    <td><div align="center" class="style1"><?php $JML_KR_DARI_PUSKESMAS_TEMP= $row['JML_KR_DARI_PUSKESMAS']+$row['JML_KR_DARI_PUSKESMAS_P']; $JML_KR_DARI_PUSKESMAS=$JML_KR_DARI_PUSKESMAS+$JML_KR_DARI_PUSKESMAS_TEMP; echo $JML_KR_DARI_PUSKESMAS_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KR_B_RUMAH_SAKIT_TEMP= $row['JML_KR_B_RUMAH_SAKIT']+$row['JML_KR_B_RUMAH_SAKIT_P']; $JML_KR_B_RUMAH_SAKIT=$JML_KR_B_RUMAH_SAKIT+$JML_KR_B_RUMAH_SAKIT_TEMP; echo $JML_KR_B_RUMAH_SAKIT_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KR_KA_PUSKESMAS_TEMP= $row['JML_KR_KA_PUSKESMAS']+$row['JML_KR_KA_PUSKESMAS_P']; $JML_KR_KA_PUSKESMAS=$JML_KR_KA_PUSKESMAS+$JML_KR_KA_PUSKESMAS_TEMP; echo $JML_KR_KA_PUSKESMAS_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KR_PO_PUSKESMAS_TEMP= $row['JML_KR_PO_PUSKESMAS']+$row['JML_KR_PO_PUSKESMAS_P']; $JML_KR_PO_PUSKESMAS=$JML_KR_PO_PUSKESMAS+$JML_KR_PO_PUSKESMAS_TEMP; echo $JML_KR_PO_PUSKESMAS_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KR_PU_PUSKESMAS_TEMP= $row['JML_KR_PU_PUSKESMAS']+$row['JML_KR_PU_PUSKESMAS_P']; $JML_KR_PU_PUSKESMAS=$JML_KR_PU_PUSKESMAS+$JML_KR_PU_PUSKESMAS_TEMP; echo $JML_KR_PU_PUSKESMAS_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KR_SE_PUSKESMAS_TEMP= $row['JML_KR_SE_PUSKESMAS']+$row['JML_KR_SE_PUSKESMAS_P']; $JML_KR_SE_PUSKESMAS=$JML_KR_SE_PUSKESMAS+$JML_KR_SE_PUSKESMAS_TEMP; echo $JML_KR_SE_PUSKESMAS_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KR_LAIN_PUSKESMAS_TEMP= $row['JML_KR_LAIN_PUSKESMAS']+$row['JML_KR_LAIN_PUSKESMAS_P']; $JML_KR_LAIN_PUSKESMAS=$JML_KR_LAIN_PUSKESMAS+$JML_KR_LAIN_PUSKESMAS_TEMP; echo $JML_KR_LAIN_PUSKESMAS_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KR_KE_PUSKESMAS_TEMP= $row['JML_KR_KE_PUSKESMAS']+$row['JML_KR_KE_PUSKESMAS_P']; $JML_KR_KE_PUSKESMAS=$JML_KR_KE_PUSKESMAS+$JML_KR_KE_PUSKESMAS_TEMP; echo $JML_KR_KE_PUSKESMAS_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KR_K_DOKTER_AHLI_TEMP= $row['JML_KR_K_DOKTER_AHLI']+$row['JML_KR_K_DOKTER_AHLI_P']; $JML_KR_K_DOKTER_AHLI=$JML_KR_K_DOKTER_AHLI+$JML_KR_K_DOKTER_AHLI_TEMP; echo $JML_KR_K_DOKTER_AHLI_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $KL_PS_DARAH_TEMP= $row['KL_PS_DARAH']+$row['KL_PS_DARAH_P']; $KL_PS_DARAH=$KL_PS_DARAH+$KL_PS_DARAH_TEMP; echo $KL_PS_DARAH_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $KL_PS_URINE_TEMP= $row['KL_PS_URINE']+$row['KL_PS_URINE_P']; $KL_PS_URINE=$KL_PS_URINE+$KL_PS_URINE_TEMP; echo $KL_PS_URINE_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $KL_PS_TINJA_TEMP= $row['KL_PS_TINJA']+$row['KL_PS_TINJA_P']; $KL_PS_TINJA=$KL_PS_TINJA+$KL_PS_TINJA_TEMP; echo $KL_PS_TINJA_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $KL_PS_LAIN_TEMP= $row['KL_PS_LAIN']+$row['KL_PS_LAIN_P']; $KL_PS_LAIN=$KL_PS_LAIN+$KL_PS_LAIN_TEMP; echo $KL_PS_LAIN_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_PKR_PUSKESMAS_TEMP= $row['JML_PKR_PUSKESMAS']+$row['JML_PKR_PUSKESMAS_P']; $JML_PKR_PUSKESMAS=$JML_PKR_PUSKESMAS+$JML_PKR_PUSKESMAS_TEMP; echo $JML_PKR_PUSKESMAS_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_PKR_DIBINA_TEMP= $row['JML_PKR_DIBINA']+$row['JML_PKR_DIBINA_P']; $JML_PKR_DIBINA=$JML_PKR_DIBINA+$JML_PKR_DIBINA_TEMP; echo $JML_PKR_DIBINA_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_PKR_KUNJUNGAN_DIBINA_TEMP= $row['JML_PKR_KUNJUNGAN_DIBINA']+$row['JML_PKR_KUNJUNGAN_DIBINA_P']; $JML_PKR_KUNJUNGAN_DIBINA=$JML_PKR_KUNJUNGAN_DIBINA+$JML_PKR_KUNJUNGAN_DIBINA_TEMP; echo $JML_PKR_KUNJUNGAN_DIBINA_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KASUS_TLPSB_TEMP= $row['JML_KASUS_TLPSB']+$row['JML_KASUS_TLPSB_P']; $JML_KASUS_TLPSB=$JML_KASUS_TLPSB+$JML_KASUS_TLPSB_TEMP; echo $JML_KASUS_TLPSB_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KUNJ_TLPSB_TEMP= $row['JML_KUNJ_TLPSB']+$row['JML_KUNJ_TLPSB_P']; $JML_KUNJ_TLPSB=$JML_KUNJ_TLPSB+$JML_KUNJ_TLPSB_TEMP; echo $JML_KUNJ_TLPSB_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_PGR_BUMIL_PERAWATAN_TEMP= $row['JML_PGR_BUMIL_PERAWATAN_P']; $JML_PGR_BUMIL_PERAWATAN= $JML_PGR_BUMIL_PERAWATAN + $JML_PGR_BUMIL_PERAWATAN_TEMP; echo $JML_PGR_BUMIL_PERAWATAN_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_PGR_BALITA_PERAWATAN_TEMP= $row['JML_PGR_BALITA_PERAWATAN']+$row['JML_PGR_BALITA_PERAWATAN_P']; $JML_PGR_BALITA_PERAWATAN= $JML_PGR_BALITA_PERAWATAN + $JML_PGR_BALITA_PERAWATAN_TEMP; echo $JML_PGR_BALITA_PERAWATAN_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_PKKP_DIBINA_TEMP= $row['JML_PKKP_DIBINA']+$row['JML_PKKP_DIBINA_P']; $JML_PKKP_DIBINA=$JML_PKKP_DIBINA+$JML_PKKP_DIBINA_TEMP; echo $JML_PKKP_DIBINA_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KK_UMUM_BAYAR_TEMP= $row['JML_KK_UMUM_BAYAR']+$row['JML_KK_UMUM_BAYAR_P']; $JML_KK_UMUM_BAYAR=$JML_KK_UMUM_BAYAR+$JML_KK_UMUM_BAYAR_TEMP; echo $JML_KK_UMUM_BAYAR_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KK_ASKES_TEMP= $row['JML_KK_ASKES']+$row['JML_KK_ASKES_P']; $JML_KK_ASKES=$JML_KK_ASKES+$JML_KK_ASKES_TEMP; echo $JML_KK_ASKES_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_KK_JPS_K_SEHAT_TEMP= $row['JML_KK_JPS_K_SEHAT']+$row['JML_KK_JPS_K_SEHAT_P']; $JML_KK_JPS_K_SEHAT=$JML_KK_JPS_K_SEHAT+$JML_KK_JPS_K_SEHAT_TEMP; echo $JML_KK_JPS_K_SEHAT_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_RT_P_DIRAWAT_TEMP= $row['JML_RT_P_DIRAWAT']+$row['JML_RT_P_DIRAWAT_P']; $JML_RT_P_DIRAWAT=$JML_RT_P_DIRAWAT+$JML_RT_P_DIRAWAT_TEMP; echo $JML_RT_P_DIRAWAT_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_RT_H_PERAWATAN_TEMP= $row['JML_RT_H_PERAWATAN']+$row['JML_RT_H_PERAWATAN_P']; $JML_RT_H_PERAWATAN=$JML_RT_H_PERAWATAN+$JML_RT_H_PERAWATAN_TEMP; echo $JML_RT_H_PERAWATAN_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_RT_T_TIDUR_TEMP= $row['JML_RT_T_TIDUR']+$row['JML_RT_T_TIDUR_P']; $JML_RT_T_TIDUR=$JML_RT_T_TIDUR+$JML_RT_T_TIDUR_TEMP; echo $JML_RT_T_TIDUR_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_RT_H_BUKA_TEMP= $row['JML_RT_H_BUKA']+$row['JML_RT_H_BUKA_P']; $JML_RT_H_BUKA=$JML_RT_H_BUKA+$JML_RT_H_BUKA_TEMP; echo $JML_RT_H_BUKA_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_RT_PK_MENINGGAL_K_48_TEMP= $row['JML_RT_PK_MENINGGAL_K_48']+$row['JML_RT_PK_MENINGGAL_K_48_P']; $JML_RT_PK_MENINGGAL_K_48=$JML_RT_PK_MENINGGAL_K_48+$JML_RT_PK_MENINGGAL_K_48_TEMP;echo $JML_RT_PK_MENINGGAL_K_48_TEMP?></div></td>
    <td><div align="center" class="style1"><?php $JML_RT_PK_MENINGGAL_L_48_TEMP= $row['JML_RT_PK_MENINGGAL_L_48']+$row['JML_RT_PK_MENINGGAL_L_48_P']; $JML_RT_PK_MENINGGAL_L_48=$JML_RT_PK_MENINGGAL_L_48+$JML_RT_PK_MENINGGAL_L_48_TEMP; echo $JML_RT_PK_MENINGGAL_L_48_TEMP?></div></td>
  </tr>
  <?php
	$no++;
	}
  ?>
  <tr>
    <td colspan="2"><div align="center" class="style2"><b>JUMLAH</b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KR_DARI_PUSKESMAS?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KR_B_RUMAH_SAKIT?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KR_KA_PUSKESMAS?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KR_PO_PUSKESMAS?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KR_PU_PUSKESMAS?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KR_SE_PUSKESMAS?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KR_LAIN_PUSKESMAS?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KR_KE_PUSKESMAS?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KR_K_DOKTER_AHLI?></b></div></td>
    <td><div align="center" class="style1"><b><?=$KL_PS_DARAH?></b></div></td>
    <td><div align="center" class="style1"><b><?=$KL_PS_URINE?></b></div></td>
    <td><div align="center" class="style1"><b><?=$KL_PS_TINJA?></b></div></td>
    <td><div align="center" class="style1"><b><?=$KL_PS_LAIN?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_PKR_PUSKESMAS?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_PKR_DIBINA?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_PKR_KUNJUNGAN_DIBINA?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KASUS_TLPSB?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KUNJ_TLPSB?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_PGR_BUMIL_PERAWATAN?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_PGR_BALITA_PERAWATAN?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_PKKP_DIBINA?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KK_UMUM_BAYAR?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KK_ASKES?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_KK_JPS_K_SEHAT?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_RT_P_DIRAWAT?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_RT_H_PERAWATAN?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_RT_T_TIDUR?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_RT_H_BUKA?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_RT_PK_MENINGGAL_K_48?></b></div></td>
    <td><div align="center" class="style1"><b><?=$JML_RT_PK_MENINGGAL_L_48?></b></div></td>
  </tr>
</table>
</body>
</html>
