<script>
	$('#backlistmastertransfer').click(function(){
		$("#t16","#tabs").empty();
		$("#t16","#tabs").load('c_master_transfer'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Transfer</div>
<div class="backbutton"><span class="kembali" id="backlistmastertransfer">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Transfer</label>
		<input type="text" readonly name="kode_transfer" id="kode_transfer" value="<?=$data->KD_TRANSFER?>" />
		<input type="hidden" name="id" id="kode_transfer" value="<?=$data->KD_TRANSFER?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Produk Transfer</label>
		<input type="text" readonly name="produk_transfer" id="produk_transfer" value="<?=$data->PRODUK_TRANSFER?>"  />
		</span>
	</fieldset>
</form>
</div >