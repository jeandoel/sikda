<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_data_dasar_target.js"></script>

<div class="mycontent">
<div id="dialogdatadasartarget" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Dasar Target</div>
	<form id="formt_data_dasar_target">
		<div class="gridtitle">Data Dasar Target<span class="tambahdata" id="t_data_dasar_target_add">Input Data Dasar Target</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Data Dasar Target </label>
						<select name="kodedatadasartarget" id="kodedatadasartargett_data_dasar_target">
						<option VALUE="KELURAHAN">KELURAHAN</option>
						<option VALUE="TAHUN">TAHUN</option>
						<option VALUE="JML_BAYI">JUMLAH BAYI</option>
						<option VALUE="JML_BALITA">JUMLAH BALITA</option>
						<option VALUE="JML_ANAK">JUMLAH ANAK</option>
						<option VALUE="JML_CATEN">JUMLAH CATEN</option>
						<option VALUE="JML_WUS_HAMIL">JUMLAH WUS HAMIL</option>
						<option VALUE="JML_WUS_TDK_HAMIL">JUMLAH WUS TDK HAMIL</option>
						</select>
						<input type="text" name="carinama" id="carinamadatadasartarget"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_data_dasar_target"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_data_dasar_target"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid" id="data_dasar_t">
		<table id="listt_data_dasar_target"></table>
		<div id="pagert_data_dasar_target"></div>
		</div >
	</form>
</div>