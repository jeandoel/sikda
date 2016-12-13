<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_unit_pelayanan.js"></script>

<div class="mycontent">
<div id="dialogunitpelayanan_new" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Unit Pelayanan</div>
	<form id="formmasterunitpelayanan">
		<div class="gridtitle">Daftar Unit Pelayanan<span class="tambahdata" id="masterunitpelayanandd">Input Data Unit Pelayanan</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						
						
						<span>
						<label>Cari Kode Unit Pelayanan</label>
						
						<input type="text" name="pasien" class="cari" id="cariunitpelayanan"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterunitpelayanan"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterunitpelayanan"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listunitpelayanan"></table>
		<div id="pagermasterunitpelayanan"></div>
		</div >
	</form>
</div>
