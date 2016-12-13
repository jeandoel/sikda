<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_gigi_permukaan.js"></script>
<style type="text/css">
.ui-jqgrid tr.jqgrow td {vertical-align:middle !important}
</style>

<div class="mycontent">
<div id="dialogmastergigipermukaan" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Permukaan Gigi</div>
	<form id="formmastergigipermukaan">
		<div class="gridtitle">Daftar Permukaan Gigi<span class="tambahdata" id="mastergigipermukaanadd">Input Permukaan Gigi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Kode</label>
						<input type="text" name="kodemastergigipermukaan" class="kodemastergigipermukaan" id="kodemastergigipermukaan"/>
						<label>Cari Nama</label>
						<input type="text" name="namamastergigipermukaan" class="namamastergigipermukaan" id="namamastergigipermukaan" style="margin-top:5px;"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastergigipermukaan"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastergigipermukaan"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmastergigipermukaan"></table>
		<div id="pagermastergigipermukaan"></div>
		</div >
	</form>
</div>