<style>
.ui-menu-item{
	font-size:.59em;
	color:blue!important;
}
.ui-autocomplete-category {
	font-weight: bold;
	padding: .1em .1.5em;
	margin: .8em 0 .2em;
	line-height: 1.5;
	font-size:.71em;
}
.ui-autocomplete{
	width:355px!important;
}
.inputaction1{
	width:255px;font-weight:bold;
}
.inputaction2{
	width:255px;font-weight:bold;color:#0B77B7
}
.labelaction{
	font-weight:bold;font-size:1.05em;color:#0B77B7;width:175px;
}
.declabel{width:91px}
.declabel2{width:215px}
.decinput{width:99px}
</style>
<script>

$("#kelurahant_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getKelurahanByKecamatanId')?>");
	
$("#form1t_imunisasi_kipi").validate({focusInvalid:true});

		$("#kabupaten_kotat_pendaftaranadd").remoteChained("#provinsit_pendaftaranadd", "<?=site_url('t_masters/getKabupatenByProvinceId')?>");
		$("#kecamatant_pendaftaranadd").remoteChained("#kabupaten_kotat_pendaftaranadd", "<?=site_url('t_masters/getKecamatanByKabupatenId')?>");
		$("#kelurahant_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getKelurahanByKecamatanId')?>");



</script>

<script>
	$("#form1t_imunisasi_kipi input[name = 'batal'], #backlistt_imunisasi_kipi").click(function(){
		$("#t215","#tabs").empty();
		$("#t215","#tabs").load('t_imunisasi'+'?_=' + (new Date()).getTime());
	});
	$("#desa_kipi").remoteChained("#kec_kipi", "<?=site_url('t_masters/getDesaByKecamatanId')?>");	 
</script>
<div class="mycontent">
<div class="formtitle">Imunisasi KIPI</div>
<div class="backbutton"><span class="kembali" id="backlistt_imunisasi_kipi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
	<div class="subformtitle">Data Pasien</div>
	<fieldset>
		<span>
			<label>Tanggal Imunisasi</label>
			<input type="text" name="" id="" value="<?=$tanggal_imunisasi?>" class="mydate" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Rekam Medis</label>
		<input type="text" name="rekam_medis" id="" value="<?=$KD_PASIEN?>" readonly />
		<input type="hidden" name="kd_trans_imunisasi" id="" value="<?=$KD_TRANS_KIPI?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="" id=""value="<?=$NAMA_LENGKAP?>" readonly  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="" id="" value="<?=$TGL_LAHIR?>" class="mydate" readonly  />		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="text" name="" id=""value="<?=$JENIS_KELAMIN?>" readonly  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Alamat</label>
		<textarea type="text" name="" id="" rows="3" cols="45" readonly><?=$alamat_pasien?></textarea>
		</span>
	</fieldset>
	</fieldset>
	<?=getComboProvinsi($KD_PROVINSI,'provinsipasien','provinsit_pendaftaranadd','readonly','')?>
	<fieldset>
	<span>
	<label>Kab/Kota</label>
		<select name="kabupaten_kotapasien" id="kabupaten_kotat_pendaftaranadd" readonly>
			<option value="<?=$KD_KABKOTA?>">--</option>
		</select>
	</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<select name="kecamatanpasien" id="kecamatant_pendaftaranadd" readonly>
				<option value="<?=$KD_KECAMATAN?>">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desa_kelurahanpasien" id="kelurahant_pendaftaranadd" readonly>
				<option value="<?=$KD_KELURAHAN?>">--</option>
			</select>
		</span>
	</fieldset>
	
	<div class="subformtitle">Data Imunisasi KIPI</div>
	
	<fieldset>
		<span>
			<label>Tanggal KIPI</label>
			<input type="text" name="tgl_kipi" id="" value="<?=$TANGGAL_KIPI?>" class="mydate" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Lokasi</label>
		<input type="text" name="jenis_lokasi_kipi" id="" value="<?=$KATEGORI_IMUNISASI?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Nama Lokasi KIPI</label>
		<input type="text" name="nama_lokasi_kipi" id="" value="<?=$NAMA_LOKASI?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat KIPI</label>
		<textarea type="text" name="alamat_kipi" id="" rows="3" cols="45" readonly><?=$alamat_kipi?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<input type="text" name="kecamatanlokasi" id="kec_kipi" value="<?=$kec_kipi?>" readonly/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desalokasi" id="desa_kipi" readonly>
				<option value="<?=$kel_kipi?>" selected:selected ></option>
			</select>
		</span>
	</fieldset>
	</br>

	<fieldset>
		<span>
		<label>Gejala</label>
		<textarea type="text" name="gejala[]" id="gejala_lain" value="" rows="3" cols="45" readonly><?=$GEJALA_KIPI?></textarea>
		</span>
	</fieldset>
	</fieldset>
	<fieldset>
		<span>
		<label>Kondisi Terakhir</label>
		<input type="text" name="" id="" value="<?=$KEADAAN_KESEHATAN?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Petugas</label>
		<input type="text" name="" id="" value="<?=$dokter?>" readonly />
		</span>
	</fieldset>	
	<br/>
	
	
	
</form>
</div >