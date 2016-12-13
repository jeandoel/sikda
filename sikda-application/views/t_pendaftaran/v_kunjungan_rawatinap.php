		<script>
		$("#tanggal_kunjunganid").mask("99/99/9999");
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
		
		$("#nokamart_pendaftaranpelayanan").remoteChained("#kamart_pendaftaranpelayanan", "<?=site_url('t_masters/getNoKamarByNamaKamar')?>");
		$("#nobedt_pendaftaranpelayanan").remoteChained("#nokamart_pendaftaranpelayanan", "<?=site_url('t_masters/getNoBedByNoKamar')?>");
		</script>
		<fieldset>
			<span>
				<label>Tanggal Kunjungan*</label>
				<input type="text" name="tanggal_kunjungan" id="tanggal_kunjunganid" value="<?=date('d/m/Y')?>" class="mydate" required  />
			</span>
		</fieldset>
		<?=getComboSpesialisasi2('','spesialisasi','spesialisasit_pendaftaranpelayanan','required','')?>	
		<?=getComboRuangan('','ruangan','ruangant_pendaftaranpelayanan','','')?>
		<fieldset>
			<span>
			<label>Kelas</label>
				<select name="kelas"  >
					<option value="">-silahkan pilih-</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>
			</span>
		</fieldset>
		<?=getComboKamar('','kamar','kamart_pendaftaranpelayanan','','')?>
		<fieldset>
			<?=getComboKamar('','no_kamar','nokamart_pendaftaranpelayanan','','inline')?>
			<span>
			<label>No. Tempat Tidur</label>
				<select name="no_tidur" id="nobedt_pendaftaranpelayanan">
					<option value="">-silahkan pilih-</option>
				</select>
			</span>
		</fieldset>
		<fieldset>
			<span>
				<label>Petugas 1</label>
				<input type="text" name="petugas" readonly value="<?=$this->session->userdata('kd_petugas')?>"  />
			</span>
		</fieldset>	
		<?=getComboDokterdanPetugas('','petugas2','petugas2t_pendaftaranpelayanan','','')?>