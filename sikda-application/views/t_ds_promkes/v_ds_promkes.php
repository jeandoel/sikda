<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_promkes.js"></script>

<div class="mycontent">
<div id="dialogds_promkes" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Promkes</div>
	<form id="formds_promkes">
		<div class="gridtitle">Daftar Promkes<span class="tambahdata" id="ds_promkesadd">Input Data Promkes</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_promkes"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahunpromkes" class="dari">
				<?php 
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?php } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_promkes"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_promkes"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_promkes"></table>
		<div id="pagerds_promkes"></div>
		</div >
	</form>
</div>