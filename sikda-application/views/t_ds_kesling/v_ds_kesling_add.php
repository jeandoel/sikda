<script>
$(document).ready(function(){
		$('#form1ds_keslingadd').ajaxForm({
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
					$("#t805","#tabs").empty();
					$("#t805","#tabs").load('t_ds_kesling'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1ds_keslingadd").validate({
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
//$("#kec_id_combo_ds_kesling").remoteChained("#kab_id_combo_ds_gigi", "<?=site_url('t_masters/getKabupatenByProvinceID3')?>");
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
	$('#backlistds_kesling').click(function(){
		$("#t805","#tabs").empty();
		$("#t805","#tabs").load('t_ds_kesling'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_kesling").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>

<style>
.menu_jk{
	width:100%;
}
.menu_l{
	float:left;
	padding-left:310px;
	font-size:10px;
}
.menu_p{
	float:left;
	padding-left:10px;
	font-size:10px;
}
</style>

<div class="mycontent">
<div class="formtitle">Tambah Data Kesehatan Lingkungan</div>
<div class="backbutton"><span class="kembali" id="backlistds_kesling">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<div class="subformtitle">PELAYANAN MEDIK DASAR DI BP KESEHATAN LINGKUNGAN</div>
<form name="frApps" id="form1ds_keslingadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_ds_kesling/addprocess')?>" enctype="multipart/form-data">		
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
	<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'KD_KECAMATAN','kec_id_combo_ds_kesling','required','')?>
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'KD_KELURAHAN','desa_kel_id_combo_ds_kesling','required','')?>
	<?=getComboPuskesmasByKec('','KD_PUSKESMAS','puskesmas_id_combo_ds_kesling','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_kesling" value="" required />
		</span>
	</fieldset>
	<div class="menu_jk">
	<div class="menu_l"><b>Diperiksa</b></div><div class="menu_p"><b>Memenuhi Syarat</b></div>
	</div>
	</br>	
	<fieldset>
		<span>
		<label>SD/MI</label>
		<input type="text" placeholder="D" name="SD_MI" value=""  />
		<input type="text" placeholder="M" name="SD_MI_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SLTP/MTs</label>
		<input type="text" placeholder="D" name="SLTP_MTS" value=""  />
		<input type="text" placeholder="M" name="SLTP_MTS_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SLTA/MA</label>
		<input type="text" placeholder="D" name="SLTA_MA" value=""  />
		<input type="text" placeholder="M" name="SLTA_MA_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERGURUAN TINGGI</label>
		<input type="text" placeholder="D" name="PERGURUAN_TINGGI" value=""  />
		<input type="text" placeholder="M" name="PERGURUAN_TINGGI_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KIOS/KUD</label>
		<input type="text" placeholder="D" name="KIOS_KUD" value=""  />
		<input type="text" placeholder="M" name="KIOS_KUD_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>HOTEL MELATI/LOSMEN</label>
		<input type="text" placeholder="D" name="HOTEL_MELATI_LOSMEN" value=""  />
		<input type="text" placeholder="M" name="HOTEL_MELATI_LOSMEN_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SALON KECANTIKAN/PANGKAS RAMBUT</label>
		<input type="text" placeholder="D" name="SALON_KECNTIKAN_P_RAMBUT" value=""  />
		<input type="text" placeholder="M" name="SALON_KECNTIKAN_P_RAMBUT_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TEMPAT REKREASI</label>
		<input type="text" placeholder="D" name="TEMPAT_REKREASI" value=""  />
		<input type="text" placeholder="M" name="TEMPAT_REKREASI_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>GEDUNG PERTEMUAN/GEDUNG PERTUNJUKAN</label>
		<input type="text" placeholder="D" name="GD_PERTEMUAN_GD_PERTUNJUKAN" value=""  />
		<input type="text" placeholder="M" name="GD_PERTEMUAN_GD_PERTUNJUKAN_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KOLAM RENANG</label>
		<input type="text" placeholder="D" name="KOLAM_RENANG" value=""  />
		<input type="text" placeholder="M" name="KOLAM_RENANG_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>MASJID/MUSHOLA</label>
		<input type="text" placeholder="D" name="MASJID_MUSHOLA" value=""  />
		<input type="text" placeholder="M" name="MASJID_MUSHOLA_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>GEREJA</label>
		<input type="text" placeholder="D" name="GEREJA" value=""  />
		<input type="text" placeholder="M" name="GEREJA_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KELENTENG</label>
		<input type="text" placeholder="D" name="KELENTENG" value=""  />
		<input type="text" placeholder="M" name="KELENTENG_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PURA</label>
		<input type="text" placeholder="D" name="PURA" value=""  />
		<input type="text" placeholder="M" name="PURA_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>WIHARA</label>
		<input type="text" placeholder="D" name="WIHARA" value=""  />
		<input type="text" placeholder="M" name="WIHARA_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TERMINAL</label>
		<input type="text" placeholder="D" name="TERMINAL" value=""  />
		<input type="text" placeholder="M" name="TERMINAL_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STASIUN</label>
		<input type="text" placeholder="D" name="STASIUN" value=""  />
		<input type="text" placeholder="M" name="STASIUN_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PELABUHAN LAUT</label>
		<input type="text" placeholder="D" name="PELABUHAN_LAUT" value=""  />
		<input type="text" placeholder="M" name="PELABUHAN_LAUT_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PASAR</label>
		<input type="text" placeholder="D" name="PASAR" value=""  />
		<input type="text" placeholder="M" name="PASAR_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>APOTIK</label>
		<input type="text" placeholder="D" name="APOTIK" value=""  />
		<input type="text" placeholder="M" name="APOTIK_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TOKO OBAT</label>
		<input type="text" placeholder="D" name="TOKO_OBAT" value=""  />
		<input type="text" placeholder="M" name="TOKO_OBAT_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SARANA/PANTI SOSIAL</label>
		<input type="text" placeholder="D" name="SARANA_PANTI_SOSIAL" value=""  />
		<input type="text" placeholder="M" name="SARANA_PANTI_SOSIAL_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SARANA KESEHATAN</label>
		<input type="text" placeholder="D" name="SARANA_KESEHATAN" value=""  />
		<input type="text" placeholder="M" name="SARANA_KESEHATAN_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>WARUNG MAKAN</label>
		<input type="text" placeholder="D" name="WARUNG_MAKAN" value=""  />
		<input type="text" placeholder="M" name="WARUNG_MAKAN_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RUMAH MAKAN</label>
		<input type="text" placeholder="D" name="RUMAH_MAKAN" value=""  />
		<input type="text" placeholder="M" name="RUMAH_MAKAN_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JASA BOGA</label>
		<input type="text" placeholder="D" name="JASA_BOGA" value=""  />
		<input type="text" placeholder="M" name="JASA_BOGA_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>INDUSTRI MAKANAN & MINUMAN</label>
		<input type="text" placeholder="D" name="INDSTRI_MKNAN_MNMAN" value=""  />
		<input type="text" placeholder="M" name="INDSTRI_MKNAN_MNMAN_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>INDUSTRI KECIL/RUMAH TANGGA</label>
		<input type="text" placeholder="D" name="INDSTRI_KCL_R_TANGGA" value=""  />
		<input type="text" placeholder="M" name="INDSTRI_KCL_R_TANGGA_MS" value=""  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>INDUSTRI BESAR</label>
		<input type="text" placeholder="D" name="INDUSTRI_BESAR" value=""  />
		<input type="text" placeholder="M" name="INDUSTRI_BESAR_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JML RUMAH</label>
		<input type="text" placeholder="D" name="JML_RUMAH" value=""  />
		<input type="text" placeholder="M" name="JML_RUMAH_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SGL</label>
		<input type="text" placeholder="D" name="SGL" value=""  />
		<input type="text" placeholder="M" name="SGL_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SPT</label>
		<input type="text" placeholder="D" name="SPT" value=""  />
		<input type="text" placeholder="M" name="SPT_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SR / PDAM</label>
		<input type="text" placeholder="D" name="SR_PDAM" value=""  />
		<input type="text" placeholder="M" name="SR_PDAM_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN SAB</label>
		<input type="text" placeholder="D" name="LAIN_LAIN_SAB" value=""  />
		<input type="text" placeholder="M" name="LAIN_LAIN_SAB_MS" value=""  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JAMBAN UMUM/MCK</label>
		<input type="text" placeholder="D" name="JMBN_UMUM_MCK" value=""  />
		<input type="text" placeholder="M" name="JMBN_UMUM_MCK_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JAMBAN KELUARGA</label>
		<input type="text" placeholder="D" name="JMBN_KELUARGA" value=""  />
		<input type="text" placeholder="M" name="JMBN_KELUARGA_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SPAL</label>
		<input type="text" placeholder="D" name="SPAL" value=""  />
		<input type="text" placeholder="M" name="SPAL_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TPS</label>
		<input type="text" placeholder="D" name="TPS" value=""  />
		<input type="text" placeholder="M" name="TPS_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TPA</label>
		<input type="text" placeholder="D" name="TPA" value=""  />
		<input type="text" placeholder="M" name="TPA_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PONDOK PESANTREN</label>
		<input type="text" placeholder="D" name="PONDOK_PESANTREN" value=""  />
		<input type="text" placeholder="M" name="PONDOK_PESANTREN_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KIMIAWI</label>
		<input type="text" placeholder="D" name="KIMIAWI" value=""  />
		<input type="text" placeholder="M" name="KIMIAWI_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAKTERIOLOGI</label>
		<input type="text" placeholder="D" name="BAKTERIOLOGI" value=""  />
		<input type="text" placeholder="M" name="BAKTERIOLOGI_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KLIEN YANG DIRUJUK KE KLINIK SANITASI</label>
		<input type="text" placeholder="D" name="KLIEN_YDRJ_KLNK_SANITASI" value=""  />
		<input type="text"  placeholder="M" name="KLIEN_YDRJ_KLNK_SANITASI_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KLIEN YANG DIKUNJUNGI</label>
		<input type="text" placeholder="D" name="KLIEN_DIKUNJUNGI" value=""  />
		<input type="text" placeholder="M" name="KLIEN_DIKUNJUNGI_MS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >