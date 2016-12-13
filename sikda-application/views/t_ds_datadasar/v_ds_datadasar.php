<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_datadasar.js"></script>

<div class="mycontent">
<div id="dialogds_datadasar" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Dasar</div>
	<form id="formds_datadasar">
		<div class="gridtitle">Daftar Data Dasar<span class="tambahdata" id="ds_datadasaradd">Input Data Dasar</span></div>
		
		<fieldset style="margin:0 13px 0 13px">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_datadasar"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahundatadasar" class="dari">
				<?php
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?php } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_datadasar"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_datadasar"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_datadasar"></table>
		<div id="pagerds_datadasar"></div>
		</div >
	</form>
</div>