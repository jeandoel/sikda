<script>
$(document).ready(function(){
		$('#formkelurahanmasterkelurahanadd').ajaxForm({
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
					$("#t19","#tabs").empty();
					$("#t19","#tabs").load('c_master_kelurahan'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#master_kecamatan_id_hidden').focus(function(){
			$("#dialogcari_master_kecamatan_id").dialog({
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
			$('#dialogcari_master_kecamatan_id').load('c_master_kecamatan/masterkecamatanpopup?id_caller=formkelurahanmasterkelurahanadd', function() {
				$("#dialogcari_master_kecamatan_id").dialog("open");
			});
		});
})

</script>
<script>
	$('#backlistmasterkelurahan').click(function(){
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('c_master_kelurahan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div id="dialogcari_master_kecamatan_id" title="Kecamatan"></div>
<div class="formtitle">Tambah Data Kelurahan</div>
<div class="backbutton"><span class="kembali" id="backlistmasterkelurahan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formkelurahanmasterkelurahanadd" method="post" action="<?=site_url('c_master_kelurahan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kelurahan</label>
		<input type="text" name="kode_kelurahan" id="kode_kelurahan" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kecamatan</label>
		<input type="text" name="kode_kecamatan" id="master_kecamatan_id_hidden" value="" readonly  />
		<input type="text" placeholder="Kecamatan" name="master_kecamatan_id" id="master_kecamatan_id" readonly value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kelurahan</label>
		<input type="text" name="kelurahan" id="kelurahan" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >