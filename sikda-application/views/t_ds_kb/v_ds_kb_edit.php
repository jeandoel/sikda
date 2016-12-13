<script>
$(document).ready(function(){
		$('#form1ds_kbedit').ajaxForm({
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
					$.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
					$("#t804","#tabs").empty();
					$("#t804","#tabs").load('t_ds_kb'+'?_=' + (new Date()).getTime());
				}
			}
		});
})

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
<div class="formtitle">Edit Data KB</div>
<div class="backbutton"><span class="kembali" id="backlistds_kb">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1ds_kbedit" method="post" action="<?=site_url('t_ds_kb/editprocess')?>">	
	<fieldset>
		<span>
		<label>Propinsi</label>
		<input type="text" style="width:195px!important" name="" id="textid" value="<?=$data->PROVINSI?>" disabled />
		<input type="hidden" name="ID" value="<?=$data->ID?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten</label>
		<input type="text" style="width:195px!important" name="" id="textid" value="<?=$data->KABUPATEN?>" disabled />
		</span>
	</fieldset>
	<?=getComboKecamatanByKab($data->KD_KECAMATAN,'KD_KECAMATAN','kec_id_combo_ds_kb','required','')?>
	<?=getComboKelurahanByKec($data->KD_KELURAHAN,'KD_KELURAHAN','desa_kel_id_combo_ds_kb','required','')?>
	<?=getComboPuskesmasByKec($data->KD_PUSKESMAS,'KD_PUSKESMAS','puskesmas_id_combo_ds_kb','required','')?>
	<fieldset>
		<span>
		<label>Bulan*</label>
		<select name="BULAN" required>
			<option value="">- pilih bulan -</option>
			<option value="01" <?=$data->BULAN=='01'?'selected':'';?> >Januari</option>
			<option value="02" <?=$data->BULAN=='02'?'selected':'';?> >Februari</option>
			<option value="03" <?=$data->BULAN=='03'?'selected':'';?> >Maret</option>
			<option value="04" <?=$data->BULAN=='04'?'selected':'';?> >April</option>
			<option value="05" <?=$data->BULAN=='05'?'selected':'';?> >Mei</option>
			<option value="06" <?=$data->BULAN=='06'?'selected':'';?> >Juni</option>
			<option value="07" <?=$data->BULAN=='07'?'selected':'';?> >Juli</option>
			<option value="08" <?=$data->BULAN=='08'?'selected':'';?> >Agustus</option>
			<option value="09" <?=$data->BULAN=='09'?'selected':'';?> >September</option>
			<option value="10" <?=$data->BULAN=='10'?'selected':'';?> >Oktober</option>
			<option value="11" <?=$data->BULAN=='11'?'selected':'';?> >November</option>
			<option value="12" <?=$data->BULAN=='12'?'selected':'';?> >Desember</option>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tahun*</label>
		<input type="text" name="TAHUN" id="tahun_ds_kb" value="<?=$data->TAHUN?>" required />
		</span>
	</fieldset>
	</br>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI MOP</label>
		<input type="text" name="AKS_BDAK_MOP" value="<?=$data->AKS_BDAK_MOP?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI MOW</label>
		<input type="text" name="AKS_BDAK_MOW" value="<?=$data->AKS_BDAK_MOW?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI IMPLANT</label>
		<input type="text" name="AKS_BDAK_IMPLANT" value="<?=$data->AKS_BDAK_IMPLANT	?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI IUD</label>
		<input type="text" name="AKS_BDAK_IUD" value="<?=$data->AKS_BDAK_IUD?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI SUNTIK</label>
		<input type="text" name="AKS_BDAK_SUNTIK" value="<?=$data->AKS_BDAK_SUNTIK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI PIL</label>
		<input type="text" name="AKS_BDAK_PIL" value="<?=$data->AKS_BDAK_PIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR BARU DENGAN ALAT KONTRASEPSI KONDOM</label>
		<input type="text" name="AKS_BDAK_KONDOM" value="<?=$data->AKS_BDAK_KONDOM?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR ULANG DENGAN ALAT KONTRASEPSI IMPLANT</label>
		<input type="text" name="AKS_UDAK_IMPLANT" value="<?=$data->AKS_UDAK_IMPLANT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR ULANG DENGAN ALAT KONTRASEPSI IUD</label>
		<input type="text" name="AKS_UDAK_IUD" value="<?=$data->AKS_UDAK_IUD?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR ULANG DENGAN ALAT KONTRASEPSI SUNTIK</label>
		<input type="text" name="AKS_UDAK_SUNTIK" value="<?=$data->AKS_UDAK_SUNTIK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR ULANG DENGAN ALAT KONTRASEPSI PIL</label>
		<input type="text" name="AKS_UDAK_PIL" value="<?=$data->AKS_UDAK_PIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR ULANG DENGAN ALAT KONTRASEPSI KONDOM</label>
		<input type="text" name="AKS_UDAK_KONDOM" value="<?=$data->AKS_UDAK_KONDOM?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT MOP</label>
		<input type="text" name="AKS_ADA_MOP" value="<?=$data->AKS_ADA_MOP?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT MOW</label>
		<input type="text" name="AKS_ADA_MOW" value="<?=$data->AKS_ADA_MOW?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT IMPLANT</label>
		<input type="text" name="AKS_ADA_IMPLANT" value="<?=$data->AKS_ADA_IMPLANT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT IUD</label>
		<input type="text" name="AKS_ADA_IUD" value="<?=$data->AKS_ADA_IUD?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT SUNTIK</label>
		<input type="text" name="AKS_ADA_SUNTIK" value="<?=$data->AKS_ADA_SUNTIK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT PIL</label>
		<input type="text" name="AKS_ADA_PIL" value="<?=$data->AKS_ADA_PIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>AKSEPTOR AKTIF (CU) DENGAN ALAT KONDOM</label>
		<input type="text" name="AKS_ADA_KONDOM" value="<?=$data->AKS_ADA_KONDOM?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI MOP</label>
		<input type="text" name="EFK_SMK_MOP" value="<?=$data->EFK_SMK_MOP?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI MOW</label>
		<input type="text" name="EFK_SMK_MOW" value="<?=$data->EFK_SMK_MOW?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI IMPLANT</label>
		<input type="text" name="EFK_SMK_IMPLANT" value="<?=$data->EFK_SMK_IMPLANT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI IUD</label>
		<input type="text" name="EFK_SMK_IUD" value="<?=$data->EFK_SMK_IUD?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI SUNTIK</label>
		<input type="text" name="EFK_SMK_SUNTIK" value="<?=$data->EFK_SMK_SUNTIK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI PIL</label>
		<input type="text" name="EFK_SMK_PIL" value="<?=$data->EFK_SMK_PIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EFEK SAMPING METODE KONTRASEPSI KONDOM</label>
		<input type="text" name="EFK_SMK_KONDOM" value="<?=$data->EFK_SMK_KONDOM?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KOMPLIKASI METODE KONTRASEPSI MOP</label>
		<input type="text" name="KOM_MK_MOP" value="<?=$data->KOM_MK_MOP?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KOMPLIKASI METODE KONTRASEPSI MOW</label>
		<input type="text" name="KOM_MK_MOW" value="<?=$data->KOM_MK_MOW?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KOMPLIKASI METODE KONTRASEPSI IMPLANT</label>
		<input type="text" name="KOM_MK_IMPLANT" value="<?=$data->KOM_MK_IMPLANT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KOMPLIKASI METODE KONTRASEPSI IUD</label>
		<input type="text" name="KOM_MK_IUD" value="<?=$data->KOM_MK_IUD?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI MOP</label>
		<input type="text" name="KGL_MK_MOP" value="<?=$data->KGL_MK_MOP?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI MOW</label>
		<input type="text" name="KGL_MK_MOW" value="<?=$data->KGL_MK_MOW?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI IMPLANT</label>
		<input type="text" name="KGL_MK_IMPLANT" value="<?=$data->KGL_MK_IMPLANT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI IUD</label>
		<input type="text" name="KGL_MK_IUD" value="<?=$data->KGL_MK_IUD?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI SUNTIK</label>
		<input type="text" name="KGL_MK_SUNTIK" value="<?=$data->KGL_MK_SUNTIK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI PIL</label>
		<input type="text" name="KGL_MK_PIL" value="<?=$data->KGL_MK_PIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEGAGALAN METODE KONTRASEPSI KONDOM</label>
		<input type="text" name="KGL_MK_KONDOM" value="<?=$data->KGL_MK_KONDOM?>"  />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle1">PELAYANAN KESEHATAN REPRODUKSI REMAJA</div>
	<br/>
	<fieldset>
		<span>
		<label>JUMLAH REMAJA YG MENDAPAT PENYULUHAN KRR</label>
		<input type="text" name="JML_RYMP_KRR" value="<?=$data->JML_RYMP_KRR?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PELAYANAN KONSELING REMAJA</label>
		<input type="text" name="JML_PK_REMAJA" value="<?=$data->JML_PK_REMAJA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BANYAKNYA REMAJA BERMASALAH YANG DITANGANI</label>
		<input type="text" name="JML_BRBY_DITANGANI" value="<?=$data->JML_BRBY_DITANGANI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >