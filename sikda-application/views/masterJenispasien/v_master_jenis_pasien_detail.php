<script>
	$('#backlistmaster_jenis_pasien').click(function(){
		$("#t59","#tabs").empty();
		$("#t59","#tabs").load('c_master_jenis_pasien'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Jenis Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_jenis_pasien">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Pasien</label>
		<input type="text" readonly name="kodejenispasien" id="kodejenispasien" disabled value="<?=$data->KD_JENIS_PASIEN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Pasien</label>
		<input type="text" readonly name="jenispasien" id="jenispasien" disabled value="<?=$data->JENIS_PASIEN?>" />
		</span>
	</fieldset>
</form>
</div >


