<script>
$(document).ready(function(){
		$('#formposisimasterposisiadd').ajaxForm({
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
					$("#t11","#tabs").empty();
					$("#t11","#tabs").load('c_master_posisi'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmasterposisi').click(function(){
		$("#t11","#tabs").empty();
		$("#t11","#tabs").load('c_master_posisi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Master Posisi</div>
<div class="backbutton"><span class="kembali" id="backlistmasterposisi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formposisimasterposisiadd" method="post" action="<?=site_url('c_master_posisi/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Posisi</label>
		<input type="text" name="kode_posisi" id="kode_posisi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Posisi</label>
		<input type="text" name="nama_posisi" id="nama_posisi" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >