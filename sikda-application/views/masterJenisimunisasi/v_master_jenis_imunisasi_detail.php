<script>
	$('#backlistmaster_jenis_imunisasi').click(function(){
		$("#t60","#tabs").empty();
		$("#t60","#tabs").load('c_master_jenis_imunisasi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Jenis Imunisasi</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_jenis_imunisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Imunisasi</label>
		<input type="text" readonly name="kodejenisimunisasi" id="kodejenisimunisasi" disabled value="<?=$data->KD_JENIS_IMUNISASI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Imunisasi</label>
		<input type="text" readonly name="jenisimunisasi" id="jenisimunisasi" disabled value="<?=$data->JENIS_IMUNISASI?>" />
		</span>
	</fieldset>
</form>
</div >


