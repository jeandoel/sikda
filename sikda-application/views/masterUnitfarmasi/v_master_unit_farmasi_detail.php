<script>
	$('#backlistmaster_unitfarmasi').click(function(){
		$("#t44","#tabs").empty();
		$("#t44","#tabs").load('c_master_unit_farmasi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Data Unit Farmasi</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_unitfarmasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Unit Farmasi</label>
		<input type="text" readonly name="kodeunitfarmasi" id="kodeunitfarmasi" value="<?=$data->KD_UNIT_FAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Unit Farmasi</label>
		<input type="text" readonly name="unitfarmasi" id="unitfarmasi" value="<?=$data->NAMA_UNIT_FAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Farmasi Utama</label>
		<input type="text" readonly name="farmasiutama" id="farmasiutama" value="<?=$data->FAR_UTAMA?>" />
		</span>
	</fieldset>
</form>
</div >


