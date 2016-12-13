<script>
$(document).ready(function(){
		$('#form1posyanduedit').ajaxForm({
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
					$("#t472","#tabs").empty();
					$("#t472","#tabs").load('t_posyandu'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistposyandu').click(function(){
		$("#t472","#tabs").empty();
		$("#t472","#tabs").load('t_posyandu'+'?_=' + (new Date()).getTime());
	})
	//$('#tglkejadianeditprop').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Data Posyandu</div>
<div class="backbutton"><span class="kembali" id="backlistposyandu">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1posyanduedit" method="post" action="<?=site_url('t_posyandu/editprocess')?>" enctype="multipart/form-data">	
	<fieldset>
		<span>
		<label>Propinsi</label>
		<input type="text"  name="" id="textid" value="<?=$data->PROVINSI?>" disabled />
		<input type="hidden" name="ID" value="<?=$data->ID?>" />
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
		<label>Nama Posyandu*</label>
		<input type="text" name="nama_posyandu" value="<?=$data->NAMA_POSYANDU?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RW</label>
		<input type="text" name="rw" value="<?=$data->RW?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RT</label>
		<input type="text" name="rt" value="<?=$data->RT?>" />
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
		<label>Jumlah Kader*</label>
		<input type="text" name="jumlah_kader" value="<?=$data->JUMLAH_KADER?>" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Jenis Posyandu*</label>
		<select name="jenis_posyandu" required>
			<option value="">Pilih Jenis Posyandu</option>
			<option value="PRATAMA" <?=$data->JENIS_POSYANDU=='PRATAMA'?'selected':''?> >PRATAMA</option>
			<option value="MADYA" <?=$data->JENIS_POSYANDU=='MADYA'?'selected':''?> >MADYA</option>
			<option value="PURNAMA" <?=$data->JENIS_POSYANDU=='PURNAMA'?'selected':''?> >PURNAMA</option>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >