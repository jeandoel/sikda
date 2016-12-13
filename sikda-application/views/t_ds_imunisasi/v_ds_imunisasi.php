<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_imunisasi.js"></script>

<div class="mycontent">
<div id="dialogds_imunisasi" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Imunisasi</div>
	<form id="formds_imunisasi">
		<div class="gridtitle">Daftar Imunisasi<span class="tambahdata" id="ds_imunisasiadd">Input Data Imunisasi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_imunisasi"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahunimunisasi" class="dari">
				<?php 
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?php } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_imunisasi"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_imunisasi"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_imunisasi"></table>
		<div id="pagerds_imunisasi"></div>
		</div >
	</form>
</div>