<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Data Dasar</title>
<style>
th {
	font-family:helvetica;
	font-size: 12px;
	border: 1px solid #000;
}
td {
	font-family:helvetica;
	text-align: center;
	font-size: 9px;
	border: 1px solid #000;
}
table{
	border-collapse: collapse;
}
</style>
</head>

<body>
<div>
<?php $n=0;foreach($dita as $data){?>
<p style="text-align:center">DINAS KESEHATAN KABUPATEN/KOTA <?=$data[$n]['KABUPATEN']?></p>
<p>Tahun : <?=$data[$n]['TAHUN']?></p>
<?php }?>
<table width="100%">
  <tr>
    <th rowspan="2" scope="col">No</th>
    <th rowspan="2" scope="col">PUSKESMAS</th>
    <th rowspan="2" scope="col">JML DESA</th>
    <th rowspan="2" scope="col">JML RT</th>
    <th rowspan="2" scope="col">JML RW</th>
    <th rowspan="2" scope="col">JML KK</th>
    <th rowspan="2" scope="col">LUAS<br/>WILAYAH</th>
    <th colspan="3" scope="col">&lt; 1 Tahun</th>
    <th colspan="3" scope="col">01 - 04 Tahun</th>
    <th colspan="3" scope="col">05 - 14 Tahun</th>
    <th colspan="3" scope="col">15 - 44 Tahun</th>
    <th colspan="3" scope="col">45 - 64 Tahun</th>
    <th colspan="3" scope="col">&gt; 65 Tahun</th>
    <th colspan="3" scope="col">Jumlah</th>
  </tr>
  <tr>
    <td>L</td>
    <td>P</td>
    <td>Jml</td>
    <td>L</td>
    <td>P</td>
    <td>Jml</td>
    <td>L</td>
    <td>P</td>
    <td>Jml</td>
    <td>L</td>
    <td>P</td>
    <td>Jml</td>
    <td>L</td>
    <td>P</td>
    <td>Jml</td>
    <td>L</td>
    <td>P</td>
    <td>Jml</td>
    <td>L</td>
    <td>P</td>
    <td>Jml</td>
  </tr>
  <tr>
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>6</td>
    <td>7</td>
    <td>8</td>
    <td>9</td>
    <td>10</td>
    <td>11</td>
    <td>12</td>
    <td>13</td>
    <td>14</td>
    <td>15</td>
    <td>16</td>
    <td>17</td>
    <td>18</td>
    <td>19</td>
    <td>20</td>
    <td>21</td>
    <td>22</td>
    <td>23</td>
    <td>24</td>
    <td>25</td>
    <td>26</td>
    <td>27</td>
    <td>28</td>
  </tr>
  <?php $as=0;$bs=0;$cs=0;$ds=0;$es=0;$fs=0;$gs=0;$hs=0;$is=0;$js=0;$ks=0;$ls=0;$ns=0;$ms=0;$os=0;$ps=0;$qs=0;$rs=0;$ss=0;$ts=0;$us=0;$vs=0;$ws=0;$xs=0;$ys=0;$zs=0;$aas=0;
	$no=1;foreach($data as $deta){
	$l_5_14 = $deta['JML_L_5_9TH'] + $deta['JML_L_10_14TH'];
	$p_5_14 = $deta['JML_P_5_9TH'] + $deta['JML_P_10_14TH'];
	$l_15_44 = $deta['JML_L_15_19TH'] + $deta['JML_L_20_24TH'] + $deta['JML_L_25_29TH'] + $deta['JML_L_30_34TH'] + $deta['JML_L_35_39TH'] + $deta['JML_L_40_44TH'];
	$p_15_44 = $deta['JML_P_15_19TH'] + $deta['JML_P_20_24TH'] + $deta['JML_P_25_29TH'] + $deta['JML_P_30_34TH'] + $deta['JML_P_35_39TH'] + $deta['JML_P_40_44TH'];
	$l_45_64 = $deta['JML_L_45_49TH'] + $deta['JML_L_50_54TH'] + $deta['JML_L_55_59TH'] + $deta['JML_L_60_64TH'];
	$p_45_64 = $deta['JML_P_45_49TH'] + $deta['JML_P_50_54TH'] + $deta['JML_P_55_59TH'] + $deta['JML_P_60_64TH'];
	$l_65 = $deta['JML_L_65_69TH'] + $deta['JML_L_70_74TH'] + $deta['JML_L_L75TH'];
	$p_65 = $deta['JML_P_65_69TH'] + $deta['JML_P_70_74TH'] + $deta['JML_P_L75TH'];
	$all_l = $l_5_14 + $l_15_44 + $l_45_64 + $l_65 + $deta['JML_L_K1TH'] + $deta['JML_L_1_4TH'];
	$all_p = $p_5_14 + $p_15_44 + $p_45_64 + $p_65 + $deta['JML_P_K1TH'] + $deta['JML_P_1_4TH'];
	
  ?>
  <tr>
    <td><?=$no?></td>
    <td><?=$deta['PUSKESMAS']?></td>
    <td><?$a=$deta['JML_SP_DESA'];$as=$as+$a;echo $a?></td>
    <td><?$b=$deta['JML_SP_RT'];$bs=$bs+$b;echo $b?></td>
    <td><?$c=$deta['JML_SP_RW'];$cs=$cs+$c;echo $c?></td>
    <td><?$d=$deta['JML_SP_KK'];$ds=$ds+$d;echo $d?></td>
    <td><?$e=$deta['JML_SP_L_WILAYAH'];$es=$es+$e;echo $e?></td>
    <td><?$f=$deta['JML_L_K1TH'];$fs=$fs+$f;echo $f?></td>
    <td><?$g=$deta['JML_P_K1TH'];$gs=$gs+$g;echo $g?></td>
    <td><?$h=$deta['JML_L_K1TH'] + $deta['JML_P_K1TH'];$hs=$hs+$h;echo $h?></td>
    <td><?$i=$deta['JML_L_1_4TH'];$is=$is+$i;echo $i?></td>
    <td><?$j=$deta['JML_P_1_4TH'];$js=$js+$j;echo $j?></td>
    <td><?$k=$deta['JML_L_1_4TH'] + $deta['JML_P_1_4TH'];$ks=$ks+$k;echo $k?></td>
    <td><?$l=$l_5_14;$ls=$ls+$l;echo $l?></td>
    <td><?$m=$p_5_14;$ms=$ms+$m;echo $m?></td>
    <td><?$n=$l_5_14 + $p_5_14;$ns=$ns+$n;echo $n?></td>
    <td><?$o=$l_15_44;$os=$os+$o;echo $o?></td>
    <td><?$p=$p_15_44;$ps=$ps+$p;echo $p?></td>
    <td><?$q=$p_15_44 + $l_15_44;$qs=$qs+$q;echo $q?></td>
    <td><?$r=$l_45_64;$rs=$rs+$r;echo $r?></td>
    <td><?$s=$p_45_64;$ss=$ss+$s;echo $s?></td>
    <td><?$t=$l_45_64 + $p_45_64;$ts=$ts+$t;echo $t?></td>
    <td><?$u=$l_65;$us=$us+$u;echo $u?></td>
    <td><?$v=$p_65;$vs=$vs+$v;echo $v?></td>
    <td><?$w=$l_65 + $p_65;$ws=$ws+$w;echo $w?></td>
    <td><?$x=$all_l;$xs=$xs+$x;echo $x?></td>
    <td><?$y=$all_p;$ys=$ys+$y;echo $y?></td>
    <td><?$z=$all_l + $all_p;$zs=$zs+$z;echo $z?></td>
  </tr>
  <?php $no++;}?>
  <tr>
    <td colspan="2">Jumlah</td>
    <td><?=$as?></td>
    <td><?=$bs?></td>
    <td><?=$cs?></td>
    <td><?=$ds?></td>
    <td><?=$es?></td>
    <td><?=$fs?></td>
    <td><?=$gs?></td>
    <td><?=$hs?></td>
    <td><?=$is?></td>
    <td><?=$js?></td>
    <td><?=$ks?></td>
    <td><?=$ls?></td>
    <td><?=$ms?></td>
    <td><?=$ns?></td>
    <td><?=$os?></td>
    <td><?=$ps?></td>
    <td><?=$qs?></td>
    <td><?=$rs?></td>
    <td><?=$ss?></td>
    <td><?=$ts?></td>
    <td><?=$us?></td>
    <td><?=$vs?></td>
    <td><?=$ws?></td>
    <td><?=$xs?></td>
    <td><?=$ys?></td>
    <td><?=$zs?></td>
  </tr>
   
</table>
<p>DATA  DASAR SARANA PRA SARANA</p>

<table width="100%" border="1px">
  <tr>
    <th rowspan="2" scope="col">No</th>
    <th rowspan="2" scope="col">PUSKESMAS</th>
    <th colspan="26" scope="col">SASARAN</th>
  </tr>
  <tr>
    <td>PUS</td>
    <td>WUS</td>
    <td>BAYI</td>
    <td>BALITA</td>
    <td>BUMIL</td>
    <td>BULIN</td>
    <td>BUFAS</td>
    <td>GAKIN</td>
    <td>K1</td>
    <td>K4</td>
    <td>KN1</td>
    <td>KN2</td>
    <td>LINAKES</td>
    <td>LINAKES<br/>NON NAKES</td>
    <td>RESTI<br/>NAKES</td>
    <td>RESTI<br/>MASY</td>
    <td>PMPB</td>
    <td>DPT1</td>
    <td>DPT2</td>
    <td>POLIO4</td>
    <td>CAMPAK</td>
    <td><p>TT2</p></td>
    <td>JML<br/>POSYANDU</td>
    <td>JML<br/>MURID TK</td>
    <td>JML<br/>KADER</td>
    <td>JML<br/>MURID SD KL 1</td>
  </tr>
  <tr>
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>6</td>
    <td>7</td>
    <td>8</td>
    <td>9</td>
    <td>10</td>
    <td>11</td>
    <td>12</td>
    <td>13</td>
    <td>14</td>
    <td>15</td>
    <td>16</td>
    <td>17</td>
    <td>18</td>
    <td>19</td>
    <td>20</td>
    <td>21</td>
    <td>22</td>
    <td>23</td>
    <td>24</td>
    <td>25</td>
    <td>26</td>
    <td>27</td>
    <td>28</td>
  </tr>
  <?php $no=1;
  $as=0;$bs=0;$cs=0;$ds=0;$es=0;$fs=0;$gs=0;$hs=0;$is=0;$js=0;$ks=0;$ls=0;$ns=0;$ms=0;$os=0;$ps=0;$qs=0;$rs=0;$ss=0;$ts=0;$us=0;
  foreach($data as $deta){?>
  <tr>
    <td><?=$no?></td>
    <td><?=$deta['PUSKESMAS']?></td>
    <td><?$a=$deta['JML_SASKIA_PUS'];$as=$as+$a;echo $a?></td>
    <td><?$b=$deta['JML_SASKIA_WUS'];$bs=$bs+$b;echo $b?></td>
    <td><?$c=$deta['JML_L_SASKIA_BAYI'] + $deta['JML_P_SASKIA_BAYI'];$cs=$cs+$c;echo $c?></td>
    <td><?$d=$deta['JML_L_SASKIA_BALITA'] + $deta['JML_P_SASKIA_BALITA'];$ds=$ds+$d;echo $d?></td>
    <td><?$e=$deta['JML_SASKIA_BUMIL'];$es=$es+$e;echo $e?></td>
    <td><?$f=$deta['JML_SASKIA_BULIN'];$fs=$fs+$f;echo $f?></td>
    <td><?$g=$deta['JML_SASKIA_BUFAS'];$gs=$gs+$g;echo $g?></td>
    <td><?$h=$deta['JML_GA_GAKIN'];$hs=$hs+$h;echo $h?></td>
    <td><?$i=$deta['JML_SASKIA_K1'];$is=$is+$i;echo $i?></td>
    <td><?$j=$deta['JML_SASKIA_K4'];$js=$js+$j;echo $j?></td>
    <td><?$k=$deta['JML_SASKIA_KN1'];$ks=$ks+$k;echo $k?></td>
    <td><?$l=$deta['JML_SASKIA_KN2'];$ls=$ls+$l;echo $l?></td>
    <td><?$m=$deta['JML_SASKIA_P_NAKES'];$ms=$ms+$m;echo $m?></td>
    <td><?$n=$deta['JML_SASKIA_P_NON_NAKES'];$ns=$ns+$n;echo $n?></td>
    <td><?$o=$deta['JML_SASKIA_RES_NAKES'];$os=$os+$o;echo $o?></td>
    <td><?$p=$deta['JML_SASKIA_RES_MASYARAKAT'];$ps=$ps+$p;echo $p?></td>
    <td><?$q=$deta['JML_SASKIA_PMPB'];$qs=$qs+$q;echo $q?></td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td><?$r=$deta['JML_SASKIA_POSYANDU'];$rs=$rs+$r;echo $r?></td>
    <td><?$s=$deta['JML_SASKIA_M_TK'];$ss=$ss+$s;echo $s?></td>
    <td><?$t=$deta['JML_SASKIA_KADER'];$ts=$ts+$t;echo $t?></td>
    <td><?$u=$deta['JML_L_SAS_DD_MSD_KELAS1'] + $deta['JML_P_SAS_DD_MSD_KELAS1'];$us=$us+$u;echo $u?></td>
  </tr>
  <?php $no++;}?>
  <tr>
    <td colspan="2">Jumlah</td>
    <td><?=$as?></td>
    <td><?=$bs?></td>
    <td><?=$cs?></td>
    <td><?=$ds?></td>
    <td><?=$es?></td>
    <td><?=$fs?></td>
    <td><?=$gs?></td>
    <td><?=$hs?></td>
    <td><?=$is?></td>
    <td><?=$js?></td>
    <td><?=$ks?></td>
    <td><?=$ls?></td>
    <td><?=$ms?></td>
    <td><?=$ns?></td>
    <td><?=$os?></td>
    <td><?=$ps?></td>
    <td><?=$qs?></td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td><?=$rs?></td>
    <td><?=$ss?></td>
    <td><?=$ts?></td>
    <td><?=$us?></td>
  </tr>
  
