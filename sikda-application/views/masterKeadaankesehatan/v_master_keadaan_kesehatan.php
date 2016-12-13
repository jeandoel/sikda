<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_keadaan_kesehatan.js"></script>

<div class="mycontent">
<div id="dialogmasterKeadaankesehatan" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Keadaan Kesehatan</div>
	<form id="formmasterKeadaankesehatan">
		<div class="gridtitle">Daftar Keadaan Kesehatan<span class="tambahdata" id="masterKeadaankesehatanadd">Input Baru</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal Input (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="darimasterKeadaankesehatan"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaimasterKeadaankesehatan"/>
						</span>
						<span>
						<label>Cari Keadaan Kesehatan</label>
						<input type="text" name="carinama" id="carinamamasterKeadaankesehatan"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterKeadaankesehatan"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterKeadaankesehatan"/>
						</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterKeadaankesehatan"></table>
		<div id="pagermasterKeadaankesehatan"></div>
		</div >
	</form>
</div>