<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?=base_url()?>assets/report_ppjk/css/style_report.css" />
<body>
<div class="content">
	<div class="title">
	<h1>10 PENYAKIT TERBANYAK RAWAT JALAN DAN RAWAT INAP</h1>
	<h2>PADA FASKES FKTP JKN</h2>
	<h3>PER PUSKESMAS</h3>
	</div>

	<table width="100%" border="1px">
	<tr>
	<td>NAMA PUSKESMAS</td>
	<td>:</td>
	<td colspan='4'><?=$PUSKESMAS?></td>
	</tr>

	<tr>
	<td>KODE PUSKESMAS</td>
	<td>:</td>
	<td><?=$KD_PUSKESMAS?></td>

	<td>BULAN PELAYANAN</td>
	<td>:</td>
	<td><?=$FROM?> - <?=$TO?></td>

	</tr>
	</table>
	<br/>
	<div><h2 align="left">A. PELAYANAN RAWAT JALAN</h2></div>
	<h3>10 PENYAKIT TERBANYAK</h3>
	
	<table width="100%" border="1px">
	<thead>
		<tr>	
			<th rowspan="2">No</th>
			<th rowspan="2" width="500px">Penyakit</th>
			<th rowspan="2">Kode ICD</th>
			<th colspan="2">Jumlah Kasus</th>
		</tr>
		<tr>	
			<th>L</th>
			<th>P</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center">1</td>
			<td align="center">2</td>
			<td align="center">3</td>
			<td align="center">4</td>
			<td align="center">5</td>
		</tr>
		<?
			$no=1;
			$TOTAL_L = 0;
			$TOTAL_P = 0;
			foreach($result as $k=>$v){ if($v['UNIT_PELAYANAN'] == 'RI') continue; if($no==11) break;?>
		<tr>
			<td align="center"><?=$no?></td>
			<td align="left"><?=$v['PENYAKIT']?></td>
			<td align="left"><?=$v['KD_PENYAKIT']?></td>
			<td align="center"><?=$v['TOTAL_L']?></td>
			<td align="center"><?=$v['TOTAL_P']?></td>
		</tr>
		<?
			$TOTAL_L += $v['TOTAL_L'];
			$TOTAL_P += $v['TOTAL_P'];
			$no++;
			}
		?>
		<tr>
			<td align="center" colspan="2">PUSKESMAS</td>
			<td align="center" background="black">&nbsp;</td>
			<td align="center"><?=$TOTAL_L?></td>
			<td align="center"><?=$TOTAL_P?></td>
		</tr>
	</tbody>
	</table>
	<br/>
	<br/>
	<div><h2 align="left">B. PELAYANAN RAWAT INAP ( Hanya untuk Puskesmas dengan tempat tidur)</h2></div>
	<h3>10 PENYAKIT TERBANYAK</h3>
	
	<table width="100%" border="1px">
	<thead>
		<tr>	
			<th rowspan="2">No</th>
			<th rowspan="2" width="500px">Penyakit</th>
			<th rowspan="2">Kode ICD</th>
			<th colspan="2">Jumlah Kasus</th>
		</tr>
		<tr>	
			<th>L</th>
			<th>P</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center">1</td>
			<td align="center">2</td>
			<td align="center">3</td>
			<td align="center">4</td>
			<td align="center">5</td>
		</tr>
		<?
			$no=1;
			$TOTAL_L = 0;
			$TOTAL_P = 0;
			foreach($result as $k=>$v){ if($v['UNIT_PELAYANAN'] == 'RJ') continue;?>
		<tr>
			<td align="center"><?=$no?>
			</td>
			<td align="left"><?=$v['PENYAKIT']?></td>
			<td align="left"><?=$v['KD_PENYAKIT']?></td>
			<td align="center"><?=$v['TOTAL_L']?></td>
			<td align="center"><?=$v['TOTAL_P']?></td>
		</tr>
		<?
			$TOTAL_L += $v['TOTAL_L'];
			$TOTAL_P += $v['TOTAL_P'];
			$no++;
			}
		?>
		<tr>
			<td align="center" colspan="2">PUSKESMAS</td>
			<td align="center" background="black">&nbsp;</td>
			<td align="center"><?=$TOTAL_L?></td>
			<td align="center"><?=$TOTAL_P?></td>
		</tr>
	</tbody>
	</table>
	<br/>
	<br/>
</div>
</body>
</html>