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
		$('#form1t_pelayanan_nifas_edit').ajaxForm({
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
					$.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
					$("#t203","#tabs").empty();
					$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
				}
			}
		});
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
				$('#listdiagnosarawatjalan').setGridParam({postData:{'myid1':id1}})
			}	
	}).navGrid('#pagert_diagnosarawatjalan',{search:false,edit:false,add:false,del:false});
	var diagnosatid = 0;
		$('#tambahdiagnosaid').click(function(){
			if($('#icdsearch_tmpval').val()){
				var myfirstrow = {kd_penyakit:$('#icdsearch_tmpval').val(), penyakit:$('#icdsearch_tmptext').val(), jenis_kasus:$('#selectjeniskasusid').val(), jenis_diagnosa:$('#selectjenisdiagnosaid').val()};
				jQuery("#listdiagnosarawatjalan").addRowData(diagnosatid+1, myfirstrow);
				$('#icdsearch').val('');
				$('#icdsearch_tmptext').val('');
				$('#icdsearch_tmpval').val('');
				if(confirm('Tambah Data Diagnosa Lain?')){
					$('#icdsearch').focus();					
				}else{
					$('#produktindakansearch').focus();
				}
			}else{
				alert('Silahkan Pilih Diagnosa.');
			}
		})
		$('#hapusdiagnosaid').click(function(){
		jQuery("#listdiagnosarawatjalan").clearGridData();
	})
	
	jQuery("#listt_kunjungan_tindakan").jqGrid({ 
		url:'t_kunjungan_nifas/t_tindakannifasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Tindakan','Tindakan', 'Harga','Keterangan','Jumlah'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_tindakan',index:'kd_tindakan', width:60}, 
				{name:'tindakannifas',index:'tindakannifas', width:465}, 
				{name:'harganifas',index:'harganifas', width:81}, 
				{name:'keterangannifas',index:'keterangannifas', width:400},
				{name:'total',index:'total', width:80,hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_kunjungan_nifas_tindakan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				$('#listt_kunjungan_tindakan').setGridParam({postData:{'myid2':id2}})
			}			
	}).navGrid('#pagert_kunjungan_nifas_tindakan',{search:false});
	
	jQuery("#listt_kunjungan_nifas_obat").jqGrid({ 
		url:'t_kunjungan_nifas/t_obatnifasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml",
		colNames:['Kode Obat','Obat','Harga','Jumlah','Dosis'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				
				{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
				{name:'obat',index:'obat', width:300},    
				{name:'hargaobt',index:'hargaobt', width:81},
				{name:'jumlah',index:'jumlah', width:51,align:'center'},
				{name:'dosis',index:'dosis', width:300,hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_kunjungan_nifas_obat'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id3='<?=$data->KD_PELAYANAN?>';
				$('#listt_kunjungan_nifas_obat').setGridParam({postData:{'myid3':id3}})
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
				{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
				{name:'obat',index:'obat', width:300}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagert_kunjungan_nifas_alergi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				id4='<?=$data->KD_PASIEN?>';
				$('#listt_kunjugan_nifas_alergi').setGridParam({postData:{'myid4':id4}})
			}			
	}).navGrid('#pagert_kunjungan_nifas_alergi',{search:false});
	
var tindakanid = 0;
		$('#tambahtindakanidnifas').click(function(){
			if($('#tindakansearch_tmpval').val()){
				if($('#kuantitastindakanidnifas').val()==''){
					alert("Silahkan Isi Kolom 'Qty'");
					$('#kuantitastindakanidnifas').focus();return false;
				}
				var myfirstrow = {kd_tindakan:$('#tindakansearch_tmpval').val(), tindakannifas:$('#tindakansearch_tmptext').val(), harganifas:$('#hargatindakanidnifas').val(), total:$('#kuantitastindakanidnifas').val(), keterangannifas:$('#keterangantindakanidnifas').val()};
				jQuery("#listt_kunjungan_tindakan").addRowData(tindakanid+1, myfirstrow);
				$('#tindakansearch').val('');
				$('#keterangantindakanidnifas').val('');
				$('#hargatindakanidnifas').val('');
				$('#kuantitastindakanidnifas').val('');
				$('#tindakansearch_tmptext').val('');
				$('#tindakansearch_tmpval').val('');
				if(confirm('Tambah Data Diagnosa Lain?')){
					$('#tindakansearch').focus();					
				}else{
					$('#alergiobatselectidnifas').focus();
					$('#alergiobatselectidnifas').css('outline-color', 'yellow');
					$('#alergiobatselectidnifas').css('outline-style', 'solid');
					$('#alergiobatselectidnifas').css('outline-width', 'thick');
				}
			}else{
				alert('Silahkan Pilih Tindakan.');
			}
		});				
		
		var obatid1 = 0;
		$('#tambahobatidnifas').click(function(){
			if($('#obat_tmpval').val()){
				if($('#kuantitasobatid').val()==''){
					alert("Silahkan Isi Kolom 'Qty'");
					$('#kuantitasobatid').focus();return false;
				}
				var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), dosis:$('#dosisobatid').val(), jumlah:$('#kuantitasobatid').val(), satuan:$('#satuan_obatid').val(), hargaobt:$('#hargaobattmpidnifas').val()};
				jQuery("#listt_kunjungan_nifas_obat").addRowData(obatid1+1, myfirstrow);
				$('#obatsearchnifas').val('');
				$('#dosisobatid').val('');
				$('#kuantitasobatid').val('');
				$('#satuan_obatid').val('');
				$('#obat_tmptext').val('');
				$('#obat_tmpval').val('');
				$('#hargaobattmpidnifas').val('');
				if(confirm('Tambah Obat Lain?')){
					$('#obatsearchnifas').focus();					
				}else{
					$('#statuskeluarid').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})
				
		var obatalergiid1 = 0;
		$('#tambahobatalergiidnifas').click(function(){
			if($('#obat_tmpvalalergi').val()){
				var myfirstrow = {kd_obat:$('#obat_tmpvalalergi').val(), obat:$('#obat_tmptextalergi').val()};
				jQuery("#listt_kunjugan_nifas_alergi").addRowData(obatalergiid1+1, myfirstrow);
				$('#obatsearchalerginifas').val('');
				$('#obat_tmptextalergi').val('');
				$('#obat_tmpvalalergi').val('');
				if(confirm('Tambah Data Alergi Obat Lain?')){
					$('#obatsearchalerginifas').focus();					
				}else{
					$('#obatsearchnifas').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})	
					
		$('#hapustindakanidnifas').click(function(){
			jQuery("#listt_kunjungan_tindakan").clearGridData();
		})
		
		$('#hapusobatidnifas').click(function(){
			jQuery("#listt_kunjungan_nifas_obat").clearGridData();
		})
		
		$('#hapusobatalergiidnifas').click(function(){
		jQuery("#listt_kunjugan_nifas_alergi").clearGridData();
		})
});

$.widget( "custom.catcomplete", $.ui.autocomplete, {
	_renderMenu: function( ul, items ) {
		var that = this,
		currentCategory = "";
		$.each( items, function( index, item ) {
		if ( item.category != currentCategory ) {
			ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
			currentCategory = item.category;
		}
			that._renderItemData( ul, item );
		});
	}
});

$('#form1t_pelayanan_nifas_edit :submit').click(function(e) {
e.preventDefault();
	if($("#form1t_pelayanan_nifas_edit").valid()) {
		if(kumpularray())$('#form1t_pelayanan_nifas_edit').submit();
	}
	return false;
});	

$( "#icdsearch" ).catcomplete({
	source: "t_pelayanan/icdsource",
	minLength: 2,
	select: function( event, ui ) {
	//log( ui.item ?"Selected: " + ui.item.value + " aka " + ui.item.id :"Nothing selected, input was " + this.value );
		$('#icdsearch_tmpval').val(ui.item.id);
		$('#icdsearch_tmptext').val(ui.item.label);
		//$('#selectjeniskasusid').focus();
	}
});
$( "#obatsearchnifas" ).catcomplete({
	source: "t_pelayanan/obatsource",
	minLength: 1,
	select: function( event, ui ) {
		var lb = ui.item.label.split("=>");
		var lb1 = lb[1].split(':');
		if(parseInt(lb1[1])<1){alert('Maaf Stok Obat Kosong, Silahkan Pilih Obat Lain');$( "#obatsearchnifas" ).val('');$( "#obat_tmptextnostock" ).val('no');return false;}
			else{
			var lb2 = lb[2].split(':');
			$('#hargaobattmpidnifas').val(lb2[1]);
			$('#obat_tmpval').val(ui.item.id);
			$('#obat_tmptext').val(lb[0]);
		
		
		}
	}
});

$( "#obatsearchalerginifas" ).catcomplete({
	source: "t_pelayanan/obatsource_alergi",
	minLength: 1,
	select: function( event, ui ) {
		$('#obat_tmpvalalergi').val(ui.item.id);
		$('#obat_tmptextalergi').val(ui.item.label);
	}
});

var searchdataproduk = <?=$dataproduktindakan?>;
$( "#tindakansearch" ).catcomplete({
	delay: 0,
	source: searchdataproduk,
	select: function( event, ui ) {
		var lb = ui.item.label.split("=>");
		var lb1 = lb[1].split(':');
		$('#hargatindakanidnifas').val(lb1[1]);
		$('#tindakansearch_tmpval').val(ui.item.id);
		$('#tindakansearch_tmptext').val(lb[0]);
	}
});
</script>
<script>
	function kumpularray(){

		if($('#listdiagnosarawatjalan').getGridParam("records")>0){
			var rows= jQuery("#listdiagnosarawatjalan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#diagnosa_final").val(JSON.stringify(paras));
		}
		if($('#listt_kunjungan_tindakan').getGridParam("records")>0){
			var rows= jQuery("#listt_kunjungan_tindakan").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#tindakan_final").val(JSON.stringify(paras));
		}
		
		if($('#listt_kunjungan_nifas_obat').getGridParam("records")>0){
			var rows= jQuery("#listt_kunjungan_nifas_obat").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obat_final").val(JSON.stringify(paras));
		}
		
		if($('#listt_kunjugan_nifas_alergi').getGridParam("records")>0){
			var rows= jQuery("#listt_kunjugan_nifas_alergi").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#alergi_final").val(JSON.stringify(paras));
		}
		
		return true;
				
	}
</script>
<script>
	$('#backlistt_kunjungan_nifas').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>

<div class="mycontent">
<div class="formtitle">Check Kunjungan Nifas</div>
<div class="backbutton"><span class="kembali" id="backlistt_kunjungan_nifas">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" id="form1t_pelayanan_nifas_edit"  enctype="multipart/form-data" action="<?=site_url('t_kunjungan_nifas/editprocess')?>">
		
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" readonly name="tanggal_daftar" id="tanggal" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		<input type="hidden" name="kdnifas" id="textid" value="<?=$data->KD_KUNJUNGAN_NIFAS?>" />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->ID_KUNJUNGAN?>" />
		<input type="hidden" name="kd_pelayanan_hidden" id="textid" value="<?=$data->KD_PELAYANAN?>" />
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
	<fieldset>
		<?=getComboDokterPemeriksa($data->PEMERIKSA,'pemeriksa','pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboDokterPetugas($data->PETUGAS,'petugas','petugas','required','inline')?>
	</fieldset>
	<fieldset>
		<span>
		<label>Status Hamil</label>
		<input type="text" readonly name="stat_hamil" id="stat_hamil" value="<?=$data->KD_STATUS_HAMIL?>" />
		</span>
	</fieldset>
	<br/>
	<br/>
	<div class="subformtitle">Diagnosa</div>
	<div class="paddinggrid">
	<table id="listdiagnosarawatjalan"></table>
	<div id="pagert_diagnosarawatjalan"></div>
	</div>
	<fieldset id="fieldsdiagnosarawatjalan">
		<span>
		<label class="declabel2">Cari Jenis Penyakit / ICD10</label>
		<input type="text" name="text" value="" id="icdsearch" style="width:255px;" />
		</span>
		<span>
		<label class="declabel">Jenis Kasus</label>
		<select class="decinput" name="selectjeniskasus" id="selectjeniskasusid">
			<option value="Baru">Kasus Baru</option>
			<option value="Lama">Kasus Lama</option>
		</select>
		</span>	
		<span>
		<label class="decinput">Jenis Diagnosa</label>
		<select class="decinput" name="selectjenisdiagnosa" id="selectjenisdiagnosaid">
			<option value="Primer">Primer</option>
			<option value="Sekunder">Sekunder</option>
			<option value="Komplikasi">Komplikasi</option>
		</select>
		<input type="hidden" name="icdsearch_tmpval" id="icdsearch_tmpval" />
		<input type="hidden" name="icdsearch_tmptext" id="icdsearch_tmptext" />
		<input type="button" value="Tambah" id="tambahdiagnosaid" />
		<input type="button" id="hapusdiagnosaid" value="Hapus" />
		</span>
	</fieldset>
	<div class="subformtitle">Tindakan</div>
		<div class="paddinggrid">
		<table id="listt_kunjungan_tindakan"></table>
		<div id="pagert_kunjungan_nifas_tindakan"></div>
		</div>
	<fieldset id="fieldstindakan">
		<span>
			<label class="declabel2">Cari Tindakan</label>
			<input type="text" name="tindakannifas" value="" id="tindakansearch" style="width:255px;" />
		</span>
		<span>
			<label class="declabel">Harga</label>
			<input type="text" name="hargatindakan" id="hargatindakanidnifas" style="width:101px" />
		</span>	
		<span>
			<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitastindakanidnifas" style="width:39px" />
			<input type="hidden" name="tindakansearch_tmpval" id="tindakansearch_tmpval" />
			<input type="hidden" name="tindakansearch_tmptext" id="tindakansearch_tmptext" />		
		</span>
		<br/>
		<span>
			<label class="declabel2">Keterangan Tindakan</label>
			<input type="text" name="keterangannifas" id="keterangantindakanidnifas" style="width:583px" />
			<input type="hidden" name="tindakan_final" id="tindakan_final" />
			<input type="button" value="Tambah" id="tambahtindakanidnifas" />
			<input type="button" value="Hapus" id="hapustindakanidnifas" />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Alergi</div>
	<div class="paddinggrid">
	<table id="listt_kunjugan_nifas_alergi"></table>
	<div id="pagert_kunjungan_nifas_alergi"></div>
	</div>
	<fieldset id="fieldstindakanrawatjalanalergi">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearchalerginifas" style="width:255px;" />
		<input type="hidden" name="obat_tmpvalalergi" id="obat_tmpvalalergi" />
			<input type="hidden" name="obat_tmptextalergi" id="obat_tmptextalergi" />
			<input type="hidden" name="alergi_final" id="alergi_final" />
			<input type="button" value="Tambah" id="tambahobatalergiidnifas" />
			<input type="button" value="Hapus" id="hapusobatalergiidnifas" />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle">Obat</div>
	<div class="paddinggrid">
	<table id="listt_kunjungan_nifas_obat"></table>
	<div id="pagert_kunjungan_nifas_obat"></div>
	</div>
	<fieldset id="fieldstindakanrawatjalan">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearchnifas" style="width:255px;" />
		</span>
		<span>
		<label style="width:77px">Aturan Pakai</label>
			<input type="text" name="hargatindakan" id="dosisobatid" style="width:55px" />
		</span>
		<?=getComboSatuan('','satuan_obat','satuan_obatid','','inline')?>
		<span>
		<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitasobatid"  style="width:39px" />
			<input type="hidden" name="obat_tmpval" id="obat_tmpval" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptext" />
			<input type="hidden" name="hargaobattmpidnifas" id="hargaobattmpidnifas" />
			<input type="hidden" name="obat_tmptextnostock" id="obat_tmptextnostock" />
			<input type="button" value="Tambah" id="tambahobatidnifas" />
			<input type="button" value="Hapus" id="hapusobatidnifas" />
			
			<input type="hidden" name="obat_final" id="obat_final" />
			<input type="hidden" name="diagnosa_final" id="diagnosa_final" />
			
		</span>		
	</fieldset>
	</br>
	<div class="subformtitle">Keterangan</div>
	<fieldset>
		<span>
		<label>Catatan Apotek</label>
		<textarea type="text" readonly name="komentar" id="komentar_id" disabled=disabled rows="auto" cols="26"> <?=$data->CATATAN_APOTEK?> </textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Catatan Dokter</label>
		<textarea type="text"  name="catatan_dokter" id=""  rows="auto" cols="26"></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
	
</form>
</div >