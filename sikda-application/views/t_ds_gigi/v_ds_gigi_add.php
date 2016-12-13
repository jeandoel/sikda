<script>
$(document).ready(function(){
		$('#form1ds_gigiadd').ajaxForm({
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
					$("#t811","#tabs").empty();
					$("#t811","#tabs").load('t_ds_gigi'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1ds_gigiadd").validate({
			rules: {
				tanggal_inspeksi: {
					date:true,
					required: true
				}
			},
			messages: {
				tanggal_inspeksi: {
					required:"Silahkan Lengkapi Data"
				}
			}
		});
})

//$("#kabupaten_kotarmh_sehatadd").remoteChained("#provinsirmh_sehatadd", "<?=site_url('t_masters/getKabupatenByProvinceId2')?>");
//$("#kecamatanrmh_sehatadd").remoteChained("#kabupaten_kotarmh_sehatadd", "<?=site_url('t_masters/getKecamatanByKabupatenId2')?>");
//$("#kelurahanrmh_sehatadd").remoteChained("#kecamatanrmh_sehatadd", "<?=site_url('t_masters/getKelurahanByKecamatanId2')?>");
//$("#kec_id_combo_ds_gigi").remoteChained("#kab_id_combo_ds_gigi", "<?=site_url('t_masters/getKabupatenByProvinceID3')?>");
$("#desa_kel_id_combo_ds_gigi").remoteChained("#kec_id_combo_ds_gigi", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_gigi").remoteChained("#kec_id_combo_ds_gigi", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
   }
});
</script>
<script>
	$('#backlistds_gigi').click(function(){
		$("#t811","#tabs").empty();
		$("#t811","#tabs").load('t_ds_gigi'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_gigi").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Tambah Data Gigi</div>
<div class="backbutton"><span class="kembali" id="backlistds_gigi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<div class="subformtitle">PELAYANAN MEDIK DASAR DI BP GIGI</div>
<form name="frApps" id="form1ds_gigiadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_ds_gigi/addprocess')?>" enctype="multipart/form-data">		
	<fieldset>
		<span>
		<label>Propinsi</label>
		<input type="text" style="width:195px!important" name="" id="textid" value="<?=$this->session->userdata('nama_propinsi')?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten</label>
		<input type="text" style="width:195px!important" name="" id="textid" value="<?=$this->session->userdata('nama_kabupaten')?>" disabled />
		</span>
	</fieldset>
	<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'KD_KECAMATAN','kec_id_combo_ds_gigi','required','')?>
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'KD_KELURAHAN','desa_kel_id_combo_ds_gigi','required','')?>
	<?=getComboPuskesmasByKec('','KD_PUSKESMAS','puskesmas_id_combo_ds_gigi','required','')?>
	<fieldset>
		<span>
		<label>Bulan*</label>
		<select name="BULAN" required>
			<option value="">- pilih bulan -</option>
			<option value="01">Januari</option>
			<option value="02">Februari</option>
			<option value="03">Maret</option>
			<option value="04">April</option>
			<option value="05">Mei</option>
			<option value="06">Juni</option>
			<option value="07">Juli</option>
			<option value="08">Agustus</option>
			<option value="09">September</option>
			<option value="10">Oktober</option>
			<option value="11">November</option>
			<option value="12">Desember</option>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tahun*</label>
		<input type="text" name="TAHUN" id="tahun_ds_gigi" value="" required />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">A. DIAGNOSA</div>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH CARIES DENTIS</label>
		<input type="text" name="JML_L_C_DENTIS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PULPA</label>
		<input type="text" name="JML_L_K_PULPA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PERIODONTAL</label>
		<input type="text" name="JML_L_K_PERIODONTAL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ABSES</label>
		<input type="text" name="JML_L_ABSES" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERSISTENSI</label>
		<input type="text" name="JML_L_PERSISTENSI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_L_LAINLAIN" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle3">PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH CARIES DENTIS</label>
		<input type="text" name="JML_P_C_DENTIS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PULPA</label>
		<input type="text" name="JML_P_K_PULPA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PERIODONTAL</label>
		<input type="text" name="JML_P_K_PERIODONTAL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ABSES</label>
		<input type="text" name="JML_P_ABSES" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERSISTENSI</label>
		<input type="text" name="JML_P_PERSISTENSI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_P_LAINLAIN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">B. PERAWATAN</div>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN TETAP PADA GIGI TETAP</label>
		<input type="text" name="JML_PR_TTG_TETAP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN TETAP PADA GIGI SULUNG</label>
		<input type="text" name="JML_PR_TTG_SULUNG" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN SEMENTARA PADA GIGI TETAP</label>
		<input type="text" name="JML_PR_TTS_TETAP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN SEMENTARA PADA GIGI SULUNG</label>
		<input type="text" name="JML_PR_TTS_SULUNG" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENGOBATAN PULPA</label>
		<input type="text" name="JML_PR_PULPA" value=""  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH PENGOBATAN PERIODONTAL</label>
		<input type="text" name="JML_PR_PERIODONTAL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENGOBATAN ABSES</label>
		<input type="text" name="JML_PR_ABSES" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENCABUTAN GIGI TETAP</label>
		<input type="text" name="JML_PR_PG_TETAP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENCABUTAN GIGI SULUNG</label>
		<input type="text" name="JML_PR_PG_SULUNG" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TINDAKAN SCALING</label>
		<input type="text" name="JML_PR_T_SCALING" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI BARU IBU HAMIL</label>
		<input type="text" name="JML_PR_KRJGBI_HAMIL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI LAMA IBU HAMIL</label>
		<input type="text" name="JML_PR_KRJGLI_HAMIL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_PR_LAINLAIN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">JUMLAH KUNJUNGAN</div>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN BARU ANAK (1-6 TAHUN)</label>
		<input type="text" name="JML_KJ_L_KRJB_ANAK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN LAMA ANAK (1-6 TAHUN)</label>
		<input type="text" name="JML_KJ_L_KRJL_ANAK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN BARU ANAK USIA SEKOLAH (6-12)</label>
		<input type="text" name="JML_KJ_L_KRJB_ANAKSEKOLAH" value=""  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN LAMA ANAK USIA SEKOLAH (6-12)</label>
		<input type="text" name="JML_KJ_L_KRJL_ANAKSEKOLAH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI LAMA LUAR WILAYAH</label>
		<input type="text" name="JML_KJ_L_KRJGLL_WILAYAH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI BARU LUAR WILAYAH</label>
		<input type="text" name="JML_KJ_L_KRJGBL_WILAYAH" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN BARU ANAK (1-6 TAHUN)</label>
		<input type="text" name="JML_KJ_P_KRJB_ANAK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN LAMA ANAK (1-6 TAHUN)</label>
		<input type="text" name="JML_KJ_P_KRJL_ANAK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN BARU ANAK USIA SEKOLAH (6-12)</label>
		<input type="text" name="JML_KJ_P_KRJB_ANAKSEKOLAH" value=""  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN LAMA ANAK USIA SEKOLAH (6-12)</label>
		<input type="text" name="JML_KJ_P_KRJL_ANAKSEKOLAH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI LAMA LUAR WILAYAH</label>
		<input type="text" name="JML_KJ_P_KRJGLL_WILAYAH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI BARU LUAR WILAYAH</label>
		<input type="text" name="JML_KJ_P_KRJGBL_WILAYAH" value=""  />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >