<script>
jQuery().ready(function (){ 
		$('#form1_sys_setting_def_dw_add').ajaxForm({
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
			$('#dialog_cari_namapuskesmas').load('c_master_puskesmas/puskesmaspopup?id_caller=form1_sys_setting_def_dw_add', function() {
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
			$('#dialogcari_master_propinsi_id').load('c_master_propinsi/masterpropinsipopup?id_caller=form1_sys_setting_def_dw_add', function() {
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
			$('#dialogcari_master_kabupaten_id').load('c_master_kabupaten/masterkabupatenpopup?id_caller=form1_sys_setting_def_dw_add', function() {
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
			$('#dialogcari_master_kecamatan_id').load('c_master_kecamatan/masterkecamatanpopup?id_caller=form1_sys_setting_def_dw_add', function() {
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
			$('#dialogcari_master_kelurahan_id').load('c_master_kelurahan/masterkelurahanpopup?id_caller=form1_sys_setting_def_dw_add', function() {
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
<div id="dialog_cari_namapuskesmas" title="Master Puskesmas"></div>
<div id="dialogcari_master_propinsi_id" title="Master Provinsi"></div>
<div id="dialogcari_master_kabupaten_id" title="Master Kabupaten"></div>
<div id="dialogcari_master_kecamatan_id" title="Master Kecamatan"></div>
<div id="dialogcari_master_kelurahan_id" title="Master Kelurahan"></div>
<div class="mycontent">
<div class="formtitle">Tambah Wilayah Kerja</div>
<div class="backbutton"><span class="kembali" id="backlist_sys_setting_def_dw">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1_sys_setting_def_dw_add" method="post" action="<?=site_url('c_sys_setting_def_dw/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Provinsi</label>
		<input type="text" name="kodeprovinsi" id="master_propinsi_id_hidden" value="" readonly  />
		<input type="text" placeholder="Provinsi" name="master_propinsi_id" id="master_propinsi_id" readonly value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten/Kota</label>
		<input type="text" name="kodekabupaten" id="master_kabupaten_id_hidden" value="" readonly  />
		<input type="text" placeholder="Kabupaten" name="master_kabupaten_id" id="master_kabupaten_id" readonly value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
		<input type="text" name="kodekecamatan" id="master_kecamatan_id_hidden" value="" readonly  />
		<input type="text" placeholder="Kecamatan" name="master_kecamatan_id" id="master_kecamatan_id" readonly value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Puskesmas</label>
		<input type="text" name="kodepuskesmas" id="nama_puskesmas_hidden" value="" readonly  />
		<input type="text" placeholder="Puskesmas" name="nama_puskesmas" id="nama_puskesmas" readonly value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kelurahan/Desa</label>
		<input type="text" name="kodekelurahan" id="master_kelurahan_id_hidden" value="" readonly  />
		<input type="text" placeholder="Kelurahan/Desa" name="lurah" id="master_kelurahan_id" readonly value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >