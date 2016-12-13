<script>
$(document).ready(function(){
		$('#form1masterpekerjaanedit').ajaxForm({
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
					$.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
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
<div class="formtitle">Edit Master Pekerjaan</div>
<div class="backbutton"><span class="kembali" id="backlistmasterpekerjaan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterpekerjaanedit" method="post" action="<?=site_url('c_master_pekerjaan/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Pekerjaan</label>
		<input type="text" name="kodepekerjaan" id="kodepekerjaan" value="<?=$data->KD_PEKERJAAN?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_PEKERJAAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pekerjaan</label>
		<input type="text" name="pekerjaan" id="pekerjaan" value="<?=$data->PEKERJAAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >


