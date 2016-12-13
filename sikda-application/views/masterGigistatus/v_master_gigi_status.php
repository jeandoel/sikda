<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_gigi_status.js"></script>
<style type="text/css">
.ui-jqgrid tr.jqgrow td {vertical-align:middle !important}
</style>

<div class="mycontent">
<div id="dialogmastergigistatus" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Status Gigi</div>
	<form id="formmastergigistatus">
		<div class="gridtitle">Daftar Master Status Gigi<span class="tambahdata" id="mastergigistatusadd">Input Master Status Gigi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Kode Status Gigi</label>
						<input type="text" name="kodemastergigistatus" class="kodemastergigistatus" id="kodemastergigistatus"/>
						<label>Cari Status Gigi</label>
						<input type="text" name="kodemastergigistatus" class="kodemastergigistatus" id="statusmastergigistatus" style="margin-top:5px;"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastergigistatus"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastergigistatus"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmastergigistatus"></table>
		<div id="pagermastergigistatus"></div>
		</div >
	</form>
</div>
