<script>
$(document).ready(function(){
		$('#formgigi_map_gigiadd').ajaxForm({
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
					$("#t1005","#tabs").empty();
					$("#t1005","#tabs").load('c_map_gigi_permukaan'+'?_=' + (new Date()).getTime());
				}
			}
		});

		$('#master_gigi_status_id_hidden').focus(function(){
			$("#dialogcari_master_gigi_status_id").dialog({
				autoOpen: false,
				modal:true,
				width: 700,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_master_gigi_status_id').load('c_master_gigi_status/masterPopup?id_caller=gigi_status_pop', function() {
				$("#dialogcari_master_gigi_status_id").dialog("open");
			});
		});

		$('#kode_id').focus(function(){
			$("#dialogcari_gigi_permukaan").dialog({
				autoOpen: false,
				modal:true,
				width: 700,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_gigi_permukaan').load('c_master_gigi_permukaan/masterPopup?id_caller=gigi_permukaan_pop', function() {
				$("#dialogcari_gigi_permukaan").dialog("open");
			});
		});

})
</script>
<script>
	$('#backlist_map_gigi').click(function(){
		$("#t1005","#tabs").empty();
		$("#t1005","#tabs").load('c_map_gigi_permukaan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Gambar Permukaan Gigi</div>
<div class="backbutton"><span class="kembali" id="backlist_map_gigi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formgigi_map_gigiadd" method="post" action="<?=site_url('c_map_gigi_permukaan/addprocess')?>" enctype="multipart/form-data">
	<div id="gigi_status_pop">
		<div id="dialogcari_master_gigi_status_id" title="Status Gigi"></div>
		<fieldset>
			<span>
				<label class="w-dialog-label">Status Gigi</label>
				<input type="hidden" name="id_status_gigi" id="master_id_status_gigi" style="width:50px;font-size:12px;" value="" tabindex="3" />
				<input type="text" name="kd_status_gigi" id="master_gigi_status_id_hidden" style="width:50px;font-size:12px;" value="" tabindex="3" />
				<input type="text" placeholder="Nama status gigi" name="master_gigi_status_id" id="master_gigi_status_id" style="font-size:12px;" readonly value="" tabindex="3" />
			</span>
		</fieldset>
	</div>
	<div id="gigi_permukaan_pop">
		<div id="dialogcari_gigi_permukaan" title="Permukaan Gigi"></div>
		<fieldset>
			<span>
				<label class="w-dialog-label">Permukaan Gigi</label>
				<input type="hidden" name="kd_gigi_permukaan" id="kd_gigi_permukaan_id" style="width:50px;font-size:12px;" value="" tabindex="3" />
				<input type="text" name="kode_id" id="kode_id" style="width:50px;font-size:12px;" value="" tabindex="3" />
				<input type="text" placeholder="Nama status gigi" name="nama_id" id="nama_id" style="font-size:12px;" readonly value="" tabindex="3" />
			</span>
		</fieldset>
	</div>
	<fieldset>
		<span>
		<label>Gambar</label>
		<input type="file" name="gambar"/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >