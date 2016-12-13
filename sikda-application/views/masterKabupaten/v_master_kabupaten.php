<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_kabupaten.js"></script>

<div class="mycontent">
<div id="dialogmasterKab" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Kabupaten</div>
	<form id="formmasterKab">
		<div class="gridtitle">Daftar Kabupaten<span class="tambahdata" id="masterKabadd">Input Kabupaten</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal Input (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="darimasterKab"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaimasterKab"/>
						</span>
						<span>
						<label>Cari Kabupaten</label>
						<input type="text" name="carinama" id="carinamamasterKab"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterKab"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterKab"/>
						</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterKab"></table>
		<div id="pagermasterKab"></div>
		</div >
	</form>
</div>