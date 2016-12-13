<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_gigi_masalah.js"></script>

<div class="mycontent">
<div id="dialogmastergigimasalah" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Masalah Gigi</div>
	<form id="formmastergigimasalah">
		<div class="gridtitle">Daftar Masalah Gigi<span class="tambahdata" id="mastergigimasalahadd">Input Masalah Gigi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Kode Masalah Gigi</label>
						<input type="text" name="kodemastergigimasalah" class="kodemastergigimasalah" id="kodemastergigimasalah"/>
						<label>Cari Masalah Gigi</label>
						<input type="text" name="masalahmastergigimasalah" class="masalahmastergigimasalah" id="masalahmastergigimasalah"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastergigimasalah"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastergigimasalah"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmastergigimasalah"></table>
		<div id="pagermastergigimasalah"></div>
		</div >
	</form>
</div>