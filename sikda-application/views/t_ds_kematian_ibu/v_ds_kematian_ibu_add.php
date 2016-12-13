<script>
$(document).ready(function(){
		$('#form1ds_kematian_ibuadd').ajaxForm({
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
					$("#t808","#tabs").empty();
					$("#t808","#tabs").load('t_ds_kematian_ibu'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1ds_kematian_ibuadd").validate({
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
//$("#kec_id_combo_ds_kematian_ibu").remoteChained("#kab_id_combo_ds_kematian_ibu", "<?=site_url('t_masters/getKabupatenByProvinceID3')?>");
$("#desa_kel_id_combo_ds_kematian_ibu").remoteChained("#kec_id_combo_ds_kematian_ibu", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_kematian_ibu").remoteChained("#kec_id_combo_ds_kematian_ibu", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_kematian_ibu').click(function(){
		$("#t808","#tabs").empty();
		$("#t808","#tabs").load('t_ds_kematian_ibu'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_kematian_ibu").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Tambah Data Kematian Ibu</div>
<div class="backbutton"><span class="kembali" id="backlistds_kematian_ibu">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<div class="subformtitle">PELAYANAN MEDIS DASAR KEMATIAN IBU</div>
<form name="frApps" id="form1ds_kematian_ibuadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_ds_kematian_ibu/addprocess')?>" enctype="multipart/form-data">		
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
	<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'KD_KECAMATAN','kec_id_combo_ds_kematian_ibu','required','')?>
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'KD_KELURAHAN','desa_kel_id_combo_ds_kematian_ibu','required','')?>
	<?=getComboPuskesmasByKec('','KD_PUSKESMAS','puskesmas_id_combo_ds_kematian_ibu','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_kematian_ibu" value="" required />
		</span>
	</fieldset>
	</br>
		<div class="subformtitle1">A. KEMATIAN IBU</div>
	<fieldset>
		<span>
		<label>JUMLAH KEMATIAN IBU</label>
		<input type="text" name="JML_K_IBU" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IDENTITAS IBU MENGIGGAL UMUR<20TH</label>
		<input type="text" name="JML_IIYM_UMUR_K_20" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IDENTITAS IBU MENGIGGAL UMUR20-30TH</label>
		<input type="text" name="JML_IIYM_UMUR_20_30TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IDENTITAS IBU MENGIGGAL UMUR>30TH</label>
		<input type="text" name="JML_IIYM_UMUR_L_30TH" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">B. PENDIDIKAN</div>
	<fieldset>
		<span>
		<label>JUMLAH PENDIDIKAN SD</label>
		<input type="text" name="JML_P_SD" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENDIDIKAN SLTP</label>
		<input type="text" name="JML_P_SLTP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENDIDIKAN SLTA</label>
		<input type="text" name="JML_P_SLTA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE<5</label>
		<input type="text" name="JML_P_PA_KE_K_5" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE>5</label>
		<input type="text" name="JML_P_PA_KE_L_5" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANC KE<4</label>
		<input type="text" name="JML_P_ANC_K_4" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANC KE>4</label>
		<input type="text" name="JML_P_ANC_L_4" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STATUS IMUNISASI: O</label>
		<input type="text" name="JML_P_S_IMUNISASI_O" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STATUS IMUNISASI: TT1</label>
		<input type="text" name="JML_P_S_IMUNISASI_TT1" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STATUS IMUNISASI: TT2</label>
		<input type="text" name="JML_P_S_IMUNISASI_TT2" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">C. SEBAB KEMATIAN</div>
	<fieldset>
		<span>
		<label>PENDARAHAN</label>
		<input type="text" name="JML_SK_PENDARAHAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EKLAMSI</label>
		<input type="text" name="JML_SK_EKLAMSI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEPSIS</label>
		<input type="text" name="JML_SK_SEPSIS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_SK_LAIN_LAIN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">D. MENINGGAL SAAT</div>
	<fieldset>
		<span>
		<label>HAMIL</label>
		<input type="text" name="JML_MS_HAMIL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NIFAS</label>
		<input type="text" name="JML_MS_NIFAS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BERSALIN</label>
		<input type="text" name="JML_MS_BERSALIN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">E. TEMPAT KEMATIAN</div>
	<fieldset>
		<span>
		<label>RUMAH</label>
		<input type="text" name="JML_TK_KI_RUMAH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PUSKESMAS/RB</label>
		<input type="text" name="JML_TK_KI_PUSKESMAS_R_B" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RUMAH SAKIT</label>
		<input type="text" name="JML_TK_KI_RS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERJALANAN</label>
		<input type="text" name="JML_TK_KI_PERJALANAN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">F. PENOLONG / PERSALINAN</div>
	<fieldset>
		<span>
		<label>DUKUN</label>
		<input type="text" name="JML_KI_PP_DUKUN" value=""  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>BIDAN</label>
		<input type="text" name="JML_KI_PP_BIDAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>DOKTER</label>
		<input type="text" name="JML_KI_PP_DR" value=""  />
		</span>
	</fieldset>
		
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >