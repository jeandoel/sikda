<script>
	$('#backlistsysSettingdef').click(function(){
		$("#t30","#tabs").empty();
		$("#t30","#tabs").load('c_sys_setting_def'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Setting Profil Aplikasi</div>
<div class="backbutton"><span class="kembali" id="backlistsysSettingdef">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Provinsi</label>
		<input type="text" name="kd_prov" readonly id="master_propinsi_id_hidden" value="<?=$data->KD_PROV?>" />
		<input type="text" placeholder="Provinsi" readonly name="provinsi" id="master_propinsi_id" value="<?=$data->PROVINSI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kabupaten/Kota</label>
		<input type="text" name="kd_kabkota" readonly id="master_kabupaten_id_hidden" value="<?=$data->KD_KABKOTA?>" />
		<input type="text" placeholder="Kabupaten/Kota" readonly name="kabukota" id="master_kabupaten_id" value="<?=$data->KABUPATEN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kecamatan</label>
		<input type="text" name="kd_kec" readonly id="master_kecamatan_id_hidden" value="<?=$data->KD_KEC?>" />
		<input type="text" placeholder="Kecamatan" readonly name="kecamatan" id="master_kecamatan_id" value="<?=$data->KECAMATAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Puskesmas</label>
		<input type="text" readonly name="kd_puskesmas" readonly id="nama_puskesmas_hidden" value="<?=$data->KD_PUSKESMAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Puskesmas</label>
		<input type="text" readonly name="nama_puskesmas" readonly id="nama_puskesmas" value="<?=$data->NAMA_PUSKESMAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<input type="textarea" readonly name="alamat" readonly id="nama_puskesmas_alamat" value="<?=$data->ALAMAT?>" style="width:410px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Kepala Puskesmas</label>
		<input type="text" readonly name="nama_pimpinan" readonly id="master_dokter_id" value="<?=$data->NAMA_PIMPINAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NIP</label>
		<input type="text" readonly name="nip" readonly id="master_dokter_id_nip" value="<?=$data->NIP?>" />
		</span>
	</fieldset>
	<fieldset style="display:none">
		<span>
		<label>Agama</label>
		<input type="text" readonly name="agama" readonly id="text3" value="<?=$data->AGAMA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Level</label>
		<input type="text" readonly name="level" readonly id="text4" value="<?=$data->LEVEL?>" />
		</span>
	</fieldset>
	<fieldset style="display:none">
		<span>
		<label>Jenis Pasien</label>
		<input type="text" readonly name="jenis_pasien" readonly id="text5" value="<?=$data->CUSTOMER?>" />
		</span>
	</fieldset>
	<fieldset style="display:none">
		<span>
		<label>Cara Bayar</label>
		<input type="text" readonly name="cara_bayar" readonly id="text6" value="<?=$data->CARA?>" />
		</span>
	</fieldset>
	<fieldset style="display:none">
		<span>
		<label>Marital</label>
		<input type="text" readonly name="marital" readonly id="text7" value="<?=$data->STATUS?>" />
		</span>
	</fieldset>
	<fieldset style="display:none">
		<span>
		<label>Pekerjaan</label>
		<input type="text" readonly name="pekerjaan" readonly id="text8" value="<?=$data->KERJA?>" />
		</span>
	</fieldset>
	<fieldset style="display:none">
		<span>
		<label>Pendidikan</label>
		<input type="text" readonly name="pendidikan" readonly id="text9" value="<?=$data->DIDIK?>" />
		</span>
	</fieldset>
	<fieldset style="display:none">
		<span>
		<label>Poli</label>
		<input type="text" readonly name="poli" readonly id="text10" value="<?=$data->UNIT?>" />
		</span>
	</fieldset>
	<fieldset style="display:none">
		<span>
		<label>Gender</label>
		<input type="text" readonly name="gender" readonly id="text11" value="<?=$data->GENDER=='L'?'Laki-laki':'Perempuan'?>" />
		</span>
	</fieldset>
	<fieldset style="display:none">
		<span>
		<label>Suku</label>
		<input type="text" readonly name="suku" readonly id="text12" value="<?=$data->RAS?>" />
		</span>
	</fieldset>
	<fieldset style="display:none">
		<span>
		<label>Unit Pelayanan</label>
		<input type="text" readonly name="unit_pelayanan" readonly id="text13" value="<?=$data->UNIT_PELAYANAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Server Kementrian Kesehatan</label>
		<input type="text" readonly name="server_kemkes" id="text14" value="<?=$data->SERVER_KEMKES?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Server Dinas Kesehatan Provinsi</label>
		<input type="text" readonly name="server_dinkes_prov" id="text15" value="<?=$data->SERVER_DINKES_PROV?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Server Dinas Kesehatan Kabupaten/Kota</label>
		<input type="text" readonly name="server_dinkes_kabkota" id="text16" value="<?=$data->SERVER_DINKES_KAB_KOTA?>" />
		</span>
	</fieldset>
</form>
</div >
