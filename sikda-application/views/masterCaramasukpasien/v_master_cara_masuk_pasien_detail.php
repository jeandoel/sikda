<script>
	$('#backlistmaster_cara_masuk_pasien').click(function(){
		$("#t55","#tabs").empty();
		$("#t55","#tabs").load('c_master_cara_masuk_pasien'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Cara Masuk Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_cara_masuk_pasien">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Cara Masuk</label>
		<input type="text" readonly name="kodecaramasuk" id="kodecaramasuk" value="<?=$data->KD_CARA_MASUK?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Cara Masuk</label>
		<input type="text" readonly name="caramasuk" id="caramasuk" value="<?=$data->CARA_MASUK?>" />
		</span>
	</fieldset>
</form>
</div >


