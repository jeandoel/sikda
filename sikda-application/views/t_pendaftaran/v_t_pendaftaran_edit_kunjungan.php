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

var parts = $("#textid").val().split("-");

if (parts[3] == "219") 
{
	$("#edit_kategori_kia").css('display','');
}
else
{
	$("#edit_kategori_kia").css('display','none');
}

$('#poliklinikt_pendaftaranubah').on('change', function() {
		if($(this).val()==219){
			$('#edit_kategori_kia').show();
		}else{
			$('#edit_kategori_kia').hide();
		}
});

$("#form1t_pendaftaranedit").validate({focusInvalid:true});

$('#form1t_pendaftaranedit :submit').click(function(e) {
	e.preventDefault();
	if($(this).val() !== "Proses Data"){
		$("#form1t_pendaftaranedit").attr("action", "<?=site_url('t_pendaftaran/batalkunjunganprocess')?>");
		$('#form1t_pendaftaranedit').submit();
	}else{
		if($("#form1t_pendaftaranedit").valid()) {		
			$('#form1t_pendaftaranedit').submit();
		}
	}
	return false;
});	

$("#nama_pasien_id").focus();
</script>
<script>
	$('#backlistt_pendaftaran').click(function(){
		$("#t202","#tabs").empty();
		$("#t202","#tabs").load('t_pendaftaran');
	});
</script>
<div class="mycontent">
<div class="formtitle">Ubah Data Pelayanan Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistt_pendaftaran">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pendaftaranedit" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_pendaftaran/ubahkunjunganprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="nama_pasien" id="nama_pasien_id" readonly value="<?=$data->NAMA_PASIEN?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_KUNJUNGAN?>" />
		<input type="hidden" name="kd_puskesmas" id="textidpus" value="<?=$data->KD_PUSKESMAS?>" />
		</span>
	</fieldset>
	<?=getComboUnitlayanan($data->KD_UNIT_LAYANAN,'unit_layanan','unit_layanant_pendaftaranubah','required','')?>	
	<?=getComboPoliklinik($data->KD_UNIT,'poliklinik','poliklinikt_pendaftaranubah','required','')?>	
	<fieldset>
		<span>
		<label>Nama Petugas</label>
		<input type="text" name="petugas" id="petugast_pendaftaran" value="<?=$data->KD_DOKTER?>" />
		</span>
	</fieldset>
	<fieldset id="edit_kategori_kia">		
		<?=getComboKategoriKIA('','kategori_kia','id_kategori_kia','','inline')?>
		<br/>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		<input type="submit" name="bt2" value="Batalkan Kunjungan"/>
		</span>
	</fieldset>
</form>
</div >