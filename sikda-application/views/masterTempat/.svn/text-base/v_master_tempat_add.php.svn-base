<script>
$(document).ready(function(){
		$('#formtempatmastertempatadd').ajaxForm({
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
					$("#t18","#tabs").empty();
					$("#t18","#tabs").load('c_master_tempat'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglmastertempat').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistmastertempat').click(function(){
		$("#t18","#tabs").empty();
		$("#t18","#tabs").load('c_master_tempat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Master Registrasi</div>
<div class="backbutton"><span class="kembali" id="backlistmastertempat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formtempatmastertempatadd" method="post" action="<?=site_url('c_master_tempat/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="text" name="kolom_kode_tempat" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama</label>
		<input type="text" name="kolom_nama_tempat" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis</label>
		<input type="text" name="kolom_jenis_tempat" id="text3" value=""  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>No. Telp</label>
		<input type="text" name="kolom_no_telp" id="text4" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pengelola</label>
		<input type="text" name="kolom_pengelola_tempat" id="text5" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ID Wilayah</label>
		<input type="text" name="kolom_id_wilayah" id="text6" value=""  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Master Registrasi</label>
		<input type="text" name="tglmastertempat" id="tglmastertempat" value="<?=date('Y-m-d')?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >