<script>
$(document).ready(function(){
		$('#form1sysSettingdefadd').ajaxForm({
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
					$("#t30","#tabs").empty();
					$("#t30","#tabs").load('c_sys_setting_def'+'?_=' + (new Date()).getTime());
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
			$('#dialogcari_master_propinsi_id').load('c_master_propinsi/masterpropinsipopup?id_caller=form1sysSettingdefadd', function() {
				$("#dialogcari_master_propinsi_id").dialog("open");
			});
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
			$('#dialogcari_master_kabupaten_id').load('c_master_kabupaten/masterkabupatenpopup?id_caller=form1sysSettingdefadd', function() {
				$("#dialogcari_master_kabupaten_id").dialog("open");
			});
		});
		
		$('#master_kecamatan_id_hidden').focus(function(){
			$("#dialogcari_master_kecamatan_id").dialog({
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
			$('#dialogcari_master_kecamatan_id').load('c_master_kecamatan/masterkecamatanpopup?id_caller=form1sysSettingdefadd', function() {
				$("#dialogcari_master_kecamatan_id").dialog("open");
			});
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
			$('#dialog_cari_namapuskesmas').load('c_master_puskesmas/puskesmaspopup?id_caller=form1sysSettingdefadd', function() {
				$("#dialog_cari_namapuskesmas").dialog("open");
			});
		});
		
		$('#master_dokter_id').focus(function(){
			$("#dialogcari_master_dokter_id").dialog({
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
			$('#dialogcari_master_dokter_id').load('c_master_dokter/masterdokterpopup?id_caller=form1sysSettingdefadd', function() {
				$("#dialogcari_master_dokter_id").dialog("open");
			});
		});
		
		$('#nama_ras').focus(function(){
			$("#dialogtransaksi_cari_namaras").dialog({
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
			$('#dialogtransaksi_cari_namaras').load('c_master_ras/masterraspopup?id_caller=form1sysSettingdefadd', function() {
				$("#dialogtransaksi_cari_namaras").dialog("open");
			});
		});
})
</script>
<script>
	$('#backlistsysSettingdef').click(function(){
		$("#t30","#tabs").empty();
		$("#t30","#tabs").load('c_sys_setting_def'+'?_=' + (new Date()).getTime());
	});
	$('#level_setting').on("change",function(){
		if($(this).val()==""){
			$('#nonkabupaten').hide();
			$('#kepalapuskesmas').hide();
		}else if($(this).val()=="KABUPATEN"){
			$('#nonkabupaten').hide();
		}else if($(this).val()=="PUSKESMAS"){
			$('#nonkabupaten').show();
			$('#kepalapuskesmas').show();
			$('#nama_nama').hide();
		}else if($(this).val()=="PUSTU"){
			$('#nonkabupaten').show();
			$('#kepalapuskesmas').hide();
			$('#nama_nama').show();
			$('#pustu').show();
			$('#pusling').hide();
			$('#bidan').hide();
			$('#polindes').hide();
		}else if($(this).val()=="PUSLIN"){
			$('#nonkabupaten').show();
			$('#kepalapuskesmas').hide();
			$('#nama_nama').show();
			$('#pusling').show();
			$('#pustu').hide();
			$('#bidan').hide();
			$('#polindes').hide();
		}else if($(this).val()=="BIDAN"){
			$('#nonkabupaten').show();
			$('#kepalapuskesmas').hide();
			$('#nama_nama').show();
			$('#bidan').show();
			$('#pusling').hide();
			$('#pustu').hide();
			$('#polindes').hide();
		}else{
			$('#nonkabupaten').show();
			$('#kepalapuskesmas').hide();
			$('#nama_nama').show();
			$('#polindes').show();
			$('#pusling').hide();
			$('#bidan').hide();
			$('#pustu').hide();
		}
	})
</script>
<div id="dialogcari_master_propinsi_id" title="Provinsi"></div>
<div id="dialogcari_master_kabupaten_id" title="Kabupaten"></div>
<div id="dialogcari_master_kecamatan_id" title="Kecamatan"></div>
<div id="dialog_cari_namapuskesmas" title="Puskesmas"></div>
<div id="dialogtransaksi_cari_namaras" title="Ras"></div>
<div id="dialogcari_master_dokter_id" title="Dokter"></div>
<div class="mycontent">
<div class="formtitle">Tambah Setting Profil Aplikasi</div>
<div class="backbutton"><span class="kembali" id="backlistsysSettingdef">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1sysSettingdefadd" method="post" action="<?=site_url('c_sys_setting_def/addprocess')?>" enctype="multipart/form-data">
	<?=getComboLevel1('','level','level_setting','required','')?>
	<fieldset>
		<span>
		<label>Kode Provinsi</label>
		<input type="text" name="kd_prov" readonly id="master_propinsi_id_hidden" value="" />
		<input type="text" placeholder="Provinsi" readonly name="provinsi" id="master_propinsi_id" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kabupaten/Kota</label>
		<input type="text" name="kd_kabkota" readonly id="master_kabupaten_id_hidden" value="" />
		<input type="text" placeholder="Kabupaten/Kota" readonly name="kabukota" id="master_kabupaten_id" value="" />
		</span>
	</fieldset>
	<div id="nonkabupaten">
	<fieldset>
		<span>
		<label>Kode Kecamatan</label>
		<input type="text" name="kd_kec" readonly id="master_kecamatan_id_hidden" value="" />
		<input type="text" placeholder="Kecamatan" readonly name="kecamatan" id="master_kecamatan_id" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Puskesmas</label>
		<input type="text" readonly name="kd_puskesmas"  id="nama_puskesmas_hidden" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Puskesmas</label>
		<input type="text" readonly name="nama_puskesmas"  id="nama_puskesmas" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<textarea readonly name="alamat"  id="nama_puskesmas_alamat" value="" style="width:195px;height:80px" />
		</span>
	</fieldset>
	<div id="nama_nama">
	<fieldset id="pustu" style="display:none">
		<span>
		<label>Nama Pustu</label>
		<input type="text" name="nama_pustu"  id="nama_pustu_id" value="" />
		</span>
	</fieldset>
	<fieldset id="polindes" style="display:none">
		<span>
		<label>Nama Polindes</label>
		<input type="text" name="nama_polindes"  id="nama_polindes_id" value="" />
		</span>
	</fieldset>
	<fieldset id="pusling" style="display:none">
		<span>
		<label>Nama Pusling</label>
		<input type="text" name="nama_pusling"  id="nama_pusling_id" value="" />
		</span>
	</fieldset>
	<fieldset id="bidan" style="display:none">
		<span>
		<label>Nama Bidan</label>
		<input type="text" name="nama_bidan"  id="nama_bidan_id" value="" />
		</span>
	</fieldset>
	</div>
	<div id="kepalapuskesmas">
	<fieldset>
		<span>
		<label>Nama Kepala Puskesmas</label>
		<input type="text" readonly name="nama_pimpinan" readonly id="master_dokter_id" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NIP</label>
		<input type="text" readonly name="nip" readonly id="master_dokter_id_nip" value="" />
		</span>
	</fieldset>
	</div>
	</div>
	<fieldset>
		<span>
		<label>Server Kementrian Kesehatan</label>
		<input type="text" name="server_kemkes" id="text13" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Server Dinas Kesehatan Provinsi</label>
		<input type="text" name="server_dinkes_prov" id="text14" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Server Dinas Kesehatan Kabupaten/Kota</label>
		<input type="text" name="server_dinkes_kabkota" id="text15" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >