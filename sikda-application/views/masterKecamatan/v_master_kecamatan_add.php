<script>
$(document).ready(function(){
		$('#form1master_kecamatan_add').ajaxForm({
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
					$("#t40","#tabs").empty();
					$("#t40","#tabs").load('c_master_kecamatan'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#master_kabupaten_id_hidden').focus(function(){
			$("#dialogcari_master_kabupaten_id").dialog({
				autoOpen: false,
				modal:true,
				width: 500,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_master_kabupaten_id').load('c_master_kabupaten/masterkabupatenpopup?id_caller=form1master_kecamatan_add', function() {
				$("#dialogcari_master_kabupaten_id").dialog("open");
			});
		});
		
})
</script>
<script>
	$('#backlistmaster_kecamatan').click(function(){
		$("#t40","#tabs").empty();
		$("#t40","#tabs").load('c_master_kecamatan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Data Kecamatan</div>
<div id="dialogcari_master_kabupaten_id" title="Kabupaten"></div>
<div class="backbutton"><span class="kembali" id="backlistmaster_kecamatan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_kecamatan_add" method="post" action="<?=site_url('c_master_kecamatan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kecamatan</label>
		<input type="text" name="kodekecamatan" id="kodekecamatan" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kabupaten</label>
		<input type="text" name="kodekabupaten" id="master_kabupaten_id_hidden" value=""  />
		<input type="text" placeholder="Nama Kabupaten" name="master_kabupaten_id" id="master_kabupaten_id" readonly value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
		<input type="text" name="kecamatan" id="kecamatan" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >