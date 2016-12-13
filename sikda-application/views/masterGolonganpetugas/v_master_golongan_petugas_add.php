<script>
$(document).ready(function(){
		$('#golonganadd').ajaxForm({
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
					$("#t65","#tabs").empty();
					$("#t65","#tabs").load('c_master_golongan'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglgolongan').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistgolongan').click(function(){
		$("#t65","#tabs").empty();
		$("#t65","#tabs").load('c_master_golongan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Golongan</div>
<div class="backbutton"><span class="kembali" id="backlistgolongan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="golonganadd" method="post" action="<?=site_url('c_master_golongan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE GOLONGAN</label>
		<input type="text" name="kd_golongan" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA GOLONGAN</label>
		<input type="text" name="nama_golongan" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >