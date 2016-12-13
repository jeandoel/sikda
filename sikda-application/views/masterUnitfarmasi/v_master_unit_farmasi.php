<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_unit_farmasi.js"></script>

<div class="mycontent">
<div id="dialogunitfarmasi" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Data Unit Farmasi/Apotik</div>
	<form id="formmaster_unitfarmasi">
		<div class="gridtitle">Daftar Data Unit Farmasi<span class="tambahdata" id="master_unitfarmasi_add">Input Data Unit Farmasi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Nama Unit Farmasi </label>
						<input type="text" name="kodeunitfarmasi" class="kodeunitfarmasi" id="kodeunitfarmasimaster_unitfarmasi"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_unitfarmasi"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_unitfarmasi"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmaster_unitfarmasi"></table>
		<div id="pagermaster_unitfarmasi"></div>
		</div >
	</form>
</div>