</table>
<p>DATA  DASAR SASARAN PROGRAM</p>

<table width="100%" border="1px">
  <tr>
    <th width="4%" rowspan="2" scope="col">No</th>
    <th width="14%" rowspan="2" scope="col">PUSKESMAS</th>
    <th width="14%" rowspan="2" scope="col">JML RUMAH</th>
    <th colspan="4" scope="col">SARANA AIR BERSIH</th>
    <th width="8%" rowspan="2" scope="col">SPAL</th>
    <th width="20%" rowspan="2" scope="col">JAMBAN<br/>
      KELUARGA</th>
    <th colspan="2" scope="col">PEMBUANGAN</th>
  </tr>
  <tr>
    <td width="5%">SGL</td>
    <td width="5%">SPT</td>
    <td width="5%">SR/DAM</td>
    <td width="5%">Lain-lain</td>
    <td>TPS</td>
    <td>TPA</td>
  </tr>
  <tr>
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>6</td>
    <td>7</td>
    <td>8</td>
    <td>9</td>
    <td>10</td>
    <td>11</td>
  </tr>
  <?php $no=1;
  $as=0;$bs=0;$cs=0;$ds=0;$es=0;$fs=0;$gs=0;$hs=0;$is=0;
  foreach($data as $deta){?>
  <tr>
    <td><?=$no?></td>
    <td><?=$deta['PUSKESMAS']?></td>
    <td><?$a=$deta['JML_SAB_RUMAH'];$as=$as+$a;echo $a?></td>
    <td><?$b=$deta['JML_SAB_SGL'];$bs=$bs+$b;echo $b?></td>
    <td><?$c=$deta['JML_SAB_SPT'];$cs=$cs+$c;echo $c?></td>
    <td><?$d=$deta['JML_SAB_SR_PDAM'];$ds=$ds+$d;echo $d?></td>
    <td><?$e=$deta['JML_SAB_LAINLAIN'];$es=$es+$e;echo $e?></td>
    <td><?$f=$deta['JML_SAB_SPAL'];$fs=$fs+$f;echo $f?></td>
    <td><?$g=$deta['JML_SAB_J_KELUARGA'];$gs=$gs+$g;echo $g?></td>
    <td><?$h=$deta['JML_SAB_TPA'];$hs=$hs+$h;echo $h?></td>
    <td><?$i=$deta['JML_SAB_TPS'];$is=$is+$i;echo $i?></td>
  </tr>
  <?php $no++;}?>
  <tr>
    <td colspan="2">Jumlah</td>
    <td><?=$as?></td>
    <td><?=$bs?></td>
    <td><?=$cs?></td>
    <td><?=$ds?></td>
    <td><?=$es?></td>
    <td><?=$fs?></td>
    <td><?=$gs?></td>
    <td><?=$hs?></td>
    <td><?=$is?></td>
  </tr>
