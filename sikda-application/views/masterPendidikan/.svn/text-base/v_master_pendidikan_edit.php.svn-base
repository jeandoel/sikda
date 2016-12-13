<script>
$(document).ready(function(){
		$('#form1master_pendidikan_edit').ajaxForm({
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
					$("#t42","#tabs").empty();
					$("#t42","#tabs").load('c_master_pendidikan'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#master_kabupaten_id_hidden').focus(function(){
			$("#dialogcari_master_kabupaten_id").dialog({
				autoOpen: false,
				modal:true,
				width: 500,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_master_kabupaten_id').load('c_master_kabupaten/masterkabupatenpopup?id_caller=form1master_pendidikan_edit', function() {
				$("#dialogcari_master_kabupaten_id").dialog("open");
			});
		});
		
})
</script>
<script>
	$('#backlistmaster_pendidikan').click(function(){
		$("#t42","#tabs").empty();
		$("#t42","#tabs").load('c_master_pendidikan'+'?_=' + (new Date()).getTime());
	})	
</script>
<div class="mycontent">
<div class="formtitle">Edit Data Pendidikan</div>
<div id="dialogcari_master_kabupaten_id" title="Kabupaten"></div>
<div class="backbutton"><span class="kembali" id="backlistmaster_pendidikan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_pendidikan_edit" method="post" action="<?=site_url('c_master_pendidikan/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Pendidikan</label>
		<input type="text" name="kodependidikan" id="kodependidikan" value="<?=$data->KD_PENDIDIKAN?>" />
		<input type="hidden" name="kodependidikanid" id="textid" value="<?=$data->KD_PENDIDIKAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pendidikan</label>
		<input type="text" name="pendidikan" id="pendidikan" value="<?=$data->PENDIDIKAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >


