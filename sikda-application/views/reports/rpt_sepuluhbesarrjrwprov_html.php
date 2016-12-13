<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?=base_url()?>assets/report_ppjk/css/style_report.css" />
<body>
<div class="content">
	<div class="title">
	<h1>10 PENYAKIT TERBANYAK RAWAT JALAN</h1>
	<h2 align="center">PADA FASKES FKTP JKN</h2>
	<h3>REKAP PROVINSI</h3>
	</div>

	<table width="100%" border="1px">
	<tr>
	<td>PROPINSI</td>
	<td>:</td>
	<td colspan='4'><?=$PROPINSI?></td>
	</tr>

	<td>BULAN</td>
	<td>:</td>
	<td><?=$FROM?> - <?=$TO?></td>

	</tr>
	</table>
	<br/>
	
	<table width="100%" border="1px">
	<thead>
		<tr>	
			<th rowspan="3">No</th>
			<th rowspan="3" width="500px">Kab / Kota</th>
			<th colspan="<?=10*3?>">10 Penyakit dan Jumlah Kasus</th>
		</tr>
		
		<tr>	
			<?for($i=1; $i<=10; $i++){?>
			<th rowspan="2">Nama Penyakit</th>
			<th colspan="2">Jumlah Kasus</th>
			<?}?>
		</tr>
		
		<tr>
			<?for($i=1; $i<=10; $i++){?>
			<th>L</th>
			<th>P</th>
			<?}?>
		</tr>
		
	</thead>
	<tbody>
		<?$no=1;foreach($result['RJ']['ROWS'] as $key1=>$row1){?>
		<tr>
			<td align="center"><?=$no?></td>
			<td align="left"><?=$key1?></td>
			
			<?$limit=1;foreach($row1 as $key2=>$row2){ if($limit == 11) break;?>
			<td align="left"><?=is_numeric($key2)?0:$key2?></td>
			<td align="center"><?=isset($row2['L'])?($row2['L']['TOTAL']):0;?></td>
			<td align="center"><?=isset($row2['P'])?($row2['P']['TOTAL']):0;?></td>
			<?$limit++;}?>
		</tr>
		<?$no++;}?>
		
		
		<tr>
			<td align="center" colspan="2">PROVINSI</td>
			<?$no=1;foreach($result['RJ']['TOTAL'] as $key=>$row){ if($no == 11) break; ?>
			<td align="center"></td>
			<td align="center"><?=isset($row['L'])?($row['L']):0;?></td>
			<td align="center"><?=isset($row['P'])?($row['P']):0;?></td>
			<?$no++;}?>
		</tr>
		
	</tbody>
	</table>
	<br/>
	<br/>
	
	<div class="title">
	<h1>10 PENYAKIT TERBANYAK RAWAT INAP</h1>
	<h2 align="center">PADA FASKES FKTP JKN</h2>
	</div>
	
	<table width="100%" border="1px">
	<tr>
	<td>PROPINSI</td>
	<td>:</td>
	<td colspan='4'><?=$PROPINSI?></td>
	</tr>

	<td>BULAN</td>
	<td>:</td>
	<td><?=$FROM?> - <?=$TO?></td>

	</tr>
	</table>
	<br/>
	<table width="100%" border="1px">
	<thead>
		<tr>	
			<th rowspan="3">No</th>
			<th rowspan="3" width="500px">Kab / Kota</th>
			<th colspan="<?=10*3?>">10 Penyakit dan Jumlah Kasus</th>
		</tr>
		
		<tr>	
			<?for($i=1; $i<=10; $i++){?>
			<th rowspan="2">Nama Penyakit</th>
			<th colspan="2">Jumlah Kasus</th>
			<?}?>
		</tr>
		
		<tr>
			<?for($i=1; $i<=10; $i++){?>
			<th>L</th>
			<th>P</th>
			<?}?>
		</tr>
		
		
	</thead>
	<tbody>
		<?$no=1;foreach($result['RI']['ROWS'] as $key1=>$row1){?>
		<tr>
			<td align="center"><?=$no?></td>
			<td align="left"><?=$key1?></td>
			<?$limit=1;foreach($row1 as $key2=>$row2){ if($limit == 11) break;?>
			<td align="left"><?=is_numeric($key2)?0:$key2?></td>
			<td align="center"><?=isset($row2['L'])?($row2['L']['TOTAL']):0;?></td>
			<td align="center"><?=isset($row2['P'])?($row2['P']['TOTAL']):0;?></td>
			<?$limit++;}?>
		</tr>
		<?$no++;}?>
		
		
		<tr>
			<td align="center" colspan="2">PROVINSI</td>
			<?$no=1;foreach($result['RI']['TOTAL'] as $key=>$row){ if($no == 11) break; ?>
			<td align="center"></td>
			<td align="center"><?=isset($row['L'])?($row['L']):0;?></td>
			<td align="center"><?=isset($row['P'])?($row['P']):0;?></td>
			<?$no++;}?>
		</tr>
		
	</tbody>
	</table>
	<br/>
	<br/>
</div>
</body>
</html>