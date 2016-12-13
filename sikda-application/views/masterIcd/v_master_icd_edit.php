<script>
$(document).ready(function(){
		$('#formmastericdedit').ajaxForm({
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
					$("#t33","#tabs").empty();
					$("#t33","#tabs").load('c_master_icd'+'?_=' + (new Date()).getTime());
				}
			}
		});
                 $('#nama_icdinduk_hidden').focus(function(){
			$("#dialog_cari_namaicdinduk").dialog({
				autoOpen: false,
				modal:true,
				width: 800,
				height: 355,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			
			$('#dialog_cari_namaicdinduk').load('c_master_icd_induk/icdindukpopup?id_caller=formmastericdedit', function() {
				$("#dialog_cari_namaicdinduk").dialog("open");
			});
		});
})
</script>
<script>
	$('#backlistmastericd').click(function(){
		$("#t33","#tabs").empty();
		$("#t33","#tabs").load('c_master_icd'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianedit').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">
<div id="dialog_cari_namaicdinduk" title="Master ICD Induk"></div>
<div class="formtitle">Input Laporan Kasus</div>
<div class="backbutton"><span class="kembali" id="backlistmastericd">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formmastericdedit" method="post" action="<?=site_url('c_master_icd/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Penyakit</label>
		<input type="text" name="kode_penyakit" id="text1"  value="<?=$data->KD_PENYAKIT?>" />
		<input type="hidden"  name="kd" id="text1" value="<?=$data->KD_PENYAKIT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode ICD Induk</label>
		<input type="text" name="kode_icd_induk" id="nama_icdinduk_hidden" value="<?=$data->KD_ICD_INDUK?>"  />
		<input type="text" placeholder="ICD Induk" name="nama_icdinduk" id="nama_icdinduk" readonly value="<?=$data->icd_induk?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Penyakit</label>
		<input type="text" name="penyakit" id="text1"  value="<?=$data->PENYAKIT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Includes</label>
		<input type="text" name="includes" id="text1"  value="<?=$data->INCLUDES?>"/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Excludes</label>
		<input type="text" name="excludes" id="text1"  value="<?=$data->EXCLUDES?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Notes</label>
		<input type="text" name="notes" id="text1"  value="<?=$data->NOTES?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Status APP</label>
		<input type="text" name="status_app" id="text1"   value="<?=$data->STATUS_APP?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Description</label>
		<input type="text" name="description" id="text1"  value="<?=$data->DESCRIPTION?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Is Default</label>
		<input type="radio" value="1" <?=$data->IS_DEFAULT=='1'?'checked':''?> name="is_default">1
		<input type="radio" value="0" <?=$data->IS_DEFAULT=='0'?'checked':''?> name="is_default">0
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Odontogram</label>
		<input type="radio" value="1" <?=$data->IS_ODONTOGRAM=='1'?'checked':''?> name="is_odontogram">Ya
		<input type="radio" value="0" <?=$data->IS_ODONTOGRAM=='0'?'checked':''?> name="is_odontogram">Tidak
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >