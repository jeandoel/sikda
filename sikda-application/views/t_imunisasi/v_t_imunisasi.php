<style>
.ui-menu-item{
	font-size:.59em;
	color:blue!important;
}
.ui-autocomplete-category {
	font-weight: bold;
	padding: .1em .1.5em;
	margin: .8em 0 .2em;
	line-height: 1.5;
	font-size:.71em;
}
.ui-autocomplete{
	width:355px!important;
}
.inputaction1{
	width:255px;font-weight:bold;
}
.inputaction2{
	width:255px;font-weight:bold;color:#0B77B7
}
.labelaction{
	font-weight:bold;font-size:1.05em;color:#0B77B7;width:175px;
}
.declabel{width:91px}
.declabel2{width:175px}
.decinput{width:99px}
</style>
<script>
$(document).ready(function(){
		$('#form1t_imunisasi_add').ajaxForm({
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
					$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
					$("#t215","#tabs").empty();
					$("#t215","#tabs").load('t_imunisasi'+'?_=' + (new Date()).getTime());
				}
			}
		});	
});



</script>
<script>
	$("#form1t_imunisasi_add input[name = 'batal'], #backlistt_imunisasi").click(function(){
		$("#t215","#tabs").empty();
		$("#t215","#tabs").load('t_imunisasi'+'?_=' + (new Date()).getTime());
	});
	  
	  	$('#showhide_kategori_imunisasi').on('change', function() {
			if($(this).val()=='imunisasi'){
				$('#kategori_imunisasi_pasien_holder').empty();
				$('#kategori_imunisasi_pasien_holder').load('t_imunisasi/load_view_imunisasi?_=' + (new Date()).getTime());
			}else if($(this).val()=='kipi'){
				$('#kategori_imunisasi_pasien_holder').empty();
				$('#kategori_imunisasi_pasien_holder').load('t_imunisasi/load_view_kipi?_=' + (new Date()).getTime());
			}else{
				$('#kategori_imunisasi_pasien_holder').empty();
			}
		});
</script>
<div class="mycontent">

</br>
<div class="formtitle">Tambah Daftar Imunisasi Luar Gedung</div>
<div class="backbutton"><span class="kembali" id="backlistt_imunisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_imunisasi_add" method="post" action="<?=site_url('t_imunisasi/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" name="tanggal_imunisasi" id="tanggal_imunisasi" class="mydate" value="<?=date('d/m/Y')?>" />
		</span>
	</fieldset>
	<?=getComboJenislokasi('','jenis_lokasi','jenis_lokasit_imunisasiadd','required','')?>	
	<fieldset>
		<span>
		<label>Nama Lokasi</label>
		<input type="text" name="namalokasi" id="namalokasi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<textarea name="alamatlokasi" rows="3" cols="23" value="" ></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<input type="text" name="kecamatan" id="kelurahant_imunisasi" value="" />
		</span>
	</fieldset>
	<fieldset>	
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desa_kelurahan" id="kelurahant_imunisasi">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>

	<br/>
	<div id="kategori_imunisasi_pasien_holder"></div>
	
	<fieldset>
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >