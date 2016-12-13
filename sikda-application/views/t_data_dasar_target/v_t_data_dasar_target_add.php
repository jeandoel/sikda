<script>
$(document).ready(function(){
		$('#formt_data_dasar_target_add').ajaxForm({
			beforeSend: function() {
			achtungShowLoader();	
		},
		uploadProgress: function(event, position, total, percentComplete) {
		},
		complete: function(xhr) {
			if(xhr.responseText!=='OK'){
				$.achtung({message: xhr.responseText, timeout:5});
			}else{
				$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
				$("#t442","#tabs").empty();
				$("#t442","#tabs").load('t_data_dasar_target'+'?_=' + (new Date()).getTime());
			}
			achtungHideLoader();	
		}
		});

		/*$("#formt_data_dasar_target_add").validate({
		rules: {
			tahun: {
				required: true
			},jmlbayi: {
				required: true
			},jmlbalita: {
				required: true
			},jmlanak: {
				required: true
			},jmlcaten: {
				required: true
			},jmlwushamil: {
				required: true
			},jmlwustdkhamil: {
				required: true
			},jmlsd: {
				required: true
			},jmlposyandu: {
				required: true
			},jmlupsbds: {
				required: true
			},jmlpembinawil: {
				required: true
			},waktutempuh: {
				required: true
			}
		},
		messages: {
			tahun: {
				required:"Silahkan Lengkapi Data"
			},jmlbayi: {
				required:"Silahkan Lengkapi Data"
			},jmlbalita: {
				required:"Silahkan Lengkapi Data"
			},jmlanak: {
				required:"Silahkan Lengkapi Data"
			},jmlcaten: {
				required:"Silahkan Lengkapi Data"
			},jmlwushamil: {
				required:"Silahkan Lengkapi Data"
			},jmlwustdkhamil: {
				required:"Silahkan Lengkapi Data"
			},jmlsd: {
				required:"Silahkan Lengkapi Data"
			},jmlposyandu: {
				required:"Silahkan Lengkapi Data"
			},jmlupsbds: {
				required:"Silahkan Lengkapi Data"
			},jmlpembinawil: {
				required:"Silahkan Lengkapi Data"
			},waktutempuh: {
				required:"Silahkan Lengkapi Data"
			}
		}
	});*/
	
	$("#desat_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getDesaByKecamatanId')?>");
		
})
</script>
<script>
	$('#t_data_dasar_target').click(function(){
		$("#t442","#tabs").empty();
		$("#t442","#tabs").load('t_data_dasar_target'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Data Dasar Target</div>
<div class="backbutton"><span class="kembali" id="t_data_dasar_target">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formt_data_dasar_target_add" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_data_dasar_target/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Kecamatan</label>
		<input type="text" name="kecamatan" value="<?=$data->KECAMATAN?>" readonly />
		<input type="hidden" name="kd_kec_hidden" id="kecamatant_pendaftaranadd" value="<?=$data->KD_KEC?>"/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Desa</label>
			<select name="namadesa" id="desat_pendaftaranadd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tahun</label>
		<input type="text" name="tahun" id="tahun" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bayi</label>
		<input type="text" name="jmlbayi" id="jmlbayi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Balita</label>
		<input type="text" name="jmlbalita" id="jmlbalita" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Anak</label>
		<input type="text" name="jmlanak" id="jmlanak" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Caten</label>
		<input type="text" name="jmlcaten" id="jmlcaten" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah WUS Hamil</label>
		<input type="text" name="jmlwushamil" id="jmlwushamil" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah WUS Tidak Hamil</label>
		<input type="text" name="jmlwustdkhamil" id="jmlwustdkhamil" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah SD</label>
		<input type="text" name="jmlsd" id="jmlsd" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Posyandu</label>
		<input type="text" name="jmlposyandu" id="jmlposyandu" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah UPS BDS</label>
		<input type="text" name="jmlupsbds" id="jmlupsbds" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Pembina WIL</label>
		<input type="text" name="jmlpembinawil" id="jmlpembinawil" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Waktu Tempuh</label>
		<input type="text" name="waktutempuh" id="waktutempuh" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >