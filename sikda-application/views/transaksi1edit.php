<script>
$(document).ready(function(){
		$('#form1transaksi1edit').ajaxForm({
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
					$("#t2","#tabs").empty();
					$("#t2","#tabs").load('transaksi1'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#form1transaksi1edit  #cari_column_master_1').click(function(){
			$("#dialogtransaksi1_cari_column").dialog({
				autoOpen: false,
				modal:true,
				width: 600,
				height: 355,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			
			$('#dialogtransaksi1_cari_column').load('master1/master1popup?id_caller=form1transaksi1edit', function() {
				$("#dialogtransaksi1_cari_column").dialog("open");
			});
		});
		
})
</script>
<script>
	$('#backlisttransaksi1').click(function(){
		$("#t2","#tabs").empty();
		$("#t2","#tabs").load('transaksi1'+'?_=' + (new Date()).getTime());
	})
	$('#tgltransaksi1').datepicker({dateFormat: "yy-mm-dd",changeYear: true,yearRange: "-100:+0"});
</script>
<div class="mycontent">
<div id="dialogtransaksi1_cari_column" title="Master Satu"></div>
<div class="formtitle">Edit Transaksi 1</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksi1">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1transaksi1edit" method="post" action="<?=site_url('transaksi1/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Column Satu</label>
		<input type="text" name="column1" id="text1" value="<?=$data->ncolumn1?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_transaksi1?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Dua</label>
		<input type="text" name="column2" id="text2" value="<?=$data->ncolumn2?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Tiga</label>
		<textarea name="column3" rows="3" cols="45"><?=$data->ncolumn3?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Master 1</label>
		<input type="text" name="column_master_1" id="column_master_1" value="<?=$data->nmastercolumn1?>" readonly  />
		<input type="hidden" name="column_master_1_id" id="column_master_1_hidden" value="<?=$data->nmaster_1_id?>"  />
		<input type="button" id="cari_column_master_1" value="..." >
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Transaksi Satu</label>
		<input type="text" name="tgltransaksi1" id="tgltransaksi1" value="<?=$data->ntgl_transaksi1?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >