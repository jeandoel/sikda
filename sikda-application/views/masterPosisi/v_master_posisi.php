<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_posisi.js"></script>

<div class="mycontent">
<div id="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Posisi</div>
	<form id="formmasterposisi">
		<div class="gridtitle">Daftar Master Posisi<span class="tambahdata" id="masterposisiadd">Input Master Posisi</span></div>
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Posisi</label>
						<input type="text" name="nama" class="nama" id="namamasterposisi"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterposisi"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterposisi"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterposisi"></table>
		<div id="pagermasterposisi"></div>
		</div >
	</form>
</div>