</table>
<p>DATA  DASAR TEMPAT UMUM</p>
<table width="100%" border="1px">
  <tr>
    <th rowspan="2" scope="col">No</th>
    <th rowspan="2" scope="col">PUSKESMAS</th>
    <th colspan="8" scope="col">JUMLAH SEKOLAH</th>
    <th colspan="6" scope="col">TEMPAT-TEMPAT UMUM</th>
    <th colspan="5" scope="col">TEMPAT IBADAH</th>
    <th colspan="3" scope="col">SARANA TRANSPORTASI</th>
    <th colspan="7" scope="col">SARANA EKONOMI DAN SOSIAL</th>
    <th colspan="4" scope="col">TEMPAT PENGOLAH</th>
  </tr>
  <tr>
    <td>TK</td>
    <td>SD</td>
    <td>MI</td>
    <td>SLTP</td>
    <td>MTS</td>
    <td>SLTA</td>
    <td>MA</td>
    <td>PT</td>
    <td>KIOS</td>
    <td>HOTEL/<br/>LOSMEN</td>
    <td>SALON/<br/>PANGKAS<br/>RAMBUT</td>
    <td>TEMPAT<br/>REKREASI</td>
    <td>GD.<br/>PERTUN-<br/>JUKAN</td>
    <td>KOLAM<br/>RENANG</td>
    <td>MESJID/<br/>MUSHOLA</td>
    <td>GEREJA</td>
    <td>KLENTENG</td>
    <td>PURA</td>
    <td>VIHARA</td>
    <td>TERMINAL</td>
    <td>STASIUN</td>
    <td>PLBH.<br/>LAUT</td>
    <td>PASAR</td>
    <td>APOTIK</td>
    <td>TOKO<br/>OBAT</td>
    <td>PANTI<br/>SOSIAL</td>
    <td>SARKES</td>
    <td>KANTOR</td>
    <td>PON PES</td>
    <td>WARUNG<br/>MAKAN</td>
    <td>RUMAH<br/>MAKAN</td>
    <td>JASA BOGA/<br/>CATERING</td>
    <td>INDUSTRI<br/>MAMIN</td>
  </tr>
  <tr>
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>6</td>
    <td>7</td>
    <td>8</td>
    <td>9</td>
    <td>10</td>
    <td>11</td>
    <td>12</td>
    <td>13</td>
    <td>14</td>
    <td>15</td>
    <td>16</td>
    <td>17</td>
    <td>18</td>
    <td>19</td>
    <td>20</td>
    <td>21</td>
    <td>22</td>
    <td>23</td>
    <td>24</td>
    <td>25</td>
    <td>26</td>
    <td>27</td>
    <td>28</td>
    <td>29</td>
    <td>30</td>
    <td>31</td>
    <td>32</td>
    <td>33</td>
    <td>34</td>
    <td>35</td>
  </tr>
  <?php $no=1;
  $as=0;$bs=0;$cs=0;$ds=0;$es=0;$fs=0;$gs=0;$hs=0;$is=0;$js=0;$ks=0;$ls=0;$ns=0;$ms=0;$os=0;$ps=0;$qs=0;$rs=0;$ss=0;$ts=0;$us=0;$vs=0;$ws=0;$xs=0;$ys=0;$zs=0;$aas=0;$abs=0;$acs=0;$ads=0;$aes=0;$afs=0;$ags=0;
  foreach($data as $deta){?>
  <tr>
    <td><?=$no?></td>
    <td><?=$deta['PUSKESMAS']?></td>
    <td><?$a=$deta['JML_TTU_TK'];$as=$as+$a;echo $a?></td>
    <td><?$b=$deta['JML_TTU_SD'];$bs=$bs+$b;echo $b?></td>
    <td><?$c=$deta['JML_TTU_MI'];$cs=$cs+$c;echo $c?></td>
    <td><?$d=$deta['JML_TTU_SLTP'];$ds=$ds+$d;echo $d?></td>
    <td><?$e=$deta['JML_TTU_MTS'];$es=$es+$e;echo $e?></td>
    <td><?$f=$deta['JML_TTU_SLTA'];$fs=$fs+$f;echo $f?></td>
    <td><?$g=$deta['JML_TTU_MA'];$gs=$gs+$g;echo $g?></td>
    <td><?$h=$deta['JML_TTU_P_TINGGI'];$hs=$hs+$h;echo $h?></td>
    <td><?$i=$deta['JML_TTU_KIOS'];$is=$is+$i;echo $i?></td>
    <td><?$j=$deta['JML_TTU_H_M_LOSMEN'];$js=$js+$j;echo $j?></td>
    <td><?$k=$deta['JML_TTU_SK_P_RAMBUT'];$ks=$ks+$k;echo $k?></td>
    <td><?$l=$deta['JML_TTU_T_REKREASI'];$ls=$ls+$l;echo $l?></td>
    <td><?$m=$deta['JML_TTU_GP_G_PERTUNJUKAN'];$ms=$ms+$m;echo $m?></td>
    <td><?$n=$deta['JML_TTU_K_RENANG'];$ns=$ns+$n;echo $n?></td>
    <td><?$o=$deta['JML_SI_MAS_MUSHOLA'];$os=$os+$o;echo $o?></td>
    <td><?$p=$deta['JML_SI_GEREJA'];$ps=$ps+$p;echo $p?></td>
    <td><?$q=$deta['JML_SI_KLENTENG'];$qs=$qs+$q;echo $q?></td>
    <td><?$r=$deta['JML_SI_PURA'];$rs=$rs+$r;echo $r?></td>
    <td><?$s=$deta['JML_SI_VIHARA'];$ss=$ss+$s;echo $s?></td>
    <td><?$t=$deta['JML_STR_TERMINAL'];$ts=$ts+$t;echo $t?></td>
    <td><?$u=$deta['JML_STR_STASIUN'];$us=$us+$u;echo $u?></td>
    <td><?$v=$deta['JML_STR_P_LAUT'];$vs=$vs+$v;echo $v?></td>
    <td><?$w=$deta['JML_SES_PASAR'];$ws=$ws+$w;echo $w?></td>
    <td><?$x=$deta['JML_SES_APOTIK'];$xs=$xs+$x;echo $x?></td>
    <td><?$y=$deta['JML_SES_T_OBAT'];$ys=$ys+$y;echo $y?></td>
    <td><?$z=$deta['JML_SES_P_SOSIAL'];$zs=$zs+$z;echo $z?></td>
    <td><?$aa=$deta['JML_SES_S_KESEHATAN'];$aas=$aas+$aa;echo $aa?></td>
    <td><?$ab=$deta['JML_SES_PERKANTORAN'];$abs=$abs+$ab;echo $ab?></td>
    <td><?$ac=$deta['JML_SES_P_PESANTREN'];$acs=$acs+$ac;echo $ac?></td>
    <td><?$ad=$deta['JML_TPM_W_MAKAN'];$ads=$ads+$ad;echo $ad?></td>
    <td><?$ae=$deta['JML_TPM_R_MAKAN'];$aes=$aes+$ae;echo $ae?></td>
    <td><?$af=$deta['JML_TPM_JB_CATERING'];$afs=$afs+$af;echo $af?></td>
    <td><?$ag=$deta['JML_TPM_IMD_MINUMAN'];$ags=$ags+$ag;echo $ag?></td>
  </tr>
  <?php $no++;}?>
  <tr>
    <td colspan="2">Jumlah</td>
    <td><?=$as?></td>
    <td><?=$bs?></td>
    <td><?=$cs?></td>
    <td><?=$ds?></td>
    <td><?=$es?></td>
    <td><?=$fs?></td>
    <td><?=$gs?></td>
    <td><?=$hs?></td>
    <td><?=$is?></td>
    <td><?=$js?></td>
    <td><?=$ks?></td>
    <td><?=$ls?></td>
    <td><?=$ms?></td>
    <td><?=$ns?></td>
    <td><?=$os?></td>
    <td><?=$ps?></td>
    <td><?=$qs?></td>
    <td><?=$rs?></td>
    <td><?=$ss?></td>
    <td><?=$ts?></td>
    <td><?=$us?></td>
    <td><?=$vs?></td>
    <td><?=$ws?></td>
    <td><?=$xs?></td>
    <td><?=$ys?></td>
    <td><?=$zs?></td>
    <td><?=$aas?></td>
    <td><?=$abs?></td>
    <td><?=$acs?></td>
    <td><?=$ads?></td>
    <td><?=$aes?></td>
    <td><?=$afs?></td>
    <td><?=$ags?></td>
  </tr>
 
</table>
</div>
</body>
</html>