<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_k_rm_restoran.js"></script>

<div class="mycontent">
<div id="dialogrmrstr" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Kesehatan Lingkungan RM dan Restoran</div>
	<form id="formrmrstr">
		<div class="gridtitle">Daftar RM dan Restoran<span class="tambahdata" id="rmrstradd">Input Data Inspeksi RM dan Restoran</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Tanggal Input (dd-mm-yyyy)</label>
			<input type="text" name="dari" class="dari" id="darirmrstr"/>
			sampai
			<input type="text" name="sampai" class="sampai" id="sampairmrstr"/>
			</span>						
		</fieldset>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama</label>
			<input type="text" name="carinama" id="carinamarmrstr"/>
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carirmrstr"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetrmrstr"/>
			</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listrmrstr"></table>
		<div id="pagerrmrstr"></div>
		</div >
	</form>
</div>