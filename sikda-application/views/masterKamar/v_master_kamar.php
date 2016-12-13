<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_kamar.js"></script>

<div class="mycontent">
<div id="dialogkamar" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Kamar</div>
	<form id="formmasterkamar">
		<div class="gridtitle">Daftar Kamar<span class="tambahdata" id="masterkamaradd">Input Data Kamar</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						
						
						<span>
						<label>Cari Kamar</label>
                                                <select name="keyword" id="keywordid">
							<option value="NO_KAMAR">Pilih Kategori</option>
							<option value="NO_KAMAR">No Kamar</option>
							<option value="NAMA_KAMAR">Nama Kamar</option>
						</select>
                                                Cari
						
						<input type="text" name="cari" class="cari" id="carikamar"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterkamar"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterkamar"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listkamar"></table>
		<div id="pagermasterkamar"></div>
		</div >
	</form>
</div>