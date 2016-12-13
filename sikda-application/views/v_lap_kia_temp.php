<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Bulanan Kia</title>
<style type="text/css">
body,td,th {
	font-size: 12px;
}
</style>
</head>

<body>
<style>
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
				</style>
<p class="style1" style="padding-left:40px;">
		
		BULAN :&nbsp <?php echo $waktu->bulan;?><br>
		TAHUN :&nbsp <?php echo $waktu->TAHUN;?><br>
		DINAS KESEHATAN KAB/KOTA  :&nbsp  <?php echo $waktu->KABUPATEN;?>
		
		</p>
<table width="1500" border="1">
  <tr>
    <td width="39" rowspan="2"><div align="center">NO</div></td>
    <td width="115" rowspan="2"><div align="center">PUSKESMAS</div></td>
    <td colspan="3"><div align="center">SASARAN</div></td>
    <td colspan="6"><div align="center">IBU HAMIL</div></td>
    <td width="39" rowspan="2"><div align="center">VIT A BUFAS</div></td>
    <td colspan="2"><div align="center">DET.RESTI</div></td>
    <td colspan="2"><div align="center">PERSALINAN</div></td>
    <td colspan="2"><div align="center">NEONATUS</div></td>
    <td colspan="3"><div align="center">KEMATIAN IBU</div></td>
    <td width="40" rowspan="2"><div align="center">LAHIR MATI</div></td>
    <td width="40" rowspan="2"><div align="center">LAHIR HIDUP</div></td>
    <td colspan="2"><div align="center">KEMATIAN</div></td>
    <td width="70" rowspan="2"><div align="center">KEMATIAN BAYI 1BL-12BL</div></td>
    <td width="81" rowspan="2"><div align="center">KEMATIAN 1-5 THN</div></td>
  </tr>
  <tr>
    <td width="75"><div align="center">BUMIL</div></td>
    <td width="84"><div align="center">BULIN</div></td>
    <td width="77"><div align="center">BAYI</div></td>
    <td width="52"><div align="center">K1</div></td>
    <td width="46"><div align="center">K4</div></td>
    <td width="92"><div align="center">TT BOSTER/ULANG</div></td>
    <td width="25">FE-1</td>
    <td width="25">FE-3</td>
    <td width="25">IOD</td>
    <td width="35">MASY</td>
    <td width="40">NAKES</td>
    <td width="45">DUKUN</td>
    <td width="40">NAKES</td>
    <td width="33">KN-1</td>
    <td width="33">KN-2</td>
    <td width="40">BUMIL</td>
    <td width="39">BUFAS</td>
    <td width="37">BULIN</td>
    <td width="34"><div align="center">0-7 HARI</div></td>
    <td width="33"><div align="center">8 HRI-1BL</div></td>
  </tr>
  <tr>
    <td><div align="center">1</div></td>
    <td><div align="center">2</div></td>
    <td><div align="center">3</div></td>
    <td><div align="center">4</div></td>
    <td><div align="center">5</div></td>
    <td><div align="center">6</div></td>
    <td><div align="center">7</div></td>
    <td><div align="center">8</div></td>
    <td><div align="center">9</div></td>
    <td><div align="center">10</div></td>
    <td><div align="center">11</div></td>
    <td><div align="center">12</div></td>
    <td><div align="center">13</div></td>
    <td><div align="center">14</div></td>
    <td><div align="center">15</div></td>
    <td><div align="center">16</div></td>
    <td><div align="center">17</div></td>
    <td><div align="center">18</div></td>
    <td><div align="center">19</div></td>
    <td><div align="center">20</div></td>
    <td><div align="center">21</div></td>
    <td><div align="center">22</div></td>
    <td><div align="center">23</div></td>
    <td><div align="center">24</div></td>
    <td><div align="center">25</div></td>
    <td><div align="center">26</div></td>
    <td><div align="center">27</div></td>
  </tr>
   <?php
	$no=1;
	$JML_KJ_K1_BUMIL=0;
	$JML_KJ_K4_BUMIL=0;
	$JML_KJ_K1_BUMIL=0;
	$JML_KJ_K1_BUMIL=0;
	$JML_KJ_BR_R_MASYARAKAT=0;
	$JML_KJ_BR_R_NAKES=0;
	$JML_P_IB_T_DUKUN=0;
	$JML_P_IB_T_KESEHATAN=0;
	$JML_KJ_N_BR_0_7HARI_KN1=0;
	$JML_KJ_N_BR_8_28HARI_KN2=0;
	$JML_K_BR_I_HAMIL=0;
	$JML_K_I_NIFAS=0;
	$JML_K_I_BERSALIN=0;
	$B_N_L_MATI=0;
	$B_N_L_HIDUP=0;
	$K_B_N_UMR_0_7_HARI=0;
	$K_B_N_UMR_8HR_1BL=0;
	$K_B_N_UMR_1BL_1THN=0;
	foreach($kia as $row){
  ?>
  <tr>
    <td><div align="center"><?=$no;?></div></td>
    <td><?=$row['PUSKESMAS'];?></td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td><?php $JML_KJ_K1_BUMIL_TEMP=$row['JML_KJ_K1_BUMIL'];$JML_KJ_K1_BUMIL=$JML_KJ_K1_BUMIL+$JML_KJ_K1_BUMIL_TEMP; echo $JML_KJ_K1_BUMIL_TEMP?></td>
    <td><?php $JML_KJ_K4_BUMIL_TEMP=$row['JML_KJ_K4_BUMIL'];$JML_KJ_K4_BUMIL=$JML_KJ_K4_BUMIL+$JML_KJ_K4_BUMIL_TEMP; echo $JML_KJ_K4_BUMIL_TEMP?></td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td><?php $JML_KJ_BR_R_MASYARAKAT_TEMP=$row['JML_KJ_BR_R_MASYARAKAT'];$JML_KJ_BR_R_MASYARAKAT=$JML_KJ_BR_R_MASYARAKAT+$JML_KJ_BR_R_MASYARAKAT_TEMP; echo $JML_KJ_BR_R_MASYARAKAT_TEMP?></td>
    <td><?php $JML_KJ_BR_R_NAKES_TEMP=$row['JML_KJ_BR_R_NAKES'];$JML_KJ_BR_R_NAKES=$JML_KJ_BR_R_NAKES+$JML_KJ_BR_R_NAKES_TEMP; echo $JML_KJ_BR_R_NAKES_TEMP?></td>
    <td><?php $JML_P_IB_T_DUKUN_TEMP=$row['JML_P_IB_T_DUKUN'];$JML_P_IB_T_DUKUN=$JML_P_IB_T_DUKUN+$JML_P_IB_T_DUKUN_TEMP; echo $JML_P_IB_T_DUKUN_TEMP?></td>
	<td><?php $JML_P_IB_T_KESEHATAN_TEMP=$row['JML_P_IB_T_KESEHATAN'];$JML_P_IB_T_KESEHATAN=$JML_P_IB_T_KESEHATAN+$JML_P_IB_T_KESEHATAN_TEMP; echo $JML_P_IB_T_KESEHATAN_TEMP?></td>
    <td><?php $JML_KJ_N_BR_0_7HARI_KN1_TEMP=$row['JML_KJ_N_BR_0_7HARI_KN1'];$JML_KJ_N_BR_0_7HARI_KN1=$JML_KJ_N_BR_0_7HARI_KN1+$JML_KJ_N_BR_0_7HARI_KN1_TEMP; echo $JML_KJ_N_BR_0_7HARI_KN1_TEMP?></td>
    <td><?php $JML_KJ_N_BR_8_28HARI_KN2_TEMP=$row['JML_KJ_N_BR_8_28HARI_KN2'];$JML_KJ_N_BR_8_28HARI_KN2=$JML_KJ_N_BR_8_28HARI_KN2+$JML_KJ_N_BR_8_28HARI_KN2_TEMP; echo $JML_KJ_N_BR_8_28HARI_KN2_TEMP?></td>
    <td><?php $JML_K_BR_I_HAMIL_TEMP=$row['JML_K_BR_I_HAMIL'];$JML_K_BR_I_HAMIL=$JML_K_BR_I_HAMIL+$JML_K_BR_I_HAMIL_TEMP; echo $JML_K_BR_I_HAMIL_TEMP?></td>
    <td><?php $JML_K_I_NIFAS_TEMP=$row['JML_K_I_NIFAS'];$JML_K_I_NIFAS=$JML_K_I_NIFAS+$JML_K_I_NIFAS_TEMP; echo $JML_K_I_NIFAS_TEMP?></td>
    <td><?php $JML_K_I_BERSALIN_TEMP=$row['JML_K_I_BERSALIN'];$JML_K_I_BERSALIN=$JML_K_I_BERSALIN+$JML_K_I_BERSALIN_TEMP; echo $JML_K_I_BERSALIN_TEMP?></td>
    <td><?php $B_N_L_MATI_TEMP=$row['B_N_L_MATI'];$B_N_L_MATI=$B_N_L_MATI+$B_N_L_MATI_TEMP; echo $B_N_L_MATI_TEMP?></td>
    <td><?php $B_N_L_HIDUP_TEMP=$row['B_N_L_HIDUP'];$B_N_L_HIDUP=$B_N_L_HIDUP+$B_N_L_HIDUP_TEMP; echo $B_N_L_HIDUP_TEMP?></td>
    <td><?php $K_B_N_UMR_0_7_HARI_TEMP=$row['K_B_N_UMR_0_7_HARI'];$K_B_N_UMR_0_7_HARI=$K_B_N_UMR_0_7_HARI+$K_B_N_UMR_0_7_HARI_TEMP; echo $K_B_N_UMR_0_7_HARI_TEMP?></td>
    <td><?php $K_B_N_UMR_8HR_1BL_TEMP=$row['K_B_N_UMR_8HR_1BL'];$K_B_N_UMR_8HR_1BL=$K_B_N_UMR_8HR_1BL+$K_B_N_UMR_8HR_1BL_TEMP; echo $K_B_N_UMR_8HR_1BL_TEMP?></td>
    <td><?php $K_B_N_UMR_1BL_1THN_TEMP=$row['K_B_N_UMR_1BL_1THN'];$K_B_N_UMR_1BL_1THN=$K_B_N_UMR_1BL_1THN+$K_B_N_UMR_1BL_1THN_TEMP; echo $K_B_N_UMR_1BL_1THN_TEMP?></td>
    <td>0</td>
  </tr>
  <?php
	$no++;
	}
  ?>
  
  <tr>
    <td colspan="2"><div align="center">JUMLAH</div></td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td><?=$JML_KJ_K1_BUMIL?></td>
    <td><?=$JML_KJ_K4_BUMIL?></td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td><?=$JML_KJ_BR_R_MASYARAKAT?></td>
    <td><?=$JML_KJ_BR_R_NAKES?></td>
    <td><?=$JML_P_IB_T_DUKUN?></td>
    <td><?=$JML_P_IB_T_KESEHATAN?></td>
    <td><?=$JML_KJ_N_BR_0_7HARI_KN1?></td>
    <td><?=$JML_KJ_N_BR_8_28HARI_KN2?></td>
    <td><?=$JML_K_BR_I_HAMIL?></td>
    <td><?=$JML_K_I_NIFAS?></td>
    <td><?=$JML_K_I_BERSALIN?></td>
    <td><?=$B_N_L_MATI?></td>
    <td><?=$B_N_L_HIDUP?></td>
    <td><?=$K_B_N_UMR_0_7_HARI?></td>
    <td><?=$K_B_N_UMR_8HR_1BL?></td>
    <td><?=$K_B_N_UMR_1BL_1THN?></td>
    <td>0</td>
    
  </tr>
</table>
</br>
<p class="style1" style="padding-left:40px;">
		
		BULAN :&nbsp <?php echo $waktu->bulan;?><br>
		TAHUN :&nbsp <?php echo $waktu->TAHUN;?><br>
		DINAS KESEHATAN KAB/KOTA  :&nbsp  <?php echo $waktu->KABUPATEN;?>
		
		</p>
<table width="1500" border="1">
  <tr>
    <td width="40" rowspan="2"><div align="center">NO</div></td>
    <td width="104" rowspan="2"><div align="center">PUSKESMAS</div></td>
    <td colspan="3"><div align="center">BERAT BAYI LAHIR</div></td>
    <td width="72" rowspan="2"><div align="center">BBLR DILAYANI NAKES</div></td>
    <td width="72" rowspan="2"><div align="center">BULIN DI RUJUK KE PUSK</div></td>
    <td width="72" rowspan="2"><div align="center">BULIN DI RUJUK KE RS</div></td>
    <td width="72" rowspan="2"><div align="center">NEONATAL RESTI</div></td>
    <td width="72" rowspan="2"><div align="center">NEONATAL RESTI DI RUJUK KE PUSK</div></td>
    <td width="72" rowspan="2"><div align="center">NEONATAL RESTI DI RUJUK KE RS</div></td>
    <td width="72" rowspan="2"><div align="center">BALITA DI DETEKSI TUMBUH KMBANGAN NYA</div></td>
    <td width="72" rowspan="2"><div align="center">ANAK DNGN KELAINAN TMBH KMBNGAN NYA</div></td>
    <td width="72" rowspan="2"><div align="center">JML TK YG ADA</div></td>
    <td width="72" rowspan="2"><div align="center">JML TK YG DIKUNJUNGI</div></td>
    <td width="72" rowspan="2"><div align="center">MURID TK YG DIPERIKSA</div></td>
    <td width="72" rowspan="2"><div align="center">MURID TK YG DIRUJUK</div></td>
    <td width="72" rowspan="2"><div align="center">BUMIL RESTI YG DIRUJUK KE PUSK</div></td>
    <td width="86" rowspan="2"><div align="center">BUMIL RESTI YG DIRUJUK KE RS</div></td>
  </tr>
  <tr>
    <td width="72" height="50"><div align="center">BBL 2500 - 3000 GR</div></td>
    <td width="72"><div align="center">BBL &gt; 3000GR</div></td>
    <td width="72"><div align="center">BBL &lt; 2500 GR</div></td>
  </tr>
  <tr>
    <td><div align="center">1</div></td>
    <td><div align="center">2</div></td>
    <td><div align="center">3</div></td>
    <td><div align="center">4</div></td>
    <td><div align="center">5</div></td>
    <td><div align="center">6</div></td>
    <td><div align="center">7</div></td>
    <td><div align="center">8</div></td>
    <td><div align="center">9</div></td>
    <td><div align="center">10</div></td>
    <td><div align="center">11</div></td>
    <td><div align="center">12</div></td>
    <td><div align="center">13</div></td>
    <td><div align="center">14</div></td>
    <td><div align="center">15</div></td>
    <td><div align="center">16</div></td>
    <td><div align="center">17</div></td>
    <td><div align="center">18</div></td>
    <td><div align="center">19</div></td>
  </tr>
   <?php
	$no=1;
	$B_N_D_BBL_2500_3000GR_p=0;
	$JML_B_N_D_BBL_L_3000GR_p=0;
	$JML_B_N_BBL_K_2500GR_p=0;
	$JML_BBLR_N_D_T_KESEHATAN_p=0;
	$JML_I_B_DRJ_PUSKESMAS=0;
	$JML_I_B_DRJ_RUMAH_SAKIT=0;
	$N_RESTI=0;
	$N_R_DRJ_PUSKESMAS=0;
	$N_R_DRJ_RS=0;
	$B_N_YG_DTK_TBH_KEMBANGNYA=0;
	$A_N_D_KLN_TBH_KEMBANG=0;
	$JML_KJ_TK_ADA=0;
	$JML_KJ_TK_DIKUNJUNGI=0;
	$M_KJ_TK_DIPERIKSA=0;
	$M_KJ_TK_DIRUJUK=0;
	$JML_B_R_R_YD_PUSKESMAS=0;
	$JML_B_R_R_YD_RUMAH_SAKIT=0;
	foreach($kia as $row){
  ?>
  <tr>
    <td><div align="center"><?=$no;?></div></td>
    <td><?=$row['PUSKESMAS'];?></td>
    <td><?php $B_N_D_BBL_2500_3000GR_p_TEMP=$row['B_N_D_BBL_2500_3000GR_p'];$B_N_D_BBL_2500_3000GR_p=$B_N_D_BBL_2500_3000GR_p+$B_N_D_BBL_2500_3000GR_p_TEMP; echo $B_N_D_BBL_2500_3000GR_p_TEMP?></td>
    <td><?php $JML_B_N_D_BBL_L_3000GR_p_TEMP=$row['JML_B_N_D_BBL_L_3000GR_p'];$JML_B_N_D_BBL_L_3000GR_p=$JML_B_N_D_BBL_L_3000GR_p+$JML_B_N_D_BBL_L_3000GR_p_TEMP; echo $JML_B_N_D_BBL_L_3000GR_p_TEMP?></td>
    <td><?php $JML_B_N_BBL_K_2500GR_p_TEMP=$row['JML_B_N_BBL_K_2500GR_p'];$JML_B_N_BBL_K_2500GR_p=$JML_B_N_BBL_K_2500GR_p+$JML_B_N_BBL_K_2500GR_p_TEMP; echo $JML_B_N_BBL_K_2500GR_p_TEMP?></td>
    <td><?php $JML_BBLR_N_D_T_KESEHATAN_p_TEMP=$row['JML_BBLR_N_D_T_KESEHATAN_p'];$JML_BBLR_N_D_T_KESEHATAN_p=$JML_BBLR_N_D_T_KESEHATAN_p+$JML_BBLR_N_D_T_KESEHATAN_p_TEMP; echo $JML_BBLR_N_D_T_KESEHATAN_p_TEMP?></td>
    <td><?php $JML_I_B_DRJ_PUSKESMAS_TEMP=$row['JML_I_B_DRJ_PUSKESMAS'];$JML_I_B_DRJ_PUSKESMAS=$JML_I_B_DRJ_PUSKESMAS+$JML_I_B_DRJ_PUSKESMAS_TEMP; echo $JML_I_B_DRJ_PUSKESMAS_TEMP?></td>
    <td><?php $JML_I_B_DRJ_RUMAH_SAKIT_TEMP=$row['JML_I_B_DRJ_RUMAH_SAKIT'];$JML_I_B_DRJ_RUMAH_SAKIT=$JML_I_B_DRJ_RUMAH_SAKIT+$JML_I_B_DRJ_RUMAH_SAKIT_TEMP; echo $JML_I_B_DRJ_RUMAH_SAKIT_TEMP?></td>
    <td><?php $N_RESTI_TEMP=$row['N_RESTI'];$N_RESTI=$N_RESTI+$N_RESTI_TEMP; echo $N_RESTI_TEMP?></td>
    <td><?php $N_R_DRJ_PUSKESMAS_TEMP=$row['N_R_DRJ_PUSKESMAS'];$N_R_DRJ_PUSKESMAS=$N_R_DRJ_PUSKESMAS+$N_R_DRJ_PUSKESMAS_TEMP; echo $N_R_DRJ_PUSKESMAS_TEMP?></td>
    <td><?php $N_R_DRJ_RS_TEMP=$row['N_R_DRJ_RS'];$N_R_DRJ_RS=$N_R_DRJ_RS+$N_R_DRJ_RS_TEMP; echo $N_R_DRJ_RS_TEMP?></td>
    <td><?php $B_N_YG_DTK_TBH_KEMBANGNYA_TEMP=$row['B_N_YG_DTK_TBH_KEMBANGNYA'];$B_N_YG_DTK_TBH_KEMBANGNYA=$B_N_YG_DTK_TBH_KEMBANGNYA+$B_N_YG_DTK_TBH_KEMBANGNYA_TEMP; echo $B_N_YG_DTK_TBH_KEMBANGNYA_TEMP?></td>
    <td><?php $A_N_D_KLN_TBH_KEMBANG_TEMP=$row['A_N_D_KLN_TBH_KEMBANG'];$A_N_D_KLN_TBH_KEMBANG=$A_N_D_KLN_TBH_KEMBANG+$A_N_D_KLN_TBH_KEMBANG_TEMP; echo $A_N_D_KLN_TBH_KEMBANG_TEMP?></td>
    <td><?php $JML_KJ_TK_ADA_TEMP=$row['JML_KJ_TK_ADA'];$JML_KJ_TK_ADA=$JML_KJ_TK_ADA+$JML_KJ_TK_ADA_TEMP; echo $JML_KJ_TK_ADA_TEMP?></td>
    <td><?php $JML_KJ_TK_DIKUNJUNGI_TEMP=$row['JML_KJ_TK_DIKUNJUNGI'];$JML_KJ_TK_DIKUNJUNGI=$JML_KJ_TK_DIKUNJUNGI+$JML_KJ_TK_DIKUNJUNGI_TEMP; echo $JML_KJ_TK_DIKUNJUNGI_TEMP?></td>
    <td><?php $M_KJ_TK_DIPERIKSA_TEMP=$row['M_KJ_TK_DIPERIKSA'];$M_KJ_TK_DIPERIKSA=$M_KJ_TK_DIPERIKSA+$M_KJ_TK_DIPERIKSA_TEMP; echo $M_KJ_TK_DIPERIKSA_TEMP?></td>
    <td><?php $M_KJ_TK_DIRUJUK_TEMP=$row['M_KJ_TK_DIRUJUK'];$M_KJ_TK_DIRUJUK=$M_KJ_TK_DIRUJUK+$M_KJ_TK_DIRUJUK_TEMP; echo $M_KJ_TK_DIRUJUK_TEMP?></td>
    <td><?php $JML_B_R_R_YD_PUSKESMAS_TEMP=$row['JML_B_R_R_YD_PUSKESMAS'];$JML_B_R_R_YD_PUSKESMAS=$JML_B_R_R_YD_PUSKESMAS+$JML_B_R_R_YD_PUSKESMAS_TEMP; echo $JML_B_R_R_YD_PUSKESMAS_TEMP?></td>
    <td><?php $JML_B_R_R_YD_RUMAH_SAKIT_TEMP=$row['JML_B_R_R_YD_RUMAH_SAKIT'];$JML_B_R_R_YD_RUMAH_SAKIT=$JML_B_R_R_YD_RUMAH_SAKIT+$JML_B_R_R_YD_RUMAH_SAKIT_TEMP; echo $JML_B_R_R_YD_RUMAH_SAKIT_TEMP?></td>
  </tr>
  <?php
	$no++;
	}
  ?>
 
  <tr>
    <td colspan="2"><div align="center">JUMLAH</div></td>
    <td><?=$B_N_D_BBL_2500_3000GR_p?></td>
    <td><?=$JML_B_N_D_BBL_L_3000GR_p?></td>
    <td><?=$JML_B_N_BBL_K_2500GR_p?></td>
    <td><?=$JML_BBLR_N_D_T_KESEHATAN_p?></td>
    <td><?=$JML_I_B_DRJ_PUSKESMAS?></td>
    <td><?=$JML_I_B_DRJ_RUMAH_SAKIT?></td>
    <td><?=$N_RESTI?></td>
    <td><?=$N_R_DRJ_PUSKESMAS?></td>
    <td><?=$N_R_DRJ_RS?></td>
    <td><?=$B_N_YG_DTK_TBH_KEMBANGNYA?></td>
    <td><?=$A_N_D_KLN_TBH_KEMBANG?></td>
    <td><?=$JML_KJ_TK_ADA?></td>
    <td><?=$JML_KJ_TK_DIKUNJUNGI?></td>
    <td><?=$M_KJ_TK_DIPERIKSA?></td>
    <td><?=$M_KJ_TK_DIRUJUK?></td>
    <td><?=$JML_B_R_R_YD_PUSKESMAS?></td>
    <td><?=$JML_B_R_R_YD_RUMAH_SAKIT?></td>
  </tr>
</table>
</body>
</html>
