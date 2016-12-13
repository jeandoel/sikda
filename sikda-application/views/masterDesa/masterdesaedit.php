<script>
$(document).ready(function(){
		$('#formdesamasterdesaedit').ajaxForm({
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
					$("#t19","#tabs").empty();
					$("#t19","#tabs").load('masterdesa'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmasterdesa').click(function(){
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('masterdesa'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianedit').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Input Nama Desa</div>
<div class="backbutton"><span class="kembali" id="backlistmasterdesa">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formdesamasterdesaedit" method="post" action="<?=site_url('masterdesa/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Desa</label>
		<input type="text" name="kolom_desa" id="text1" value="<?=$data->nnama_desa?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_desa?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Master Desa</label>
		<input type="text" name="tglmasterdesa" id="tglkejadianedit" value="<?=$data->ntgl_master_desa?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >