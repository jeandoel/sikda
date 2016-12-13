<p>
	<h4>TOTAL AWAL TERIMA:</h4>
	<?php
		foreach($items_terima as $item):
			echo "$item->NAMA_OBAT : $item->TOTAL_TERIMA<br/>";
		endforeach;
	?>
</p>
<p>
	<h4>TOTAL AWAL KELUAR DI LUAR APOTIK:</h4>
	<?php
		foreach($items_keluar as $item):
			echo "$item->NAMA_OBAT : $item->TOTAL_KELUAR<br/>";
		endforeach;
	?>
</p>
<p>
	<h4>TOTAL AWAL PEMAKAIAN:</h4>
	<?php
		foreach($items_pemakaian as $item):
			echo "$item->NAMA_OBAT : $item->TOTAL_PEMAKAIAN<br/>";
		endforeach;
	?>
</p>
<p>
	<h4>PENERIMAAN:</h4>
	<?php
		foreach($penerimaan as $item):
			echo "$item->NAMA_OBAT : $item->TOTAL_TERIMA<br/>";
		endforeach;
	?>
</p>
<p>
	<h4>PENGELUARAN DI LUAR APOTIK:</h4>
	<?php
		foreach($pengeluaran as $item):
			echo "$item->NAMA_OBAT : $item->TOTAL_KELUAR<br/>";
		endforeach;
	?>
</p>
<p>
	<h4>PEMAKAIAN:</h4>
	<?php
		foreach($pemakaian as $item):
			echo "$item->NAMA_OBAT : $item->TOTAL_PEMAKAIAN<br/>";
		endforeach;
	?>
</p>
<p>
	<h4>STOK AKHIR:</h4>
	<?php
		foreach($stock as $item):
			echo $item['NAMA_OBAT'] .":". $item['QTY'] ."<br/>";
		endforeach;
	?>
</p>
<p>
	<h4>SATU QUERY:</h4>
	<h3><?=$combined? $combined[0]->NAMA_KABUPATEN: '';?></h3>
	<?php
		foreach($combined as $item):
			echo $item->NAMA_OBAT ." : ". $item->STOK_AKHIR ." : PENERIMAAN => ".$item->TERIMA."<br/>";
		endforeach;
	?>
</p>