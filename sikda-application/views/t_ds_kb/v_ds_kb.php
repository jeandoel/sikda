<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_kb.js"></script>

<div class="mycontent">
<div id="dialogds_kb" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data KB</div>
	<form id="formds_kb">
		<div class="gridtitle">Daftar KB<span class="tambahdata" id="ds_kbadd">Input Data KB</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_kb"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahunkb" class="dari">
				<?php 
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?php } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_kb"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_kb"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_kb"></table>
		<div id="pagerds_kb"></div>
		</div >
	</form>
</div>