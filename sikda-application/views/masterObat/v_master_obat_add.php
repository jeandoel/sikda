<script>
$(document).ready(function(){
		$('#obatadd').ajaxForm({
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
					$("#t61","#tabs").empty();
					$("#t61","#tabs").load('c_master_obat'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#kd_gol_obat').focus(function(){
			$("#dialogcari_master_gol_obat_id").dialog({
				autoOpen: false,
				modal:true,
				width: 600,
				height: 425,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			
			$('#dialogcari_master_gol_obat_id').load('c_master_gol_obat/mastergolobatpopup?id_caller=obatadd', function() {
				$("#dialogcari_master_gol_obat_id").dialog("open");
			});
		});
		
			$('#master_satuan_kecil_hidden').focus(function(){
			$("#dialogcari_master_satuan_kecil_id").dialog({
				autoOpen: false,
				modal:true,
				width: 600,
				height: 425,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			
			$('#dialogcari_master_satuan_kecil_id').load('c_master_satuan_kecil/satuankecilpopup?id_caller=obatadd', function() {
				$("#dialogcari_master_satuan_kecil_id").dialog("open");
			});
		});
		
		$('#master_satuan_besar_id_hidden').focus(function(){
			$("#dialogcari_master_satuan_besar_id").dialog({
				autoOpen: false,
				modal:true,
				width: 600,
				height: 425,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			
			$('#dialogcari_master_satuan_besar_id').load('c_master_satuan_besar/mastersatuanbesarpopup?id_caller=obatadd', function() {
				$("#dialogcari_master_satuan_besar_id").dialog("open");
			});
		});
		
		$('#nama_terapi_hidden').focus(function(){
			$("#dialogtransaksi_cari_namaterapi").dialog({
				autoOpen: false,
				modal:true,
				width: 600,
				height: 425,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			
			$('#dialogtransaksi_cari_namaterapi').load('c_master_terapi_obat/masterterapipopup?id_caller=obatadd', function() {
				$("#dialogtransaksi_cari_namaterapi").dialog("open");
			});
		});
		
})
$('#tglobat').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistobat').click(function(){
		$("#t61","#tabs").empty();
		$("#t61","#tabs").load('c_master_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div id="dialogcari_master_gol_obat_id" title="Master Golongan Obat"></div>
<div id="dialogcari_master_satuan_kecil_id" title="Master Satuan Kecil"></div>
<div id="dialogcari_master_satuan_besar_id" title="Master Satuan Besar"></div>
<div id="dialogtransaksi_cari_namaterapi" title="Master Terapi Obat"></div>
<div class="mycontent">
<div class="formtitle">Tambah Obat</div>
<div class="backbutton"><span class="kembali" id="backlistobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="obatadd" method="post" action="<?=site_url('c_master_obat/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE OBAT</label>
		<input type="text" name="kode_obat_val" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA OBAT</label>
		<input type="text" name="nama_obat" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KD GOL OBAT</label>
		<input type="text" name="kd_gol_obat" id="kd_gol_obat" value=""  />
		<input type="text" placeholder="Golongan Obat" name="master_gol_obat_id" id="master_gol_obat_id" readonly value="" />
		</span>
	</fieldset>	
	<div id="imunisasiplaceholder"><!-- placeholder for loaded imunisasi --></div>
	<fieldset>
		<span>
		<label>KD SAT KECIL</label>
		<input type="text" name="kd_sat_kecil" id="master_satuan_kecil_hidden" value=""  />
		<input type="text" placeholder="Satuan kecil" name="master_satuan_kecil" id="master_satuan_kecil" readonly value="" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>KD SAT BESAR</label>
		<input type="text" name="kd_sat_besar" id="master_satuan_besar_id_hidden" value=""  />
		<input type="text" placeholder="Satuan besar" name="master_satuan_besar_id" id="master_satuan_besar_id" readonly value="" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>KD TERAPI OBAT</label>
		<input type="text" name="kd_ter_obat" id="nama_terapi_hidden" value=""  />
		<input type="text" placeholder="Terapi Obat" name="nama_terapi" id="nama_terapi" readonly value="" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>GENERIK</label>
		<input type="text" name="generik"  value=""  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>FRACTION</label>
		<input type="text" name="fraction"  value=""  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>SINGKATAN</label>
		<input type="text" name="singkatan"  value=""  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>IS DEFAULT</label>
		<input type="text" name="default"  value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >