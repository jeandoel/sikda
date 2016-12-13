<script>
$(document).ready(function(){
	$('#form1t_pelayanan_imunisasi').ajaxForm({
		beforeSend: function() {
			achtungShowLoader();	
		},
		uploadProgress: function(event, position, total, percentComplete) {
		},
		complete: function(xhr) {
			achtungHideLoader();
			if(xhr.responseText!=='OK'){
				$.achtung({message: xhr.responseText, timeout:5});
			}else{
				$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
				$("#t203","#tabs").empty();
				$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
			}
		}
	});	
	$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(a) {
		var n = $(":text,:radio,:checkbox,select,textarea").length;
		if (a.which == 13) 
		{
			a.preventDefault();
			var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
			var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
			if(nextIndex < n && $('#form1t_pelayanan_imunisasi').valid()){
				$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
			}else{			
				if($('#form1t_pelayanan_imunisasi').valid()) {
					$('#form1t_pelayanan_imunisasi').submit();
				}
				return false;
			}
		}
	});
	$('#carabayart_pendaftaranadd').chained('#jenis_pasient_pendaftaranadd');
	$('#formkategori_imunisasi').load('t_imunisasi_dg/get_imu?kdpasien='+$('#kdpasien').val());
	$('#tgl_pelayanan').focus();
});

</script>
<script>
	$("#form1t_pelayanan_imunisasi input[name = 'batal'], #backt_pelayanan_imunisasi").click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	});
</script>
<div class="mycontent">
<div class="formtitle">Pelayanan Imunisasi</div>
<div class="backbutton"><span class="kembali" id="backt_pelayanan_imunisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pelayanan_imunisasi" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_imunisasi_dg/processimunisasi')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis#</label>
		<input type="text" name="kdpasien" id="pas" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kdpasien" id="kdpasien" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid1" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid2" value="<?=$data->ID_KUNJUNGAN?>" />
		<input type="hidden" name="kd_unit_hidden" id="textid3" value="<?=$data->KD_UNIT?>" />
		<input type="hidden" name="kd_urutmasuk_hidden" id="textid4" value="<?=$data->URUT_MASUK?>" />
		<input type="hidden" name="kd_unitpel_hidden" id="textid5" value="<?=$data->KD_UNIT_LAYANAN?>" />
		<input type="hidden" name="kd_kec_hidden" id="textid6" value="<?=$data->KD_KECAMATAN?>" />
		<input type="hidden" name="kd_kel_hidden" id="textid7" value="<?=$data->KD_KELURAHAN?>" />
		</span>
		<span>
		<label>NIK</label>
		<input type="text" name="text" value="<?=$data->NIK?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="text" value="<?=$data->NAMA_PASIEN?>" disabled />
		</span>
		<span>
		<label>Golongan Darah</label>
		<input type="text" name="text" value="<?=$data->KD_GOL_DARAH?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Pasien</label>
		<input type="text" name="text" value="<?=$data->CUSTOMER?>" disabled />
		</span>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="text" value="<?=$data->TGL_LAHIR?>" disabled />
		</span>
	</fieldset>
	<div class="subformtitle">Pelayanan</div>
	<fieldset>
		<span>
		<label>Tanggal Pelayanan</label>
		<input id="tgl_pelayanan" class="mydate" type="text" name="tgl_pelayanan" value="<?=date('d/m/Y')?>" required>
		</span>
	</fieldset>
	<fieldset>		
		<?=getComboJenispasien($data->KD_CUSTOMER,'jenis_pasien','jenis_pasient_pendaftaranadd','','inline')?>
		<?=getComboCarabayar($data->CARA_BAYAR,'cara_bayar','carabayart_pendaftaranadd','','inline')?>
	</fieldset>
	<div id="formkategori_imunisasi"><!--Show_hide kategori Imunisasi--></div>
	<fieldset>
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" name="bt1" value="Simpan"/>
		</span>
	</fieldset>	
</form>
</div >