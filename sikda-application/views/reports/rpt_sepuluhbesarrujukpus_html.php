<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?=base_url()?>assets/report_ppjk/css/style_report.css" />
<body>
<div class="content">
	<div class="title">
	<h1>10 PENYAKIT TERBANYAK YANG DI RUJUK</h1>
	<h2 align="center">PADA FASKES FKTP JKN</h2>
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
		<?
			$no=1;
			$TOTAL_L = 0;
			$TOTAL_P = 0;
			foreach($result as $k=>$v){ if($no==11) break;
				$v['L'] = isset($v['L'])?$v['L']:array();
				$v['P'] = isset($v['P'])?$v['P']:array();
		?>
		<tr>
			<td align="center"><?=$no?></td>
			<td align="left"><?=$v['DESCRIPTION']?></td>
			<td align="left"><?=$v['KD_PENYAKIT']?></td>
			<td align="center"><?=(isset($v['L']['TOTAL'])?$v['L']['TOTAL']:0)?></td>
			<td align="center"><?=(isset($v['P']['TOTAL'])?$v['P']['TOTAL']:0)?></td>
		</tr>
		<?
			$TOTAL_L += (isset($v['L']['TOTAL'])?$v['L']['TOTAL']:0);
			$TOTAL_P += (isset($v['P']['TOTAL'])?$v['P']['TOTAL']:0);
			$no++;
			}
		?>
		<tr>
			<td align="center" colspan="2">JUMLAH</td>
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