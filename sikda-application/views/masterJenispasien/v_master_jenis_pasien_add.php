	<script>
$(document).ready(function(){
		$('#form1master_jenis_pasien_add').ajaxForm({
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
					$("#t59","#tabs").empty();
					$("#t59","#tabs").load('c_master_jenis_pasien'+'?_=' + (new Date()).getTime());
				}
			}
		});	
})
</script>
<script>
	$('#backlistmaster_jenis_pasien').click(function(){
		$("#t59","#tabs").empty();
		$("#t59","#tabs").load('c_master_jenis_pasien'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Jenis Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_jenis_pasien">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_jenis_pasien_add" method="post" action="<?=site_url('c_master_jenis_pasien/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Pasien</label>
		<input type="text" placeholder="Otomatis" name="kodejenispasien" id="kodejenispasien" value="" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Pasien</label>
		<input type="text" name="jenispasien" id="jenispasien" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >