<script>
$(document).ready(function(){
		$('#form1master1edit').ajaxForm({
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
					$("#t6","#tabs").empty();
					$("#t6","#tabs").load('master1'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmaster1').click(function(){
		$("#t6","#tabs").empty();
		$("#t6","#tabs").load('master1'+'?_=' + (new Date()).getTime());
	})
	$('#tglmaster1').datepicker({dateFormat: "yy-mm-dd",changeYear: true,yearRange: "-100:+0"});
</script>
<div class="mycontent">
<div class="formtitle">Input Laporan Kasus</div>
<div class="backbutton"><span class="kembali" id="backlistmaster1">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master1edit" method="post" action="<?=site_url('master1/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Column Satu</label>
		<input type="text" name="column1" id="text1" value="<?=$data->ncolumn1?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_master1?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Dua</label>
		<input type="text" name="column2" id="text2" value="<?=$data->ncolumn2?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Tiga</label>
		<textarea name="column3" rows="3" cols="45"><?=$data->ncolumn3?></textarea>
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Master Satu</label>
		<input type="text" name="tglmaster1" id="tglmaster1" value="<?=$data->ntgl_master1?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >