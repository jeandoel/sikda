		<script>
		
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
		<div class="formtitle">Kesimpulan Akhir Nifas</div>
		<fieldset>
		<?=getComboKeadaanibu('','kead_ibu','keaad_pendaftaranadd','required','inline')?>
		</fieldset>
		<fieldset>
		<?=getComboKeadaanbayi('','kead_bayi','keaad_pendaftaranadd','required','inline')?>
		</fieldset>
		<fieldset>
		<?=getComboKomplikasinifas('','komp_nifas','komplikasi_pendaftaranadd','required','inline')?>
		</fieldset>
			