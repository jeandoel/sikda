<script>
	$(function(){

		jQuery("#listimunisasi").jqGrid({
			url:'t_imunisasi_dg/t_imunisasixml', 
			emptyrecords: 'Tidak Ada Data',
			datatype: 'xml',
			rownumbers:true,
			width: 580,
			height: 'auto',
			mtype: 'POST',
			colNames:['Jenis Imunisasi','Vaksin'],
			colModel :[ 
			{name:'jenisimunisasi',index:'jenisimunisasi'}, 
			{name:'namavaksin',index:'namavaksin'},
			],
			rowNum:35,
			viewrecords: true,
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas='<?=$data->KD_PUSKESMAS?>';
				$('#listimunisasi').setGridParam({postData:{'myid2':id2,'idpuskesmas':idpuskesmas}})
			}			
		}); 

		jQuery("#listpetugas").jqGrid({
			url:"t_imunisasi_dg/t_petugasxml",
			emptyrecords: "Tidak Ada Data",
			datatype: "xml",
			rownumbers:true,
			width: 580,
			height: 'auto',
			mtype: 'POST',
			colNames:['Petugas'],
			colModel :[ 
			{name:'nama',index:'nama'},
			],
			rowNum:35,
			viewrecords: true,
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas='<?=$data->KD_PUSKESMAS?>';
				$('#listpetugas').setGridParam({postData:{'myid2':id2,'idpuskesmas':idpuskesmas}})
			}			
		})
		
		if ($('#kategoripasienid').val()=='') {
			$('#formkategori_pasiensiswa').css("display",'none');
			$('#formkategori_pasienwushamil').css("display",'none');
			$('#formkategori_pasienwustdkhamil').css("display",'none');
		}else if ($('#kategoripasienid').val()=='6') {
			$('#formkategori_pasiensiswa').css("display",'none');
			$('#formkategori_pasienwushamil').css("display",'');
			$('#formkategori_pasienwustdkhamil').css("display",'');
		}
		else if ($('#kategoripasienid').val()=='5') {
			$('#formkategori_pasiensiswa').css("display",'none');
			$('#formkategori_pasienwushamil').css("display",'');
			$('#formkategori_pasienwustdkhamil').css("display",'none');
		}else if ($('#kategoripasienid').val()=='7'|| $(this).val()=='8'){
			$('#formkategori_pasiensiswa').css("display",'none');
			$('#formkategori_pasienwushamil').css("display",'none');
		}else {
			$('#formkategori_pasiensiswa').css("display",'');
			$('#formkategori_pasienwushamil').css("display",'none');
		}
		
		
		$('#hpht').mask('99/99/9999');
	})
</script>
<script>
	$("form input[name = 'batal'], #backt_pelayanan_imunisasi").click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	});
</script>
<div class="mycontent">
<div class="formtitle">Detail Pelayanan Imunisasi</div>
<div class="backbutton"><span class="kembali" id="backt_pelayanan_imunisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
	<fieldset>
		<span>
		<label>Rekam Medis#</label>
		<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid1" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid2" value="<?=$data->KD_KUNJUNGAN?>" />
		<input type="hidden" name="kd_unit_hidden" id="textid3" value="<?=$data->KD_UNIT?>" />
		<input type="hidden" name="kd_urutmasuk_hidden" id="textid4" value="<?=$data->URUT_MASUK?>" />
		<input type="hidden" name="kd_unitpel_hidden" id="textid5" value="<?=$data->KD_UNIT_LAYANAN?>" />
		<input type="hidden" name="kd_kec_hidden" id="textid6" value="<?=$data->KD_KECAMATAN?>" />
		<input type="hidden" name="kd_kel_hidden" id="textid7" value="<?=$data->KD_KELURAHAN?>" />
		</span>
		<span>
		<label>NIK</label>
		<input type="text" name="text" value="<?=isset($data->NO_PENGENAL)?$data->NO_PENGENAL:''?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="text" value="<?=$data->NAMA_LENGKAP?>" disabled />
		</span>
		<span>
		<label>Golongan Darah</label>
		<input type="text" name="text" value="<?=$data->KD_GOL_DARAH?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="text" value="<?=$data->TGL_LAHIR?>" disabled />
		</span>
	</fieldset>
	<fieldset>		
		<span>
		<label>Kel/Jenis Pasien</label>
		<input type="text" name="text" value="<?=$data->KD_CUSTOMER?>" disabled />
		</span>
		<span>
		<label>Cara Bayar</label>
		<input type="text" name="text" value="<?=$data->CARA_BAYAR?>" disabled />
		</span>
	</fieldset>
	<div class="subformtitle">Pelayanan</div>
	<fieldset>
		<span>
		<label>Tanggal Pelayanan</label>
		<input id="tgl_pelayanan" class="mydate" type="text" name="tgl_pelayanan" value="<?=$data->TGL_PELAYANAN?>" readonly>
		</span>
	</fieldset>
	<?=getComboJenisPasienImunisasi($data->KD_JENIS_PASIEN,'kategoripasien','kategoripasienid','required','','disabled')?>

<fieldset id="formkategori_pasiensiswa">
	<span>
	<label>Nama Ibu</label>
	<input type="text" name="namaibu" id="namaibu" value="<?=isset($dataibu->NAMA_IBU)?$dataibu->NAMA_IBU:''?>"  readonly/>
	</span>
	<span>
</fieldset>	

<div id="formkategori_pasienwushamil">
<?=getComboStatusnikah($data->STATUS_MARITAL,'statusmenikah','statusmenikah','','')?>
<fieldset>	
	<span>
	<label>Nama Suami</label>
	<input type="text" name="namasuami" id="namasuami" value="<?=isset($datasuami->NAMA_SUAMI)?$datasuami->NAMA_SUAMI:''?>"  />
	</span>
</fieldset>
<div id="formkategori_pasienwustdkhamil">
<fieldset>	
	<span>
	<label>HPHT</label>
	<input type="text" class="mydate" name="hpht" id="hpht" value="<?=$data->TANGGAL?>" readonly  />
	</span>
</fieldset>
<fieldset>	
	<span>
	<label>Kehamilan ke</label>
	<input type="text" name="kehamilanke" id="kehamilanke" value="<?=$data->HAMIL_KE?>" readonly />
	</span>
</fieldset>
<fieldset>	
	<span>
	<label>Jarak Kehamilan</label>
	<input type="text" name="jarakkehamilan" id="jarakkehamilan" value="<?=$data->JARAK_KEHAMILAN?>" readonly  />
	</span>
</fieldset>
</div>
</div>
<br/>
<table id="listimunisasi"></table>
<table id="listpetugas"></table>
<br/>
<?=getComboStatuskeluar($data->KEADAAN_KELUAR,'status_keluar','status_keluar_id','disabled','')?>
</div >