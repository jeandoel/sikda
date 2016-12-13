<script>
$(document).ready(function(){
		$('#form1t_apotikedit').ajaxForm({
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
					$("#t304","#tabs").empty();
					$("#t304","#tabs").load('t_gudang');
				}
			}
		});
});

$("#form1t_apotikedit").validate({focusInvalid:true});

$('#form1t_apotikedit :submit').click(function(e) {
	e.preventDefault();
		if($("#form1t_apotikedit").valid()) {		
			$('#form1t_apotikedit').submit();
		}
	return false;
});	

$("#nama_pasien_id").focus();
</script>
<script>
	$('#backlistt_apotikedit').click(function(){
		$("#t304","#tabs").empty();
		$("#t304","#tabs").load('t_gudang');
	})
	//$('#tglt_apotikedit').datepicker({dateFormat: "yy-mm-dd",changeYear: true,yearRange: "-100:+0"});
	$('#gudangstockid').focus();
</script>
<div class="mycontent">
<div class="formtitle">Ubah Stock Obat</div>
<div class="backbutton"><span class="kembali" id="backlistt_apotikedit">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_apotikedit" method="post" action="<?=site_url('t_gudang/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Obat</label>
		<input type="text" name="nama_obat" readonly value="<?=$data->NAMA_OBAT?>" readonly />
		<input type="hidden" name="kd_obat" value="<?=$data->KD_OBAT?>" />
		<input type="hidden" name="kd_puskesmas" value="<?=$data->KD_PKM?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Stock</label>
		<input type="text" name="stock" id="gudangstockid" value="<?=$data->JUMLAH_STOK_OBAT?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >