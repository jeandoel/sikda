<style>
.ui-menu-item{
	font-size:.59em;
	color:blue!important;
}
.ui-autocomplete-category {
	font-weight: bold;
	padding: .1em .1.5em;
	margin: .8em 0 .2em;
	line-height: 1.5;
	font-size:.71em;
}
.ui-autocomplete{
	width:355px!important;
}
.inputaction1{
	width:255px;font-weight:bold;
}
.inputaction2{
	width:255px;font-weight:bold;color:#0B77B7
}
.labelaction{
	font-weight:bold;font-size:1.05em;color:#0B77B7;width:175px;
}
.declabel{width:91px}
.declabel2{width:175px}
.decinput{width:99px}
</style>
<script>
$(document).ready(function(){
		jQuery("#listdiagnosarawatjalan").jqGrid({ 
		url:'t_pelayanan/diagnosarawatjalan_xml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Penyakit', 'Penyakit', 'Jenis Kasus','Jenis Diagnosa'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel :[ 
			{name:'kd_penyakit',index:'kd_penyakit', width:55,align:'center'}, 
			{name:'penyakit',index:'penyakit', width:801}, 
			{name:'jenis_kasus',index:'jenis_kasus', width:81}, 
			{name:'jenis_diagnosa',index:'jenis_diagnosa', width:81}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_diagnosarawatjalan'),
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id1='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listdiagnosarawatjalan').setGridParam({postData:{'myid1':id1,'idpuskesmas':idpuskesmas}})
			}	
		}).navGrid('#pagert_diagnosarawatjalan',{search:false,edit:false,add:false,del:false});
		
		jQuery("#listkeadaanbayi").jqGrid({
		url:'t_kesehatan_ibu_dan_anak/t_keadaanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Keadaan Bayi Saat Lahir'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows : true,	
		colModel :[ {name:'kd_keadaan_bayi_lahir',index:'kd_keadaan_bayi_lahir', width:55,hidden:true},
					{name:'keadaan_bayi_lahir',index:'keadaan_bayi_lahir', width:801},
		],
			rowNum:35,
			pager: jQuery('#pagert_keadaanbayi'),
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id5='<?=$data->KD_KUNJUNGAN_BERSALIN?>';
				$('#listkeadaanbayi').setGridParam({postData:{'myid5':id5}})
			}			
		}).navGrid('#pagert_keadaanbayi',{search:false}); 
		
		jQuery("#listasuhanbayi").jqGrid({
		url:'t_kesehatan_ibu_dan_anak/t_asuhanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Asuhan Bayi Baru Lahir'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows : true,	
		colModel :[ 
		{name:'kd_asuhan_bayi_lahir',index:'kd_asuhan_bayi_lahir', width:55,hidden:true},
		{name:'asuhan_bayi_lahir',index:'asuhan_bayi_lahir', width:801}
		],
			rowNum:35,
			pager: jQuery('#pagert_asuhanbayi'),
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id6='<?=$data->KD_KUNJUNGAN_BERSALIN?>';
				$('#listasuhanbayi').setGridParam({postData:{'myid6':id6}})
			}			
		}).navGrid('#pagert_asuhanbayi',{search:false});
		//////////// Modul Tindakan dan Harga ////////////////////
		jQuery("#listtindakanrawatjalan").jqGrid({
			url:'t_kesehatan_ibu_dan_anak/t_tindakanxml', 
			emptyrecords: 'Nothing to display',
			datatype: "xml", 
			colNames:['Kode Tindakan','Tindakan', 'Harga','Jumlah','Keterangan'],
			rownumbers:true,
			width: 1049,
			height: 'auto',
			mtype: 'POST',
			altRows : true,
			colModel :[ 
			{name:'kd_tindakan',index:'kd_tindakan', width:55,align:'center'}, 
			{name:'tindakan',index:'tindakan', width:300}, 
			{name:'harga',index:'harga', width:81}, 
			{name:'jumlah',index:'jumlah', width:51,align:'center'},
			{name:'keterangan',index:'keterangan', width:400}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_tindakanrawatjalan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listtindakanrawatjalan').setGridParam({postData:{'myid2':id2,'idpuskesmas':idpuskesmas}})
			}		
		}).navGrid('#pagert_tindakanrawatjalan',{search:false});

		jQuery("#listalergirawatjalan").jqGrid({
			url:'t_kesehatan_ibu_dan_anak/t_alergixml', 
			emptyrecords: 'Nothing to display',
			datatype: "xml",
			colNames:['Kode Obat','Obat'],
			rownumbers:true,
			width: 1049,
			height: 'auto',
			mtype: 'POST',
			altRows : true,
			colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_alergirawatjalan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PASIEN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listalergirawatjalan').setGridParam({postData:{'myid4':id4,'idpuskesmas':idpuskesmas}})
			}			
		}).navGrid('#pagert_alergirawatjalan',{search:false});
		
		jQuery("#listobatrawatjalan").jqGrid({
			url:'t_kesehatan_ibu_dan_anak/t_obatxml', 
			emptyrecords: 'Nothing to display',
			datatype: "xml",
			colNames:['Kode Obat','Obat', 'Dosis','Harga','Jumlah'],
			rownumbers:true,
			width: 1049,
			height: 'auto',
			mtype: 'POST',
			altRows : true,
			colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}, 
			{name:'dosis',index:'dosis', width:81}, 
			{name:'harga',index:'harga', width:81},
			{name:'jumlah',index:'jumlah', width:51,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_obatrawatjalan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id3='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listobatrawatjalan').setGridParam({postData:{'myid3':id3,'idpuskesmas':idpuskesmas}})
			}		
		}).navGrid('#pagert_obatrawatjalan',{search:false});

});
</script>
<script>
	$('#backlisttransaksi_pemeriksaanneonatus').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kunjungan Ibu Bersalin</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksi_pemeriksaanneonatus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kunjungan Ibu Bersalin</label>
		<input type="text" placeholder="Otomatis" readonly name="kodebersalin" id="kodebersalin" value="" />
		</span>
		<span>
		<label>Tanggal Kunjungan</label>
		<input type="text" readonly name="tglkunjungan" id="tglkunjungan" value="<?=$data->TANGGAL_PERSALINAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jam Kelahiran</label>
		<input type="text" readonly name="jam_kelahiran" id="kunjunganke" value="<?=$data->JAM_KELAHIRAN?>" />
		</span>
		<span>
		<label>Umur Kehamilan</label>
		<input type="text" readonly name="beratbadan" id="beratbadan" value="<?=$data->UMUR_KEHAMILAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Persalinan</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->CARA_PERSALINAN?>" />
		</span>
		<span>
		<label>Jenis Kelahiran</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->JENIS_KELAHIRAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bayi</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->JML_BAYI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keadaan Ibu</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->KEADAAN_KESEHATAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Status Hamil</label>
	<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->STATUS_HAMIL?>" />
		</span>
	</fieldset>
		
<div class="subformtitle">Bayi saat Lahir</div>
        <fieldset>
		<span>
		<label>Anak Ke</label>
		<input type="text" name="anak_ke" id="tempat_lahirt_pendaftaranadd" value="<?=$data->ANAK_KE?>"  />		
		</span>
		<span>
		<label>Panjang Badan(cm)</label>
		<input type="text" name="panjang_badan" id="tempat_lahirt_pendaftaranadd" value="<?=$data->PANJANG_BADAN?>" required  />		
		</span>	
	</fieldset>
	 <fieldset>
		<span>
		<label>Berat Lahir (gram)</label>
		<input type="text" name="berat_lahir" id="tempat_lahirt_pendaftaranadd" value="<?=$data->BERAT_LAHIR?>" required  />		
		</span>	
		<span>
		<label>Lingkar Kepala(cm)</label>
		<input type="text" name="lingkar_kepala" id="tempat_lahirt_pendaftaranadd" value="<?=$data->LINGKAR_KEPALA?>" required  />		
		</span>	
	</fieldset>
        <fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="text" name="berat_lahir" id="" value="<?=$data->JENIS_KELAMIN?>" required  />
		</span>
	</fieldset>
	<br/>
	<div class="paddinggrid">
		<table id="listkeadaanbayi"></table>
		<div id="pagert_keadaanbayi"></div>
	</div>
	<br/>
	<div class="paddinggrid">
		<table id="listasuhanbayi"></table>
		<div id="pagert_asuhanbayi"></div>
	</div>
	<br/>
	<div class="subformtitle">Diagnosa</div>
	<div class="paddinggrid">
	<table id="listdiagnosarawatjalan"></table>
	<div id="pagert_diagnosarawatjalan"></div>
	</div>
	
	<div class="subformtitle">Tindakan</div>
		<div class="paddinggrid">
		<table id="listtindakanrawatjalan"></table>
		<div id="pagert_tindakanrawatjalan"></div>
		</div>
	<div class="subformtitle">Pemberian Obat / Vitamin</div>
	<br/>
		<div class="subformtitle">Alergi</div>
		<div class="paddinggrid">
		<table id="listalergirawatjalan"></table>
		<div id="pagert_alergirawatjalan"></div>
		</div>
	<br/>
		<div class="subformtitle">Obat</div>
		<div class="paddinggrid">
		<table id="listobatrawatjalan"></table>
		<div id="pagert_obatrawatjalan"></div>
	</div>
	<fieldset>
		<span>
		<label>Nama Pemeriksa</label>
		<input type="text" readonly name="nama_pemeriksa" id="nama_pemeriksa" value="<?=$data->DOKTER_PEMERIKSA?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Petugas</label>
		<input type="text" readonly name="nama_petugas" id="nama_petugas" value="<?=$data->DOKTER_PETUGAS?>" readonly />
		</span>
	</fieldset>
	
</form>
</div >
