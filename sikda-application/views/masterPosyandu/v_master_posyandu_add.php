<script>
$(document).ready(function(){
		$('#form1posyanduadd').ajaxForm({
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
					$("#t8","#tabs").empty();
					$("#t8","#tabs").load('c_master_posyandu'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglposyandu').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistposyandu').click(function(){
		$("#t8","#tabs").empty();
		$("#t8","#tabs").load('c_master_posyandu'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Posyandu</div>
<div class="backbutton"><span class="kembali" id="backlistposyandu">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1posyanduadd" method="post" action="<?=site_url('c_master_posyandu/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Posyandu</label>
		<input type="text" name="kodeposyandu" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Posyandu</label>
		<input type="text" name="namaposyandu" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat Posyandu</label>
		<textarea name="alamatposyandu" rows="3" cols="45"></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Kader</label>
		<input type="text" name="jumlahkader" id="text4" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Posyandu</label>
		<input type="text" name="tglposyandu" id="tglposyandu" value="<?=date('Y-m-d')?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >