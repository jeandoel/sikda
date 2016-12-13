<script>
$(document).ready(function(){
		$('#form1mastergolobatedit').ajaxForm({
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
					$("#t22","#tabs").empty();
					$("#t22","#tabs").load('c_master_gol_obat'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastergolobat').click(function(){
		$("#t22","#tabs").empty();
		$("#t22","#tabs").load('c_master_gol_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Edit Golongan Obat</div>
<div class="backbutton"><span class="kembali" id="backlistmastergolobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1mastergolobatedit" method="post" action="<?=site_url('c_master_gol_obat/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Golongan Obat</label>
		<input type="text" name="kd_gol_obat" autocomplete="off" id="text1" value="<?=$data->KD_GOL_OBAT?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_GOL_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Golongan Obat</label>
		<input type="text" name="gol_obat" id="text2" value="<?=$data->GOL_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >