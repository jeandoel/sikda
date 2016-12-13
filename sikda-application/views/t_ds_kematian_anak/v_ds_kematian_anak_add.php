<script>
$(document).ready(function(){
		$('#form1ds_kematian_anakadd').ajaxForm({
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
					$("#t809","#tabs").empty();
					$("#t809","#tabs").load('t_ds_kematian_anak'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1ds_kematian_anakadd").validate({
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
//$("#kec_id_combo_ds_kematian_anak").remoteChained("#kab_id_combo_ds_kematian_anak", "<?=site_url('t_masters/getKabupatenByProvinceID3')?>");
$("#desa_kel_id_combo_ds_kematian_anak").remoteChained("#kec_id_combo_ds_kematian_anak", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_kematian_anak").remoteChained("#kec_id_combo_ds_kematian_anak", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_kematian_anak').click(function(){
		$("#t809","#tabs").empty();
		$("#t809","#tabs").load('t_ds_kematian_anak'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_kematian_anak").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Tambah Data Kematian Bayi</div>
<div class="backbutton"><span class="kembali" id="backlistds_kematian_anak">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<div class="subformtitle">PELAYANAN MEDIS DASAR KEMATIAN BAYI</div>
<form name="frApps" id="form1ds_kematian_anakadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_ds_kematian_anak/addprocess')?>" enctype="multipart/form-data">		
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
	<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'KD_KECAMATAN','kec_id_combo_ds_kematian_anak','required','')?>
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'KD_KELURAHAN','desa_kel_id_combo_ds_kematian_anak','required','')?>
	<?=getComboPuskesmasByKec('','KD_PUSKESMAS','puskesmas_id_combo_ds_kematian_anak','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_kematian_anak" value="" required />
		</span>
	</fieldset>
	</br>
		<div class="subformtitle1">KEMATIAN BAYI</div>
		<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH KEMATIAN BAYI LAKI-LAKI</label>
		<input type="text" name="JML_L_K_BAYI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 0-7 HARI</label>
		<input type="text" name="JML_L_U_0_7_HARI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 8-30 HARI</label>
		<input type="text" name="JML_L_U_8_30_HARI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 1-12 BULAN</label>
		<input type="text" name="JML_L_U_1_12_BULAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 1-5 TAHUN</label>
		<input type="text" name="JML_L_U_1_5_TAHUN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE<5</label>
		<input type="text" name="JML_P_PA_KE_KSD_5_L" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE>5</label>
		<input type="text" name="JML_P_PA_KE_L_5_L" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">B. PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH KEMATIAN BAYI PEREMPUAN</label>
		<input type="text" name="JML_P_K_BAYI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 0-7 HARI</label>
		<input type="text" name="JML_P_U_0_7_HARI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 8-30 HARI</label>
		<input type="text" name="JML_P_U_8_30_HARI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 1-12 BULAN</label>
		<input type="text" name="JML_P_U_1_12_BULAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 1-5 TAHUN</label>
		<input type="text" name="JML_P_U_1_5_TAHUN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE<5</label>
		<input type="text" name="JML_P_PA_KE_KSD_5" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE>5</label>
		<input type="text" name="JML_P_PA_KE_L_5" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">C. ANC</div>
	<fieldset>
		<span>
		<label>ANC <4</label>
		<input type="text" name="JML_ANC_KSD_4" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANC >4</label>
		<input type="text" name="JML_ANC_L_4" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">D. STATUS IMUNISASI</div>
	<fieldset>
		<span>
		<label>BCG</label>
		<input type="text" name="JML_SI_BCG" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>DPT</label>
		<input type="text" name="JML_SI_DPT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>POLIO</label>
		<input type="text" name="JML_SI_POLIO" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>CAMPAK</label>
		<input type="text" name="JML_SI_CAMPAK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>HB</label>
		<input type="text" name="JML_SI_HB" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">E. SEBAB KEMATIAN</div>
	<fieldset>
		<span>
		<label>TETANUS NEONATORIUM(TN)</label>
		<input type="text" name="JML_SK_TN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BBLR</label>
		<input type="text" name="JML_SK_BBLR" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ASFEKSIA</label>
		<input type="text" name="JML_SK_ASFEKSIA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_SK_LAIN_LAIN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">F. TEMPAT KEMATIAN</div>
	<fieldset>
		<span>
		<label>RUMAH</label>
		<input type="text" name="JML_TK_RUMAH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PUSKESMAS/RB</label>
		<input type="text" name="JML_TK_PUSKESMAS_RB" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RUMAH SAKIT</label>
		<input type="text" name="JML_TK_RS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERJALANAN</label>
		<input type="text" name="JML_TK_PERJALANAN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">G. PENOLONG / PERSALINAN</div>
	<fieldset>
		<span>
		<label>DUKUN</label>
		<input type="text" name="JML_PP_DUKUN" value=""  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>BIDAN</label>
		<input type="text" name="JML_PP_BIDAN" value=""  />
		</span>
	</fieldset>
			
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >