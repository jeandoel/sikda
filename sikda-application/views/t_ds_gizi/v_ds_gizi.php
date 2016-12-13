<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_gizi.js"></script>

<div class="mycontent">
<div id="dialogds_gizi" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Gizi</div>
	<form id="formds_gizi">
		<div class="gridtitle">Daftar Gizi<span class="tambahdata" id="ds_giziadd">Input Data Gizi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_gizi"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahungizi" class="dari">
				<?php 
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?php } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_gizi"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_gizi"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_gizi"></table>
		<div id="pagerds_gizi"></div>
		</div >
	</form>
</div>