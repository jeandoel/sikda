<script>
$(document).ready(function(){
		$('#form1mastersatuanbesaredit').ajaxForm({
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
					$("#t71","#tabs").empty();
					$("#t71","#tabs").load('c_master_satuan_besar'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastersatuanbesar').click(function(){
		$("#t71","#tabs").empty();
		$("#t71","#tabs").load('c_master_satuan_besar'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Edit Satuan Besar</div>
<div class="backbutton"><span class="kembali" id="backlistmastersatuanbesar">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1mastersatuanbesaredit" method="post" action="<?=site_url('c_master_satuan_besar/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Satuan Besar</label>
		<input type="text" name="kdsatbesar" id="text1" value="<?=$data->KD_SAT_BESAR?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_SAT_BESAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Satuan Besar Obat</label>
	<input type="text" name="satbesarobat" id="text2" value="<?=$data->SAT_BESAR_OBAT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >