<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_agama.js"></script>

<div class="mycontent">
<div id="dialogagama" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Data Agama</div>
	<form id="formmaster_agama">
		<div class="gridtitle">Daftar Data Agama<span class="tambahdata" id="master_agama_add">Input Data Agama</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Agama </label>
						<input type="text" name="kodeagama" class="kodeagama" id="kodeagamamaster_agama"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_agama"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_agama"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmaster_agama"></table>
		<div id="pagermaster_agama"></div>
		</div >
	</form>
</div>