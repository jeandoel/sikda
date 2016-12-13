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
	jQuery("#listt_tindakan_anak").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_tindakan_anakxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD PEMERIKSAAN ANAK','Tindakan','Keterangan'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'tindakan',index:'tindakan', width:465}, 
				{name:'keterangan',index:'keterangan', width:400}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_tindakan_anak'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id='<?=$data->KD_PEMERIKSAAN_NEONATUS?>';
				$('#listt_tindakan_anak').setGridParam({postData:{'myid':id}})
			}			
	}).navGrid('#pagert_tindakan_anak',{search:false});
	
	jQuery("#listt_tindakan_ibu").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_tindakan_ibuxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Tindakan', 'Harga','Jumlah'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
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
				id2='<?=$data->KD_PEMERIKSAAN_NEONATUS?>';
				$('#listt_tindakan_ibu').setGridParam({postData:{'myid2':id2}})
			}			
	}).navGrid('#pagert_tindakan_ibu',{search:false});
	
	jQuery("#listt_pemeriksaan_neonatus_obat").jqGrid({ 
		url:'t_pemeriksaan_neonatus/t_obatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['KD PEMERIKSAAN ANAK','Obat','Harga','Jumlah'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id3',index:'id3', width:5,hidden:true},
				{name:'obat',index:'obat', width:300}, 
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
				$('#listt_pemeriksaan_neonatus_obat').setGridParam({postData:{'myid3':id3}})
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
				{name:'id4',index:'id4', width:5,hidden:true},
				{name:'kd_obat',index:'kd_obat', width:155,align:'center'}, 
				{name:'obat',index:'obat', width:100}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_pemeriksaan_neonatus_alergi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PASIEN?>';
				$('#listt_pemeriksaan_neonatus_alergi').setGridParam({postData:{'myid4':id4}})
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
		<label>Kode Pemeriksaan Neonatus</label>
		<input type="text" placeholder="Otomatis" readonly name="kodepemeriksaanneonatus" id="kodepemeriksaanneonatus" value="" />
		<input type="hidden" readonly name="id" id="kodepemeriksaanneonatus" value="<?=$data->KD_PEMERIKSAAN_NEONATUS?>" />
		</span>
	</fieldset>
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
		<input type="text" readonly name="pemeriksa" id="pemeriksa" value="<?=$data->dokter_pemeriksa?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Petugas</label>
		<input type="text" readonly name="petugas" id="petugas" value="<?=$data->dokter_petugas?>" />
		</span>
	</fieldset>
</form>
</div >
