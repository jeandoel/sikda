<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN KB</title>
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
	<span><b>LAPORAN  BULANAN  KB</b></span>
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
<table width="200" border="1" style="font-size: 11px">
  <tr style="font-weight: bold">
    <td rowspan="2" align="center">NO</td>
    <td rowspan="2" align="center">PUSKESMAS</td>
    <td rowspan="2" align="center">SASARAN PMPB </td>
    <td colspan="9" align="center">AKSEPTOR BARU </td>
    <td rowspan="2" align="center">JUMLAH PUS </td>
    <td colspan="9" align="center">AKSEPTOR AKTIF </td>
    <td colspan="9" align="center">EFEK SAMPING </td>
    <td colspan="9" align="center">KEGAGALAN</td>
    <td rowspan="2" align="center">PENYULUHAN KRR </td>
    <td rowspan="2" align="center">KONSELING REMAJA </td>
    <td rowspan="2" align="center">REMAJA BERMASALAH </td>
  </tr>
  <tr style="font-weight: bold">
    <td align="center">IUD</td>
    <td align="center">MOW</td>
    <td align="center">MOP</td>
    <td align="center">IMPLANT</td>
    <td align="center">SUNTIK</td>
    <td align="center">PIL</td>
    <td align="center">KONDOM</td>
    <td align="center">JUMLAH</td>
    <td align="center">PERSEN</td>
    <td align="center">IUD</td>
    <td align="center">MOW</td>
    <td align="center">MOP</td>
    <td align="center">IMPLANT</td>
    <td align="center">SUNTIK</td>
    <td align="center">PIL</td>
    <td align="center">KONDOM</td>
    <td align="center">JUMLAH</td>
    <td align="center">PERSEN</td>
    <td align="center">IUD</td>
    <td align="center">MOW</td>
    <td align="center">MOP</td>
    <td align="center">IMPLANT</td>
    <td align="center">SUNTIK</td>
    <td align="center">PIL</td>
    <td align="center">KONDOM</td>
    <td align="center">JUMLAH</td>
    <td align="center">PERSEN</td>
    <td align="center">IUD</td>
    <td align="center">MOW</td>
    <td align="center">MOP</td>
    <td align="center">IMPLANT</td>
    <td align="center">SUNTIK</td>
    <td align="center">PIL</td>
    <td align="center">KONDOM</td>
    <td align="center">JUMLAH</td>
    <td align="center">PERSEN</td>
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
    <td align="center">31</td>
    <td align="center">32</td>
    <td align="center">33</td>
    <td align="center">34</td>
    <td align="center">35</td>
    <td align="center">36</td>
    <td align="center">37</td>
    <td align="center">38</td>
    <td align="center">39</td>
    <td align="center">40</td>
    <td align="center">41</td>
    <td align="center">42</td>
    <td align="center">43</td>
  </tr>
  <?php
  $no=1;
  $PMPB=0;
  $JML_PUS=0;
  $JML_B_IUD=0;
  $JML_B_MOW=0;
  $JML_B_MOP=0;
  $JML_B_IMPLANT=0;
  $JML_B_SUNTIK=0;
  $JML_B_PIL=0;
  $JML_B_KONDOM=0;
  $TOTAL_JML_B=0;
  $TOTAL_PERSEN_B=0;
  $JML_A_IUD=0;
  $JML_A_MOW=0;
  $JML_A_MOP=0;
  $JML_A_IMPLANT=0;
  $JML_A_SUNTIK=0;
  $JML_A_PIL=0;
  $JML_A_KONDOM=0;
  $TOTAL_JML_A=0;
  $TOTAL_PERSEN_A=0;
  $JML_E_IUD=0;
  $JML_E_MOW=0;
  $JML_E_MOP=0;
  $JML_E_IMPLANT=0;
  $JML_E_SUNTIK=0;
  $JML_E_PIL=0;
  $JML_E_KONDOM=0;
  $TOTAL_JML_E=0;
  $TOTAL_PERSEN_E=0;
  $JML_G_IUD=0;
  $JML_G_MOW=0;
  $JML_G_MOP=0;
  $JML_G_IMPLANT=0;
  $JML_G_SUNTIK=0;
  $JML_G_PIL=0;
  $JML_G_KONDOM=0;
  $TOTAL_JML_G=0;
  $TOTAL_PERSEN_G=0;
  $JML_KRR=0;
  $JML_KONSEL=0;
  $JML_RMJ=0;
  foreach ($kb as $row){
  ?>
  <tr align="center" style="font-size: 11px">
    <td><?php echo $no;?></td>
    <td><?php echo $row['PUSKESMAS'];?></td>
    <td><?php echo $PMPB;?></td>
    <td><?php $JML_B_IUD_TEMP = $row['AKS_BDAK_IUD']; $JML_B_IUD = $JML_B_IUD + $JML_B_IUD_TEMP; echo $JML_B_IUD_TEMP;?></td>
    <td><?php $JML_B_MOW_TEMP = $row['AKS_BDAK_MOW']; $JML_B_MOW = $JML_B_MOW + $JML_B_MOW_TEMP; echo $JML_B_MOW_TEMP;?></td>
    <td><?php $JML_B_MOP_TEMP = $row['AKS_BDAK_MOP']; $JML_B_MOP = $JML_B_MOP + $JML_B_MOP_TEMP; echo $JML_B_MOP_TEMP;?></td>
    <td><?php $JML_B_IMPLANT_TEMP = $row['AKS_BDAK_IMPLANT']; $JML_B_IMPLANT = $JML_B_IMPLANT + $JML_B_IMPLANT_TEMP; echo $JML_B_IMPLANT_TEMP;?></td>
    <td><?php $JML_B_SUNTIK_TEMP = $row['AKS_BDAK_SUNTIK']; $JML_B_SUNTIK = $JML_B_SUNTIK + $JML_B_SUNTIK_TEMP; echo $JML_B_SUNTIK_TEMP;?></td>
    <td><?php $JML_B_PIL_TEMP = $row['AKS_BDAK_PIL']; $JML_B_PIL = $JML_B_PIL + $JML_B_PIL_TEMP; echo $JML_B_PIL_TEMP;?></td>
    <td><?php $JML_B_KONDOM_TEMP = $row['AKS_BDAK_KONDOM']; $JML_B_KONDOM = $JML_B_KONDOM + $JML_B_KONDOM_TEMP; echo $JML_B_KONDOM_TEMP;?></td>
    <td><?php $TOTAL_JML_B_TEMP = $row['AKS_BDAK_IUD']+$row['AKS_BDAK_MOW']+$row['AKS_BDAK_MOP']+$row['AKS_BDAK_IMPLANT']+$row['AKS_BDAK_SUNTIK']+$row['AKS_BDAK_PIL']+$row['AKS_BDAK_KONDOM'];  $TOTAL_JML_B = $TOTAL_JML_B + $TOTAL_JML_B_TEMP; echo $TOTAL_JML_B_TEMP;?></td>
    <td><?php $TOTAL_PERSEN_B_TEMP = $row['AKS_BDAK_IUD']+$row['AKS_BDAK_MOW']+$row['AKS_BDAK_MOP']+$row['AKS_BDAK_IMPLANT']+$row['AKS_BDAK_SUNTIK']+$row['AKS_BDAK_PIL']+$row['AKS_BDAK_KONDOM']; $TOTAL_PERSEN_B = $TOTAL_PERSEN_B + $TOTAL_PERSEN_B_TEMP; echo $TOTAL_PERSEN_B_TEMP;?></td>
    <td><?php echo $JML_PUS;?></td>
    <td><?php $JML_A_IUD_TEMP = $row['AKS_ADA_IUD']; $JML_A_IUD = $JML_A_IUD + $JML_A_IUD_TEMP; echo $JML_A_IUD_TEMP;?></td>
    <td><?php $JML_A_MOW_TEMP = $row['AKS_ADA_MOW']; $JML_A_MOW = $JML_A_MOW + $JML_A_MOW_TEMP; echo $JML_A_MOW_TEMP;?></td>
    <td><?php $JML_A_MOP_TEMP = $row['AKS_ADA_MOP']; $JML_A_MOP = $JML_A_MOP + $JML_A_MOP_TEMP; echo $JML_A_MOP_TEMP;?></td>
    <td><?php $JML_A_IMPLANT_TEMP = $row['AKS_ADA_IMPLANT']; $JML_A_IMPLANT = $JML_A_IMPLANT + $JML_A_IMPLANT_TEMP; echo $JML_A_IMPLANT_TEMP;?></td>
    <td><?php $JML_A_SUNTIK_TEMP = $row['AKS_ADA_SUNTIK']; $JML_A_SUNTIK = $JML_A_SUNTIK + $JML_A_SUNTIK_TEMP; echo $JML_A_SUNTIK_TEMP;?></td>
    <td><?php $JML_A_PIL_TEMP = $row['AKS_ADA_PIL']; $JML_A_PIL = $JML_A_PIL + $JML_A_PIL_TEMP; echo $JML_A_PIL_TEMP;?></td>
    <td><?php $JML_A_KONDOM_TEMP = $row['AKS_ADA_KONDOM']; $JML_A_KONDOM = $JML_A_KONDOM + $JML_A_KONDOM_TEMP; echo $JML_A_KONDOM_TEMP;?></td>
    <td><?php $TOTAL_JML_A_TEMP = $row['AKS_ADA_IUD']+$row['AKS_ADA_MOW']+$row['AKS_ADA_MOP']+$row['AKS_ADA_IMPLANT']+$row['AKS_ADA_SUNTIK']+$row['AKS_ADA_PIL']+$row['AKS_ADA_KONDOM'];  $TOTAL_JML_A = $TOTAL_JML_A + $TOTAL_JML_A_TEMP; echo $TOTAL_JML_A_TEMP;?></td>
    <td><?php $TOTAL_PERSEN_A_TEMP = $row['AKS_ADA_IUD']+$row['AKS_ADA_MOW']+$row['AKS_ADA_MOP']+$row['AKS_ADA_IMPLANT']+$row['AKS_ADA_SUNTIK']+$row['AKS_ADA_PIL']+$row['AKS_ADA_KONDOM'];  $TOTAL_PERSEN_A = $TOTAL_PERSEN_A + $TOTAL_PERSEN_A_TEMP; echo $TOTAL_PERSEN_A_TEMP;?></td>
    <td><?php $JML_E_IUD_TEMP = $JML_E_IUD + $row['EFK_SMK_IUD']; $JML_E_IUD = $JML_E_IUD + $JML_E_IUD_TEMP; echo $JML_E_IUD_TEMP;?></td>
    <td><?php $JML_E_MOW_TEMP = $JML_E_MOW + $row['EFK_SMK_MOW']; $JML_E_MOW = $JML_E_MOW + $JML_E_MOW_TEMP; echo $JML_E_MOW_TEMP;?></td>
    <td><?php $JML_E_MOP_TEMP = $JML_E_MOP + $row['EFK_SMK_MOP']; $JML_E_MOP = $JML_E_MOP + $JML_E_MOP_TEMP; echo $JML_E_MOP_TEMP;?></td>
    <td><?php $JML_E_IMPLANT_TEMP = $JML_E_IMPLANT + $row['EFK_SMK_IMPLANT']; $JML_E_IMPLANT = $JML_E_IMPLANT + $JML_E_IMPLANT_TEMP; echo $JML_E_IMPLANT_TEMP;?></td>
    <td><?php $JML_E_SUNTIK_TEMP = $JML_E_SUNTIK + $row['EFK_SMK_SUNTIK']; $JML_E_SUNTIK = $JML_E_SUNTIK + $JML_E_SUNTIK_TEMP; echo $JML_E_SUNTIK_TEMP;?></td>
    <td><?php $JML_E_PIL_TEMP = $JML_E_PIL + $row['EFK_SMK_PIL']; $JML_E_PIL = $JML_E_PIL + $JML_E_PIL_TEMP; echo $JML_E_PIL_TEMP;?></td>
    <td><?php $JML_E_KONDOM_TEMP = $JML_E_KONDOM + $row['EFK_SMK_KONDOM']; $JML_E_KONDOM = $JML_E_KONDOM + $JML_E_KONDOM_TEMP; echo $JML_E_KONDOM_TEMP;?></td>
    <td><?php $TOTAL_JML_E_TEMP = $row['EFK_SMK_IUD']+$row['EFK_SMK_MOW']+$row['EFK_SMK_MOP']+$row['EFK_SMK_IMPLANT']+$row['EFK_SMK_SUNTIK']+$row['EFK_SMK_PIL']+$row['EFK_SMK_KONDOM']; $TOTAL_JML_E = $TOTAL_JML_E + $TOTAL_JML_E_TEMP; echo $TOTAL_JML_E_TEMP;?></td>
    <td><?php $TOTAL_PERSEN_E_TEMP = $row['EFK_SMK_IUD']+$row['EFK_SMK_MOW']+$row['EFK_SMK_MOP']+$row['EFK_SMK_IMPLANT']+$row['EFK_SMK_SUNTIK']+$row['EFK_SMK_PIL']+$row['EFK_SMK_KONDOM']; $TOTAL_PERSEN_E = $TOTAL_PERSEN_E + $TOTAL_PERSEN_E_TEMP; echo $TOTAL_PERSEN_E_TEMP;?></td>
    <td><?php $JML_G_IUD_TEMP = $JML_G_IUD + $row['KGL_MK_IUD']; $JML_G_IUD = $JML_G_IUD + $JML_G_IUD_TEMP; echo $JML_G_IUD_TEMP;?></td>
    <td><?php $JML_G_MOW_TEMP = $JML_G_MOW + $row['KGL_MK_MOW']; $JML_G_MOW = $JML_G_MOW + $JML_G_MOW_TEMP; echo $JML_G_MOW_TEMP;?></td>
    <td><?php $JML_G_MOP_TEMP = $JML_G_MOP + $row['KGL_MK_MOP']; $JML_G_MOP = $JML_G_MOP + $JML_G_MOP_TEMP; echo $JML_G_MOP_TEMP;?></td>
    <td><?php $JML_G_IMPLANT_TEMP = $JML_G_IMPLANT + $row['KGL_MK_IMPLANT']; $JML_G_IMPLANT = $JML_G_IMPLANT + $JML_G_IMPLANT_TEMP; echo $JML_G_IMPLANT_TEMP;?></td>
    <td><?php $JML_G_SUNTIK_TEMP = $JML_G_SUNTIK + $row['KGL_MK_SUNTIK']; $JML_G_SUNTIK = $JML_G_SUNTIK + $JML_G_SUNTIK_TEMP; echo $JML_G_SUNTIK_TEMP;?></td>
    <td><?php $JML_G_PIL_TEMP = $JML_G_PIL + $row['KGL_MK_PIL']; $JML_G_PIL = $JML_G_PIL + $JML_G_PIL_TEMP; echo $JML_G_PIL_TEMP;?></td>
    <td><?php $JML_G_KONDOM_TEMP = $JML_G_KONDOM + $row['KGL_MK_KONDOM']; $JML_G_KONDOM = $JML_G_KONDOM + $JML_G_KONDOM_TEMP; echo $JML_G_KONDOM_TEMP;?></td>
    <td><?php $TOTAL_JML_G_TEMP = $row['KGL_MK_IUD']+$row['KGL_MK_MOW']+$row['KGL_MK_MOP']+$row['KGL_MK_IMPLANT']+$row['KGL_MK_SUNTIK']+$row['KGL_MK_PIL']+$row['KGL_MK_KONDOM']; $TOTAL_JML_G = $TOTAL_JML_G + $TOTAL_JML_G_TEMP; echo $TOTAL_JML_G_TEMP;?></td>
    <td><?php $TOTAL_PERSEN_G_TEMP = $row['KGL_MK_IUD']+$row['KGL_MK_MOW']+$row['KGL_MK_MOP']+$row['KGL_MK_IMPLANT']+$row['KGL_MK_SUNTIK']+$row['KGL_MK_PIL']+$row['KGL_MK_KONDOM']; $TOTAL_PERSEN_G = $TOTAL_PERSEN_G + $TOTAL_PERSEN_G_TEMP; echo $TOTAL_PERSEN_G_TEMP;?></td>
    <td><?php $JML_KRR_TEMP = $row['JML_RYMP_KRR']; $JML_KRR = $JML_KRR + $JML_KRR_TEMP; echo $JML_KRR_TEMP;?></td>
    <td><?php $JML_KONSEL_TEMP = $row['JML_PK_REMAJA']; $JML_KONSEL = $JML_KONSEL + $JML_KONSEL_TEMP; echo $JML_KONSEL_TEMP;?></td>
    <td><?php $JML_RMJ_TEMP = $row['JML_BRBY_DITANGANI']; $JML_RMJ = $JML_RMJ + $JML_RMJ_TEMP; echo $JML_RMJ_TEMP;?></td>
  </tr>
   <?php
  $no++;
  }
  ?>
  <tr align="center">
    <td colspan="2" align="center">JUMLAH</td>
    <td><?php echo $PMPB;?></td>
    <td><?php echo $JML_B_IUD?></td>
    <td><?php echo $JML_B_MOW;?></td>
    <td><?php echo $JML_B_MOP;?></td>
    <td><?php echo $JML_B_IMPLANT;?></td>
    <td><?php echo $JML_B_SUNTIK;?></td>
    <td><?php echo $JML_B_PIL;?></td>
    <td><?php echo $JML_B_KONDOM;?></td>
    <td><?php echo $TOTAL_JML_B;?></td>
    <td><?php echo $TOTAL_PERSEN_B;?></td>
    <td><?php echo $JML_PUS;?></td>
    <td><?php echo $JML_A_IUD?></td>
    <td><?php echo $JML_A_MOW;?></td>
    <td><?php echo $JML_A_MOP;?></td>
    <td><?php echo $JML_A_IMPLANT;?></td>
    <td><?php echo $JML_A_SUNTIK;?></td>
    <td><?php echo $JML_A_PIL;?></td>
    <td><?php echo $JML_A_KONDOM;?></td>
    <td><?php echo $TOTAL_JML_A;?></td>
    <td><?php echo $TOTAL_PERSEN_A;?></td>
    <td><?php echo $JML_E_IUD?></td>
    <td><?php echo $JML_E_MOW;?></td>
    <td><?php echo $JML_E_MOP;?></td>
    <td><?php echo $JML_E_IMPLANT;?></td>
    <td><?php echo $JML_E_SUNTIK;?></td>
    <td><?php echo $JML_E_PIL;?></td>
    <td><?php echo $JML_E_KONDOM;?></td>
    <td><?php echo $TOTAL_JML_E;?></td>
    <td><?php echo $TOTAL_PERSEN_E;?></td>
    <td><?php echo $JML_G_IUD?></td>
    <td><?php echo $JML_G_MOW;?></td>
    <td><?php echo $JML_G_MOP;?></td>
    <td><?php echo $JML_G_IMPLANT;?></td>
    <td><?php echo $JML_G_SUNTIK;?></td>
    <td><?php echo $JML_G_PIL;?></td>
    <td><?php echo $JML_G_KONDOM;?></td>
    <td><?php echo $TOTAL_JML_G;?></td>
    <td><?php echo $TOTAL_PERSEN_G;?></td>
    <td><?php echo $JML_KRR;?></td>
    <td><?php echo $JML_KONSEL;?></td>
    <td><?php echo $JML_RMJ;?></td>
  </tr>
 
</table>
</body>
</html>
