
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
				$('#listdiagnosarawatinap').setGridParam({postData:{'myid1':id1}})
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
				$('#listtindakanrawatinap').setGridParam({postData:{'myid2':id2}})
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
				$('#listalergirawatinap').setGridParam({postData:{'myid3':id3}})
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
				$('#listobatrawatinap').setGridParam({postData:{'myid4':id4}})
			}			
	}).navGrid('#pagert_obatrawatinap',{search:false});
	
	var diagnosatid = 0;
		$('#tambahdiagnosaid').click(function(){
			if($('#icdsearch_tmpval').val()){
				var myfirstrow = {kd_penyakit:$('#icdsearch_tmpval').val(), penyakit:$('#icdsearch_tmptext').val(), jenis_kasus:$('#selectjeniskasusid').val(), jenis_diagnosa:$('#selectjenisdiagnosaid').val()};
				jQuery("#listdiagnosarawatinap").addRowData(diagnosatid+1, myfirstrow);
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
		
	var tindakanid = 0;
		$('#tambahtindakanid').click(function(){
			if($('#produktindakansearch_tmpval').val()){
				var myfirstrow = {kd_tindakan:$('#produktindakansearch_tmpval').val(), tindakan:$('#produktindakansearch_tmptext').val(), harga:$('#hargatindakanid').val(), jumlah:$('#kuantitastindakanid').val(), keterangan:$('#keterangantindakanid').val()};
				jQuery("#listtindakanrawatinap").addRowData(tindakanid+1, myfirstrow);
				$('#produktindakansearch').val('');
				$('#keterangantindakanid').val('');
				$('#hargatindakanid').val('');
				$('#kuantitastindakanid').val('');
				$('#produktindakansearch_tmptext').val('');
				$('#produktindakansearch_tmpval').val('');
				if(confirm('Tambah Data Diagnosa Lain?')){
					$('#produktindakansearch').focus();					
				}else{
					$('#alergiobatselectid').focus();
					$('#alergiobatselectid').css('outline-color', 'yellow');
					$('#alergiobatselectid').css('outline-style', 'solid');
					$('#alergiobatselectid').css('outline-width', 'thick');
				}
			}else{
				alert('Silahkan Pilih Tindakan.');
			}
		})
	
	$('#alergiobatselectid').change(function(){
			var c = this.checked ?'checked':'unchecked';
			if(c=='checked'){
				$('#showhidealergitable').show();
				$('#obatsearchalergi').focus();
			}else{
				$('#showhidealergitable').hide();
				jQuery("#listalergirawatinap").clearGridData();
			}
		})

	var obatalergiid = 0;
		$('#tambahobatalergiid').click(function(){
			if($('#obat_tmpvalalergi').val()){
				var myfirstrow = {kd_obat:$('#obat_tmpvalalergi').val(), obat:$('#obat_tmptextalergi').val()};
				jQuery("#listalergirawatinap").addRowData(obatalergiid+1, myfirstrow);
				$('#obatsearchalergi').val('');
				$('#obat_tmptextalergi').val('');
				$('#obat_tmpvalalergi').val('');
				if(confirm('Tambah Data Alergi Obat Lain?')){
					$('#obatsearchalergi').focus();					
				}else{
					$('#obatsearch').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})
		
	var obatid = 0;
		$('#tambahobatid').click(function(){
			if($('#obat_tmpval').val()){
				var myfirstrow = {kd_obat:$('#obat_tmpval').val(), obat:$('#obat_tmptext').val(), dosis:$('#dosisobatid').val(), jumlah:$('#kuantitasobatid').val(), satuan:$('#satuanobatid').val(), harga:$('#hargaobattmpid').val()};
				jQuery("#listobatrawatinap").addRowData(obatid+1, myfirstrow);
				$('#obatsearch').val('');
				$('#dosisobatid').val('');
				$('#kuantitasobatid').val('');
				$('#satuan_obatid').val('');
				$('#kuantitasobatid').val('');
				$('#obat_tmptext').val('');
				$('#obat_tmpval').val('');
				$('#hargaobattmpid').val('');
				if(confirm('Tambah Obat Lain?')){
					$('#obatsearch').focus();					
				}else{
					$('#statuskeluarid').focus();
				}
			}else{
				alert('Silahkan Pilih Obat.');
			}
		})
		
	$('#hapusdiagnosaid').click(function(){
		jQuery("#listdiagnosarawatinap").clearGridData();
	})
	
	$('#hapustindakanid').click(function(){
		jQuery("#listtindakanrawatinap").clearGridData();
	})
	
	$('#hapusobatalergiid').click(function(){
		jQuery("#listalergirawatinap").clearGridData();
	})
	
	$('#hapusobatid').click(function(){
		jQuery("#listobatrawatinap").clearGridData();
	})
});

$("#carabayart_pelayananaddrj").chained("#jenis_pasient_pelayananaddrj");
$("#form1t_pelayananpelayanan").validate({focusInvalid:true});

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

$('#form1t_pelayananpelayanan :submit').click(function(e) {
	e.preventDefault();
	if($("#form1t_pelayananpelayanan").valid()) {
		if(kumpularray())$('#form1t_pelayananpelayanan').submit();
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

$( "#obatsearchalergi" ).catcomplete({
	source: "t_pelayanan/obatsource_alergi",
	minLength: 2,
	select: function( event, ui ) {
		$('#obat_tmpvalalergi').val(ui.item.id);
		$('#obat_tmptextalergi').val(ui.item.label);
	}
});

$( "#obatsearch" ).catcomplete({
	source: "t_pelayanan/obatsource",
	minLength: 2,
	select: function( event, ui ) {
		var lb = ui.item.label.split("=>");
		var lb1 = lb[1].split(':');
		var lb2 = lb[2].split(':');
		if(parseInt(lb1[1])<1){alert('Maaf Stok Obat Kosong, Silahkan Pilih Obat Lain');$( "#obatsearch" ).val('');$( "#obat_tmptextnostock" ).val('no');return false;}
		$('#hargaobattmpid').val(lb2[1]);
		$('#obat_tmpval').val(ui.item.id);
		$('#obat_tmptext').val(lb[0]);
	}
});

var searchdataproduk = <?=$dataproduktindakan?>;
$( "#produktindakansearch" ).catcomplete({
	delay: 0,
	source: searchdataproduk,
	select: function( event, ui ) {
		var lb = ui.item.label.split("=>");
		var lb1 = lb[1].split(':');
		$('#hargatindakanid').val(lb1[1]);
		$('#produktindakansearch_tmpval').val(ui.item.id);
		$('#produktindakansearch_tmptext').val(lb[0]);
	}
});

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		if(nextIndex < n && $(this).valid()){
			if($(this).attr('id')=='selectjenisdiagnosaid'){
				if($('#icdsearch_tmpval').val()){
					$('#tambahdiagnosaid').focus();return false;
				}else{
					$('#produktindakansearch').focus();
				}
			}
			if($(this).attr('id')=='keterangantindakanid'){
				if($('#produktindakansearch_tmpval').val()){
					$('#tambahtindakanid').focus();return false;
				}else{
					$('#alergiobatselectid').focus();
					$('#alergiobatselectid').css('outline-color', 'yellow');
					$('#alergiobatselectid').css('outline-style', 'solid');
					$('#alergiobatselectid').css('outline-width', 'thick');
				}				
			}
			if($(this).attr('id')=='kuantitasobatid'){				
				if($('#obat_tmpval').val()){
					$('#tambahobatid').focus();return false;
				}else{
					$('#statuskeluarid').focus();
				}
			}
			if($(this).attr('id')=='obatsearchalergi'){				
				if($('#obat_tmpvalalergi').val()){
					$('#tambahobatalergiid').focus();return false;
				}else{
					$('#obatsearch').focus();
				}
			}
			
			if($(this).attr('id')=='obatsearch'){
				if($('#obat_tmptextnostock').val()=='no'){$( "#obat_tmptextnostock" ).val('');$( "#obatsearch" ).focus();return false;}
			}
			
			if($(this).attr('id')=='alergiobatselectid'){
				$( "#obatsearch" ).focus();
				$('#alergiobatselectid').css('outline-color', 'white');
			}
			
			$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
		}else{			
			if($("#form1t_pelayananpelayanan").valid()) {
				//$(':text,:radio,:checkbox,select,textarea')[nextIndex-1].blur();
				if(kumpularray())$('#form1t_pelayananpelayanan').submit();
			}
			return false;
		}
   }
});
</script>

<script>
	//$('#tglt_pelayanan').datepicker({dateFormat: "yy-mm-dd",changeYear: true,yearRange: "-100:+0"});
	function kumpularray(){
		if($('#listdiagnosarawatinap').getGridParam("records")>0){
			var rows= jQuery("#listdiagnosarawatinap").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
				//paras.push($.param(row));
			}
			$("#diagnosa_final").val(JSON.stringify(paras));
		}
		
		if($('#listtindakanrawatinap').getGridParam("records")>0){
			var rows= jQuery("#listtindakanrawatinap").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#tindakan_final").val(JSON.stringify(paras));
		}
		
		if($('#listalergirawatinap').getGridParam("records")>0){
			var rows= jQuery("#listalergirawatinap").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#alergi_final").val(JSON.stringify(paras));
		}
		
		if($('#listobatrawatinap').getGridParam("records")>0){
			var rows= jQuery("#listobatrawatinap").jqGrid('getRowData');
			var paras=new Array();
			for(var i=0;i<rows.length;i++){
				var row = rows[i];
				paras.push(JSON.stringify(row));
			}
			$("#obat_final").val(JSON.stringify(paras));
		}
		return true;
				
	}
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
<div class="subformtitle">Check Rawat Inap</div>
<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Tanggal Pelayanan</label>
		<input type="text" disabled name="text" value="<?=$data->TGL_PELAYANAN?>"/>
		</span>	
	</fieldset>
	<fieldset>
		<span>
		<label>Unit Pelayanan</label>
		<input type="text" disabled name="text" value="<?=$data->UNIT?>" />
		</span>	
	</fieldset>
	<?=getComboJenispasien('','jenis_pasien','jenis_pasient_pelayananaddrj','','')?>
	<?=getComboCarabayar('','cara_bayar','carabayart_pelayananaddrj','','')?>
	<fieldset>		
		<span>
			<label>Anamnesa</label>
			<textarea name="anamnesa" id="anamnesa" rows="2" cols="23" ><?=$data->ANAMNESA?></textarea>
		</span>	
	</fieldset>
	<fieldset>	
		<span>
			<label>Catatan Fisik</label>
			<textarea name="catatan_fisik" rows="2" cols="23" ><?=$data->CATATAN_FISIK?></textarea>
		</span>	
	</fieldset>
	<fieldset>		
		<span>
			<label>Catatan Dokter</label>
			<textarea name="catatan_dokter" rows="2" cols="23" ><?=$data->CATATAN_DOKTER?></textarea>
		</span>			
	</fieldset>	
	
	<div class="subformtitle">Diagnosa</div>
	<div class="paddinggrid">
	<table id="listdiagnosarawatinap"></table>
	<div id="pagert_diagnosarawatinap"></div>
	</div>
	<fieldset id="fieldsdiagnosarawatinap">
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
	<table id="listtindakanrawatinap"></table>
	<div id="pagert_tindakanrawatinap"></div>
	</div>
	<fieldset id="fieldstindakanrawatinap">
		<span>
		<label class="declabel2">Cari Tindakan</label>
		<input type="text" name="text" value="" id="produktindakansearch" style="width:255px;" />
		</span>
		<span>
		<label class="declabel">Harga</label>
		<input type="text" name="hargatindakan" id="hargatindakanid" style="width:101px" />
		</span>	
		<span>
		<label style="width:37px">Qty</label>
		<input type="text" name="kuantitastindakan" id="kuantitastindakanid" style="width:39px" />
		<input type="hidden" name="produktindakansearch_tmpval" id="produktindakansearch_tmpval" />
		<input type="hidden" name="produktindakansearch_tmptext" id="produktindakansearch_tmptext" />		
		</span>
	</fieldset>
	<fieldset>
		<span>
			<label class="declabel2">Keterangan Tindakan</label>
			<input type="text" name="keterangantindakan" id="keterangantindakanid" style="width:583px" />
			<input type="button" value="Tambah" id="tambahtindakanid" />
			<input type="button" value="Hapus" id="hapustindakanid" />
		</span>
	</fieldset>

	<div class="subformtitle">Alergi Obat</div>
	<div class="paddinggrid">
	<table id="listalergirawatinap"></table>
	<div id="pagert_alergirawatinap"></div>
	</div>
	<fieldset id="fieldstindakanrawatinapalergi">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearchalergi" style="width:255px;" />
		<input type="hidden" name="obat_tmpval" id="obat_tmpvalalergi" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptextalergi" />
			<input type="button" value="Tambah" id="tambahobatalergiid" />
			<input type="button" value="Hapus" id="hapusobatalergiid" />
		</span>
	</fieldset>
	
	<div class="subformtitle">Obat</div>
	<div class="paddinggrid">
	<table id="listobatrawatinap"></table>
	<div id="pagert_obatrawatinap"></div>
	</div>
	<fieldset id="fieldstindakanrawatinap">
		<span>
		<label class="declabel2">Cari Obat</label>
		<input type="text" name="text" value="" id="obatsearch" style="width:255px;" />
		</span>
		<span>
		<label style="width:77px">Aturan Pakai</label>
			<input type="text" name="dosis" id="dosisobatid" style="width:55px" />
		</span>
		<?=getComboSatuan('','satuan_obat','satuanobatid','','inline')?>
		<span>
		<label style="width:37px">Qty</label>
			<input type="text" name="kuantitastindakan" id="kuantitasobatid"  style="width:39px" />
			<input type="hidden" name="obat_tmpval" id="obat_tmpval" />
			<input type="hidden" name="obat_tmptext" id="obat_tmptext" />
			<input type="hidden" name="hargaobattmpid" id="hargaobattmpid" />
			<input type="hidden" name="obat_tmptextnostock" id="obat_tmptextnostock" />
			<input type="button" value="Tambah" id="tambahobatid" />
			<input type="button" value="Hapus" id="hapusobatid" />
			
			<input type="hidden" name="diagnosa_final" id="diagnosa_final" />
			<input type="hidden" name="tindakan_final" id="tindakan_final" />
			<input type="hidden" name="alergi_final" id="alergi_final" />
			<input type="hidden" name="obat_final" id="obat_final" />
		</span>		
	</fieldset>
	<br/>
	<?=getComboStatuskeluar($data->KEADAAN_KELUAR,'status_keluar','statuskeluarid','','')?>
	<br/>
	<div class="subformtitle">Keterangan</div>
	<fieldset>
		<span>
		<label>Catatan Apotek (Untuk Dokter)</label>
		<textarea name="catatan_apotek" rows="2" cols="23" ></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Catatan Dokter (Untuk Apotek)</label>
		<textarea name="catatan_dokter" rows="2" cols="23" ></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >