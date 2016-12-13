<script>
$(document).ready(function(){
		$('#form1master_pendidikan_add').ajaxForm({
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
					$("#t42","#tabs").empty();
					$("#t42","#tabs").load('c_master_pendidikan'+'?_=' + (new Date()).getTime());
				}
			}
		});	
})
</script>
<script>
	$('#backlistmaster_pendidikan').click(function(){
		$("#t42","#tabs").empty();
		$("#t42","#tabs").load('c_master_pendidikan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Data Pendidikan</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_pendidikan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_pendidikan_add" method="post" action="<?=site_url('c_master_pendidikan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Pendidikan</label>
		<input type="text" name="kodependidikan" id="kodependidikan" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pendidikan</label>
		<input type="text" name="pendidikan" id="pendidikan" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >