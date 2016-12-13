<script>
$(document).ready(function(){
		$('#form1masterKotaedit').ajaxForm({
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
					$("#t27","#tabs").empty();
					$("#t27","#tabs").load('c_master_kota'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmasterKota').click(function(){
		$("#t27","#tabs").empty();
		$("#t27","#tabs").load('c_master_kota'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianeditkota').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Kota</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKota">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterKotaedit" method="post" action="<?=site_url('c_master_kota/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Kota</label>
		<input type="text" name="nama_kota" autocomplete="off" id="text1" value="<?=$data->nnama_kota?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_kota?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Master</label>
		<input type="text" name="tglmasterKota" id="tglkejadianeditkota" value="<?=$data->ntgl_master_kota?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >