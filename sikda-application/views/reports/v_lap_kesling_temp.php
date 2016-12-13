<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>laporan Bulanan Kesling</title>
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
<table width="700" border="1">
  <tr>
    <td width="19" rowspan="3"><div align="center">NO</div></td>
    <td width="72" rowspan="3"><div align="center">PUSKESMAS</div></td>
    <td colspan="8"><div align="center">PENYEHATAN LINGKUNGAN SEKOLAH</div></td>
    <td colspan="2"><div align="center">TEMPAT</div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">SD/MI</div></td>
    <td colspan="2"><div align="center">SLTP/MTS</div></td>
    <td colspan="2"><div align="center">SLTA/MA</div></td>
    <td colspan="2"><div align="center">PT</div></td>
    <td colspan="2"><div align="center">KIOS/KUD</div></td>
  </tr>
  <tr>
    <td width="63">DIPERIKSA</td>
    <td width="30"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="43"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="46"><div align="center">MS</div></td>
    <td width="63">DIPERIKSA</td>
    <td width="52"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="47"><div align="center">MS</div></td>
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
  </tr>
  <?php
	$no=1;
	$SD_MI=0;
	$SD_MI_MS=0;
	$SLTP_MTS=0;
	$SLTP_MTS_MS=0;
	$SLTA_MA=0;
	$SLTA_MA_MS=0;
	$PERGURUAN_TINGGI=0;
	$PERGURUAN_TINGGI_MS=0;
	$KIOS_KUD=0;
	$KIOS_KUD_MS=0;
	foreach($kesling as $row){
  ?>
  <tr>
    <td><div align="center"><?=$no;?></div></td>
    <td><?=$row['PUSKESMAS'];?></td>
    <td><?php $SD_MI_TEMP=$row['SD_MI'];$SD_MI=$SD_MI+$SD_MI_TEMP; echo $SD_MI_TEMP?></td>
    <td><?php $SD_MI_MS_TEMP=$row['SD_MI_MS'];$SD_MI_MS=$SD_MI_MS+$SD_MI_MS_TEMP; echo $SD_MI_MS_TEMP?></td>
    <td><?php $SLTP_MTS_TEMP=$row['SLTP_MTS'];$SLTP_MTS=$SLTP_MTS+$SLTP_MTS_TEMP; echo $SLTP_MTS_TEMP?></td>
    <td><?php $SLTP_MTS_MS_TEMP=$row['SLTP_MTS_MS'];$SLTP_MTS_MS=$SLTP_MTS_MS+$SLTP_MTS_MS_TEMP; echo $SLTP_MTS_MS_TEMP?></td>
    <td><?php $SLTA_MA_TEMP=$row['SLTA_MA'];$SLTA_MA=$SLTA_MA+$SLTA_MA_TEMP; echo $SLTA_MA_TEMP?></td>
    <td><?php $SLTA_MA_MS_TEMP=$row['SLTA_MA_MS'];$SLTA_MA_MS=$SLTA_MA_MS+$SLTA_MA_MS_TEMP; echo $SLTA_MA_MS_TEMP?></td>
    <td><?php $PERGURUAN_TINGGI_TEMP=$row['PERGURUAN_TINGGI'];$PERGURUAN_TINGGI=$PERGURUAN_TINGGI+$PERGURUAN_TINGGI_TEMP; echo $PERGURUAN_TINGGI_TEMP?></td>
    <td><?php $PERGURUAN_TINGGI_MS_TEMP=$row['PERGURUAN_TINGGI_MS'];$PERGURUAN_TINGGI_MS=$PERGURUAN_TINGGI_MS+$PERGURUAN_TINGGI_MS_TEMP; echo $PERGURUAN_TINGGI_MS_TEMP?></td>
    <td><?php $KIOS_KUD_TEMP=$row['KIOS_KUD'];$KIOS_KUD=$KIOS_KUD+$KIOS_KUD_TEMP; echo $KIOS_KUD_TEMP?></td>
    <td><?php $KIOS_KUD_MS_TEMP=$row['KIOS_KUD_MS'];$KIOS_KUD_MS=$KIOS_KUD_MS+$KIOS_KUD_MS_TEMP; echo $KIOS_KUD_MS_TEMP?></td>
  </tr>
  <?php
	$no++;
	}
  ?>

  <tr>
    <td colspan="2"><div align="center">JUMLAH</div></td>
    <td><?=$SD_MI?></td>
    <td><?=$SD_MI_MS?></td>
    <td><?=$SLTP_MTS?></td>
    <td><?=$SLTP_MTS_MS?></td>
    <td><?=$SLTA_MA?></td>
    <td><?=$SLTA_MA_MS?></td>
    <td><?=$PERGURUAN_TINGGI?></td>
    <td><?=$PERGURUAN_TINGGI_MS?></td>
    <td><?=$KIOS_KUD?></td>
    <td><?=$KIOS_KUD_MS?></td>
    
  </tr>
</table>
</br>
<div>
	<span><b>LAPORAN  BULANAN PKL (TEMPAT - TEMPAT UMUM) </b></span><br>
	<br>
</div>
<table width="708" border="1">
  <tr>
    <th width="28" rowspan="3" >NO</th>
    <th width="77" rowspan="3" >PUSKESMAS</th>
    <th colspan="10" >TEMPAT - TEMPAT UMUM</th>
  </tr>
  <tr>
    <td colspan="2"><div align="center">HOTEL / LOSMEN</div></td>
    <td colspan="2"><div align="center">SALON / PANGKAS</div></td>
    <td colspan="2"><div align="center">TEMPAT REKREASI</div></td>
    <td colspan="2"><div align="center">GEDUNG PERTEMUAN</div></td>
    <td colspan="2"><div align="center">KOLAM RENANG</div></td>
  </tr>
  <tr>
    <td width="63">DIPERIKSA</td>
    <td width="47"><div align="center">MS</div></td>
    <td width="63">DIPERIKSA</td>
    <td width="41"><div align="center">MS</div></td>
    <td width="63">DIPERIKSA</td>
    <td width="42"><div align="center">MS</div></td>
    <td width="63">DIPERIKSA</td>
    <td width="40"><div align="center">MS</div></td>
    <td width="63">DIPERIKSA</td>
    <td width="42"><div align="center">MS</div></td>
  </tr>
  <tr>
    <th scope="row">1</th>
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
  </tr>
    <?php
	$no=1;
	$HOTEL_MELATI_LOSMEN=0;
	$HOTEL_MELATI_LOSMEN_MS=0;
	$SALON_KECNTIKAN_P_RAMBUT=0;
	$SALON_KECNTIKAN_P_RAMBUT_MS=0;
	$TEMPAT_REKREASI=0;
	$TEMPAT_REKREASI_MS=0;
	$GD_PERTEMUAN_GD_PERTUNJUKAN=0;
	$GD_PERTEMUAN_GD_PERTUNJUKAN_MS=0;
	$KOLAM_RENANG=0;
	$KOLAM_RENANG_MS=0;
	foreach($kesling as $row){
  ?>
  <tr>
    <td><div align="center"><?=$no;?></div></td>
    <td><?=$row['PUSKESMAS'];?></td>
    <td><?php $HOTEL_MELATI_LOSMEN_TEMP=$row['HOTEL_MELATI_LOSMEN'];$HOTEL_MELATI_LOSMEN=$HOTEL_MELATI_LOSMEN+$HOTEL_MELATI_LOSMEN_TEMP; echo $HOTEL_MELATI_LOSMEN_TEMP?></td>
    <td><?php $HOTEL_MELATI_LOSMEN_MS_TEMP=$row['HOTEL_MELATI_LOSMEN_MS'];$HOTEL_MELATI_LOSMEN_MS=$HOTEL_MELATI_LOSMEN_MS+$HOTEL_MELATI_LOSMEN_MS_TEMP; echo $HOTEL_MELATI_LOSMEN_MS_TEMP?></td>
    <td><?php $SALON_KECNTIKAN_P_RAMBUT_TEMP=$row['SALON_KECNTIKAN_P_RAMBUT'];$SALON_KECNTIKAN_P_RAMBUT=$SALON_KECNTIKAN_P_RAMBUT+$SALON_KECNTIKAN_P_RAMBUT_TEMP; echo $SALON_KECNTIKAN_P_RAMBUT_TEMP?></td>
    <td><?php $SALON_KECNTIKAN_P_RAMBUT_MS_TEMP=$row['SALON_KECNTIKAN_P_RAMBUT_MS'];$SALON_KECNTIKAN_P_RAMBUT_MS=$SALON_KECNTIKAN_P_RAMBUT_MS+$SALON_KECNTIKAN_P_RAMBUT_MS_TEMP; echo $SALON_KECNTIKAN_P_RAMBUT_MS_TEMP?></td>
    <td><?php $TEMPAT_REKREASI_TEMP=$row['TEMPAT_REKREASI'];$TEMPAT_REKREASI=$TEMPAT_REKREASI+$TEMPAT_REKREASI_TEMP; echo $TEMPAT_REKREASI_TEMP?></td>
    <td><?php $TEMPAT_REKREASI_MS_TEMP=$row['TEMPAT_REKREASI_MS'];$TEMPAT_REKREASI_MS=$TEMPAT_REKREASI_MS+$TEMPAT_REKREASI_MS_TEMP; echo $TEMPAT_REKREASI_MS_TEMP?></td>
    <td><?php $GD_PERTEMUAN_GD_PERTUNJUKAN_TEMP=$row['GD_PERTEMUAN_GD_PERTUNJUKAN'];$GD_PERTEMUAN_GD_PERTUNJUKAN=$GD_PERTEMUAN_GD_PERTUNJUKAN+$GD_PERTEMUAN_GD_PERTUNJUKAN_TEMP; echo $GD_PERTEMUAN_GD_PERTUNJUKAN_TEMP?></td>
    <td><?php $GD_PERTEMUAN_GD_PERTUNJUKAN_MS_TEMP=$row['GD_PERTEMUAN_GD_PERTUNJUKAN_MS'];$GD_PERTEMUAN_GD_PERTUNJUKAN_MS=$GD_PERTEMUAN_GD_PERTUNJUKAN_MS+$GD_PERTEMUAN_GD_PERTUNJUKAN_MS_TEMP; echo $GD_PERTEMUAN_GD_PERTUNJUKAN_MS_TEMP?></td>
    <td><?php $KOLAM_RENANG_TEMP=$row['KOLAM_RENANG'];$KOLAM_RENANG=$KOLAM_RENANG+$KOLAM_RENANG_TEMP; echo $KOLAM_RENANG_TEMP?></td>
    <td><?php $KOLAM_RENANG_MS_TEMP=$row['KOLAM_RENANG_MS'];$KOLAM_RENANG_MS=$KOLAM_RENANG_MS+$KOLAM_RENANG_MS_TEMP; echo $KOLAM_RENANG_MS_TEMP?></td>
    
  </tr>
   <?php
	$no++;
	}
  ?>
  <tr>
    <th colspan="2" scope="row">JUMLAH</th>
    <td><?=$HOTEL_MELATI_LOSMEN?></td>
    <td><?=$HOTEL_MELATI_LOSMEN_MS?></td>
    <td><?=$SALON_KECNTIKAN_P_RAMBUT?></td>
    <td><?=$SALON_KECNTIKAN_P_RAMBUT_MS?></td>
    <td><?=$TEMPAT_REKREASI?></td>
    <td><?=$TEMPAT_REKREASI_MS?></td>
    <td><?=$GD_PERTEMUAN_GD_PERTUNJUKAN?></td>
    <td><?=$GD_PERTEMUAN_GD_PERTUNJUKAN_MS?></td>
    <td><?=$KOLAM_RENANG?></td>
    <td><?=$KOLAM_RENANG_MS?></td>
    
  </tr>
</table>
</br>
<div>
	<span><b>LAPORAN  BULANAN PKL (TEMPAT IBADAH & TRANSPORTASI) </b></span><br>
	<br>
	<span></span>
	<br>
</div>
<table width="1100" border="1">
  <tr>
    <th width="19" rowspan="3" scope="col">NO</th>
    <th width="75" rowspan="3" scope="col">PUSKESMAS</th>
    <th colspan="10" scope="col">TEMPAT IBADAH</th>
    <th colspan="6" scope="col">SARANA TRANSPORTASI</th>
  </tr>
  <tr>
    <td colspan="2"><div align="center">MESJID/MUSHOLAH</div></td>
    <td colspan="2"><div align="center">GEREJA</div></td>
    <td colspan="2"><div align="center">KLENTENG</div></td>
    <td colspan="2"><div align="center">PURA</div></td>
    <td colspan="2"><div align="center">VIHARA</div></td>
    <td colspan="2"><div align="center">STASIUN</div></td>
    <td colspan="2"><div align="center">TERMINAL</div></td>
    <td colspan="2"><div align="center">PLBH. LAUT</div></td>
  </tr>
  <tr>
    <td width="70"><div align="center">DIPERIKSA</div></td>
    <td width="45"><div align="center">MS</div></td>
    <td width="64"><div align="center">DIPERIKSA</div></td>
    <td width="44"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="41"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="45"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="54"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="44"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="55"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="54"><div align="center">MS</div></td>
  </tr>
  <tr>
    <th scope="row">1</th>
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
  </tr>
   <?php
	$no=1;
	$MASJID_MUSHOLA=0;
	$MASJID_MUSHOLA_MS=0;
	$GEREJA=0;
	$GEREJA_MS=0;
	$KELENTENG=0;
	$KELENTENG_MS=0;
	$PURA=0;
	$PURA_MS=0;
	$WIHARA=0;
	$WIHARA_MS=0;
	$STASIUN=0;
	$STASIUN_MS=0;
	$TERMINAL=0;
	$TERMINAL_MS=0;
	$PELABUHAN_LAUT=0;
	$PELABUHAN_LAUT_MS=0;
	foreach($kesling as $row){
  ?>
  <tr>
     <td><div align="center"><?=$no;?></div></td>
    <td><?=$row['PUSKESMAS'];?></td>
    <td><?php $MASJID_MUSHOLA_TEMP=$row['MASJID_MUSHOLA'];$MASJID_MUSHOLA=$MASJID_MUSHOLA+$MASJID_MUSHOLA_TEMP; echo $MASJID_MUSHOLA_TEMP?></td>
    <td><?php $MASJID_MUSHOLA_MS_TEMP=$row['MASJID_MUSHOLA_MS'];$MASJID_MUSHOLA_MS=$MASJID_MUSHOLA_MS+$MASJID_MUSHOLA_MS_TEMP; echo $MASJID_MUSHOLA_MS_TEMP?></td>
    <td><?php $GEREJA_TEMP=$row['GEREJA'];$GEREJA=$GEREJA+$GEREJA_TEMP; echo $GEREJA_TEMP?></td>
    <td><?php $GEREJA_MS_TEMP=$row['GEREJA_MS'];$GEREJA_MS=$GEREJA_MS+$GEREJA_MS_TEMP; echo $GEREJA_MS_TEMP?></td>
    <td><?php $KELENTENG_TEMP=$row['KELENTENG'];$KELENTENG=$KELENTENG+$KELENTENG_TEMP; echo $KELENTENG_TEMP?></td>
    <td><?php $KELENTENG_MS_TEMP=$row['KELENTENG_MS'];$KELENTENG_MS=$KELENTENG_MS+$KELENTENG_MS_TEMP; echo $KELENTENG_MS_TEMP?></td>
    <td><?php $PURA_TEMP=$row['PURA'];$PURA=$PURA+$PURA_TEMP; echo $PURA_TEMP?></td>
    <td><?php $PURA_MS_TEMP=$row['PURA_MS'];$PURA_MS=$PURA_MS+$PURA_MS_TEMP; echo $PURA_MS_TEMP?></td>
    <td><?php $WIHARA_TEMP=$row['WIHARA'];$WIHARA=$WIHARA+$WIHARA_TEMP; echo $WIHARA_TEMP?></td>
    <td><?php $WIHARA_MS_TEMP=$row['WIHARA_MS'];$WIHARA_MS=$WIHARA_MS+$WIHARA_MS_TEMP; echo $WIHARA_MS_TEMP?></td>
    <td><?php $STASIUN_TEMP=$row['STASIUN'];$STASIUN=$STASIUN+$STASIUN_TEMP; echo $STASIUN_TEMP?></td>
    <td><?php $STASIUN_MS_TEMP=$row['STASIUN_MS'];$STASIUN_MS=$STASIUN_MS+$STASIUN_MS_TEMP; echo $STASIUN_MS_TEMP?></td>
    <td><?php $TERMINAL_TEMP=$row['TERMINAL'];$TERMINAL=$TERMINAL+$TERMINAL_TEMP; echo $TERMINAL_TEMP?></td>
    <td><?php $TERMINAL_MS_TEMP=$row['TERMINAL_MS'];$TERMINAL_MS=$TERMINAL_MS+$TERMINAL_MS_TEMP; echo $TERMINAL_MS_TEMP?></td>
    <td><?php $PELABUHAN_LAUT_TEMP=$row['PELABUHAN_LAUT'];$PELABUHAN_LAUT=$PELABUHAN_LAUT+$PELABUHAN_LAUT_TEMP; echo $PELABUHAN_LAUT_TEMP?></td>
    <td><?php $PELABUHAN_LAUT_MS_TEMP=$row['PELABUHAN_LAUT_MS'];$PELABUHAN_LAUT_MS=$PELABUHAN_LAUT_MS+$PELABUHAN_LAUT_MS_TEMP; echo $PELABUHAN_LAUT_MS_TEMP?></td>
   
  </tr>
  <?php
	$no++;
	}
  ?>  
  <tr>
    <th colspan="2" scope="row">JUMLAH</th>
    <td><?=$MASJID_MUSHOLA?></td>
    <td><?=$MASJID_MUSHOLA_MS?></td>
    <td><?=$GEREJA?></td>
    <td><?=$GEREJA_MS?></td>
    <td><?=$KELENTENG?></td>
    <td><?=$KELENTENG_MS?></td>
    <td><?=$PURA?></td>
    <td><?=$PURA_MS?></td>
    <td><?=$WIHARA?></td>
    <td><?=$WIHARA_MS?></td>
    <td><?=$STASIUN?></td>
    <td><?=$STASIUN_MS?></td>
    <td><?=$TERMINAL?></td>
    <td><?=$TERMINAL_MS?></td>
    <td><?=$PELABUHAN_LAUT?></td>
    <td><?=$PELABUHAN_LAUT_MS?></td>
   
  </tr>
</table>
</br>
<div>
	<span><b>LAPORAN  BULANAN PKL (SARANA EKONOMI &amp; SOSIAL) </b></span><br>
	<br>
	<span></span>
	<br>
</div>
<table width="915" border="1">
  <tr>
    <th width="27" rowspan="3" scope="col">NO</th>
    <th width="74" rowspan="3" scope="col">PUSKESMAS</th>
    <th colspan="12" scope="col">SARANA EKONOMI DAN SOSIAL</th>
  </tr>
  <tr>
    <td colspan="2"><div align="center">PASAR</div></td>
    <td colspan="2"><div align="center">APOTIK</div></td>
    <td colspan="2"><div align="center">TOKO OBAT</div></td>
    <td colspan="2"><div align="center">PANTI SOSIAL</div></td>
    <td colspan="2"><div align="center">SARKES</div></td>
    <td colspan="2"><div align="center">PON PES</div></td>
  </tr>
  <tr>
    <td width="69"><div align="center">DIPERIKSA</div></td>
    <td width="59"><div align="center">MS</div></td>
    <td width="71"><div align="center">DIPERIKSA</div></td>
    <td width="53"><div align="center">MS</div></td>
    <td width="70"><div align="center">DIPERIKSA</div></td>
    <td width="62"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="58"><div align="center">MS</div></td>
    <td width="65"><div align="center">DIPERIKSA</div></td>
    <td width="50"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="43"><div align="center">MS</div></td>
  </tr>
  <tr>
    <th scope="row">1</th>
    <td><div align="center">2</div></td>
    <td><div align="center">3</div></td>
    <td><div align="center">4</div></td>
    <td><div align="center">5</div></td>
    <td>6</td>
    <td><div align="center">7</div></td>
    <td><div align="center">8</div></td>
    <td><div align="center">9</div></td>
    <td><div align="center">10</div></td>
    <td><div align="center">11</div></td>
    <td><div align="center">12</div></td>
    <td><div align="center">13</div></td>
    <td><div align="center">14</div></td>
  </tr>
  <?php
	$no=1;
	$PASAR=0;
	$PASAR_MS=0;
	$APOTIK=0;
	$APOTIK_MS=0;
	$TOKO_OBAT=0;
	$TOKO_OBAT_MS=0;
	$SARANA_PANTI_SOSIAL=0;
	$SARANA_PANTI_SOSIAL_MS=0;
	$SARANA_KESEHATAN=0;
	$SARANA_KESEHATAN_MS=0;
	$PONDOK_PESANTREN=0;
	$PONDOK_PESANTREN_MS=0;
	foreach($kesling as $row){
  ?>
  <tr>
     <td><div align="center"><?=$no;?></div></td>
   <td><?=$row['PUSKESMAS'];?></td>
   <td><? $PASAR_TEMP=$row['PASAR'];$PASAR=$PASAR+$PASAR_TEMP; echo $PASAR_TEMP?></td>
   <td><? $PASAR_MS_TEMP=$row['PASAR_MS'];$PASAR_MS=$PASAR_MS+$PASAR_MS_TEMP; echo $PASAR_MS_TEMP?></td>
   <td><? $APOTIK_TEMP=$row['APOTIK'];$APOTIK=$APOTIK+$APOTIK_TEMP; echo $APOTIK_TEMP?></td>
   <td><? $APOTIK_MS_TEMP=$row['APOTIK_MS'];$APOTIK_MS=$APOTIK_MS+$APOTIK_MS_TEMP; echo $APOTIK_MS_TEMP?></td>
   <td><? $TOKO_OBAT_TEMP=$row['TOKO_OBAT'];$TOKO_OBAT=$TOKO_OBAT+$TOKO_OBAT_TEMP; echo $TOKO_OBAT_TEMP?></td>
   <td><? $TOKO_OBAT_MS_TEMP=$row['TOKO_OBAT_MS'];$TOKO_OBAT_MS=$TOKO_OBAT_MS+$TOKO_OBAT_MS_TEMP; echo $TOKO_OBAT_MS_TEMP?></td>
   <td><? $SARANA_PANTI_SOSIAL_TEMP=$row['SARANA_PANTI_SOSIAL'];$SARANA_PANTI_SOSIAL=$SARANA_PANTI_SOSIAL+$SARANA_PANTI_SOSIAL_TEMP; echo $SARANA_PANTI_SOSIAL_TEMP?></td>
   <td><? $SARANA_PANTI_SOSIAL_MS_TEMP=$row['SARANA_PANTI_SOSIAL_MS'];$SARANA_PANTI_SOSIAL_MS=$SARANA_PANTI_SOSIAL_MS+$SARANA_PANTI_SOSIAL_MS_TEMP; echo $SARANA_PANTI_SOSIAL_MS_TEMP?></td>
   <td><? $SARANA_KESEHATAN_TEMP=$row['SARANA_KESEHATAN'];$SARANA_KESEHATAN=$SARANA_KESEHATAN+$SARANA_KESEHATAN_TEMP; echo $SARANA_KESEHATAN_TEMP?></td>
   <td><? $SARANA_KESEHATAN_MS_TEMP=$row['SARANA_KESEHATAN_MS'];$SARANA_KESEHATAN_MS=$SARANA_KESEHATAN_MS+$SARANA_KESEHATAN_MS_TEMP; echo $SARANA_KESEHATAN_MS_TEMP?></td>
   <td><? $PONDOK_PESANTREN_TEMP=$row['PONDOK_PESANTREN'];$PONDOK_PESANTREN=$PONDOK_PESANTREN+$PONDOK_PESANTREN_TEMP; echo $PONDOK_PESANTREN_TEMP?></td>
   <td><? $PONDOK_PESANTREN_MS_TEMP=$row['PONDOK_PESANTREN_MS'];$PONDOK_PESANTREN_MS=$PONDOK_PESANTREN_MS+$PONDOK_PESANTREN_MS_TEMP; echo $PONDOK_PESANTREN_MS_TEMP?></td>
  </tr>
   <?php
	$no++;
	}
  ?>  
  <tr>
    <th colspan="2" scope="row">JUMLAH</th>
    <td><?=$PASAR?></td>
    <td><?=$PASAR_MS?></td>
    <td><?=$APOTIK?></td>
    <td><?=$APOTIK_MS?></td>
    <td><?=$TOKO_OBAT?></td>
    <td><?=$TOKO_OBAT_MS?></td>
    <td><?=$SARANA_PANTI_SOSIAL?></td>
    <td><?=$SARANA_PANTI_SOSIAL_MS?></td>
    <td><?=$SARANA_KESEHATAN?></td>
    <td><?=$SARANA_KESEHATAN_MS?></td>
    <td><?=$PONDOK_PESANTREN?></td>
    <td><?=$PONDOK_PESANTREN_MS?></td>
  
  </tr>
</table>
</br>
<div>
	<span><b>LAPORAN  BULANAN PKL (TEMPAT PENGOLAHAN MAKANAN) </b></span><br>
	<br>
	<span></span>
	<br>
</div>
<table width="915" border="1">
  <tr>
    <th width="32" rowspan="3" scope="col">NO</th>
    <th width="74" rowspan="3" scope="col">PUSKESMAS</th>
    <th colspan="12" scope="col">TEMPAT PENGOLAH MAKANAN DAN INDUSTRI</th>
  </tr>
  <tr>
    <td colspan="2"><div align="center">WARUNG MAKAN</div></td>
    <td colspan="2"><div align="center">RUMAH MAKAN</div></td>
    <td colspan="2"><div align="center">JASA BOGA</div></td>
    <td colspan="2"><div align="center">INDUSTRI MAMIN</div></td>
    <td colspan="2"><div align="center">INDUSTRI RUMAH</div></td>
    <td colspan="2"><div align="center">INDUSTRI BESAR</div></td>
  </tr>
  <tr>
    <td width="62"><div align="center">DIPERIKSA</div></td>
    <td width="53"><div align="center">MS</div></td>
    <td width="56"><div align="center">DIPERIKSA</div></td>
    <td width="58"><div align="center">MS</div></td>
    <td width="58"><div align="center">DIPERIKSA</div></td>
    <td width="60"><div align="center">MS</div></td>
    <td width="61"><div align="center">DIPERIKSA</div></td>
    <td width="56"><div align="center">MS</div></td>
    <td width="69"><div align="center">DIPERIKSA</div></td>
    <td width="62"><div align="center">MS</div></td>
    <td width="66"><div align="center">DIPERIKSA</div></td>
    <td width="60"><div align="center">MS</div></td>
  </tr>
  <tr>
    <th scope="row">1</th>
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
  </tr>
   <?php
	$no=1;
	$WARUNG_MAKAN=0;
	$WARUNG_MAKAN_MS=0;
	$RUMAH_MAKAN=0;
	$RUMAH_MAKAN_MS=0;
	$JASA_BOGA=0;
	$JASA_BOGA_MS=0;
	$INDSTRI_MKNAN_MNMAN=0;
	$INDSTRI_MKNAN_MNMAN_MS=0;
	$INDSTRI_KCL_R_TANGGA=0;
	$INDSTRI_KCL_R_TANGGA_MS=0;
	$INDUSTRI_BESAR=0;
	$INDUSTRI_BESAR_MS=0;
	foreach($kesling as $row){
  ?>
  <tr>
    <td><div align="center"><?=$no;?></div></td>
    <td><?=$row['PUSKESMAS'];?></td>
    <td><?php $WARUNG_MAKAN_TEMP=$row['WARUNG_MAKAN'];$WARUNG_MAKAN=$WARUNG_MAKAN+$WARUNG_MAKAN_TEMP; echo $WARUNG_MAKAN_TEMP?></td>
    <td><?php $WARUNG_MAKAN_MS_TEMP=$row['WARUNG_MAKAN_MS'];$WARUNG_MAKAN_MS=$WARUNG_MAKAN_MS+$WARUNG_MAKAN_MS_TEMP; echo $WARUNG_MAKAN_MS_TEMP?></td>
    <td><?php $RUMAH_MAKAN_TEMP=$row['RUMAH_MAKAN'];$RUMAH_MAKAN=$RUMAH_MAKAN+$RUMAH_MAKAN_TEMP; echo $RUMAH_MAKAN_TEMP?></td>
    <td><?php $RUMAH_MAKAN_MS_TEMP=$row['RUMAH_MAKAN_MS'];$RUMAH_MAKAN_MS=$RUMAH_MAKAN_MS+$RUMAH_MAKAN_MS_TEMP; echo $RUMAH_MAKAN_MS_TEMP?></td>
    <td><?php $JASA_BOGA_TEMP=$row['JASA_BOGA'];$JASA_BOGA=$JASA_BOGA+$JASA_BOGA_TEMP; echo $JASA_BOGA_TEMP?></td>
    <td><?php $JASA_BOGA_MS_TEMP=$row['JASA_BOGA_MS'];$JASA_BOGA_MS=$JASA_BOGA_MS+$JASA_BOGA_MS_TEMP; echo $JASA_BOGA_MS_TEMP?></td>
    <td><?php $INDSTRI_MKNAN_MNMAN_TEMP=$row['INDSTRI_MKNAN_MNMAN'];$INDSTRI_MKNAN_MNMAN=$INDSTRI_MKNAN_MNMAN+$INDSTRI_MKNAN_MNMAN_TEMP; echo $INDSTRI_MKNAN_MNMAN_TEMP?></td>
    <td><?php $INDSTRI_MKNAN_MNMAN_MS_TEMP=$row['INDSTRI_MKNAN_MNMAN_MS'];$INDSTRI_MKNAN_MNMAN_MS=$INDSTRI_MKNAN_MNMAN_MS+$INDSTRI_MKNAN_MNMAN_MS_TEMP; echo $INDSTRI_MKNAN_MNMAN_MS_TEMP?></td>
    <td><?php $INDSTRI_KCL_R_TANGGA_TEMP=$row['INDSTRI_KCL_R_TANGGA'];$INDSTRI_KCL_R_TANGGA=$INDSTRI_KCL_R_TANGGA+$INDSTRI_KCL_R_TANGGA_TEMP; echo $INDSTRI_KCL_R_TANGGA_TEMP?></td>
    <td><?php $INDSTRI_KCL_R_TANGGA_MS_TEMP=$row['INDSTRI_KCL_R_TANGGA_MS'];$INDSTRI_KCL_R_TANGGA_MS=$INDSTRI_KCL_R_TANGGA_MS+$INDSTRI_KCL_R_TANGGA_MS_TEMP; echo $INDSTRI_KCL_R_TANGGA_MS_TEMP?></td>
    <td><?php $INDUSTRI_BESAR_TEMP=$row['INDUSTRI_BESAR'];$INDUSTRI_BESAR=$INDUSTRI_BESAR+$INDUSTRI_BESAR_TEMP; echo $INDUSTRI_BESAR_TEMP?></td>
    <td><?php $INDUSTRI_BESAR_MS_TEMP=$row['INDUSTRI_BESAR_MS'];$INDUSTRI_BESAR_MS=$INDUSTRI_BESAR_MS+$INDUSTRI_BESAR_MS_TEMP; echo $INDUSTRI_BESAR_MS_TEMP?></td>

  </tr>
  <?php
	$no++;
	}
  ?>  
  <tr>
    <th height="19" colspan="2" scope="row">JUMLAH</th>
   <td><?=$WARUNG_MAKAN?></td>
   <td><?=$WARUNG_MAKAN_MS?></td>
   <td><?=$RUMAH_MAKAN?></td>
   <td><?=$RUMAH_MAKAN_MS?></td>
   <td><?=$JASA_BOGA?></td>
   <td><?=$JASA_BOGA_MS?></td>
   <td><?=$INDSTRI_MKNAN_MNMAN?></td>
   <td><?=$INDSTRI_MKNAN_MNMAN_MS?></td>
   <td><?=$INDSTRI_KCL_R_TANGGA?></td>
   <td><?=$INDSTRI_KCL_R_TANGGA_MS?></td>
   <td><?=$INDUSTRI_BESAR?></td>
   <td><?=$INDUSTRI_BESAR_MS?></td>
   
  </tr>
</table>
</br>
<div>
	<span><b>LAPORAN  BULANAN PKL (SAMIJAGA,SPAL DAN PEMBUANGAN SAMPAH ) </b></span><br>
	<br>
	<span></span>
	<br>
</div>
<table width="1300" border="1">
  <tr>
    <th width="26" rowspan="3" scope="col">NO</th>
    <th width="76" rowspan="3" scope="col">PUSKESMAS</th>
    <th colspan="20" scope="col">SAMIJAGA, SPAL &amp; TEMPAT PEMBUANGAN SAMPAH</th>
  </tr>
  <tr>
    <td colspan="2"><div align="center">RUMAH</div></td>
    <td colspan="2"><div align="center">SUMUR GALI</div></td>
    <td colspan="2"><div align="center">SUMUR POMPA</div></td>
    <td colspan="2"><div align="center">SR/PDAM</div></td>
    <td colspan="2"><div align="center">LAIN-LAIN SAB</div></td>
    <td colspan="2"><div align="center">JAMBAN UMUM</div></td>
    <td colspan="2"><div align="center">JAMBAN KELUARGA</div></td>
    <td colspan="2"><div align="center">SPAL</div></td>
    <td colspan="2"><div align="center">TPS</div></td>
    <td colspan="2"><div align="center">TPA</div></td>
  </tr>
  <tr>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="43"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="47"><div align="center">MS</div></td>
    <td width="66"><div align="center">DIPERIKSA</div></td>
    <td width="40"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="37"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="39"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="44"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="47"><div align="center">MS</div></td>
    <td width="64"><div align="center">DIPERIKSA</div></td>
    <td width="45"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="47"><div align="center">MS</div></td>
    <td width="63"><div align="center">DIPERIKSA</div></td>
    <td width="39"><div align="center">MS</div></td>
  </tr>
  <tr>
    <th scope="row">1</th>
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
  </tr>
   <?php
	$no=1;
	$JML_RUMAH=0;
	$JML_RUMAH_MS=0;
	$SGL=0;
	$SGL_MS=0;
	$SPT=0;
	$SPT_MS=0;
	$SR_PDAM=0;
	$SR_PDAM_MS=0;
	$LAIN_LAIN_SAB=0;
	$LAIN_LAIN_SAB_MS=0;
	$JMBN_UMUM_MCK=0;
	$JMBN_UMUM_MCK_MS=0;
	$JMBN_KELUARGA=0;
	$JMBN_KELUARGA_MS=0;
	$SPAL=0;
	$SPAL_MS=0;
	$TPS=0;
	$TPS_MS=0;
	$TPA=0;
	$TPA_MS=0;
	foreach($kesling as $row){
  ?>
  <tr>
   <td><div align="center"><?=$no;?></div></td>
    <td><?=$row['PUSKESMAS'];?></td>
    <td><?php $JML_RUMAH_TEMP=$row['JML_RUMAH'];$JML_RUMAH=$JML_RUMAH+$JML_RUMAH_TEMP; echo $JML_RUMAH_TEMP?></td>
    <td><?php $JML_RUMAH_MS_TEMP=$row['JML_RUMAH_MS'];$JML_RUMAH_MS=$JML_RUMAH_MS+$JML_RUMAH_MS_TEMP; echo $JML_RUMAH_MS_TEMP?></td>
    <td><?php $SGL_TEMP=$row['SGL'];$SGL=$SGL+$SGL_TEMP; echo $SGL_TEMP?></td>
    <td><?php $SGL_MS_TEMP=$row['SGL_MS'];$SGL_MS=$SGL_MS+$SGL_MS_TEMP; echo $SGL_MS_TEMP?></td>
    <td><?php $SPT_TEMP=$row['SPT'];$SPT=$SPT+$SPT_TEMP; echo $SPT_TEMP?></td>
    <td><?php $SPT_MS_TEMP=$row['SPT_MS'];$SPT_MS=$SPT_MS+$SPT_MS_TEMP; echo $SPT_MS_TEMP?></td>
    <td><?php $SR_PDAM_TEMP=$row['SR_PDAM'];$SR_PDAM=$SR_PDAM+$SR_PDAM_TEMP; echo $SR_PDAM_TEMP?></td>
    <td><?php $SR_PDAM_MS_TEMP=$row['SR_PDAM_MS'];$SR_PDAM_MS=$SR_PDAM_MS+$SR_PDAM_MS_TEMP; echo $SR_PDAM_MS_TEMP?></td>
    <td><?php $LAIN_LAIN_SAB_TEMP=$row['LAIN_LAIN_SAB'];$LAIN_LAIN_SAB=$LAIN_LAIN_SAB+$LAIN_LAIN_SAB_TEMP; echo $LAIN_LAIN_SAB_TEMP?></td>
    <td><?php $LAIN_LAIN_SAB_MS_TEMP=$row['LAIN_LAIN_SAB_MS'];$LAIN_LAIN_SAB_MS=$LAIN_LAIN_SAB_MS+$LAIN_LAIN_SAB_MS_TEMP; echo $LAIN_LAIN_SAB_MS?></td>
    <td><?php $JMBN_UMUM_MCK_TEMP=$row['JMBN_UMUM_MCK'];$JMBN_UMUM_MCK=$JMBN_UMUM_MCK+$JMBN_UMUM_MCK_TEMP; echo $JMBN_UMUM_MCK_TEMP?></td>
    <td><?php $JMBN_UMUM_MCK_MS_TEMP=$row['JMBN_UMUM_MCK_MS'];$JMBN_UMUM_MCK_MS=$JMBN_UMUM_MCK_MS+$JMBN_UMUM_MCK_MS_TEMP; echo $JMBN_UMUM_MCK_MS_TEMP?></td>
    <td><?php $JMBN_KELUARGA_TEMP=$row['JMBN_KELUARGA'];$JMBN_KELUARGA=$JMBN_KELUARGA+$JMBN_KELUARGA_TEMP; echo $JMBN_KELUARGA_TEMP?></td>
    <td><?php $JMBN_KELUARGA_MS_TEMP=$row['JMBN_KELUARGA_MS'];$JMBN_KELUARGA_MS=$JMBN_KELUARGA_MS+$JMBN_KELUARGA_MS_TEMP; echo $JMBN_KELUARGA_MS_TEMP?></td>
    <td><?php $SPAL_TEMP=$row['SPAL'];$SPAL=$SPAL+$SPAL_TEMP; echo $SPAL_TEMP?></td>
    <td><?php $SPAL_MS_TEMP=$row['SPAL_MS'];$SPAL_MS=$SPAL_MS+$SPAL_MS_TEMP; echo $SPAL_MS_TEMP?></td>
    <td><?php $TPS_TEMP=$row['TPS'];$TPS=$TPS+$TPS_TEMP; echo $TPS_TEMP?></td>
    <td><?php $TPS_MS_TEMP=$row['TPS_MS'];$TPS_MS=$TPS_MS+$TPS_MS_TEMP; echo $TPS_MS_TEMP?></td>
    <td><?php $TPA_TEMP=$row['TPA'];$TPA=$TPA+$TPA_TEMP; echo $TPA_TEMP?></td>
    <td><?php $TPA_MS_TEMP=$row['TPA_MS'];$TPA_MS=$TPA_MS+$TPA_MS_TEMP; echo $TPA_MS_TEMP?></td>
  
  </tr>
   <?php
	$no++;
	}
  ?>  
  <tr>
    <th colspan="2" scope="row">JUMLAH</th>
    <td><?=$JML_RUMAH?></td>
    <td><?=$JML_RUMAH_MS?></td>
    <td><?=$SGL?></td>
    <td><?=$SGL_MS?></td>
    <td><?=$SPT?></td>
    <td><?=$SPT_MS?></td>
    <td><?=$SR_PDAM?></td>
    <td><?=$SR_PDAM_MS?></td>
    <td><?=$LAIN_LAIN_SAB?></td>
    <td><?=$LAIN_LAIN_SAB_MS?></td>
    <td><?=$JMBN_UMUM_MCK?></td>
    <td><?=$JMBN_UMUM_MCK_MS?></td>
    <td><?=$JMBN_KELUARGA?></td>
    <td><?=$JMBN_KELUARGA_MS?></td>
    <td><?=$SPAL?></td>
    <td><?=$SPAL_MS?></td>
    <td><?=$TPS?></td>
    <td><?=$TPS_MS?></td>
    <td><?=$TPA?></td>
    <td><?=$TPA_MS?></td>
 
  </tr>
</table>
</body>
</body>
</body>
</html>
