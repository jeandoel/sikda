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
				var idpuskesmas='<?=$data->KD_PUSKESMAS?>';
				$('#listdiagnosarawatjalan').setGridParam({postData:{'myid1':id1, 'idpuskesmas':idpuskesmas}})
			}	
	}).navGrid('#pagert_diagnosarawatjalan',{search:false,edit:false,add:false,del:false});
	
	jQuery("#listt_bumil_tindakan").jqGrid({ 
		url:'t_kunjungan_ibu_hamil/t_tindakanxml', 
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
			pager: jQuery('#pagert_bumil_tindakan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas='<?=$data->KD_PUSKESMAS?>';
				$('#listt_bumil_tindakan').setGridParam({postData:{'myid2':id2, 'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_bumil_tindakan',{search:false});
	
	jQuery("#listt_bumil_obat").jqGrid({ 
		url:'t_kunjungan_ibu_hamil/t_obatxml', 
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
			pager: jQuery('#pagert_bumil_obat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id3='<?=$data->KD_PELAYANAN?>';
				var idpuskesmas='<?=$data->KD_PUSKESMAS?>';
				$('#listt_bumil_obat').setGridParam({postData:{'myid3':id3, 'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_bumil_obat',{search:false});
	
	jQuery("#listt_bumil_alergi").jqGrid({ 
		url:'t_kunjungan_ibu_hamil/t_alergixml', 
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
			pager: jQuery('#pagert_bumil_alergi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PASIEN?>';
				var idpuskesmas='<?=$data->KD_PUSKESMAS?>';
				$('#listt_bumil_alergi').setGridParam({postData:{'myid4':id4, 'idpuskesmas':idpuskesmas}})
			}			
	}).navGrid('#pagert_bumil_alergi',{search:false});
		
	
});

</script>
<script>
	$('#backlistt_kunjungan_bumil').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kunjungan Ibu Hamil</div>
<div class="backbutton"><span class="kembali" id="backlistt_kunjungan_bumil">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_kunjungan_bumil_detail" method="post" enctype="multipart/form-data">
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal Kunjungan</label>
		<input type="text" readonly name="tgl_kunjungan" id="tgl_kunjungan" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		<input type="hidden" name="id" id="kd_bumil" value="<?=$data->KD_KUNJUNGAN_BUMIL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kunjungan Ke</label>
		<input type="text" name="kunjungan_ke" id="kunjungan_ke" value="<?=$data->KUNJUNGAN_KE?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keluhan</label>
		<textarea name="keluhan" id="keluhan" rows="auto" cols="23" readonly><?=$data->KELUHAN?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Lingkar Lengan Atas</label>
		<input type="text" name="lila" id="lila"  value="<?=$data->LILA?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tekanan Darah (mmHg)</label>
		<input type="text" name="tekanan_darah" id="tekanan_darah"  value="<?=$data->TEKANAN_DARAH?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Badan (Kg)</label>
		<input type="text" name="berat_badan" id="berat_badan"  value="<?=$data->BERAT_BADAN?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tinggi Badan (Cm)</label>
		<input type="text" name="tinggi_badan" id="tinggi_badan"  value="<?=isset($data->TINGGI_BADAN)?$data->TINGGI_BADAN:''?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Umur Kehamilan (minggu)</label>
		<input type="text" name="umur_hamil" id="umur_hamil"  value="<?=$data->UMUR_KEHAMILAN?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tinggi Fundus (cm)</label>
		<input type="text" name="tinggi_fundus" id="tinggi_fundus"  value="<?=$data->TINGGI_FUNDUS?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Letak Janin</label>
		<input type="text" name="letak_janin" id="letak_janin"  value="<?=$data->LETAK_JANIN?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Denyut Jantung Janin per Menit</label>
		<input type="text" name="denyut_jantung" id="denyut_jantung"  value="<?=$data->DENYUT_JANTUNG?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Kaki Bengkak</label>
		<input type="text" name="kaki_bengkak" id="kaki_bengkak"  value="<?=$data->KAKI_BENGKAK?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Lab Darah HB (gram%)</label>
		<input type="text" name="lab_darah" id="lab_darah"  value="<?=$data->LAB_DARAH_HB?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Lab Urine Reduksi</label>
		<input type="text" name="lab_urin_reduksi" id="lab_urin_reduksi"  value="<?=$data->LAB_URIN_REDUKSI?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Lab Urine Protein</label>
		<input type="text" name="lab_urin_protein" id="lab_urin_protein"  value="<?=$data->LAB_URIN_PROTEIN?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Status Hamil</label>
		<input type="text" name="status_hamil" id="status_hamil"  value="<?=$data->STATUS_HAMIL?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nasehat yang Disampaikan</label>
		<textarea type="text" name="nasehat" id="nasehat" rows="auto" cols="23" readonly ><?=$data->NASEHAT?></textarea>
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
		<table id="listt_bumil_tindakan"></table>
		<div id="pagert_bumil_tindakan"></div>
		</div>
	<br/>
		<div class="subformtitle">Alergi</div>
		<div class="paddinggrid">
		<table id="listt_bumil_alergi"></table>
		<div id="pagert_bumil_alergi"></div>
		</div>
	<br/>
		<div class="subformtitle">Obat</div>
		<div class="paddinggrid">
		<table id="listt_bumil_obat"></table>
		<div id="pagert_bumil_obat"></div>
	</div>
	<br/>
	<fieldset>
		<span>
		<label>Nama Pemeriksa</label>
		<input type="text" readonly name="nama_pemeriksa" id="nama_pemeriksa" value="<?=$data->DOKTER?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Petugas</label>
		<input type="text" readonly name="nama_petugas" id="nama_petugas" value="<?=$data->PETUGAS?>" readonly />
		</span>
	</fieldset>
</form>
</div >