<script>
$(document).ready(function(){
		$('#form1jeniskasusedit').ajaxForm({
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
					$("#t52","#tabs").empty();
					$("#t52","#tabs").load('c_master_jenis_kasus'+'?_=' + (new Date()).getTime());
				}
			}
		});
		$('#nama_icdinduk_hidden').focus(function(){
			$("#dialog_cari_namaicdinduk").dialog({
				autoOpen: false,
				modal:true,
				width: 545,
				height: 455,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialog_cari_namaicdinduk').load('c_master_icd_induk/icdindukpopup?id_caller=form1jeniskasusedit', function() {
				$("#dialog_cari_namaicdinduk").dialog("open");
			});
		});
})
</script>
<script>
	$('#backlistjeniskasus').click(function(){
		$("#t52","#tabs").empty();
		$("#t52","#tabs").load('c_master_jenis_kasus'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div id="dialog_cari_namaicdinduk" title="Master ICD"></div>
<div class="formtitle">Edit Jenis Kasus</div>
<div class="backbutton"><span class="kembali" id="backlistjeniskasus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1jeniskasusedit" method="post" action="<?=site_url('c_master_jenis_kasus/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Kasus</label>
		<input type="text" name="kodejeniskasus" id="kodejeniskasus" value="<?=$data->KD_JENIS_KASUS?>"  />
		<input type="hidden" name="id" id="kodejeniskasus" value="<?=$data->KD_JENIS_KASUS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Kasus</label>
		<input type="text" name="jeniskasus" id="jeniskasus" value="<?=$data->JENIS_KASUS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode ICD</label>
		<input type="text" name="kodeicd" id="nama_icdinduk_hidden" value="<?=$data->KD_ICD_INDUK?>"  />
		<input type="text" placeholder="" name="nama_icdinduk" id="nama_icdinduk" value="<?=$data->namapenyakit?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Jenis</label>
		<input type="text" name="kodejenis" id="kodejenis" value="<?=$data->KD_JENIS?>"  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >