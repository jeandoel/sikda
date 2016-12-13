<script type="text/javascript" src="<?=base_url()?>assets/customjs/mastertempat.js"></script>

<div class="mycontent">
<div id="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Data Registrasi Tempat</div>
	<form id="formmastertempat">
		<div class="gridtitle">Daftar Master Registrasi Tempat<span class="tambahdata" id="mastertempatadd">Input Master Vaksin</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal Master Registrasi (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="darimastertempat"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaimastertempat"/>
						
						</span>
					</fieldset>
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Nama Tempat</label>
						<input type="text" name="nama" class="nama" id="namamastertempat"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastertempat"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastertempat"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmastertempat"></table>
		<div id="pagermastertempat"></div>
		</div >
	</form>
</div>