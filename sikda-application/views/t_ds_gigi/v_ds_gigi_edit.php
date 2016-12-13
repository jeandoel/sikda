<script>
$(document).ready(function(){
		$('#form1ds_gigiedit').ajaxForm({
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
					$("#t811","#tabs").empty();
					$("#t811","#tabs").load('t_ds_gigi'+'?_=' + (new Date()).getTime());
				}
			}
		});
})

$("#desa_kel_id_combo_ds_gigi").remoteChained("#kec_id_combo_ds_gigi", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_gigi").remoteChained("#kec_id_combo_ds_gigi", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_gigi').click(function(){
		$("#t811","#tabs").empty();
		$("#t811","#tabs").load('t_ds_gigi'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_gigi").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Edit Data Gigi</div>
<div class="backbutton"><span class="kembali" id="backlistds_gigi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1ds_gigiedit" method="post" action="<?=site_url('t_ds_gigi/editprocess')?>">	
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
	<?=getComboKecamatanByKab($data->KD_KECAMATAN,'KD_KECAMATAN','kec_id_combo_ds_gigi','required','')?>
	<?=getComboKelurahanByKec($data->KD_KELURAHAN,'KD_KELURAHAN','desa_kel_id_combo_ds_gigi','required','')?>
	<?=getComboPuskesmasByKec($data->KD_PUSKESMAS,'KD_PUSKESMAS','puskesmas_id_combo_ds_gigi','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_gigi" value="<?=$data->TAHUN?>" required />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">A. DIAGNOSA</div>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH CARIES DENTIS</label>
		<input type="text" name="JML_L_C_DENTIS" value="<?=$data->JML_L_C_DENTIS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PULPA</label>
		<input type="text" name="JML_L_K_PULPA" value="<?=$data->JML_L_K_PULPA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PERIODONTAL</label>
		<input type="text" name="JML_L_K_PERIODONTAL" value="<?=$data->JML_L_K_PERIODONTAL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ABSES</label>
		<input type="text" name="JML_L_ABSES" value="<?=$data->JML_L_ABSES?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERSISTENSI</label>
		<input type="text" name="JML_L_PERSISTENSI" value="<?=$data->JML_L_PERSISTENSI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_L_LAINLAIN" value="<?=$data->JML_L_LAINLAIN?>"  />
		</span>
	</fieldset>
	<div class="subformtitle3">PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH CARIES DENTIS</label>
		<input type="text" name="JML_P_C_DENTIS" value="<?=$data->JML_P_C_DENTIS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PULPA</label>
		<input type="text" name="JML_P_K_PULPA" value="<?=$data->JML_P_K_PULPA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELAINAN PERIODONTAL</label>
		<input type="text" name="JML_P_K_PERIODONTAL" value="<?=$data->JML_P_K_PERIODONTAL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ABSES</label>
		<input type="text" name="JML_P_ABSES" value="<?=$data->JML_P_ABSES?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERSISTENSI</label>
		<input type="text" name="JML_P_PERSISTENSI" value="<?=$data->JML_P_PERSISTENSI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_P_LAINLAIN" value="<?=$data->JML_P_LAINLAIN?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">B. PERAWATAN</div>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN TETAP PADA GIGI TETAP</label>
		<input type="text" name="JML_PR_TTG_TETAP" value="<?=$data->JML_PR_TTG_TETAP?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN TETAP PADA GIGI SULUNG</label>
		<input type="text" name="JML_PR_TTG_SULUNG" value="<?=$data->JML_PR_TTG_SULUNG?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN SEMENTARA PADA GIGI TETAP</label>
		<input type="text" name="JML_PR_TTS_TETAP" value="<?=$data->JML_PR_TTS_TETAP?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TUMPATAN SEMENTARA PADA GIGI SULUNG</label>
		<input type="text" name="JML_PR_TTS_SULUNG" value="<?=$data->JML_PR_TTS_SULUNG?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENGOBATAN PULPA</label>
		<input type="text" name="JML_PR_PULPA" value="<?=$data->JML_PR_PULPA?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH PENGOBATAN PERIODONTAL</label>
		<input type="text" name="JML_PR_PERIODONTAL" value="<?=$data->JML_PR_PERIODONTAL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENGOBATAN ABSES</label>
		<input type="text" name="JML_PR_ABSES" value="<?=$data->JML_PR_ABSES?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENCABUTAN GIGI TETAP</label>
		<input type="text" name="JML_PR_PG_TETAP" value="<?=$data->JML_PR_PG_TETAP?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENCABUTAN GIGI SULUNG</label>
		<input type="text" name="JML_PR_PG_SULUNG" value="<?=$data->JML_PR_PG_SULUNG?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TINDAKAN SCALING</label>
		<input type="text" name="JML_PR_T_SCALING" value="<?=$data->JML_PR_T_SCALING?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI BARU IBU HAMIL</label>
		<input type="text" name="JML_PR_KRJGBI_HAMIL" value="<?=$data->JML_PR_KRJGBI_HAMIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI LAMA IBU HAMIL</label>
		<input type="text" name="JML_PR_KRJGLI_HAMIL" value="<?=$data->JML_PR_KRJGLI_HAMIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_PR_LAINLAIN" value="<?=$data->JML_PR_LAINLAIN?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">JUMLAH KUNJUNGAN</div>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN BARU ANAK (1-6 TAHUN)</label>
		<input type="text" name="JML_KJ_L_KRJB_ANAK" value="<?=$data->JML_KJ_L_KRJB_ANAK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN LAMA ANAK (1-6 TAHUN)</label>
		<input type="text" name="JML_KJ_L_KRJL_ANAK" value="<?=$data->JML_KJ_L_KRJL_ANAK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN BARU ANAK USIA SEKOLAH (6-12)</label>
		<input type="text" name="JML_KJ_L_KRJB_ANAKSEKOLAH" value="<?=$data->JML_KJ_L_KRJB_ANAKSEKOLAH?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN LAMA ANAK USIA SEKOLAH (6-12)</label>
		<input type="text" name="JML_KJ_L_KRJL_ANAKSEKOLAH" value="<?=$data->JML_KJ_L_KRJL_ANAKSEKOLAH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI LAMA LUAR WILAYAH</label>
		<input type="text" name="JML_KJ_L_KRJGLL_WILAYAH" value="<?=$data->JML_KJ_L_KRJGLL_WILAYAH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI BARU LUAR WILAYAH</label>
		<input type="text" name="JML_KJ_L_KRJGBL_WILAYAH" value="<?=$data->JML_KJ_L_KRJGBL_WILAYAH?>"  />
		</span>
	</fieldset>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN BARU ANAK (1-6 TAHUN)</label>
		<input type="text" name="JML_KJ_P_KRJB_ANAK" value="<?=$data->JML_KJ_P_KRJB_ANAK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN LAMA ANAK (1-6 TAHUN)</label>
		<input type="text" name="JML_KJ_P_KRJL_ANAK" value="<?=$data->JML_KJ_P_KRJL_ANAK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN BARU ANAK USIA SEKOLAH (6-12)</label>
		<input type="text" name="JML_KJ_P_KRJB_ANAKSEKOLAH" value="<?=$data->JML_KJ_P_KRJB_ANAKSEKOLAH?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN LAMA ANAK USIA SEKOLAH (6-12)</label>
		<input type="text" name="JML_KJ_P_KRJL_ANAKSEKOLAH" value="<?=$data->JML_KJ_P_KRJL_ANAKSEKOLAH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI LAMA LUAR WILAYAH</label>
		<input type="text" name="JML_KJ_P_KRJGLL_WILAYAH" value="<?=$data->JML_KJ_P_KRJGLL_WILAYAH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN RAWAT JALAN GIGI BARU LUAR WILAYAH</label>
		<input type="text" name="JML_KJ_P_KRJGBL_WILAYAH" value="<?=$data->JML_KJ_P_KRJGBL_WILAYAH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >