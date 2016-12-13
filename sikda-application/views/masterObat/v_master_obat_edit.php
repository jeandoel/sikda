<script>
$(document).ready(function(){
		$('#obatedit').ajaxForm({
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
			
			$('#dialogcari_master_gol_obat_id').load('c_master_gol_obat/mastergolobatpopup?id_caller=obatedit', function() {
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
			
			$('#dialogcari_master_satuan_kecil_id').load('c_master_satuan_kecil/satuankecilpopup?id_caller=obatedit', function() {
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
			
			$('#dialogcari_master_satuan_besar_id').load('c_master_satuan_besar/mastersatuanbesarpopup?id_caller=obatedit', function() {
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
			
			$('#dialogtransaksi_cari_namaterapi').load('c_master_terapi_obat/masterterapipopup?id_caller=obatedit', function() {
				$("#dialogtransaksi_cari_namaterapi").dialog("open");
			});
		});
})
</script>
<script>
	$('#backlistobat').click(function(){
		$("#t61","#tabs").empty();
		$("#t61","#tabs").load('c_master_obat'+'?_=' + (new Date()).getTime());
	})
	$('#tglobat').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div id="dialogcari_master_gol_obat_id" title="Master Satu"></div>
<div id="dialogcari_master_satuan_kecil_id" title="Master Dua"></div>
<div id="dialogcari_master_satuan_besar_id" title="Master Tiga"></div>
<div id="dialogtransaksi_cari_namaterapi" title="Master Empat"></div>

<div class="mycontent">
<div class="formtitle">Edit Obat</div>
<div class="backbutton"><span class="kembali" id="backlistobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="obatedit" method="post" action="<?=site_url('c_master_obat/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE OBAT</label>
		<input type="text" name="kode_obat_val" id="text1" value="<?=$data->KD_OBAT_VAL?>" />
		<input type="hidden" name="kd_obat" id="textid" value="<?=$data->KD_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA OBAT</label>
		<input type="text" name="nama_obat" id="text2" value="<?=$data->NAMA_OBAT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KD GOL OBAT</label>
		<input type="text" name="kd_gol_obat" id="kd_gol_obat" value="<?=$data->KD_GOL_OBAT?>" readonly  />
		<input type="text" name="master_gol_obat_id" id="master_gol_obat_id" value="<?=$data->kodegolongan?>" />
		</span>
	</fieldset>	
	<div id="imunisasiplaceholder" style="<?=$data->KD_GOL_OBAT=='VAKSIN'?'':'display:none'?>" ><?=getComboJenisimunisasi($data->KD_JENIS_IMUNISASI,'jenis_imunisasi','imunisasi_add','')?><!-- placeholder for loaded imunisasi --></div>
	<fieldset>
		<span>
		<label>KD SAT KECIL</label>
		<input type="text" name="kd_sat_kecil" id="master_satuan_kecil_hidden" value="<?=$data->KD_SAT_KECIL?>" readonly  />
		<input type="text" name="master_satuan_kecil" id="master_satuan_kecil" value="<?=$data->kodesatkcl?>" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>KD SAT BESAR</label>
		<input type="text" name="kd_sat_besar" id="master_satuan_besar_id_hidden" value="<?=$data->KD_SAT_BESAR?>" readonly  />
		<input type="text" name="master_satuan_kecil" id="master_satuan_kecil" value="<?=$data->kodesatbesar?>" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>KD TERAPI OBAT</label>
		<input type="text" name="kd_ter_obat" id="nama_terapi_hidden" value="<?=$data->KD_TERAPI_OBAT?>" readonly  />
		<input type="text" name="nama_terapi" id="nama_terapi" value="<?=$data->kodeterapi?>" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>GENERIK</label>
		<input type="text" name="generik" value="<?=$data->GENERIK?>" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>FRACTION</label>
		<input type="text" name="fraction" value="<?=$data->FRACTION?>" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>SINGKATAN</label>
		<input type="text" name="singkatan" value="<?=$data->SINGKATAN?>" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>IS DEFAULT</label>
		<input type="text" name="default" value="<?=$data->IS_DEFAULT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >