<script>
$(document).ready(function(){
		$('#formvaksinmastervaksinadd').ajaxForm({
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
					$("#t10","#tabs").empty();
					$("#t10","#tabs").load('c_master_vaksin'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglmastervaksin').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistmastervaksin').click(function(){
		$("#t10","#tabs").empty();
		$("#t10","#tabs").load('c_master_vaksin'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Master Vaksin</div>
<div class="backbutton"><span class="kembali" id="backlistmastervaksin">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formvaksinmastervaksinadd" method="post" action="<?=site_url('c_master_vaksin/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="text" name="kolom_kode" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama</label>
		<input type="text" name="kolom_nama" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Golongan</label>
		<input type="text" name="kolom_golongan" id="text3" value=""  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Sumber</label>
		<input type="text" name="kolom_sumber" id="text4" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Satuan</label>
		<input type="text" name="kolom_satuan" id="text5" value=""  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Master Vaksin</label>
		<input type="text" name="tglmastervaksin" id="tglmastervaksin" value="<?=date('Y-m-d')?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >