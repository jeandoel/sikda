<script>
$(document).ready(function(){
		$('#formmasterkeluarpasien').ajaxForm({
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
					$("#t34","#tabs").empty();
					$("#t34","#tabs").load('c_master_status_keluar_pasien'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglmastergd').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<script>
	$('#backlistmasterkeluarpasien').click(function(){
		$("#t34","#tabs").empty();
		$("#t34","#tabs").load('c_master_status_keluar_pasien'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Status Keluar Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistmasterkeluarpasien">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formmasterkeluarpasien" method="post" action="<?=site_url('c_master_status_keluar_pasien/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Status</label>
		<input type="text" name="kode_status" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan</label>
		<input type="text" name="keterangan" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >