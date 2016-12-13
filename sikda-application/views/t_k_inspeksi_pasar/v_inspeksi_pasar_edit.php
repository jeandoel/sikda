<script>
$(document).ready(function(){
		$('#form1rmhsehatedit').ajaxForm({
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
					$("#t463","#tabs").empty();
					$("#t463","#tabs").load('t_k_inspeksi_pasar'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$("#tanggalinspeksipasar").mask("99/99/9999");
</script>
<script>
	$('#backlistrmhsehat').click(function(){
		$("#t463","#tabs").empty();
		$("#t463","#tabs").load('t_k_inspeksi_pasar'+'?_=' + (new Date()).getTime());
	})
	//$('#tglkejadianeditprop').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Data Inspeksi Pasar</div>
<div class="backbutton"><span class="kembali" id="backlistrmhsehat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1rmhsehatedit" method="post" action="<?=site_url('t_k_inspeksi_pasar/editprocess')?>" enctype="multipart/form-data">	
	<fieldset>
		<span>
		<label>Propinsi</label>
		<input type="text"  name="" id="textid" value="<?=$data->PROVINSI?>" disabled />
		<input type="hidden" name="ID" value="<?=$data->ID?>" />
		<input type="hidden" name="fileold" value="<?=$data->DOKUMEN_PEMERIKSAAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten</label>
		<input type="text"  name="" id="textid" value="<?=$data->KABUPATEN?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
		<input type="text"  name="" id="textid" value="<?=$data->KECAMATAN?>" disabled />
		</span>
	</fieldset>
	<?=getComboKelurahanByKec($data->KD_KELURAHAN,'desa_kelurahan','','required','')?>
	<fieldset>
		<span>
		<label>Nama Pasar*</label>
		<input type="text" name="nama_pasar" value="<?=$data->NAMA_PASAR?>"  required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat*</label>
		<input type="text" name="alamat" value="<?=$data->ALAMAT?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Penanggung Jawab</label>
		<input type="text" name="pic" value="<?=$data->PIC?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Kios*</label>
		<input type="text" name="jumlah_kios" value="<?=$data->JUMLAH_KIOS?>" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Jumlah Pedagang*</label>
		<input type="text" name="jumlah_pedagang" value="<?=$data->JUMLAH_PEDAGANG?>" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Jumlah Asosiasi*</label>
		<input type="text" name="jumlah_asosiasi" value="<?=$data->JUMLAH_ASOSIASI?>" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Team Pemeriksa*</label>
		<input type="text" name="pemeriksa" value="<?=$data->PEMERIKSA?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Total Nilai Pemeriksaan*</label>
		<input type="text" name="total_nilai" value="<?=$data->TOTAL_NILAI?>" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Inspeksi* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_inspeksi"  value="<?=$data->TANGGAL?>" id="tanggalinspeksipasar" class="mydate" required  />		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Dokumen Pemeriksaan*</label>
		<input type="file" name="filedok" /> File:
		<a href="<?=base_url()?>tmp/inspeksipasar/<?=$data->DOKUMEN_PEMERIKSAAN?>" style="color:blue"><?=$data->DOKUMEN_PEMERIKSAAN?></a>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >