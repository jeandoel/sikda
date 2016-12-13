<script>
$(document).ready(function(){
		$('#form1mastersatuankeciladd').ajaxForm({
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
					$("#t72","#tabs").empty();
					$("#t72","#tabs").load('c_master_satuan_kecil'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastersatuankecil').click(function(){
		$("#t72","#tabs").empty();
		$("#t72","#tabs").load('c_master_satuan_kecil'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Satuan Kecil</div>
<div class="backbutton"><span class="kembali" id="backlistmastersatuankecil">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1mastersatuankeciladd" method="post" action="<?=site_url('c_master_satuan_kecil/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Satuan Kecil Obat</label>
		<input type="text" name="kdsatkclobat" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Satuan Kecil Obat</label>
		<input type="text" name="satkclobat" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >