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
		
		$('#poliklinikt_pendaftaranpelayanan').on('change', function() {
			if($(this).val()==219){
				$('#pilihkunjungankia').show();
			}else{
				$('#pilihkunjungankia').hide();
			}
		});
		
		$('#pilihkategorikia').on('change', function() {
			if($(this).val()==1){
				$('#kunjungankia_holder').empty();
				$('#kunjungankia_holder').load('t_registrasi_kia/add?_='+ (new Date()).getTime());
			}else if($(this).val()==2){
				$('#kunjungankia_holder').empty();
				$('#kunjungankia_holder').load('t_registrasi_kia/kesehatananak?_='+ (new Date()).getTime());
			}else{
				$('#kunjungankia_holder').empty();
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
		<fieldset id="pilihkunjungankia" style="display:none">
			<span>
				<label>Kategori KIA</label>
				<select name="kategori_kia" id="pilihkategorikia">
					<option value="">- silahkan pilih -</option>
					<option value="1">Kesehatan Ibu</option>
					<option value="2">Kesehatan Anak/Bayi</option>
				</select>
			</span>
		</fieldset>
	<div id="kunjungankia_holder"></div>
	