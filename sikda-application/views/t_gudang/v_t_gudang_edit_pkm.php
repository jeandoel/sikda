<script>
$(document).ready(function(){
		$('#form1t_apotikeditpkm').ajaxForm({
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

$("#form1t_apotikeditpkm").validate({focusInvalid:true});

$('#form1t_apotikeditpkm :submit').click(function(e) {
	e.preventDefault();
		if($("#form1t_apotikeditpkm").valid()) {		
			$('#form1t_apotikeditpkm').submit();
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
<div class="formtitle">Ubah Stock Obat PKM</div>
<div class="backbutton"><span class="kembali" id="backlistt_apotikedit">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_apotikeditpkm" method="post" action="<?=site_url('t_gudang/editprocess_pkm')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Obat</label>
		<input type="text" name="nama_obat" readonly value="<?=$data[0]['NAMA_OBAT']?>" readonly />
		<input type="hidden" name="kd_obat" value="<?=$data[0]['KD_OBAT']?>" />
		<input type="hidden" name="kd_puskesmas" value="<?=$data[0]['KD_PKM']?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Stock APT</label>
		<input type="text" name="stock" id="gudangstockid" value="<?=isset($data[0]['JUMLAH_STOK_OBAT'])?$data[0]['JUMLAH_STOK_OBAT']:0?>" required />
		</span>
		<span>
		<label>Stock IF</label>
		<input type="text" name="stock1" id="gudangstockid1" value="<?=isset($data[1]['JUMLAH_STOK_OBAT'])?$data[1]['JUMLAH_STOK_OBAT']:0?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >