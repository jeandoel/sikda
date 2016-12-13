<script>
$(document).ready(function(){
		$('#form1masterjenisobatedit').ajaxForm({
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
					$("#t73","#tabs").empty();
					$("#t73","#tabs").load('c_master_jenis_obat'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmasterjenisobat').click(function(){
		$("#t73","#tabs").empty();
		$("#t73","#tabs").load('c_master_jenis_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Edit Jenis Obat</div>
<div class="backbutton"><span class="kembali" id="backlistmasterjenisobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterjenisobatedit" method="post" action="<?=site_url('c_master_jenis_obat/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Obat</label>
		<input type="text" name="kdjnsobat" id="text1" value="<?=$data->KD_JNS_OBT?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_JNS_OBT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Obat</label>
	<input type="text" name="jenisobat" id="text2" value="<?=$data->JENIS_OBAT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >