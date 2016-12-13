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
					$("#t8","#tabs").empty();
					$("#t8","#tabs").load('c_master_posyandu'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistposyandu').click(function(){
		$("#t8","#tabs").empty();
		$("#t8","#tabs").load('c_master_posyandu'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianedit').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Posyandu</div>
<div class="backbutton"><span class="kembali" id="backlistposyandu">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1posyanduedit" method="post" action="<?=site_url('c_master_posyandu/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Posyandu</label>
		<input type="text" name="kodeposyandu" id="text1" value="<?=$data->nkode_posyandu?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_posyandu?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Posyandu</label>
		<input type="text" name="namaposyandu" id="text2" value="<?=$data->nnama_posyandu?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat Posyandu</label>
		<textarea name="alamatposyandu" rows="3" cols="45"><?=$data->nalamat_posyandu?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Kader</label>
		<input type="text" name="jumlahkader" id="text4" value="<?=$data->njumlah_kader?>"  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Posyandu</label>
		<input type="text" name="tglposyandu" id="tglkejadianedit" value="<?=$data->ntgl_posyandu?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >