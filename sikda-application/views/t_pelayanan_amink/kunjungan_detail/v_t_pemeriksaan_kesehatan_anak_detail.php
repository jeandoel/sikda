<script>
	$('#backlistt_pemeriksaan_kesehatan_anak').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Pemeriksaan Anak</div>
<div class="backbutton"><span class="kembali" id="backlistt_pemeriksaan_kesehatan_anak">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pemeriksaan_kesehatan_anak_detail" method="post" action="<?=site_url('t_pemeriksaan_kesehatan_anak/detail')?>" enctype="multipart/form-data">
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal Periksa</label>
		<input type="text" readonly name="tgl_periksa" id="tgl_periksa" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		<input type="hidden" name="id" id="kd_pemeriksaan_anak" value="<?=$data->KD_PEMERIKSAAN_ANAK?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Penyakit/Masalah</label>
		<textarea name="kolom_penyakit" id="kolom_penyakit" rows="auto" cols="23" readonly><?=$data->PENYAKIT?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tindakan</label>
		<textarea name="kolom_tindakan" id="kolom_tindakan" rows="auto" cols="23" readonly><?=$data->PRODUK?></textarea>
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
		<input type="text" readonly name="kolom_nama_pemeriksa" id="kolom_nama_pemeriksa" value="<?=$data->dokter?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Petugas</label>
		<input type="text" readonly name="kolom_nama_petugas" id="kolom_nama_petugas" value="<?=$data->KD_DOKTER_PETUGAS?>" />
		</span>
	</fieldset>
</form>
</div >