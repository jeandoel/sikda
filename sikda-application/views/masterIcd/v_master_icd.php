<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_icd.js"></script>

<div class="mycontent">
<div id="dialogicd_new" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master ICD</div>
	<form id="formmastericd">
		<div class="gridtitle">Daftar ICD<span class="tambahdata" id="mastericdadd">Input Data ICD</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						
						
						<span>
						<label>Cari ICD</label>
                        <select name="keyword" id="keywordid">
							<option value="KD_PENYAKIT">Pilih Kategori</option>
							<option value="KD_PENYAKIT">Kode Penyakit</option>
							<option value="PENYAKIT">Penyakit</option>
						</select>
                                                Cari
						
						<input type="text" name="cari" class="cari" id="carinamamastericd"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastericd"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastericd"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listicd"></table>
		<div id="pagermastericd"></div>
		</div >
	</form>
</div>
