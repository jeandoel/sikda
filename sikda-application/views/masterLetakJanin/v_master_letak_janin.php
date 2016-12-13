<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_letak_janin.js"></script>

<div class="mycontent">
<div id="dialogmasterLetakJanin" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Letak Janin</div>
	<form id="formmasterLetakJanin">
		<div class="gridtitle">Daftar Letak Janin<span class="tambahdata" id="masterLetakJaninadd">Input Baru</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Letak Janin</label>
						<input type="text" name="carinama" id="carinamamasterLetakJanin"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterLetakJanin"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterLetakJanin"/>
						</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterLetakJanin"></table>
		<div id="pagermasterLetakJanin"></div>
		</div >
	</form>
</div>