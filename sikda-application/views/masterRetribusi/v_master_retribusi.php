<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_retribusi.js"></script>

<div class="mycontent">
<div id="dialogretribusi" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Retribusi</div>
	<form id="formretribusi">
		<div class="gridtitle">Daftar Retribusi<span class="tambahdata" id="masterretribusiadd">Input Retribusi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Retribusi</label>
						<input type="text" name="nama" class="nama" id="namaretribusi"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="cariretribusi" />
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetretribusi" />
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listretribusi"></table>
		<div id="pagerretribusi"></div>
		</div >
	</form>
</div>
