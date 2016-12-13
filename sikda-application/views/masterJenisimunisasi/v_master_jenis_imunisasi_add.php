	<script>
$(document).ready(function(){
		$('#form1master_jenis_imunisasi_add').ajaxForm({
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
					$("#t60","#tabs").empty();
					$("#t60","#tabs").load('c_master_jenis_imunisasi'+'?_=' + (new Date()).getTime());
				}
			}
		});	
})
</script>
<script>
	$('#backlistmaster_jenis_imunisasi').click(function(){
		$("#t60","#tabs").empty();
		$("#t60","#tabs").load('c_master_jenis_imunisasi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Jenis Imunisasi</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_jenis_imunisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_jenis_imunisasi_add" method="post" action="<?=site_url('c_master_jenis_imunisasi/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Imunisasi</label>
		<input type="text" placeholder="Otomatis" name="kodejenisimunisasi" id="kodejenisimunisasi" value="" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Imunisasi</label>
		<input type="text" name="jenisimunisasi" id="jenisimunisasi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >