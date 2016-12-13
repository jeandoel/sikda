<table class="rptRevenue" rel="total">
	<tr class="thead">
		<th>KD Penyakit</th>
		<th>Penyakit</th>
		<th>Jumlah</th>
	</tr>
	<?php foreach($top5diagnose as $res =>$val):?>
	<tr>
		<td><?=$val['KD_PENYAKIT']?></td>
		<td><?=$val['PENYAKIT']?></td>
		<td><?=$val['BANYAK']?></td>
	</tr>
	<?php endforeach;?>
</table>