<script>
$(document).ready(function(){
		$('#formmastersaranaposyanduadd').ajaxForm({
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
<div class="formtitle">Tambah Master Sarana Posyandu</div>
<div class="backbutton"><span class="kembali" id="backlistmastersaranaposyandu">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formmastersaranaposyanduadd" method="post" action="<?=site_url('c_master_sarana_posyandu/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Sarana Posyandu</label>
		<input type="text" name="kodesarana" id="kodesarana" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Sarana Posyandu</label>
		<input type="text" name="saranaposyandu" id="saranaposyandu" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >