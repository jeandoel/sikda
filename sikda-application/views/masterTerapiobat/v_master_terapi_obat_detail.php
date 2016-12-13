<script>
	$('#backlistmaster_terapiobat').click(function(){
		$("#t43","#tabs").empty();
		$("#t43","#tabs").load('c_master_terapi_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Data Terapi Obat</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_terapiobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Terapi Obat</label>
		<input type="text" readonly name="kodeterapiobat" id="kodeterapiobat" value="<?=$data->KD_TERAPI_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Terapi Obat</label>
		<input type="text" readonly name="terapiobat" id="terapiobat" value="<?=$data->TERAPI_OBAT?>" />
		</span>
	</fieldset>
</form>
</div >


