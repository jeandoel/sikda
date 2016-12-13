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
					$("#t461","#tabs").empty();
					$("#t461","#tabs").load('t_k_rumah_sehat'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$("#tanggalrumahsehat").mask("99/99/9999");
</script>
<script>
	$('#backlistrmhsehat').click(function(){
		$("#t461","#tabs").empty();
		$("#t461","#tabs").load('t_k_rumah_sehat'+'?_=' + (new Date()).getTime());
	})
	//$('#tglkejadianeditprop').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Data Inspeksi Rumah Sehat</div>
<div class="backbutton"><span class="kembali" id="backlistrmhsehat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1rmhsehatedit" method="post" action="<?=site_url('t_k_rumah_sehat/editprocess')?>" enctype="multipart/form-data">	
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
		<label>Nama KK*</label>
		<input type="text" name="nama_kk" value="<?=$data->NAMA_KK?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Jiwa*</label>
		<input type="text" name="jumlah_jiwa" value="<?=$data->JUMLAH_JIWA?>" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Pemeriksa*</label>
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
		<input type="text" name="tanggal_inspeksi"  value="<?=$data->TANGGAL?>" id="tanggalrumahsehat" class="mydate" required  />		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Dokumen Pemeriksaan*</label>
		<input type="file" name="filedok" /> File:
		<a href="<?=base_url()?>tmp/rumahsehat/<?=$data->DOKUMEN_PEMERIKSAAN?>" style="color:blue"><?=$data->DOKUMEN_PEMERIKSAAN?></a>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >