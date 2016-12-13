<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_kecamatan.js"></script>

<div class="mycontent">
<div id="dialogkecamatan" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Data Kecamatan</div>
	<form id="formmaster_kecamatan">
		<div class="gridtitle">Daftar Data Kecamatan<span class="tambahdata" id="master_kecamatan_add">Input Data Kecamatan</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Kecamatan </label>
						<input type="text" name="kodekecamatan" class="kodekecamatan" id="kodekecamatanmaster_kecamatan"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_kecamatan"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_kecamatan"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmaster_kecamatan"></table>
		<div id="pagermaster_kecamatan"></div>
		</div >
	</form>
</div>