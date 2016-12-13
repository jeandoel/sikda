<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_kematian_ibu.js"></script>

<div class="mycontent">
<div id="dialogds_kematian_ibu" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Kematian Ibu</div>
	<form id="formds_kematian_ibu">
		<div class="gridtitle">Daftar Kematian Ibu<span class="tambahdata" id="ds_kematian_ibuadd">Input Data Kematian Ibu</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_kematian_ibu"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahunkematianibu" class="dari">
				<?php 
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?PHP } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_kematian_ibu"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_kematian_ibu"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_kematian_ibu"></table>
		<div id="pagerds_kematian_ibu"></div>
		</div >
	</form>
</div>