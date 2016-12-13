<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_pel_trans_kia.js"></script>

<div class="mycontent">
<div id="dialogpeltranskia" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Pelayanan Kesehatan Ibu dan Anak</div>
	<form id="formt_kesehatanibudananak">
		<div class="gridtitle">Pelayanan<span id="t_kesehatanibudananakadd" class="tambahdata"></span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						
						
						<span>
						<label>Cari Berdasarkan</label>
						<select name="keyword" id="keywordid">
						  <option value="">--Pilih Kategori--</option>
						   <option value="NO_REGISTRASI">No Registrasi</option>
						    <option value="NAMA_LENGKAP">Nama Pengunjung</option>
						     <option value="KD_KUNJUNGAN_KIA">Kategori Kunjungan</option>
						</select>
						
						<input type="text" name="cari" class="cari" id="kesehatanibudananak"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caritrans_kia"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resettrans_kia"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listpel_trans_kia"></table>
		<div id="pagert_trans_kia"></div>
		</div >
	</form>
</div>