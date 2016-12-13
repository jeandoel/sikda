<script>
$(document).ready(function(){
		$('#form1retribusiadd').ajaxForm({
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
			$('#dialogcari_master_kecamatan_id').load('c_master_kecamatan/masterkecamatanpopup?id_caller=form1retribusiadd', function() {
				$("#dialogcari_master_kecamatan_id").dialog("open");
			});
		});
		$('#nama_puskesmas_hidden').focus(function(){
			$("#dialog_cari_namapuskesmas").dialog({
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
			$('#dialog_cari_namapuskesmas').load('c_master_puskesmas/puskesmaspopup?id_caller=form1retribusiadd', function() {
				$("#dialog_cari_namapuskesmas").dialog("open");
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
<div id="dialog_cari_namapuskesmas" title="Puskesmas"></div>
<div class="formtitle">Tambah Retribusi</div>
<div class="backbutton"><span class="kembali" id="backlistretribusi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1retribusiadd" method="post" action="<?=site_url('c_master_retribusi/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kecamatan</label>
		<input type="text" name="kodekecamatan" id="master_kecamatan_id_hidden" value="" readonly  />
		<input type="text" placeholder="Kecamatan" name="master_kecamatan_id" id="master_kecamatan_id" readonly value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Puskesmas</label>
		<input type="text" name="kodepuskesmas" id="nama_puskesmas_hidden" value="" readonly/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Puskesmas</label>
		<input type="text" name="namapuskesmas" id="nama_puskesmas" value=""  readonly/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<textarea name="alamat" id='nama_puskesmas_alamat' rows="3" cols="45"></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nilai Retribusi</label>
		<input type="text" name="nilairetribusi" id="nilairetribusi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >
