<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_ruangan.js"></script>

<div class="mycontent">
<div id="dialogruangan" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Data Ruangan</div>
	<form id="formmaster_ruangan">
		<div class="gridtitle">Daftar Data Ruangan<span class="tambahdata" id="master_ruangan_add">Input Data Ruangan</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Ruangan </label>
						<input type="text" name="koderuangan" class="koderuangan" id="koderuanganmaster_ruangan"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_ruangan"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_ruangan"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmaster_ruangan"></table>
		<div id="pagermaster_ruangan"></div>
		</div >
	</form>
</div>