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
	
	jQuery("#listtindakan_kb").jqGrid({ 
		url:'t_pelayanan_kb/t_pelayanan_tindakankbxml', 
		emptyrecords: 'Tidak Ada Data',
		datatype: "xml", 
		colNames:['Kode','Tindakan', 'Harga','Jumlah','Keterangan'],
		rownumbers:true,
		width: 750,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel :[ 
			{name:'kd_tindakan',index:'kd_tindakan', width:55,align:'center'},
			{name:'tindakan',index:'tindakan', width:500}, 
			{name:'harga',index:'harga', width:300}, 
			{name:'jumlah',index:'jumlah', width:100,align:'center'},
			{name:'keterangan',index:'keterangan', width:400}
			],
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listtindakan_kb').setGridParam({postData:{'myid2':id2,'idpuskesmas':idpuskesmas}})
			}	


}).navGrid('#pagert_tindakan_pelayanan_kb',{search:false});


jQuery("#listalergikb").jqGrid({ 
		url:'t_pelayanan_kb/t_pelayanan_alergiobatkbxml', 
		emptyrecords: 'Tidak Ada Data',
		datatype: "xml", 
		colNames:['Kode Obat','Obat'],
		rownumbers:true,
		width: 750,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}
			],
			beforeRequest:function(){
				id3='<?=$data->KD_PASIEN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listalergikb').setGridParam({postData:{'myid3':id3,'idpuskesmas':idpuskesmas}})
			}	


}).navGrid('#pagert_alergi_pelayanan_kb',{search:false});


jQuery("#listobatkb").jqGrid({ 
		url:'t_pelayanan_kb/t_pelayanan_obatkbxml', 
		emptyrecords: 'Tidak Ada Data',
		datatype: "xml", 
		colNames:['Kode Obat','Obat', 'Dosis','Harga','Jumlah'],
		rownumbers:true,
		width: 750,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}, 
			{name:'dosis',index:'dosis', width:81}, 
			{name:'harga',index:'harga', width:81},
			{name:'jumlah',index:'jumlah', width:51,align:'center'}
			],
			beforeRequest:function(){
				id4='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listobatkb').setGridParam({postData:{'myid4':id4,'idpuskesmas':idpuskesmas}})
			}	


}).navGrid('#pagert_obat_pelayanan_kb',{search:false});

});
</script>
<script>
	$('#backlistt_pelayanan_kb').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Pelayanan KB</div>
<div class="backbutton"><span class="kembali" id="backlistt_pelayanan_kb">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="text" readonly name="kdkunjungankb" id="kdkunjungankb" value="<?=$data->KD_KUNJUNGAN_KB?>" />
		<input type="hidden" readonly name="id" id="kdkunjungankb" value="<?=$data->KD_KUNJUNGAN_KB?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" readonly name="tanggalpemeriksaan" id="tanggalpemeriksaan" value="<?=$data->TANGGAL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis KB</label>
		<input type="text" readonly name="kdjeniskb" id="kdjeniskb" value="<?=$data->JENIS_KB?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keluhan</label>
		<input type="text" readonly name="keluhan" id="keluhan" value="<?=$data->KELUHAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Anamnese</label>
		<textarea type="text" readonly name="anamnese" id="anamnese" rows="auto" cols="26"> <?=$data->ANAMNESE?> </textarea>
		</span>
	</fieldset>
	</fieldset>
	<br/>
	<div class="subformtitle">Diagnosa</div>
	<div class="paddinggrid">
	<table id="listdiagnosarawatjalan"></table>
	<div id="pagert_diagnosarawatjalan"></div>
	</div>
		
	<div class="subformtitle">Tindakan</div>
		<div class="paddinggrid">
		<table id="listtindakan_kb"></table>
		<div id="pagert_tindakan_pelayanan_kb"></div>
		</div>
	<br/>
		<div class="subformtitle">Alergi</div>
		<div class="paddinggrid">
		<table id="listalergikb"></table>
		<div id="pagert_alergi_pelayanan_kb"></div>
		</div>
	<br/>
		<div class="subformtitle">Obat</div>
		<div class="paddinggrid">
		<table id="listobatkb"></table>
		<div id="pagert_obat_pelayanan_kb"></div>
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
	
	
</form>
</div >