<script>
$(document).ready(function(){
		$('#formt_data_dasar_target_edit').ajaxForm({
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
					$("#t442","#tabs").empty();
					$("#t442","#tabs").load('t_data_dasar_target'+'?_=' + (new Date()).getTime());
				}
			}
		});
		$("#desat_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getDesaByKecamatanId')?>");
			
})
</script>
<script>
	$('#backlistt_data_dasar_target').click(function(){
		$("#t442","#tabs").empty();
		$("#t442","#tabs").load('t_data_dasar_target'+'?_=' + (new Date()).getTime());
	})	
</script>
<div class="mycontent">
<div class="formtitle">Edit Data Dasar Target</div>
<div class="backbutton"><span class="kembali" id="backlistt_data_dasar_target">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formt_data_dasar_target_edit" method="post" action="<?=site_url('t_data_dasar_target/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Kecamatan</label>
		<input type="text" name="kecamatan" id="kecamatant_pendaftaranadd" value="<?=$data->KECAMATAN?>" />
		<input type="hidden" name="kd_kec_hidden" value="<?=$data->KD_KECAMATAN?>" />
		<input type="hidden" name="id" value="<?=$data->KD_DATA_DASAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Desa</label>
			<select name="namadesa" id="desat_pendaftaranadd">
				<option value="<?=$data->KD_KELURAHAN?>" selected:selected ></option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tahun</label>
		<input type="text" name="tahun" id="tahun" value="<?=$data->TAHUN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bayi</label>
		<input type="text" name="jmlbayi" id="jmlbayi" value="<?=$data->JML_BAYI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Balita</label>
		<input type="text" name="jmlbalita" id="jmlbalita" value="<?=$data->JML_BALITA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Anak</label>
		<input type="text" name="jmlanak" id="jmlanak" value="<?=$data->JML_ANAK?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Caten</label>
		<input type="text" name="jmlcaten" id="jmlcaten" value="<?=$data->JML_CATEN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah WUS Hamil</label>
		<input type="text" name="jmlwushamil" id="jmlwushamil" value="<?=$data->JML_WUS_HAMIL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah WUS Tidak Hamil</label>
		<input type="text" name="jmlwustdkhamil" id="jmlwustdkhamil" value="<?=$data->JML_WUS_TDK_HAMIL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah SD</label>
		<input type="text" name="jmlsd" id="jmlsd" value="<?=$data->JML_SD?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Posyandu</label>
		<input type="text" name="jmlposyandu" id="jmlposyandu" value="<?=$data->JML_POSYANDU?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah UPS BDS</label>
		<input type="text" name="jmlupsbds" id="jmlupsbds" value="<?=$data->JML_UPS_BDS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Pembina WIL</label>
		<input type="text" name="jmlpembinawil" id="jmlpembinawil" value="<?=$data->JML_PEMBINA_WIL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Waktu Tempuh</label>
		<input type="text" name="waktutempuh" id="waktutempuh" value="<?=$data->WAKTU_TEMPUH?>" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >


