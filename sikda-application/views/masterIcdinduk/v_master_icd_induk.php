<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_icd_induk.js"></script>

<div class="mycontent">
<div id="dialogicdinduk_new" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master ICD Induk</div>
	<form id="formmaster_icd_induk">
		<div class="gridtitle">Daftar ICD Induk<span class="tambahdata" id="master_icd_induk_add">Input ICD Induk</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Berdasarkan</label>
						<select name="keyword" id="namakeyword">
							<option value="KD_ICD_INDUK">Kode ICD Induk</option>
							<option value="ICD_INDUK">ICD Induk</option>
						</select>
						<input type="text" name="cari" id="carikategori"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_icd_induk"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_icd_induk"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmaster_icd_induk"></table>
		<div id="pagermaster_icd_induk"></div>
		</div >
	</form>
</div>
