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
		jQuery("#listt_pemeriksaan_kesehatan_anak_penyakit").jqGrid({ 
		url:'t_pemeriksaan_kesehatan_anak/t_penyakitxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Penyakit','Penyakit', 'Jenis Kasus','Jenis Diagnosa'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
			{name:'kd_penyakit',index:'kd_penyakit', width:55,align:'center'}, 
			{name:'penyakit',index:'penyakit', width:801}, 
			{name:'jenis_kasus',index:'jenis_kasus', width:81}, 
			{name:'jenis_diagnosa',index:'jenis_diagnosa', width:81}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_kesehatan_anak_penyakit'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id='<?=$data->KD_PELAYANAN?>';
				$('#listt_pemeriksaan_kesehatan_anak_penyakit').setGridParam({postData:{'myid':id}})
			}			
	}).navGrid('#pagert_pemeriksaan_kesehatan_anak_penyakit',{search:false,edit:false,add:false,del:false});
	
	jQuery("#listt_pemeriksaan_kesehatan_anak_tindakan").jqGrid({ 
		url:'t_pemeriksaan_kesehatan_anak/t_tindakanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Tindakan','Tindakan', 'Harga','Jumlah','Keterangan'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_tindakan',index:'kd_tindakan', width:60}, 
				{name:'tindakan',index:'tindakan', width:465}, 
				{name:'harga',index:'harga', width:81}, 
				{name:'jumlah',index:'jumlah', width:51,align:'center'},
				{name:'keterangan',index:'keterangan', width:400}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_kesehatan_anak_tindakan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				$('#listt_pemeriksaan_kesehatan_anak_tindakan').setGridParam({postData:{'myid2':id2}})
			}			
	}).navGrid('#pagert_pemeriksaan_kesehatan_anak_tindakan',{search:false});
	
	jQuery("#listt_pemeriksaan_kesehatan_anak_obat").jqGrid({ 
		url:'t_pemeriksaan_kesehatan_anak/t_obatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode Obat','Obat', 'Dosis','Harga','Jumlah'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
				{name:'obat',index:'obat', width:300}, 
				{name:'dosis',index:'dosis', width:81}, 
				{name:'harga',index:'harga', width:81},
				{name:'jumlah',index:'jumlah', width:51,align:'center'}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_kesehatan_anak_obat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id3='<?=$data->KD_PELAYANAN?>';
				$('#listt_pemeriksaan_kesehatan_anak_obat').setGridParam({postData:{'myid3':id3}})
			}			
	}).navGrid('#pagert_pemeriksaan_kesehatan_anak_obat',{search:false});
	
	jQuery("#listt_pemeriksaan_kesehatan_anak_alergi").jqGrid({ 
		url:'t_pemeriksaan_kesehatan_anak/t_alergixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode Obat','Obat'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,	
		colModel:[ 
				{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
				{name:'obat',index:'obat', width:300}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_kesehatan_anak_alergi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PASIEN?>';
				$('#listt_pemeriksaan_kesehatan_anak_alergi').setGridParam({postData:{'myid4':id4}})
			}			
	}).navGrid('#pagert_pemeriksaan_kesehatan_anak_alergi',{search:false});
		
	
});

</script>
<script>
		$('#backlistt_pemeriksaan_kesehatan_anak').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Pemeriksaan Anak</div>
<div class="backbutton"><span class="kembali" id="backlistt_pemeriksaan_kesehatan_anak">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pemeriksaan_kesehatan_anak_detail" method="post" enctype="multipart/form-data">
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal Pelayanan</label>
		<input type="text" name="tgl_periksa" id="tgl_periksa" value="<?=$data->TANGGAL_KUNJUNGAN?>" readonly />
		<input type="hidden" name="id" id="kd_pemeriksaan_anak" value="<?=$data->KD_PEMERIKSAAN_ANAK?>" />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Diagnosa</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_kesehatan_anak_penyakit"></table>
	<div id="pagert_pemeriksaan_kesehatan_anak_penyakit"></div>
	</div>
	<br/>
	<div class="subformtitle">Tindakan</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_kesehatan_anak_tindakan"></table>
	<div id="pagert_pemeriksaan_kesehatan_anak_tindakan"></div>
	</div>
	<br/>
	<div class="subformtitle">Alergi</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_kesehatan_anak_alergi"></table>
	<div id="pagert_pemeriksaan_kesehatan_anak_alergi"></div>
	</div>
	<br/>
	<div class="subformtitle">Obat</div>
	<div class="paddinggrid">
	<table id="listt_pemeriksaan_kesehatan_anak_obat"></table>
	<div id="pagert_pemeriksaan_kesehatan_anak_obat"></div>
	</div>
	<br/>
	<fieldset>
		<span>
		<label>Nama Pemeriksa</label>
		<input type="text" readonly name="kolom_nama_pemeriksa" id="kolom_nama_pemeriksa" value="<?=$data->DOKTER?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Petugas</label>
		<input type="text" readonly name="kolom_nama_petugas" id="kolom_nama_petugas" value="<?=$data->PETUGAS?>" />
		</span>
	</fieldset>
</form>
</div >