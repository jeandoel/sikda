<script>
$(document).ready(function(){
		$('#form1ds_ukgsadd').ajaxForm({
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
					$("#t812","#tabs").empty();
					$("#t812","#tabs").load('t_ds_ukgs'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1ds_ukgsadd").validate({
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
//$("#kec_id_combo_ds_ukgs").remoteChained("#kab_id_combo_ds_ukgs", "<?=site_url('t_masters/getKabupatenByProvinceID3')?>");
$("#desa_kel_id_combo_ds_ukgs").remoteChained("#kec_id_combo_ds_ukgs", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_ukgs").remoteChained("#kec_id_combo_ds_ukgs", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_ukgs').click(function(){
		$("#t812","#tabs").empty();
		$("#t812","#tabs").load('t_ds_ukgs'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_ukgs").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Tambah Data UKGS</div>
<div class="backbutton"><span class="kembali" id="backlistds_ukgs">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<div class="subformtitle">PELAYANAN MEDIK DASAR DI BP UKGS</div>
<form name="frApps" id="form1ds_ukgsadd" method="post" action="<?=site_url('t_ds_ukgs/addprocess')?>" enctype="multipart/form-data">		
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
	<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'KD_KECAMATAN','kec_id_combo_ds_ukgs','required','')?>
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'KD_KELURAHAN','desa_kel_id_combo_ds_ukgs','required','')?>
	<?=getComboPuskesmasByKec('','KD_PUSKESMAS','puskesmas_id_combo_ds_ukgs','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_ukgs" value="" required />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">PELAYANAN MEDIK DASAR GIGI UKGS</div>
	<fieldset>
		<span>
		<label>SD UKGS TAHAP III</label>
		<input type="text" name="JML_PMDGU_SD_UKGS_TAHAP_III" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SD UKGS INTEGRASI</label>
		<input type="text" name="JML_PMDGU_SD_UKGS_INTEGRASI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID LAKI-LAKI SD KLS V DAN VI UKGS SELEKTIF TAHAP III</label>
		<input type="text" name="JML_PMDGU_L_SD_V_VI_UKGS_III" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID LAKI-LAKI SD KLS V DAN VI UKGS SELEKTIF TAHAP III YG SELESAI PERAWATAN</label>
		<input type="text" name="JML_PMDGU_L_SD_V_VI_UKGS_III_PERAWATAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID PEREMPUAN SD KLS V DAN VI UKGS SELEKTIF TAHAP III</label>
		<input type="text" name="JML_PMDGU_P_SD_V_VI_UKGS_III" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID PEREMPUAN SD KLS V DAN VI UKGS SELEKTIF TAHAP III YG SELESAI PERAWATAN</label>
		<input type="text" name="JML_PMDGU_P_SD_V_VI_UKGS_III_PERAWATAN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle2">LAKI-LAKI :</div>
	<div class="subformtitle3">PEMERIKSAAN :</div>
	<fieldset>
		<span>
		<label>JUMLAH PEMERIKSAAN BARU</label>
		<input type="text" name="JML_PEMERIKSAAN_L_BARU" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PEMERIKSAAN LAMA</label>
		<input type="text" name="JML_PEMERIKSAAN_L_LAMA" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle3">DIAGNOSA : </div>
	<fieldset>
		<span>
		<label>JUMLAH CARIES DENTIS</label>
		<input type="text" name="JML_DIAGNOSA_L_C_DENTIS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PULPA</label>
		<input type="text" name="JML_DIAGNOSA_L_K_PULPA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PERIODONTAL</label>
		<input type="text" name="JML_DIAGNOSA_L_K_PERIODONTAL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ABSES</label>
		<input type="text" name="JML_DIAGNOSA_L_ABSES" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERSISTENSI</label>
		<input type="text" name="JML_DIAGNOSA_L_PERSISTENSI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_DIAGNOSA_L_LAINLAIN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle2">PEREMPUAN :</div>
	<div class="subformtitle3">PEMERIKSAAN :</div>
	<fieldset>
		<span>
		<label>JUMLAH PEMERIKSAAN BARU</label>
		<input type="text" name="JML_PEMERIKSAAN_P_BARU" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PEMERIKSAAN LAMA</label>
		<input type="text" name="JML_PEMERIKSAAN_P_LAMA" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle3">DIAGNOSA :</div>
	<fieldset>
		<span>
		<label>JUMLAH CARIES DENTIS</label>
		<input type="text" name="JML_DIAGNOSA_P_C_DENTIS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PULPA</label>
		<input type="text" name="JML_DIAGNOSA_P_K_PULPA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PERIODONTAL</label>
		<input type="text" name="JML_DIAGNOSA_P_K_PERIODONTAL" value=""  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH ABSES</label>
		<input type="text" name="JML_DIAGNOSA_P_ABSES" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERSISTENSI</label>
		<input type="text" name="JML_DIAGNOSA_P_PERSISTENSI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_DIAGNOSA_P_LAINLAIN" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle3">PERAWATAN :</div>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN TETAP PADA GIGI TETAP</label>
		<input type="text" name="JML_PERAWATAN_P_TTP_GIGITETAP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN TETAP PADA GIGI SULUNG</label>
		<input type="text" name="JML_PERAWATAN_P_TTP_GIGISULUNG" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN SEMENTARA</label>
		<input type="text" name="JML_PERAWATAN_P_T_SEMENTARA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENGOBATAN PULPA</label>
		<input type="text" name="JML_PERAWATAN_P_P_PULPA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENGOBATAN PERIODENTAL</label>
		<input type="text" name="JML_PERAWATAN_P_P_PERIODENTAL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENGOBATAN ABSES</label>
		<input type="text" name="JML_PERAWATAN_P_P_ABSES" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TINDAKAN SCALLING</label>
		<input type="text" name="JML_PERAWATAN_P_T_SCALLING" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENCABUTAN GIGI TETAP</label>
		<input type="text" name="JML_PERAWATAN_P_P_GIGITETAP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENCABUTAN GIGI SULUNG</label>
		<input type="text" name="JML_PERAWATAN_P_P_GIGISULUNG" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_PERAWATAN_P_LAINLAIN" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle3">PEMBINAAN :</div>
	<fieldset>
		<span>
		<label>JUMLAH PENYULUHAN KESEHATAN GIGI MELALUI KELAS</label>
		<input type="text" name="JML_PEMBINAAN_P_PKGM_KELAS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PEMBINAAN KE SD UKGS</label>
		<input type="text" name="JML_PEMBINAAN_P_PKSD_UKGS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PEMBINAAN KE DESA UKGMD</label>
		<input type="text" name="JML_PEMBINAAN_P_PKD_UKGM" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENDUDUK YG MENDAPAT PELAYANAN GIGI SEDERHANA OLEH KADER</label>
		<input type="text" name="JML_PEMBINAAN_P_PYMPGSO_KADER" value=""  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH POSYANDU DENGAN KESEHATAN GIGI</label>
		<input type="text" name="JML_PEMBINAAN_P_PDK_GIGI" value=""  />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >