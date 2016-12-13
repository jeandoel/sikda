<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_gigi_prosedur.js"></script>

<div class="mycontent">
<div id="dialogmastergigiprosedur" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Prosedur Gigi</div>
	<form id="formmastergigiprosedur">
		<div class="gridtitle">Daftar Master Prosedur Gigi<span class="tambahdata" id="mastergigiproseduradd">Input Prosedur Gigi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Kode Prosedur Gigi</label>
						<input type="text" name="kodemastergigiprosedur" class="kodemastergigiprosedur" id="kodemastergigiprosedur"/>
						<label>Cari Prosedur Gigi</label>
						<input type="text" name="prosedurmastergigiprosedur" class="prosedurmastergigiprosedur" id="prosedurmastergigiprosedur"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastergigiprosedur"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastergigiprosedur"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmastergigiprosedur"></table>
		<div id="pagermastergigiprosedur"></div>
		</div >
	</form>
</div>
