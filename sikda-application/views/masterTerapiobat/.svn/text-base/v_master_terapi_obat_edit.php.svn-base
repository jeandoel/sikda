<script>
$(document).ready(function(){
		$('#form1master_terapiobat_edit').ajaxForm({
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
					$("#t43","#tabs").empty();
					$("#t43","#tabs").load('c_master_terapi_obat'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
})
</script>
<script>
	$('#backlistmaster_terapiobat').click(function(){
		$("#t43","#tabs").empty();
		$("#t43","#tabs").load('c_master_terapi_obat'+'?_=' + (new Date()).getTime());
	})	
</script>
<div class="mycontent">
<div class="formtitle">Edit Data Terapi Obat</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_terapiobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_terapiobat_edit" method="post" action="<?=site_url('c_master_terapi_obat/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Terapi Obat</label>
		<input type="text" name="kodeterapiobat" id="kodeterapiobat" value="<?=$data->KD_TERAPI_OBAT?>" />
		<input type="hidden" name="kodeterapiobatid" id="textid" value="<?=$data->KD_TERAPI_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Terapi Obat</label>
		<input type="text" name="terapiobat" id="terapiobat" value="<?=$data->TERAPI_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >


