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
		$('#form1t_pelayanan_kb_edit').ajaxForm({
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
	
	jQuery("#listtindakan_kb").jqGrid({ 
		url:'t_pelayanan_kb/t_pelayanan_tindakankbxml', 
		emptyrecords: 'Tidak Ada Data',
		datatype: "xml", 
		colNames:['kd_tindakan','Tindakan', 'Harga','Jumlah','Keterangan'],
		rownumbers:true,
		width: 700,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel :[ 
			{name:'kd_tindakan',index:'kd_tindakan', width:500,hidden:true}, 
			{name:'tindakan',index:'tindakan', width:500}, 
			{name:'harga',index:'harga', width:300}, 
			{name:'jumlah',index:'jumlah', width:100,align:'center'},
			{name:'keterangan',index:'keterangan', width:400}
			],
			beforeRequest:function(){
				id2='<?=$data->KD_PELAYANAN?>';
				$('#listtindakan_kb').setGridParam({postData:{'myid2':id2}})
			}	


}).navGrid('#pagert_tindakan_pelayanan_kb',{search:false});


jQuery("#listalergikb").jqGrid({ 
		url:'t_pelayanan_kb/t_pelayanan_alergiobatkbxml', 
		emptyrecords: 'Tidak Ada Data',
		datatype: "xml", 
		colNames:['Kode Obat','Obat'],
		rownumbers:true,
		width: 700,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel :[ 
			{name:'kd_obat',index:'kd_obat', width:55,align:'center'}, 
			{name:'obat',index:'obat', width:300}
			],
			beforeRequest:function(){
				id3='<?=$data->KD_PASIEN?>';
				$('#listalergikb').setGridParam({postData:{'myid3':id3}})
			}	


}).navGrid('#pagert_alergi_pelayanan_kb',{search:false});


jQuery("#listobatkb").jqGrid({ 
		url:'t_pelayanan_kb/t_pelayanan_obatkbxml', 
		emptyrecords: 'Tidak Ada Data',
		datatype: "xml", 
		colNames:['Kode Obat','Obat', 'Dosis','Harga','Jumlah'],
		rownumbers:true,
		width: 700,
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
				$('#listobatkb').setGridParam({postData:{'myid4':id4}})
			}	


}).navGrid('#pagert_obat_pelayanan_kb',{search:false});


var tindakankbid = 0;
		$('#tambahtindakankbid').click(function(){
			if($('#produktindakankbsearch_tmpval').val()){
				if($('#kuantitastindakankbid').val()==''){
					alert("Silahkan Isi Kolom 'Qty'");
					$('#kuantitastindakankbid').focus();return false;
				}
				var myfirstrow = {kd_tindakan:$('#produktindakankbsearch_tmpval').val(), tindakan:$('#produktindakankbsearch_tmptext').val(), harga:$('#hargatindakankbid').val(), jumlah:$('#kuantitastindakankbid').val(), keterangan:$('#keterangantindakankbid').val()};
				jQuery("#listtindakan_kb").addRowData(tindakankbid+1, myfirstrow);
				$('#produktindakankbsearch').val('');
				$('#keterangantindakankbid').val('');
				$('#hargatindakankbid').val('');
				$('#kuantitastindakankbid').val('');
				$('#produktindakankbsearch_tmptext').val('');
				$('#produktindakankbsearch_tmpval').val('');
				if(confirm('Tambah Data Diagnosa Lain?')){
					$('#produktindakankbsearch').focus();					
				}else{
					$('#alergiobatkbselectid').focus();
					$('#alergiobatkbselectid').css('outline-color', 'yellow');
					$('#alergiobatkbselectid').css('outline-style', 'solid');
					$('#alergiobatkbselectid').css('outline-width', 'thick');
				}
			}else{
				alert('Silahkan Pilih Tindakan.');
			}
		});
		
		
		var obatkbid = 0;
		$('#tambahobatkbid').click(function(){
			if($('#obat_tmpval').val()){
				if($('#kuantitasobatkbid').val()==''){
					alert("Silahkan Isi Kolom 'Qty'");
					$('#kuantitasobatkbid').focus();return false;
				}
				var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), dosis:$('#dosisobatkbid').val(), jumlah:$('#kuantitasobatkbid').val(), satuan:$('#satuanobatkbid').val(), harga:$('#hargaobattmpid').val()};
				jQuery("#listobatkb").addRowData(obatkbid+1, myfirstrow);
				$('#obatkbsearch').val('');
				$('#dosisobatkbid').val('');
				$('#kuantitasobatkbid').val('');
				$('#satuan_obatkbid').val('');
				$('#kuantitasobatkbid').val('');
				$('#obat_tmptext').val('');
				$('#obat_tmpval').val('');
				$('#hargaobattmpid').val('');
				if(confirm('Tambah Obat Lain?')){
					$('#obatkbsearch').focus();					
				}else{
					$('#statuskeluarid').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})
		
		
		var obatalergikbid = 0;
		$('#tambahobatalergikbid').click(function(){
			if($('#obat_tmpvalalergi').val()){
				var myfirstrow = {kd_obat:$('#obat_tmpvalalergi').val(), obat:$('#obat_tmptextalergi').val()};
				jQuery("#listalergikb").addRowData(obatalergikbid+1, myfirstrow);
				$('#obatkbsearchalergikb').val('');
				$('#obat_tmptextalergi').val('');
				$('#obat_tmpvalalergi').val('');
				if(confirm('Tambah Data Alergi Obat Lain?')){
					$('#obatkbsearchalergikb').focus();					
				}else{
					$('#obatkbsearch').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})		
		
		
		$('#hapustindakankbid').click(function(){
			jQuery("#listtindakan_kb").clearGridData();
			}) 		
		$('#hapusobatkbid').click(function(){
			jQuery("#listobatkb").clearGridData();
			})
		
		$('#hapusobatalergikbid').click(function(){
			jQuery("#listalergikb").clearGridData();
			})
			
			$("#form1t_pelayanan_kb_edit").validate({focusInvalid:true});
			
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

$('#form1t_pelayanan_kb_edit :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_pelayanan_kb_edit").valid()) {
		if(kumpularray())$('#form1t_pelayanan_kb_edit').submit();
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
$( "#obatkbsearch" ).catcomplete({
	source: "t_pelayanan_kb/obatsource",
	minLength: 2,
	select: function( event, ui ) {
		var lb = ui.item.label.split("=>");
		var lb1 = lb[1].split(':');
		if(parseInt(lb1[1])<1){alert('Maaf Stok Obat Kosong, Silahkan Pilih Obat Lain');$( "#obatkbsearch" ).val('');$( "#obat_tmptextnostock" ).val('nol');return false;}
		else{
		var lb2 = lb[2].split(':');
		
		$('#hargaobattmpid').val(lb2[1]);
		$('#obat_tmpval').val(ui.item.id);
		$('#obat_tmptext').val(lb[0]);
		
}	}
});

$( "#obatkbsearchalergikb" ).catcomplete({
	source: "t_pelayanan_kb/obatsource_alergi",
	minLength: 2,
	select: function( event, ui ) {
		$('#obat_tmpvalalergi').val(ui.item.id);
		$('#obat_tmptextalergi').val(ui.item.label);
	}
});


var searchdataproduk = <?=$dataproduktindakan?>;
$( "#produktindakankbsearch" ).catcomplete({
	delay: 0,
	source: searchdataproduk,
	select: function( event, ui ) {
		var lb = ui.item.label.split("=>");
		var lb1 = lb[1].split(':');
		$('#hargatindakankbid').val(lb1[1]);
		$('#produktindakankbsearch_tmpval').val(ui.item.id);
		$('#produktindakankbsearch_tmptext').val(lb[0]);
	}
});


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
		if($('#listtindakan_kb').getGridParam("records")>0){
			var rows= jQuery("#listtindakan_kb").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#tindakankb_final").val(JSON.stringify(paras));
		}
		
			if($('#listobatkb').getGridParam("records")>0){
			var rows= jQuery("#listobatkb").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obatkb_final").val(JSON.stringify(paras));
		}
		
		if($('#listalergikb').getGridParam("records")>0){
			var rows= jQuery("#listalergikb").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#alergikb_final").val(JSON.stringify(paras));
		}
			
		
	return true;
				
	}


</script>
<script>
	$('#backlistt_pelayanan_kb').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Check Kunjungan KB</div>
<div class="backbutton"><span class="kembali" id="backlistt_pelayanan_kb">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" id="form1t_pelayanan_kb_edit" action="<?=site_url('t_pelayanan_kb/editprocess')?>" enctype="multipart/form-data" >
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="text" readonly name="kdkunjungankb" id="kdkunjungankb" value="<?=$data->KD_KUNJUNGAN_KB?>" />
		<input type="hidden" readonly name="id" id="kdkunjungankb" value="<?=$data->KD_KUNJUNGAN_KB?>" />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_kunjungan_hidden" id="textid" value="<?=$data->ID_KUNJUNGAN?>" />
		<input type="hidden" name="kd_pelayanan_hidden" id="textid" value="<?=$data->KD_PELAYANAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text"  name="tanggal_daftar" id="tanggal_daftar" value="<?=$data->TANGGAL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis KB</label>
		<input type="text" readonly name="aa" id="aa" value="<?=$data->JENIS_KB?>" />
		<input type="hidden" name="kdjeniskb" id="kdjeniskb"  value="<?=$data->KD_JENIS_KB?>" readonly />
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
		<table id="listtindakan_kb"></table>
		<div id="pagert_tindakan_pelayanan_kb"></div>
		</div>
		<fieldset id="fieldstindakanrawatjalan">
		<span>
		<label class="declabel2">Cari Tindakan</label>
		<input type="text" name="text" value="" id="produktindakankbsearch" style="width:255px;" />
		</span>
		<span>
		<label class="declabel">Harga</label>
		<input type="text" name="hargatindakan" id="hargatindakankbid" style="width:101px" />
		</span>	
		<span>
		<label style="width:37px">Qty</label>
		<input type="text" name="kuantitastindakan" id="kuantitastindakankbid" style="width:39px" />
		<input type="hidden" name="produktindakankbsearch_tmpval" id="produktindakankbsearch_tmpval" />
		<input type="hidden" name="produktindakankbsearch_tmptext" id="produktindakankbsearch_tmptext" />		
		</span>
	</fieldset>
	<fieldset>
		<span>
			<label class="declabel2">Keterangan Tindakan</label>
			<input type="text" name="keterangantindakan" id="keterangantindakankbid" style="width:583px" />
			<input type="button" value="Tambah" id="tambahtindakankbid" />
			<input type="button" value="Hapus" id="hapustindakankbid" />
		</span>
	</fieldset>
	<br/>
		<div class="subformtitle">Alergi</div>
		<div class="paddinggrid">
		<table id="listalergikb"></table>
		<div id="pagert_alergi_pelayanan_kb"></div>
		</div>
		<fieldset id="fieldstindakanrawatjalanalergi">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatkbsearchalergikb" style="width:255px;" />
		<input type="hidden" name="obat_tmpval" id="obat_tmpvalalergi" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptextalergi" />
			<input type="button" value="Tambah" id="tambahobatalergikbid" />
			<input type="button" value="Hapus" id="hapusobatalergikbid" />
		</span>
	</fieldset>
	<br/>
		<div class="subformtitle">Obat</div>
		<div class="paddinggrid">
		<table id="listobatkb"></table>
		<div id="pagert_obat_pelayanan_kb"></div>
	</div>
	<table id="listobatkb"></table>
	<fieldset id="fieldstindakanrawatjalan">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatkbsearch" style="width:255px;" />
		</span>
		<span>
		<label style="width:77px">Aturan Pakai</label>
			<input type="text" name="hargatindakan" id="dosisobatkbid" style="width:55px" />
		</span>
		<?=getComboSatuan('','satuan_obat','satuanobatkbid','','inline')?>
		<span>
		<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitasobatkbid"  style="width:39px" />
			<input type="hidden" name="obat_tmpval" id="obat_tmpval" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptext" />
			<input type="hidden" name="hargaobattmpid" id="hargaobattmpid" />
			<input type="hidden" name="obat_tmptextnostock" id="obat_tmptextnostock" />
			<input type="button" value="Tambah" id="tambahobatkbid" />
			<input type="button" value="Hapus" id="hapusobatkbid" />
			
			<input type="hidden" name="diagnosa_final" id="diagnosa_final" />
			<input type="hidden" name="obatkb_final" id="obatkb_final" />
			<input type="hidden" name="alergikb_final" id="alergikb_final" />
			<input type="hidden" name="tindakankb_final" id="tindakankb_final" />
			
		</span>		
	</fieldset>
	<br/>
	<fieldset>
		<?=getComboDokterPemeriksa($data->PEMERIKSA,'pemeriksa','pemeriksa','required','inline')?>
	</fieldset>
	<fieldset>
		<?=getComboDokterPetugas($data->PETUGAS,'petugas','petugas','required','inline')?>
	</fieldset>
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