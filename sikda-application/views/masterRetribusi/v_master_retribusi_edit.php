<script>
$(document).ready(function(){
		$('#form1retribusiedit').ajaxForm({
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
					$("#t900","#tabs").empty();
					$("#t900","#tabs").load('c_master_retribusi'+'?_=' + (new Date()).getTime());
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
			$('#dialogcari_master_kecamatan_id').load('c_master_kecamatan/masterkecamatanpopup?id_caller=form1retribusiedit', function() {
				$("#dialogcari_master_kecamatan_id").dialog("open");
			});
		});
})
</script>
<script>
	$('#backlistretribusi').click(function(){
		$("#t900","#tabs").empty();
		$("#t900","#tabs").load('c_master_retribusi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div id="dialogcari_master_kecamatan_id" title="Kecamatan"></div>
<div class="formtitle">Edit Retribusi</div>
<div class="backbutton"><span class="kembali" id="backlistretribusi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1retribusiedit" method="post" action="<?=site_url('c_master_retribusi/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kecamatan</label>
		<input type="text" name="kodekecamatan" id="master_kecamatan_id_hidden" value="<?=$data->KD_KECAMATAN?>" readonly  />
		<input type="text" name="master_kecamatan_id" id="master_kecamatan_id" value="<?=$data->nama_kecamatan?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Puskesmas</label>
		<input type="text" name="kodepuskesmas" id="kodepuskesmas" value="<?=$data->KD_PUSKESMAS?>"  />
		<input type="hidden" name="kd_retribusi" id="kdretribusi" value="<?=$data->KD_RETRIBUSI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Puskesmas</label>
		<input type="text" name="namapuskesmas" id="namapuskesmas" value="<?=$data->PUSKESMAS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<textarea name="alamat" rows="3" cols="45"><?=$data->ALAMAT?></textarea>
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Nilai Retribusi</label>
		<input type="text" name="nilairetribusi" id="nilairetribusi" value="<?=$data->NILAI_RETRIBUSI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >
