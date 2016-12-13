<script>
$(document).ready(function(){
		$('#form1masterKiaadd').ajaxForm({
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
					$("#t29","#tabs").empty();
					$("#t29","#tabs").load('c_master_kia'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
})
</script>
<script>
	$('#backlistmasterKia').click(function(){
		$("#t29","#tabs").empty();
		$("#t29","#tabs").load('c_master_kia'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Kia</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKia">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterKiaadd" method="post" action="<?=site_url('c_master_kia/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Format XML</label>
		<input type="text" name="format_xml" id="textid" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel ID</label>
		<input type="text" name="variabel_id" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Parent ID</label>
		<input type="text" name="parent_id" id="text2" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel Data</label>
		<input type="text" name="variabel_data" id="text3" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Definisi</label>
		<input type="text" name="definisi" id="text4" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pilihan Value</label>
		<input type="text" name="pilihan_value" id="text5" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>I Row</label>
		<input type="text" name="IRow" id="text6" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Status</label>
		<input type="text" name="status" id="text7" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pelayanan Ulang</label>
		<input type="text" name="pelayanan_ulang" id="text8" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >