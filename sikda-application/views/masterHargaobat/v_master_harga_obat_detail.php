<script>
	$('#backlistmasterhargaobat').click(function(){
		$("#t23","#tabs").empty();
		$("#t23","#tabs").load('c_master_harga_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Harga Obat</div>
<div class="backbutton"><span class="kembali" id="backlistmasterhargaobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Tarif</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->KD_TARIF?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->idd?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Obat</label>
		<input type="text" readonly name="kodeobat" id="text2" value="<?=$data->KD_OBAT?>" />
		<input type="text" readonly autocomplete="off" name="namaobat" id="nama_obat" value="<?=$data->NAMA_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Harga Beli</label>
		<input type="text" readonly name="hargabeli" id="text3" value="<?=$data->HARGA_BELI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Harga Jual</label>
		<input type="text" readonly name="hargajual" id="text4" value="<?=$data->HARGA_JUAL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Milik Obat</label>
		<input type="text" readonly name="kodemilik" id="text5" value="<?=$data->KD_MILIK_OBAT?>" />
		</span>
	</fieldset>
</form>
</div >