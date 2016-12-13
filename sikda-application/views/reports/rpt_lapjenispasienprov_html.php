<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?=base_url()?>assets/report_ppjk/css/style_report.css" />
<body>
<div class="content">
	<div class="title">
	<h1>JUMLAH KUNJUNGAN BERDASARKAN JENIS PASIEN</h1>
	<h2 align="center">PADA FASKES FKTP JKN</h2>
	<h3>REKAP PROVINSI</h3>
	</div>

	<table width="100%" border="1px">
	
	<td>PROVINSI</td>
	<td>:</td>
	<td><?=$PROPINSI?></td>
	
	<td>BULAN</td>
	<td>:</td>
	<td><?=$FROM?> - <?=$TO?></td>

	</tr>
	</table>
	<br/>
	
	<table width="100%" border="1px">
	<thead>
		<tr>
			<th rowspan="2" width="50px">No</th>
			<th rowspan="2" width="200px">JENIS PESERTA</th>
			<?for($i=1; $i<=12; $i++){?>
			<th colspan="2" width="100px"><?=date('F', strtotime("2014-".$i."-01"))?></th>
			<?}?>
		</tr>
		
		<tr>
			<?for($i=1; $i<=12; $i++){?>
			<th width="15px">L</th>
			<th width="15px">P</th>
			<?}?>
		</tr>
		
	</thead>
	<tbody>
		<?
			$TOTAL = array();
			$TOTAL['01L'] = '';
			$TOTAL['01P'] = '';
			
			$TOTAL['02L'] = '';
			$TOTAL['02P'] = '';
			
			$TOTAL['03L'] = '';
			$TOTAL['03P'] = '';
			
			$TOTAL['04L'] = '';
			$TOTAL['04P'] = '';
			
			$TOTAL['05L'] = '';
			$TOTAL['05P'] = '';
			
			$TOTAL['06L'] = '';
			$TOTAL['06P'] = '';
			
			$TOTAL['07L'] = '';
			$TOTAL['07P'] = '';
			
			$TOTAL['08L'] = '';
			$TOTAL['08P'] = '';
			
			$TOTAL['09L'] = '';
			$TOTAL['09P'] = '';
			
			$TOTAL['10L'] = '';
			$TOTAL['10P'] = '';
			
			$TOTAL['11L'] = '';
			$TOTAL['11P'] = '';
			
			$TOTAL['12L'] = '';
			$TOTAL['12P'] = '';
			$no=1;foreach($result as $row){
			
			$TOTAL['01L'] += $row['01L'];
			$TOTAL['01P'] += $row['01P'];
			
			$TOTAL['02L'] += $row['02L'];
			$TOTAL['02P'] += $row['02P'];
			
			$TOTAL['03L'] += $row['03L'];
			$TOTAL['03P'] += $row['03P'];
			
			$TOTAL['04L'] += $row['04L'];
			$TOTAL['04P'] += $row['04P'];
			
			$TOTAL['05L'] += $row['05L'];
			$TOTAL['05P'] += $row['05P'];
			
			$TOTAL['06L'] += $row['06L'];
			$TOTAL['06P'] += $row['06P'];
			
			$TOTAL['07L'] += $row['07L'];
			$TOTAL['07P'] += $row['07P'];
			
			$TOTAL['08L'] += $row['08L'];
			$TOTAL['08P'] += $row['08P'];
			
			$TOTAL['09L'] += $row['09L'];
			$TOTAL['09P'] += $row['09P'];
			
			$TOTAL['10L'] += $row['10L'];
			$TOTAL['10P'] += $row['10P'];
			
			$TOTAL['11L'] += $row['11L'];
			$TOTAL['11P'] += $row['11P'];
			
			$TOTAL['12L'] += $row['12L'];
			$TOTAL['12P'] += $row['12P'];
		?>
		<tr>
			<td align="center"><?=$no?></td>
			<td align="left"><?=$row['KD_JENIS_PASIEN']?></td>
			
			<td align="left"><?=$row['01L']?></td>
			<td align="left"><?=$row['01P']?></td>
			
			<td align="left"><?=$row['02L']?></td>
			<td align="left"><?=$row['02P']?></td>
			
			<td align="left"><?=$row['03L']?></td>
			<td align="left"><?=$row['03P']?></td>
			
			<td align="left"><?=$row['04L']?></td>
			<td align="left"><?=$row['04P']?></td>
			
			<td align="left"><?=$row['05L']?></td>
			<td align="left"><?=$row['05P']?></td>
			
			<td align="left"><?=$row['06L']?></td>
			<td align="left"><?=$row['06P']?></td>
			
			<td align="left"><?=$row['07L']?></td>
			<td align="left"><?=$row['07P']?></td>
			
			<td align="left"><?=$row['08L']?></td>
			<td align="left"><?=$row['08P']?></td>
			
			<td align="left"><?=$row['09L']?></td>
			<td align="left"><?=$row['09P']?></td>
			
			<td align="left"><?=$row['10L']?></td>
			<td align="left"><?=$row['10P']?></td>
			
			<td align="left"><?=$row['11L']?></td>
			<td align="left"><?=$row['11P']?></td>
			
			<td align="left"><?=$row['12L']?></td>
			<td align="left"><?=$row['12P']?></td>
		</tr>
		<?$no++;}?>
		
		<tr>
			<td align="left"></td>
			<td align="left"></td>
			
			<td align="left"><?=$TOTAL['01L']?></td>
			<td align="left"><?=$TOTAL['01P']?></td>
			
			<td align="left"><?=$TOTAL['02L']?></td>
			<td align="left"><?=$TOTAL['02P']?></td>
			
			<td align="left"><?=$TOTAL['03L']?></td>
			<td align="left"><?=$TOTAL['03P']?></td>
			
			<td align="left"><?=$TOTAL['04L']?></td>
			<td align="left"><?=$TOTAL['04P']?></td>
			
			<td align="left"><?=$TOTAL['05L']?></td>
			<td align="left"><?=$TOTAL['05P']?></td>
			
			<td align="left"><?=$TOTAL['06L']?></td>
			<td align="left"><?=$TOTAL['06P']?></td>
			
			<td align="left"><?=$TOTAL['07L']?></td>
			<td align="left"><?=$TOTAL['07P']?></td>
			
			<td align="left"><?=$TOTAL['08L']?></td>
			<td align="left"><?=$TOTAL['08P']?></td>
			
			<td align="left"><?=$TOTAL['09L']?></td>
			<td align="left"><?=$TOTAL['09P']?></td>
			
			<td align="left"><?=$TOTAL['10L']?></td>
			<td align="left"><?=$TOTAL['10P']?></td>
			
			<td align="left"><?=$TOTAL['11L']?></td>
			<td align="left"><?=$TOTAL['11P']?></td>
			
			<td align="left"><?=$TOTAL['12L']?></td>
			<td align="left"><?=$TOTAL['12P']?></td>
		</tr>
		
		
	</tbody>
	</table>
	<br/>
	<br/>
</div>
</body>
</html>