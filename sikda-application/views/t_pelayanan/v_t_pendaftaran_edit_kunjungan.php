


<script>
$(document).ready(function(){
		$('#form1t_pendaftaranedit').ajaxForm({
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
					$("#t202","#tabs").empty();
					$("#t202","#tabs").load('t_pendaftaran');
				}
			}
		});
});

$("#form1t_pendaftaranedit").validate({focusInvalid:true});

$('#form1t_pendaftaranedit :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_pendaftaranedit").valid()) {
		$('#form1t_pendaftaranedit').submit();
	}
	return false;
});	

$("#nama_pasien_id").focus();
</script>
<script>
	$('#backlistt_pendaftaran').click(function(){
		$("#t202","#tabs").empty();
		$("#t202","#tabs").load('t_pendaftaran');
	})
	//$('#tglt_pendaftaran').datepicker({dateFormat: "yy-mm-dd",changeYear: true,yearRange: "-100:+0"});
</script>
<div class="mycontent">
<div class="formtitle">Ubah Data Pelayanan Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistt_pendaftaran">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pendaftaranedit" method="post" action="<?=site_url('t_pendaftaran/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="nama_pasien" id="nama_pasien_id" value="<?=$data->NAMA_PASIEN?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_KUNJUNGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Unit Layanan</label>
		<input type="text" name="column2" id="text2" value="<?=$data->KD_UNIT_LAYANAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Poliklinik</label>
		<input type="text" name="column2" id="text2" value="<?=$data->KD_UNIT?>"  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Nama Petugas</label>
		<input type="text" name="tglt_pendaftaran" id="tglt_pendaftaran" value="<?=$data->KD_DOKTER?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >