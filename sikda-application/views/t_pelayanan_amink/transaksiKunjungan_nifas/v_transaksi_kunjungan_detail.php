<script>
	$('#backlistt_kunjungan_nifas').click(function(){
		$("#t401","#tabs").empty();
		$("#t401","#tabs").load('t_kunjungan_nifas'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kunjungan Nifas</div>
<div class="backbutton"><span class="kembali" id="backlistt_kunjungan_nifas">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" readonly name="tanggal" id="tanggal" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keluhan</label>
		<textarea type="text" readonly name="keluhan" id="keluhan" rows="auto" cols="28"> <?=$data->KELUHAN?> </textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tekanan Darah</label>
		<input type="text" readonly name="tekanan_darah" id="tekanan_darah" value="<?=$data->TEKANAN_DARAH?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nadi</label>
		<input type="text" readonly name="nadi" id="nadi" value="<?=$data->NADI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nafas</label>
		<input type="text" readonly name="nafas" id="nafas" value="<?=$data->NAFAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Suhu</label>
		<input type="text" readonly name="suhu" id="suhu" value="<?=$data->SUHU?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kontraksi Rahim</label>
		<input type="text" readonly name="kontraksi" id="kontraksi" value="<?=$data->KONTRAKSI_RAHIM?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Perdarahan</label>
		<input type="text" readonly name="perdarahan" id="perdarahan" value="<?=$data->PERDARAHAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Warna Lokhia</label>
		<input type="text" readonly name="warna_lokhia" id="warna_lokhia" value="<?=$data->WARNA_LOKHIA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Lokhia</label>
		<input type="text" readonly name="jumlah_lokhia" id="jumlah_lokhia" value="<?=$data->JML_LOKHIA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Bau Lokhia</label>
		<input type="text" readonly name="bau_lokhia" id="bau_lokhia" value="<?=$data->BAU_LOKHIA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Buang Air Besar</label>
		<input type="text" readonly name="bab" id="bab" value="<?=$data->BUANG_AIR_BESAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Buang Air Kecil</label>
		<input type="text" readonly name="bak" id="bak" value="<?=$data->BUANG_AIR_KECIL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Produksi Asi</label>
		<input type="text" readonly name="produksi_asi" id="produksi_asi" value="<?=$data->PRODUKSI_ASI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tindakan</label>
		<textarea type="text" readonly name="tindakan" id="tindakan" rows="auto" cols="28"> <?=$data->TINDAKAN?> </textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nasehat</label>
		<textarea type="text" readonly name="nasehat" id="nasehat" rows="auto" cols="28"> <?=$data->NASEHAT?> </textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pemeriksa</label>
		<input type="text" readonly name="pemeriksa" id="pemeriksa" value="<?=$data->pemeriksa?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Petugas</label>
		<input type="text" readonly name="petugas" id="petugas" value="<?=$data->petugas?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Status Hamil</label>
		<input type="text" readonly name="stat_hamil" id="stat_hamil" value="<?=$data->KD_STATUS_HAMIL?>" />
		</span>
	</fieldset>
	
	
</form>
</div >