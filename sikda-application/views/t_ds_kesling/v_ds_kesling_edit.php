<script>
$(document).ready(function(){
		$('#form1ds_keslingedit').ajaxForm({
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
					$("#t805","#tabs").empty();
					$("#t805","#tabs").load('t_ds_kesling'+'?_=' + (new Date()).getTime());
				}
			}
		});
})

$("#desa_kel_id_combo_ds_kesling").remoteChained("#kec_id_combo_ds_kesling", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_kesling").remoteChained("#kec_id_combo_ds_kesling", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_kia').click(function(){
		$("#t805","#tabs").empty();
		$("#t805","#tabs").load('t_ds_kesling'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_kesling").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Edit Data Kesehatan Lingkungan</div>
<div class="backbutton"><span class="kembali" id="backlistds_kia">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1ds_keslingedit" method="post" action="<?=site_url('t_ds_kesling/editprocess')?>">	
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
	<?=getComboKecamatanByKab($data->KD_KECAMATAN,'KD_KECAMATAN','kec_id_combo_ds_kesling','required','')?>
	<?=getComboKelurahanByKec($data->KD_KELURAHAN,'KD_KELURAHAN','desa_kel_id_combo_ds_kesling','required','')?>
	<?=getComboPuskesmasByKec($data->KD_PUSKESMAS,'KD_PUSKESMAS','puskesmas_id_combo_ds_kesling','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_kesling" value="<?=$data->TAHUN?>" required />
		</span>
	</fieldset>
	<div class="menu_jk">
	<div class="menu_l"><b>Diperiksa</b></div><div class="menu_p"><b>Memenuhi Syarat</b></div>
	</div>
	</br>
	<fieldset>
		<span>
		<label>SD/MI</label>
		<input type="text" name="SD_MI" value="<?=$data->SD_MI?>"  />
		<input type="text" name="SD_MI_MS" value="<?=$data->SD_MI_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SLTP/MTs</label>
		<input type="text" name="SLTP_MTS" value="<?=$data->SLTP_MTS?>"  />
		<input type="text" name="SLTP_MTS_MS" value="<?=$data->SLTP_MTS_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SLTA/MA</label>
		<input type="text" name="SLTA_MA" value="<?=$data->SLTA_MA?>"  />
		<input type="text" name="SLTA_MA_MS" value="<?=$data->SLTA_MA_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERGURUAN TINGG</label>
		<input type="text" name="PERGURUAN_TINGGI" value="<?=$data->PERGURUAN_TINGGI?>"  />
		<input type="text" name="PERGURUAN_TINGGI_MS" value="<?=$data->PERGURUAN_TINGGI_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KIOS/KUD</label>
		<input type="text" name="KIOS_KUD" value="<?=$data->KIOS_KUD?>"  />
		<input type="text" name="KIOS_KUD_MS" value="<?=$data->KIOS_KUD_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>HOTEL MELATI/LOSMEN</label>
		<input type="text" name="HOTEL_MELATI_LOSMEN" value="<?=$data->HOTEL_MELATI_LOSMEN?>"  />
		<input type="text" name="HOTEL_MELATI_LOSMEN_MS" value="<?=$data->HOTEL_MELATI_LOSMEN_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SALON KECANTIKAN/PANGKAS RAMBUT</label>
		<input type="text" name="SALON_KECNTIKAN_P_RAMBUT" value="<?=$data->SALON_KECNTIKAN_P_RAMBUT?>"  />
		<input type="text" name="SALON_KECNTIKAN_P_RAMBUT_MS" value="<?=$data->SALON_KECNTIKAN_P_RAMBUT_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TEMPAT REKREASI</label>
		<input type="text" name="TEMPAT_REKREASI" value="<?=$data->TEMPAT_REKREASI?>"  />
		<input type="text" name="TEMPAT_REKREASI_MS" value="<?=$data->TEMPAT_REKREASI_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>GEDUNG PERTEMUAN/GEDUNG PERTUNJUKAN</label>
		<input type="text" name="GD_PERTEMUAN_GD_PERTUNJUKAN" value="<?=$data->GD_PERTEMUAN_GD_PERTUNJUKAN?>"  />
		<input type="text" name="GD_PERTEMUAN_GD_PERTUNJUKAN_MS" value="<?=$data->GD_PERTEMUAN_GD_PERTUNJUKAN_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KOLAM RENANG</label>
		<input type="text" name="KOLAM_RENANG" value="<?=$data->KOLAM_RENANG?>"  />
		<input type="text" name="KOLAM_RENANG_MS" value="<?=$data->KOLAM_RENANG_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>MASJID/MUSHOLA</label>
		<input type="text" name="MASJID_MUSHOLA" value="<?=$data->MASJID_MUSHOLA?>"  />
		<input type="text" name="MASJID_MUSHOLA_MS" value="<?=$data->MASJID_MUSHOLA_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>GEREJA</label>
		<input type="text" name="GEREJA" value="<?=$data->GEREJA?>"  />
		<input type="text" name="GEREJA_MS" value="<?=$data->GEREJA_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KELENTENG</label>
		<input type="text" name="KELENTENG" value="<?=$data->KELENTENG?>"  />
		<input type="text" name="KELENTENG_MS" value="<?=$data->KELENTENG_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PURA</label>
		<input type="text" name="PURA" value="<?=$data->PURA?>"  />
		<input type="text" name="PURA_MS" value="<?=$data->PURA_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>WIHARA</label>
		<input type="text" name="WIHARA" value="<?=$data->WIHARA?>"  />
		<input type="text" name="WIHARA_MS" value="<?=$data->WIHARA_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TERMINAL</label>
		<input type="text" name="TERMINAL" value="<?=$data->TERMINAL?>"  />
		<input type="text" name="TERMINAL_MS" value="<?=$data->TERMINAL_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STASIUN</label>
		<input type="text" name="STASIUN" value="<?=$data->STASIUN?>"  />
		<input type="text" name="STASIUN_MS" value="<?=$data->STASIUN_MS?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>PELABUHAN LAUT</label>
		<input type="text" name="PELABUHAN_LAUT" value="<?=$data->PELABUHAN_LAUT?>"  />
		<input type="text" name="PELABUHAN_LAUT_MS" value="<?=$data->PELABUHAN_LAUT_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PASAR</label>
		<input type="text" name="PASAR" value="<?=$data->PASAR?>"  />
		<input type="text" name="PASAR_MS" value="<?=$data->PASAR_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>APOTIK</label>
		<input type="text" name="APOTIK" value="<?=$data->APOTIK?>"  />
		<input type="text" name="APOTIK_MS" value="<?=$data->APOTIK_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TOKO OBAT</label>
		<input type="text" name="TOKO_OBAT" value="<?=$data->TOKO_OBAT?>"  />
		<input type="text" name="TOKO_OBAT_MS" value="<?=$data->TOKO_OBAT_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SARANA/PANTI SOSIAL</label>
		<input type="text" name="SARANA_PANTI_SOSIAL" value="<?=$data->SARANA_PANTI_SOSIAL?>"  />
		<input type="text" name="SARANA_PANTI_SOSIAL_MS" value="<?=$data->SARANA_PANTI_SOSIAL_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SARANA KESEHATAN</label>
		<input type="text" name="SARANA_KESEHATAN" value="<?=$data->SARANA_KESEHATAN?>"  />
		<input type="text" name="SARANA_KESEHATAN_MS" value="<?=$data->SARANA_KESEHATAN_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>WARUNG MAKAN</label>
		<input type="text" name="WARUNG_MAKAN" value="<?=$data->WARUNG_MAKAN?>"  />
		<input type="text" name="WARUNG_MAKAN_MS" value="<?=$data->WARUNG_MAKAN_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RUMAH MAKAN</label>
		<input type="text" name="RUMAH_MAKAN" value="<?=$data->RUMAH_MAKAN?>"  />
		<input type="text" name="RUMAH_MAKAN_MS" value="<?=$data->RUMAH_MAKAN_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JASA BOGA</label>
		<input type="text" name="JASA_BOGA" value="<?=$data->JASA_BOGA?>"  />
		<input type="text" name="JASA_BOGA_MS" value="<?=$data->JASA_BOGA_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>INDUSTRI MAKANAN & MINUMAN</label>
		<input type="text" name="INDSTRI_MKNAN_MNMAN" value="<?=$data->INDSTRI_MKNAN_MNMAN?>"  />
		<input type="text" name="INDSTRI_MKNAN_MNMAN_MS" value="<?=$data->INDSTRI_MKNAN_MNMAN_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>INDUSTRI KECIL/RUMAH TANGGA</label>
		<input type="text" name="INDSTRI_KCL_R_TANGGA" value="<?=$data->INDSTRI_KCL_R_TANGGA?>"  />
		<input type="text" name="INDSTRI_KCL_R_TANGGA_MS" value="<?=$data->INDSTRI_KCL_R_TANGGA_MS?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>INDUSTRI BESAR</label>
		<input type="text" name="INDUSTRI_BESAR" value="<?=$data->INDUSTRI_BESAR?>"  />
		<input type="text" name="INDUSTRI_BESAR_MS" value="<?=$data->INDUSTRI_BESAR_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JML RUMAH</label>
		<input type="text" name="JML_RUMAH" value="<?=$data->JML_RUMAH?>"  />
		<input type="text" name="JML_RUMAH_MS" value="<?=$data->JML_RUMAH_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SGL</label>
		<input type="text" name="SGL" value="<?=$data->SGL?>"  />
		<input type="text" name="SGL_MS" value="<?=$data->SGL_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SPT</label>
		<input type="text" name="SPT" value="<?=$data->SPT?>"  />
		<input type="text" name="SPT_MS" value="<?=$data->SPT_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SR / PDAM</label>
		<input type="text" name="SR_PDAM" value="<?=$data->SR_PDAM?>"  />
		<input type="text" name="SR_PDAM_MS" value="<?=$data->SR_PDAM_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN SAB</label>
		<input type="text" name="LAIN_LAIN_SAB" value="<?=$data->LAIN_LAIN_SAB?>"  />
		<input type="text" name="LAIN_LAIN_SAB_MS" value="<?=$data->LAIN_LAIN_SAB_MS?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JAMBAN UMUM_MCK</label>
		<input type="text" name="JMBN_UMUM_MCK" value="<?=$data->JMBN_UMUM_MCK?>"  />
		<input type="text" name="JMBN_UMUM_MCK_MS" value="<?=$data->JMBN_UMUM_MCK_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JAMBAN KELUARGA</label>
		<input type="text" name="JMBN_KELUARGA" value="<?=$data->JMBN_KELUARGA?>"  />
		<input type="text" name="JMBN_KELUARGA_MS" value="<?=$data->JMBN_KELUARGA_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SPAL</label>
		<input type="text" name="SPAL" value="<?=$data->SPAL?>"  />
		<input type="text" name="SPAL_MS" value="<?=$data->SPAL_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TPS </label>
		<input type="text" name="TPS" value="<?=$data->TPS?>"  />
		<input type="text" name="TPS_MS" value="<?=$data->TPS_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TPA </label>
		<input type="text" name="TPA" value="<?=$data->TPA?>"  />
		<input type="text" name="TPA_MS" value="<?=$data->TPA_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PONDOK PESANTREN</label>
		<input type="text" name="PONDOK_PESANTREN" value="<?=$data->PONDOK_PESANTREN?>"  />
		<input type="text" name="PONDOK_PESANTREN_MS" value="<?=$data->PONDOK_PESANTREN_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KIMIAWI</label>
		<input type="text" name="KIMIAWI" value="<?=$data->KIMIAWI?>"  />
		<input type="text" name="KIMIAWI_MS" value="<?=$data->KIMIAWI_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAKTERIOLOGI</label>
		<input type="text" name="BAKTERIOLOGI" value="<?=$data->BAKTERIOLOGI?>"  />
		<input type="text" name="BAKTERIOLOGI_MS" value="<?=$data->BAKTERIOLOGI_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KLIEN YANG DIRUJUK KE KLINIK SANITASI</label>
		<input type="text" name="KLIEN_YDRJ_KLNK_SANITASI" value="<?=$data->KLIEN_YDRJ_KLNK_SANITASI?>"  />
		<input type="text" name="KLIEN_YDRJ_KLNK_SANITASI_MS" value="<?=$data->KLIEN_YDRJ_KLNK_SANITASI_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KLIEN YANG DIKUNJUNGI</label>
		<input type="text" name="KLIEN_DIKUNJUNGI" value="<?=$data->KLIEN_DIKUNJUNGI?>"  />
		<input type="text" name="KLIEN_DIKUNJUNGI_MS" value="<?=$data->KLIEN_DIKUNJUNGI_MS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >