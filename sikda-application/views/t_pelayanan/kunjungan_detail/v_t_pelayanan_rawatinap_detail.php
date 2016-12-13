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
		jQuery("#listdiagnosarawatinap").jqGrid({ 
		url:'t_pelayanan/diagnosarawatinap_xml', 
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
			pager: jQuery('#pagert_diagnosarawatinap'),
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id1='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listdiagnosarawatinap').setGridParam({postData:{'myid1':id1,'idpuskesmas':idpuskesmas}})
			}	
	}).navGrid('#pagert_diagnosarawatinap',{search:false});
	
	jQuery("#listtindakanrawatinap").jqGrid({ 
		url:'t_pelayanan/tindakanrawatinap_xml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Tindakan','Tindakan', 'Harga','Jumlah','Keterangan'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel :[ 
			{name:'kd_tindakan',index:'kd_tindakan', width:55,align:'center'}, 
			{name:'tindakan',index:'tindakan', width:300}, 
			{name:'harga',index:'harga', width:81}, 
			{name:'jumlah',index:'jumlah', width:51,align:'center'},
			{name:'keterangan',index:'keterangan', width:400}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_tindakanrawatinap'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listtindakanrawatinap').setGridParam({postData:{'myid2':id2,'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_tindakanrawatinap',{search:false});
	
	jQuery("#listalergirawatinap").jqGrid({ 
		url:'t_pelayanan/alergirawatinap_xml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode Obat','Obat'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_alergirawatinap'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id3='<?=$data->KD_PASIEN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listalergirawatinap').setGridParam({postData:{'myid3':id3,'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_alergirawatinap',{search:false});
	
	jQuery("#listobatrawatinap").jqGrid({ 
		url:'t_pelayanan/obatrawatinap_xml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode Obat','Obat', 'Dosis','Harga','Jumlah'],
		rownumbers:true,
		width: 1049,
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
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_obatrawatinap'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listobatrawatinap').setGridParam({postData:{'myid4':id4,'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_obatrawatinap',{search:false});
});
</script>

<script>
	$("#form1t_pelayananpelayanan input[name = 'batal'],#backlistt_pelayanan").click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	});
	$("#showhide_pelayananlayanan").focus();
</script>
<div class="mycontent">
<div class="backbutton"><span class="kembali" id="backlistt_pelayanan">kembali ke list</span></div>
<div class="subformtitle">Detail Rawat Inap </div>
<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal Pelayanan</label>
		<input type="text" name="text" value="<?=$data->TGL_PELAYANAN?>" disabled />
		</span>	
	</fieldset>
	<fieldset>
		<span>
		<label>Unit Pelayanan</label>
		<input type="text" name="text" value="<?=$data->UNIT?>" disabled />
		</span>	
	</fieldset>
	<fieldset>
		<span>
		<label>Kel/Jenis Pasien</label>
		<input type="text" disabled name="jenis_pasien" id="jenis_pasien" value="<?=$data->CUSTOMER?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Cara/Bayar</label>
		<input type="text" disabled name="cara_bayar" id="cara_bayar" value="<?=$data->CARA_BAYAR?>" />
		</span>
	</fieldset>
	<fieldset>		
		<span>
			<label>Anamnesa</label>
			<textarea name="anamnesa" id="anamnesa" cols="27" disabled ><?=$data->ANAMNESA?></textarea>
		</span>	
	</fieldset>
	<fieldset>	
		<span>
			<label>Catatan Fisik</label>
			<textarea name="catatan_fisik" rows="2" cols="27" disabled ><?=$data->CATATAN_FISIK?></textarea>
		</span>	
	</fieldset>
	<fieldset>		
		<span>
			<label>Catatan Dokter</label>
			<textarea name="catatan_dokter" rows="2" cols="27" disabled ><?=$data->CATATAN_DOKTER?></textarea>
		</span>			
	</fieldset>	
	
	<div class="subformtitle">Diagnosa</div>
	<div class="paddinggrid">
	<table id="listdiagnosarawatinap"></table>
	<div id="pagert_diagnosarawatinap"></div>
	</div>
	
	<div class="subformtitle">Tindakan</div>
	<div class="paddinggrid">
	<table id="listtindakanrawatinap"></table>
	<div id="pagert_tindakanrawatinap"></div>
	</div>
	
	<div class="subformtitle">Alergi Obat</div>
	<div class="paddinggrid">
	<table id="listalergirawatinap"></table>
	<div id="pagert_alergirawatinap"></div>
	</div>
	
	<div class="subformtitle">Obat</div>
	<div class="paddinggrid">
	<table id="listobatrawatinap"></table>
	<div id="pagert_obatrawatinap"></div>
	</div>
	<fieldset>
		<span>
		<label>Status Keluar Pasien</label>
		<input type="text" name="status_keluar" id="status_keluar" value="<?=$data->KEADAAN_KELUAR?>" disabled />
		</span>
	</fieldset>
</form>
</div >