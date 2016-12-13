<script>
$(document).ready(function(){
		$('#form1masterKasusadd').ajaxForm({
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
					$("#t21","#tabs").empty();
					$("#t21","#tabs").load('c_master_kasus'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#master_jenis_kasus_id').focus(function(){
			$("#dialogcari_master_jenis_kasus_id").dialog({
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
			$('#dialogcari_master_jenis_kasus_id').load('c_master_jenis_kasus/masterjeniskasuspopup?id_caller=form1masterKasusadd', function() {
				$("#dialogcari_master_jenis_kasus_id").dialog("open");
			});
		});
		
})
</script>
<script>
	$('#backlistmasterKasus').click(function(){
		$("#t21","#tabs").empty();
		$("#t21","#tabs").load('c_master_kasus'+'?_=' + (new Date()).getTime());
	})
</script>
<div id="dialogcari_master_jenis_kasus_id" title="Jenis Kasus"></div>
<div class="mycontent">
<div class="formtitle">Tambah Kasus</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKasus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterKasusadd" method="post" action="<?=site_url('c_master_kasus/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Kasus</label>
		<input type="text" readonly name="kode_jenis_kasus" id="master_jenis_kasus_id" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel ID</label>
		<input type="text" name="variabel_idd" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Parent ID</label>
		<input type="text" name="parent_idd" id="text2" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel Name</label>
		<input type="text" name="variabel_name" id="text3" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel Definisi</label>
		<input type="text" name="variabel_defi" id="text4" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan</label>
		<input type="textarea" name="ket" id="text5" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pilihan Value</label>
		<input type="text" name="pilihan_value" id="text6" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>I Row</label>
		<input type="text" name="IRow" id="text7" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >