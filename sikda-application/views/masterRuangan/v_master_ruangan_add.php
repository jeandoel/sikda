	<script>
$(document).ready(function(){
		$('#form1master_ruangan_add').ajaxForm({
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
					$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
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
			$('#dialog_cari_namapuskesmas').load('c_master_puskesmas/puskesmaspopup?id_caller=form1master_ruangan_add', function() {
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
<div class="formtitle">Tambah Data Ruangan</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_ruangan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_ruangan_add" method="post" action="<?=site_url('c_master_ruangan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Ruangan</label>
		<input type="text" name="koderuangan" id="koderuangan" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Puskesmas</label>
		<input type="text" name="kodepuskesmas" id="nama_puskesmas_hidden" value="" />
		<input type="text" placeholder="Puskesmas" name="nama_puskesmas" id="nama_puskesmas" readonly value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Ruangan</label>
		<input type="text" name="ruangan" id="ruangan" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >