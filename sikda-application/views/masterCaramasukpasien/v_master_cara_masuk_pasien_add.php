	<script>
$(document).ready(function(){
		$('#form1master_cara_masuk_pasien_add').ajaxForm({
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
					$("#t55","#tabs").empty();
					$("#t55","#tabs").load('c_master_cara_masuk_pasien'+'?_=' + (new Date()).getTime());
				}
			}
		});	
})
</script>
<script>
	$('#backlistmaster_cara_masuk_pasien').click(function(){
		$("#t55","#tabs").empty();
		$("#t55","#tabs").load('c_master_cara_masuk_pasien'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Cara Masuk Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_cara_masuk_pasien">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_cara_masuk_pasien_add" method="post" action="<?=site_url('c_master_cara_masuk_pasien/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Cara Masuk</label>
		<input type="text" name="kodecaramasuk" id="kodecaramasuk" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Cara Masuk</label>
		<input type="text" name="caramasuk" id="caramasuk" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >