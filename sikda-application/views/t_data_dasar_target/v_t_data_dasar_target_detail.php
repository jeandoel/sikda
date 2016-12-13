<script>
	$('#backlistt_data_dasar_target').click(function(){
		$("#t442","#tabs").empty();
		$("#t442","#tabs").load('t_data_dasar_target'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Data Dasar Target</div>
<div class="backbutton"><span class="kembali" id="backlistt_data_dasar_target">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Kecamatan</label>
		<input type="text" name="kecamatan" value="<?=$data->KECAMATAN?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Desa</label>
		<input type="text" name="namadesa" id="namadesa" value="<?=$data->KELURAHAN?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tahun</label>
		<input type="text" name="tahun" id="tahun" value="<?=$data->TAHUN?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bayi</label>
		<input type="text" name="jmlbayi" id="jmlbayi" value="<?=$data->JML_BAYI?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Balita</label>
		<input type="text" name="jmlbalita" id="jmlbalita" value="<?=$data->JML_BALITA?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Anak</label>
		<input type="text" name="jmlanak" id="jmlanak" value="<?=$data->JML_ANAK?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Caten</label>
		<input type="text" name="jmlcaten" id="jmlcaten" value="<?=$data->JML_CATEN?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah WUS Hamil</label>
		<input type="text" name="jmlwushamil" id="jmlwushamil" value="<?=$data->JML_WUS_HAMIL?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah WUS Tidak Hamil</label>
		<input type="text" name="jmlwustdkhamil" id="jmlwustdkhamil" value="<?=$data->JML_WUS_TDK_HAMIL?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah SD</label>
		<input type="text" name="jmlsd" id="jmlsd" value="<?=$data->JML_SD?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Posyandu</label>
		<input type="text" name="jmlposyandu" id="jmlposyandu" value="<?=$data->JML_POSYANDU?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah UPS BDS</label>
		<input type="text" name="jmlupsbds" id="jmlupsbds" value="<?=$data->JML_UPS_BDS?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Pembina WIL</label>
		<input type="text" name="jmlpembinawil" id="jmlpembinawil" value="<?=$data->JML_PEMBINA_WIL?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Waktu Tempuh</label>
		<input type="text" name="waktutempuh" id="waktutempuh" value="<?=$data->WAKTU_TEMPUH?>" disabled />
		</span>
	</fieldset>			
</form>
</div >


