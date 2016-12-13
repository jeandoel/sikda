<script>
$(document).ready(function(){
		$('#form1ds_promkesadd').ajaxForm({
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
					$("#t810","#tabs").empty();
					$("#t810","#tabs").load('t_ds_promkes'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1ds_promkesadd").validate({
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
//$("#kec_id_combo_ds_promkes").remoteChained("#kab_id_combo_ds_promkes", "<?=site_url('t_masters/getKabupatenByProvinceID3')?>");
$("#desa_kel_id_combo_ds_promkes").remoteChained("#kec_id_combo_ds_promkes", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_promkes").remoteChained("#kec_id_combo_ds_promkes", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_promkes').click(function(){
		$("#t810","#tabs").empty();
		$("#t810","#tabs").load('t_ds_promkes'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_promkes").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Tambah Data Promkes</div>
<div class="backbutton"><span class="kembali" id="backlistds_promkes">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<div class="subformtitle">PELAYANAN MEDIK DASAR DI BP PROMKES</div>
<form name="frApps" id="form1ds_promkesadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_ds_promkes/addprocess')?>" enctype="multipart/form-data">		
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
	<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'KD_KECAMATAN','kec_id_combo_ds_promkes','required','')?>
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'KD_KELURAHAN','desa_kel_id_combo_ds_promkes','required','')?>
	<?=getComboPuskesmasByKec('','KD_PUSKESMAS','puskesmas_id_combo_ds_promkes','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_promkes" value="" required />
		</span>
	</fieldset>
	</br>
	<fieldset>
		<span>
		<label>POSYANDU YANG AKTIF</label>
		<input type="text" name="JML_P_AKTIF" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>POSYANDU PRATAMA</label>
		<input type="text" name="JML_P_PRATAMA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>POSYANDU MADYA</label>
		<input type="text" name="JML_P_MADYA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>POSYANDU PURNAMA</label>
		<input type="text" name="JML_P_PURNAMA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>POSYANDU MANDIRI</label>
		<input type="text" name="JML_P_MANDIRI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>POSYANDU LANSIA</label>
		<input type="text" name="JML_P_LANSIA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAPORAN KEGIATAN POSYANDU LANSIA</label>
		<input type="text" name="JML_LKP_LANSIA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KADER AKTIF</label>
		<input type="text" name="JML_KADER_AKTIF" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PONDOK PESANTREN YANG DIBINA</label>
		<input type="text" name="JML_PP_DIBINA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>FREKUENSI PEMBINAAN PONDOK PESANTREN</label>
		<input type="text" name="JML_FPP_PESANTREN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SOSIALISASI KEGIATAN SAKA BAKTI HUSADA</label>
		<input type="text" name="JML_SKSB_HUSADA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMBINAAN SAKA BAKTI HUSADA</label>
		<input type="text" name="JML_PSB_HUSADA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PENYULUHAN DB</label>
		<input type="text" name="JML_PENYULUHAN_DB" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PENYULUHAN KESLING</label>
		<input type="text" name="JML_PENYULUHAN_KESLING" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PENYULUHAN KIA</label>
		<input type="text" name="JML_PENYULUHAN_KIA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PENYULUHAN TBC</label>
		<input type="text" name="JML_PENYULUHAN_TBC" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PENYULUHAN NAPZA</label>
		<input type="text" name="JML_PENYULUHAN_NAPZA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PENYULUHAN PTM</label>
		<input type="text" name="JML_PENYULUHAN_PTM" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PENYULUHAN MALARIA</label>
		<input type="text" name="JML_PENYULUHAN_MALARIA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PENYULUHAN DIARE</label>
		<input type="text" name="JML_PENYULUHAN_DIARE" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PENYULUHAN GIZI</label>
		<input type="text" name="JML_PENYULUHAN_GIZI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PENYULUHAN PHBS</label>
		<input type="text" name="JML_PENYULUHAN_PHBS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMBERDAYAAN DALAM PSN</label>
		<input type="text" name="JML_PD_PSN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUMAH BEBAS JENTIK</label>
		<input type="text" name="JML_RMH_BEBAS_JENTIK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUMAH DIPERIKSA</label>
		<input type="text" name="JML_RMH_DIPERIKSA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TTU BEBAS JENTIK</label>
		<input type="text" name="JML_TTU_BEBAS_JENTIK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TTU DIPERIKSA</label>
		<input type="text" name="JML_TTU_DIPERIKSA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TOGA</label>
		<input type="text" name="JML_TOGA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMBERDAYAAN TOMAGA</label>
		<input type="text" name="JML_P_TOMAGA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMBINAAN UKK</label>
		<input type="text" name="JML_P_UKK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMBINAAN DESA SIAGA</label>
		<input type="text" name="JML_PD_SIAGA" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">RUMAH TANGGA</div>
	<fieldset>
		<span>
		<label>RUMAH TANGGA PRATAMA</label>
		<input type="text" name="JML_RT_PRATAMA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RUMAH TANGGA MADYA</label>
		<input type="text" name="JML_RT_MADYA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RUMAH TANGGA UTAMA</label>
		<input type="text" name="JML_RT_UTAMA" value=""  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>RUMAH TANGGA PARIPURNA</label>
		<input type="text" name="JML_RT_PARIPURNA" value=""  />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >