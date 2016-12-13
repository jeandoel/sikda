<script>
$(document).ready(function(){
		$('#form1ds_kbadd').ajaxForm({
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
					$("#t804","#tabs").empty();
					$("#t804","#tabs").load('t_ds_kb'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1ds_kbadd").validate({
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
//$("#kec_id_combo_ds_kb").remoteChained("#kab_id_combo_ds_kb", "<?=site_url('t_masters/getKabupatenByProvinceID3')?>");
$("#desa_kel_id_combo_ds_kb").remoteChained("#kec_id_combo_ds_kb", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_kb").remoteChained("#kec_id_combo_ds_kb", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_kb').click(function(){
		$("#t804","#tabs").empty();
		$("#t804","#tabs").load('t_ds_kb'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_kb").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Tambah Data KB</div>
<div class="backbutton"><span class="kembali" id="backlistds_kb">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1ds_kbadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_ds_kb/addprocess')?>" enctype="multipart/form-data">		
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
	<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'KD_KECAMATAN','kec_id_combo_ds_kb','required','')?>
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'KD_KELURAHAN','desa_kel_id_combo_ds_kb','required','')?>
	<?=getComboPuskesmasByKec('','KD_PUSKESMAS','puskesmas_id_combo_ds_kb','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_kb" value="" required />
		</span>
	</fieldset>
	</br>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI MOP</label>
		<input type="text" name="AKS_BDAK_MOP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI MOW</label>
		<input type="text" name="AKS_BDAK_MOW" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI IMPLANT</label>
		<input type="text" name="AKS_BDAK_IMPLANT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI IUD</label>
		<input type="text" name="AKS_BDAK_IUD" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI SUNTIK</label>
		<input type="text" name="AKS_BDAK_SUNTIK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI PIL</label>
		<input type="text" name="AKS_BDAK_PIL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI KONDOM</label>
		<input type="text" name="AKS_BDAK_KONDOM" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR ULANG DENGAN ALAT KONTRASEPSI IMPLANT</label>
		<input type="text" name="AKS_UDAK_IMPLANT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR ULANG DENGAN ALAT KONTRASEPSI IUD</label>
		<input type="text" name="AKS_UDAK_IUD" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR ULANG DENGAN ALAT KONTRASEPSI SUNTIK</label>
		<input type="text" name="AKS_UDAK_SUNTIK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR ULANG DENGAN ALAT KONTRASEPSI PIL</label>
		<input type="text" name="AKS_UDAK_PIL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR ULANG DENGAN ALAT KONTRASEPSI KONDOM</label>
		<input type="text" name="AKS_UDAK_KONDOM" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT MOP</label>
		<input type="text" name="AKS_ADA_MOP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT MOW</label>
		<input type="text" name="AKS_ADA_MOW" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT IMPLANT</label>
		<input type="text" name="AKS_ADA_IMPLANT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT IUD</label>
		<input type="text" name="AKS_ADA_IUD" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT SUNTIK</label>
		<input type="text" name="AKS_ADA_SUNTIK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT PIL</label>
		<input type="text" name="AKS_ADA_PIL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT KONDOM</label>
		<input type="text" name="AKS_ADA_KONDOM" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI MOP</label>
		<input type="text" name="EFK_SMK_MOP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI MOW</label>
		<input type="text" name="EFK_SMK_MOW" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI IMPLANT</label>
		<input type="text" name="EFK_SMK_IMPLANT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI IUD</label>
		<input type="text" name="EFK_SMK_IUD" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI SUNTIK</label>
		<input type="text" name="EFK_SMK_SUNTIK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI PIL</label>
		<input type="text" name="EFK_SMK_PIL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI KONDOM</label>
		<input type="text" name="EFK_SMK_KONDOM" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KOMPLIKASI METODE KONTRASEPSI MOP</label>
		<input type="text" name="KOM_MK_MOP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KOMPLIKASI METODE KONTRASEPSI MOW</label>
		<input type="text" name="KOM_MK_MOW" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KOMPLIKASI METODE KONTRASEPSI IMPLANT</label>
		<input type="text" name="KOM_MK_IMPLANT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KOMPLIKASI METODE KONTRASEPSI IUD</label>
		<input type="text" name="KOM_MK_IUD" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI MOP</label>
		<input type="text" name="KGL_MK_MOP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI MOW</label>
		<input type="text" name="KGL_MK_MOW" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI IMPLANT</label>
		<input type="text" name="KGL_MK_IMPLANT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI IUD</label>
		<input type="text" name="KGL_MK_IUD" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI SUNTIK</label>
		<input type="text" name="KGL_MK_SUNTIK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI PIL</label>
		<input type="text" name="KGL_MK_PIL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI KONDOM</label>
		<input type="text" name="KGL_MK_KONDOM" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle1">PELAYANAN KESEHATAN REPRODUKSI REMAJA</div>
	<fieldset>
		<span>
		<label>JUMLAH REMAJA YG MENDAPAT PENYULUHAN KRR</label>
		<input type="text" name="JML_RYMP_KRR" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PELAYANAN KONSELING REMAJA</label>
		<input type="text" name="JML_PK_REMAJA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BANYAKNYA REMAJA BERMASALAH YANG DITANGANI</label>
		<input type="text" name="JML_BRBY_DITANGANI" value=""  />
		</span>
	</fieldset>

	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >