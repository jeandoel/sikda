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
	
	jQuery("#listt_kunjungan_tindakan").jqGrid({ 
		url:'t_kunjungan_nifas/t_tindakannifasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Tindakan','Tindakan', 'Harga','Keterangan'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id2',index:'id2', width:60}, 
				{name:'tindakan',index:'tindakan', width:465}, 
				{name:'harga',index:'harga', width:81}, 
				{name:'keterangan',index:'keterangan', width:400}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_kunjungan_nifas_tindakan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listt_kunjungan_tindakan').setGridParam({postData:{'myid2':id2,'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_kunjungan_nifas_tindakan',{search:false});
	
	jQuery("#listt_kunjungan_nifas_obat").jqGrid({ 
		url:'t_kunjungan_nifas/t_obatnifasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode Obat','Obat','Harga','Jumlah'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				
				{name:'id3',index:'id3', width:55,align:'center'}, 
				{name:'obat',index:'obat', width:300},  
				{name:'hargaobt',index:'hargaobt', width:81},
				{name:'jumlah',index:'jumlah', width:51,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_kunjungan_nifas_obat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id3='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listt_kunjungan_nifas_obat').setGridParam({postData:{'myid3':id3,'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_kunjungan_nifas_obat',{search:false});
	
	jQuery("#listt_kunjugan_nifas_alergi").jqGrid({ 
		url:'t_kunjungan_nifas/t_alerginifasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['kd obat','Obat'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,	
		colModel:[ 
				{name:'id4',index:'id4', width:50},
				{name:'obat',index:'obat', width:55,align:'center'}, 
				
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_kunjungan_nifas_alergi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PASIEN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listt_kunjugan_nifas_alergi').setGridParam({postData:{'myid4':id4,'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_kunjungan_nifas_alergi',{search:false});
		
	



</script>
<script>
	$('#backlistt_kunjungan_nifas').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kunjungan Nifas</div>
<div class="backbutton"><span class="kembali" id="backlistt_kunjungan_nifas">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" readonly name="tanggal_daftar" id="tanggal" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keluhan</label>
		<textarea type="text" readonly name="keluhan" id="keluhan" rows="auto" cols="28"> <?=$data->KELUHAN?> </textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tekanan Darah</label>
		<input type="text" readonly name="tekanan_darah" id="tekanan_darah" value="<?=$data->TEKANAN_DARAH?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nadi</label>
		<input type="text" readonly name="nadi" id="nadi" value="<?=$data->NADI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nafas</label>
		<input type="text" readonly name="nafas" id="nafas" value="<?=$data->NAFAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Suhu</label>
		<input type="text" readonly name="suhu" id="suhu" value="<?=$data->SUHU?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kontraksi Rahim</label>
		<input type="text" readonly name="kontraksi" id="kontraksi" value="<?=$data->KONTRAKSI_RAHIM?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Perdarahan</label>
		<input type="text" readonly name="perdarahan" id="perdarahan" value="<?=$data->PERDARAHAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Warna Lokhia</label>
		<input type="text" readonly name="warna_lokhia" id="warna_lokhia" value="<?=$data->WARNA_LOKHIA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Lokhia</label>
		<input type="text" readonly name="jumlah_lokhia" id="jumlah_lokhia" value="<?=$data->JML_LOKHIA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Bau Lokhia</label>
		<input type="text" readonly name="bau_lokhia" id="bau_lokhia" value="<?=$data->BAU_LOKHIA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Buang Air Besar</label>
		<input type="text" readonly name="bab" id="bab" value="<?=$data->BUANG_AIR_BESAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Buang Air Kecil</label>
		<input type="text" readonly name="bak" id="bak" value="<?=$data->BUANG_AIR_KECIL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Produksi Asi</label>
		<input type="text" readonly name="produksi_asi" id="produksi_asi" value="<?=$data->PRODUKSI_ASI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nasehat</label>
		<textarea type="text" readonly name="nasehat" id="nasehat" rows="auto" cols="28"> <?=$data->NASEHAT?> </textarea>
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Diagnosa</div>
	<div class="paddinggrid">
	<table id="listdiagnosarawatjalan"></table>
	<div id="pagert_diagnosarawatjalan"></div>
	</div>
	<div class="subformtitle">Tindakan</div>
		<div class="paddinggrid">
		<table id="listt_kunjungan_tindakan"></table>
		<div id="pagert_kunjungan_nifas_tindakan"></div>
		</div>
	<br/>
	<fieldset>
		<span>
		<label>Nama Pemeriksa</label>
		<input type="text" readonly name="pemeriksa" id="pemeriksa" value="<?=$data->PEMERIKSA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Petugas</label>
		<input type="text" readonly name="petugas" id="petugas" value="<?=$data->PETUGAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Status Hamil</label>
		<input type="text" readonly name="stat_hamil" id="stat_hamil" value="<?=$data->KD_STATUS_HAMIL?>" />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Alergi</div>
	<div class="paddinggrid">
	<table id="listt_kunjugan_nifas_alergi"></table>
	<div id="pagert_kunjungan_nifas_alergi"></div>
	</div>
	<br/>
	<div class="subformtitle">Obat</div>
	<div class="paddinggrid">
	<table id="listt_kunjungan_nifas_obat"></table>
	<div id="pagert_kunjungan_nifas_obat"></div>
	</div>
	<br/>
	
</form>
</div >