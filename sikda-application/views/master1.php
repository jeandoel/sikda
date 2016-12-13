<script type="text/javascript" src="<?=base_url()?>assets/customjs/master1.js"></script>

<div class="mycontent">
<div id="dialogmaster1" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Satu</div>
	<form id="formmaster1">
		<div class="gridtitle">Daftar Master1<span class="tambahdata" id="master1add">Input Master1</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Tanggal Master1 (dd-mm-yyyy)</label>
			<input type="text" name="dari" class="dari" id="darimaster1"/>
			sampai
			<input type="text" name="sampai" class="sampai" id="sampaimaster1"/>
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster1"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster1"/>
			</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listmaster1"></table>
		<div id="pagermaster1"></div>
		</div >
	</form>
</div>