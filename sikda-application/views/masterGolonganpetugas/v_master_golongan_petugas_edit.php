<script>
$(document).ready(function(){
		$('#golonganedit').ajaxForm({
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
					$("#t65","#tabs").empty();
					$("#t65","#tabs").load('c_master_golongan'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistgolongan').click(function(){
		$("#t65","#tabs").empty();
		$("#t65","#tabs").load('c_master_golongan'+'?_=' + (new Date()).getTime());
	})
	$('#tglgolongan').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Ubah Golongan Obat</div>
<div class="backbutton"><span class="kembali" id="backlistgolongan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="golonganedit" method="post" action="<?=site_url('c_master_golongan/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE GOLONGAN OBAT</label>
		<input type="text" name="kd_golongan" id="kd_golongan" value="<?=$data->KD_GOLONGAN?>" />
		<input type="hidden" name="kd_gol" id="textid" value="<?=$data->KD_GOLONGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA GOLONGAN</label>
		<input type="text" name="nama_golongan" id="text2" value="<?=$data->NM_GOLONGAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >