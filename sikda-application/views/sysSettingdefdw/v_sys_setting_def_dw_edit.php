<script>
$(document).ready(function(){
		$('#form1_sys_setting_def_dw_edit').ajaxForm({
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
					$("#t56","#tabs").empty();
					$("#t56","#tabs").load('c_sys_setting_def_dw'+'?_=' + (new Date()).getTime());
				}
			}
		});
		$('#nama_puskesmas_hidden').focus(function(){
			$("#dialog_cari_namapuskesmas").dialog({
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
			$('#dialog_cari_namapuskesmas').load('c_master_puskesmas/puskesmaspopup?id_caller=form1_sys_setting_def_dw_edit', function() {
				$("#dialog_cari_namapuskesmas").dialog("open");
			});
		});
		
		$('#master_propinsi_id_hidden').focus(function(){
			$("#dialogcari_master_propinsi_id").dialog({
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
			$('#dialogcari_master_propinsi_id').load('c_master_propinsi/masterpropinsipopup?id_caller=form1_sys_setting_def_dw_edit', function() {
				$("#dialogcari_master_propinsi_id").dialog("open");
			});
		});
		
		$('#master_kabupaten_id_hidden').focus(function(){
			$("#dialogcari_master_kabupaten_id").dialog({
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
			$('#dialogcari_master_kabupaten_id').load('c_master_kabupaten/masterkabupatenpopup?id_caller=form1_sys_setting_def_dw_edit', function() {
				$("#dialogcari_master_kabupaten_id").dialog("open");
			});
		});
		
		$('#master_kecamatan_id_hidden').focus(function(){
			$("#dialogcari_master_kecamatan_id").dialog({
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
			$('#dialogcari_master_kecamatan_id').load('c_master_kecamatan/masterkecamatanpopup?id_caller=form1_sys_setting_def_dw_edit', function() {
				$("#dialogcari_master_kecamatan_id").dialog("open");
			});
		});
		
		$('#master_kelurahan_id_hidden').focus(function(){
			$("#dialogcari_master_kelurahan_id").dialog({
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
			$('#dialogcari_master_kelurahan_id').load('c_master_kelurahan/masterkelurahanpopup?id_caller=form1_sys_setting_def_dw_edit', function() {
				$("#dialogcari_master_kelurahan_id").dialog("open");
			});
		});
})
</script>
<script>
	$('#backlist_sys_setting_def_dw').click(function(){
		$("#t56","#tabs").empty();
		$("#t56","#tabs").load('c_sys_setting_def_dw'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div id="dialog_cari_namapuskesmas" title="Master Puskesmas"></div>
<div id="dialogcari_master_propinsi_id" title="Master Provinsi"></div>
<div id="dialogcari_master_kabupaten_id" title="Master Kabupaten"></div>
<div id="dialogcari_master_kecamatan_id" title="Master Kecamatan"></div>
<div id="dialogcari_master_kelurahan_id" title="Master Kelurahan"></div>
<div class="formtitle">Edit Wilayah Kerja</div>
<div class="backbutton"><span class="kembali" id="backlist_sys_setting_def_dw">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1_sys_setting_def_dw_edit" method="post" action="<?=site_url('c_sys_setting_def_dw/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Provinsi</label>
		<input type="text" name="kodeprovinsi" id="master_propinsi_id_hidden" value="<?=$data->KD_PROVINSI?>"  />
		<input type="text" name="master_propinsi_id" id="master_propinsi_id" readonly value="<?=$data->namaprovinsi?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten/Kota</label>
		<input type="text" name="kodekabupaten" id="master_kabupaten_id_hidden" value="<?=$data->KD_KABUPATEN?>"  />
		<input type="text" name="master_kabupaten_id" id="master_kabupaten_id" readonly value="<?=$data->namakabupaten?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
		<input type="text" name="kodekecamatan" id="master_kecamatan_id_hidden" value="<?=$data->KD_KECAMATAN?>"  />
		<input type="text" name="master_kecamatan_id" id="master_kecamatan_id" readonly value="<?=$data->namakecamatan?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Puskesmas</label>
		<input type="text" name="kodepuskesmas" id="nama_puskesmas_hidden" readonly value="<?=$data->KD_PUSKESMAS?>"  />
		<input type="text" placeholder="Puskesmas" name="nama_puskesmas" id="nama_puskesmas" readonly value="<?=$data->namapuskesmas?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kelurahan/Desa</label>
		<input type="text" name="kodekelurahan" id="master_kelurahan_id_hidden" value="<?=$data->KD_KELURAHAN?>"  />
		<input type="text" name="master_kelurahan_id" id="master_kelurahan_id" readonly value="<?=$data->namakelurahan?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >