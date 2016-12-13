<script>
$(document).ready(function(){
		$('#form1t_pendaftaranpelayanan').ajaxForm({
			beforeSend: function() {
				achtungShowLoader();	
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			complete: function(xhr) {
				achtungHideLoader();
				if(xhr.responseText!=='OK'){
					$.achtung({message: xhr.responseText, timeout:5});
				}else{
					$.achtung({message: 'Proses Berhasil', timeout:5});
					$("#t202","#tabs").empty();
					$("#t202","#tabs").load('t_pendaftaran'+'?_=' + (new Date()).getTime());
				}
			}
		});
});


$('input:radio[name="kategori_kia"]').change(
		function(){
			if ($(this).is(':checked') && $(this).val() == '1') {
				$("#showhide_kunjungan_bersalin").show();
				$("#showhide_pemeriksaan_anak").hide();
				$('#showhide_pemeriksaan_anak').load('t_registrasi_kia/kesehatananak?_=' + (new Date()).getTime());
			}else{
				$("#showhide_pemeriksaan_ibu").hide();
				$("#showhide_pemeriksaan_anak").show();
				$('#showhide_pemeriksaan_anak').load('t_registrasi_kia/kesehatananak?_=' + (new Date()).getTime());
			}
		});


</script>
<script>
	$("#form1t_pendaftaranpelayanan input[name = 'batal'], #backlistt_pendaftaran").click(function(){
		$("#t423","#tabs").empty();
		$("#t423","#tabs").load('c_pel_trans_kia'+'?_=' + (new Date()).getTime());
	});
	$('#tglt_pendaftaran').datepicker({dateFormat: "yy-mm-dd",changeYear: true,yearRange: "-100:+0"});
</script>
<script>
	$('#backlistt_grid').click(function(){
		$("#t423","#tabs").empty();
		$("#t423","#tabs").load('c_pel_trans_kia'+'?_=' + (new Date()).getTime());
	})
		$("#form1t_pelayanan_kb_add input[name = 'batal'], #backlistt_grid").click(function(){
		$("#t422","#tabs").empty();
		$("#t422","#tabs").load('t_kesehatan_ibu_dan_anak'+'?_=' + (new Date()).getTime());
	});
</script>
<div class="mycontent">
<div class="formtitle">View Kunjungan <?=$data->KUNJUNGAN_KIA?></div>
<div class="backbutton"><span class="kembali" id="backlistt_grid">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pendaftaranpelayanan" method="post" action="<?=site_url('t_pendaftaran/daftarkunjunganprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>No Rekam Medis</label>
		<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="text" value="<?=$data->NAMA_PASIEN?>" disabled />
		</span>
		<span>
		<label>Golongan Darah</label>
		<input type="text" name="text" value="<?=$data->KD_GOL_DARAH?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Kunjungan</label>
		<input type="text" name="text" value="Kunjungan <?=$data->KUNJUNGAN_KIA?>" disabled />
		</span>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="text" value="<?=$data->TGL_LAHIR?>" disabled />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Pelayanan Kunjungan <?=$data->KUNJUNGAN_KIA?> </div>	
	<fieldset>
		<span>
		<input type="radio" name="kategori_kia" value="1" checked>Kunjungan <?=$data->KUNJUNGAN_KIA?>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kunjungan Bersalin</label>
		<input type="text" name="kode_kunjungan_bersalin" id="" value="Otomatis" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Daftar* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_daftar" id="tglmaster" value="<?=date('d/m/Y')?>" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jam Kelahiran</label>
		<input type="text" name="jam_kelahiran" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>
		<?=getComboKetwaktu('','ket_waktu','ket_waktu','','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<label>Umur Kehamilan(minggu)</label>
		<input type="text" name="umur_kehamilan" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	<fieldset>
		<?=getcombodokter('','dokter','dokter','required','inline')?>		
	</fieldset>
	<fieldset>
		<?=getComboPetugas('','petugas','petugas','required','inline')?>		
	</fieldset>
	<fieldset>
		<?=getComboJenispersalinan('','jenis_persalinan','jenis_persalinan','required','inline')?>		
	</fieldset>
	<fieldset>
		<?=getComboJeniskelahiran('','jenis_kelahiran','jenis_kelahiran','required','inline')?>	
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bayi</label>
		<input type="text" name="jumlah_bayi" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
		<fieldset>
		<?=getComboKesehatan('','keadaan_kesehatan','keadaan_kesehatan','required','inline')?>	
	</fieldset>
	
	<fieldset>
		<?=getComboStatushamil('','status_hamil','status_hamil','required','inline')?>	
	</fieldset>
	
<div class="subformtitle">Bayi saat Lahir</div>
        <fieldset>
		<span>
		<label>Anak Ke</label>
		<input type="text" name="anak_ke" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	 <fieldset>
		<span>
		<label>Berat Lahir (gram)</label>
		<input type="text" name="berat_lahir" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	  <fieldset>
		<span>
		<label>Panjang Badan(cm)</label>
		<input type="text" name="panjang_badan" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	   <fieldset>
		<span>
		<label>Lingkar Kepala(cm)</label>
		<input type="text" name="lingkar_kepala" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
        <fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="radio" name="jk" value="L">Laki - Laki
		<input type="radio" name="jk" value="P">Perempuan
		</span>
	</fieldset>
	<table id="listkeadaanbayi"></table>
	<fieldset id="fieldskeadaanbayi">
		<span>
		<label>Keadaan Bayi Saat Lahir</label>
		<input type="text" name="keadaan_bayi_lahir" value="" id="keadaanbayisearch"/>
		</span>
		<span>
		<input type="hidden" name="keadaanbayisearch_tmpval" id="keadaanbayisearch_tmpval" />
		<input type="hidden" name="keadaanbayisearch_tmptext" id="keadaanbayisearch_tmptext" />
		<input type="hidden" name="keadaanbayi_final" id="keadaanbayi_final" />
		<input type="button" value="Tambah" id="tambahkeadaanbayiid" />
		<input type="button" id="hapuskeadaanbayiid" value="Hapus" />
		</span>
	</fieldset>
	<br/>
	<table id="listasuhanbayi"></table>
	<fieldset id="fieldsasuhanbayi">
		<span>
		<label>Asuhan Bayi Baru Lahir</label>
		<input type="text" name="asuhan_bayi_lahir" value="" id="asuhanbayisearch"/>
		</span>	
		<span>
		<input type="hidden" name="asuhanbayisearch_tmpval" id="asuhanbayisearch_tmpval" />
		<input type="hidden" name="asuhanbayisearch_tmptext" id="asuhanbayisearch_tmptext" />
		<input type="hidden" name="asuhanbayi_final" id="asuhanbayi_final" />
		<input type="button" value="Tambah" id="tambahasuhanbayiid" />
		<input type="button" id="hapusasuhanbayiid" value="Hapus" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan Tambahan</label>
		<textarea name="ket_tambahan" rows="3" cols="45"></textarea>
		</span>	
	</fieldset>
	<fieldset>
		
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >
