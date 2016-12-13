<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_kematian_anak.js"></script>

<div class="mycontent">
<div id="dialogds_kematian_anak" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Kematian Bayi</div>
	<form id="formds_kematian_anak">
		<div class="gridtitle">Daftar Kematian Bayi<span class="tambahdata" id="ds_kematian_anakadd">Input Data Kematian Bayi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_kematian_anak"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahunkematiananak" class="dari">
				<?php 
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?PHP } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_kematian_anak"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_kematian_anak"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_kematian_anak"></table>
		<div id="pagerds_kematian_anak"></div>
		</div >
	</form>
</div>