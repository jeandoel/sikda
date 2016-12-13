<script>
	$('#backlistcarabayar').click(function(){
		$("#t53","#tabs").empty();
		$("#t53","#tabs").load('c_master_cara_bayar'+'?_=' + (new Date()).getTime());
	})
</script>

<div class="mycontent">
<div class="formtitle">Detail Cara Bayar</div>
<div class="backbutton"><span class="kembali" id="backlistcarabayar">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data" id="form1carabayardetail">
	<fieldset>
		<span>
		<label>Kode Bayar</label>
		<input type="text" readonly name="kodebayar" id="kodebayar" value="<?=$data->KD_BAYAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Cara Bayar</label>
		<input type="text" readonly name="carabayar" id="carabayar" value="<?=$data->CARA_BAYAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Customer</label>
		<input type="text" readonly name="kodecustomer" id="kodecustomer" value="<?=$data->KD_CUSTOMER?> - <?=$data->CUSTOMER?>"  />
		</span>
	</fieldset>
</form>
</div >