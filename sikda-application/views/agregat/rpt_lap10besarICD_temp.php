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

	<table width="100%">
	<tr>
	<td>NAMA PUSKESMAS</td>
	<td>:</td>
	<td colspan='4'><?=$NAMA_PUSKESMAS?></td>
	</tr>

	<tr>
	<td>KODE PUSKESMAS</td>
	<td>:</td>
	<td><?=$KODE_PUSKESMAS?></td>

	<td>BULAN PELAYANAN</td>
	<td>:</td>
	<td><?=date('Y F', strtotime($BULAN))?></td>

	</tr>
	</table>
	<br/>
	<div><h2 align="left">A. PELAYANAN RAWAT JALAN</h2></div>
	<h3>10 PENYAKIT TERBANYAK</h3>
	
	<table width="100%">
	<thead>
		<tr>	
			<th rowspan="2">No</th>
			<th rowspan="2" width="500px">Penyakit</th>
			<th rowspan="2">Kode ICD</th>
			<th colspan="2">Jumlah Kasus</th>
			<th rowspan="2">Action</th>
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
			<td align="center">6</td>
		</tr>
		<?
			$no=1;
			foreach($ROWS['RJ'] as $k=>$v){?>
		<tr>
			<td align="center"><?=$no?></td>
			<td align="left"><?=$v['NM_ICD']?></td>
			<td align="left"><?=$v['KD_ICD']?></td>
			<td align="center"><?=$v['L']?></td>
			<td align="center"><?=$v['P']?></td>
			<td align="center"><?=$v['ACTION']?></td>
		</tr>
			<?$no++;}?>
	</tbody>
	</table>
	<br/>
	<br/>
	<div><h2 align="left">B. PELAYANAN RAWAT INAP ( Hanya untuk Puskesmas dengan tempat tidur)</h2></div>
	<h3>10 PENYAKIT TERBANYAK</h3>
	
	<table width="100%">
	<thead>
		<tr>	
			<th rowspan="2">No</th>
			<th rowspan="2" width="500px">Penyakit</th>
			<th rowspan="2">Kode ICD</th>
			<th colspan="2">Jumlah Kasus</th>
			<th rowspan="2">Action</th>
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
			<td align="center">6</td>
		</tr>
		<?
			$no=1;
			foreach($ROWS['RI'] as $k=>$v){?>
		<tr>
			<td align="center"><?=$no?></td>
			<td align="left"><?=$v['NM_ICD']?></td>
			<td align="left"><?=$v['KD_ICD']?></td>
			<td align="center"><?=$v['L']?></td>
			<td align="center"><?=$v['P']?></td>
			<td align="center"><?=$v['ACTION']?></td>
		</tr>
			<?$no++;}?>
	</tbody>
	</table>
	<br/>
	<br/>
</div>
</body>
</html>