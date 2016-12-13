<script>
$(document).ready(function(){
		$('#form1master_ruangan_edit').ajaxForm({
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
					$("#t45","#tabs").empty();
					$("#t45","#tabs").load('c_master_ruangan'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#nama_puskesmas_hidden').focus(function(){
			$("#dialog_cari_namapuskesmas").dialog({
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
			$('#dialog_cari_namapuskesmas').load('c_master_puskesmas/puskesmaspopup?id_caller=form1master_ruangan_edit', function() {
				$("#dialog_cari_namapuskesmas").dialog("open");
			});
		});
})
</script>
<script>
	$('#backlistmaster_ruangan').click(function(){
		$("#t45","#tabs").empty();
		$("#t45","#tabs").load('c_master_ruangan'+'?_=' + (new Date()).getTime());
	})	
</script>
<div class="mycontent">
<div id="dialog_cari_namapuskesmas" title="Puskesmas"></div>
<div class="formtitle">Edit Data Ruangan</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_ruangan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_ruangan_edit" method="post" action="<?=site_url('c_master_ruangan/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Ruangan</label>
		<input type="text" name="koderuangan" id="koderuangan" value="<?=$data->KD_RUANGAN?>" />
		<input type="hidden" name="koderuanganid" id="textid" value="<?=$data->KD_RUANGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Puskesmas</label>
		<input type="text" name="kodepuskesmas" id="nama_puskesmas_hidden" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="text" placeholder="Puskesmas" name="nama_puskesmas" id="nama_puskesmas" readonly value="<?=$data->PUSKESMAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Ruangan</label>
		<input type="text" name="ruangan" id="ruangan" value="<?=$data->NAMA_RUANGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >


