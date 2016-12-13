<script>
$(document).ready(function(){
		$('#form1masterpekerjaanadd').ajaxForm({
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
					$("#t54","#tabs").empty();
					$("#t54","#tabs").load('c_master_pekerjaan'+'?_=' + (new Date()).getTime());
				}
			}
		});	
})
</script>
<script>
	$('#backlistmasterpekerjaan').click(function(){
		$("#t54","#tabs").empty();
		$("#t54","#tabs").load('c_master_pekerjaan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Master Pekerjaan</div>
<div class="backbutton"><span class="kembali" id="backlistmasterpekerjaan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterpekerjaanadd" method="post" action="<?=site_url('c_master_pekerjaan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Pekerjaan</label>
		<input type="text" name="kodepekerjaan" id="kodepekerjaan" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pekerjaan</label>
		<input type="text" name="pekerjaan" id="pekerjaan" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >