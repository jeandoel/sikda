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
		</script>
		<fieldset>
			<span>
				<label>Tanggal Kunjungan*</label>
				<input type="text" name="tanggal_kunjungan" id="tanggal_kunjunganid" value="<?=date('d/m/Y')?>" class="mydate" required  />
			</span>
		</fieldset>
		<?=getComboUnitlayanan('','unit_layanan','unit_layanant_pendaftaranpelayanan','required','')?>	
		<?=getComboPoliklinik('','poliklinik','poliklinikt_pendaftaranpelayanan','required','')?>
		<fieldset>
			<span>
				<label>Petugas 1</label>
				<input type="text" name="petugas" readonly value="<?=$this->session->userdata('kd_petugas')?>"
			</span>
		</fieldset>
		<?=getComboDokterdanPetugas('','petugas2','petugas2t_pendaftaranpelayanan','','')?>
		