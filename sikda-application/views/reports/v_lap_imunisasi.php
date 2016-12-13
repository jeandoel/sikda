<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN IMUNISASI</title>
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
.style1 {font-size: 10px}
.style2 {font-size: xx-small}
</style>
</head>

<body>
<div>
	<span><b>LAPORAN  BULANAN  IMUNISASI</b></span>
	<span><br>
	BULAN : <?php echo $waktu->BULAN;?></span>
	<span><br>
	TAHUN : <?php echo $waktu->TAHUN;?></span>
	<span><br>
	DINAS KESEHATAN KAB/KOTA : <?php echo $waktu->KABUPATEN;?></span>
	<br>
	<span></span>
	<br>
</div>
<table width="1200" border="1" style="font-size: 12px">
  <tr style="font-weight: bold">
    <td rowspan="2" align="center">NO</td>
    <td rowspan="2" align="center">PUSKESMAS</td>
    <td rowspan="2" align="center">BCG</td>
    <td colspan="3" align="center">VAKSINASI DPT </td>
    <td colspan="4" align="center">VAKSINASI POLIO </td>
    <td rowspan="2" align="center">CAMPAK</td>
    <td colspan="4" align="center">VAKSINASI Hb UNIJECT </td>
    <td colspan="3" align="center">VAKSINASI Hb VIAL </td>
    <td colspan="5" align="center">STATUS T1-T5 IBU HAMIL </td>
    <td colspan="5" align="center">STATUS T1-T5 WUS </td>
    <td colspan="2" align="center">DT ANAK </td>
  </tr>
  <tr style="font-weight: bold">
    <td align="center">1</td>
    <td align="center">2</td>
    <td align="center">3</td>
    <td align="center">1</td>
    <td align="center">2</td>
    <td align="center">3</td>
    <td align="center">4</td>
    <td align="center">&lt; 7 Hr </td>
    <td align="center">&gt; 7 Hr </td>
    <td align="center">2</td>
    <td align="center">3</td>
    <td align="center">1</td>
    <td align="center">2</td>
    <td align="center">3</td>
    <td align="center">TT1</td>
    <td align="center">TT2</td>
    <td align="center">TT3</td>
    <td align="center">TT4</td>
    <td align="center">TT5</td>
    <td align="center">TT1</td>
    <td align="center">TT2</td>
    <td align="center">TT3</td>
    <td align="center">TT4</td>
    <td align="center">TT5</td>
    <td align="center">DT1</td>
    <td align="center">DT2</td>
  </tr>
  <tr style="font-weight: bold">
    <td align="center">1</td>
    <td align="center">2</td>
    <td align="center">3</td>
    <td align="center">4</td>
    <td align="center">5</td>
    <td align="center">6</td>
    <td align="center">7</td>
    <td align="center">8</td>
    <td align="center">9</td>
    <td align="center">10</td>
    <td align="center">11</td>
    <td align="center">12</td>
    <td align="center">13</td>
    <td align="center">14</td>
    <td align="center">15</td>
    <td align="center">16</td>
    <td align="center">17</td>
    <td align="center">18</td>
    <td align="center">19</td>
    <td align="center">20</td>
    <td align="center">21</td>
    <td align="center">22</td>
    <td align="center">23</td>
    <td align="center">24</td>
    <td align="center">25</td>
    <td align="center">26</td>
    <td align="center">27</td>
    <td align="center">28</td>
    <td align="center">29</td>
    <td align="center">30</td>
  </tr>
  <?php
  $no=1;
  $JML_BCG=0;
  $JML_DPT1=0;
  $JML_DPT2=0;
  $JML_DPT3=0;
  $JML_POLIO1=0;
  $JML_POLIO2=0;
  $JML_POLIO3=0;
  $JML_POLIO4=0;
  $JML_CAMPAK=0;
  $JML_UNIJECT_P7=0;
  $JML_UNIJECT_M7=0;
  $JML_UNIJECT_2=0;
  $JML_UNIJECT_3=0;
  $JML_VIAL_1=0;
  $JML_VIAL_2=0;
  $JML_VIAL_3=0;
  $JML_H_1=0;
  $JML_H_2=0;
  $JML_H_3=0;
  $JML_H_4=0;
  $JML_H_5=0;
  $JML_W_1=0;
  $JML_W_2=0;
  $JML_W_3=0;
  $JML_W_4=0;
  $JML_W_5=0;
  $JML_VDT1=0;
  $JML_VDT2=0;
  foreach ($imun as $row){
  ?>
  <tr align="center">
    <td><?php echo $no;?></td>
    <td><?php echo $row['PUSKESMAS'];?></td>
    <td><?php $JML_BCG_TEMP= $row['JML_IMUN_BCG_L']+$row['JML_IMUN_BCG_P']; $JML_BCG=$JML_BCG+$JML_BCG_TEMP; echo $JML_BCG_TEMP?></td>
    <td><?php $JML_DPT1_TEMP = $row['JML_IMUN_DPT1_L']+$row['JML_IMUN_DPT1_P'];$JML_DPT1 = $JML_DPT1 + $JML_DPT1_TEMP; echo $JML_DPT1_TEMP?></td>
    <td><?php $JML_DPT2_TEMP = $row['JML_IMUN_DPT2_L']+$row['JML_IMUN_DPT2_P'];$JML_DPT2 = $JML_DPT2 + $JML_DPT2_TEMP; echo $JML_DPT2_TEMP?></td>
    <td><?php $JML_DPT3_TEMP = $row['JML_IMUN_DPT3_L']+$row['JML_IMUN_DPT3_P'];$JML_DPT3 = $JML_DPT3 + $JML_DPT3_TEMP; echo $JML_DPT3_TEMP?></td>
    <td><?php $JML_POLIO1_TEMP = $row['JML_IMUN_POLIO1_L']+$row['JML_IMUN_POLIO1_P']; $JML_POLIO1 = $JML_POLIO1 + $JML_POLIO1_TEMP; echo $JML_POLIO1_TEMP?></td>
    <td><?php $JML_POLIO2_TEMP = $row['JML_IMUN_POLIO2_L']+$row['JML_IMUN_POLIO2_P']; $JML_POLIO2 = $JML_POLIO2 + $JML_POLIO2_TEMP; echo $JML_POLIO2_TEMP?></td>
    <td><?php $JML_POLIO3_TEMP = $row['JML_IMUN_POLIO3_L']+$row['JML_IMUN_POLIO3_P']; $JML_POLIO3 = $JML_POLIO3 + $JML_POLIO3_TEMP; echo $JML_POLIO3_TEMP?></td>
    <td><?php $JML_POLIO4_TEMP = $row['JML_IMUN_POLIO4_L']+$row['JML_IMUN_POLIO4_P']; $JML_POLIO4 = $JML_POLIO4 + $JML_POLIO4_TEMP; echo $JML_POLIO4_TEMP?></td>
    <td><?php $JML_CAMPAK_TEMP = $row['JML_IMUN_CAMPAK_L']+$row['JML_IMUN_CAMPAK_P']; $JML_CAMPAK = $JML_CAMPAK + $JML_CAMPAK_TEMP; echo $JML_CAMPAK_TEMP?></td>
    <td><?php $JML_UNIJECT_M7_TEMP = $row['JML_IMUN_HBU_M7_L']+$row['JML_IMUN_HBU_M7_P']; $JML_UNIJECT_M7 = $JML_UNIJECT_M7 + $JML_UNIJECT_M7_TEMP; echo $JML_UNIJECT_M7_TEMP?></td>
    <td><?php $JML_UNIJECT_P7_TEMP = $row['JML_IMUN_HBU_P7_L']+$row['JML_IMUN_HBU_P7_P']; $JML_UNIJECT_P7 = $JML_UNIJECT_P7 + $JML_UNIJECT_P7_TEMP; echo $JML_UNIJECT_P7_TEMP?></td>
    <td><?php $JML_UNIJECT_2_TEMP = $row['JML_IMUN_HB_UNIJECT2_L']+$row['JML_IMUN_HB_UNIJECT2_P']; $JML_UNIJECT_2 = $JML_UNIJECT_2 + $JML_UNIJECT_2_TEMP; echo $JML_UNIJECT_2_TEMP?></td>
    <td><?php $JML_UNIJECT_3_TEMP = $row['JML_IMUN_HB_UNIJECT3_L']+$row['JML_IMUN_HB_UNIJECT3_P']; $JML_UNIJECT_3 = $JML_UNIJECT_3 + $JML_UNIJECT_3_TEMP; echo $JML_UNIJECT_3_TEMP?></td>
    <td><?php $JML_VIAL_1_TEMP = $row['JML_IMUN_HB_VIAL1_L']+$row['JML_IMUN_HB_VIAL1_P']; $JML_VIAL_1 = $JML_VIAL_1 + $JML_VIAL_1_TEMP; echo $JML_VIAL_1_TEMP?></td>
    <td><?php $JML_VIAL_2_TEMP = $row['JML_IMUN_HB_VIAL2_L']+$row['JML_IMUN_HB_VIAL2_P']; $JML_VIAL_2 = $JML_VIAL_2 + $JML_VIAL_2_TEMP; echo $JML_VIAL_2_TEMP?></td>
    <td><?php $JML_VIAL_3_TEMP = $row['JML_IMUN_HB_VIAL3_L']+$row['JML_IMUN_HB_VIAL3_P']; $JML_VIAL_3 = $JML_VIAL_3 + $JML_VIAL_3_TEMP; echo $JML_VIAL_3_TEMP?></td>
    <td><?php $JML_H_1_TEMP = $row['JML_IMUN_TT1_HAMIL_P']; $JML_H_1 = $JML_H_1 + $JML_H_1_TEMP; echo$JML_H_1_TEMP?></td>
    <td><?php $JML_H_2_TEMP = $row['JML_IMUN_TT2_HAMIL_P']; $JML_H_2 = $JML_H_2 + $JML_H_2_TEMP; echo$JML_H_2_TEMP?></td>
    <td><?php $JML_H_3_TEMP = $row['JML_IMUN_TT3_HAMIL_P']; $JML_H_3 = $JML_H_3 + $JML_H_3_TEMP; echo$JML_H_3_TEMP?></td>
    <td><?php $JML_H_4_TEMP = $row['JML_IMUN_TT4_HAMIL_P']; $JML_H_4 = $JML_H_4 + $JML_H_4_TEMP; echo$JML_H_4_TEMP?></td>
    <td><?php $JML_H_5_TEMP = $row['JML_IMUN_TT5_HAMIL_P']; $JML_H_5 = $JML_H_5 + $JML_H_5_TEMP; echo$JML_H_5_TEMP?></td>
    <td><?php $JML_W_1_TEMP = $row['JML_IMUN_TT1_WUS_P']; $JML_W_1 = $JML_W_1 + $JML_W_1_TEMP; echo $JML_W_1_TEMP?></td>
    <td><?php $JML_W_2_TEMP = $row['JML_IMUN_TT2_WUS_P']; $JML_W_2 = $JML_W_2 + $JML_W_2_TEMP; echo $JML_W_2_TEMP?></td>
    <td><?php $JML_W_3_TEMP = $row['JML_IMUN_TT3_WUS_P']; $JML_W_3 = $JML_W_3 + $JML_W_3_TEMP; echo $JML_W_3_TEMP?></td>
    <td><?php $JML_W_4_TEMP = $row['JML_IMUN_TT4_WUS_P']; $JML_W_4 = $JML_W_4 + $JML_W_4_TEMP; echo $JML_W_4_TEMP?></td>
    <td><?php $JML_W_5_TEMP = $row['JML_IMUN_TT5_WUS_P']; $JML_W_5 = $JML_W_5 + $JML_W_5_TEMP; echo $JML_W_5_TEMP?></td>
    <td><?php $JML_VDT1_TEMP = $row['JML_VDT1_ANAKSEKOLAH']; $JML_VDT1 = $JML_VDT1 + $JML_VDT1_TEMP; echo $JML_VDT1_TEMP?></td>
    <td><?php $JML_VDT2_TEMP = $row['JML_VDT2_ANAKSEKOLAH']; $JML_VDT2 = $JML_VDT2 + $JML_VDT2_TEMP; echo $JML_VDT2_TEMP?></td>
  </tr>
  <?php
  $no++;
  }
  ?>
  <tr align="center">
    <td colspan="2" align="center">JUMLAH</td>
    <td><?php echo $JML_BCG;?></td>
    <td><?php echo $JML_DPT1;?></td>
    <td><?php echo $JML_DPT2;?></td>
    <td><?php echo $JML_DPT3;?></td>
    <td><?php echo $JML_POLIO1;?></td>
    <td><?php echo $JML_POLIO2;?></td>
    <td><?php echo $JML_POLIO3;?></td>
    <td><?php echo $JML_POLIO4;?></td>
    <td><?php echo $JML_CAMPAK;?></td>
    <td><?php echo $JML_UNIJECT_M7;?></td>
    <td><?php echo $JML_UNIJECT_P7?></td>
    <td><?php echo $JML_UNIJECT_2;?></td>
    <td><?php echo $JML_UNIJECT_3;?></td>
    <td><?php echo $JML_VIAL_1;?></td>
    <td><?php echo $JML_VIAL_2;?></td>
    <td><?php echo $JML_VIAL_3;?></td>
    <td><?php echo $JML_H_1;?></td>
    <td><?php echo $JML_H_2;?></td>
    <td><?php echo $JML_H_3;?></td>
    <td><?php echo $JML_H_4;?></td>
    <td><?php echo $JML_H_5;?></td>
    <td><?php echo $JML_W_1;?></td>
    <td><?php echo $JML_W_2;?></td>
    <td><?php echo $JML_W_3;?></td>
    <td><?php echo $JML_W_4;?></td>
    <td><?php echo $JML_W_5;?></td>
    <td><?php echo $JML_VDT1;?></td>
    <td><?php echo $JML_VDT2;?></td>
  </tr>
  
</table>
</body>
</html>
