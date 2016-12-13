<script>
$(document).ready(function(){
		$('#form1mastermilikobatedit').ajaxForm({
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
					$("#t74","#tabs").empty();
					$("#t74","#tabs").load('c_master_milik_obat'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastermilikobat').click(function(){
		$("#t74","#tabs").empty();
		$("#t74","#tabs").load('c_master_milik_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Edit Milik Obat</div>
<div class="backbutton"><span class="kembali" id="backlistmastermilikobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1mastermilikobatedit" method="post" action="<?=site_url('c_master_milik_obat/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Milik Obat</label>
		<input type="text" name="kdmilikobat" id="text1" value="<?=$data->KD_MILIK_OBAT?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_MILIK_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kepemilikan</label>
	<input type="text" name="kepemilikan" id="text2" value="<?=$data->KEPEMILIKAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >