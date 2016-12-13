<script>
$(document).ready(function(){
		$('#form1ds_datadasaradd').ajaxForm({
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
					$("#t801","#tabs").empty();
					$("#t801","#tabs").load('t_ds_datadasar'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1ds_datadasaradd").validate({
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
//$("#kec_id_combo_ds_datadasar").remoteChained("#kab_id_combo_ds_datadasar", "<?=site_url('t_masters/getKabupatenByProvinceID3')?>");
$("#desa_kel_id_combo_ds_datadasar").remoteChained("#kec_id_combo_ds_datadasar", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_datadasar").remoteChained("#kec_id_combo_ds_datadasar", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('id')=='JML_P_SAS_DD_MSD_KELAS3'){
				$('#form1ds_datadasaradd').submit();
			}
			else{
				$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
			}
		}
   }
});
</script>
<script>
	$('#backlistds_datadasar').click(function(){
		$("#t801","#tabs").empty();
		$("#t801","#tabs").load('t_ds_datadasar'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_datadasar").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Tambah Data Dasar</div>
<div class="backbutton"><span class="kembali" id="backlistds_datadasar">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<!--<div class="subformtitle">PELAYANAN MEDIK DASAR DI BP DATA DASAR</div>-->
<form name="frApps" id="form1ds_datadasaradd" method="post" onsubmit="bt1.disabled = true; return true;" action="<?=site_url('t_ds_datadasar/addprocess')?>" enctype="multipart/form-data">		
	<input type="text" style="display:none;width:195px!important" name="" id="textid" value="<?=$this->session->userdata('nama_propinsi')?>" disabled />
	<input type="text" style="display:none;width:195px!important" name="" id="textid" value="<?=$this->session->userdata('nama_kabupaten')?>" disabled />
	<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'KD_KECAMATAN','kec_id_combo_ds_datadasar','required','')?>
	<?=getComboPuskesmasByKec('','KD_PUSKESMAS','puskesmas_id_combo_ds_datadasar','required','')?>
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'KD_KELURAHAN','desa_kel_id_combo_ds_datadasar','required','')?>
	<fieldset>
		<span>
		<label>Tahun*</label>
		<input type="text" name="TAHUN" id="tahun_ds_datadasar" value="" required />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SASARAN PENDUDUK (KOORDINATOR TU)</div>
	<fieldset>
		<span>
		<label>JUMLAH DESA</label>
		<input type="text" name="JML_SP_DESA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RT</label>
		<input type="text" name="JML_SP_RT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RW</label>
		<input type="text" name="JML_SP_RW" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KK</label>
		<input type="text" name="JML_SP_KK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LUAS WILAYAH</label>
		<input type="text" name="JML_SP_L_WILAYAH" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH KURANG DARI 1 TAHUN</label>
		<input type="text" name="JML_L_K1TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 1 SAMPAI 4 TAHUN</label>
		<input type="text" name="JML_L_1_4TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 5 SAMPAI 9 TAHUN</label>
		<input type="text" name="JML_L_5_9TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 10 SAMPAI 14 TAHUN</label>
		<input type="text" name="JML_L_10_14TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 15 SAMPAI 19 TAHUN</label>
		<input type="text" name="JML_L_15_19TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 20 SAMPAI 24 TAHUN</label>
		<input type="text" name="JML_L_20_24TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 25 SAMPAI 29 TAHUN</label>
		<input type="text" name="JML_L_25_29TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 30 SAMPAI 34 TAHUN</label>
		<input type="text" name="JML_L_30_34TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 35 SAMPAI 39 TAHUN</label>
		<input type="text" name="JML_L_35_39TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 40 SAMPAI 44 TAHUN</label>
		<input type="text" name="JML_L_40_44TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 45 SAMPAI 49 TAHUN</label>
		<input type="text" name="JML_L_45_49TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 50 SAMPAI 54 TAHUN</label>
		<input type="text" name="JML_L_50_54TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 55 SAMPAI 59 TAHUN</label>
		<input type="text" name="JML_L_55_59TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 60 SAMPAI 64 TAHUN</label>
		<input type="text" name="JML_L_60_64TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 65 SAMPAI 69 TAHUN</label>
		<input type="text" name="JML_L_65_69TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 70 SAMPAI 74 TAHUN</label>
		<input type="text" name="JML_L_70_74TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH DIATAS 75 TAHUN</label>
		<input type="text" name="JML_L_L75TH" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH KURANG DARI 1 TAHUN</label>
		<input type="text" name="JML_P_K1TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 1 SAMPAI 4 TAHUN</label>
		<input type="text" name="JML_P_1_4TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 5 SAMPAI 9 TAHUN</label>
		<input type="text" name="JML_P_5_9TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 10 SAMPAI 14 TAHUN</label>
		<input type="text" name="JML_P_10_14TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 15 SAMPAI 19 TAHUN</label>
		<input type="text" name="JML_P_15_19TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 20 SAMPAI 24 TAHUN</label>
		<input type="text" name="JML_P_20_24TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 25 SAMPAI 29 TAHUN</label>
		<input type="text" name="JML_P_25_29TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 30 SAMPAI 34 TAHUN</label>
		<input type="text" name="JML_P_30_34TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 35 SAMPAI 39 TAHUN</label>
		<input type="text" name="JML_P_35_39TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 40 SAMPAI 44 TAHUN</label>
		<input type="text" name="JML_P_40_44TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 45 SAMPAI 49 TAHUN</label>
		<input type="text" name="JML_P_45_49TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 50 SAMPAI 54 TAHUN</label>
		<input type="text" name="JML_P_50_54TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 55 SAMPAI 59 TAHUN</label>
		<input type="text" name="JML_P_55_59TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 60 SAMPAI 64 TAHUN</label>
		<input type="text" name="JML_P_60_64TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 65 SAMPAI 69 TAHUN</label>
		<input type="text" name="JML_P_65_69TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 70 SAMPAI 74 TAHUN</label>
		<input type="text" name="JML_P_70_74TH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH DIATAS 75 TAHUN</label>
		<input type="text" name="JML_P_L75TH" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">GAKIN</div>
	<fieldset>
		<span>
		<label>JUMLAH GAKIN</label>
		<input type="text" name="JML_GA_GAKIN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH LAKI-LAKI</label>
		<input type="text" name="JML_GA_LAKI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PEREMPUAN</label>
		<input type="text" name="JML_GA_PEREMPUAN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SARANA AIR BERSIH (KESEHATAN LINGKUNGAN)</div>
	<fieldset>
		<span>
		<label>JUMLAH RUMAH</label>
		<input type="text" name="JML_SAB_RUMAH" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SGL</label>
		<input type="text" name="JML_SAB_SGL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SPT</label>
		<input type="text" name="JML_SAB_SPT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SR/PDAM</label>
		<input type="text" name="JML_SAB_SR_PDAM" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH LAIN-LAIN</label>
		<input type="text" name="JML_SAB_LAINLAIN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SPAL</label>
		<input type="text" name="JML_SAB_SPAL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH JAMBAN KELUARGA</label>
		<input type="text" name="JML_SAB_J_KELUARGA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TPA</label>
		<input type="text" name="JML_SAB_TPA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TPS</label>
		<input type="text" name="JML_SAB_TPS" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">TEMPAT-TEMPAT UMUM</div>
	<fieldset>
		<span>
		<label>JUMLAH TK</label>
		<input type="text" name="JML_TTU_TK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SD</label>
		<input type="text" name="JML_TTU_SD" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MI</label>
		<input type="text" name="JML_TTU_MI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SLTP</label>
		<input type="text" name="JML_TTU_SLTP" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MTS</label>
		<input type="text" name="JML_TTU_MTS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SLTA</label>
		<input type="text" name="JML_TTU_SLTA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MA</label>
		<input type="text" name="JML_TTU_MA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERGURUAN TINGGI</label>
		<input type="text" name="JML_TTU_P_TINGGI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KIOS</label>
		<input type="text" name="JML_TTU_KIOS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH HOTEL/MELATI/LOSMEN</label>
		<input type="text" name="JML_TTU_H_M_LOSMEN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SALON KECANTIKAN/PANGKAS RAMBUT</label>
		<input type="text" name="JML_TTU_SK_P_RAMBUT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TEMPAT REKREASI</label>
		<input type="text" name="JML_TTU_T_REKREASI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH GEDUNG PERTEMUAN/GEDUNG PERTUNJUKAN</label>
		<input type="text" name="JML_TTU_GP_G_PERTUNJUKAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KOLAM RENANG</label>
		<input type="text" name="JML_TTU_K_RENANG" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SARANA IBADAH</div>
	<fieldset>
		<span>
		<label>JUMLAH MASJID/MUSHOLA</label>
		<input type="text" name="JML_SI_MAS_MUSHOLA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH GEREJA</label>
		<input type="text" name="JML_SI_GEREJA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KLENTENG</label>
		<input type="text" name="JML_SI_KLENTENG" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PURA</label>
		<input type="text" name="JML_SI_PURA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VIHARA</label>
		<input type="text" name="JML_SI_VIHARA" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SARANA TRANSPORTASI</div>
	<fieldset>
		<span>
		<label>JUMLAH TERMINAL</label>
		<input type="text" name="JML_STR_TERMINAL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH STASIUN</label>
		<input type="text" name="JML_STR_STASIUN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PELABUHAN LAUT</label>
		<input type="text" name="JML_STR_P_LAUT" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SARANA EKONOMI DAN SOSIAL</div>
	<fieldset>
		<span>
		<label>JUMLAH PASAR</label>
		<input type="text" name="JML_SES_PASAR" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH APOTIK</label>
		<input type="text" name="JML_SES_APOTIK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TOKO OBAT</label>
		<input type="text" name="JML_SES_T_OBAT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PANTI SOSIAL</label>
		<input type="text" name="JML_SES_P_SOSIAL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SARANA KESEHATAN</label>
		<input type="text" name="JML_SES_S_KESEHATAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERKANTORAN</label>
		<input type="text" name="JML_SES_PERKANTORAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PONDOK PESANTREN</label>
		<input type="text" name="JML_SES_P_PESANTREN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">TEMPAT PENGOLAHAN MAKANAN</div>
	<fieldset>
		<span>
		<label>JUMLAH WARUNG MAKAN</label>
		<input type="text" name="JML_TPM_W_MAKAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUMAH MAKAN</label>
		<input type="text" name="JML_TPM_R_MAKAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH JASA BOGA/CATERING</label>
		<input type="text" name="JML_TPM_JB_CATERING" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH INDUSTRI MAKANAN DANA MINUMAN</label>
		<input type="text" name="JML_TPM_IMD_MINUMAN" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SASARAN (KIA)</div>
	<fieldset>
		<span>
		<label>JUMLAH PUS</label>
		<input type="text" name="JML_SASKIA_PUS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH WUS</label>
		<input type="text" name="JML_SASKIA_WUS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BAYI LAKI-LAKI</label>
		<input type="text" name="JML_L_SASKIA_BAYI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BAYI PEREMPUAN</label>
		<input type="text" name="JML_P_SASKIA_BAYI" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BALITA LAKI-LAKI</label>
		<input type="text" name="JML_L_SASKIA_BALITA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BALITA PEREMPUAN</label>
		<input type="text" name="JML_P_SASKIA_BALITA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BUMIL</label>
		<input type="text" name="JML_SASKIA_BUMIL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BULIN</label>
		<input type="text" name="JML_SASKIA_BULIN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BUFAS</label>
		<input type="text" name="JML_SASKIA_BUFAS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH K1</label>
		<input type="text" name="JML_SASKIA_K1" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH K4</label>
		<input type="text" name="JML_SASKIA_K4" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KN1</label>
		<input type="text" name="JML_SASKIA_KN1" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KN2</label>
		<input type="text" name="JML_SASKIA_KN2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERSALINAN NAKES</label>
		<input type="text" name="JML_SASKIA_P_NAKES" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERSALINAN NON NAKES</label>
		<input type="text" name="JML_SASKIA_P_NON_NAKES" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RESTI NAKES</label>
		<input type="text" name="JML_SASKIA_RES_NAKES" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RESTI MASYARAKAT</label>
		<input type="text" name="JML_SASKIA_RES_MASYARAKAT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PMPB</label>
		<input type="text" name="JML_SASKIA_PMPB" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH POSYANDU</label>
		<input type="text" name="JML_SASKIA_POSYANDU" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID TK</label>
		<input type="text" name="JML_SASKIA_M_TK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KADER</label>
		<input type="text" name="JML_SASKIA_KADER" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SASARAN (DATA DASAR)</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID TK LAKI-LAKI</label>
		<input type="text" name="JML_L_SAS_DD_M_TK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID TK PEREMPUAN</label>
		<input type="text" name="JML_P_SAS_DD_M_TK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 1 LAKI-LAKI</label>
		<input type="text" name="JML_L_SAS_DD_MSD_KELAS1" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 1 PEREMPUAN</label>
		<input type="text" name="JML_P_SAS_DD_MSD_KELAS1" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 2 LAKI-LAKI</label>
		<input type="text" name="JML_L_SAS_DD_MSD_KELAS2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 2 PEREMPUAN</label>
		<input type="text" name="JML_P_SAS_DD_MSD_KELAS2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 3 LAKI-LAKI</label>
		<input type="text" name="JML_L_SAS_DD_MSD_KELAS3" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 3 PEREMPUAN</label>
		<input type="text" id="JML_P_SAS_DD_MSD_KELAS3" name="JML_P_SAS_DD_MSD_KELAS3" value=""  />
		</span>
	</fieldset>
	
	</br>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >