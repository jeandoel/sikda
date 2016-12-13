<script>
$(document).ready(function(){
		$('#form1masterKasusedit').ajaxForm({
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
					$("#t21","#tabs").empty();
					$("#t21","#tabs").load('c_master_kasus'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#master_jenis_kasus_id').focus(function(){
			$("#dialogcari_master_jenis_kasus_id").dialog({
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
			$('#dialogcari_master_jenis_kasus_id').load('c_master_jenis_kasus/masterjeniskasuspopup?id_caller=form1masterKasusedit', function() {
				$("#dialogcari_master_jenis_kasus_id").dialog("open");
			});
		});
		
})
</script>
<script>
	$('#backlistmasterKasus').click(function(){
		$("#t21","#tabs").empty();
		$("#t21","#tabs").load('c_master_kasus'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
	<div id="dialogcari_master_jenis_kasus_id" title="Jenis Kasus"></div>
<div class="formtitle">Edit Kasus</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKasus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterKasusedit" method="post" action="<?=site_url('c_master_kasus/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Kasus</label>
		<input type="text"  name="kode_jenis_kasus" id="master_jenis_kasus_id"  value="<?=$data->KD_JENIS_KASUS?>" />
		<input type="hidden" name="id" autocomplete="off" id="textidd" value="<?=$data->VARIABEL_ID?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel ID</label>
		<input type="text" name="variabel_idd" id="text1" value="<?=$data->VARIABEL_ID?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Parent ID</label>
		<input type="text" name="parent_idd" id="text2" value="<?=$data->PARENT_ID?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel Name</label>
		<input type="text" name="variabel_name" id="text3" value="<?=$data->VARIABEL_NAME?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel Definisi</label>
		<input type="text" name="variabel_defi" id="text4" value="<?=$data->VARIABEL_DEFINISI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan</label>
		<input type="textarea" name="ket" id="text5" value="<?=$data->KETERANGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pilihan Value</label>
		<input type="text" name="pilihan_value" id="text6" value="<?=$data->PILIHAN_VALUE?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>I Row</label>
		<input type="text" name="IRow" id="text7" value="<?=$data->IROW?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >
