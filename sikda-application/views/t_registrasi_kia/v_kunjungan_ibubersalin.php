	<script>
		$("#tanggal_daftart_ibu_bersalin").mask("99/99/9999");
		$("#tanggal_daftart_ibu_bersalin").focus();
		
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
	<fieldset>
		<span>
		<label>Tanggal Daftar* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_daftar" class="mydate" id="tanggal_daftart_ibu_bersalin" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jam Kelahiran</label>
		<input type="text" name="jam_kelahiran" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>
		<?=getComboKetwaktu('','ket_waktu','ket_waktu','requied','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<label>Umur Kehamilan(minggu)</label>
		<input type="text" name="umur_kehamilan" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	<fieldset>
		<?=getComboDokter('','dokter','dokter','required','inline')?>		
	</fieldset>
	<fieldset>
		<?=getComboJenispersalinan('','jenis_persalinan','jenis_persalinan','required','inline')?>		
	</fieldset>
	<fieldset>
		<?=getComboJeniskelahiran('','jenis_kelahiran','jenis_kelahiran','required','inline')?>	
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bayi</label>
		<input type="text" name="jumlah_bayi" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	<fieldset>
		<?=getComboKesehatan('','keadaan_kesehatan','keadaan_kesehatan','required','inline')?>	
	</fieldset>
	
	<fieldset>
		<?=getComboStatushamil('','status_hamil','status_hamil','required','inline')?>	
	</fieldset>
	
	<div class="subformtitle">Bayi saat Lahir</div>
        <fieldset>
		<span>
		<label>Anak Ke</label>
		<input type="text" name="anak_ke" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	 <fieldset>
		<span>
		<label>Berat Lahir (gram)</label>
		<input type="text" name="berat_lahir" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	  <fieldset>
		<span>
		<label>Panjang Badan(cm)</label>
		<input type="text" name="panjang_badan" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	   <fieldset>
		<span>
		<label>Lingkar Kepala(cm)</label>
		<input type="text" name="lingkar_kepala" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
        <fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="radio" name="jk" value="L">Laki - Laki
		<input type="radio" name="jk" value="P">Perempuan
		</span>
	</fieldset>
        <fieldset>
		<?=getComboKeadaanbayilahir('','keadaan_bayi_lahir','keadaan_bayi_lahir','required','inline')?>	
	</fieldset>
	<fieldset>
		<?=getComboAsuhanbayilahir('','asuhan_bayi_lahir','asuhan_bayi_lahir','required','inline')?>	
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan Tambahan</label>
		<textarea name="ket_tambahan2" rows="3" cols="45"></textarea>
		</span>	
	</fieldset>
