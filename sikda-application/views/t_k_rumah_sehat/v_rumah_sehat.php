<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_k_rumah_sehat.js"></script>

<div class="mycontent">
<div id="dialogrumahsht" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Kesehatan Lingkungan Rumah Sehat</div>
	<form id="formrumahsht">
		<div class="gridtitle">Daftar Rumah Sehat<span class="tambahdata" id="rumahshtadd">Input Data Inspeksi Rumah Sehat</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Tanggal Input (dd-mm-yyyy)</label>
			<input type="text" name="dari" class="dari" id="darirumahsht"/>
			sampai
			<input type="text" name="sampai" class="sampai" id="sampairumahsht"/>
			</span>						
		</fieldset>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama KK</label>
			<input type="text" name="carinama" id="carinamarumahsht"/>
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carirumahsht"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetrumahsht"/>
			</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listrumahsht"></table>
		<div id="pagerrumahsht"></div>
		</div >
	</form>
</div>