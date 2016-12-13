<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_k_inspeksi_pasar.js"></script>

<div class="mycontent">
<div id="dialoginpeksipsr" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Kesehatan Lingkungan Pasar</div>
	<form id="forminpeksipsr">
		<div class="gridtitle">Daftar Pasar<span class="tambahdata" id="inpeksipsradd">Input Data Inspeksi Pasar</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Tanggal Input (dd-mm-yyyy)</label>
			<input type="text" name="dari" class="dari" id="dariinpeksipsr"/>
			sampai
			<input type="text" name="sampai" class="sampai" id="sampaiinpeksipsr"/>
			</span>						
		</fieldset>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Pasar</label>
			<input type="text" name="carinama" id="carinamainpeksipsr"/>
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="cariinpeksipsr"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetinpeksipsr"/>
			</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listinpeksipsr"></table>
		<div id="pagerinpeksipsr"></div>
		</div >
	</form>
</div>