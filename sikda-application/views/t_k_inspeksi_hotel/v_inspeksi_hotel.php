<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_k_inspeksi_hotel.js"></script>

<div class="mycontent">
<div id="dialoginspekhtel" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Kesehatan Lingkungan Pemeriksaan Kesehatan Hotel</div>
	<form id="forminspekhtel">
		<div class="gridtitle">Daftar Pemeriksaan Kesehatan Hotel<span class="tambahdata" id="inspekhteladd">Input Data Pemeriksaan Kesehatan Hotel</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Tanggal Input (dd-mm-yyyy)</label>
			<input type="text" name="dari" class="dari" id="dariinspekhtel"/>
			sampai
			<input type="text" name="sampai" class="sampai" id="sampaiinspekhtel"/>
			</span>						
		</fieldset>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Hotel</label>
			<input type="text" name="carinama" id="carinamainspekhtel"/>
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="cariinspekhtel"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetinspekhtel"/>
			</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listinspekhtel"></table>
		<div id="pagerinspekhtel"></div>
		</div >
	</form>
</div>