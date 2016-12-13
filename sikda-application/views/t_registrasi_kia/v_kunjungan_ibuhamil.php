<script>
//$('#tanggal_kunjunganid').datepicker({dateFormat: "dd/mm/yy",changeYear: true});
$('#tanggal_kembaliid').datepicker({dateFormat: "dd/mm/yy",changeYear: true});
$("#tanggal_kunjunganid").mask("99/99/9999");
$("#tanggal_kembaliid").mask("99/99/9999");
$("#tanggal_kunjunganid").focus();

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
	var n = $(":text,:radio,:checkbox,select,textarea").length;
	if (e.which == 13) 
	{
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($(this).closest("form").valid()) {
				$(this).closest("form").submit();
			}
			return false;
		}
	}
});
</script>
<script>
$("#form1t_registrasi_kiaadd input[name = 'lihat'], #lihat_kunjungan").click(function(){
		$("#t303","#tabs").empty();
		$("#t303","#tabs").load('kunjungan_ibu_hamil'+'?_=' + (new Date()).getTime());
});
$('#hpht').mask('99/99/9999');

</script>
		
		
		<fieldset>
			<span>
				<label>Kunjungan Ke</label>
				<select name="kunjungan_ke" id="kunjungan_ke_ibu_hamil">
					<option value="">- silahkan pilih -</option>
					<option value="K1">K1</option>
					<option value="K2">K2</option>
					<option value="K3">K3</option>
					<option value="K4">K4</option>
					<option value="K5">K5</option>
					<option value="K6">K6</option>
					<option value="K7">K7</option>
					<option value="K8">K8</option>
					<option value="K9">K9</option>
					<option value="K10">K10</option>
				</select>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Keluhan Sekarang</label>
				<textarea placeholder="Sebutkan Keluhan" name="keluhan" id="keluhan_ibu_hamil" value="" style="width:195px;height:75px"></textarea>
			</span>
		</fieldset>
		<fieldset>
			<span>
				<label>Tekanan Darah (mmHg)</label>
				<input type="text" name="tekanan_darah" id="tekanan_darah_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Berat Badan (Kg)</label>
				<input type="text" name="berat_badan" id="berat_badan_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Umur Kehamilan (minggu)</label>
				<input type="text" name="umur_kehamilan" id="umur_kehamilan_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Tinggi Fundus (cm)</label>
				<input type="text" name="tinggi_fundus" id="tinggi_fundus_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Letak Janin</label>
				<select name="letak_janin" id="letak_janin_ibu_hamil">
					<option value="">- silahkan pilih -</option>
					<option value="Sungsang">Sungsang</option>
					<option value="Melintang">Melintang</option>
				</select>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Denyut Jantung Janin per Menit</label>
				<input type="text" name="denyut_jantung" id="denyut_jantung_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Kaki Bengkak</label>
				<select name="kaki_bengkak" id="kaki_bengkak_ibu_hamil">
					<option value="">- silahkan pilih -</option>
					<option value="+">Positif (+)</option>
					<option value="-">Negatif (-)</option>
				</select>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Lab Darah HB (gram%)</label>
				<input type="text" name="lab_darah" id="lab_darah_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Lab Urine Reduksi</label>
				<input type="text" name="lab_urine" id="lab_urine_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Lab Urine Protein</label>
				<input type="text" name="lab_urine_protein" id="lab_urine_protein_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>HPHT dan HPL</label>
				<input type="text" name="hpht" id="hpht"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Tindakan</label>
				<input type="text" name="tindakan" id="tindakan_ibu_hamil"  value=""  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Pemeriksaan Khusus</label>
				<select name="pemeriksaan_khusus" id="pemeriksaan_khusus_ibu_hamil">
					<option value="">- silahkan pilih -</option>
					<option value=""></option>
					<option value=""></option>
				</select>
			</span>
		</fieldset>	
		<?=getComboKasus('','kasus_temu','kasus_temu_ibu_hamil','','')?>
		<?=getComboKasus1('','kasus_ditangani','kasus_ditangani_ibu_hamil','','')?>
		<?=getComboKasus2('','kasus_dirujuk','kasus_dirujuk_ibu_hamil','','')?>
		<?=getComboKasus3('','kasus_kematian','kasus_kematian_ibu_hamil','','')?>
		<fieldset>
			<span>
				<label>Penyebab Kematian</label>
				<select name="sebab_mati" id="sebab_mati_ibu_hamil">
					<option value="">- silahkan pilih -</option>
					<option value=""></option>
					<option value=""></option>
				</select>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Status Hamil</label>
				<input type="text" name="status_hamil" id="status_hamil_ibu_hamil"  value="Belum Melahirkan"  />
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Nasehat yang Disampaikan</label>
				<textarea type="text" name="nasehat" id="nasehat_ibu_hamil" value="" style="width:195px;height:75px"></textarea>
			</span>
		</fieldset>	
		<fieldset>
			<span>
				<label>Tanggal Kembali*</label>
				<input type="text" name="tanggal_kembali" id="tanggal_kembaliid" value="<?=date('d/m/Y')?>" class="mydate" required  />
			</span>
		</fieldset>
		<?=getComboDokter1('','pemeriksa','pemeriksa_ibu_hamil','required','')?>
		<fieldset>
			<?=getComboDokter2('','petugas','petugas_ibu_hamil','required','inline')?>
			<span>
				<input type="button" name="lihat" id="lihat_kunjungan" value="Lihat Kunjungan">
			</span>
		</fieldset>
