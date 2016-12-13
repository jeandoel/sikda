<script>
	$('#backlistmaster_kategori_imunisasi').click(function(){
		$("#t58","#tabs").empty();
		$("#t58","#tabs").load('c_master_kategori_imunisasi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kategori Imunisasi</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_kategori_imunisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kategori Imunisasi</label>
		<input type="text" readonly name="kodekategoriimunisasi" id="kodekategoriimunisasi" disabled value="<?=$data->KD_KATEGORI_IMUNISASI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kategori Imunisasi</label>
		<input type="text" readonly name="kategoriimunisasi" id="kategoriimunisasi" disabled value="<?=$data->KATEGORI_IMUNISASI?>" />
		</span>
	</fieldset>
</form>
</div >


