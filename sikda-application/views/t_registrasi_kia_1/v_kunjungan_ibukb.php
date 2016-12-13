	<script>
		$("#tanggal_kunjungan_ibu_kb").mask("99/99/9999");
		$("#tanggal_kunjungan_ibu_kb").focus();
		
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
		<label>Tanggal</label>
		<input type="text" name="tgl_transaksi" id="tanggal_kunjungan_ibu_kb" class="mydate" value="<?=date('d/m/Y')?>" required />
		</span>
	</fieldset>
		<?=getComboJeniskb('','kdjeniskb','jeniskbt_pelayanan_kb_add','required','')?>	
	<fieldset>
		<span>
		<label>Keluhan</label>
		<input type="text" name="keluhan" id="text1" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Anamnese</label>
		<input type="text" name="anamnese" id="text1" value="" required />
		</span>
	</fieldset>
	<?=getComboTindakan('','kdproduk','produkt_pelayanan_kb_add','required','')?>	
	<fieldset>
		<span>
		<label>Nama Pemeriksa</label>
		<input type="text" name="pemeriksa" id="text1" value="" required />
		</span>
	</fieldset>
	