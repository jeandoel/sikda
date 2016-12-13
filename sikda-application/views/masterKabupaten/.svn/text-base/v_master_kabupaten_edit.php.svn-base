<script>
$(document).ready(function(){
		$('#form1masterKabedit').ajaxForm({
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
					$("#t26","#tabs").empty();
					$("#t26","#tabs").load('c_master_kabupaten'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#master_propinsi_id_hidden').focus(function(){
			$("#dialogcari_master_propinsi_id").dialog({
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
			$('#dialogcari_master_propinsi_id').load('c_master_propinsi/masterpropinsipopup?id_caller=form1masterKabedit', function() {
				$("#dialogcari_master_propinsi_id").dialog("open");
			});
		});
})
</script>
<script>
	$('#backlistmasterKab').click(function(){
		$("#t26","#tabs").empty();
		$("#t26","#tabs").load('c_master_kabupaten'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianeditkab').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<div id="dialogcari_master_propinsi_id" title="Propinsi"></div>
<div class="mycontent">
<div class="formtitle">Edit Kabupaten</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKab">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterKabedit" method="post" action="<?=site_url('c_master_kabupaten/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kabupaten</label>
		<input type="text" name="kode_kab" autocomplete="off" id="textid" value="<?=$data->KD_KABUPATEN?>" />
		<input type="hidden" name="id" autocomplete="off" id="textidd" value="<?=$data->KD_KABUPATEN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Provinsi</label>
		<input type="text" name="master_propinsi_id_column" id="master_propinsi_id_hidden" value="<?=$data->KD_PROVINSI?>"  />
		<input type="text" name="master_propinsi_id" id="master_propinsi_id" readonly value="<?=$data->PROVINSI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten</label>
		<input type="text" name="nama_kabupaten" autocomplete="off" id="text2" value="<?=$data->KABUPATEN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >