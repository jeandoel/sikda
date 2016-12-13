<script>
jQuery().ready(function (){ 
		$('#form1transwilayahadd').ajaxForm({
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
					$("#t3","#tabs").empty();
					$("#t3","#tabs").load('c_transaksi_wilayah'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#cari_master_propinsi_id').click(function(){
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
			$('#dialogcari_master_propinsi_id').load('c_master_propinsi/transaksipropinsipopup?id_caller=form1transwilayahadd', function() {
				$("#dialogcari_master_propinsi_id").dialog("open");
			});
		});
		
		$('#cari_master_kabupaten_id').click(function(){
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
			$('#dialogcari_master_kabupaten_id').load('c_master_kabupaten/transaksikabupatenpopup?id_caller=form1transwilayahadd', function() {
				$("#dialogcari_master_kabupaten_id").dialog("open");
			});
		});
		
		$('#cari_master_kota_id').click(function(){
			$("#dialogcari_master_kota_id").dialog({
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
			$('#dialogcari_master_kota_id').load('c_master_kota/transaksikotapopup?id_caller=form1transwilayahadd', function() {
				$("#dialogcari_master_kota_id").dialog("open");
			});
		});
		
		$('#cari_master_kecamatan_id').click(function(){
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
			$('#dialogcari_master_kecamatan_id').load('c_master_kecamatan/transaksikecamatanpopup?id_caller=form1transwilayahadd', function() {
				$("#dialogcari_master_kecamatan_id").dialog("open");
			});
		});
		
		$('#cari_master_desa_id').click(function(){
			$("#dialogcari_master_desa_id").dialog({
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
			$('#dialogcari_master_desa_id').load('c_master_desa/transaksidesapopup?id_caller=form1transwilayahadd', function() {
				$("#dialogcari_master_desa_id").dialog("open");
			});
		});
		
})

$('#tgltransaksiwilayah').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlisttranswilayah').click(function(){
		$("#t3","#tabs").empty();
		$("#t3","#tabs").load('c_transaksi_wilayah'+'?_=' + (new Date()).getTime());
	})
</script>
<div id="dialogcari_master_propinsi_id" title="Propinsi"></div>
<div id="dialogcari_master_kabupaten_id" title="Kabupaten"></div>
<div id="dialogcari_master_kota_id" title="Kota"></div>
<div id="dialogcari_master_kecamatan_id" title="Kecamatan"></div>
<div id="dialogcari_master_desa_id" title="Desa"></div>
<div class="mycontent">
<div class="formtitle">Tambah Transaksi Wilayah</div>
<div class="backbutton"><span class="kembali" id="backlisttranswilayah">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1transwilayahadd" method="post" action="<?=site_url('c_transaksi_wilayah/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Transaksi</label>
		<input type="text" name="kode_transaksi" id="text1" autocomplete="off" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Propinsi</label>
		<input type="text" name="master_propinsi_id" id="master_propinsi_id" readonly value="" />
		<input type="hidden" name="master_propinsi_id_column" id="master_propinsi_id_hidden" value=""  />
		<input type="button" id="cari_master_propinsi_id" value="list" >
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Kabupaten</label>
		<input type="text" name="master_kabupaten_id" id="master_kabupaten_id" autocomplete="off" value=""  />
		<input type="hidden" name="master_kabupaten_id_column" id="master_kabupaten_id_hidden" value=""  />
		<input type="button" id="cari_master_kabupaten_id" value="list">
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Kota</label>
		<input type="text" name="master_kota_id" id="master_kota_id" autocomplete="off" value=""  />
		<input type="hidden" name="master_kota_id_column" id="master_kota_id_hidden" value=""  />
		<input type="button" id="cari_master_kota_id" value="list" >
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Nama Kecamatan</label>
		<input type="text" name="master_kecamatan_id" id="master_kecamatan_id" autocomplete="off" value=""  />
		<input type="hidden" name="master_kecamatan_id_column" id="master_kecamatan_id_hidden" value=""  />
		<input type="button" id="cari_master_kecamatan_id" value="list" >
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Nama Desa</label>
		<input type="text" name="master_desa_id" id="master_desa_id" autocomplete="off" value=""  />
		<input type="hidden" name="master_desa_id_column" id="master_desa_id_hidden" value=""  />
		<input type="button" id="cari_master_desa_id" value="list" >
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>No RT</label>
		<input type="text" name="noRT" id="text7" autocomplete="off" value=""  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>No RW</label>
		<input type="text" name="noRW" id="text8" autocomplete="off" value=""  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Transaksi</label>
		<input type="text" name="tgltransaksiwilayah" id="tgltransaksiwilayah" value="<?=date('d-m-Y')?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >