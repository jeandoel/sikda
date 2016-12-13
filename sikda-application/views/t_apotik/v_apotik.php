<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_apotik.js"></script>
<div id="dialogcari_apotikkomentar" class="dialog" style="color:red;font-size:.75em;" title="Pesan Check"></div>
<div id="dialogcari_lihatapotikkomentar" class="dialog" style="color:red;font-size:.75em;" title="Pesan Check"></div>

<div class="mycontent">
<div id="dialogcari_apotikcetak_id" title="" style="display:none"><iframe id="dialogcari_apotikcetakiframe_id"  style="width:100%;height:100%;" src=""></iframe></div>
<div id="dialogt_apotik" class="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Apotik</div>
	<form id="formt_apotik">
		<div class="gridtitle_t">&nbsp;</div>					
		<fieldset class="fieldsetpencarian">	
			<span>
			<label>Pencarian Berdasarkan</label>
			<select id="keywordt_pendaftaran" name="keyword">				
				<option value="NAMA_LENGKAP">Nama Pasien</option>
				<option value="KD_PASIEN">Rekam Medis</option>
			</select>
			<input type="text" name="cari" id="carit_pendaftaran"/>
			</span>
		</fieldset>
		<fieldset class="fieldsetpencarian">			
			<span>
				<label>Status</label>
				<select name="status_pelayanan" id="status_pelayanant_apotik">
					<option value="">Semua</option>
					<option value="1">Sudah Dilayani</option>
					<option value="0">Belum Dilayani</option>
				</select>
			</span>
			<span>
				<label class="mydate">Tanggal</label>				
				<input type="text" name="tanggal" class="dari" id="tanggalt_apotik" value="<?=date('d/m/Y')?>" />
			</span>
		</fieldset>
		
		<fieldset class="fieldsetpencarian">	
			<span>
				<label>&nbsp;</label>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_apotik" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_apotik"/>
			</span>	
		</fieldset>
		<div class="paddinggrid" id="pelayanan_grid_antrian">
		<table id="listt_apotik"></table>
		<div id="pagert_apotikanantrian"></div>
		</div >
	</form>
</div>