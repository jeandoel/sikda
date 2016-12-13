<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_spesialisasi.js"></script>

<div class="mycontent">
<div id="dialogmasterspesialisasi" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Spesialisasi</div>
	<form id="formmasterspesialisasi">
		<div class="gridtitle">Daftar Master Spesialisasi<span class="tambahdata" id="masterspesialisasiadd">Input Master Spesialisasi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Spesialisasi</label>
						<input type="text" name="nama" class="nama" id="namamasterspesialisasi"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterspesialisasi"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterspesialisasi"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterspesialisasi"></table>
		<div id="pagermasterspesialisasi"></div>
		</div >
	</form>
</div>