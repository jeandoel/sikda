<script>
$(document).ready(function(){
		$('#form1t_pendaftaranpelayanan').ajaxForm({
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
					$.achtung({message: 'Proses Berhasil', timeout:5});
					$("#t202","#tabs").empty();
					$("#t202","#tabs").load('t_pendaftaran'+'?_=' + (new Date()).getTime());
				}
			}
		});
});

$('#form1t_pendaftaranpelayanan #showhide_pasienbaru_kunjungan').on('change', function() {
		if($(this).val()=='rawat_jalan'){
			$('#form1t_pendaftaranpelayanan #jeniskunjunganplaceholder').empty();
			$('#form1t_pendaftaranpelayanan #jeniskunjunganplaceholder').load('t_pendaftaran/rawatjalan?_=' + (new Date()).getTime());
		}else if($(this).val()=='UGD'){
			$('#form1t_pendaftaranpelayanan #jeniskunjunganplaceholder').empty();
			$('#form1t_pendaftaranpelayanan #jeniskunjunganplaceholder').load('t_pendaftaran/ugd?_=' + (new Date()).getTime());
		}else if($(this).val()=='rawat_inap'){
			$('#form1t_pendaftaranpelayanan #jeniskunjunganplaceholder').empty();
			$('#form1t_pendaftaranpelayanan #jeniskunjunganplaceholder').load('t_pendaftaran/rawatinap?_=' + (new Date()).getTime());
		}else{
			$('#form1t_pendaftaranpelayanan #jeniskunjunganplaceholder').empty();
		}
	});

$("#form1t_pendaftaranpelayanan").validate({focusInvalid:true});

$('#form1t_pendaftaranpelayanan :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_pendaftaranpelayanan").valid()) {
		$('#form1t_pendaftaranpelayanan').submit();
	}
	return false;
});	

$("#showhide_pasienbaru_kunjungan").focus();

</script>
<script>
	$("#form1t_pendaftaranpelayanan input[name = 'batal'], #backlistt_pendaftaran").click(function(){
		$("#t202","#tabs").empty();
		$("#t202","#tabs").load('t_pendaftaran'+'?_=' + (new Date()).getTime());
	});
	$('#tglt_pendaftaran').datepicker({dateFormat: "yy-mm-dd",changeYear: true,yearRange: "-100:+0"});
</script>
<div class="mycontent">
<div class="formtitle">Pendaftaran Kunjungan</div>
<div class="backbutton"><span class="kembali" id="backlistt_pendaftaran">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pendaftaranpelayanan" method="post" action="<?=site_url('t_pendaftaran/daftarkunjunganprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis#</label>
		<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textidpus" value="<?=$data->KD_PUSKESMAS?>" />
		</span>
		<span>
		<label>NIK</label>
		<input type="text" name="text" value="<?=$data->NIK?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="text" value="<?=$data->NAMA_PASIEN?>" disabled />
		</span>
		<span>
		<label>Golongan Darah</label>
		<input type="text" name="text" value="<?=$data->KD_GOL_DARAH?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<?=getComboJenispasien('','jenis_pasien','jenis_pasient_pendaftaranadd','required','inline')?>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="text" value="<?=$data->TGL_LAHIR?>" disabled />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Daftarkan Ke Kunjungan</div>	
	<fieldset>
		<span>
		<label>Jenis Kunjungan</label>
			<select name="showhide_kunjungan" id="showhide_pasienbaru_kunjungan">
				<option value="">Pilih Jenis Kunjungan</option>
				<option value="rawat_jalan">Rawat Jalan</option>
				<!--<option value="UGD">Unit Gawat Darurat</option>-->
				<option value="rawat_inap">Rawat Inap</option>
			</select>
		</span>
	</fieldset>
	<div id="jeniskunjunganplaceholder"><!-- placeholder for loaded jenis kunjungan --></div>
	<br/>
	<br/>
	<fieldset>
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >