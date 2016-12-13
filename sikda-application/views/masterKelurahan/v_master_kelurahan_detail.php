<script>
	$('#backlistmasterkelurahan').click(function(){
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('c_master_kelurahan'+'?_=' + (new Date()).getTime());
	})
</script>

<div class="mycontent">
<div id="dialogcari_master_kecamatan_id" title="Kecamatan"></div>
<div class="formtitle">Detail Kelurahan</div>
<div class="backbutton"><span class="kembali" id="backlistmasterkelurahan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kelurahan</label>
		<input type="text" name="kode_kelurahan" id="kode_kelurahan" value="<?=$data->KD_KELURAHAN?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kecamatan</label>
		<input type="text" name="master_kecamatan_id_hidden" id="master_kecamatan_id_hidden" value="<?=$data->KD_KECAMATAN?>" readonly />
		<input type="text" name="master_kecamatan_id" id="master_kecamatan_id" value="<?=$data->namakecamatan?>" readonly/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kelurahan</label>
		<input type="text" name="kelurahan" id="kelurahan" value="<?=$data->KELURAHAN?>" readonly />
		</span>
	</fieldset>
</form>
</div >