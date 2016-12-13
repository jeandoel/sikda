<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_gigi.js"></script>
<style type="text/css">
.ui-jqgrid tr.jqgrow td {vertical-align:middle !important}
</style>

<div class="mycontent">
<div id="dialogmastergigi" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Nomenklatur</div>
	<form id="formmastergigi">
		<div class="gridtitle">Daftar Nomenklatur<span class="tambahdata" id="mastergigiadd">Input Nomenklatur</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Nomenklatur</label>
						<input type="text" name="kodemastergigi" class="kodemastergigi" id="kodemastergigi"/>
						<label>Cari Nama Gigi</label>
						<input type="text" name="namamastergigi" class="namamastergigi" id="namamastergigi" style="margin-top:5px;" />
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastergigi"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastergigi"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmastergigi"></table>
		<div id="pagermastergigi"></div>
		</div >
	</form>
</div>