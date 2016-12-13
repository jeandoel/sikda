<script>
$(document).ready(function(){
		$('#form1ds_kiaedit').ajaxForm({
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
					$("#t802","#tabs").empty();
					$("#t802","#tabs").load('t_ds_kia'+'?_=' + (new Date()).getTime());
				}
			}
		});
})

$("#desa_kel_id_combo_ds_kia").remoteChained("#kec_id_combo_ds_kia", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_kia").remoteChained("#kec_id_combo_ds_kia", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
		$("#t802","#tabs").empty();
		$("#t802","#tabs").load('t_ds_kia'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_kia").mask("9999");
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
	padding-left:335px;
	font-size:12px;
}
.menu_p{
	float:left;
	padding-left:60px;
	font-size:12px;
}
</style>

<div class="mycontent">
<div class="formtitle">Edit Data Kia</div>
<div class="backbutton"><span class="kembali" id="backlistds_kia">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1ds_kiaedit" method="post" action="<?=site_url('t_ds_kia/editprocess')?>">	
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
	<?=getComboKecamatanByKab($data->KD_KECAMATAN,'KD_KECAMATAN','kec_id_combo_ds_kia','required','')?>
	<?=getComboKelurahanByKec($data->KD_KELURAHAN,'KD_KELURAHAN','desa_kel_id_combo_ds_kia','required','')?>
	<?=getComboPuskesmasByKec($data->KD_PUSKESMAS,'KD_PUSKESMAS','puskesmas_id_combo_ds_kia','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_kia" value="<?=$data->TAHUN?>" required />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">JUMLAH BUMIL</div>
	<fieldset>
		<span>
		<label>KUNJUNGAN K1 BUMIL</label>
		<input type="text" name="JML_KJ_K1_BUMIL" value="<?=$data->JML_KJ_K1_BUMIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KUNJUNGAN K4 BUMIL</label>
		<input type="text" name="JML_KJ_K4_BUMIL" value="<?=$data->JML_KJ_K4_BUMIL?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">BUMIL RESIKO</div>
	<fieldset>
		<span>
		<label>KUNJUNGAN BUMIL RESTI OLEH MASYARAKAT</label>
		<input type="text" name="JML_KJ_BR_R_MASYARAKAT" value="<?=$data->JML_KJ_BR_R_MASYARAKAT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KUNJUNGAN BUMIL RESTI OLEH NAKES</label>
		<input type="text" name="JML_KJ_BR_R_NAKES" value="<?=$data->JML_KJ_BR_R_NAKES?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BUMIL DENGAN RESTI YANG DIRUJUK KE PUSKESMAS</label>
		<input type="text" name="JML_B_R_R_YD_PUSKESMAS" value="<?=$data->JML_B_R_R_YD_PUSKESMAS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BUMIL DENGAN RESTI YANG DIRUJUK KE RUMAH SAKIT</label>
		<input type="text" name="JML_B_R_R_YD_RUMAH_SAKIT" value="<?=$data->JML_B_R_R_YD_RUMAH_SAKIT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN IBU HAMIL</label>
		<input type="text" name="JML_K_BR_I_HAMIL" value="<?=$data->JML_K_BR_I_HAMIL?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">IBU BERSALIN</div>
	<fieldset>
		<span>
		<label>PERSALINAN OLEH TENAGA KESEHATAN</label>
		<input type="text" name="JML_P_IB_T_KESEHATAN" value="<?=$data->JML_P_IB_T_KESEHATAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN OLEH TENAGA DUKUN</label>
		<input type="text" name="JML_P_IB_T_DUKUN" value="<?=$data->JML_P_IB_T_DUKUN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>IBU BERSALIN DI RUJUK KE PUSKESMAS</label>
		<input type="text" name="JML_I_B_DRJ_PUSKESMAS" value="<?=$data->JML_I_B_DRJ_PUSKESMAS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>IBU BERSALIN DI RUJUK KE RUMAH SAKIT</label>
		<input type="text" name="JML_I_B_DRJ_RUMAH_SAKIT" value="<?=$data->JML_I_B_DRJ_RUMAH_SAKIT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN IBU BERSALIN</label>
		<input type="text" name="JML_K_I_BERSALIN" value="<?=$data->JML_K_I_BERSALIN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN IBU NIFAS</label>
		<input type="text" name="JML_K_I_NIFAS" value="<?=$data->JML_K_I_NIFAS?>"  />
		</span>
	</fieldset>
	<div class="subformtitle1">NEONATAL</div>
	<div class="menu_jk">
	<div class="menu_l"><b>L</b></div><div class="menu_p"><b>P</b></div>
	</div>
	</br>
	<fieldset>
		<span>
		<label>KUNJUNGAN NEONATAL BARU (KN 1)</label>
		<input type="text" name="JML_KJ_N_BR_0_7HARI_KN1" value="<?=$data->JML_KJ_N_BR_0_7HARI_KN1?>"  />
		<input type="text" name="JML_KJ_N_BR_0_7HARI_KN1_p" value="<?=$data->JML_KJ_N_BR_0_7HARI_KN1_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KUNJUNGAN NEONATAL LENGKAP (KN LENGKAP)</label>
		<input type="text" name="JML_KJ_N_BR_8_28HARI_KN2" value="<?=$data->JML_KJ_N_BR_8_28HARI_KN2?>"  />
		<input type="text" name="JML_KJ_N_BR_8_28HARI_KN2_p" value="<?=$data->JML_KJ_N_BR_8_28HARI_KN2_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAYI DENGAN BBL < 2500 GR</label>
		<input type="text" name="JML_B_N_BBL_K_2500GR" value="<?=$data->JML_B_N_BBL_K_2500GR?>"  />
		<input type="text" name="JML_B_N_BBL_K_2500GR_p" value="<?=$data->JML_B_N_BBL_K_2500GR_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BBLR DILAYANI TENAGA KESEHATAN</label>
		<input type="text" name="JML_BBLR_N_D_T_KESEHATAN" value="<?=$data->JML_BBLR_N_D_T_KESEHATAN?>"  />
		<input type="text" name="JML_BBLR_N_D_T_KESEHATAN_p" value="<?=$data->JML_BBLR_N_D_T_KESEHATAN_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAYI DENGAN BBL 2500 - 3000 GR</label>
		<input type="text" name="B_N_D_BBL_2500_3000GR" value="<?=$data->B_N_D_BBL_2500_3000GR?>"  />
		<input type="text" name="B_N_D_BBL_2500_3000GR_p" value="<?=$data->B_N_D_BBL_2500_3000GR_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAYI DENGAN BBL > 3000 GR</label>
		<input type="text" name="JML_B_N_D_BBL_L_3000GR" value="<?=$data->JML_B_N_D_BBL_L_3000GR?>"  />
		<input type="text" name="JML_B_N_D_BBL_L_3000GR_p" value="<?=$data->JML_B_N_D_BBL_L_3000GR_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAYI LAHIR HIDUP</label>
		<input type="text" name="B_N_L_HIDUP" value="<?=$data->B_N_L_HIDUP?>"  />
		<input type="text" name="B_N_L_HIDUP_p" value="<?=$data->B_N_L_HIDUP_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAYI LAHIR MATI</label>
		<input type="text" name="B_N_L_MATI" value="<?=$data->B_N_L_MATI?>"  />
		<input type="text" name="B_N_L_MATI_p" value="<?=$data->B_N_L_MATI_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN BAYI UMUR 0-7 HARI</label>
		<input type="text" name="K_B_N_UMR_0_7_HARI" value="<?=$data->K_B_N_UMR_0_7_HARI?>"  />
		<input type="text" name="K_B_N_UMR_0_7_HARI_p" value="<?=$data->K_B_N_UMR_0_7_HARI_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN BAYI UMUR 8HR-1BL</label>
		<input type="text" name="K_B_N_UMR_8HR_1BL" value="<?=$data->K_B_N_UMR_8HR_1BL?>"  />
		<input type="text" name="K_B_N_UMR_8HR_1BL_p" value="<?=$data->K_B_N_UMR_8HR_1BL_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN BAYI UMUR 1BL-1THN</label>
		<input type="text" name="K_B_N_UMR_1BL_1THN" value="<?=$data->K_B_N_UMR_1BL_1THN?>"  />
		<input type="text" name="K_B_N_UMR_1BL_1THN_p" value="<?=$data->K_B_N_UMR_1BL_1THN_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN BALITA</label>
		<input type="text" name="K_N_BALITA" value="<?=$data->K_N_BALITA?>"  />
		<input type="text" name="K_N_BALITA_p" value="<?=$data->K_N_BALITA_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NEONATAL RESTI</label>
		<input type="text" name="N_RESTI" value="<?=$data->N_RESTI?>"  />
		<input type="text" name="N_RESTI_p" value="<?=$data->N_RESTI_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NEONATAL RESTI DIRUJUK KE PUSKESMAS</label>
		<input type="text" name="N_R_DRJ_PUSKESMAS" value="<?=$data->N_R_DRJ_PUSKESMAS?>"  />
		<input type="text" name="N_R_DRJ_PUSKESMAS_p" value="<?=$data->N_R_DRJ_PUSKESMAS_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NEONATAL RESTI DIRUJUK RS</label>
		<input type="text" name="N_R_DRJ_RS" value="<?=$data->N_R_DRJ_RS?>"  />
		<input type="text" name="N_R_DRJ_RS_p" value="<?=$data->N_R_DRJ_RS_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BALITA YANG DIDETEKSI TUMBUH KEMBANGNYA</label>
		<input type="text" name="B_N_YG_DTK_TBH_KEMBANGNYA" value="<?=$data->B_N_YG_DTK_TBH_KEMBANGNYA?>"  />
		<input type="text" name="B_N_YG_DTK_TBH_KEMBANGNYA_p" value="<?=$data->B_N_YG_DTK_TBH_KEMBANGNYA_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK DENGAN KELAINAN TUMBUH KEMBANG</label>
		<input type="text" name="A_N_D_KLN_TBH_KEMBANG" value="<?=$data->A_N_D_KLN_TBH_KEMBANG?>"  />
		<input type="text" name="A_N_D_KLN_TBH_KEMBANG_p" value="<?=$data->A_N_D_KLN_TBH_KEMBANG_p?>"  />
		</span>
	</fieldset>
	<div class="subformtitle1">KUNJUNGAN KE TK (TAMAN KANAK-KANAK)</div>
	<fieldset>
		<span>
		<label>JUMLAH TK YANG ADA</label>
		<input type="text" name="JML_KJ_TK_ADA" value="<?=$data->JML_KJ_TK_ADA?>"  />
		<input type="text" name="JML_KJ_TK_ADA_p" value="<?=$data->JML_KJ_TK_ADA_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TK YANG DIKUNJUNGI</label>
		<input type="text" name="JML_KJ_TK_DIKUNJUNGI" value="<?=$data->JML_KJ_TK_DIKUNJUNGI?>"  />
		<input type="text" name="JML_KJ_TK_DIKUNJUNGI_p" value="<?=$data->JML_KJ_TK_DIKUNJUNGI_p?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>MURID TK YANG DIPERIKSA</label>
		<input type="text" name="M_KJ_TK_DIPERIKSA" value="<?=$data->M_KJ_TK_DIPERIKSA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>MURID TK YANG DIRUJUK</label>
		<input type="text" name="M_KJ_TK_DIRUJUK" value="<?=$data->M_KJ_TK_DIRUJUK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >