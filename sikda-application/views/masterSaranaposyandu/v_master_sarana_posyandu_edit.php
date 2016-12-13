<script>
$(document).ready(function(){
		$('#formsaranaposyanduedit').ajaxForm({
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
					$("#t15","#tabs").empty();
					$("#t15","#tabs").load('c_master_sarana_posyandu'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastersaranaposyandu').click(function(){
		$("#t15","#tabs").empty();
		$("#t15","#tabs").load('c_master_sarana_posyandu'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Edit Sarana Posyandu</div>
<div class="backbutton"><span class="kembali" id="backlistmastersaranaposyandu">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formsaranaposyanduedit" method="post" action="<?=site_url('c_master_sarana_posyandu/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Sarana Posyandu</label>
		<input type="text" name="kodesarana" id="kodesarana" value="<?=$data->KD_SARANA_POSYANDU?>" />
		<input type="hidden" name="id" id="kodesarana" value="<?=$data->KD_SARANA_POSYANDU?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Sarana Posyandu</label>
		<input type="text" name="saranaposyandu" id="saranaposyandu" value="<?=$data->NAMA_SARANA_POSYANDU?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >