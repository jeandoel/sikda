<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_status_marital.js"></script>

<div class="mycontent">
<div id="dialogstatusmarital_new" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Status Marital</div>
	<form id="formmasterststusmarital">
		<div class="gridtitle">Daftar Status Marital<span class="tambahdata" id="master_status_marital_add">Input Status Marital</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Nama Status</label>
						<input type="text" name="nama" class="nama" id="namastatusmarital"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caristatusmarital"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetstatusmarital"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="liststatusmarital"></table>
		<div id="pagerstatusmarital"></div>
		</div >
	</form>
</div>
