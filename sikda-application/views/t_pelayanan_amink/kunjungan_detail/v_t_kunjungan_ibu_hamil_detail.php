<script>
	$('#backlistt_kunjungan_bumil').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kunjungan</div>
<div class="backbutton"><span class="kembali" id="backlistt_kunjungan_bumil">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_kunjungan_bumil_detail" method="post" action="<?=site_url('t_kunjungan_ibu_hamil/detail')?>" enctype="multipart/form-data">
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal Kunjungan</label>
		<input type="text" readonly name="tgl_kunjungan" id="tgl_kunjungan" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		<input type="hidden" name="id" id="kd_bumil" value="<?=$data->KD_KUNJUNGAN_BUMIL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kunjungan Ke</label>
		<input type="text" name="kunjungan_ke" id="kunjungan_ke" value="<?=$data->KUNJUNGAN_KE?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keluhan</label>
		<textarea name="keluhan" id="keluhan" rows="auto" cols="23" readonly><?=$data->KELUHAN?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tekanan Darah (mmHg)</label>
		<input type="text" name="tekanan_darah" id="tekanan_darah"  value="<?=$data->TEKANAN_DARAH?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Badan (Kg)</label>
		<input type="text" name="berat_badan" id="berat_badan"  value="<?=$data->BERAT_BADAN?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Umur Kehamilan (minggu)</label>
		<input type="text" name="umur_hamil" id="umur_hamil"  value="<?=$data->UMUR_KEHAMILAN?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tinggi Fundus (cm)</label>
		<input type="text" name="tinggi_fundus" id="tinggi_fundus"  value="<?=$data->TINGGI_FUNDUS?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Letak Janin</label>
		<input type="text" name="letak_janin" id="letak_janin"  value="<?=$data->LETAK_JANIN?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Denyut Jantung Janin per Menit</label>
		<input type="text" name="denyut_jantung" id="denyut_jantung"  value="<?=$data->DENYUT_JANTUNG?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Kaki Bengkak</label>
		<input type="text" name="kaki_bengkak" id="kaki_bengkak"  value="<?=$data->KAKI_BENGKAK?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Lab Darah HB (gram%)</label>
		<input type="text" name="lab_darah" id="lab_darah"  value="<?=$data->LAB_DARAH_HB?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Lab Urine Reduksi</label>
		<input type="text" name="lab_urin_reduksi" id="lab_urin_reduksi"  value="<?=$data->LAB_URIN_REDUKSI?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Lab Urine Protein</label>
		<input type="text" name="lab_urin_protein" id="lab_urin_protein"  value="<?=$data->LAB_URIN_PROTEIN?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Status Hamil</label>
		<input type="text" name="status_hamil" id="status_hamil"  value="<?=$data->STATUS_HAMIL?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nasehat yang Disampaikan</label>
		<textarea type="text" name="nasehat" id="nasehat" rows="auto" cols="23" readonly ><?=$data->NASEHAT?></textarea>
		</span>
		</fieldset>
	<fieldset>
		<span>
		<label>Tindakan</label>
		<textarea name="tindakan" id="tindakan" rows="auto" cols="23" readonly><?=$data->TINDAKAN?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alergi Obat</label>
		<textarea name="alergi_obat" id="alergi_obat" rows="auto" cols="23" readonly><?=$data->ALERGI?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Obat</label>
		<textarea name="obat" id="obat" rows="auto" cols="23" readonly><?=$data->OBAT?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pemeriksa</label>
		<input type="text" readonly name="nama_pemeriksa" id="nama_pemeriksa" value="<?=$data->DOKTER?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Petugas</label>
		<input type="text" readonly name="nama_petugas" id="nama_petugas" value="<?=$data->PETUGAS?>" readonly />
		</span>
	</fieldset>
</form>
</div >