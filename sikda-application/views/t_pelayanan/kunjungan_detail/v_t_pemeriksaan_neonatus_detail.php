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
	
	jQuery("#listt_tindakan_anak").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_tindakan_anakxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Tindakan','Harga','Jumlah','Keterangan'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kdprodukanak',index:'kdprodukanak', width:465,hidden:true}, 
				{name:'tindakan',index:'tindakan', width:465}, 
				{name:'Harga',index:'Harga', width:465,hidden:true}, 
				{name:'Jumlah',index:'Jumlah', width:465,hidden:true}, 
				{name:'keterangan',index:'keterangan', width:400}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_tindakan_anak'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listt_tindakan_anak').setGridParam({postData:{'myid':id,'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_tindakan_anak',{search:false});
	
	jQuery("#listt_tindakan_ibu").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_tindakan_ibuxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Tindakan', 'Harga','Jumlah'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kode',index:'kode', width:465,hidden:true}, 
				{name:'tindakan',index:'tindakan', width:465}, 
				{name:'harga',index:'harga', width:81}, 
				{name:'jumlah',index:'jumlah', width:51,align:'center'},
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_tindakan_ibu'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listt_tindakan_ibu').setGridParam({postData:{'myid2':id2,'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_tindakan_ibu',{search:false});
	
	jQuery("#listt_pemeriksaan_neonatus_obat").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_obatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode','Obat','Dosis','Harga','Jumlah'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kode',index:'kode', width:5,hidden:true},
				{name:'obat',index:'obat', width:300}, 
				{name:'dosis',index:'dosis', width:5,hidden:true},
				{name:'harga',index:'harga', width:81},
				{name:'jumlah',index:'jumlah', width:51,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_neonatus_obat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id3='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listt_pemeriksaan_neonatus_obat').setGridParam({postData:{'myid3':id3,'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_pemeriksaan_neonatus_obat',{search:false});
	
	jQuery("#listt_pemeriksaan_neonatus_alergi").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_alergixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['KD_OBAT','Nama Obat','Action'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,	
		colModel:[ 
				{name:'id4',index:'id4', width:20},
				{name:'kd_obat',index:'kd_obat', width:155,align:'center'}, 
				{name:'obat',index:'obat', width:100,hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_neonatus_alergi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PASIEN?>';
				var idpuskesmas = '<?=$data->KD_PUSKESMAS?>';
				$('#listt_pemeriksaan_neonatus_alergi').setGridParam({postData:{'myid4':id4,'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_pemeriksaan_neonatus_alergi',{search:false});
		
	
});

</script>
<script>
	$('#backlisttransaksi_pemeriksaanneonatus').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Pemeriksaan Neonatus</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksi_pemeriksaanneonatus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" readonly name="tglkunjungan" id="tglkunjungan" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kunjungan ke</label>
		<input type="text" readonly name="kunjunganke" id="kunjunganke" value="<?=$data->KUNJUNGAN_KE?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Badan (kg)</label>
		<input type="text" readonly name="beratbadan" id="beratbadan" value="<?=$data->BERAT_BADAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Panjang Badan (cm)</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->PANJANG_BADAN?>" />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Diagnosa</div>
	<div class="paddinggrid">
	<table id="listdiagnosarawatjalan"></table>
	<div id="pagert_diagnosarawatjalan"></div>
	</div>
	<div class="subformtitle">Memeriksa Bayi/Anak</div>
		<div class="paddinggrid">
		<table id="listt_tindakan_anak"></table>
		<div id="pagert_tindakan_anak"></div>
		</div>
	<br/>
	<div class="subformtitle">Tindakan Ibu</div>
		<div class="paddinggrid">
		<table id="listt_tindakan_ibu"></table>
		<div id="pagert_tindakan_ibu"></div>
		</div>
	<br/>
	<fieldset>
		<span>
		<label>Keluhan</label>
		<input type="text" readonly name="keluhan" id="keluhan" value="<?=$data->KELUHAN?>" />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Alergi</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_neonatus_alergi"></table>
	<div id="pagert_pemeriksaan_neonatus_alergi"></div>
	</div>
	<br/>
	<div class="subformtitle">Obat</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_neonatus_obat"></table>
	<div id="pagert_pemeriksaan_neonatus_obat"></div>
	</div>
	<br/>
	<fieldset>
		<span>
		<label>Pemeriksa</label>
		<input type="text" readonly name="pemeriksa" id="pemeriksa" value="<?=$data->PEMERIKSA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Petugas</label>
		<input type="text" readonly name="petugas" id="petugas" value="<?=$data->PETUGAS?>" />
		</span>
	</fieldset>
</form>
</div >
