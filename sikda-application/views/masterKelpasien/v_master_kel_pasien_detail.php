<script>
	$('#backlistkelpasien').click(function(){
		$("#t67","#tabs").empty();
		$("#t67","#tabs").load('c_master_kel_pasien'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kelompok Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistkelpasien">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE KELOMPOK PASIEN</label>
		<input type="text" readonly name="kd_cus" id="text1" value="<?=$data->KD_CUSTOMER?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_CUSTOMER?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>CUSTOMER</label>
		<input type="text" readonly name="cus" id="text2" value="<?=$data->CUSTOMER?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TELEPON</label>
		<input type="text" readonly name="tlp1" id="text2" value="<?=$data->TELEPON1?>"  />
		</span>
	</fieldset>
		
</form>
</div >
